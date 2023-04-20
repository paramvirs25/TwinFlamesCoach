<?php
add_filter('uwp_excluded_users_from_list', 'uwp_excluded_users_from_list_cb', 10, 1);
function uwp_excluded_users_from_list_cb($exclude_users){
	$users = get_users( array( 'role__not_in' => array( 'support'), 'fields' => array('ID') ) );
	$users = wp_list_pluck( $users, 'ID' );
	if($users && count($users) > 0){
        return array_merge($exclude_users, $users);
    }
	return $exclude_users;
}

>