<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WF_OrderImpExpCsv_System_Status_Tools {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_debug_tools', array( $this, 'tools' ) );
	}

	/**
	 * Tools we add to WC
	 * @param  array $tools
	 * @return array
	 */
	public function tools( $tools ) {
		$tools['delete_trashed_orders'] = array(
			'name'		=> __( 'Delete Trashed Orders','wf_order_import_export'),
			'button'	=> __( 'Delete  Trashed Orders','wf_order_import_export' ),
			'desc'		=> __( 'This tool will delete all  Trashed Orders.', 'wf_order_import_export' ),
			'callback'  => array( $this, 'delete_trashed_orders' )
		);
		$tools['delete_all_orders'] = array(
			'name'		=> __( 'Delete Orders','wf_order_import_export'),
			'button'	=> __( 'Delete ALL Orders','wf_order_import_export' ),
			'desc'		=> __( 'This tool will delete all orders allowing you to start fresh.', 'wf_order_import_export' ),
			'callback'  => array( $this, 'delete_all_orders' )
		);
		return $tools;
	}

	/**
	 * Delete Trashed Orders
	 */
	public function delete_trashed_orders() {
		global $wpdb;
		// Delete Trashed Orders
		$result  = absint( $wpdb->delete( $wpdb->posts, array( 'post_type' => 'shop_order' , 'post_status' => 'trash') ) );
		echo '<div class="updated"><p>' . sprintf( __( '%d Orders Deleted', 'wf_order_import_export' ), ( $result ) ) . '</p></div>';
	}

	/**
	 * Delete all orders
	 */
	public function delete_all_orders() {
		global $wpdb;

		// Delete Orders
		$result = absint( $wpdb->delete( $wpdb->posts, array( 'post_type' => 'shop_order' ) ) );

		// Delete meta and term relationships with no post
		$wpdb->query( "DELETE pm
			FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} wp ON wp.ID = pm.post_id
			WHERE wp.ID IS NULL" );
		echo '<div class="updated"><p>' . sprintf( __( '%d Orders Deleted', 'wf_order_import_export' ), $result ) . '</p></div>';
	}	
}

new WF_OrderImpExpCsv_System_Status_Tools();