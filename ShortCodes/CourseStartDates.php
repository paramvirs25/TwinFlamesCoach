<?php
namespace TFC;

use \TFC\JsonUtilities as JsonUtil;
use \TFC\Configuration as Config;

class CourseDates
{
    public $course_name;
    public $start_date;
    public $start_time;
    public $weeks_before_next_batch;
    public $total_number_of_classes;

    public $start_date_time;
    public $final_starting_date_time;

    public static $date_format = 'Y-m-d';
    //public static $output_date_format = 'j F Y';
    //public static $output_time_format = 'g:i A';
    public static $output_date_time_format = 'l j F Y g:i A';

    /**
     * @param array $data Associative array with course data.
     */
    public function __construct($data)
    {
        $this->course_name = $data['name'];
        $this->start_date = $data['start_date'];
        $this->start_time = $data['start_time'];
        $this->weeks_before_next_batch = $data['weeks_before_next_batch'];
        $this->total_number_of_classes = $data['total_number_of_classes'];

        $this->start_date_time = \DateTime::createFromFormat('d/m/Y g:i A', $this->start_date . ' ' . $this->start_time);

        // Calculate the start date during object construction
        $this->final_starting_date_time = $this->calculateFinalStartDateTime();
        //echo $this->final_starting_date_time->format('d/m/Y g:i A') . ' <br>';
    }

    /**
     * @return DateTime|null Returns a DateTime object if a valid start date is calculated, or null if the start date is blank.
     */
    public function calculateFinalStartDateTime(): ?\DateTime
    {
        // Check if start_date is blank
        if (empty($this->start_date)) {
            return null;
        }

        // Get current date and time
        $current_date_time = new \DateTime();

        // start date is greater than current date
        if ($this->start_date_time > $current_date_time) {
            $final_date_time = $this->start_date_time;
        } else { //start date is in past
            $next_start_date_time = clone $this->start_date_time;
            $next_start_date_time->modify('+' . $this->weeks_before_next_batch . ' weeks');
            $final_date_time = $next_start_date_time;
        }

        return $final_date_time;
    }

    /**
     * Get courses array from JSON data.
     */
    public static function getCoursesArray()
    {
        $courses_data = JsonUtil::getJsonData(Config::$courses_dates_json_path);

        return isset($courses_data['courses']) ? $courses_data['courses'] : [];
    }

    public static function getAllCourses()
    {
        $courses = self::getCoursesArray();
        $course_objects = [];

        foreach ($courses as $course_data) {
            $course_objects[] = new CourseDates($course_data);
        }

        return $course_objects;
    }  

    /**
     * Retrieves a course object by its name.
     *
     * This method searches for a course with the specified name
     * within the course data stored in JSON format. If a course
     * with the specified name is found, it creates a CourseDates
     * object representing that course and returns it. If no
     * matching course is found, null is returned.
     *
     * @param string $course_name The name of the course to retrieve.
     * @return \TFC\CourseDates|null The CourseDates object representing
     *                               the course, or null if no course
     *                               with the specified name is found.
     */
    public static function getCourseByName($course_name){
        // Get courses array from JSON data
        $courses_array = \TFC\CourseDates::getCoursesArray();

        // Find the corresponding course by name
        $selected_course = null;
        foreach ($courses_array as $course_data) {
            if ($course_data['short_name'] === $course_name) {
                $selected_course = new \TFC\CourseDates($course_data);
                break;
            }
        }

        return $selected_course;
    }      

    /**
     * Retrieves the class dates for ongoing courses.
     *
     * This method checks each course to determine if it has already started.
     * A course is considered to have started if its start date is in the past
     * and the number of weeks passed since the start date is less than the
     * total number of classes. If a course has started, it calculates and
     * returns the dates for all upcoming classes.
     *
     * @return array An array containing the class dates for ongoing courses.
     */
    public static function getOnGoingCoursesClassesDates(){
        $ongoing_classes = [];

        // Get all courses
        $courses = self::getAllCourses();
        
        // Get the current date and time
        $current_date_time = new \DateTime();

        // Iterate through each course
        foreach ($courses as $course) {
            // Check if the course has already started
            if ($course->start_date_time < $current_date_time) {
                // Calculate the number of weeks passed since the start date
                $diff = $current_date_time->diff($course->start_date_time);
                $weeks_passed = floor($diff->days / 7);

                // Check if the number of weeks passed is less than the total number of classes
                if ($weeks_passed < $course->total_number_of_classes) {
                    // Calculate the class dates for the ongoing course
                    $class_dates = [];
                    $class_date = clone $course->start_date_time;

                    for ($i = 0; $i < $course->total_number_of_classes; $i++) {
                        $class_dates[] = $class_date->format(self::$date_format);
                        $class_date->modify('+1 week');
                    }

                    // Add the course name and class dates to the result array
                    $ongoing_classes[$course->course_name] = $class_dates;
                }
            }
        }

        return $ongoing_classes;
    }


