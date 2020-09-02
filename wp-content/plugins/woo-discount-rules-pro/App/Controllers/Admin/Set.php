<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Template;
use Wdr\App\Rules\BuyXGetY as RulesBuyXGetY;

class Set
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
        $adjustment_type['wdr_set_discount'] = array(
            'class' => '',
            'label' => __('Bundle (Set) Discount', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Bulk Discount', WDR_PRO_TEXT_DOMAIN),
            'template' => '',
        );

        return $adjustment_type;
    }

    /**
     * Add fields
     * */
    public static function addFields($rule){

        //Set adjustments
        if ($get_set_adjustments = \WDRPro\App\Rules\Set::getAdjustments($rule)) {
            $set_adj_operator = (isset($get_set_adjustments->operator) && !empty($get_set_adjustments->operator)) ? $get_set_adjustments->operator : 'product_cumulative';
            $set_adj_as_cart = (isset($get_set_adjustments->apply_as_cart_rule) && !empty($get_set_adjustments->apply_as_cart_rule)) ? $get_set_adjustments->apply_as_cart_rule : '';
            $set_adj_as_cart_label = (isset($get_set_adjustments->cart_label) && !empty($get_set_adjustments->cart_label)) ? $get_set_adjustments->cart_label : '';
            $set_adj_ranges = (isset($get_set_adjustments->ranges) && !empty($get_set_adjustments->ranges)) ? $get_set_adjustments->ranges : false;
            $set_adj_message = (isset($get_set_adjustments->table_message) && !empty($get_set_adjustments->table_message)) ? $get_set_adjustments->table_message : false;
        } else {
            $set_adj_operator = 'product_cumulative';
            $set_adj_as_cart = '';
            $set_adj_ranges = false;
            $set_adj_message = "";
        }

        $template =  new Template();
        $data['rule'] = $rule;
        $data['set_adj_operator'] = isset($set_adj_operator)? $set_adj_operator: null;
        $data['set_adj_as_cart'] = isset($set_adj_as_cart)? $set_adj_as_cart: null;
        $data['set_adj_ranges'] = isset($set_adj_ranges)? $set_adj_ranges: null;
        $data['set_adj_message'] = isset($set_adj_message)? $set_adj_message: null;
        $data['set_adj_as_cart_label'] = isset($set_adj_as_cart_label)? $set_adj_as_cart_label: null;
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Discounts/set.php');
        $template->setData($data);
        $template->display();
    }
}

Set::init();