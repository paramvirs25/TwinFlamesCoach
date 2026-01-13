<?php
function tfc_product_reviews($atts)
{
    $atts = shortcode_atts([
        'product_id' => '',
        'limit' => 3,
        'all_reviews_url' => '',
    ], $atts);

    if (empty($atts['product_id'])) return '';

    $site_url = 'https://members.twinflamescoach.com';
    $consumer_key = 'ck_eb1c121f64e16a8f9c640a09b235fe80c2d546f3';
    $consumer_secret = 'cs_3a5fdf29eaffa907f09b1722b4227699345c11ea';

    $api_url = $site_url . '/wp-json/wc/v3/products/reviews'
        . '?product=' . intval($atts['product_id'])
        . '&per_page=' . intval($atts['limit'])
        . '&orderby=date'
        . '&order=desc'
        . '&consumer_key=' . $consumer_key
        . '&consumer_secret=' . $consumer_secret;

    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) return '';

    $reviews = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($reviews) || isset($reviews['code'])) return '';

    ob_start();
    ?>

    <div class="tfc-vertical-reviews">

        <?php foreach ($reviews as $review): ?>
            <div class="tfc-vertical-review-item">

                <div class="tfc-review-header">
                    <?php if (!empty($review['reviewer_avatar_urls']['96'])): ?>
                        <img
                            class="tfc-avatar"
                            src="<?php echo esc_url($review['reviewer_avatar_urls']['96']); ?>"
                            alt="<?php echo esc_attr($review['reviewer']); ?>"
                        >
                    <?php endif; ?>

                    <div>
                        <div class="tfc-reviewer-name">
                            <?php echo esc_html($review['reviewer']); ?>
                        </div>

                        <?php if (!empty($review['rating'])): ?>
                            <div class="tfc-stars">
                                <?php echo str_repeat('★', intval($review['rating'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="tfc-review-text">
                    <?php echo wp_kses_post(wpautop($review['review'])); ?>
                </div>

            </div>
        <?php endforeach; ?>

        <?php if (!empty($atts['all_reviews_url'])): ?>
            <div class="tfc-all-reviews-link">
                <a href="<?php echo esc_url($atts['all_reviews_url']); ?>" class="tfc-button">
                    View all testimonials
                </a>
            </div>
        <?php endif; ?>

    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('product_reviews', 'tfc_product_reviews');
