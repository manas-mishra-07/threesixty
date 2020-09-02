<?php
/*
 * 
Plugin Name: Order / Coupon / Subscription Export Import Plugin for WooCommerce (BASIC)
Plugin URI: https://wordpress.org/plugins/order-import-export-for-woocommerce/
Description: Export and Import Order detail including line items, From and To your WooCommerce Store.
Author: WebToffee
Author URI: https://www.webtoffee.com/product/woocommerce-order-coupon-subscription-export-import/
Version: 1.4.0
Text Domain: wf_order_import_export
WC tested up to: 3.5.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) || ! is_admin() ) {
	return;
}

define( "WF_ORDER_IMP_EXP_ID", "wf_order_imp_exp" );
define( "WF_WOOCOMMERCE_ORDER_IM_EX", "wf_woocommerce_order_im_ex" );

define("WF_CPN_IMP_EXP_ID", "wf_cpn_imp_exp");
define("wf_coupon_csv_im_ex", "wf_coupon_csv_im_ex");

if (!defined('WF_ORDERIMPEXP_CURRENT_VERSION')) {
    define("WF_ORDERIMPEXP_CURRENT_VERSION", "1.4.0");
}

/**
 * Check if WooCommerce is active
 */
if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {	

	if ( ! class_exists( 'WF_Order_Import_Export_CSV' ) ) :

	/**
	 * Main CSV Import class
	 */
	class WF_Order_Import_Export_CSV {

		/**
		 * Constructor
		 */
		public function __construct() {
			
                        define( 'WF_OrderImpExpCsv_FILE', __FILE__ );
                        
                        if (!defined('WT_OrdImpExpCsv_BASE')) {
                            define('WT_OrdImpExpCsv_BASE', plugin_dir_path(__FILE__));
                        }

			add_filter( 'woocommerce_screen_ids', array( $this, 'woocommerce_screen_ids' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'wf_plugin_action_links' ) );
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'init', array( $this, 'catch_export_request' ), 20 );
			add_action( 'init', array( $this, 'catch_save_settings' ), 20 );
			add_action( 'admin_init', array( $this, 'register_importers' ) );
                                               

			include_once( 'includes/class-wf-orderimpexpcsv-admin-screen.php' );
			include_once( 'includes/importer/class-wf-orderimpexpcsv-importer.php' );

			if ( defined('DOING_AJAX') ) {
				include_once( 'includes/class-wf-orderimpexpcsv-ajax-handler.php' );
			}
                        
                        // uninstall feedback catch
                        include_once 'includes/class-wf-orderimpexp-plugin-uninstall-feedback.php';
		}
		
		public function wf_plugin_action_links( $links ) {
			$plugin_links = array(
				'<a href="' . admin_url( 'admin.php?page=wf_woocommerce_order_im_ex' ) . '">' . __( 'Import Export', 'wf_order_import_export' ) . '</a>',
                                '<a href="https://www.webtoffee.com/product/woocommerce-order-coupon-subscription-export-import/" target="_blank" style="color:#3db634;">' . __( 'Premium Upgrade', 'wf_order_import_export' ) . '</a>',	
                                '<a target="_blank" href="https://www.webtoffee.com/support/">' . __( 'Support', 'wf_order_import_export' ) . '</a>',
                                '<a target="_blank" href="https://wordpress.org/plugins/order-import-export-for-woocommerce/reviews/">' . __('Review', 'wf_customer_import_export') . '</a>',

			);
                        if (array_key_exists('deactivate', $links)) {
                            $links['deactivate'] = str_replace('<a', '<a class="wforderimpexp-deactivate-link"', $links['deactivate']);
                        }
			return array_merge( $plugin_links, $links );
		}
		
		/**
		 * Add screen ID
		 */
		public function woocommerce_screen_ids( $ids ) {
			$ids[] = 'admin'; // For import screen
			return $ids;
		}

		/**
		 * Handle localisation
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'wf_order_import_export', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Catches an export request and exports the data. This class is only loaded in admin.
		 */
		public function catch_export_request() {
			if ( ! empty( $_GET['action'] ) && ! empty( $_GET['page'] ) && $_GET['page'] == 'wf_woocommerce_order_im_ex' ) {
				switch ( $_GET['action'] ) {
					case "export" :
                                                $user_ok = $this->hf_user_permission();
                                                if ($user_ok) {
						include_once( 'includes/exporter/class-wf-orderimpexpcsv-exporter.php' );
						WF_OrderImpExpCsv_Exporter::do_export( 'shop_order' );
                                                }  else {
                                                    wp_redirect(wp_login_url());
                                                }
					break;
				}
			}
		}
		
		public function catch_save_settings() {
			if ( ! empty( $_GET['action'] ) && ! empty( $_GET['page'] ) && $_GET['page'] == 'wf_woocommerce_order_im_ex' ) {
				switch ( $_GET['action'] ) {
					case "settings" :
						include_once( 'includes/settings/class-wf-orderimpexpcsv-settings.php' );
						WF_OrderImpExpCsv_Settings::save_settings( );
					break;
				}
			}
		}

		/**
		 * Register importers for use
		 */
		public function register_importers() {
			register_importer( 'woocommerce_wf_order_csv', 'WooCommerce Order (CSV)', __('Import <strong>Orders</strong> to your store via a csv file.', 'wf_order_import_export'), 'WF_OrderImpExpCsv_Importer::order_importer' );
		}
               
                private function hf_user_permission() {
                // Check if user has rights to export
                $current_user = wp_get_current_user();
                $user_ok = false;
                $wf_roles = apply_filters('hf_user_permission_roles', array('administrator', 'shop_manager'));
                if ($current_user instanceof WP_User) {
                    $can_users = array_intersect($wf_roles, $current_user->roles);
                    if (!empty($can_users)) {
                        $user_ok = true;
                    }
                }
                return $user_ok;
                }
	}
	endif;

	new WF_Order_Import_Export_CSV();
        
        
        
        if (!class_exists('WF_Coupon_Import_Export_CSV')) :

        class WF_Coupon_Import_Export_CSV {

            public $cron;
            public $cron_import;

            /**
             * Constructor
             */
            public function __construct() {
                
                define('WF_CpnImpExpCsv_FILE', __FILE__);

                if (is_admin()) {
                    add_action('admin_notices', array($this, 'wf_coupon_ie_admin_notice'), 15);
                }

                add_filter('woocommerce_screen_ids', array($this, 'woocommerce_screen_ids'));
                add_action('init', array($this, 'load_plugin_textdomain'));
                add_action('init', array($this, 'catch_export_request'), 20);
                add_action('init', array($this, 'catch_save_settings'), 20);
                add_action('admin_init', array($this, 'register_importers'));

                include_once( 'includes/class-wf-cpnimpexpcsv-admin-screen.php' );
                include_once( 'includes/importer/class-wf-cpnimpexpcsv-importer.php' );
               
                if (defined('DOING_AJAX')) {
                    include_once( 'includes/class-wf-cpnimpexpcsv-ajax-handler.php' );
                }
                
            }


            function wf_coupon_ie_admin_notice() {
                global $pagenow;
                global $post;

                if (!isset($_GET["wf_coupon_ie_msg"]) && empty($_GET["wf_coupon_ie_msg"])) {
                    return;
                }

                $wf_coupon_ie_msg = $_GET["wf_coupon_ie_msg"];

                switch ($wf_coupon_ie_msg) {
                    case "1":
                        echo '<div class="update"><p>' . __('Successfully uploaded via FTP.', 'wf_order_import_export') . '</p></div>';
                        break;
                    case "2":
                        echo '<div class="error"><p>' . __('Error while uploading via FTP.', 'wf_order_import_export') . '</p></div>';
                        break;
                    case "3":
                        echo '<div class="error"><p>' . __('Please choose the file in CSV format using Method 1.', 'wf_order_import_export') . '</p></div>';
                        break;
                }
            }

            /**
             * Add screen ID
             */
            public function woocommerce_screen_ids($ids) {
                $ids[] = 'admin'; // For import screen
                return $ids;
            }

            /**
             * Handle localisation
             */
            public function load_plugin_textdomain() {
                load_plugin_textdomain('wf_order_import_export', false, dirname(plugin_basename(__FILE__)) . '/lang/');
            }

            /**
             * Catches an export request and exports the data. This class is only loaded in admin.
             */
            public function catch_export_request() {
                if (!empty($_GET['action']) && !empty($_GET['page']) && $_GET['page'] == 'wf_coupon_csv_im_ex') {
                    switch ($_GET['action']) {
                        case "export" :
                            $user_ok = $this->hf_user_permission();
                            if ($user_ok) {
                                include_once( 'includes/exporter/class-wf-cpnimpexpcsv-exporter.php' );
                                WF_CpnImpExpCsv_Exporter::do_export('shop_coupon');
                            } else {
                                wp_redirect(wp_login_url());
                            }
                            break;
                    }
                }
            }

            public function catch_save_settings() {
                if (!empty($_GET['action']) && !empty($_GET['page']) && $_GET['page'] == 'wf_coupon_csv_im_ex') {
                    switch ($_GET['action']) {
                        case "settings" :
                            include_once( 'includes/settings/class-wf-allimpexpcsv-settings.php' );
                            wf_allImpExpCsv_Settings::save_settings();
                            break;
                    }
                }
            }

            /**
             * Register importers for use
             */
            public function register_importers() {
                register_importer('coupon_csv', 'WooCommerce Coupons (CSV)', __('Import <strong>coupon</strong> to your store via a csv file.', 'wf_order_import_export'), 'WF_CpnImpExpCsv_Importer::coupon_importer');
            }

            private function hf_user_permission() {
                // Check if user has rights to export
                $current_user = wp_get_current_user();
                $user_ok = false;
                $wf_roles = apply_filters('hf_user_permission_roles', array('administrator', 'shop_manager'));
                if ($current_user instanceof WP_User) {
                    $can_users = array_intersect($wf_roles, $current_user->roles);
                    if (!empty($can_users)) {
                        $user_ok = true;
                    }
                }
                return $user_ok;
            }
            
            
        }

        endif;

    new WF_Coupon_Import_Export_CSV();

}



