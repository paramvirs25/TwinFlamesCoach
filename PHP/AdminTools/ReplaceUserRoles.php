<?php
namespace TFCMembers;

class UserRoles {

	const onbiw1_complete_roles_to_remove = array( 'general_instructions_iw', 'nasikagra', 'innerchild_tool', 'pastloversrelease_tool', 'fearhealing_tool', 'jalandhar_bandha', 'belief_clearing_01_tool', 'reflect_transmute_tool', 'shambhavimudra', 'creative_visualization', 'harmony_heal_tool' );
	const onbiw1_complete_roles_to_add = array( 'basic_iw_1','followup' );

	public static function approveNewUser(){
		$output = "Approve new user starts -> <br/>";		
		$output .= UserRoles::replaceGroupUsersRoles(
			'tfcnewstudent', 
			array( 'tfcnewstudent' ), 
			array( 'subscriber', 'general_instructions_iw', 'group_basic_iw_1' )
		);	
		$output .= "Approve new user ends!<br/>";
		
		return $output;
	}

	public static function giveAccessToBasicIWFirstClass(){
		$output = "Access to Basic IW first class starts -> <br/>";
		$output .= UserRoles::replaceGroupUsersRoles(
			'group_basic_iw_1', 
			array(), 
			array( 'nasikagra', 'innerchild_tool' )
		);	
		$output .= "Access to Basic IW first class ends!<br/>";
		
		return $output;
	}	

	public static function onGroupBasicIW1Complete(){
		$output = "UpdateGroupUserOnBasicIW1Complete starts -><br/>";

		$output .= UserRoles::replaceGroupUsersRoles(
			'group_basic_iw_1', 
			UserRoles::onbiw1_complete_roles_to_remove,
			UserRoles::onbiw1_complete_roles_to_add
		);
		
		$output .= "UpdateGroupUserOnBasicIW1Complete ends<br/>";
		
		return $output;
	}

	public static function onUserBasicIW1Complete($user_id){
		$output = "UpdateUserOnBasicIW1Complete starts -><br/>";

		if( !isset($user_id)){
			$output .= 'It seems input variables are not properly set. No users are being updated!';
			return $output;
		}

		// Get user information based on user ID
		$user = get_user_by('ID', $user_id);

		$output .= UserRoles::replaceUserRoles(
			$user, 
			UserRoles::onbiw1_complete_roles_to_remove,
			UserRoles::onbiw1_complete_roles_to_add
		);
		
		$output .= "UpdateUserOnBasicIW1Complete ends<br/>";
		
		return $output;
	}

	public static function onBasicIW2Complete(){
		$output = "UpdateUserOnBasicIW2Complete starts -><br/>";
		
		$output .= UserRoles::replaceGroupUsersRoles(
			'group_basic_iw_2', 
			array( 'tfciwchakrashuddhi', 'belief_clearing_2_tool', 'tfciwhigherheart', 'tfciwlocation', 'angels_blessings_tool', 'tfciwsound', 'tfciwcosmicmarriage' ),
			array( 'tfciw' )
		);
		
		$output .= "UpdateUserOnBasicIW2Complete ends<br/>";
		
		return $output;
	}

	//$search_by_group_role - Define the role to search for
	//$roles_to_remove - Define the list of roles to remove from the users
	//$roles_to_add - Define the list of roles to add to the users
	public static function replaceGroupUsersRoles($search_by_group_role, $roles_to_remove, $roles_to_add) {
		$output = "";

		if( !isset($search_by_group_role) || !isset($roles_to_remove) || !isset($roles_to_add)){
			$output .= 'It seems input variables are not properly set. No users are being updated!';
			return $output;
		}

		// Get the list of users with the search role
		$user_query = new \WP_User_Query( array( 'role' => $search_by_group_role ) );
		$users = $user_query->get_results();

		// Loop through the users and remove the specified roles
		foreach ( $users as $user ) {
			$output .= UserRoles::replaceUserRoles($user, $roles_to_remove, $roles_to_add);
		}

		return $output;
	}

	public static function replaceUserRoles($user, $roles_to_remove, $roles_to_add){
		$newline = '<br/>';
		$hrtag = "<hr/>";
		$output = "";

		if( !isset($user) || !isset($roles_to_remove) || !isset($roles_to_add)){
			$output .= 'It seems input variables are not properly set. No users are being updated!';
			return $output;
		}

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

		return $output;
	}
}
