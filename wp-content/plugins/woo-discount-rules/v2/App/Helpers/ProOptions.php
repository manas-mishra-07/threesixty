<?php

namespace Wdr\App\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ProOptions
{
    public static function init(){
        self::hooks();
    }

    /**
     * Hooks
     * */
    protected static function hooks(){
        add_filter('advanced_woo_discount_rules_filters', array(__CLASS__, 'addProFilters'));
        add_filter('advanced_woo_discount_rules_conditions', array(__CLASS__, 'addProConditions'));
        add_filter('advanced_woo_discount_rules_adjustment_type', array(__CLASS__, 'addProAdjustmentType'));
    }

    /**
     * Add Pro adjustment type
     *
     * @param $filter_types array
     * @return array
     * */
    public static function addProFilters($filter_types){
        $is_pro = Helper::hasPro();
        if($is_pro === false){
            $filter_types['product_category'] = array(
                'active' => false,
                'label' => __('Category - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Product', WDR_TEXT_DOMAIN),
                'template' => '',
            );
            $filter_types['product_attributes'] = array(
                'active' => false,
                'label' => __('Attributes - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Product', WDR_TEXT_DOMAIN),
                'template' => '',
            );
            $filter_types['product_tags'] = array(
                'active' => false,
                'label' => __('Tags - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Product', WDR_TEXT_DOMAIN),
                'template' => '',
            );
            $filter_types['product_sku'] = array(
                'active' => false,
                'label' => __('SKUs - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Product', WDR_TEXT_DOMAIN),
                'template' => '',
            );
            $filter_types['product_on_sale'] = array(
                'active' => false,
                'label' => __('On sale products - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Product', WDR_TEXT_DOMAIN),
                'template' => '',
            );

        }

        return $filter_types;
    }

    /**
     * Add Pro conditions
     *
     * @param $available_conditions array
     * @return array
     * */
    public static function addProConditions($available_conditions){
        $is_pro = Helper::hasPro();
        if($is_pro === false){
            $available_conditions['cart_coupon'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Coupons - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_item_product_attributes'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Attributes - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart Items', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_item_product_category'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Category - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart Items', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_item_product_combination'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Product combination - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart Items', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_item_products'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Products - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart Items', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_item_product_sku'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('SKU - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart Items', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_item_product_tags'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Tags - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart Items', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_items_quantity'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Cart items quantity - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_items_weight'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Total weight - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['cart_payment_method'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Payment Method - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Cart', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['order_date'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Date - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Date & Time', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['order_date_and_time'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Date and Time - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Date & Time', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['order_days'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Days - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Date & Time', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['order_time'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Time - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Date & Time', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['purchase_first_order'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('First order - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Purchase History', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['purchase_last_order'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Last order - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Purchase History', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['purchase_last_order_amount'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Last order amount - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Purchase History', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['purchase_previous_orders'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Number of orders made - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Purchase History', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['purchase_previous_orders_for_specific_product'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Number of orders made with following products - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Purchase History', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['purchase_spent'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Spent - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Purchase History', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['shipping_city'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('City - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Shipping', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['shipping_country'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Country - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Shipping', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['shipping_state'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('State - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Shipping', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['shipping_zipcode'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Zipcode - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Shipping', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['user_email'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Email - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Customer', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['user_list'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('User - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Customer', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['user_logged_in'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('Is logged in - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Customer', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );
            $available_conditions['user_role'] = array(
                'object' => '\Wdr\App\Conditions\Base',
                'enable' => false,
                'label' => __('User role - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Customer', WDR_TEXT_DOMAIN),
                'template' => '',
                'extra_params' => array(),
            );

        }
        return $available_conditions;
    }

    /**
     * Add Pro adjustment type
     *
     * @param $adjustment_type array
     * @return array
     * */
    public static function addProAdjustmentType($adjustment_type){
        $is_pro = Helper::hasPro();
        if($is_pro === false){
            $adjustment_type['wdr_buy_x_get_x_discount'] = array(
                'class' => '',
                'enable' => false,
                'label' => __('Buy X get X - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Bogo Discount', WDR_TEXT_DOMAIN),
                'template' => '',
            );
            $adjustment_type['wdr_buy_x_get_y_discount'] = array(
                'class' => '',
                'enable' => false,
                'label' => __('Buy X get Y - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Bogo Discount', WDR_TEXT_DOMAIN),
                'template' => '',
            );
            $adjustment_type['wdr_free_shipping'] = array(
                'class' => '',
                'enable' => false,
                'label' => __('Free Shipping - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Simple Discount', WDR_TEXT_DOMAIN),
            );
            $adjustment_type['wdr_set_discount'] = array(
                'class' => '',
                'enable' => false,
                'label' => __('Bundle (Set) Discount - PRO -', WDR_TEXT_DOMAIN),
                'group' => __('Bulk Discount', WDR_TEXT_DOMAIN),
            );
        }

        return $adjustment_type;
    }
}

ProOptions::init();