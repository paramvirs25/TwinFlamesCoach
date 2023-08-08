<?php

// Shortcode for Course 1 - Life Coach course
function life_coach_start_date_shortcode() {
    $current_year = date('Y');
    $start_date = strtotime($current_year . '-01-01');
    if (time() > $start_date) {
        $next_year = $current_year + 1;
        $start_date = strtotime($next_year . '-01-01');
    }
    return date('F j, Y', $start_date);
}
add_shortcode('life_coach_start_date', 'life_coach_start_date_shortcode');

// Shortcode for Course 2 - Basic Inner Work 2 program
function basic_inner_work_2_start_date_shortcode() {
    $last_start_date = strtotime('2023-04-30'); // Change this date to the last conducted start date
    $next_start_date = strtotime('+4 months', $last_start_date);
    if (time() > $next_start_date) {
        $next_start_date = strtotime('+5 months', $next_start_date);
    }
    return date('F j, Y', $next_start_date);
}
add_shortcode('basic_inner_work_2_start_date', 'basic_inner_work_2_start_date_shortcode');

// Shortcode for Course 3 - Advanced Twin Flame Healings
function twin_flame_start_date_shortcode() {
    $current_year = date('Y');
    $start_date = strtotime($current_year . '-08-01');
    if (time() > $start_date) {
        $next_year = $current_year + 1;
        $start_date = strtotime($next_year . '-08-01');
    }
    return date('F j, Y', $start_date);
}
add_shortcode('twin_flame_start_date', 'twin_flame_start_date_shortcode');
