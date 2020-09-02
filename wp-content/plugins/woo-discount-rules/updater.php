<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if(!class_exists('FlycartWooDiscountRulesExistingPROUpdater')){
    class FlycartWooDiscountRulesExistingPROUpdater{
        protected static $config_key = 'woo-discount-config-v2';
        protected static $slug = 'woo-discount-rules';
        protected static $plugin_name = 'Discount Rules for WooCommerce';
        protected static $flycart_url = 'https://www.flycart.org/';
        protected static $update_url = 'https://www.flycart.org/';//?wpaction=updatecheck&wpslug=woo-discount-rules&pro=1

        /**
         * Initialise
         * */
        public static function init(){
            self::hooks();
        }

        public static function installProPlugin(){
            $download_url = null;
            if(!self::is_plugin_installed( 'woo-discount-rules-pro/woo-discount-rules-pro.php' )){
                $licence_key = self::getLicenceKey();
                if(!empty($licence_key)){
                    $update_url = self::getProUpdateURL('updatecheck', $licence_key);
                    $result = wp_remote_get( $update_url , array());
                    $status = self::validateApiResponse($result);
                    if ( !is_wp_error($status) ){
                        $json = json_decode( $result['body'] );
                        if ( is_object($json) && isset($json->download_url)) {
                            if(!empty($json->download_url)){
                                $download_url = $json->download_url;
                            }
                        }
                    }
                }
            }
            if($download_url != null && !empty($download_url)){
                add_filter( 'upgrader_source_selection', function ($upgrader){
                    $upgrader->strings = array();
                    return $upgrader;
                } );
                include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                wp_cache_flush();
                $upgrader = new Plugin_Upgrader();
                $installed = $upgrader->install( $download_url );
                if($installed){
                    $activate = activate_plugin( "woo-discount-rules-pro/woo-discount-rules-pro.php" );
                }
                if ( ! $upgrader->result || is_wp_error( $upgrader->result ) ) {
                    echo "<input type='hidden' id='wdr_pro_install_status' value='0'/>";
                    echo "<div class='awdr_pro_install_message'>".__('Please download the Pro 2.0 pack from My Downloads page in our site, install and activate it. <a href="https://docs.flycart.org/en/collections/2195266?utm_source=woo-discount-rules-v2&utm_campaign=doc&utm_medium=text-click&utm_content=documentation" target="_blank">Here is a guide and video tutorial</a>', WDR_TEXT_DOMAIN)."</div>";
                } else {
                    echo "<input type='hidden' id='wdr_pro_install_status' value='1'/>";
                    echo "<div class='awdr_pro_install_message'>".__('Redirecting to v2 please wait..')."</div";
                }
            }
        }

        public static function availableAutoInstall(){
            if(!self::is_plugin_installed( 'woo-discount-rules-pro/woo-discount-rules-pro.php' )){
                $licence_key = self::getLicenceKey();
                if(!empty($licence_key)){
                    $update_url = self::getProUpdateURL('updatecheck', $licence_key);
                    $result = wp_remote_get( $update_url , array());
                    $status = self::validateApiResponse($result);
                    if ( !is_wp_error($status) ){
                        $json = json_decode( $result['body'] );
                        if ( is_object($json) && isset($json->download_url)) {
                            if(!empty($json->download_url)){
                                return true;
                            }
                        }
                    }
                }
            }

            return false;
        }

        public static function  is_plugin_installed( $slug ) {
            if ( ! function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            $all_plugins = get_plugins();

            if ( !empty( $all_plugins[$slug] ) ) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Hooks
         * */
        protected static function hooks(){
            add_filter('puc_request_info_result-woo-discount-rules', array(__CLASS__, 'loadWooDiscountRulesUpdateDetails'), 10, 2);
            self::runUpdater();

            //add_action('after_plugin_row', array(__CLASS__, 'messageAfterPluginRow'), 10, 3);
            //add_action('admin_notices', array(__CLASS__, 'errorNoticeInAdminPages'));
        }

        /**
         * Update Licence key with settings
         * */
        protected static function updateLicenceKeyInSettings($licence_key){
            $config = get_option(self::$config_key);
            $config['licence_key'] = $licence_key;
            update_option(self::$config_key, $config);
        }

        /**
         * Update licence key as validated
         * */
        protected static function updateLicenceKeyAsValidated($status){
            update_option('advanced_woo_discount_rules_licence_verified_time', time());
            if($status){
                update_option('advanced_woo_discount_rules_licence_status', 1);
            } else {
                update_option('advanced_woo_discount_rules_licence_status', 0);
            }
        }

        /**
         * Get licence key verified status
         * */
        public static function getLicenceKeyVerifiedStatus(){
            if(self::hasPro()){
                return get_option('advanced_woo_discount_rules_licence_status', 0);
            } else {
                return get_option('woo_discount_rules_verified_key', 0);
            }
        }

        /**
         * Get message for licence key
         * */
        public static function messageForLicenceKey($status, $licence_key){
            if(empty($licence_key)){
                return '<p class="wdr-licence-invalid-text">'.esc_html__('Please enter a valid license key', WDR_TEXT_DOMAIN).'</p>';
            } else {
                if($status){
                    return '<p class="wdr-licence-valid-text">'.esc_html__('License key check : Passed.', WDR_TEXT_DOMAIN).'</p>';
                } else {
                    return '<p class="wdr-licence-invalid-text">'.esc_html__('License key seems to be Invalid. Please enter a valid license key', WDR_TEXT_DOMAIN).'</p>';
                }
            }
        }

        /**
         * Check licence key is valid
         *
         * @param $key string
         * @return boolean
         * */
        protected static function isValidLicenceKey($key)
        {
            $licence_check_url = self::getUpdateURL('licensecheck', $key);
            $result = wp_remote_get( $licence_check_url , array());

            $status = self::validateApiResponse($result);
            if ( !is_wp_error($status) ){
                $json = json_decode( $result['body'] );
                if ( is_object($json) && isset($json->license_check)) {
                    return (bool)$json->license_check;
                }
            }

            return false;
        }

        /**
         * Check if $result is a successful update API response.
         *
         * @param array|WP_Error $result
         * @return true|WP_Error
         */
        protected static function validateApiResponse($result) {
            if ( is_wp_error($result) ) { /** @var WP_Error $result */
                return new \WP_Error($result->get_error_code(), 'WP HTTP Error: ' . $result->get_error_message());
            }

            if ( !isset($result['response']['code']) ) {
                return new \WP_Error(
                    'puc_no_response_code',
                    'wp_remote_get() returned an unexpected result.'
                );
            }

            if ( $result['response']['code'] !== 200 ) {
                return new \WP_Error(
                    'puc_unexpected_response_code',
                    'HTTP response code is ' . $result['response']['code'] . ' (expected: 200)'
                );
            }

            if ( empty($result['body']) ) {
                return new \WP_Error('puc_empty_response', 'The metadata file appears to be empty.');
            }

            return true;
        }

        /**
         * Run Plugin updater
         * */
        protected static function runUpdater(){
            require WDR_PLUGIN_BASE_PATH.'v1/vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';
            $update_url = self::getUpdateURL();
            try {
                $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
                    $update_url,
                    WDR_PLUGIN_BASE_PATH.'woo-discount-rules.php',
                    'woo-discount-rules'
                );
            } catch (\Exception $e){}
        }

        /**
         * Check has pro version
         *
         * @return boolean
         * */
        public static function hasPro(){
            if (defined('WDR_PRO'))
                if(WDR_PRO === true) return true;

            return false;
        }

        /**
         * Get licence key
         *
         * @return string
         * */
        protected static function getLicenceKey(){
            if(self::hasPro()){
                $config = get_option(self::$config_key);
                if (isset($config['licence_key'])) {
                    return $config['licence_key'];
                } else {
                    return '';
                }
            } else {
                $config = get_option('woo-discount-config');
                if (is_string($config)) $config = json_decode($config);
                return isset($config->license_key)? $config->license_key: null;

            }
        }

        /**
         * Get update URL
         * @param $type string
         *
         * @return string
         * */
        public static function getProUpdateURL($type = 'updatecheck', $licence_key = null)
        {
            $update_url = self::$update_url.'?wpaction='.$type.'&wpslug=discount-rules-v2-pro&pro=1';
            if(empty($licence_key)){
                $licence_key = self::getLicenceKey();
            }
            $update_url .= '&dlid='.$licence_key;
            return $update_url;
        }

        /**
         * Get update URL
         * @param $type string
         *
         * @return string
         * */
        public static function getUpdateURL($type = 'updatecheck', $licence_key = null)
        {
            $update_url = self::$update_url.'?wpaction='.$type.'&wpslug='.self::$slug.'&pro=1';
            if(empty($licence_key)){
                $licence_key = self::getLicenceKey();
            }
            $update_url .= '&dlid='.$licence_key;
            return $update_url;
        }

        /**
         * Error notice on admin pages
         * */
        public static function errorNoticeInAdminPages(){
            $htmlPrefix = '<div class="notice notice-warning"><p>';
            $htmlSuffix = '</p></div>';
            $message = self::getErrorMessageIfExists();
            if($message['has_message']){
                echo $htmlPrefix.$message['message'].$htmlSuffix;
            }
        }

        /**
         * Get message to display
         *
         * @return array
         * */
        protected static function getErrorMessageIfExists(){
            $licence_key = self::getLicenceKey();
            $message['has_message'] = false;
            $message['message'] = '';
            $enter_valid_anchor_tag = '<a href="admin.php?page=woo_discount_rules&tab=settings">'.__('Please enter a valid license key').'</a>';
            $flycart_anchor_tag = '<a href="'.self::$flycart_url.'" target="_blank">'.__('our website').'</a>';
            if ( !empty($licence_key) ) {
                $verifiedLicense = self::getLicenceKeyVerifiedStatus();
                if(!$verifiedLicense){
                    $message['message'] = sprintf(__('License key for the %s seems invalid. %s, you can get it from %s', WDR_TEXT_DOMAIN), self::$plugin_name, $enter_valid_anchor_tag, $flycart_anchor_tag);
                    $message['has_message'] = true;
                }
            } else {
                $message['message'] = sprintf(__('License key for the %s is not entered. %s, you can get it from %s', WDR_TEXT_DOMAIN), self::$plugin_name, $enter_valid_anchor_tag, $flycart_anchor_tag);
                $message['has_message'] = true;
            }

            return $message;
        }

        /**
         * Hook to check and display updates below plugin in Admin Plugins section
         * This plugin checks for license key validation and displays error notices
         * @param string $plugin_file our plugin file
         * @param string $plugin_data Plugin details
         * @param string $status
         * */
        public static function messageAfterPluginRow( $plugin_file, $plugin_data, $status ){
            if( isset($plugin_data['TextDomain']) && $plugin_data['TextDomain'] == 'woo-discount-rules' ){
                $message = self::getErrorMessageIfExists();
                if($message['has_message']){
                    // If an update is available ?
                    // prevent update if error occurs
                    echo '<tr>';
                    echo '<td> </td>';
                    echo '<td colspan="2"> <div class="notice-message error inline notice-error notice-alt"><p>'.$message['message'].'</p></div></td>';
                    echo '</tr>';
                }

                if(empty($plugin_data['package']) && !empty($plugin_data['upgrade_notice'])){
                    echo '<tr class="plugin-update-tr active" data-slug="woo-discount-rules">';
                    echo '<td class="plugin-update colspanchange" colspan="3"> <div class="notice inline notice-warning notice-alt"><p>'.$plugin_data['upgrade_notice'].'</p></div></td>';
                    echo '</tr>';
                }
            }

        }

        /**
         * To load Woo discount rules update details
         * */
        public static function loadWooDiscountRulesUpdateDetails($pluginInfo, $result){
            try{
                global $wp_version;
                // include an unmodified $wp_version
                include( ABSPATH . WPINC . '/version.php' );
                $args = array('slug' => 'woo-discount-rules', 'fields' => array('active_installs'));
                $response = wp_remote_post(
                    'http://api.wordpress.org/plugins/info/1.0/',
                    array(
                        'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' ),
                        'body' => array(
                            'action' => 'plugin_information',
                            'request'=>serialize((object)$args)
                        )
                    )
                );

                if(!empty($response)){
                    $returned_object = maybe_unserialize(wp_remote_retrieve_body($response));
                    if(!empty($returned_object)){
                        if(empty($pluginInfo)){$pluginInfo = new \stdClass();}
                        if(!empty($returned_object->name)) $pluginInfo->name = $returned_object->name;
                        if(!empty($returned_object->sections)) $pluginInfo->sections = $returned_object->sections;
                        if(!empty($returned_object->author)) $pluginInfo->author = $returned_object->author;
                        if(!empty($returned_object->author_profile)) $pluginInfo->author_profile = $returned_object->author_profile;
                        if(!empty($returned_object->requires)) $pluginInfo->requires = $returned_object->requires;
                        if(!empty($returned_object->tested)) $pluginInfo->tested = $returned_object->tested;
                        if(!empty($returned_object->rating)) $pluginInfo->rating = $returned_object->rating;
                        if(!empty($returned_object->ratings)) $pluginInfo->ratings = $returned_object->ratings;
                        if(!empty($returned_object->num_ratings)) $pluginInfo->num_ratings = $returned_object->num_ratings;
                        if(!empty($returned_object->support_threads)) $pluginInfo->support_threads = $returned_object->support_threads;
                        if(!empty($returned_object->support_threads_resolved)) $pluginInfo->support_threads_resolved = $returned_object->support_threads_resolved;
                        if(!empty($returned_object->downloaded)) $pluginInfo->downloaded = $returned_object->downloaded;
                        if(!empty($returned_object->last_updated)) $pluginInfo->last_updated = $returned_object->last_updated;
                        if(!empty($returned_object->added)) $pluginInfo->added = $returned_object->added;
                        if(!empty($returned_object->versions)) $pluginInfo->versions = $returned_object->versions;
                        if(!empty($returned_object->tags)) $pluginInfo->tags = $returned_object->tags;
                        if(!empty($returned_object->screenshots)) $pluginInfo->screenshots = $returned_object->screenshots;
                        if(!empty($returned_object->active_installs)) $pluginInfo->active_installs = $returned_object->active_installs;
                    }
                }
            } catch (\Exception $e){}

            return $pluginInfo;
        }
    }
}