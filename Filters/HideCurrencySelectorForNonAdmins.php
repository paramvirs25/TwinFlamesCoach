<?php
add_action('wp_head', function() {
    // Check if the current user is NOT an administrator
    if ( ! current_user_can('manage_options') ) {
        // Inject CSS to instantly hide the CURCY bar elements from non-admins
        echo '<style>
            .woo-multi-currency-sidebar, 
            #wmc_currencies_bar, 
            .wmc-sidebar,
            div[class*="wmc-"] { 
                display: none !important; 
            }
        </style>';
    }
}, 999);

?>