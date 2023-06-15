<?php
namespace TFC;

add_shortcode( 'ajax_enable', function () {
    //For AJAX call
	add_action( 'wp_enqueue_scripts', 'my_enqueue_function' );	 
} );

function my_enqueue_function() {
	wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/wp-content/uploads/custom-css-js/my-ajax-script.js', array('jquery') );
	wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
?>