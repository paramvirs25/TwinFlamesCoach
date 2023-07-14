<?php
//THIS CODE IS NOT BEING USED

add_shortcode( 'login_organize', function () {
	ob_start();
?>
	<style>
		.tfcHideLogin{
			display: none;
		}
		.tfcShowLogin{
			display: block;
		}
	</style>
	<script src="https://paramvirs25.github.io/TwinFlamesCoach/Javascript/LoginPage.js" defer></script>

<?php
	return ob_get_clean();
} );
