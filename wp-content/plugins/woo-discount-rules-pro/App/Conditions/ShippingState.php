<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class ShippingState extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'shipping_state';
        $this->label = __('State', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Shipping', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Shipping/state.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $shipping_state = $this->input->post('calc_shipping_state', NULL);
            if (empty($shipping_state) || is_null($shipping_state)) {
                $shipping_state = self::$woocommerce_helper->getShippingState();
            }
            if (!empty($shipping_state)) {
                return $this->doCompareInListOperation($options->operator, $shipping_state, $options->value);
            }
        }
        return false;
    }
}