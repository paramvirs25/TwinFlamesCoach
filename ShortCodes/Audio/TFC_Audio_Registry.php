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

        'connection_tool' => [
            'title' => 'Connection Tool',

            'hindi' => [
                'adilo'        => 'n5izXTBn',
                'google_drive' => '1iP2_gg_3BX92aiDvPAqfMnzCEYxkdphb',
                'publit'       => 'Tools/Connection-ToolHindi.mp3',
            ],

            'english' => [
                'adilo'        => 'BNS8Lu9H',
                'google_drive' => '1xqqxLwOlXh76InreADyCF4qcpXKfdxx6',
                'publit'       => 'Tools/Connection-Tool-English.mp3',
            ],
        ],

        'inner_child' => [
            'title' => 'Inner Child',

            'hindi' => [
                'adilo'        => 'v3nSo8LI',
                'google_drive' => '1dh-fru0APil4bgfKB7O33H29JoUoRq9R',
                'publit'       => 'Tools/Inner-ChildHindi.mp3',
            ],

            'english' => [
                'adilo'        => 'DNGpObzW',
                'google_drive' => '1a8TBj1NOxfWw8--WKbs_YvFooQt2VStr',
                'publit'       => 'Tools/Inner-Child-English.mp3',
            ],
        ],

        'harmony_healing' => [
            'title' => 'Harmony Healing',

            'hindi' => [
                'adilo'        => '6rLLkk6L',
                'google_drive' => '1MF9S-Q1Kx5Sl8wjLwvAt_qe6zieXLJO7',
                'publit'       => 'Tools/Harmony-HealingHindi.mp3',
            ],

            'english' => [
                'adilo'        => 'gqwVspjC',
                'google_drive' => '1-hLV8-UKTbRSkToYjALiMEpTqtYdo8-V',
                'publit'       => 'Tools/Harmony-Healing-English.mp3',
            ],
        ],

        'four_mirrors' => [
            'title' => 'Four Mirrors',

            'hindi' => [
                'adilo'  => '3lDZg7Iw',
                'publit' => 'Tools/Four-mirrors.mp3',
            ],
        ],

        'fear_healing' => [
            'title' => 'Fear Healing',

            'hindi' => [
                'adilo'        => 'c4_4_Z0_',
                'google_drive' => '1rw4-q-z4giSSUMb1dynbEblEPh9i1ZYc',
                'publit'       => 'Tools/Fear-Healing-Hindi.mp3',
            ],

            'english' => [
                'adilo'        => 'D5bp9Ikm',
                'google_drive' => '1UYzIG1hHQfuT1unseg557Q0vQ3M1-mYT',
                'publit'       => 'Tools/Fear-Healing-English.mp3',
            ],
        ],


        'belief_clearing_session_1' => [
            'title' => 'Belief Clearing Session 1',

            'hindi' => [
                'adilo'        => '5T1XG28A',
                'google_drive' => '1IFMGuZtWmW_QIQX9IKF3TXkKZlYUSUav',
                'publit'       => 'Tools/Belief-Clearing-Session-1Hindi.mp3',
            ],

            'english' => [
                'adilo'        => 'NUNqDHqg',
                'google_drive' => '1UjFqNrXZ-3Lm43CWJ36Sq3mkR5s2Tq-q',
                'publit'       => 'Tools/Belief-Clearing-Session-01-English.mp3',
            ],
        ],


        'creative_visualization' => [
            'title' => 'Creative Visualization',

            'hindi' => [
                'adilo'        => 'OQORnz80',
                'google_drive' => '1NsIuJwIuuWE5ZIIwfswF6Jc5RHvh7a0Z',
                'publit'       => 'Tools/Creative-VisualizationHindi.mp3',
            ],

            'english' => [
                'adilo'        => 'mjjvQ3ct',
                'google_drive' => '1OWDALKyXZy5POTASGoxiRFP-QRuRgX0r',
                'publit'       => 'Tools/Creative-Visualisation-English.mp3',
            ],
        ],

        'belief_clearing_session_2' => [
            'title' => 'Belief Clearing Session 2',

            'hindi' => [
                'adilo'        => 'TrvZLb8m',
                'google_drive' => '1Yy6VKd-AdHvvgdFwlZxXbp8UJVp4u8L-',
                'publit'       => 'Tools/Belief-Clearing-Session-2Hindi.mp3',
            ],

            'english' => [
                'adilo'        => 'YgVEN_9x',
                'google_drive' => '1DIsHi1wMZdVWkoSFBLDi_FsME6BVShop',
                'publit'       => 'Tools/Belief-Clearing-Session-2-English.mp3',
            ],
        ],


        'higher_heart_1' => [
            'title' => 'Higher Heart 1',

            'hindi' => [
                'adilo'        => '7ZNxPgoV',
                'google_drive' => '1VBulAEk9e7ViFoa54UYy8ipvM866URQ7',
                'publit'       => 'Tools/Higher-heart-1Hindi.mp3',
            ],

            'english' => [
                'adilo'        => '_60ljj01',
                'google_drive' => '1S161o2_YpIDVFuJGfqtZWwHP8c62NC7k',
                'publit'       => 'Tools/Higher-Heart-1English.mp3',
            ],
        ],


        'angels_blessings_hd' => [
            'title' => 'Angels Blessings HD',

            'hindi' => [
                'adilo'        => 'k056WdQ7',
                'google_drive' => '1XeJb1bGMr9I09pxea0opJkRYlv_O2ufk',
                'publit'       => 'Tools/Angels-Blessings-HD-Hindi.mp3',
            ],

            'english' => [
                'adilo'        => 'saOz7dzG',
                'google_drive' => '1q-GfcJ-UNM42yWBuaaDIcRbR8JTbb1aK',
                'publit'       => 'Tools/Angels-blessings-HD-English.mp3',
            ],
        ],

        'cosmic_marriage' => [
            'title' => 'Cosmic Marriage',

            'hindi' => [
                'adilo'        => 'H6giQpes',
                'google_drive' => '10gLtdXNCn4a4mEWuTp77J8ktQYUW6ZkW',
                'publit'       => 'Tools/Cosmic-Marriage-Hindi.mp3',
            ],

            'english' => [
                'adilo'        => 'Nl0lKpzC',
                'google_drive' => '1WJ69U0ABpr_eYiW4YxXE4g9cmG3TAg9L',
                'publit'       => 'Tools/Cosmic-Marriage-English.mp3',
            ],
        ],

        'star_activation' => [
            'title' => 'Star Activation',

            'hindi' => [
                'adilo'        => 'leaypTvF',
                'google_drive' => '10GXLIXKYv8gi2vmM-W1XFDlxbvp4RCo5',
                'publit'       => 'Tools/Star-activation.mp3',
            ],

            'english' => [
                'adilo'        => 'qnF20K8D',
                'google_drive' => '1dXG3k8tls_U5wcHQNJaUiwzq3GmPQI3U',
                'publit'       => 'Tools/Star-activation-Eng-Small.mp3',
            ],
        ],


        'higher_heart_2_manifestations' => [
            'title' => 'Higher Heart 2 - Manifestations',

            'hindi' => [
                'adilo'        => 'EdRSyhRf',
                'google_drive' => '1E5Vn37bm7tdUIs4Fc_GadgjdrLKa584w',
                'publit'       => 'Tools/Higher-heart-2-Manifestations.mp3',
            ],

            'english' => [
                'adilo'        => 'qh5EQEGy',
                'google_drive' => '1oDnUM7yEerRccOxZgsksAhG7Br8qV0dT',
                'publit'       => 'Tools/Higher-Heart-2-Eng.mp3',
            ],
        ],

        'energy_ritual' => [
            'title' => 'Energy Ritual',

            'hindi' => [
                'adilo'        => 'eMsRxPQ4',
                'google_drive' => '1vzTK_rnXuevKVd6f5FU_XG4t0Gn97Wtk',
                'publit'       => 'Tools/Energy-ritual.mp3',
            ],

            'english' => [
                'adilo'        => 'RnQd6CWX',
                'google_drive' => '1JJj8xEc_XHPh_LmEjILEPB3DCmyR44HH',
                'publit'       => 'Tools/Energy-Ritual-English.mp3',
            ],
        ],


        'affirmations' => [
            'title' => 'Affirmations',

            'hindi' => [
                'adilo'        => 'ga8Gcuuk',
                'google_drive' => '191bF0WP96xODZMalI-tGV-jfrohqXck5',
                'publit'       => 'Tools/Affirmation.mp3',
            ],

            'english' => [
                'adilo'        => 'SSdwcElu',
                'google_drive' => '1sqwL3gTsRXCfpNf7JnWMkPKlC37UFCNt',
                'publit'       => 'Tools/Affirmations-Eng.mp3',
            ],
        ],


        'belief_clearing_advanced_1' => [
            'title' => 'Belief Clearing Advanced 1',

            'hindi' => [
                'adilo'        => 'n9ihEanw',
                'google_drive' => '1RvkBL5_xWVcz3YWTWfPUVeyxZal7m-xg',
                'publit'       => 'Tools/Belief-Clearing-Advanced-1.mp3',
            ],
        ],

        'union_of_souls' => [
            'title' => 'Union of Souls',

            'hindi' => [
                'google_drive' => '1JEekT0fAiOpnHgVVNWlAp3-yz5YMiVhp',
                'publit'       => 'Tools/UnionOfSouls-Hindi.mp3',
            ],
        ],


        'sexual_belief_clearing' => [
            'title' => 'Sexual Belief Clearing',

            'hindi' => [
                'adilo'        => '8LgbGdYo',
                'google_drive' => '1vfygaenDviFX7JFJEiZl8JDykWek84oS',
                'publit'       => 'Tools/Sexual-belief-clearing-Hindi.mp3',
            ],

            'english' => [
                'adilo'        => 'Zzbs0oYt',
                'google_drive' => '1V6IhkoCqnNBgnLAl0geU72DJDmynqlQM',
                'publit'       => 'Tools/Sexual-belief-clearing-English.mp3',
            ],
        ],

        'spirit_animal_guide' => [
            'title' => 'Spirit Animal Guide',

            'hindi' => [
                'google_drive' => '1F-zFh500Ba8NhOk4sXvEGb4nAfAzcTDc',
                'publit'       => 'Tools/Animal-Spirit-Guides-small.mp3',
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