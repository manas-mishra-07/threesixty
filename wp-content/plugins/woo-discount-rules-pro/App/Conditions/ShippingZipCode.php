<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class ShippingZipCode extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'shipping_zipcode';
        $this->label = __('Zipcode', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Shipping', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Shipping/zip-code.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $shipping_post_code = self::$woocommerce_helper->getShippingZipCode();
            if (!empty($shipping_post_code)) {
                $post_code_list = (!is_array($options->value) && !is_object($options->value)) ? explode(',', $options->value) : $options->value;
                $post_code_array = array();
                if (!empty($post_code_list)) {
                    foreach ($post_code_list as $post_code) {
                        $post_code_array[] = strtolower(trim($post_code));
                    }
                }
                return $this->doCompareInListOperation($options->operator, $shipping_post_code, $post_code_array);
            }
        }
        return false;
    }
}