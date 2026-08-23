<?php
function tfc_audio_player_shortcode($atts) {

    $atts = shortcode_atts([
        'audio_id'        => '',
        'hindi_heading'   => 'Hindi',
        'english_heading' => 'English',
    ], $atts);


    if (empty($atts['audio_id'])) {
        return '';
    }


    $audio = TFC_Audio_Registry::get($atts['audio_id']);

    if (!$audio) {
        return '';
    }


    $output = '<div class="wp-block-group tfcScrollHorizRow">';


    /*
     * ============================================================
     * HINDI
     * ============================================================
     */

    if (!empty($audio['hindi'])) {

        $player = TFC_Audio_Renderer::render(
            $audio,
            'hindi'
        );

        if ($player) {

            $output .= sprintf(
                '<div class="wp-block-group">
                    <h4 class="wp-block-heading">%s</h4>
                    %s
                </div>',
                esc_html($atts['hindi_heading']),
                $player
            );
        }
    }


    /*
     * ============================================================
     * ENGLISH
     * ============================================================
     */

    if (!empty($audio['english'])) {

        $player = TFC_Audio_Renderer::render(
            $audio,
            'english'
        );

        if ($player) {

            $output .= sprintf(
                '<div class="wp-block-group">
                    <h4 class="wp-block-heading">%s</h4>
                    %s
                </div>',
                esc_html($atts['english_heading']),
                $player
            );
        }
    }


    $output .= '</div>';

    return $output;
}


add_shortcode('tfc_audio_player', 'tfc_audio_player_shortcode');