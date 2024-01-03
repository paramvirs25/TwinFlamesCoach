<?php

/**
 * For twinflamescoach.com
 * Change the Focus Keyword Limit
 */
add_filter( 'rank_math/focus_keyword/maxtags', function() {
    return 10; // Number of Focus Keywords. 
});

/**
 * For Members.twinflamescoach.com
 * Missing field ‘hasMerchantReturnPolicy’ (in ‘offers’)
 */
add_filter( 'rank_math/snippet/rich_snippet_product_entity', function( $entity ) {
    $entity['offers']['hasMerchantReturnPolicy'] = false;
    return $entity;
});

?>