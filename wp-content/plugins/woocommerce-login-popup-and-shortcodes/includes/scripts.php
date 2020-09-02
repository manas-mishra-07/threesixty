<?php
/**
 * Scripts
 *
 * @copyright   Copyright (c) 2017, Jeffrey Carandang
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( !function_exists( 'woocommerce_login_styler_scripts' ) ):
    add_action( 'wp_enqueue_scripts', 'woocommerce_login_styler_scripts', 100 );
    function woocommerce_login_styler_scripts( $hook ) {

        $js_dir  = WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL . 'assets/js/';
    	$css_dir = WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL . 'assets/css/';

        // Use minified libraries if SCRIPT_DEBUG is turned off
    	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

        wp_register_style( 'woocommerce_login_styler-styles', $css_dir . 'woo-login.css' , array(), null );

        wp_register_script(
            'jquery-woo-login-styler',
            $js_dir .'jquery.woo-login'. $suffix .'.js',
            array( 'jquery' ),
            '',
            true
      );
    }
endif;
?>
