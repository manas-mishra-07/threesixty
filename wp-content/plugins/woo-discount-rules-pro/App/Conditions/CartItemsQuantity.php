<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use Wdr\App\Controllers\DiscountCalculator;
use Wdr\App\Helpers\Helper;

class CartItemsQuantity extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'cart_items_quantity';
        $this->label = __('Item quantity', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Cart/cart-quantity.php';
    }

    function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        $total_quantities = 0;
        if (!empty($cart)) {
            if($options->calculate_from == 'from_filter'){
                $total_quantities = DiscountCalculator::getFilterBasedCartQuantities('cart_quantities', $this->rule);
            }else{
                foreach ($cart as $cart_item) {
                    if(Helper::isCartItemConsideredForCalculation(true, $cart_item, "cart_item_qty_condition")){
                        $total_quantities += intval((isset($cart_item['quantity'])) ? $cart_item['quantity'] : 0);
                    }
                }
            }
        }
        if (isset($options->operator) && $options->value && !empty($total_quantities)) {
            $operator = sanitize_text_field($options->operator);
            $value = $options->value;
            return $this->doComparisionOperation($operator, $total_quantities, $value);
        }
        return false;
    }
}