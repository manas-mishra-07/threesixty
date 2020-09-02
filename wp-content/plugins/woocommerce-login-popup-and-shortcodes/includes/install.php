<?php
/**
 * Install Function
 *
 * @copyright   Copyright (c) 2016, Jeffrey Carandang
 * @since       3.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//add settings link on plugin page
if( !function_exists( 'woo_login_popup_sc_filter_plugin_actions' ) ){
  add_action( 'plugin_action_links_' . plugin_basename( WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_FILE ) , 'woo_login_popup_sc_filter_plugin_actions' );
  function woo_login_popup_sc_filter_plugin_actions($links){
    $links[]  = '<a href="'. esc_url( admin_url( 'admin.php?page=woo_login_popup_sc_settings' ) ) .'">' . __( 'Settings', 'woo-login-popup-shortcodes' ) . '</a>';
    return $links;
  }
}

//register default values
if( !function_exists( 'woo_login_popup_sc_register_defaults' ) ){
	register_activation_hook( WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_FILE, 'woo_login_popup_sc_register_defaults' );
  	add_action( 'plugins_loaded', 'woo_login_popup_sc_register_defaults' );
	function woo_login_popup_sc_register_defaults(){
		if( is_admin() ){

			if( !get_option( 'woo_login_popup_sc_installDate' ) ){
				add_option( 'woo_login_popup_sc_installDate', date( 'Y-m-d h:i:s' ) );
			}

		}
	}
}

?>