    public static function getSortedCoursesByDates()
    {
        $all_start_dates = self::getAllCourses();

        $current_timestamp = time();

        usort($all_start_dates, function ($a, $b) use ($current_timestamp) {
            $a_start = $a->final_starting_date_time->getTimestamp();
            $b_start = $b->final_starting_date_time->getTimestamp();

            // Check if final_starting_date_time is in the past
            $a_is_past = $a_start < $current_timestamp;
            $b_is_past = $b_start < $current_timestamp;

            // If both are in the past or both are in the future, compare normally
            if ($a_is_past == $b_is_past) {
                return $a_start - $b_start;
            }

            // If $a is in the past, move it to the end
            return $a_is_past ? 1 : -1;
        });

        return $all_start_dates;
    }

    /**
     *  @return string similar to "November 2023 7:00 PM IST" or 'To be Announced Soon'
     */
    public static function formatCourseDateTime(CourseDates $course){
        $current_date_time = new \DateTime();

        //if start date is in future
        if (isset($course->final_starting_date_time) && ($course->final_starting_date_time >= $current_date_time)) {
            //return $course->final_starting_date_time->format(self::$output_date_format . ' g:i A') . ' IST';
            return self::formatDateTime($course->final_starting_date_time);
        } else {
            return 'To be Announced Soon';
        }
    }

    public static function formatDateTime($date_time_to_format){
        return $date_time_to_format->format(self::$output_date_time_format) . ' IST';
    }

    /**
     * Generates an HTML table from the ongoing classes data.
     *
     * @param array $ongoing_classes An array containing the class dates for ongoing courses.
     * @return string HTML representation of the ongoing classes table.
     */
    public static function generateOngoingClassesTable($ongoing_classes) {
        // Initialize an empty string to store the HTML table
        $html_table = '';
        $html_table .= '<table border="1">';
        $html_table .= '<thead><tr><th>Course Name</th><th>Class Dates</th></tr></thead>';
        $html_table .= '<tbody>';

        // Get the current date
        $current_date = date(self::$date_format);
        

        // Iterate through each course in the ongoing classes array
        foreach ($ongoing_classes as $course_name => $class_dates) {
            // Start a new table row for each course
            $html_table .= '<tr>';
            // Add the course name in the first column
            $html_table .= '<td>' . $course_name . '</td>';
            // Start a new table cell for class dates in the second column
            $html_table .= '<td>';
            // Iterate through each class date and add it to the cell
            foreach ($class_dates as $class_date) {
                // Check if the class date is less than today
                if ($class_date < $current_date) {
                    // Format as strikethrough
                    $html_table .= '<del>' . $class_date . '</del><br>';
                } else {
                    // Regular formatting
                    $html_table .= '<span style="color:green;">' . $class_date . '</span>' . '<br>';
                }
            }
            // Close the table cell for class dates
            $html_table .= '</td>';
            // Close the table row for the current course
            $html_table .= '</tr>';
        }

        // Close the table body and table
        $html_table .= '</tbody></table>';

        // Return the generated HTML table
        return $html_table;
    }

}


add_shortcode('upcoming_course_start_date', function ($atts) {
    // Extract shortcode attributes
    $attributes = shortcode_atts(array(
        'course_name' => '',
    ), $atts);

    $course = null;
    $formatted_date = '';

    $course = \TFC\CourseDates::getCourseByName($attributes['course_name']);

    // format date
    if (isset($course)) {
        $formatted_date = \TFC\CourseDates::formatCourseDateTime($course);
    }

    return $formatted_date;
});

// Add the shortcode
add_shortcode('all_course_start_dates', function () {
    // Get all course start dates
    $courses = \TFC\CourseDates::getSortedCoursesByDates();

    // Initialize an empty string to store the output
    $output = '';

    // Initialize an empty string to store the output
    $output = '<table border="1">';
    $output .= '<thead style="font-weigth:bold;"><tr><th>Course Name</th><th>Start Date</th></tr></thead>';
    $output .= '<tbody>';

    // Loop through each course and format the output as a table row
    foreach ($courses as $course) {
        $output .= '<tr>';
        $output .= '<td>' . $course->course_name . '</td>';
        $output .= '<td>' . \TFC\CourseDates::formatCourseDateTime($course) . '</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';

    // Return the formatted output
    return $output;
});

add_shortcode('all_ongoing_courses_classes_dates', function () {
    // Get ongoing classes dates
    $ongoing_classes = \TFC\CourseDates::getOnGoingCoursesClassesDates();

    // Generate HTML table from ongoing classes data
    $html_table = \TFC\CourseDates::generateOngoingClassesTable($ongoing_classes);

    return $html_table;
});
