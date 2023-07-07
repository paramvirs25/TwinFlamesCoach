<?php
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
?>