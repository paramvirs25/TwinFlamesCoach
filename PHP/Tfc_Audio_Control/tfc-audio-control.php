<?php
/**
 * Plugin Name: Tfc Audio Control
 * Plugin URI: #
 * Description: A Gutenberg block for displaying an audio player with a "Save to Dropbox" link.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: #
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tfc-audio-control
 */

// Enqueue the block's assets
function tfc_audio_control_block_assets() {
    wp_enqueue_script(
        'tfc-audio-control-block',
        plugin_dir_url(__FILE__) . 'js/block.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . 'js/block.js')
    );
}

add_action('enqueue_block_editor_assets', 'tfc_audio_control_block_assets');

// Register the block
function tfc_audio_control_register_block() {
    // Enqueue block editor styles
    wp_enqueue_style(
        'tfc-audio-control-editor-style',
        plugin_dir_url(__FILE__) . 'css/editor-style.css',
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'css/editor-style.css')
    );

    // Enqueue front-end styles
    wp_enqueue_style(
        'tfc-audio-control-style',
        plugin_dir_url(__FILE__) . 'css/style.css',
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'css/style.css')
    );

    // Register the block
    register_block_type('tfc-audio-control/block', array(
        'editor_script' => 'tfc-audio-control-block',
        'editor_style' => 'tfc-audio-control-editor-style',
        'style' => 'tfc-audio-control-style',
        'render_callback' => 'tfc_audio_control_render_callback',
    ));
}

add_action('init', 'tfc_audio_control_register_block');

// Render the block on the front-end
function tfc_audio_control_render_callback($attributes) {
    // Extract attributes
    $audio_file_language = isset($attributes['audio_file_language']) ? $attributes['audio_file_language'] : '';
    $audio_file_id = isset($attributes['audio_file_id']) ? $attributes['audio_file_id'] : '';
    $audio_file_name = isset($attributes['audio_file_name']) ? $attributes['audio_file_name'] : '';

    // Generate the HTML output
    $output = '<div class="contentbox">
        <h5>' . esc_html($audio_file_language) . '</h5>
        <audio controls src="https://docs.google.com/uc?export=open&id=' . esc_attr($audio_file_id) . '"></audio>
        <div class="has-text-align-center"><a class="dropbox-saver dropbox-dropin-btn dropbox-dropin-default" data-filename="' . esc_attr($audio_file_name) . '" href="https://docs.google.com/uc?export=download&id=' . esc_attr($audio_file_id) . '"><span class="dropin-btn-status"></span>Save to Dropbox</a></div>
    </div>';

    return $output;
}
