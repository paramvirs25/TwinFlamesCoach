<?php

/**
 * Calculate and display the price with optional discounts based on the user's location.
 *
 * @param array $atts
 * @return string HTML list of items
 */
function calculatePriceWithDiscount( $atts ) {
	$inrPrice = $atts['inr'];
	$discounts = $atts['discount'];
	$isShowDiscount = false;
	$currencySymbol = "INR ₹";
	$currencyMultiplier = 1;
	$output = "";

	if (is_null($inrPrice) || $inrPrice === '') {
		return $output;
	}

	// If the geotarget API exists
	if (function_exists('geot_target')) {

		// Calculate the final price by applying discounts, if any
		if (!is_null($discounts) && $discounts !== '') {
			$isShowDiscount = true;

			// Extract discounts from the 'discount' attribute
			$discounts = explode(',', $discounts);
			$discountValues = array();
			$classCounts = array();

			foreach ($discounts as $discount) {
				$discountPair = explode('=', $discount);
				if (count($discountPair) === 2) {
					$key = $discountPair[0];
					$value = $discountPair[1];
					if (strpos($key, 'classes') === 0) {
						$classCounts[] = $value;
					} elseif (strpos($key, 'discount') === 0) {
						$discountValues[] = $value;
					}
				}
			}			
		}

		// Format the price based on the user's country
		if (!geot_target('IN')) {
			// For the rest of the world in USD
			$currencySymbol = 'USD $';
			$currencyMultiplier = 0.02;
		}

		$beforeDiscountPriceFormated = number_format($inrPrice * $currencyMultiplier, 2);

		// Generate the HTML list of items
		$output = "<ul>";
		$output .= "<li>The cost for a single class is: $currencySymbol $beforeDiscountPriceFormated</li>";

		if ($isShowDiscount) {
			foreach ($classCounts as $index => $classCount) {
				$discountValue = $discountValues[$index];
				$totalCost = $inrPrice * $classCount;
				$discountAmount = $totalCost - ($totalCost * $discountValue / 100);
				$discountedPriceFormatted = number_format($discountAmount * $currencyMultiplier, 2);

				$output .= "<li>You can save $discountValue% when you sign up for $classCount classes. The total cost after the discount is: <br/><span><s>$currencySymbol $totalCost</s></span> <span style='color:#77a464;'>$currencySymbol $discountedPriceFormatted</span></li>";
			}
		}

		$output .= "</ul>";
	}

	return $output;
}
add_shortcode('country_price_discount', 'calculatePriceWithDiscount');


/**
 * Applies discount,
 *      currency symbol,
 *      Currency conversion
 * based on user location.
 *
 * @param [type] $atts
 * expected input attributes are
 *      inr - price in INR
 *      discount - percentage discount to be applied (in discount value is blank then no discount will be applied)
 * @return void
 * returns optput similar to following 
 * a. strikethrough(USD 700.00) USD 630.00 OR
 * b. strikethrough(INR 35,000.00) INR 31,500.00
 */
function calculatePrice( $atts ) {
	$inrPrice = $atts['inr'];
    $discount = $atts['discount'];
    $isShowDiscount = false;    
    $currencySymbol = "INR ₹";
    $currencyMultiplier = 1;
	$out = "";
	
	if (is_null($inrPrice) || $inrPrice === '') {
		return $out;
	}
	
    //if geotarget API exists
	if( function_exists( 'geot_target' ) ) {

        //Calculate the final price by apply discount if any
        if (!is_null($discount) && $discount !== '') {
            $isShowDiscount = true;
            $discountedPrice = $inrPrice - ($inrPrice * $discount / 100);
        }

        //format price based on country
		if( !geot_target( 'IN' ) ) { //Rest of the world in USD
            $currencySymbol = 'USD $';
            $currencyMultiplier = .02;			
		}

        $beforeDiscountPrice = number_format($inrPrice * $currencyMultiplier, 2);
        

        //optput strikethrough(USD $700.00) USD $630.00
        $out = sprintf("<span style='%s'><s>%s %s</s></span> <span style='color:#77a464;'>%s %s</span>", 
            $isShowDiscount ? '' : 'display:none',
            $currencySymbol, 
            $beforeDiscountPrice, 
            $currencySymbol, 
            number_format($discountedPrice * $currencyMultiplier, 2)
        );

	}
    
    return $out;
}
add_shortcode( 'country_price', 'calculatePrice' );
