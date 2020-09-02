<?php
/**
 * Registration Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !function_exists( 'woo_login_popup_sc_register' ) ):
	add_action( 'woo_login_popup_sc_modal', 'woo_login_popup_sc_register' );
	function woo_login_popup_sc_register( $visible ){
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
	        <div id="woo-login-popup-sc-register" class="woo-login-popup-sc <?php echo ( $visible == 'register' ) ? 'woo-login-popup-sc-show' : '';?>">

				<h2><?php _e( 'Register', 'woo-login-popup-shortcodes' ); ?></h2>

				<form method="post" class="register">

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
							<label for="reg_username"><?php _e( 'Username', 'woo-login-popup-shortcodes' ); ?> <span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</p>

					<?php endif; ?>

					<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
						<label for="reg_email"><?php _e( 'Email Address', 'woo-login-popup-shortcodes' ); ?> <span class="required">*</span></label>
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
							<label for="reg_password"><?php _e( 'Password', 'woo-login-popup-shortcodes' ); ?> <span class="required">*</span></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
						</p>

					<?php endif; ?>

					<!-- Spam Trap -->
					<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woo-login-popup-shortcodes' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>

					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php do_action( 'register_form' ); ?>

					<p class="woocomerce-FormRow form-row">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woo-login-popup-shortcodes' ); ?>" />
					</p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

					<p class="woocommerce-plogin">
						<a href="#woo-login-popup-sc-login" class="woo-login-popup-sc-toggle"><?php _e( 'Log In', 'woo-login-popup-shortcodes' ); ?></a> | <a href="#woo-login-popup-sc-password" class="woo-login-popup-sc-toggle"><?php _e( 'Lost your password?', 'woo-login-popup-shortcodes' ); ?></a>
					</p>

				</form>
	        </div>
    <?php
		endif;
	}
endif;
?>
