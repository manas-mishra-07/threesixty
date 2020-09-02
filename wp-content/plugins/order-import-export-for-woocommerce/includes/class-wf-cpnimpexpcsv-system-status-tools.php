<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WF_CpnImpExpCsv_System_Status_Tools {

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
		$tools['delete_coupons'] = array(
			'name'		=> __( 'Delete Coupons','wf_order_import_export'),
			'button'	=> __( 'Delete ALL coupons','wf_order_import_export' ),
			'desc'		=> __( 'This tool will delete all coupons allowing you to start fresh.', 'wf_order_import_export' ),
			'callback'  => array( $this, 'delete_coupons' )
		);
		
		return $tools;
	}

	/**
	 * Delete coupons
	 */
	public function delete_coupons() 
	{
		global $wpdb;

		// Delete coupons
		$result  = absint( $wpdb->delete( $wpdb->posts, array( 'post_type' => 'shop_coupon' ) ) );
		

		// Delete meta and term relationships with no post
		$wpdb->query( "DELETE pm
			FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} wp ON wp.ID = pm.post_id
			WHERE wp.ID IS NULL" );
		

		echo '<div class="updated"><p>' . sprintf( __( '%d Coupons Deleted', 'wf_order_import_export' ), ( $result) ) . '</p></div>';
	}

	
}

new WF_CpnImpExpCsv_System_Status_Tools();