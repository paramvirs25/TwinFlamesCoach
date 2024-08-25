<?php
function whatsapp_button($phone_number, $message){
    // Sanitize message
    $message = urlencode($message);
    
    // WhatsApp URL
    $whatsapp_url = "https://api.whatsapp.com/send?phone=$phone_number&text=$message";

    // Output WhatsApp button HTML
    $output = '<div class="wp-block-jetpack-send-a-message">';
    $output .= '<div class="wp-block-jetpack-whatsapp-button aligncenter is-color-dark">';
    $output .= '<a class="whatsapp-block__button" href="' . $whatsapp_url . '" style="background-color:#25D366;color:#fff" target="_blank" rel="noopener noreferrer">WhatsApp to Program Support</a>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function whatsapp_program_support_shortcode($atts, $content = null) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'message' => ''
    ), $atts);

    // Hardcoded phone number
    $phone_number = '919417302025';

    return whatsapp_button($phone_number, $atts['message']);
}

add_shortcode('whatsapp_program_support', 'whatsapp_program_support_shortcode');