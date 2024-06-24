<?php
add_action( 'woocommerce_before_calculate_totals', 'apply_auto_coupon_discounts', 10, 1 );

function apply_auto_coupon_discounts( $cart ){
	// Check if user is logged in
    if ( !is_user_logged_in() ) {
		return;
    }

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }
	
	// Check if current page is the cart page
	if ( ! is_cart() ) {
		return;
	}
	
	//Personal Consultation | Jnana Param or Ritu Om
	if (is_cart_contains_product( $cart, 
		TFCMembers\Products::PERSONAL_CONSULTATION_PARAM_ID, 
		TFCMembers\Products::PERSONAL_CONSULTATION_RITU_ID ) ) {
		apply_course_completion_discount_via_coupon_on_consultation( $cart );
	}
	// else if(is_cart_contains_product( $cart, TFCMembers\Products::BASIC_IW_1_ID ) ) { //Basic IW 1
	// 	$course = TFCMembers\Courses::getBasicIw1();
	// 	apply_repeater_discount( $cart, $course );
	// }
	// else if(is_cart_contains_product( $cart, TFCMembers\Products::TWIN_FLAMES_COACH_ID  ) ) { //Twin Flames Coach
	// 	$course = TFCMembers\Courses::getCertifiedCoach();
	// 	apply_repeater_discount( $cart, $course );
	// }
	
}

function apply_course_completion_discount_via_coupon_on_consultation( $cart ) {
	
    // Get logged-in user's roles
    $user = wp_get_current_user();
    $user_roles = $user->roles;

    // Get all courses and check if user has a matching role
    $courses = TFCMembers\Courses::getAllCourses();
	
	foreach ($courses as $course) {
		if (in_array($course->courseRoleName, $user_roles)) {
			//echo "<p>Course " . $course->courseName . "</p>";

			apply_coupon($cart, $course->courseCompletionCouponForDiscount);
        }
    }
}

function apply_repeater_discount( $cart, $course ) {
	
    // Get logged-in user's roles
    $user = wp_get_current_user();
    $user_roles = $user->roles;

    if (in_array($course->courseRoleName, $user_roles)) {
		//echo "<p>Course " . $course->courseName . "</p>";
		apply_coupon($cart, "repeater");
	}
}

function is_cart_contains_product( $cart, $product_id1, $product_id2 ){
	$cart_contains_product = false;
	foreach ( $cart->get_cart_contents() as $item ) {
		if ( $item['product_id'] == $product_id1 || $item['product_id'] == $product_id2 ) {
			$cart_contains_product = true;
			break;
		}
	}
	
	return $cart_contains_product;
}

function apply_coupon($cart, $coupon_code){
	
	$coupon = new WC_Coupon($coupon_code);
	//$coupon->set_remove_message(''); //dont show any mesage when coupon is removed from cart.
	if ($coupon->is_valid()) { // check if coupon is valid				
		$cart->add_discount($coupon_code);
		wc_clear_notices(); // Clear coupon code applied notice				
	}
}
