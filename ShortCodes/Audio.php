<?php
function tfc_audio_shortcode($atts) {
    $atts = shortcode_atts([
        'hindi_audio_id' => '',
        'english_audio_id' => '',
    ], $atts);

    $output = '<div class="wp-block-group tfcScrollHorizRow">';

    $audio_sources = [
        'Hindi' => $atts['hindi_audio_id'],
        'English' => $atts['english_audio_id']
    ];

    foreach ($audio_sources as $language => $audio_id) {
        if (!empty($audio_id)) {
            $audio_url = esc_url('https://adilo.bigcommand.com/watch/' . $audio_id);
            $output .= "<div class='wp-block-group'>
                            <h3 class='wp-block-heading'>{$language}</h3>
                            <div style='width: 100%; position: relative; padding-top: 56.25%'>
                                <iframe style='position: absolute; top: 0; left: 0; width: 100%; height: 100%' 
                                        allowtransparency='true' 
                                        loading='lazy' 
                                        src='{$audio_url}' 
                                        frameborder='0' 
                                        allowfullscreen 
                                        mozallowfullscreen 
                                        webkitallowfullscreen 
                                        oallowfullscreen 
                                        msallowfullscreen 
                                        scrolling='no'></iframe>
                            </div>
                        </div>";
        }
    }

    $output .= '</div>';
    return $output;
}

add_shortcode('tfc_audio', 'tfc_audio_shortcode');
