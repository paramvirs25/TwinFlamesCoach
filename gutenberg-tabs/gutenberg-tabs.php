<?php
/*
Plugin Name: Gutenberg Tabs
Description: Adds multiple tabs functionality to Gutenberg editor.
Version: 1.0.0
Author: Your Name
*/

// Enqueue the plugin stylesheets and scripts
function gutenberg_tabs_enqueue_assets() {
    wp_enqueue_style( 'gutenberg-tabs-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '1.0.0' );
    wp_enqueue_script( 'gutenberg-tabs-script', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'wp-blocks', 'wp-element', 'wp-editor' ), '1.0.0', true );
}
add_action( 'enqueue_block_editor_assets', 'gutenberg_tabs_enqueue_assets' );

// Register the tab block
function gutenberg_tabs_register_block() {
    wp_register_script(
        'gutenberg-tabs-block',
        plugins_url( 'js/block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'js/block.js' )
    );

    register_block_type( 'gutenberg-tabs/tab', array(
        'editor_script' => 'gutenberg-tabs-block',
    ) );
}
add_action( 'init', 'gutenberg_tabs_register_block' );

?>