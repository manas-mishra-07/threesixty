<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
class GeneralHooks
{
    public static function init(){
        self::hook();
    }

    protected static function hook(){
        add_action('admin_enqueue_scripts', array(__CLASS__, 'adminPageScript'), 100 );
    }

    public static function adminPageScript(){
        wp_register_style('woo_discount_pro_admin_style', WDR_PRO_PLUGIN_URL . '/Assets/Css/admin_style.css', array(), WDR_PRO_VERSION);
        wp_enqueue_style('woo_discount_pro_admin_style');

        wp_register_script('woo_discount_pro_admin_script', WDR_PRO_PLUGIN_URL . '/Assets/Js/wdr_pro_admin.js', array(), WDR_PRO_VERSION);
        wp_enqueue_script('woo_discount_pro_admin_script');

        $localization_data = self::getLocalizationData();
        wp_localize_script( 'woo_discount_pro_admin_script', 'woo_discount_pro_localization', $localization_data);
    }

    /**
     * Localization text
     *
     * @return array
     * */
    public static function getLocalizationData(){
        return array(
            'validate' => esc_html__('Validate', WDR_PRO_TEXT_DOMAIN),
            'validating_please_wait' => esc_html__('Validating please wait..', WDR_PRO_TEXT_DOMAIN),
        );
    }
}

GeneralHooks::init();

