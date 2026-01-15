<?php
function tfc_remote_product_reviews_slider($atts)
{
    $atts = shortcode_atts([
        'product_id' => '',
        'limit' => 10,
    ], $atts);

    if (empty($atts['product_id'])) {
        return 'Product ID not provided.';
    }

    $site_url = 'https://members.twinflamescoach.com';
    $consumer_key = 'ck_eb1c121f64e16a8f9c640a09b235fe80c2d546f3';
    $consumer_secret = 'cs_3a5fdf29eaffa907f09b1722b4227699345c11ea';

    // ✅ CORRECT ENDPOINT
    $api_url = $site_url . '/wp-json/wc/v3/products/reviews'
        . '?product=' . intval($atts['product_id'])
        . '&per_page=' . intval($atts['limit'])
        . '&consumer_key=' . $consumer_key
        . '&consumer_secret=' . $consumer_secret;

    $response = wp_remote_get($api_url, ['timeout' => 20]);

    if (is_wp_error($response)) {
        return 'Unable to fetch reviews.';
    }

    $reviews = json_decode(wp_remote_retrieve_body($response), true);

    if (empty($reviews) || isset($reviews['code'])) {
        return '';
    }

    ob_start();
    ?>

    

    <div class="tfc-review-slider">

        <?php foreach ($reviews as $review): ?>

            <div class="tfc-review-card">
                <div class="tfc-review-header">
                    <div class="tfc-review-avatar">
                        <?php if (!empty($review['reviewer_avatar_urls']['96'])): ?>
                            <img src="<?php echo esc_url($review['reviewer_avatar_urls']['96']); ?>">
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="tfc-review-name">
                            <?php echo esc_html($review['reviewer']); ?>
                        </div>
                        <?php if (!empty($review['rating'])): ?>
                            <div class="tfc-review-stars">
                                <?php echo str_repeat('★', intval($review['rating'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="tfc-review-content">
                    <?php echo wp_kses_post(wpautop($review['review'])); ?>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('product_reviews_slider', 'tfc_remote_product_reviews_slider');
