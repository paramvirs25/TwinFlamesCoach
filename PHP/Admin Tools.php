<?php
add_shortcode( 'admin_tools', function () {
	if (!empty($_GET['act'])) {
		if($_GET['act'] == 'approve'){
			approveNewUser();
		} else if($_GET['act'] == 'bw1class'){
			giveAccessToBasicIWFirstClass();
		} else if($_GET['act'] == 'biw1comp'){
			onBasicIW1Complete();
		} else if($_GET['act'] == 'biw2comp'){
			onBasicIW2Complete();
		}
		
	} else {

		$out = '<form action="/admin-tools/" method="get" name="admintools">
		  <input type="hidden" name="act" value="run">
		  <input type="submit" value="Approve New Users" onclick="document.forms[\'admintools\'].act.value = \'approve\' ">
		  <br/><br/>
		  <input type="submit" value="Give Access to Basic IW first class" onclick="document.forms[\'admintools\'].act.value = \'bw1class\' ">
		  <br/><br/>
		  <input type="submit" value="On Basic Inner Work 1 Complete" onclick="document.forms[\'admintools\'].act.value = \'biw1comp\' ">
		  <br/><br/>
		  <input type="submit" value="On Basic Inner Work 2 Complete" onclick="document.forms[\'admintools\'].act.value = \'biw2comp\' ">
		</form>';
	}

	return $out;
} );


>