<?php
if (!defined('ABSPATH')) {
    exit;
}

class WF_OrderImpExpCsv_Admin_Screen {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_print_styles', array($this, 'admin_scripts'));
        add_action('admin_notices', array($this, 'admin_notices'));
    }

    /**
     * Notices in admin
     */
    public function admin_notices() {
        if (!function_exists('mb_detect_encoding')) {
            echo '<div class="error"><p>' . __('Order CSV Import Export requires the function <code>mb_detect_encoding</code> to import and export CSV files. Please ask your hosting provider to enable this function.', 'wf_order_import_export') . '</p></div>';
        }
    }

    /**
     * Admin Menu
     */
    public function admin_menu() {
        $page = add_submenu_page('woocommerce', __('Order Im-Ex', 'wf_order_import_export'), __('Order Im-Ex', 'wf_order_import_export'), apply_filters('woocommerce_csv_order_role', 'manage_woocommerce'), 'wf_woocommerce_order_im_ex', array($this, 'output'));
    }

    /**
     * Admin Scripts
     */
    public function admin_scripts() {
        global $wp_scripts;
        wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css');
        wp_enqueue_style('woocommerce-order-csv-importer', plugins_url(basename(plugin_dir_path(WF_OrderImpExpCsv_FILE)) . '/styles/wf-style.css', basename(__FILE__)), '', '1.0.0', 'screen');
        
    }

    /**
     * Admin Screen output
     */
    public function output() {
        $tab = 'import';
        if (!empty($_GET['tab'])) {
            if ($_GET['tab'] == 'export') {
                $tab = 'export';
            }elseif($_GET['tab'] == 'subscription' ) {
                $tab = 'subscription';
            }
        }
        include( 'views/html-wf-admin-screen.php' );
    }

    /**
     * Admin page for importing
     */
    public function admin_import_page() {
        include( 'views/import/html-wf-import-orders.php' );
        $post_columns = include( 'exporter/data/data-wf-post-columns.php' );
        include( 'views/export/html-wf-export-orders.php' );
    }

    /**
     * Admin Page for exporting
     */
    public function admin_export_page() {
        $post_columns = include( 'exporter/data/data-wf-post-columns.php' );
        include( 'views/export/html-wf-export-orders.php' );
    }
        public function admin_subscription_page() 
    {
        include( 'views/html-wf-getting-started-subscription.php' );
    }

}

new WF_OrderImpExpCsv_Admin_Screen();
