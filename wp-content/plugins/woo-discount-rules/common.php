<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

add_action('wp_ajax_awdr_auto_install_pro_plugin', function (){
    FlycartWooDiscountRulesExistingPROUpdater::installProPlugin();
    exit;
});
add_action('wp_ajax_awdr_switch_version', function (){
    $version = isset($_REQUEST['version'])? $_REQUEST['version']: '';
    $page = isset($_REQUEST['page'])? $_REQUEST['page']: '';
    $return['status'] = false;
    $return['message'] = esc_html__('Invalid request', WDR_TEXT_DOMAIN);
    if($version !== '' && $page !== ''){
        $url = admin_url('admin.php?page=' . $page . '&awdr_switch_plugin_to=' . $version);
        $do_switch = true;
        if (!isAWDREnvironmentCompatible()) {
            $return['message'] = __('Discount Rules 2.0 requires minimum PHP version of ', WDR_TEXT_DOMAIN) . ' ' . WDR_REQUIRED_PHP_VERSION;
            wp_send_json_success($return);
        }
        if (!isAWDRWooCompatible()) {
            $return['message'] = __('Discount Rules 2.0 requires at least Woocommerce', WDR_TEXT_DOMAIN) . ' ' . WDR_WC_REQUIRED_VERSION;
            wp_send_json_success($return);
        }
        if (defined('WDR_BACKWARD_COMPATIBLE')) {
            if(WDR_BACKWARD_COMPATIBLE == true){
                if ($version == "v2") {
                    if (!defined('WDR_PRO')) {
                        $do_switch = false;
                    }
                }
            }
        }
        if($do_switch){
            $return['status'] = true;
            $return['message'] = '';
            $return['url'] = $url;
        } else {
            $has_auto_update = false;
            if (!is_multisite()) {
                if(class_exists('FlycartWooDiscountRulesExistingPROUpdater')){
                    if(FlycartWooDiscountRulesExistingPROUpdater::availableAutoInstall()){
                        $has_auto_update = true;
                    }
                }
            }
            if($has_auto_update){
                $return['type'] = 'auto_install';
                $message = __('<p>Since 2.0, you need BOTH Core and Pro (2.0) packages installed and activated.</p>', WDR_TEXT_DOMAIN);
                $message .= __('<p><b>Why we made this change?</b></p>', WDR_TEXT_DOMAIN);
                $message .= __('<p>This arrangement is to avoid the confusion in the installation and upgrade process. Many users first install the core free version. Then purchase the PRO version and try to install it over the free version. Since both free and pro packages have same names, wordpress asks them to uninstall free and then install pro. As you can see, this is quite confusing for the end users.</p>', WDR_TEXT_DOMAIN);
                $message .= __('<p>As a result, starting from 2.0, we now have two packs: 1. Core 2. PRO.</p>', WDR_TEXT_DOMAIN);
                $message .= '<p><button type="button" class="awdr_auto_install_pro_plugin btn btn-info">'.__('Download and Install', WDR_TEXT_DOMAIN).'</button></p>';
                $return['message'] = $message;
            } else {
                $return['message'] = __('Since 2.0, you need BOTH Core and Pro (2.0) packages installed and activated.  Please download the Pro 2.0 pack from My Downloads page in our site, install and activate it. <a href="https://docs.flycart.org/en/articles/4006520-switching-to-2-0-from-v1-x-versions?utm_source=woo-discount-rules-v2&utm_campaign=doc&utm_medium=text-click&utm_content=switch_to_v2" target="_blank">Here is a guide and video tutorial</a>', WDR_TEXT_DOMAIN);
                $return['type'] = 'manual_install';
            }
        }
    }

    wp_send_json_success($return);
});


/**
 * Action sto show the toggle button
 */
