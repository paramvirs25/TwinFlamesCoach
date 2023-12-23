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

        // Parse input date and time
        $current_date = new DateTime();

        // Calculate next batch start date based on conditions
        if ($this->start_date_time > $current_date) {
            $final_date_time = $this->start_date_time;
        } else {
            $next_start_date = clone $this->start_date_time;
            $next_start_date->modify('+' . $this->weeks_before_next_batch . ' weeks');
            $final_date_time = $next_start_date;
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
        if (isset($course->start_date_time)) {
            return $course->start_date_time->format('j F Y g:i A') . ' IST';
        } else {
            return 'To be Announced Soon';
        }
    }

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

        // Sort the array based on 'start_date'
        // usort($all_start_dates, function ($a, $b) {
        //     $a_start = DateTime::createFromFormat('d/m/Y', $a->start_date_time)->getTimestamp();
        //     $b_start = DateTime::createFromFormat('d/m/Y', $b->start_date_time)->getTimestamp();
        //     return $a_start - $b_start;
        // });

        usort($all_start_dates, function ($a, $b) {
            $a_start = $a->start_date_time->getTimestamp();
            $b_start = $b->start_date_time->getTimestamp();
            return $a_start - $b_start;
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
            '30/10/2023',
            '08:00 PM',
            12
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

    $formatted_date = '';

    // Use a switch statement to determine which course method to call
    switch ($attributes['course_name']) {
        case 'lifecoach':
            $start_date_info = CourseDatesTfc::lifeCoachStartDate();
            break;
        case 'chb': //Chakra healing & balancing
            $start_date_info = CourseDatesTfc::chakraHealingStartDate();
            break;
        case 'biw2': //basic IW 2
            $start_date_info = CourseDatesTfc::basicInnerWork2StartDate();
            break;
        case 'advtfh1': //Adv TF HEalings 1
            $start_date_info = CourseDatesTfc::advTFHealing1StartDate();
            break;
        case 'ybtf': // Yogasth Bhav
            $start_date_info = CourseDatesTfc::yogasthBhavTFStartDate();
            break;
        case 'mwtf': //Mirror Work
            $start_date_info = CourseDatesTfc::mirrorWorkTFStartDate();
            break;
        default:
            // Handle the case where course_name doesn't match any known courses
            $start_date_info = null;
            break;
    }

    // Call calculateStartDate method using the extracted start_date_info
    if (isset($start_date_info)) {
        $formatted_date = CourseDatesTfc::formatDateTime($start_date_info);
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

    // Loop through each course and format the output
    foreach ($courses as $course) {
        $output .= '<p>';
        $output .= $course->course_name . '<br>';
        $output .= 'Start Date and Time: ' . CourseDatesTfc::formatDateTime($course) . '<br>';
        $output .= '</p>';
    }

    // Return the formatted output
    return $output;
}

// Add the shortcode
add_shortcode('all_course_start_dates', 'all_course_start_dates_shortcode');
