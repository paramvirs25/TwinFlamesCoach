// Creates a subpage under the Tools section
<?php
add_action('admin_menu', 'wpdocs_register_my_api_keys_page');
function wpdocs_register_my_api_keys_page() {
    add_submenu_page(
        'tools.php',
        'API Keys',
        'API Keys',
        'manage_options',
        'api-keys',
        'add_api_keys_callback' );
}
 
// The admin page containing the form
function add_api_keys_callback() { ?>
    <div class="wrap"><div id="icon-tools" class="icon32"></div>
        <h2>My API Keys Page</h2>
        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">
            <h3>Your API Key</h3>
            <input type="text" name="api_key" placeholder="Enter API Key">
            <input type="hidden" name="action" value="process_form">			 
            <input type="submit" name="submit" id="submit" class="update-button button button-primary" value="Update API Key"  />
        </form> 
    </div>
    <?php
}

// Submit functionality
function submit_api_key() {
    if (isset($_POST['api_key'])) {
        $api_key = sanitize_text_field( $_POST['api_key'] );
        $api_exists = get_option('api_key');
        if (!empty($api_key) && !empty($api_exists)) {
            update_option('api_key', $api_key);
        } else {
            add_option('api_key', $api_key);
        }
    }
    wp_redirect($_SERVER['HTTP_REFERER']);
}
add_action( 'admin_post_nopriv_process_form', 'submit_api_key' );
add_action( 'admin_post_process_form', 'submit_api_key' );