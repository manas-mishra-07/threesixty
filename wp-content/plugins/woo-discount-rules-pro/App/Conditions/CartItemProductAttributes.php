<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class CartItemProductAttributes extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_item_product_attributes';
        $this->label = __('Attributes', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart Items', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/product-attributes.php';
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        return $this->doCartItemsCheck($cart, $options, 'product_attributes');
    }
}