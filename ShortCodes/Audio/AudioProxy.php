<?php
add_action('init', function() {
    add_rewrite_rule('^audio-proxy/([a-zA-Z0-9_-]+)/?', 'index.php?audio_file_id=$matches[1]', 'top');
});

add_filter('query_vars', function($vars) {
    $vars[] = 'audio_file_id';
    return $vars;
});

add_action('template_redirect', function() {
    $file_id = get_query_var('audio_file_id');
    if ($file_id) {
        if (!is_user_logged_in()) {
            wp_die('Access Denied', 'Error', ['response' => 403]);
        }

        $accessToken = get_google_access_token();
        if (!$accessToken) {
            wp_die('Failed to get access token', 'Error', ['response' => 500]);
        }

        $googleApiUrl = "https://www.googleapis.com/drive/v3/files/$file_id?alt=media";

        // Serve full file (no range support fallback)
        header('Content-Type: audio/mpeg');
        header('Accept-Ranges: none');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_exec($ch);
        curl_close($ch);

        exit();
    }
});


function get_google_access_token() {
	//Google drive credentials are stored by "_Store Credentials" snippet
    $client_id = get_option('tfc_google_drive_client_id');
    $client_secret = get_option('tfc_google_drive_client_secret');
    $refresh_token = get_option('tfc_google_drive_refresh_token');

    // Optionally, cache the access token for performance
    $cached_token = get_transient('google_drive_access_token');
    if ($cached_token) {
        return $cached_token;
    }

    $response = wp_remote_post('https://oauth2.googleapis.com/token', [
        'body' => [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        ],
    ]);

    if (is_wp_error($response)) {
        return false;  // Failed to get token
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($body['access_token'])) {
        // Cache the token for 1 hour (or the expiration time)
        set_transient('google_drive_access_token', $body['access_token'], 3600);
        return $body['access_token'];
    }

    return false;
}
