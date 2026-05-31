<?php

add_shortcode('tfc_support_coaches', 'tfc_support_coaches_shortcode');

function tfc_support_coaches_shortcode() {

    $users = get_transient('tfc_support_coaches');

    if ($users === false) {

        $response = wp_remote_get(
            'https://members.twinflamescoach.com/wp-json/tfc/v1/users?nocache=' . time(),
            [
                'timeout' => 20
            ]
        );

        if (is_wp_error($response)) {
            return '<p>Unable to load coaches.</p>';
        }

        $users = json_decode(
            wp_remote_retrieve_body($response),
            true
        );

        set_transient(
            'tfc_support_coaches',
            $users,
            5 * MINUTE_IN_SECONDS
        );
    }

    if (empty($users)) {
        return '<p>No coaches found.</p>';
    }

    ob_start();

    static $css_loaded = false;

    if (!$css_loaded) {
        $css_loaded = true;
        ?>
        <style>
        .tfc-users-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:30px 20px;
            margin:30px 0;
        }

        .tfc-user{
            text-align:center;
        }

        .tfc-user a{
            text-decoration:none;
            color:inherit;
            display:block;
        }

        .tfc-user-avatar img{
            width:120px;
            height:120px;
            border-radius:50%;
            object-fit:cover;
            display:block;
            margin:0 auto 12px;
            transition:transform .2s ease;
        }

        .tfc-user a:hover .tfc-user-avatar img{
            transform:scale(1.05);
        }

        .tfc-user-name{
            font-size:16px;
            font-weight:600;
            line-height:1.4;
        }

        @media (max-width:1024px){
            .tfc-users-grid{
                grid-template-columns:repeat(3,1fr);
            }
        }

        @media (max-width:768px){
            .tfc-users-grid{
                grid-template-columns:repeat(3,1fr);
                gap:20px 10px;
            }

            .tfc-user-avatar img{
                width:90px;
                height:90px;
            }

            .tfc-user-name{
                font-size:14px;
            }
        }

        @media (max-width:480px){
            .tfc-users-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .tfc-user-avatar img{
                width:80px;
                height:80px;
            }
        }
        </style>
        <?php
    }
    ?>

    <div class="tfc-users-grid">

        <?php foreach ($users as $user) : ?>

            <div class="tfc-user">

                <a href="<?php echo esc_url($user['profile_url']); ?>" target="_blank">

                    <div class="tfc-user-avatar">
                        <img
                            src="<?php echo esc_url($user['avatar']); ?>"
                            alt="<?php echo esc_attr($user['display_name']); ?>"
                            loading="lazy"
                        >
                    </div>

                    <div class="tfc-user-name">
                        <?php echo esc_html($user['display_name']); ?>
                    </div>

                </a>

            </div>

        <?php endforeach; ?>

    </div>

    <?php

    return ob_get_clean();
}