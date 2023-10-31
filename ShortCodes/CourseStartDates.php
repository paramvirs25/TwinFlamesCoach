<?php
class CourseDatesTfc
{
    public static function formatDateTime($date_time){
        if (isset($date_time)) {
            return $date_time->format('F Y g:i A') . ' IST';
        } else {
            return 'To be Announced Soon';
        }
    }
    /**
     *
     * @param [string] $start_date 
     * Format dd/mm/yyyy
     * @param [string] $start_time 
     * Format hh:mm AM/PM
     * @param [int] $weeks_before_next_batch
     * @return string
     * returns optput similar to November 2023 7:00 PM IST
     */
    public static function calculateStartDate($start_date, $start_time, $weeks_before_next_batch): ?DateTime
    {
        // Check if start_date is blank
        if (empty($start_date)) {
            return null;
        }

        // Parse input date and time
        $start_date_time = DateTime::createFromFormat('d/m/Y g:i A', $start_date . ' ' . $start_time);
        $current_date = new DateTime();

        // Calculate next batch start date based on conditions
        if ($start_date_time > $current_date) {
            $formatted_date = $start_date_time;
            //$start_date_time->format('j F Y g:i A') . ' IST';
        } else {
            $next_start_date = clone $start_date_time;
            $next_start_date->modify('+' . $weeks_before_next_batch . ' weeks');
            $formatted_date = $next_start_date;
            //$next_start_date->format('F Y g:i A') . ' IST';
        }

        return $formatted_date;
    }

    public static function getAllCourseStartDates()
    {
        $all_start_dates = array(
            self::lifeCoachStartDate(),
            self::basicInnerWork2StartDate(),
            self::advTFHealing1StartDate(),
            self::yogasthBhavTFStartDate(),
            self::mirrorWorkTFStartDate()
        );

        // Update the 'start_date' in each item in the array using calculateStartDate
        foreach ($all_start_dates as &$course) {
            $calculated_start_date = self::calculateStartDate($course['start_date'], $course['start_time'], $course['weeks_before_next_batch']);
            $course['start_date'] = $calculated_start_date->format('d/m/Y');
        }

        // Sort the array based on 'start_date'
        usort($all_start_dates, function ($a, $b) {
            $a_start = DateTime::createFromFormat('d/m/Y', $a['start_date'])->getTimestamp();
            $b_start = DateTime::createFromFormat('d/m/Y', $b['start_date'])->getTimestamp();
            return $a_start - $b_start;
        });

        return $all_start_dates;
    }

    public static function lifeCoachStartDate()
    {
        return array(
            'course_name' => 'Life Coach',
            'start_date' => '18/01/2023',
            'start_time' => '07:30 PM',
            'weeks_before_next_batch' => 52
        );
    }

    public static function basicInnerWork2StartDate()
    {
        return array(
            'course_name' => 'Basic Inner Work 2',
            'start_date' => '29/10/2023',   //Last date - '23/04/2023'
            'start_time' => '07:00 PM',
            'weeks_before_next_batch' => 24
        );
    }

    public static function advTFHealing1StartDate()
    {
        return array(
            'course_name' => 'Advanced Twin Flame Healings 1',
            'start_date' => '5/08/2023',
            'start_time' => '08:00 PM',
            'weeks_before_next_batch' => 52
        );
    }

    public static function yogasthBhavTFStartDate()
    {
        return array(
            'course_name' => 'Yogasth Bhava Twin Flame Journey',
            'start_date' => '23/08/2023',
            'start_time' => '07:00 PM',
            'weeks_before_next_batch' => 12
        );
    }

    public static function mirrorWorkTFStartDate()
    {
        return array(
            'course_name' => 'Mirror Work for Twin Flames',
            'start_date' => '23/10/2023',   //Last date '11/09/2023'
            'start_time' => '07:00 PM',
            'weeks_before_next_batch' => 6
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
        $formatted_date = CourseDatesTfc::formatDateTime(
            CourseDatesTfc::calculateStartDate(
                $start_date_info['start_date'],
                $start_date_info['start_time'],
                $start_date_info['weeks_before_next_batch']
            )
        );
    }

    return $formatted_date;
}
add_shortcode('upcoming_course_start_date', 'upcoming_course_start_date_shortcode');

// Shortcode function to return all course dates
function all_course_start_dates_shortcode()
{
    // Get all course start dates
    $all_start_dates = CourseDatesTfc::getAllCourseStartDates();

    // Initialize an empty string to store the output
    $output = '';

    // Loop through each course and format the output
    foreach ($all_start_dates as $course) {
        $output .= '<p>';
        $output .= 'Course Name: ' . $course['course_name'] . '<br>';
        $output .= 'Start Date and Time: ' . CourseDatesTfc::formatDateTime(CourseDatesTfc::calculateStartDate($course['start_date'], $course['start_time'], $course['weeks_before_next_batch'])) . '<br>';
        $output .= '</p>';
    }

    // Return the formatted output
    return $output;
}

// Add the shortcode
add_shortcode('all_course_start_dates', 'all_course_start_dates_shortcode');
