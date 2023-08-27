<?php
// Add this code to your functions.php or a custom plugin file

function upcoming_course_start_date_shortcode($atts) {
    // Extract shortcode attributes
    $attributes = shortcode_atts(array(
        'start_date' => '',
        'start_time' => '',
        'weeks_before_next_batch' => 0,
    ), $atts);

    // Parse input date and time
    $start_date = DateTime::createFromFormat('d/m/Y g:i A', $attributes['start_date'] . ' ' . $attributes['start_time']);
    $current_date = new DateTime();

    // Calculate next batch start date based on conditions
    if ($start_date > $current_date) {
        $formatted_date = $start_date->format('j F Y g:i A');
    } else {
        $next_start_date = clone $start_date;
        $next_start_date->modify('+' . $attributes['weeks_before_next_batch'] . ' weeks');
        $formatted_date = $next_start_date->format('F Y g:i A');
    }

    return $formatted_date;
}
add_shortcode('upcoming_course_start_date', 'upcoming_course_start_date_shortcode');
