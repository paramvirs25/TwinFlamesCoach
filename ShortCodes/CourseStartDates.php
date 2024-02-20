<?php
class Course
{
    public $course_name;
    public $start_date;
    public $start_time;
    public $weeks_before_next_batch;
    public $start_date_time;

    /**
     * @param array $data Associative array with course data.
     */
    public function __construct($data)
    {
        $this->course_name = $data['name'];
        $this->start_date = $data['start_date'];
        $this->start_time = $data['start_time'];
        $this->weeks_before_next_batch = $data['weeks_before_next_batch'];
        $this->start_date_time = DateTime::createFromFormat('d/m/Y g:i A', $this->start_date . ' ' . $this->start_time);

        // Calculate the start date during object construction
        $this->start_date_time = $this->calculateStartDateTime();
        //echo $this->start_date_time->format('d/m/Y g:i A') . ' <br>';
    }

    /**
     * @return DateTime|null Returns a DateTime object if a valid start date is calculated, or null if the start date is blank.
     */
    public function calculateStartDateTime(): ?DateTime
    {
        // Check if start_date is blank
        if (empty($this->start_date)) {
            return null;
        }

        // Get current date and time
        $current_date_time = new DateTime();

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
}

class CourseDatesTfc
{
    /**
     * Get courses data from the JSON file.
     */
    private static function getCoursesData()
    {
        $json_file = 'https://paramvirs25.github.io/TwinFlamesCoach/Json/course_dates.json'; // Update this path

        // Use a more robust method (e.g., cURL) for HTTP requests to handle errors more effectively
        $json_content = @file_get_contents($json_file);

        if ($json_content === false) {
            // Handle the error (e.g., log, display an error message)
            return null;
        }

        // Decode the JSON content with error handling
        $json_data = json_decode($json_content, true);

        if ($json_data === null && json_last_error() !== JSON_ERROR_NONE) {
            // Handle the JSON decoding error (e.g., log, display an error message)
            return null;
        }

        return $json_data;
    }


    /**
     * Get courses array from JSON data.
     */
    public static function getCoursesArray()
    {
        $courses_data = self::getCoursesData();

        return isset($courses_data['courses']) ? $courses_data['courses'] : [];
    }

    public static function getAllCourses()
    {
        $courses = self::getCoursesArray();
        $course_objects = [];

        foreach ($courses as $course_data) {
            $course_objects[] = new Course($course_data);
        }

        return $course_objects;
    }

    /**
     *  @return string similar to "November 2023 7:00 PM IST" or 'To be Announced Soon'
     */
    public static function formatDateTime(Course $course)
    {
        $current_date_time = new DateTime();

        //if start date is in future
        if (isset($course->start_date_time) && ($course->start_date_time >= $current_date_time)) {
            return $course->start_date_time->format('j F Y g:i A') . ' IST';
        } else {
            return 'To be Announced Soon';
        }
    }    

    public static function getSortedCoursesByDates()
    {
        $all_start_dates = self::getAllCourses();

        $current_timestamp = time();

        usort($all_start_dates, function ($a, $b) use ($current_timestamp) {
            $a_start = $a->start_date_time->getTimestamp();
            $b_start = $b->start_date_time->getTimestamp();

            // Check if start_date_time is in the past
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
}

function upcoming_course_start_date_shortcode($atts)
{
    // Extract shortcode attributes
    $attributes = shortcode_atts(array(
        'course_name' => '',
    ), $atts);

    $course = null;
    $formatted_date = '';

    // Get courses array from JSON data
    $courses_array = CourseDatesTfc::getCoursesArray();

    // Find the corresponding course by name
    $selected_course = null;
    foreach ($courses_array as $course_data) {
        if ($course_data['short_name'] === $attributes['course_name']) {
            $selected_course = new Course($course_data);
            break;
        }
    }

    $course = $selected_course;

    // format date
    if (isset($course)) {
        $formatted_date = CourseDatesTfc::formatDateTime($course);
    }

    return $formatted_date;
}
add_shortcode('upcoming_course_start_date', 'upcoming_course_start_date_shortcode');

// Shortcode function to return all course dates
function all_course_start_dates_shortcode()
{
    // Get all course start dates
    $courses = CourseDatesTfc::getSortedCoursesByDates();

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
        $output .= '<td>' . CourseDatesTfc::formatDateTime($course) . '</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';

    // Return the formatted output
    return $output;
}

// Add the shortcode
add_shortcode('all_course_start_dates', 'all_course_start_dates_shortcode');
