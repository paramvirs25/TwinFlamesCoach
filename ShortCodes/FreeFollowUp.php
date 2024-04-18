<?php
function free_follow_up_shortcode($atts) {
    // Get the current user ID
    $user_id = get_current_user_id();	
	
    //Retrieving Consultation Count
    $remaining_count = TFCMembers\FreeFollowUpConsultationManager::getRemainingConsultations( $user_id );
    return 'Remaining free consultations: ' . $remaining_count;	
	
    if ($remaining_count > 0) {            
		return '<div class="contentbox promobox-container" style="display: flex; align-items: center;">
						<img src="https://members.twinflamescoach.com/wp-content/uploads/2024/02/16x16-icon-45590.png" style="width: 34px; height: auto;" />
						<a href="https://members.twinflamescoach.com/product/15-min-follow-up/">Free 15-min follow-up available</a>
					</div>';
	}
}

// Register the shortcode
add_shortcode('free_follow_up', 'free_follow_up_shortcode');
