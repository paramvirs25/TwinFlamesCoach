<?php

class TFC_Audio_Renderer {

    /**
     * Render one language of an audio.
     */
    public static function render($audio_data, $language) {

        /*
         * The new registry structure stores languages directly:
         *
         * $audio_data['hindi']
         * $audio_data['english']
         */
        if (
            empty($audio_data[$language]) ||
            !is_array($audio_data[$language])
        ) {
            return '';
        }

        $language_data = $audio_data[$language];


        /*
         * Try providers according to priority:
         *
         * Publit
         * Adilo
         * Google Drive
         */
        foreach (TFC_Audio_Registry::get_provider_priority() as $provider) {

            /*
             * Does this audio/language have this provider?
             */
            if (empty($language_data[$provider])) {
                continue;
            }


            switch ($provider) {

                case 'publit':
                    return self::render_publit(
                        $language_data[$provider]
                    );


                case 'adilo':
                    return self::render_adilo(
                        $language_data[$provider]
                    );


                case 'google_drive':
                    return self::render_google_drive(
                        $language_data[$provider]
                    );
            }
        }


        /*
         * No provider available.
         */
        return '';
    }


    /**
     * Render Publit player.
     */
    private static function render_publit($file) {

        if (empty($file)) {
            return '';
        }


        $url = 'https://TwinFlamesCoach.publit.io/file/' . ltrim($file, '/');


        return sprintf(
            '<audio oncontextmenu="return false;" controlslist="nodownload" controls style="width: 90%%;">
                <source src="%s" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>',
            esc_url($url)
        );
    }


    /**
     * Render Adilo player.
     */
    private static function render_adilo($id) {

        if (empty($id)) {
            return '';
        }


        $audio_url = esc_url(
            'https://adilo.bigcommand.com/watch/' . $id
        );


        return sprintf(
            '<div style="width: 100%%; position: relative; padding-top: 56.25%%;">
                <iframe
                    style="position: absolute; top: 0; left: 0; width: 100%%; height: 100%%;"
                    allowtransparency="true"
                    loading="lazy"
                    src="%s"
                    frameborder="0"
                    allowfullscreen
                    mozallowfullscreen
                    webkitallowfullscreen
                    oallowfullscreen
                    msallowfullscreen
                    scrolling="no">
                </iframe>
            </div>',
            $audio_url
        );
    }


    /**
     * Render Google Drive audio player.
     */
    private static function render_google_drive($id) {

        if (empty($id)) {
            return '';
        }


        $audio_url = esc_url(
            'https://members.twinflamescoach.com/audio-proxy/' . $id
        );


        return sprintf(
            '<audio controls controlsList="nodownload" style="width: 90%%;">
                <source src="%s" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>',
            $audio_url
        );
    }
}