<?php
/**
 * Shortcodes
 *
 * @copyright   Copyright (c) 2017, Jeffrey Carandang
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( !function_exists( 'woo_login_styler_register_sc' ) ){
    add_action( 'init', 'woo_login_styler_register_sc' );
    function woo_login_styler_register_sc(){
        add_shortcode( 'woo-login-popup', 'woo_login_styler_display_sc' );
    }
}

if( !function_exists( 'woo_login_styler_display_sc' ) ){
    function woo_login_styler_display_sc( $atts, $content = null ){
		$sc_atts = apply_filters( 'woo_login_styler_atts-default', array(
				'visible'	=> 'login',
				'modal' 	=> false,
			) );

		$args = shortcode_atts( $sc_atts , $atts );

		//check if woo installed
		if ( !class_exists( 'WooCommerce' ) ) {
			return;
		}

		//do not show on logged in users
		// if( is_user_logged_in() && !$args['modal'] ){
		// 	return '<p>'. apply_filters( 'woo_login_styler_atts_loggedin', __( 'You have successfully logged in.', 'woo-login-popup-shortcodes' ) ) .'</p>';
		// }

		//add style and scripts when shortcodes available only
		wp_enqueue_style( 'woocommerce_login_styler-styles' );
		wp_enqueue_script( 'jquery-woo-login-styler' );

		$notices  = WC()->session->get( 'wc_notices', array() );
		// $visible  = '';
		if( !empty( $notices ) ){
			$args['visible'] = 'login';
			if( isset( $_POST['register'] ) ){
				$args['visible'] = 'register';
			}elseif( isset( $_POST['wc_reset_password'] ) ){
				$args['visible'] = 'password';
			}
		}

		$options = get_option( 'woo_login_popup_sc_settings' );

		ob_start(); ?>
		<div class="woo-login-popup-sc-modal-overlay <?php echo ( !empty( $args['visible'] ) && $args['modal'] && !empty( $notices ) ) ? 'woo-login-popup-sc-show' : ''; ?>"></div>
		<div class="woo-login-popup-sc-modal <?php echo ( !$args['modal'] ) ? 'woo-login-popup-sc-modal-off' : 'woo-login-popup-sc-modal-on' ; ?> <?php echo ( !empty( $args['visible'] ) && $args['modal'] && !empty( $notices ) ) ? 'woo-login-popup-sc-show' : ''; ?>">
			<span class="woo-login-popup-sc-close"><a href="#"></a></span>
			<div class="woo-login-popup-sc-modal-inner">
				<div class="woo-login-popup-sc-left">
					<?php wc_print_notices(); ?>
					<?php
						if( is_user_logged_in() ){ ?>
							<div id="woo_login_popup_sc_loggedin">
								<h2><?php _e( 'Navigation', 'woo-login-popup-shortcodes' ); ?></h2>
								<p><?php echo apply_filters( 'woo_login_popup_sc_loggedin_text', __( 'You have successfully loggedin! Use the links below to navigate through your accounts pages.', 'woo-login-popup-shortcodes' ) ); ?></p>
								<nav class="woocommerce-MyAccount-navigation">
									<ul>
										<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
											<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
												<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
								</nav>
							</div>
						<?php
						}else{
							do_action( 'woo_login_popup_sc_modal', $args['visible'] );
						}
					?>
				</div>

				<div class="woo-login-popup-sc-bg" <?php echo ( is_array( $options ) && isset( $options['background'] ) && !empty( $options['background'] ) ) ? 'style="background-image:url(\''. $options['background'] .'\')"' : ''; ?> ></div>
				<div class="woo-login-popup-sc-clear"></div>
			</div>
			<div class="woo-login-popup-sc-modal-footer">
				<?php do_action( 'oo_login_popup_sc_modal_footer' );?>
			</div>
		</div>
    <?php
		$output = ob_get_clean();

		return $output;
	}
}

?>
