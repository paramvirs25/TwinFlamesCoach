<?php
function fetch_wc_product_via_api($atts)
{
    $atts = shortcode_atts([
        'id' => '',
        'hide_product_image' => 'false',
        'hide_product_name' => 'false',
        'hide_price' => 'false',
        'hide_short_description' => 'false',
    ], $atts);

    if (empty($atts['id'])) return 'Product ID not provided.';

    // Normalize attributes to booleans
    $hide_image = filter_var($atts['hide_product_image'], FILTER_VALIDATE_BOOLEAN);
    $hide_name  = filter_var($atts['hide_product_name'], FILTER_VALIDATE_BOOLEAN);
    $hide_price = filter_var($atts['hide_price'], FILTER_VALIDATE_BOOLEAN);
    $hide_short_desc = filter_var($atts['hide_short_description'], FILTER_VALIDATE_BOOLEAN);

    // Set your site URL and API credentials
    $site_url = 'https://members.twinflamescoach.com';
    $consumer_key = 'ck_eb1c121f64e16a8f9c640a09b235fe80c2d546f3';
    $consumer_secret = 'cs_3a5fdf29eaffa907f09b1722b4227699345c11ea';

    $api_url = $site_url . '/wp-json/wc/v3/products/' . $atts['id'] .
        '?consumer_key=' . $consumer_key .
        '&consumer_secret=' . $consumer_secret;

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) return 'Error fetching product.';

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (!$data || isset($data['code'])) return 'Product not found or access denied.';

    // Build output
    $output = '<div class="embedded-product" style="border:1px solid #ddd; padding:16px; max-width:700px; margin:0 0 24px 0;">';

    $output .= '<div style="display:flex; flex-wrap:wrap; align-items: flex-start;">';

    // Product Image
    if (!$hide_image && !empty($data['images'][0]['src'])) {
        $output .= '<div style="flex: 0 0 200px; max-width:200px; margin-right:16px; margin-bottom:16px;">';
        $output .= '<img src="' . esc_url($data['images'][0]['src']) . '" style="width:100%; height:auto;" />';
        $output .= '</div>';
    }

    // Right Column
    $output .= '<div style="flex: 1 1 300px; min-width:0;">';

    // Product Name
    if (!$hide_name) {
        $output .= '<h3 style="margin-top:0;">' . esc_html($data['name']) . '</h3>';
    }

    // Price
    if (!$hide_price && !empty($data['price_html'])) {
        $output .= '<p>' . $data['price_html'] . '</p>';
    }

    // Short Description
    if (!$hide_short_desc && !empty($data['short_description'])) {
        $output .= '<div class="short-description" style="margin-bottom:10px;">' .
            wp_kses_post($data['short_description']) .
            '</div>';
    }

    // Button
    $output .= '<a target="_blank" href="' . esc_url($data['permalink']) . '" class="button" style="display:inline-block; background:#0073aa; color:#fff; padding:8px 16px; text-decoration:none; border-radius:4px;">Book Now</a>';

    $output .= '</div>'; // close right col
    $output .= '</div>'; // close flex
    $output .= '</div>'; // close wrapper

    return $output;
}
add_shortcode('product_embed', 'fetch_wc_product_via_api');
