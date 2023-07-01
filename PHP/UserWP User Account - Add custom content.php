<?php
add_filter('uwp_account_available_tabs', 'uwp_account_available_tabs_cb', 10, 1);
function uwp_account_available_tabs_cb($tabs){

	$tabs['new-tab'] = array(
		'title' => __( 'Certificates', 'userswp' ),
		'icon'  => 'fa fa-certificate',
	);

    return $tabs;
}

add_filter('uwp_account_page_title', 'uwp_account_page_title_cb', 10, 2);
function uwp_account_page_title_cb($title, $type){
	if ( $type == 'new-tab' ) {
		$title = __( 'All Certificates', 'uwp-messaging' );
	}

	return $title;
}

add_filter('uwp_account_form_display', 'uwp_account_form_display_cb', 10, 1);
function uwp_account_form_display_cb($type){
	if ( $type == 'new-tab' ) {
        //echo 'Your custom content goes here...';
        echo display_user_certificates();
	}
}

function display_user_certificates() {
	
    $user = uwp_get_displayed_user();
	$meta_prefix = "uwp_meta_";	
	$returnHTML = "<i>Note: Starting from 2023, if you have completed any certification programs, you can view and download your certificates by by clicking links below:</i><br/><hr/>";
	
	//Chakra balancing certificate
	$chakraBalanceCertUrl = get_user_meta( $user->ID, $meta_prefix."chakra_balancing_certificate_url", true );
	if($chakraBalanceCertUrl != "" && $chakraBalanceCertUrl != "#"){
		$returnHTML = $returnHTML.sprintf("<p><a href='%s' target='_new'>Download Chakra Balancing & Healing Certificate</a></p>", $chakraBalanceCertUrl);
	}

	$lifeCoachCertUrl = get_user_meta( $user->ID, $meta_prefix."life_coach_certificate_url", true );
	if($lifeCoachCertUrl != "" && $lifeCoachCertUrl != "#"){
		$returnHTML = $returnHTML.sprintf("<p><a href='%s' target='_new'>Download Life Coach Certificate</a></p>", $lifeCoachCertUrl);
	}
	
	//return get_user_meta( $user->ID, "uwp_meta_chakra_balancing_certificate_url", true );
	//return $chakraBalanceCertUrl;
	return $returnHTML;
}

?>