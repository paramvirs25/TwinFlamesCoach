<?php
function create_whatsapp_button($isAutoClick, $url, $text){
    // Ensure correct class is added for auto-click
    $autoClickLinkText = ($isAutoClick) ? " auto-click-link" : ""; 

    // Output WhatsApp button HTML
    $output = '<div class="wp-block-jetpack-send-a-message">';
    $output .= '<div class="wp-block-jetpack-whatsapp-button aligncenter is-color-dark">';
    $output .= '<a class="confirmFreeConsultModal whatsapp-block__button' . $autoClickLinkText . '" href="' . $url . '" style="background-color:#25D366;color:#fff" target="_self" rel="noopener noreferrer">' . $text . '</a>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function whatsapp_url($phone_number, $message){
    // Sanitize message
    $message = urlencode($message);

    return "https://api.whatsapp.com/send?phone=$phone_number&text=$message";
}

function whatsapp_param_shortcode($atts, $content = null) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'message' => ''
    ), $atts);

    // Hardcoded phone number
    $phone_number = '919478016938';

    return create_whatsapp_button(
        false,  // Now passing boolean
        whatsapp_url($phone_number, $atts['message']),
        "WhatsApp Jnana Param"
    );
}

function whatsapp_rituom_shortcode($atts, $content = null) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'message' => ''
    ), $atts);

    // Hardcoded phone number
    $phone_number = '919876491309';

    return create_whatsapp_button(
        false,  // Now passing boolean
        whatsapp_url($phone_number, $atts['message']),
        "WhatsApp Ritu Om"
    );
}

function whatsapp_program_support_shortcode($atts, $content = null) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'message' => ''
    ), $atts);

    // Hardcoded phone number
    $phone_number = '919417302025';

    return create_whatsapp_button(
        false,  // Now passing boolean
        whatsapp_url($phone_number, $atts['message']),
        "WhatsApp Program Support"
    );
}

function whatsapp_group_button_shortcode($atts, $content = null) {
    // Extract attributes and convert 'true'/'false' string to boolean
    $atts = shortcode_atts(array(
        'is-auto-click' => 'false', // Set default as 'false'
        'url' => '',
        'text' => ''
    ), $atts);

    // Convert string to boolean
    $isAutoClick = filter_var($atts['is-auto-click'], FILTER_VALIDATE_BOOLEAN);

    return create_whatsapp_button($isAutoClick, $atts['url'], $atts['text']);
}

// Register the shortcodes
add_shortcode('whatsapp_param', 'whatsapp_param_shortcode');
add_shortcode('whatsapp_rituom', 'whatsapp_rituom_shortcode');
add_shortcode('whatsapp_program_support', 'whatsapp_program_support_shortcode');
add_shortcode('whatsapp_group_button', 'whatsapp_group_button_shortcode');
