<?php
add_action('admin_menu', function () {
    add_management_page(
        'Review Manager',
        'Review Manager',
        'manage_options',
        'review-manager',
        'tfc_review_manager_page'
    );
});

function tfc_review_manager_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Handle user assignment
    if (isset($_POST['assign_user'])) {
        $comment_id = intval($_POST['comment_id']);
        $user_id    = intval($_POST['user_id']);

        if ($comment_id && $user_id) {
            wp_update_comment([
                'comment_ID' => $comment_id,
                'user_id'    => $user_id,
            ]);

            echo '<div class="updated"><p>User assigned successfully.</p></div>';
        }
    }

    // Handle product move
    if (isset($_POST['move_review'])) {
        $comment_id     = intval($_POST['comment_id']);
        $new_product_id = intval($_POST['new_product_id']);

        if ($comment_id && $new_product_id) {
            wp_update_comment([
                'comment_ID'      => $comment_id,
                'comment_post_ID' => $new_product_id,
            ]);

            echo '<div class="updated"><p>Review moved to selected product.</p></div>';
        }
    }

    // Product selector
    $products = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $selected_product = intval($_GET['product_id'] ?? 0);
    ?>

    <div class="wrap">
        <h1>Review Manager</h1>

        <form method="get">
            <input type="hidden" name="page" value="review-manager">
            <label><strong>Select Product</strong></label>
            <select name="product_id" onchange="this.form.submit()">
                <option value="">-- Select product --</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product->ID; ?>"
                        <?php selected($selected_product, $product->ID); ?>>
                        <?php echo esc_html($product->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php
        if ($selected_product):

            $reviews = get_comments([
                'post_id' => $selected_product,
                'type'    => 'review',
                'status'  => 'approve',
                'number'  => 100,
            ]);

            if (empty($reviews)) {
                echo '<p>No reviews found for this product.</p>';
            } else {

                $users = get_users([
                    'orderby' => 'display_name',
                    'order'   => 'ASC',
                ]);
                ?>

                <table class="widefat striped" style="margin-top:20px;">
                    <thead>
                        <tr>
                            <th>Reviewer</th>
                            <th>Review</th>
                            <th>Linked User</th>
                            <th>Assign User</th>
                            <th>Move to Product</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?php echo esc_html($review->comment_author); ?></td>

                            <td><?php echo esc_html(wp_trim_words($review->comment_content, 18)); ?></td>

                            <td>
                                <?php
                                if ($review->user_id) {
                                    $u = get_user_by('id', $review->user_id);
                                    echo esc_html($u->display_name);
                                } else {
                                    echo '<em>Guest</em>';
                                }
                                ?>
                            </td>

                            <td>
                                <form method="post" style="display:flex; gap:6px;">
                                    <input type="hidden" name="comment_id" value="<?php echo $review->comment_ID; ?>">
                                    <select name="user_id">
                                        <option value="">Select user</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?php echo $user->ID; ?>">
                                                <?php
													$first = get_user_meta($user->ID, 'first_name', true);
													$last  = get_user_meta($user->ID, 'last_name', true);

													$name = trim($first . ' ' . $last);

													if (empty($name)) {
														$name = $user->display_name;
													}

													echo esc_html($name);
												?>

                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="assign_user" class="button">
                                        Assign
                                    </button>
                                </form>
                            </td>

                            <td>
                                <form method="post" style="display:flex; gap:6px;">
                                    <input type="hidden" name="comment_id" value="<?php echo $review->comment_ID; ?>">
                                    <select name="new_product_id">
                                        <option value="">Select product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?php echo $product->ID; ?>">
                                                <?php echo esc_html($product->post_title); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="move_review" class="button">
                                        Move
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>

        <?php
            }
        endif;
        ?>
    </div>
    <?php
}
