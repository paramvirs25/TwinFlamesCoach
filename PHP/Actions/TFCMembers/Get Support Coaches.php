<?php

add_action('rest_api_init', function () {

    register_rest_route('tfc/v1', '/users', [
        'methods'  => 'GET',
        'callback' => 'tfc_get_users',
        'permission_callback' => '__return_true',
    ]);

});

function tfc_get_users() {

   	$users = get_users([
    	'role'   => 'support',
    	'number' => 15
	]);

    $output = [];

    foreach ($users as $user) {

        $output[] = [
            'id'           => $user->ID,
            'display_name' => $user->display_name,
            'avatar'       => get_avatar_url($user->ID),
            'profile_url' => site_url('/profile/' . $user->user_nicename . '/'),
        ];
    }

    return rest_ensure_response($output);
}