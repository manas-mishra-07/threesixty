<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use Wdr\App\Controllers\Configuration;
use Wdr\App\Helpers\Helper;

class CartItemProductCombination extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_item_product_combination';
        $this->label = __('Product combination', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart Items', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/product-combination.php';
        $this->config = new Configuration();
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        $result = false;
        if (isset($options->operator) && isset($options->type) && isset($options->product) && is_array($options->product) && isset($options->from) && isset($options->from) && isset($options->to)) {
            if (empty($options->product)) {
                return true;
            }
            $apply_discount_to_child = apply_filters('advanced_woo_discount_rules_apply_discount_to_child', true);
            if($apply_discount_to_child){
                if(isset($options->product_variants) && !empty($options->product_variants) && is_array($options->product_variants)){
                    $options->product = Helper::combineProductArrays($options->product, $options->product_variants);
                }
            }
            $operator = $options->operator;
            $value_1 = $options->from;
            $value_2 = $options->to;
            $total_quantities_arr = array();
            if (!empty($cart)) {
                $total_quantities_arr = array_fill_keys($options->product, 0);
                foreach ($cart as $cart_item) {
                    $item = (isset($cart_item['data']) && !empty($cart_item['data'])) ? $cart_item['data'] : NULL;
                    if(Helper::isCartItemConsideredForCalculation(true, $cart_item, "product_combination")){
                        $product_id = self::$woocommerce_helper->getProductId($item);
                        if (in_array($product_id, $options->product)) {
                            $total_quantities_arr[$product_id] = intval((isset($cart_item['quantity'])) ? $cart_item['quantity'] : 0);
                        }
                    }
                }
            }
            if (!empty($total_quantities_arr)) {
                switch ($options->type) {
                    case "any":
                        $res = array();
                        foreach ($total_quantities_arr as $quantity) {
                            if($quantity > 0){
                                if ($this->doComparisionOperation($operator, $quantity, $value_1, $value_2)) {
                                    $res[] = 1;
                                }
                            }
                        }
                        $result = !empty($res);
                        break;
                    case "each":
                        $res = array();
                        foreach ($total_quantities_arr as $quantity) {
                            if($quantity > 0) {
                                if (!$this->doComparisionOperation($operator, $quantity, $value_1, $value_2)) {
                                    $res[] = 0;
                                    break;
                                }
                            } else {
                                $res[] = 0;
                                break;
                            }
                        }
                        $result = empty($res);
                        break;
                    default:
                    case "combine":
                        $total_quantities = array_sum($total_quantities_arr);
                        $result = false;
                        if($total_quantities > 0){
                            $result = $this->doComparisionOperation($operator, $total_quantities, $value_1, $value_2);
                        }
                        break;
                }
            }
        }
        return $result;
    }
}