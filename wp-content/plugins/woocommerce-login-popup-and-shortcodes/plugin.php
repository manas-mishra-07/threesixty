<?php
/**
 * Plugin Name: WooCommerce Login Popup and Shortcodes
 * Plugin URI: https://wordpress.org/plugins/woocommerce-login-popup-and-shortcodes/
 * Description: Simple Modal Login Page & Shortcode for WooCommerce.
 * Version: 1.0.2
 * Author: Phpbits Creative Studio
 * Author URI: https://phpbits.net/
 * Text Domain: woo-login-popup-shortcodes
 * Domain Path: languages
 *
 * @category Login
 * @author Jeffrey Carandang
 * @version 1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'WOO_LOGIN_POPUP_SHORTCODES' ) ) :

/**
 * Main WOO_LOGIN_POPUP_SHORTCODES Class.
 *
 * @since  1.0
 */
final class WOO_LOGIN_POPUP_SHORTCODES {
	/**
	 * @var WOO_LOGIN_POPUP_SHORTCODES The one true WOO_LOGIN_POPUP_SHORTCODES
	 * @since  1.0
	 */
	private static $instance;

	/**
	 * Main WOO_LOGIN_POPUP_SHORTCODES Instance.
	 *
	 * Insures that only one instance of WOO_LOGIN_POPUP_SHORTCODES exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since  1.0
	 * @static
	 * @staticvar array $instance
	 * @uses WOO_LOGIN_POPUP_SHORTCODES::setup_constants() Setup the constants needed.
	 * @uses WOO_LOGIN_POPUP_SHORTCODES::includes() Include the required files.
	 * @uses WOO_LOGIN_POPUP_SHORTCODES::load_textdomain() load the language files.
	 * @see WOO_LOGIN_POPUP_SHORTCODES()
	 * @return object|WOO_LOGIN_POPUP_SHORTCODES The one true WOO_LOGIN_POPUP_SHORTCODES
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WOO_LOGIN_POPUP_SHORTCODES ) ) {
			self::$instance = new WOO_LOGIN_POPUP_SHORTCODES;
			self::$instance->setup_constants();

			// add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
			// self::$instance->roles         = new WIDGETOPTS_Roles();
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_constants() {

		// Plugin version.
		if ( ! defined( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_NAME' ) ) {
			define( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_NAME', 'WooCommerce Login Popup and Shortcodes' );
		}

		// Plugin version.
		if ( ! defined( 'WOO_LOGIN_POPUP_SHORTCODES_VERSION' ) ) {
			define( 'WOO_LOGIN_POPUP_SHORTCODES_VERSION', '1.0.2' );
		}

		// Plugin Folder Path.
		if ( ! defined( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR' ) ) {
			define( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL' ) ) {
			define( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File.
		if ( ! defined( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_FILE' ) ) {
			define( 'WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/shortcodes.php';
		require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/modal.php';
		require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/form-login.php';
		require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/form-register.php';
		require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/form-lost-password.php';
		require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/scripts.php';
		if( is_admin() ){
			require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/install.php';
			require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/settings/settings-tab.php';
			require_once WOO_LOGIN_POPUP_SHORTCODES_PLUGIN_DIR . 'includes/notices.php';
		}
	}

}

endif; // End if class_exists check.


/**
 * The main function for that returns WOO_LOGIN_POPUP_SHORTCODES
 *
 * The main function responsible for returning the one true WOO_LOGIN_POPUP_SHORTCODES
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $widgetopts = WOO_LOGIN_POPUP_SHORTCODES(); ?>
 *
 * @since 1.0
 * @return object|WOO_LOGIN_POPUP_SHORTCODES The one true WOO_LOGIN_POPUP_SHORTCODES Instance.
 */
if( !function_exists( 'WOO_LOGIN_POPUP_SHORTCODES_FN' ) ){
	function WOO_LOGIN_POPUP_SHORTCODES_FN() {
		return WOO_LOGIN_POPUP_SHORTCODES::instance();
	}
	// Get Plugin Running.
	WOO_LOGIN_POPUP_SHORTCODES_FN();
}
?>
