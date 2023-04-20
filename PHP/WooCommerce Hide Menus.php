<?php
	//Hide Menu -PHP Method
	add_filter( 'woocommerce_account_menu_items', 'QuadLayers_rename_acc_adress_tab', 9999 );
	function QuadLayers_rename_acc_adress_tab( $items ) {
		//$items['edit-address'] = 'Your addresses';
		unset( $items['dashboard'] );
		//unset( $items['orders'] );
		unset( $items['downloads'] );
		//unset( $items['edit-address'] );
		unset( $items['payment-methods'] );
		unset( $items['edit-account'] );
		//unset( $items['woo-wallet'] );
		unset( $items['customer-logout'] );

		return $items;
	}
>