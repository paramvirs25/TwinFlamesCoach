<?php
function tfc_audio_shortcode($atts) {
    $atts = shortcode_atts([
        'hindi_audio_id' => '',
        'english_audio_id' => '',
        'hindi_heading' => '',
        'english_heading' => '',
    ], $atts);

    $output = '<div class="wp-block-group tfcScrollHorizRow">';

    $audio_sources = [
        'Hindi' => [
            'id' => $atts['hindi_audio_id'],
            'heading' => $atts['hindi_heading'] ?: 'Hindi'
        ],
        'English' => [
            'id' => $atts['english_audio_id'],
            'heading' => $atts['english_heading'] ?: 'English'
        ]
    ];

    foreach ($audio_sources as $language => $data) {
        if (!empty($data['id'])) {
            $audio_url = esc_url('https://adilo.bigcommand.com/watch/' . $data['id']);
            $output .= "<div class='wp-block-group'>
                            <h4 class='wp-block-heading'>{$data['heading']}</h4>
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
