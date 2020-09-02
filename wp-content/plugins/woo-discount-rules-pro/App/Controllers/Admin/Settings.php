<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Template;

class Settings
{
    public static function init(){
        self::hooks();
    }

    /**
     * Hooks
     * */
    protected static function hooks(){
        add_action('advanced_woo_discount_rules_before_general_settings_fields', array(__CLASS__, 'loadGeneralSettings'));
        add_action('advanced_woo_discount_rules_cart_settings_fields', array(__CLASS__, 'loadCartSettings'));
        add_action('advanced_woo_discount_rules_promotion_settings_fields', array(__CLASS__, 'loadPromotionSettings'));
    }

    /**
     * load general settings
     *
     * @param $configuration object
     * @return array
     * */
    public static function loadGeneralSettings($configuration){
        $template =  new Template();
        $data['configuration'] = $configuration;
        $data['licence_key_message'] = UpdateHandler::messageForLicenceKey(UpdateHandler::getLicenceKeyVerifiedStatus(), $configuration->getConfig('licence_key', ''));
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Settings/general.php');
        $template->setData($data);
        $template->display();
    }

    /**
     * load promotion settings
     *
     * @param $configuration object
     * @return array
     * */
    public static function loadPromotionSettings($configuration){
        $template =  new Template();
        $data['configuration'] = $configuration;
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Settings/promotion.php');
        $template->setData($data);
        $template->display();
    }

    /**
     * load cart settings
     *
     * @param $configuration object
     * @return array
     * */
    public static function loadCartSettings($configuration){
        $template =  new Template();
        $data['configuration'] = $configuration;
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Settings/cart.php');
        $template->setData($data);
        $template->display();
    }
}

Settings::init();