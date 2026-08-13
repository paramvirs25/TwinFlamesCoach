<?php

class TFC_Audio_Registry {

    /**
     * Provider priority.
     *
     * The first configured provider will be used.
     * If it is not available for an audio, the next provider is tried.
     */
    private static $provider_priority = [
        'publit',
        'adilo',
        'google_drive',
    ];


    /**
     * Audio library.
     *
     * Each audio has a logical ID.
     * Provider-specific IDs/files live here.
     */
    private static $audios = [

        /*
         * ============================================================
         * CHAKRA BALANCING
         * ============================================================
         */

        'chakra_balancing_root' => [
            'title' => 'Root Chakra',

            'languages' => [

                'hindi' => [
                    'adilo' => [
                        'id' => 'NkPF1ZsR',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/1-Root-Chakra-Hindi.mp3',
                    ],
                ],

                'english' => [
                    'adilo' => [
                        'id' => 'ZIwdP4S0',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/1-Root-Chakra.mp3',
                    ],
                ],
            ],
        ],


        'chakra_balancing_sacral' => [
            'title' => 'Sacral Chakra',

            'languages' => [

                'hindi' => [
                    'adilo' => [
                        'id' => 'BnRcnuFR',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/2-Sacral-chakra-Hindi.mp3',
                    ],
                ],

                'english' => [
                    'adilo' => [
                        'id' => 'tH60wj1p',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/2-Sacral-Chakra.mp3',
                    ],
                ],
            ],
        ],


        'chakra_balancing_solar_plexus' => [
            'title' => 'Solar Plexus Chakra',

            'languages' => [

                'hindi' => [
                    'adilo' => [
                        'id' => 'gn0XrZlP',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/3-Solar-Plexus-Hindi.mp3',
                    ],
                ],

                'english' => [
                    'adilo' => [
                        'id' => 'IbVJjZTj',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/3-Solar-Plexus-Chakra.mp3',
                    ],
                ],
            ],
        ],


        'chakra_balancing_heart' => [
            'title' => 'Heart Chakra',

            'languages' => [

                'english' => [
                    'adilo' => [
                        'id' => 'DYUxEX3E',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/4-Heart-Chakra.mp3',
                    ],
                ],
            ],
        ],


        'chakra_balancing_throat' => [
            'title' => 'Throat Chakra',

            'languages' => [

                'english' => [
                    'adilo' => [
                        'id' => 'znSIe5Zf',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/5-Throat-Chakra.mp3',
                    ],
                ],
            ],
        ],


        'chakra_balancing_third_eye' => [
            'title' => 'Third Eye Chakra',

            'languages' => [

                'english' => [
                    'adilo' => [
                        'id' => '3sruhIcr',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/6-Third-Eye-Chakra.mp3',
                    ],
                ],
            ],
        ],


        'chakra_balancing_crown' => [
            'title' => 'Crown Chakra',

            'languages' => [

                'english' => [
                    'adilo' => [
                        'id' => 'Ij3rWVB9',
                    ],
                    'publit' => [
                        'file' => 'Chakra-Balancing/7-Crown-Chakra.mp3',
                    ],
                ],
            ],
        ],
    ];


    /**
     * Get an audio record.
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
     * Get all audios.
     */
    public static function all() {

        return self::$audios;
    }
}