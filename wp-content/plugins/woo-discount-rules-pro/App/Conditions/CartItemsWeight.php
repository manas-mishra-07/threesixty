<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use Wdr\App\Helpers\Helper;

class CartItemsWeight extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'cart_items_weight';
        $this->label = __('Total weight', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Cart/weight.php';
    }

    function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        $total_weight = 0;
        if (!empty($cart)) {
            foreach ($cart as $cart_item) {
                if(Helper::isCartItemConsideredForCalculation(true, $cart_item, "cart_item_weight_condition")){
                    $item_weight = floatval(isset($cart_item['data']) ? self::$woocommerce_helper->getWeight($cart_item['data']) : 0);
                    $item_quantity = intval((isset($cart_item['quantity']) && !empty($cart_item['quantity'])) ? $cart_item['quantity'] : 0);
                    $total_weight += floatval($item_weight * $item_quantity);
                }
            }
        }
        if (isset($options->operator) && $options->value && !empty($total_weight)) {
            $operator = sanitize_text_field($options->operator);
            $value = $options->value;
            return $this->doComparisionOperation($operator, $total_weight, $value);
        }
        return false;
    }
}