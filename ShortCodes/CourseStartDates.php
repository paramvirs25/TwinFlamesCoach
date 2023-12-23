<?php
class Course
{
    public $course_name;
    public $start_date;
    public $start_time;
    public $weeks_before_next_batch;

    public function __construct($name, $start_date, $start_time, $weeks_before_next_batch)
    {
        $this->course_name = $name;
        $this->start_date = $start_date;
        $this->start_time = $start_time;
        $this->weeks_before_next_batch = $weeks_before_next_batch;
    }
}

class CourseDatesTfc
{
    /**
     *  @return string similar to "November 2023 7:00 PM IST" or 'To be Announced Soon'
     */
    public static function formatDateTime($date_time)
    {
        if (isset($date_time)) {
            return $date_time->format('j F Y g:i A') . ' IST';
        } else {
            return 'To be Announced Soon';
        }
    }

    /**
     * @param Course $course
     * @return DateTime|null Returns a DateTime object if a valid start date is calculated, or null if the start date is blank.
     */
    public static function calculateStartDate(Course $course): ?DateTime
    {
        // Check if start_date is blank
        if (empty($course->start_date)) {
            return null;
        }

        // Parse input date and time
        $start_date_time = DateTime::createFromFormat('d/m/Y g:i A', $course->start_date . ' ' . $course->start_time);
        $current_date = new DateTime();

        // Calculate next batch start date based on conditions
        if ($start_date_time > $current_date) {
            $final_date_time = $start_date_time;
        } else {
            $next_start_date = clone $start_date_time;
            $next_start_date->modify('+' . $course->weeks_before_next_batch . ' weeks');
            $final_date_time = $next_start_date;
        }

        return $final_date_time;
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

        // Update the 'start_date' in each item in the array using calculateStartDate
        foreach ($all_start_dates as &$course) {
            $calculated_start_date = self::calculateStartDate($course);
            $course->start_date = $calculated_start_date->format('d/m/Y');
        }

        // Sort the array based on 'start_date'
        usort($all_start_dates, function ($a, $b) {
            $a_start = DateTime::createFromFormat('d/m/Y', $a->start_date)->getTimestamp();
            $b_start = DateTime::createFromFormat('d/m/Y', $b->start_date)->getTimestamp();
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

    // ... rest of the code ...
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
        $formatted_date = CourseDatesTfc::formatDateTime(CourseDatesTfc::calculateStartDate($start_date_info));
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
        $output .= 'Start Date and Time: ' . CourseDatesTfc::formatDateTime(CourseDatesTfc::calculateStartDate($course)) . '<br>';
        $output .= '</p>';
    }

    // Return the formatted output
    return $output;
}

// Add the shortcode
add_shortcode('all_course_start_dates', 'all_course_start_dates_shortcode');
