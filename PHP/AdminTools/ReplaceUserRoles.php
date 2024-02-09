<?php
//namespace TFCMembers;

function approveNewUser(){
	$output = "Approve new user starts -> <br/>";
	$output .= replaceUsersRoles(
		'tfcnewstudent', 
		array( 'tfcnewstudent' ), 
		array( 'subscriber', 'general_instructions_iw', 'group_basic_iw_1' )
	);	
	$output .= "Approve new user ends!<br/>";
	
	return $output;
}

function giveAccessToBasicIWFirstClass(){
	$output = "Access to Basic IW first class starts -> <br/>";
	$output .= replaceUsersRoles(
		'group_basic_iw_1', 
		array(), 
		array( 'nasikagra', 'innerchild_tool' )
	);	
	$output .= "Access to Basic IW first class ends!<br/>";
	
	return $output;
}

function onBasicIW1Complete(){
	$output = "UpdateUserOnBasicIW1Complete starts -><br/>";
	
	$output .= replaceUsersRoles(
		'group_basic_iw_1', 
		array( 'general_instructions_iw', 'nasikagra', 'innerchild_tool', 'pastloversrelease_tool', 'fearhealing_tool', 'jalandhar_bandha', 'belief_clearing_01_tool', 'reflect_transmute_tool', 'shambhavimudra', 'creative_visualization', 'harmony_heal_tool' ),
		array( 'basic_iw_1','followup' )
	);
	
	$output .= "UpdateUserOnBasicIW1Complete ends<br/>";
	
	return $output;
}

function onBasicIW2Complete(){
	$output = "UpdateUserOnBasicIW2Complete starts -><br/>";
	
	$output .= replaceUsersRoles(
		'group_basic_iw_2', 
		array( 'tfciwchakrashuddhi', 'belief_clearing_2_tool', 'tfciwhigherheart', 'tfciwlocation', 'angels_blessings_tool', 'tfciwsound', 'tfciwcosmicmarriage' ),
		array( 'tfciw' )
	);
	
	$output .= "UpdateUserOnBasicIW2Complete ends<br/>";
	
	return $output;
}

//$search_by_user_role - Define the role to search for
//$roles_to_remove - Define the list of roles to remove from the users
//$roles_to_add - Define the list of roles to add to the users
function replaceUsersRoles($search_by_user_role, $roles_to_remove, $roles_to_add) {
	$output = "";

	if( !isset($search_by_user_role) || !isset($roles_to_remove) || !isset($roles_to_add)){
		$output .= 'It seems input variables are not properly set. No users are being updated!';
		return $output;
	}

	// Get the list of users with the search role
	$user_query = new WP_User_Query( array( 'role' => $search_by_user_role ) );
	$users = $user_query->get_results();

	// Loop through the users and remove the specified roles
	foreach ( $users as $user ) {
		$output .= replaceUserRoles($user, $roles_to_remove, $roles_to_add);
	}

	return $output;
}

function replaceUserRoles($user, $roles_to_remove, $roles_to_add){
	$newline = '<br/>';
	$hrtag = "<hr/>";
	$output = "";

	$user_id = $user->ID;
	$user_roles = $user->roles;

	$output .= "<div class='contentbox'> User first name: ";
	$output .= $user->first_name; 
	$output .= $hrtag;

	// remove roles
	foreach ( $roles_to_remove as $role ) {
		if (in_array($role, $user_roles)) {
			// role already exists in $user_roles, so delete it
			$user->remove_role( $role );

			$output .= "Removed Role name: ";
			$output .= $role; $output .= $newline;
		}
	}

	$output .= $hrtag;

	// Add the new roles
	foreach ( $roles_to_add as $role ) {
		// role dont exists in $user_roles, so add it
		if (!in_array($role, $user_roles)) {
			$user->add_role( $role );

			$output .= "Added Role name: ";
			$output .= $role; $output .= $newline;
		}
	}			

	$output .= "</div>";
}
