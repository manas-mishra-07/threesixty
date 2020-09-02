<?php
/**
 * Admin Options Page
 * WooCommerce > Login Popup
 *
 * @copyright   Copyright (c) 2017, Jeffrey Carandang
 * @since       1.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates the admin submenu pages under the Settings menu and assigns their
 *
 * @since 1.0
 * @return void
 */
if( !function_exists( 'woo_login_popup_sc_options_link' ) ):
	function woo_login_popup_sc_options_link() {
		add_submenu_page(
			'woocommerce',
			__( 'Login Popup', 'woo-login-popup-shortcodes' ),
			__( 'Login Popup', 'woo-login-popup-shortcodes' ),
			'manage_options',
			'woo_login_popup_sc_settings',
			'woo_login_popup_sc_options_page'
		);
	}
	add_action( 'admin_menu', 'woo_login_popup_sc_options_link', 90 );
	add_action('admin_init', 'woo_login_popup_sc_options_cb');
endif;

if( !function_exists( 'woo_login_popup_sc_options_cb' ) ):
	function woo_login_popup_sc_options_cb(){
	    register_setting( 'woo_login_popup_sc_settings_group', 'woo_login_popup_sc_settings', 'woo_login_popup_sc_settings_sanitize');
	}
endif;

if( !function_exists( 'woo_login_popup_sc_options_scripts' ) ):
	function woo_login_popup_sc_options_scripts( $hook ) {
		if( 'woocommerce_page_woo_login_popup_sc_settings' == $hook ){
			wp_enqueue_media();
		}
	}
	add_action( 'admin_enqueue_scripts', 'woo_login_popup_sc_options_scripts' );
endif;

/**
 * Options Page
 *
 * Renders the options page contents.
 *
 * @since 1.0
 * @return void
 */
