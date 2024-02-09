<?php

function user_follow_up_eligibility_shortcode($atts)
{
    // Get the current user ID
    $user_id = get_current_user_id();

    //Follow up consultation product
    $product_id = 12161;

    // Get the product ID from the shortcode attribute or set a default value
    //isset($atts['product_id']) ? intval($atts['product_id']) : 0;

    if ($user_id && $product_id) {
        // Check if the user has purchased the product
        $user_has_purchased = wc_customer_bought_product($user_id, $user_id, $product_id);

        if (!$user_has_purchased) {
            return '<div class="contentbox promobox-container" style="display: flex; align-items: center;">
						<img src="https://members.twinflamescoach.com/wp-content/uploads/2024/02/16x16-icon-45590.png" style="width: 34px; height: auto;" />
						<a href="https://members.twinflamescoach.com/product/15-min-follow-up/">Free 15-min follow-up available</a>
					</div>';
        }
    } else {
        return 'Something went wrong due to Invalid user ID or product ID, and we could not find out if you are elilgible for free follow up call';
    }
}

// Register the shortcode
add_shortcode('user_follow_up_eligibility', 'user_follow_up_eligibility_shortcode');
