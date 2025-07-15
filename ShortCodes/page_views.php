<?php
function tfc_combined_koko_views_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'add' => 0,
    ), $atts );

    $add = intval( $atts['add'] );
    $post_id = get_the_ID();

    if ( ! is_singular() || ! shortcode_exists( 'koko_analytics_counter' ) ) {
        return '';
    }

    // Use output buffering to capture the result of the Koko shortcode
    ob_start();
    echo do_shortcode( "[koko_analytics_counter days='3650' global='false' metric='pageviews']" );
    $koko_output = ob_get_clean();

    // Extract the numeric value from Koko's output
    preg_match( '/(\d[\d,]*)/', $koko_output, $matches );
    $koko_views = isset( $matches[1] ) ? intval( str_replace( ',', '', $matches[1] ) ) : 0;

    $total = $koko_views + $add;

    return '👁️ ' . number_format_i18n( $total ) . ' views';
}
add_shortcode( 'tfc_page_views', 'tfc_combined_koko_views_shortcode' );
