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

    public static function lifeCoachStartDate(){
        return CourseDatesTfc::courseStartDate("18/01/2023", "07:30 PM", 24);
    }

    public static function basicInnerWork2StartDate(){
        return CourseDatesTfc::courseStartDate("23/04/2023", "07:00 PM", 24);
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
        $formatted_date = CourseDatesTfc::lifeCoachStartDate();
    } elseif ($attributes['course_name'] === 'biw2') {
        $formatted_date = CourseDatesTfc::basicInnerWork2StartDate();
    }

    return $formatted_date;
}
add_shortcode('upcoming_course_start_date', 'upcoming_course_start_date_shortcode');