if (!get_option('OCSEIPF_Webtoffee_storefrog_admin_notices_dismissed')) {
    add_action('admin_notices', 'webtoffee_storefrog_admin_notices');
    add_action('wp_ajax_OCSEIPF_webtoffee_storefrog_notice_dismiss', 'webtoffee_storefrog_notice_dismiss');
} 
function webtoffee_storefrog_admin_notices() {

    if (apply_filters('webtoffee_storefrog_suppress_admin_notices', false)) {
        return;
    }
    $screen = get_current_screen();

    $allowed_screen_ids = array('woocommerce_page_wf_woocommerce_order_im_ex','woocommerce_page_wf_coupon_csv_im_ex');
    if (in_array($screen->id, $allowed_screen_ids) || (isset($_GET['import']) && $_GET['import'] == 'woocommerce_wf_order_csv') || (isset($_GET['import']) && $_GET['import'] == 'coupon_csv')  ) {

        $notice = __('<h3>Save Time, Money & Hassle on Your WooCommerce Data Migration?</h3>', 'wf_order_import_export');
        $notice .= __('<h3>Use StoreFrog Migration Services.</h3>', 'wf_order_import_export');

        $content = '<style>.webtoffee-storefrog-nav-tab.updated {display: flex;align-items: center;margin: 18px 20px 10px 0;padding:23px;border-left-color: #2c85d7!important}.webtoffee-storefrog-nav-tab ul {margin: 0;}.webtoffee-storefrog-nav-tab h3 {margin-top: 0;margin-bottom: 9px;font-weight: 500;font-size: 16px;color: #2880d3;}.webtoffee-storefrog-nav-tab h3:last-child {margin-bottom: 0;}.webtoffee-storefrog-banner {flex-basis: 20%;padding: 0 15px;margin-left: auto;} .webtoffee-storefrog-banner a:focus{box-shadow: none;}</style>';
        $content .= '<div class="updated woocommerce-message webtoffee-storefrog-nav-tab notice is-dismissible"><ul>' . $notice . '</ul><div class="webtoffee-storefrog-banner"><a href="http://www.storefrog.com/" target="_blank"> <img src="' . plugins_url(basename(plugin_dir_path(WF_OrderImpExpCsv_FILE))) . '/images/storefrog.png"/></a></div><div style="position: absolute;top: 0;right: 1px;z-index: 10000;" ><button type="button" id="webtoffee-storefrog-notice-dismiss" class="notice-dismiss"><span class="screen-reader-text">' . __('Dismiss this notice.', 'wf_order_import_export') . '</span></button></div></div>';
        echo $content;


        wc_enqueue_js("jQuery( '#webtoffee-storefrog-notice-dismiss' ).click( function() {
                            jQuery.post( '" . admin_url("admin-ajax.php") . "', { action: 'OCSEIPF_webtoffee_storefrog_notice_dismiss' } );
                            jQuery('.webtoffee-storefrog-nav-tab').fadeOut();
			});
		    ");
    }
}

