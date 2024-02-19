<?php
class Course
{
    public $course_name;
    public $start_date;
    public $start_time;
    public $weeks_before_next_batch;
    public $start_date_time;

    public function __construct($name, $start_date, $start_time, $weeks_before_next_batch)
    {
        $this->course_name = $name;
        $this->start_date = $start_date;
        $this->start_time = $start_time;
        $this->weeks_before_next_batch = $weeks_before_next_batch;
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

    // public static function getSortedCoursesByDates()
    // {
    //     $all_start_dates = array(
    //         self::lifeCoachStartDate(),
    //         self::chakraHealingStartDate(),
    //         self::basicInnerWork2StartDate(),
    //         self::advTFHealing1StartDate(),
    //         self::yogasthBhavTFStartDate(),
    //         self::mirrorWorkTFStartDate()
    //     );

    //     usort($all_start_dates, function ($a, $b) {
    //         $a_start = $a->start_date_time->getTimestamp();
    //         $b_start = $b->start_date_time->getTimestamp();
    //         return $a_start - $b_start;
    //     });
        

    //     return $all_start_dates;
    // }

    public static function getSortedCoursesByDates()
{
    $all_start_dates = array(
        self::lifeCoachStartDate(),
        self::chakraHealingStartDate(),
        self::basicInnerWork2StartDate(),
        self::advTFHealing1StartDate(),
        self::yogasthBhavTFStartDate(),
        self::mirrorWorkTFStartDate()
    );

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


    public static function mirrorWorkTFStartDate()
    {
        return new Course(
            'Mirror Work for Twin Flames',
            '23/10/2023',
            '07:00 PM',
            6
        );
    }

    public static function chakraHealingStartDate()
    {
        return new Course(
            'Chakra Healing & Balancing',
            '25/02/2022',
            '08:00 PM',
            16
        );
    }

    public static function basicInnerWork2StartDate()
    {
        return new Course(
            'Basic Inner Work 2',
            '29/10/2023',
            '07:00 PM',
            24
        );
    }

    public static function lifeCoachStartDate()
    {
        return new Course(
            'Life Coach',
            '06/01/2024',
            '07:30 PM',
            52
        );
    }

    public static function advTFHealing1StartDate()
    {
        return new Course(
            'Advanced Twin Flame Healings 1',
            '5/08/2023',
            '08:00 PM',
            52
        );
    }

    public static function yogasthBhavTFStartDate()
    {
        return new Course(
            'Yogasth Bhava Twin Flame Journey',
            '23/08/2023',
            '07:00 PM',
            12
        );
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

    // Use a switch statement to determine which course method to call
    switch ($attributes['course_name']) {
        case 'lifecoach':
            $course = CourseDatesTfc::lifeCoachStartDate();
            break;
        case 'chb': //Chakra healing & balancing
            $course = CourseDatesTfc::chakraHealingStartDate();
            break;
        case 'biw2': //basic IW 2
            $course = CourseDatesTfc::basicInnerWork2StartDate();
            break;
        case 'advtfh1': //Adv TF HEalings 1
            $course = CourseDatesTfc::advTFHealing1StartDate();
            break;
        case 'ybtf': // Yogasth Bhav
            $course = CourseDatesTfc::yogasthBhavTFStartDate();
            break;
        case 'mwtf': //Mirror Work
            $course = CourseDatesTfc::mirrorWorkTFStartDate();
            break;
        default:
            // Handle the case where course_name doesn't match any known courses
            $course = null;
            break;
    }

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
