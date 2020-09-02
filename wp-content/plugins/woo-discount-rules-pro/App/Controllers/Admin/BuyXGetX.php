<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Template;
use WDRPro\App\Rules\BuyXGetX as RulesBuyXGetX;

class BuyXGetX
{
    public static function init(){
        self::hooks();
    }

    /**
     * Hooks
     * */
    protected static function hooks(){
        add_filter('advanced_woo_discount_rules_adjustment_type', array(__CLASS__, 'addAdjustmentType'));
        add_action('advanced_woo_discount_rules_admin_after_load_rule_fields', array(__CLASS__, 'addFields'));
    }

    /**
     * Add adjustment type
     *
     * @param $adjustment_type array
     * @return array
     * */
    public static function addAdjustmentType($adjustment_type){
        $adjustment_type['wdr_buy_x_get_x_discount'] = array(
            'class' => '',
            'label' => __('Buy X get X', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Bogo Discount', WDR_PRO_TEXT_DOMAIN),
            'template' => '',
        );

        return $adjustment_type;
    }

    /**
     * Add fields
     * */
    public static function addFields($rule){
        //Buy X Get X
        if ($get_buyx_getx_adjustments = RulesBuyXGetX::getBuyXGetXAdjustments($rule)) {
            $buyx_getx_cart_rule = (isset($get_buyx_getx_adjustments->apply_as_cart_rule) && !empty($get_buyx_getx_adjustments->apply_as_cart_rule)) ? $get_buyx_getx_adjustments->apply_as_cart_rule : '';
            $get_buyx_getx_adjustments = (isset($get_buyx_getx_adjustments->ranges) && !empty($get_buyx_getx_adjustments->ranges)) ? $get_buyx_getx_adjustments->ranges : '';

        }
        $template =  new Template();
        $data['rule'] = $rule;
        $data['buyx_getx_cart_rule'] = isset($buyx_getx_cart_rule)? $buyx_getx_cart_rule: null;
        $data['get_buyx_getx_adjustments'] = isset($get_buyx_getx_adjustments)? $get_buyx_getx_adjustments: null;
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Discounts/buy-x-get-x.php');
        $template->setData($data);
        $template->display();
    }
}

BuyXGetX::init();