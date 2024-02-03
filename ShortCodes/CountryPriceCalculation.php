<?php
// Requires
// Class - Currency

/**
 * Calculate and display the price with optional discounts based on the user's location.
 * USAGE: [country_price_discount inr="6750" discount="classes1=3,discount1=5,classes2=6,discount2=10"]
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

	// Get currency symbol and currency multiplier
	$result = TFC\Currency::determineCurrency();
	$currencySymbol = $result['currencySymbol'];
	$currencyMultiplier = $result['currencyMultiplier'];

	// Generate the HTML list of items
	$output = "<ul>";
	$output .= "<li>The cost for a single class is: 
		<span style='color:#77a464;'>" . 
		TFC\Currency::formatCurrency($inrPrice, $currencySymbol, $currencyMultiplier) . 
		"</span></li>";

	if ($isShowDiscount) {
		foreach ($classCounts as $index => $classCount) {
			$discountValue = $discountValues[$index];
			$inrTotalCost = $inrPrice * $classCount;
			$inrDiscountAmount = $inrTotalCost - ($inrTotalCost * $discountValue / 100);
			
			$output .= "<li>You can save 
				<span style=\"color:#77a464;\">$discountValue%</span> when you sign up for 
				<span style=\"color:#77a464;\">$classCount classes</span>. 
				The total cost after the discount is: <br/>
				<span><s>" . TFC\Currency::formatCurrency($inrTotalCost, $currencySymbol, $currencyMultiplier) . "</s></span> 
				<span style=\"color:#77a464;\">" . TFC\Currency::formatCurrency($inrDiscountAmount, $currencySymbol, $currencyMultiplier) . "</span>
			</li>";

		}
	}

	$output .= "</ul>";

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
	$discountedPrice = 	$inrPrice;
    $isShowDiscount = false;    
    $currencySymbol = "INR ₹";
    $currencyMultiplier = 1;
	$out = "";
	
	if (is_null($inrPrice) || $inrPrice === '') {
		return $out;
	}

	//Calculate the final price by apply discount if any
	if (!is_null($discount) && $discount !== '') {
		$isShowDiscount = true;
		$discountedPrice = $inrPrice - ($inrPrice * $discount / 100);
	}

	// Get currency symbol and currency multiplier
	$result = TFC\Currency::determineCurrency();
	$currencySymbol = $result['currencySymbol'];
	$currencyMultiplier = $result['currencyMultiplier'];

	$beforeDiscountPrice = number_format($inrPrice * $currencyMultiplier, 2);
	

	//optput strikethrough(USD $700.00) USD $630.00
	$out = sprintf("<span style='%s'><s>%s %s</s></span> <span style='color:#77a464;'>%s %s</span>", 
		$isShowDiscount ? '' : 'display:none',
		$currencySymbol, 
		$beforeDiscountPrice, 
		$currencySymbol, 
		number_format($discountedPrice * $currencyMultiplier, 2)
	);
    
    return $out;
}
add_shortcode( 'country_price', 'calculatePrice' );
