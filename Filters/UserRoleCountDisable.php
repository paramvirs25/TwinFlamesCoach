<?php
add_filter( 'pre_count_users', function( $counts, $strategy, $site_id ) {
    return array(
        'total_users' => 0,
        'avail_roles' => array(),
    );
}, 10, 3 );