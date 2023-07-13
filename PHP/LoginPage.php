<?php
add_shortcode( 'login_organize', function () {
	ob_start();
?>

	<script src="https://paramvirs25.github.io/TwinFlamesCoach/Javascript/LoginPage.js" defer></script>

<?php
	return ob_get_clean();
} );
