<?php
add_shortcode('admin_tools', function () {
    $out = "";

    if (!empty($_GET['act'])) {
        switch ($_GET['act']) {
            case 'workshop_approve':
                $out .= TFCMembers\UserPermissionManager::approveNewGroupUsersForWorkshop();
                break;
            case 'bw1approve':
                $out .= TFCMembers\UserPermissionManager::approveNewGroupUsersForBIW1();
                break;
            // case 'bw1class':
            //     $out .= TFCMembers\UserPermissionManager::giveGroupUsersAccessToBasicIWFirstClass();
            //     break;
            // case 'groupbiw1comp':
            //     $out .= TFCMembers\UserPermissionManager::onGroupBasicIW1Complete();
            //     break;
            case 'biw2comp':
                $out .= TFCMembers\UserPermissionManager::onGroupBasicIW2Complete();
                break;
            case 'userbiw1comp':
                // Check if 'user_id' is set in the query string
                $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
                $out .= TFCMembers\UserPermissionManager::onUserBasicIW1Complete($userId);
                break;            
            case 'use_user_consultation': //decrease free consultation counter
                // Check if 'user_id' is set in the query string
                $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
                $out .= TFCMembers\UserPermissionManager::useUserConsultation($userId);
                break;
        }
    } else {
        // Use heredoc syntax for cleaner HTML
        $out = <<<HTML
        <form action="/admin-tools/" method="get" name="admintools">
          <input type="hidden" name="act" value="run">
		  
		<div class="contentbox">
		  	<h2>Tools operating on User ID</h2>
		  
		  	<p>
                <label>User Id</label> 
		  	    <input type="text" id="user_id" name="user_id" />			  
			</p>
			<p><input type="submit" value="User Basic Inner Work 1 Complete" onclick="document.forms['admintools'].act.value = 'userbiw1comp' "></p>
            <p><input type="submit" value="Use USer 1 consultation" onclick="document.forms['admintools'].act.value = 'use_user_consultation' "></p>
		</div>

		<div class="contentbox">
		  <h2>Tools operating on User Group</h2>
		  <p><input type="submit" value="Approve New Users for Workshops" onclick="document.forms['admintools'].act.value = 'workshop_approve' "></p>

          <p><input type="submit" value="Approve New Users for Basic IW" onclick="document.forms['admintools'].act.value = 'bw1approve' "></p>
          
          <!-- <p><input type="submit" value="Give Access to Basic IW first class" onclick="document.forms['admintools'].act.value = 'bw1class' "></p> -->
          
          <!-- <p><input type="submit" value="Group Basic Inner Work 1 Complete" onclick="document.forms['admintools'].act.value = 'groupbiw1comp' ">(NOT-TESTED For Free Consultation Increment)</p> -->
          
          <p><input type="submit" value="Group Basic Inner Work 2 Complete" onclick="document.forms['admintools'].act.value = 'biw2comp' ">(NOT-TESTED For Free Consultation Increment)</p>
		</div>
        </form>
HTML;
    }

    return $out;
});
