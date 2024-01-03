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
	
	if (is_cart_contains_product( $cart, 11782 ) ) { //Personal Consultation
		apply_course_completion_discount_via_coupon_on_consultation( $cart, 11782 );
	}
	else if(is_cart_contains_product( $cart, 11726 ) ) { //Basic IW 1
		$course = TFCMembers\Courses::getBasicIw1();
		apply_basicIW1_repeater_discount( $cart, 11726, $course );
	}
	
}

function apply_course_completion_discount_via_coupon_on_consultation( $cart, $product_id ) {
	
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

function apply_basicIW1_repeater_discount( $cart, $product_id, $course ) {
	
    // Check if cart contains this product
	if ( ! is_cart_contains_product( $cart, $product_id ) ) {
		return; // Terminate function if cart does not contain this product
	}

    // Get logged-in user's roles
    $user = wp_get_current_user();
    $user_roles = $user->roles;

    if (in_array($course->courseRoleName, $user_roles)) {
		//echo "<p>Course " . $course->courseName . "</p>";
		apply_coupon($cart, "repeaterbiw1");
	}
}

function is_cart_contains_product( $cart, $product_id ){
	$cart_contains_product = false;
	foreach ( $cart->get_cart_contents() as $item ) {
		if ( $item['product_id'] == $product_id ) {
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
