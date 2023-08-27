<?php
// Add this code to your functions.php or a custom plugin file

class CourseDatesTfc {
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
}

function upcoming_course_start_date_shortcode($atts) {
    // Extract shortcode attributes
    $attributes = shortcode_atts(array(
        'start_date' => '',
        'start_time' => '',
        'weeks_before_next_batch' => 0,
    ), $atts);

    // Call CourseDatesTfc class method for processing
    $formatted_date = CourseDatesTfc::courseStartDate(
        $attributes['start_date'],
        $attributes['start_time'],
        $attributes['weeks_before_next_batch']
    );

    return $formatted_date;
}
add_shortcode('upcoming_course_start_date', 'upcoming_course_start_date_shortcode');
