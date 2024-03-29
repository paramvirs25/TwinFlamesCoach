<?php
add_shortcode('admin_tools', function () {
    $out = "";

    if (!empty($_GET['act'])) {
        switch ($_GET['act']) {
            case 'workshop_approve':
                $out .= TFCMembers\UserRoles::approveNewUserForWorkshop();
                break;
            case 'bw1approve':
                $out .= TFCMembers\UserRoles::approveNewUserForBIW1();
                break;
            case 'bw1class':
                $out .= TFCMembers\UserRoles::giveAccessToBasicIWFirstClass();
                break;
            case 'groupbiw1comp':
                $out .= TFCMembers\UserRoles::onGroupBasicIW1Complete();
                break;
            case 'userbiw1comp':
                // Check if 'user_id' is set in the query string
                $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
                $out .= TFCMembers\UserRoles::onUserBasicIW1Complete($userId);
                break;
            case 'biw2comp':
                $out .= TFCMembers\UserRoles::onBasicIW2Complete();
                break;
        }
    } else {
        // Use heredoc syntax for cleaner HTML
        $out = <<<HTML
        <form action="/admin-tools/" method="get" name="admintools">
          <input type="hidden" name="act" value="run">
		  
		<div class="contentbox">
		  	<h2>Tools operating on User ID</h2>
		  
		  	<p><label>User Id</label> 
		  	<input type="text" id="user_id" name="user_id" />			  
			</p>
			<p><input type="submit" value="User Basic Inner Work 1 Complete" onclick="document.forms['admintools'].act.value = 'userbiw1comp' "></p>
		</div>
		<div class="contentbox">
		  <h2>Tools operating on User Group</h2>
		  <p><input type="submit" value="Approve New Users for Workshops" onclick="document.forms['admintools'].act.value = 'workshop_approve' "></p>

          <p><input type="submit" value="Approve New Users for Basic IW" onclick="document.forms['admintools'].act.value = 'bw1approve' "></p>
          
          <p><input type="submit" value="Give Access to Basic IW first class" onclick="document.forms['admintools'].act.value = 'bw1class' "></p>
          
          <p><input type="submit" value="Group Basic Inner Work 1 Complete" onclick="document.forms['admintools'].act.value = 'groupbiw1comp' "></p>
          
          <p><input type="submit" value="Group Basic Inner Work 2 Complete" onclick="document.forms['admintools'].act.value = 'biw2comp' "></p>
		</div>
        </form>
HTML;
    }

    return $out;
});
