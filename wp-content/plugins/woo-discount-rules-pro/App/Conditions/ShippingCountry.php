<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class ShippingCountry extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'shipping_country';
        $this->label = __('Country', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Shipping', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Shipping/country.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $shipping_country = $this->input->post('calc_shipping_country', NULL);
            if (empty($shipping_country) || is_null($shipping_country)) {
                $shipping_country = self::$woocommerce_helper->getShippingCountry();
            }
            if (!empty($shipping_country)) {
                return $this->doCompareInListOperation($options->operator, $shipping_country, $options->value);
            }
        }
        return false;
    }
}