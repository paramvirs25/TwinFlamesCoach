<?php
add_action( 'woocommerce_before_calculate_totals', 'apply_coupon_discounts', 10, 1 );

function apply_coupon_discounts( $cart ){
	// Check if user is logged in
    if ( !is_user_logged_in() ) {
		return;
    }

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }
	
	apply_course_completion_discount_via_coupon_on_consultation( $cart );
	
}

function apply_course_completion_discount_via_coupon_on_consultation( $cart ) {
	
    $product_id = 11782; // Set product ID for CONSULTATION product
	$product = wc_get_product($product_id);
	if ($product->get_id() != $product_id) { // only proceed if product is CONSULTATION
		return;
	}

    // Get logged-in user's roles
    $user = wp_get_current_user();
    $user_roles = $user->roles;

    // Get all courses and check if user has a matching role
    $courses = TFCMembers\Courses::getAllCourses();
	
	foreach ($courses as $course) {
		if (in_array($course->courseRoleName, $user_roles)) {
			//echo "<p>Course " . $course->courseName . "</p>";
			
            // User has this course's role, so apply discount via coupon code
            $coupon_code = $course->courseCompletionCouponForDiscount; // Set coupon code here
            $coupon = new WC_Coupon($coupon_code);
            if ($coupon->is_valid()) { // check if coupon is valid
                $cart->add_discount($coupon_code);
				wc_clear_notices(); // Clear coupon code applied notice
            }
        }
    }
}

>