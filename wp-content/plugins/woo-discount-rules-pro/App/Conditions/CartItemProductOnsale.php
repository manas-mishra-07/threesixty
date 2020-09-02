<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use Wdr\App\Helpers\Woocommerce;

class CartItemProductOnsale extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_item_product_onsale';
        $this->label = __('On sale products', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart Items', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/product-onsale.php';
    }

    public function check($cart, $options)
    {

        if(!empty($cart)){
            $operator = isset($options->operator) ? $options->operator : 'in_list';
            $result = array();
            foreach ($cart as $cart_item){
                $product =  isset($cart_item['data']) ? $cart_item['data'] : false;
                if($product){
                    if ('in_list' === $operator) {
                        $result[] = (Woocommerce::isProductInSale($product)) ? 'true' : 'false';
                    } elseif ('not_in_list' === $operator) {
                        $result[] = (Woocommerce::isProductInSale($product)) ? 'false' : 'true';
                    } elseif ('any' === $operator) {
                        $result[] = 'false';
                    }
                }
            }
            if(!empty($result)){
                $result = array_unique($result);
                return (in_array("false", $result)) ? false : true;
            }
            return false;
        }
    }
}