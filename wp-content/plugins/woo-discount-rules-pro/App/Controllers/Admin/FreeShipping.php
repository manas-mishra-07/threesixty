<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
class FreeShipping
{
    public static function init(){
        self::hooks();
    }

    /**
     * Hooks
     * */
    protected static function hooks(){
        add_filter('advanced_woo_discount_rules_adjustment_type', array(__CLASS__, 'addAdjustmentType'));
    }

    /**
     * Add adjustment type
     *
     * @param $adjustment_type array
     * @return array
     * */
    public static function addAdjustmentType($adjustment_type){
        $adjustment_type['wdr_free_shipping'] = array(
            'class' => '',
            'label' => __('Free Shipping', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Simple Discount', WDR_PRO_TEXT_DOMAIN),
            'template' => '',
        );

        return $adjustment_type;
    }
}

FreeShipping::init();