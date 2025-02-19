<?php
function basic_inner_work_1_date() {
    // Get the current timestamp
    $now = current_time('timestamp');

    // Calculate days until next Sunday
    $daysUntilSunday = (7 - date('w', $now)) % 7;
    if ($daysUntilSunday === 0) {
        $daysUntilSunday = 7; // Ensure it's the next Sunday, not today if already Sunday
    }

    // Get the timestamp for next Sunday at 9 AM
    $nextSunday = strtotime("+$daysUntilSunday days", $now);
    $nextSunday9AM = strtotime('9:00 AM', $nextSunday);

    // Format the date
    return date('F j Y l g:i A', $nextSunday9AM);
}

// Register the shortcode
add_shortcode('basic_inner_work_1_date', 'basic_inner_work_1_date');
