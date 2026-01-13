<?php
// add_shortcode('debug_testimonial_meta', function () {

//     if (!current_user_can('manage_options')) {
//         return '';
//     }

//     $posts = get_posts([
//         'post_type' => 'wpm-testimonial',
//         'posts_per_page' => 1,
//         'post_status' => 'publish',
//     ]);

//     if (empty($posts)) {
//         return 'No testimonial found.';
//     }

//     $meta = get_post_meta($posts[0]->ID);

//     $output = "<pre>";
//     foreach ($meta as $key => $value) {
//         $output .= esc_html($key) . " => " . esc_html(print_r($value, true)) . "\n";
//     }
//     $output .= "</pre>";

//     return $output;
// });


// 
// // add_shortcode('debug_taxonomies', function () {

//     if (!current_user_can('manage_options')) {
//         return '';
//     }

//     $taxes = get_taxonomies([], 'objects');

//     $output = "<pre>";
//     foreach ($taxes as $tax) {
//         $output .= esc_html($tax->name) . "\n";
//     }
//     $output .= "</pre>";

//     return $output;
// });


// add_shortcode('debug_post_types', function () {

//     if (!current_user_can('manage_options')) {
//         return '';
//     }

//     $types = get_post_types([], 'objects');

//     $output = "<pre>";
//     foreach ($types as $type) {
//         $output .= esc_html($type->name) . "\n";
//     }
//     $output .= "</pre>";

//     return $output;
// });



function tfc_export_strong_testimonials_csv_shortcode()
{
    if (!current_user_can('manage_options')) {
        return 'Access denied.';
    }

    // Confirmed slugs
    $testimonial_post_type = 'wpm-testimonial';
    $testimonial_taxonomy  = 'wpm-testimonial-category';

    // 🔴 UPDATE THIS if your meta key differs
    $reviewer_name_meta_key = 'client_name';

    $rows = [];

    $rows[] = [
        'reviewer_name',
        'review_text',
        'product_slug',
        'review_date',
        'rating'
    ];

    $testimonials = get_posts([
        'post_type'      => $testimonial_post_type,
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    foreach ($testimonials as $testimonial) {

        $terms = wp_get_post_terms($testimonial->ID, $testimonial_taxonomy);
        if (empty($terms) || is_wp_error($terms)) {
            continue;
        }

        $product_slug = $terms[0]->slug;

        // ✅ Correct reviewer name
        $reviewer_name = get_post_meta(
            $testimonial->ID,
            $reviewer_name_meta_key,
            true
        );

        if (empty($reviewer_name)) {
            $reviewer_name = 'Student';
        }

        $rows[] = [
            $reviewer_name,
            trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($testimonial->post_content))),
            $product_slug,
            $testimonial->post_date,
            5
        ];
    }

    $csv_output = '';
    foreach ($rows as $row) {
        $escaped = array_map(function ($field) {
            $field = str_replace('"', '""', $field);
            return '"' . $field . '"';
        }, $row);

        $csv_output .= implode(',', $escaped) . "\n";
    }

    ob_start();
    ?>
    <div style="max-width:100%; margin:20px 0;">
        <h3>Strong Testimonials → CSV Export</h3>
        <p>Copy everything below and save it as a <code>.csv</code> file.</p>

        <textarea
            style="width:100%; height:450px; font-family:monospace; font-size:13px;"
            onclick="this.select();"
        ><?php echo esc_textarea($csv_output); ?></textarea>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode('export_strong_testimonials_csv', 'tfc_export_strong_testimonials_csv_shortcode');
