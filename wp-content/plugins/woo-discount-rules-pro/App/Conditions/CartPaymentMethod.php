<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class CartPaymentMethod extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_payment_method';
        $this->label = __('Payment Method', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Cart/payment-method.php';
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        if (isset($options->operator) && isset($options->value)) {
            $payment_method = self::$woocommerce_helper->getUserSelectedPaymentMethod();
            return $this->doCompareInListOperation($options->operator, $payment_method, $options->value);
        }
        return false;
    }
}