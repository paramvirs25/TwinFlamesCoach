<?php

class TFC_Audio_Registry {

    /**
     * Provider priority.
     *
     * The first available provider will be used.
     */
    private static $provider_priority = [
        'publit',
        'adilo',
        'google_drive',
    ];


    /**
     * Audio library.
     *
     * Structure:
     *
     * 'audio_id' => [
     *     'title' => 'Audio Title',
     *     'hindi' => [
     *         'adilo'       => 'Adilo ID',
     *         'publit'      => 'Publit file path',
     *         'google_drive'=> 'Google Drive ID',
     *     ],
     *     'english' => [
     *         ...
     *     ],
     * ],
     */
    private static $audios = [

        /*
         * ============================================================
         * CHAKRA BALANCING
         * ============================================================
         */

        'chakra_balancing_root' => [
            'title' => 'Root Chakra',

            'hindi' => [
                'adilo'  => 'NkPF1ZsR',
                'publit' => 'Chakra-Balancing/1-Root-Chakra-Hindi.mp3',
            ],

            'english' => [
                'adilo'  => 'ZIwdP4S0',
                'publit' => 'Chakra-Balancing/1-Root-Chakra.mp3',
            ],
        ],


        'chakra_balancing_sacral' => [
            'title' => 'Sacral Chakra',

            'hindi' => [
                'adilo'  => 'BnRcnuFR',
                'publit' => 'Chakra-Balancing/2-Sacral-chakra-Hindi.mp3',
            ],

            'english' => [
                'adilo'  => 'tH60wj1p',
                'publit' => 'Chakra-Balancing/2-Sacral-Chakra.mp3',
            ],
        ],


        'chakra_balancing_solar_plexus' => [
            'title' => 'Solar Plexus Chakra',

            'hindi' => [
                'adilo'  => 'gn0XrZlP',
                'publit' => 'Chakra-Balancing/3-Solar-Plexus-Hindi.mp3',
            ],

            'english' => [
                'adilo'  => 'IbVJjZTj',
                'publit' => 'Chakra-Balancing/3-Solar-Plexus-Chakra.mp3',
            ],
        ],


        'chakra_balancing_heart' => [
            'title' => 'Heart Chakra',

            'english' => [
                'adilo'  => 'DYUxEX3E',
                'publit' => 'Chakra-Balancing/4-Heart-Chakra.mp3',
            ],
        ],


        'chakra_balancing_throat' => [
            'title' => 'Throat Chakra',

            'english' => [
                'adilo'  => 'znSIe5Zf',
                'publit' => 'Chakra-Balancing/5-Throat-Chakra.mp3',
            ],
        ],


        'chakra_balancing_third_eye' => [
            'title' => 'Third Eye Chakra',

            'english' => [
                'adilo'  => '3sruhIcr',
                'publit' => 'Chakra-Balancing/6-Third-Eye-Chakra.mp3',
            ],
        ],


        'chakra_balancing_crown' => [
            'title' => 'Crown Chakra',

            'english' => [
                'adilo'  => 'Ij3rWVB9',
                'publit' => 'Chakra-Balancing/7-Crown-Chakra.mp3',
            ],
        ],

    ];


    /**
     * Get one audio by logical ID.
     */
    public static function get($audio_id) {

        return self::$audios[$audio_id] ?? null;
    }


    /**
     * Get provider priority.
     */
    public static function get_provider_priority() {

        return self::$provider_priority;
    }


    /**
     * Get all registered audios.
     */
    public static function all() {

        return self::$audios;
    }
}