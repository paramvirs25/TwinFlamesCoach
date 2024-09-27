<?php
function create_whatsapp_button($isAutoClick, $url, $text){
    // Check if auto-click class should be added
    $autoClickLinkText = ($isAutoClick == "true") ? " auto-click-link" : ""; 

    // Output WhatsApp button HTML
    $output = '<div class="wp-block-jetpack-send-a-message">';
    $output .= '<div class="wp-block-jetpack-whatsapp-button aligncenter is-color-dark">';
    $output .= '<a class="whatsapp-block__button' . $autoClickLinkText . '" href="' . $url . '" style="background-color:#25D366;color:#fff" target="_blank" rel="noopener noreferrer">' . $text . '</a>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function whatsapp_url($phone_number, $message){
    // Sanitize message
    $message = urlencode($message);

    return "https://api.whatsapp.com/send?phone=$phone_number&text=$message";
}

function whatsapp_program_support_shortcode($atts, $content = null) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'message' => ''
    ), $atts);

    // Hardcoded phone number
    $phone_number = '919417302025';

    return create_whatsapp_button(
        "false", 
        whatsapp_url($phone_number, $atts['message']),
        "WhatsApp to Program Support"
    );
}

function whatsapp_group_button_shortcode($atts, $content = null) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'isAutoClick' => '',
        'url' => '',
        'text' => ''
    ), $atts);

    return create_whatsapp_button($atts['isAutoClick'], $atts['url'], $atts['text']);
}

// Register the shortcodes
add_shortcode('whatsapp_program_support', 'whatsapp_program_support_shortcode');
add_shortcode('whatsapp_group_button', 'whatsapp_group_button_shortcode');
