<?php
function tfc_import_wc_reviews_from_csv_shortcode()
{
    if (!current_user_can('manage_options')) {
        return 'Access denied.';
    }

    // Slug → Product ID mapping
    $slug_to_product_id = [
		'attunement-kriya-kundalini-yoga' => 14644,
		'reprogram-mind' => 11797,
		
        'advanced-tf-healings' => 12622,
        'life-coach' => 13356,
        'twin-flame-inner-work-program-basic' => 11726,
        'chakra-healings-program' => 12256,
        'after-a-year' => 11726,
        'coaching-and-healing-session' => 11782,
        'difficult-divine-guidance' => 11805,
        'twin-flame-inner-work-apprentice' => 12485,
        'twin-flame-sexual-energy' => 13182,
    ];

    $report_html = '';

    if (isset($_POST['tfc_import_reviews'])) {

        $slug        = trim($_POST['product_slug'] ?? '');
        $max_per_run = max(1, intval($_POST['max_per_run'] ?? 1));

        if (empty($slug)) {
            $report_html = '<p style="color:red;">Product slug is required.</p>';
        } elseif (!isset($slug_to_product_id[$slug])) {
            $report_html = '<p style="color:red;">Unknown product slug.</p>';
        } elseif (empty($_FILES['csv_file']['tmp_name'])) {
            $report_html = '<p style="color:red;">Please upload a CSV file.</p>';
        } else {

            $product_id = $slug_to_product_id[$slug];
            $file = $_FILES['csv_file']['tmp_name'];

            $handle = fopen($file, 'r');
            if (!$handle) {
                $report_html = '<p style="color:red;">Unable to read uploaded file.</p>';
            } else {

                fgetcsv($handle); // skip header

                $imported_this_run = 0;
                $total_for_slug = 0;
                $already_imported = 0;

                while (($row = fgetcsv($handle)) !== false) {

                    if (count($row) < 5) continue;

                    [$name, $content, $row_slug, $date, $rating] = $row;

                    if ($row_slug !== $slug) continue;

                    $total_for_slug++;

                    $hash = md5($name . '|' . $content . '|' . $date);

                    $existing = get_comments([
                        'post_id' => $product_id,
                        'meta_key' => '_import_hash',
                        'meta_value' => $hash,
                        'count' => true,
                    ]);

                    if ($existing > 0) {
                        $already_imported++;
                        continue;
                    }

                    if ($imported_this_run >= $max_per_run) {
                        continue;
                    }

                    $comment_id = wp_insert_comment([
                        'comment_post_ID' => $product_id,
                        'comment_author' => sanitize_text_field($name),
                        'comment_content' => wp_kses_post($content),
                        'comment_status' => 'approve',
                        'comment_type' => 'review',
                        'comment_date' => sanitize_text_field($date),
                    ]);

                    if ($comment_id) {
                        add_comment_meta($comment_id, 'rating', intval($rating));
                        add_comment_meta($comment_id, '_import_source', 'strong_testimonials');
                        add_comment_meta($comment_id, '_import_slug', $slug);
                        add_comment_meta($comment_id, '_import_hash', $hash);
                        $imported_this_run++;
                    }
                }

                fclose($handle);

                $remaining = max(0, $total_for_slug - ($already_imported + $imported_this_run));

                $report_html = "
                    <div style='padding:12px; border:1px solid #ccc; margin-top:15px;'>
                        <strong>Import summary</strong><br>
                        Product slug: <code>{$slug}</code><br>
                        Product ID: {$product_id}<br><br>

                        Imported this run: <strong>{$imported_this_run}</strong><br>
                        Already imported earlier: {$already_imported}<br>
                        Remaining testimonials: {$remaining}
                    </div>
                ";
            }
        }
    }

    ob_start();
    ?>

    <form method="post" enctype="multipart/form-data" style="max-width:100%; margin:20px 0;">
        <h3>Incremental WooCommerce Review Import (CSV Upload)</h3>

        <p>
            <label><strong>Product Slug (one at a time)</strong></label><br>
            <input type="text" name="product_slug" style="width:100%; max-width:400px;">
        </p>

        <p>
            <label><strong>Max testimonials per run</strong></label><br>
            <input type="number" name="max_per_run" value="1" min="1" style="width:100px;">
        </p>

        <p>
            <label><strong>Upload CSV File</strong></label><br>
            <input type="file" name="csv_file" accept=".csv">
        </p>

        <p>
            <button type="submit" name="tfc_import_reviews" class="button button-primary">
                Import
            </button>
        </p>
    </form>

    <?php
    return $report_html . ob_get_clean();
}

add_shortcode('import_wc_reviews_from_csv', 'tfc_import_wc_reviews_from_csv_shortcode');