if( !function_exists( 'woo_login_popup_sc_options_page' ) ):
	function woo_login_popup_sc_options_page(){
		 $options = get_option( 'woo_login_popup_sc_settings' ); ?>

		 <div class="wrap">
			<h1>
				<?php _e( 'WooCommerce Login Popup & Shortcodes', 'woo-login-popup-shortcodes' ); ?>
				<a href="<?php echo esc_url( apply_filters( 'woo_login_popup_sc_support_url', 'https://wordpress.org/support/plugin/woo-login-popup-shortcodes' ) ); ?>" target="_blank" class="page-title-action"><?php _e( 'Support', 'woo-login-popup-shortcodes' ); ?></a>
			</h1>

			<div id="woo-login-popup-sc-settings-messages-container"></div>
			<div class="woo-login-popup-sc-settings-desc">
				<p><?php _e( 'Customize the login screen using the option provided below. You can also add you own CSS styling using the provided field for custom CSS code.', 'woo-login-popup-shortcodes' );?></p>
			</div>

			<div id="poststuff" class="woo-login-popup-sc-poststuff">
				<div id="post-body" class="metabox-holder columns-2 hide-if-no-js">
					<div id="postbox-container-2" class="postbox-container">

						<div class="woo-login-popup-sc-container hide-if-no-js">
							<form method="post" action="options.php" id="woo-login-popup-sc-settings-form">
								<?php settings_fields( 'woo_login_popup_sc_settings_group' ); ?>
								<?php do_settings_sections( 'woo_login_popup_sc_plugin_settings' ); ?>

								<table class="form-table woo-login-popup-sc-settings-table">
									<tr>
										<th scope="row">
											<label for="woo-login-popup-sc-enable-p"><?php _e( 'Enable Popup', 'woo-login-popup-shortcodes' );?></label>
										</th>
										<td>
											<input type="checkbox" id="woo-login-popup-sc-enable-p" name="woo_login_popup_sc_settings[popup]" value="1" <?php echo ( is_array( $options ) && isset( $options['popup'] ) && !empty( $options['popup'] ) ) ? 'checked="checked"' : '';?> />
											<small><?php _e( 'Check this option to automatically add the modal popup on wp_footer hook and toggle when element with <code>woo-login-popup-sc-open</code> class has been clicked.', 'woo-login-popup-shortcodes' );?></small>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label><?php _e( 'Background Image', 'woo-login-popup-shortcodes' );?></label>
										</th>
										<td>
											<button class="button button-primary woo_login_popup_sc_uploaded" data-field='.woo_login_popup_sc_image_fld' data-preview=".woo_login_popup_sc_preview" data-title="<?php _e( 'Select or Upload Background Image', 'woo-login-popup-shortcodes' );?>" data-text="<?php _e( 'Use as Background', 'woo-login-popup-shortcodes' );?>"><?php _e( 'Select or Upload Image', 'woo-login-popup-shortcodes' );?></button>
											<?php if( is_array( $options ) && isset( $options['background'] ) && !empty( $options['background'] ) ): ?>
												&nbsp;&nbsp;<a href="#" class="woo_login_popup_sc_remove" data-field='.woo_login_popup_sc_image_fld' data-preview=".woo_login_popup_sc_preview" ><?php _e( 'Remove Background Image', 'woo-login-popup-shortcodes' );?></a>
											<?php endif; ?>
											<input type="hidden" class="woo_login_popup_sc_image_fld" name="woo_login_popup_sc_settings[background]" value="<?php echo ( is_array( $options ) && isset( $options['background'] ) ) ? $options['background'] : '';?>" />
											<div class="woo_login_popup_sc_preview"><?php echo ( is_array( $options ) && isset( $options['background'] ) && !empty( $options['background'] ) ) ? '<img src="'. $options['background'] .'">' : '';?></div>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label><?php _e( 'Custom CSS', 'woo-login-popup-shortcodes' );?></label>
										</th>
										<td>
											<textarea class="widefat" name="woo_login_popup_sc_settings[css]" rows="10"><?php echo ( is_array( $options ) && isset( $options['css'] ) ) ? esc_textarea( $options['css'] ) : '';?></textarea>
											<small><?php _e( 'Add Custom CSS code here to style the display on your preference.', 'woo-login-popup-shortcodes' );?></small>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label><?php _e( 'Shortcode', 'woo-login-popup-shortcodes' );?></label>
										</th>
										<td>
											<small><?php _e( 'Use <code>[woo-login-popup]</code> to automatically display the login and registration box anywhere.', 'woo-login-popup-shortcodes' );?></small>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label><?php _e( 'Helpful Guides', 'woo-login-popup-shortcodes' );?></label>
										</th>
										<td>
											<small><?php _e( 'Did you know that you know that you can target specific type when you are opening the popup using menu link? Simple add any of the following as URL or HREF value : <br />#woo-login-popup-sc-login <br />#woo-login-popup-sc-register <br />#woo-login-popup-sc-password', 'woo-login-popup-shortcodes' );?></small>
										</td>
									</tr>
								</table>

								<?php
								if( function_exists('submit_button')) { submit_button(); } else { ?>
									<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'woo-login-popup-shortcodes' );?>"></p>
								<?php } ?>
							</form>

							</form>
						</div>
						<div class="woo-login-popup-sc-modal-background"></div>
					</div>

					<div id="postbox-container-1" class="postbox-container">
						<a href="http://widget-options.com/?utm_source=easy-login-admin&amp;utm_medium=sidebar&amp;utm_campaign=woo-login-admin-banner" target="_blank"><img src="<?php echo WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL;?>/assets/images/banner-widget-options-woo.jpg" /></a><br /><br />
						<a href="https://wordpress.org/plugins/forty-four/" target="_blank"><img src="<?php echo WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL;?>/assets/images/banner-404.jpg" /></a><br /><br />
						<a href="http://phpbits.net/plugin/mobi/?utm_source=easy-login-admin&amp;utm_medium=sidebar&amp;utm_campaign=woo-login-admin-banner" target="_blank"><img src="<?php echo WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL;?>/assets/images/banner-mobi.jpg" /></a>
					</div>

				</div>
			</div>
		</div>

		<style type="text/css">
			.woo-login-popup-sc-settings-table{
				width: 100%;
			}
			.woo-login-popup-sc-settings-table img{
				max-width: 100%;
			}
			.woo_login_popup_sc_preview{
				display: block;
				width: 100%;
			}
			.woo_login_popup_sc_preview img{
				padding: 15px 0px;
			}
			.woo_login_popup_sc_remove{
				line-height: 25px;
				color: #a00;
			}
			.woo-login-popup-sc-poststuff .postbox-container img{
				max-width: 100%;
				border: 0px;
			}
		</style>

		<script type="text/javascript">
			jQuery( document ).ready( function(){
				var file__frame;

			    jQuery( 'body' ).on( 'click', '.woo_login_popup_sc_uploaded', function( event ){
			        event.preventDefault();

					var fld = jQuery( this ).attr( 'data-field' );
					var preview = jQuery( this ).attr( 'data-preview' );

			        // Create the media frame.
			        file__frame = wp.media.frames.file__frame = wp.media({
			          title: jQuery( this ).attr( 'data-title' ),
			          button: {
			            text: jQuery( this ).attr( 'data-text' ),
			          },
			          multiple: false  // Set to true to allow multiple files to be selected
			        });

			        // When an image is selected, run a callback.
			        file__frame.on( 'select', function() {
			          // We set multiple to false so only get one image from the uploader
			          attachment = file__frame.state().get('selection').first().toJSON();
			          jQuery( fld ).val( attachment.url );
			          jQuery( preview ).html('<img src="'+ attachment.url +'" />');
			          // jQuery('#wpautbox_user_image_url').html('<img src="'+ attachment.url +'" width="120"/><br />');
			          // Do something with attachment.id and/or attachment.url here
			        });

			        // Finally, open the modal
			        file__frame.open();
			    });

				jQuery( '.woo_login_popup_sc_remove' ).on( 'click' ,function(e){

					var fld = jQuery( this ).attr( 'data-field' );
					var preview = jQuery( this ).attr( 'data-preview' );

			    	jQuery( fld ).val('');
			       	jQuery( preview ).html('');
					e.preventDefault();
					e.stopPropagation();
			    });
			} );
		</script>

	    <?php
	 }
 endif;
?>
