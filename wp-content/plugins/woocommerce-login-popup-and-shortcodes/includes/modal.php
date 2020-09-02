<?php
/**
 * Modal Container Element
 * added using wp_footer action
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !function_exists( 'woo_login_popup_sc_modal' ) ):
	add_action( 'wp_footer', 'woo_login_popup_sc_modal' );
	function woo_login_popup_sc_modal(){
		$options = get_option( 'woo_login_popup_sc_settings' );
		if( is_array( $options ) && isset( $options['popup'] ) && !empty( $options['popup'] ) ){
			echo do_shortcode( '[woo-login-popup modal="true"]' );
		}
		if( is_array( $options ) && isset( $options['css'] ) && !empty( $options['css'] ) ){ ?>
			<style type="text/css"><?php echo esc_textarea( $options['css'] ); ?></style>
		<?php }
	}
endif;

?>
