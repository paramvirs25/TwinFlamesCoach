<?php
function tfc_combined_koko_views_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'add' => 0,
        ),
        $atts
    );

    $add     = intval( $atts['add'] );
    $post_id = get_the_ID();

    if ( ! is_singular() || ! $post_id ) {
        return '';
    }

    global $wpdb;

    /*
     * Koko Analytics post statistics table
     */
    $stats_table = $wpdb->prefix . 'koko_analytics_post_stats';

    /*
     * Get all pageviews associated with this WordPress Post ID.
     *
     * This includes historical data from the old path_id
     * as well as new data from the current path_id.
     */
    $koko_views = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT COALESCE( SUM(pageviews), 0 )
            FROM {$stats_table}
            WHERE post_id = %d
            ",
            $post_id
        )
    );

    $koko_views = intval( $koko_views );

    /*
     * Add any manually supplied adjustment.
     */
    $total = $koko_views + $add;

    /*
     * Display the result.
     */
    return '👁️ ' . number_format_i18n( $total ) . ' views';
}

add_shortcode(
    'tfc_page_views',
    'tfc_combined_koko_views_shortcode'
);