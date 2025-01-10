<?php
	add_filter('woocommerce_rest_check_permissions', function ($permission, $context, $object_id, $post_type) {
		if ('product' === $post_type && 'read' === $context) {
			return true; // Allow public access to product data
		}
		return $permission;
	}, 10, 4);
	