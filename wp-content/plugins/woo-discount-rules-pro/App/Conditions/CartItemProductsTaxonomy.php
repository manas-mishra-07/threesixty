<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class CartItemProductsTaxonomy extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_item_products_taxonomy';
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        $custom_taxonomy = isset($options->custom_taxonomy) ? $options->custom_taxonomy : 'products_taxonomy';
        return $this->doCartItemsCheck($cart, $options, $custom_taxonomy);
    }
}