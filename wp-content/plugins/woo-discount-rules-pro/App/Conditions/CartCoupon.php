<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class CartCoupon extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_coupon';
        $this->label = __('Coupons', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Cart/coupon.php';
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        $result = false;
        if (isset($options->operator)) {
            $list = isset($options->value) ? (array)$options->value : array();
            $custom_coupon = isset($options->custom_value) ? $options->custom_value : array();
            $applied_coupons = self::$woocommerce_helper->getAppliedCoupons();
            switch ($options->operator) {
                case 'at_least_one':
                    $result = !empty(array_intersect($applied_coupons, $list));
                    break;
                case 'all':
                    $result = (count(array_intersect($applied_coupons, $list)) >= count($list));
                    break;
                case 'only':
                    $result = (count(array_intersect($applied_coupons, $list)) == count($list));
                    break;
                case 'none':
                    $result = (count(array_intersect($applied_coupons, $list)) == 0);
                    break;
                case 'none_at_all':
                    $result = empty($applied_coupons);
                    break;
                case 'custom_coupon':
                    if(isset($custom_coupon) && !empty($custom_coupon)){
                        $result = in_array( $custom_coupon, $applied_coupons);
                    }
                    break;
                default:
                case 'at_least_one_any':
                    $result = !empty($applied_coupons);
                    break;
            }
        }
        return $result;
    }
}