<?php
function tfc_audio_shortcode($atts) {
    // Flag to control which player to use
    $is_use_adilo = true;  // Change to false to use HTML5 audio player when possible

    // Define shortcode attributes
    $atts = shortcode_atts([
        'hindi_audio_id'        => '',
        'english_audio_id'      => '',
        'gd_hindi_audio_id'     => '',
        'gd_english_audio_id'   => '',
        'hindi_heading'         => '',
        'english_heading'       => '',
    ], $atts);

    $output = '<div class="wp-block-group tfcScrollHorizRow">';

    $audio_sources = [
        'Hindi' => [
            'id'         => $atts['hindi_audio_id'],
            'gd_id'      => $atts['gd_hindi_audio_id'],
            'heading'    => $atts['hindi_heading'] ?: 'Hindi'
        ],
        'English' => [
            'id'         => $atts['english_audio_id'],
            'gd_id'      => $atts['gd_english_audio_id'],
            'heading'    => $atts['english_heading'] ?: 'English'
        ]
    ];

    foreach ($audio_sources as $language => $data) {
        // Decide if we should use Adilo or HTML5 player
        if ($is_use_adilo || empty($data['gd_id'])) {
            // Use Adilo iframe
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
        } else {
            // Use HTML5 audio player with Google Drive ID
            $gd_audio_url = esc_url('https://members.twinflamescoach.com/audio-proxy/' . $data['gd_id']);
            $output .= "<div class='wp-block-group'>
                            <h4 class='wp-block-heading'>{$data['heading']}</h4>
                            <audio controls controlsList='nodownload' style='width: 100%;'>
                                <source src='{$gd_audio_url}' type='audio/mpeg'>
                                Your browser does not support the audio element.
                            </audio>
                        </div>";
        }
    }

    $output .= '</div>';
    return $output;
}

add_shortcode('tfc_audio', 'tfc_audio_shortcode');