add_action('advanced_woo_discount_rules_on_settings_head', function () {
    $has_switch = true;
    $page = NULL;
    if (isset($_GET['page'])) {
        $page = sanitize_text_field($_GET['page']);
    }
    global $awdr_load_version;
    $version = ($awdr_load_version == "v1") ? "v2" : "v1";
    $url = admin_url('admin.php?page=' . $page . '&awdr_switch_plugin_to=' . $version);
    $message = __('Switch to Discount Rules 2.0  which comes with a better UI and advanced rules. (You can switch back any time. Your settings and rules in V1 are  kept as is)', WDR_TEXT_DOMAIN);
    $button_text = __("Switch to 2.0 <span style='background-color: #FF8C00 ; padding: 3px; border-radius: 4px'>Public beta</span>", WDR_TEXT_DOMAIN);
    if($version == "v1"){
        $has_switch = \Wdr\App\Helpers\Migration::hasSwitchBackOption();
        $message = __('Would you like to switch to older Woo Discount Rules?', WDR_TEXT_DOMAIN);
        $button_text = __("Click here to Switch back", WDR_TEXT_DOMAIN);
    }
    if($has_switch){
        echo '<div style="background: #fff;padding: 20px;font-size: 13px;font-weight: bold;">' . $message . ' <button class="btn btn-info awdr-switch-version-button" data-version="' . $version . '" data-page="'.$page.'">' . $button_text . '</button></div>';
        echo "<div class='wdr_switch_message' style='color:#a00;font-weight: bold;'></div>";
        echo '<div class="modal" id="wdr_switch_popup">
                    <div class="modal-sandbox"></div>
                    <div class="modal-box">
                        <div class="modal-header">
                            <div class="close-modal"><span class="wdr-close-modal-box">&#10006;</span></div>
                            <h1 class="wdr-modal-header-title">'.__("Install 2.0 Pro package", WDR_TEXT_DOMAIN).'</h1>
                        </div>
                        <div class="modal-body">
                            <div class=\'wdr_pro_install_message\'></div>
                        </div>
                    </div>
                </div>';
    }
});

add_action('advanced_woo_discount_rules_content_next_to_tabs', function () {
    $has_switch = true;
    $page = NULL;
    if (isset($_GET['page'])) {
        $page = sanitize_text_field($_GET['page']);
    }
    global $awdr_load_version;
    $version = ($awdr_load_version == "v1") ? "v2" : "v1";
    if($version == "v1"){
        $has_switch = \Wdr\App\Helpers\Migration::hasSwitchBackOption();
    }
    if($has_switch){
        $button_text = __("Switch back to Discount Rules 1.x", WDR_TEXT_DOMAIN);
        echo '<button class="btn btn-info awdr-switch-version-button awdr-switch-version-button-on-tab" data-version="' . $version . '" data-page="'.$page.'">' . $button_text . '</button>';
    }
});

/**
 * Determines if the server environment is compatible with this plugin.
 *
 * @return bool
 * @since 1.0.0
 *
 */
if(!function_exists('isAWDREnvironmentCompatible')){
    function isAWDREnvironmentCompatible()
    {
        return version_compare(PHP_VERSION, WDR_REQUIRED_PHP_VERSION, '>=');
    }
}

/**
 * Check the woocommerce is active or not
 * @return bool
 */
if(!function_exists('isAWDRWooActive')){
    function isAWDRWooActive()
    {
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins', array()));
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        return in_array('woocommerce/woocommerce.php', $active_plugins, false) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
    }
}

/**
 * Check woocommerce version is compatibility
 * @return bool
 */
if(!function_exists('isAWDRWooCompatible')){
    function isAWDRWooCompatible()
    {
        $current_wc_version = getAWDRWooVersion();
        return version_compare($current_wc_version, WDR_WC_REQUIRED_VERSION, '>=');
    }
}

/**
 * get the version of woocommerce
 * @return mixed|null
 */
if(!function_exists('getAWDRWooVersion')){
    function getAWDRWooVersion()
    {
        if (defined('WC_VERSION')) {
            return WC_VERSION;
        }
        if (!function_exists('get_plugins')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_folder = get_plugins('/woocommerce');
        $plugin_file = 'woocommerce.php';
        $wc_installed_version = NULL;
        if (isset($plugin_folder[$plugin_file]['Version'])) {
            $wc_installed_version = $plugin_folder[$plugin_file]['Version'];
        }
        return $wc_installed_version;
    }
}

/**
 * Determines if the WordPress compatible.
 *
 * @return bool
 * @since 1.0.0
 *
 */
if(!function_exists('isAWDRWpCompatible')){
    function isAWDRWpCompatible()
    {
        $required_wp_version = 4.9;
        return version_compare(get_bloginfo('version'), $required_wp_version, '>=');
    }
}

if(!function_exists('awdr_check_compatible')){
    function awdr_check_compatible(){
        if (!isAWDREnvironmentCompatible()) {
            exit(__('This plugin can not be activated because it requires minimum PHP version of ', WDR_TEXT_DOMAIN) . ' ' . WDR_REQUIRED_PHP_VERSION);
        }
        if (!isAWDRWooActive()) {
            exit(__('Woocommerce must installed and activated in-order to use Advanced woo discount rules!', WDR_TEXT_DOMAIN));
        }
        if (!isAWDRWooCompatible()) {
            exit(__(' Advanced woo discount rules requires at least Woocommerce', WDR_TEXT_DOMAIN) . ' ' . WDR_WC_REQUIRED_VERSION);
        }
    }
}
