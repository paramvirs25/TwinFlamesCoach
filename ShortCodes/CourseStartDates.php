<?php
// Add this code to your functions.php or a custom plugin file

class CourseDatesTfc {
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
    public static function courseStartDate($start_date, $start_time, $weeks_before_next_batch) {
        // Check if start_date is blank
        if (empty($start_date)) {
            return 'To be Announced Soon';
        }

        // Parse input date and time
        $start_date_time = DateTime::createFromFormat('d/m/Y g:i A', $start_date . ' ' . $start_time);
        $current_date = new DateTime();

        // Calculate next batch start date based on conditions
        if ($start_date_time > $current_date) {
            $formatted_date = $start_date_time->format('j F Y g:i A') . ' IST';
        } else {
            $next_start_date = clone $start_date_time;
            $next_start_date->modify('+' . $weeks_before_next_batch . ' weeks');
            $formatted_date = $next_start_date->format('F Y g:i A') . ' IST';
        }

        return $formatted_date;
    }

    public static function getAllCourseStartDates() {
        $life_coach_start_date = self::lifeCoachStartDate();
        $basic_inner_work2_start_date = self::basicInnerWork2StartDate();
        $adv_tf_healing1_start_date = self::advTFHealing1StartDate();

        $all_start_dates = array($life_coach_start_date, $basic_inner_work2_start_date, $adv_tf_healing1_start_date);

        usort($all_start_dates, function ($a, $b) {
            $a_start = DateTime::createFromFormat('d/m/Y', $a['start_date']);
            $b_start = DateTime::createFromFormat('d/m/Y', $b['start_date']);
            return $a_start <=> $b_start;
        });

        return $all_start_dates;
    }

    public static function lifeCoachStartDate() {
        return array(
            'course_name' => 'Life Coach',
            'start_date' => '18/01/2023',
            'start_time' => '07:30 PM',
            'weeks_before_next_batch' => 52
        );
    }

    public static function basicInnerWork2StartDate() {
        return array(
            'course_name' => 'Basic Inner Work 2',
            'start_date' => '23/04/2023',
            'start_time' => '07:00 PM',
            'weeks_before_next_batch' => 24
        );
    }    

    public static function advTFHealing1StartDate() {
        return array(
            'course_name' => 'Advanced Twin Flame Healings 1',
            'start_date' => '5/08/2023',
            'start_time' => '08:00 PM',
            'weeks_before_next_batch' => 52
        );
    }    
}

function upcoming_course_start_date_shortcode($atts) {
    // Extract shortcode attributes
    $attributes = shortcode_atts(array(
        'course_name' => '',
    ), $atts);

    $formatted_date = '';

    // Determine which course method to call based on course_name attribute
    if ($attributes['course_name'] === 'lifecoach') {
        $start_date_info = CourseDatesTfc::lifeCoachStartDate();
    } elseif ($attributes['course_name'] === 'biw2') {
        $start_date_info = CourseDatesTfc::basicInnerWork2StartDate();
    } elseif ($attributes['course_name'] === 'advtfh1') {
        $start_date_info = CourseDatesTfc::advTFHealing1StartDate();
    }

    // Call courseStartDate method using the extracted start_date_info
    if (isset($start_date_info)) {
        $formatted_date = CourseDatesTfc::courseStartDate(
            $start_date_info['start_date'],
            $start_date_info['start_time'],
            $start_date_info['weeks_before_next_batch']
        );
    }

    return $formatted_date;
}

add_shortcode('upcoming_course_start_date', 'upcoming_course_start_date_shortcode');
