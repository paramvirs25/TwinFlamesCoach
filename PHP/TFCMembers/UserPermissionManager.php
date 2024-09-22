<?php
namespace TFCMembers;

class UserPermissionManager {

	const onbiw1_complete_roles_to_remove = array( 'general_instructions_iw', 'nasikagra', 'innerchild_tool', 'pastloversrelease_tool', 'fearhealing_tool', 'jalandhar_bandha', 'belief_clearing_01_tool', 'reflect_transmute_tool', 'shambhavimudra', 'creative_visualization', 'harmony_heal_tool' );
	const onbiw1_complete_roles_to_add = array( 'basic_iw_1','followup' );

	public static function approveNewGroupUsersForWorkshop(){
		$output = "approveNewGroupUsersForWorkshop starts -> <br/>";		
		$output .= UserPermissionManager::updateGroupUsers(
			'tfcnewstudent', 
			array( 'tfcnewstudent' ), 
			array( 'subscriber', 'tools' ),
			false
		);	
		$output .= "approveNewGroupUsersForWorkshop ends!<br/>";
		
		return $output;
	}

	public static function approveNewGroupUsersForBIW1(){
		$output = "approveNewGroupUsersForBIW1 starts -> <br/>";		
		$output .= UserPermissionManager::updateGroupUsers(
			'tfcnewstudent', 
			array( 'tfcnewstudent' ), 
			array( 'subscriber', 'general_instructions_iw', 'group_basic_iw_1' ),
			false
		);	
		$output .= "approveNewGroupUsersForBIW1 ends!<br/>";
		
		return $output;
	}

	// public static function giveGroupUsersAccessToBasicIWFirstClass(){
	// 	$output = "giveGroupUsersAccessToBasicIWFirstClass starts -> <br/>";
	// 	$output .= UserPermissionManager::updateGroupUsers(
	// 		'group_basic_iw_1', 
	// 		array(), 
	// 		array( 'nasikagra', 'innerchild_tool' ),
	// 		false
	// 	);	
	// 	$output .= "giveGroupUsersAccessToBasicIWFirstClass ends!<br/>";
		
	// 	return $output;
	// }	

	// public static function onGroupBasicIW1Complete(){
	// 	$output = "onGroupBasicIW1Complete starts -><br/>";

	// 	$output .= UserPermissionManager::updateGroupUsers(
	// 		'group_basic_iw_1', 
	// 		UserPermissionManager::onbiw1_complete_roles_to_remove,
	// 		UserPermissionManager::onbiw1_complete_roles_to_add,
	//		false
	// 	);
		
	// 	$output .= "onGroupBasicIW1Complete ends<br/>";
		
	// 	return $output;
	// }

	public static function onGroupBasicIW2Complete(){
		$output = "onGroupBasicIW2Complete starts -><br/>";
		
		$output .= UserPermissionManager::updateGroupUsers(
			'group_basic_iw_2', 
			array( 'tfciwchakrashuddhi', 'belief_clearing_2_tool', 'tfciwhigherheart', 'tfciwlocation', 'angels_blessings_tool', 'tfciwsound', 'tfciwcosmicmarriage' ),
			array( 'tfciw','followup' ),
			true
		);
		
		$output .= "onGroupBasicIW2Complete ends<br/>";
		
		return $output;
	}

	public static function onGroupAdvTfHealComplete(){
		$output = "onGroupAdvTfHealComplete starts -><br/>";
		
		$output .= UserPermissionManager::updateGroupUsers(
			'group_advance_tf_healings', 
			array( 'group_advance_tf_healings' ),
			array( 'advanced_twin_flame_healings_1','followup' ),
			true
		);
		
		$output .= "onGroupAdvTfHealComplete ends<br/>";
		
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

		$output .= UserPermissionManager::replaceUserRoles(
			$user, 
			UserPermissionManager::onbiw1_complete_roles_to_remove,
			UserPermissionManager::onbiw1_complete_roles_to_add
		);

		//Granting free Consultation
		$output .= UserPermissionManager::grantFreeConsultations($user);
		//$remaining_count = FreeFollowUpConsultationManager::grantFreeConsultations( $user_id );
		//$output .= "Added one free consultation.Remaining free consultation(s) are: " . $remaining_count .	"<br/>";
		
		$output .= "UpdateUserOnBasicIW1Complete ends<br/>";
		
		return $output;
	}

	public static function useUserConsultation( $user_id ) {
		$output = "Use User Consultation - starts -> <br/>";

		//Retrieving remaining Consultation Count
		$remaining_count = FreeFollowUpConsultationManager::getRemainingConsultations( $user_id );
		$output .= "Remaining free consultation(s) are: " . $remaining_count .	"<br/>";

		//use one consultation
		FreeFollowUpConsultationManager::useConsultation($user_id);

		////Retrieving remaining Consultation Count after using one consultation
		$remaining_count = FreeFollowUpConsultationManager::getRemainingConsultations( $user_id );
		$output .= "Removed one free consultation. Remaining free consultation(s) are: " . $remaining_count .	"<br/>";

		$output .= "Use User Consultation - ends!<br/>";
		
		return $output;
	}

	//$search_by_group_role - Define the role to search for
	//$roles_to_remove - Define the list of roles to remove from the users
	//$roles_to_add - Define the list of roles to add to the users
	private static function updateGroupUsers($search_by_group_role, $roles_to_remove, $roles_to_add, bool $isGrantFreeConsultations) {
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
			$output .= UserPermissionManager::replaceUserRoles($user, $roles_to_remove, $roles_to_add);

			if($isGrantFreeConsultations){
				//Granting free Consultation
				//$remaining_count = FreeFollowUpConsultationManager::grantFreeConsultations( $user->ID );
				//$output .= "Added one free consultation.Remaining free consultation(s) are: " . $remaining_count .	"<br/>";

				$output .= UserPermissionManager::grantFreeConsultations($user);
			}
		}

		return $output;
	}

	private static function replaceUserRoles($user, $roles_to_remove, $roles_to_add){
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

	private static function grantFreeConsultations($user){
		$output = "";

		//Granting free Consultation
		$remaining_count = FreeFollowUpConsultationManager::grantFreeConsultations( $user->ID );
		$output .= "Added one free consultation.Remaining free consultation(s) are: " . $remaining_count .	"<br/>";

		return $output;
	}
}
