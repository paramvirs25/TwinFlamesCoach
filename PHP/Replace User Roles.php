<?php
namespace TFCMembers;

function approveNewUser(){
		echo "Approve new user starts -> <br/>";
		replaceUserRoles(
			'tfcnewstudent', 
			array( 'tfcnewstudent' ), 
			array( 'subscriber', 'general_instructions_iw', 'group_basic_iw_1' )
		);	
		echo "Approve new user ends!<br/>";
	}

	function giveAccessToBasicIWFirstClass(){
		echo "Access to Basic IW first class starts -> <br/>";
		replaceUserRoles(
			'group_basic_iw_1', 
			array(), 
			array( 'nasikagra', 'pastloversrelease_tool', 'innerchild_tool' )
		);	
		echo "Access to Basic IW first class ends!<br/>";
	}


	function onBasicIW1Complete(){
		echo "UpdateUserOnBasicIW1Complete starts -><br/>";
		
		replaceUserRoles(
			'group_basic_iw_1', 
			array( 'general_instructions_iw', 'nasikagra', 'innerchild_tool', 'pastloversrelease_tool', 'fearhealing_tool', 'jalandhar_bandha', 'belief_clearing_01_tool', 'reflect_transmute_tool', 'shambhavimudra', 'creative_visualization', 'harmony_heal_tool' ),
			array( 'basic_iw_1' ));
		
		echo "UpdateUserOnBasicIW1Complete ends<br/>";
	}

	function onBasicIW2Complete(){
		echo "UpdateUserOnBasicIW2Complete starts -><br/>";
		
		replaceUserRoles(
			'group_basic_iw_2', 
			array( 'tfciwchakrashuddhi', 'belief_clearing_2_tool', 'tfciwhigherheart', 
				'tfciwlocation', 'angels_blessings_tool', 
				'tfciwsound', 'tfciwcosmicmarriage' ),
			array( 'tfciw' ));
		
		echo "UpdateUserOnBasicIW2Complete ends<br/>";
	}

	//$search_by_user_role - Define the role to search for
	//$roles_to_remove - Define the list of roles to remove from the users
	//$roles_to_add - Define the list of roles to add to the users
	function replaceUserRoles($search_by_user_role, $roles_to_remove, $roles_to_add) {
		$newline = '<br/>';
		$hrtag = "<hr/>";
		
		if( !isset($search_by_user_role) || !isset($roles_to_remove) || !isset($roles_to_add)){
			echo 'It seems input variables are not properly set. No users are being updated!';
			return;
		}
	  	
		// Get the list of users with the search role
		$user_query = new WP_User_Query( array( 'role' => $search_by_user_role ) );
		$users = $user_query->get_results();

		// Loop through the users and remove the specified roles
		foreach ( $users as $user ) {
			$user_id = $user->ID;
			$user_roles = $user->roles;
			
			echo "<div class='contentbox'> User first name: ";
			echo $user->first_name; 
			echo $hrtag;
			
			// remove roles
			foreach ( $roles_to_remove as $role ) {
				if (in_array($role, $user_roles)) {
				  	// role already exists in $user_roles, so delete it
				  	$user->remove_role( $role );
					
					echo "Removed Role name: ";
					echo $role; echo $newline;
				}
			}
			
			echo $hrtag;

			// Add the new roles
			foreach ( $roles_to_add as $role ) {
				// role dont exists in $user_roles, so add it
				if (!in_array($role, $user_roles)) {
					$user->add_role( $role );
					
					echo "Added Role name: ";
					echo $role; echo $newline;
				}
			}			
			
			echo "</div>";
		}
	}
?>