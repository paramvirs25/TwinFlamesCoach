<?php
// Only Allow One Product In Cart
add_filter ('woocommerce_add_cart_item_data', 'wdm_empty_cart', 10, 3);
function wdm_empty_cart ($cart_item_data, $product_id, $variation_id) {
  global $woocommerce;
  $woocommerce->cart->empty_cart ();
  // Do nothing with the data and return
  return $cart_item_data;
}

/*Product deletion was not working with followinig code, so commented it */
// function woo_cart_ensure_only_one_item( $cart_contents ) {
//     return array( end( $cart_contents ) );
// }
// add_filter( 'woocommerce_cart_contents_changed', 'woo_cart_ensure_only_one_item' );
