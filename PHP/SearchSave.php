<?php
function get_data() {
    //$abc = '1';
    //$result = $wpdb->get_results("SELECT * FROM ".$wpdb->options ." WHERE option_name LIKE '_transient_%'");
    //echo  $result; //returning this value but still shows 0
    echo "Hi";
    wp_die();
}

add_action( 'wp_ajax_nopriv_get_data', 'get_data' );
add_action( 'wp_ajax_get_data', 'get_data' );

?>