function webtoffee_storefrog_notice_dismiss() {

    if (!current_user_can('manage_woocommerce')) {
        wp_die(-1);
    }
    update_option('OCSEIPF_Webtoffee_storefrog_admin_notices_dismissed', 1);
    wp_die();
}




add_filter('admin_footer_text', 'WT_admin_footer_text', 100);
add_action('wp_ajax_ocsie_wt_review_plugin', "review_plugin");

function WT_admin_footer_text($footer_text) {
    if (!current_user_can('manage_woocommerce') || !function_exists('wc_get_screen_ids')) {
        return $footer_text;
    }
    $screen = get_current_screen();
    $allowed_screen_ids = array('woocommerce_page_wf_woocommerce_order_im_ex','woocommerce_page_wf_coupon_csv_im_ex');
    if (in_array($screen->id, $allowed_screen_ids) || (isset($_GET['import']) && $_GET['import'] == 'woocommerce_wf_order_csv') || (isset($_GET['import']) && $_GET['import'] == 'coupon_csv')  ) {
        if (!get_option('ocsie_wt_plugin_reviewed')) {
            $footer_text = sprintf(
                    __('If you like the plugin please leave us a %1$s review.', 'wf_order_import_export'), '<a href="https://wordpress.org/support/plugin/order-import-export-for-woocommerce/reviews/?rate=5#new-post" target="_blank" class="wt-review-link" data-rated="' . esc_attr__('Thanks :)', 'wf_order_import_export') . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
            );
            wc_enqueue_js(
                    "jQuery( 'a.wt-review-link' ).click( function() {
                                                   jQuery.post( '" . WC()->ajax_url() . "', { action: 'ocsie_wt_review_plugin' } );
                                                   jQuery( this ).parent().text( jQuery( this ).data( 'rated' ) );
                                           });"
            );
        } else {
            $footer_text = __('Thank you for your review.', 'wf_order_import_export');
        }
    }

    return '<i>' . $footer_text . '</i>';
}

function review_plugin() {
    if (!current_user_can('manage_woocommerce')) {
        wp_die(-1);
    }
    update_option('ocsie_wt_plugin_reviewed', 1);
    wp_die();
}