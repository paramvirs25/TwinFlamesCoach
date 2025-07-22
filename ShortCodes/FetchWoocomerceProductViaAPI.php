<?php
function fetch_wc_product_via_api($atts)
{
    $atts = shortcode_atts([
        'id' => '',
    ], $atts);

    if (empty($atts['id'])) return 'Product ID not provided.';

    // Set your site URL and API credentials
    $site_url = 'https://members.twinflamescoach.com';
    $consumer_key = 'ck_eb1c121f64e16a8f9c640a09b235fe80c2d546f3'; // Replace with actual
    $consumer_secret = 'cs_3a5fdf29eaffa907f09b1722b4227699345c11ea'; // Replace with actual

    $api_url = $site_url . '/wp-json/wc/v3/products/' . $atts['id'] .
        '?consumer_key=' . $consumer_key .
        '&consumer_secret=' . $consumer_secret;

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return 'Error fetching product.';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (!$data || isset($data['code'])) {
        return 'Product not found or access denied.';
    }

    // Build output
    $output = '<div class="embedded-product" style="border:1px solid #ddd; padding:16px; max-width:700px; margin:0 0 24px 0;">';

    $output .= '<div style="display:flex; flex-wrap:wrap; align-items: flex-start;">';

    // Product Image (left column)
    if (!empty($data['images'][0]['src'])) {
        $output .= '<div style="flex: 0 0 200px; max-width:200px; margin-right:16px; margin-bottom:16px;">';
        $output .= '<img src="' . esc_url($data['images'][0]['src']) . '" style="width:100%; height:auto;" />';
        $output .= '</div>';
    }

    // Product Details (right column)
    $output .= '<div style="flex: 1 1 300px; min-width:0;">';

    // Product Name
    $output .= '<h3 style="margin-top:0;">' . esc_html($data['name']) . '</h3>';

    // Price (with Woo multi-currency HTML)
    if (!empty($data['price_html'])) {
        $output .= '<p>' . $data['price_html'] . '</p>';
    }

    // Short Description
    if (!empty($data['short_description'])) {
        $output .= '<div class="short-description" style="margin-bottom:10px;">' . wp_kses_post($data['short_description']) . '</div>';
    }

    // CTA Button
    $output .= '<a target="_blank" href="' . esc_url($data['permalink']) . '" class="button" style="display:inline-block; background:#0073aa; color:#fff; padding:8px 16px; text-decoration:none; border-radius:4px;">Book Now</a>';

    $output .= '</div>'; // close right column
    $output .= '</div>'; // close flex container

    $output .= '</div>'; // close outer box


    return $output;
}
add_shortcode('product_embed', 'fetch_wc_product_via_api');
