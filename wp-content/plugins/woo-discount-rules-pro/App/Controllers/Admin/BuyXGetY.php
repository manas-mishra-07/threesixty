<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Template;
use WDRPro\App\Rules\BuyXGetY as RulesBuyXGetY;

class BuyXGetY
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
        $adjustment_type['wdr_buy_x_get_y_discount'] = array(
            'class' => '',
            'label' => __('Buy X get Y', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Bogo Discount', WDR_PRO_TEXT_DOMAIN),
            'template' => '',
        );

        return $adjustment_type;
    }

    /**
     * Add fields
     * */
    public static function addFields($rule){
        //Buy X Get Y
        if ($get_buyx_gety_adjustments = RulesBuyXGetY::getBuyXGetYAdjustmentsForAdmin($rule)) {
            $get_buyx_gety_operator = (isset($get_buyx_gety_adjustments->operator) && !empty($get_buyx_gety_adjustments->operator)) ? $get_buyx_gety_adjustments->operator : 'product_cumulative';
            $get_buyx_gety_types = (isset($get_buyx_gety_adjustments->type) && !empty($get_buyx_gety_adjustments->type)) ? $get_buyx_gety_adjustments->type : '';
            $get_buyx_gety_mode = (isset($get_buyx_gety_adjustments->mode) && !empty($get_buyx_gety_adjustments->mode)) ? $get_buyx_gety_adjustments->mode : '';
            $get_buyx_gety_cart_rule = (isset($get_buyx_gety_adjustments->apply_as_cart_rule) && !empty($get_buyx_gety_adjustments->apply_as_cart_rule)) ? $get_buyx_gety_adjustments->apply_as_cart_rule : '';
            $get_buyx_gety_adjustments = (isset($get_buyx_gety_adjustments->ranges) && !empty($get_buyx_gety_adjustments->ranges)) ? $get_buyx_gety_adjustments->ranges : '';
        }else{
            $get_buyx_gety_operator = 'product_cumulative';
        }
        $template =  new Template();
        $data['rule'] = $rule;
        $data['get_buyx_gety_operator'] = isset($get_buyx_gety_operator)? $get_buyx_gety_operator: null;
        $data['get_buyx_gety_types'] = isset($get_buyx_gety_types)? $get_buyx_gety_types: null;
        $data['get_buyx_gety_mode'] = isset($get_buyx_gety_mode)? $get_buyx_gety_mode: null;
        $data['get_buyx_gety_cart_rule'] = isset($get_buyx_gety_cart_rule)? $get_buyx_gety_cart_rule: null;
        $data['get_buyx_gety_adjustments'] = isset($get_buyx_gety_adjustments)? $get_buyx_gety_adjustments: null;
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Discounts/buy-x-get-y.php');
        $template->setData($data);
        $template->display();
    }
}

BuyXGetY::init();