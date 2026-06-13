<?php

function user_follow_up_eligibility_shortcode($atts)
{
    // Get the current user ID
    $user_id = get_current_user_id();

    if ($user_id) {
        $remaining_count = TFCMembers\FreeFollowUpConsultationManager::getRemainingConsultations( $user_id );
    
        if ($remaining_count > 0) {
            return '<div class="contentbox promobox-container" style="display: flex; align-items: center;">
						ℹ️ <a href="https://members.twinflamescoach.com/product/15-min-follow-up/">
                        &nbsp;' . $remaining_count . ' Free 15-min follow-up available
                        </a>
					</div>';
        }
    } else {
        return 'Something went wrong due to Invalid user ID or product ID, and we could not find out if you are elilgible for free follow up call';
    }
}

// Register the shortcode
add_shortcode('user_follow_up_eligibility', 'user_follow_up_eligibility_shortcode');
