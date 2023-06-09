<?php
function woo_cart_ensure_only_one_item( $cart_contents ) {
    return array( end( $cart_contents ) );
}
add_filter( 'woocommerce_cart_contents_changed', 'woo_cart_ensure_only_one_item' );
?>