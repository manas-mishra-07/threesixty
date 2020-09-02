<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class PurchaseLastOrderAmount extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_last_order_amount';
        $this->label = __('Last order amount', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Purchase History', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/last-order-amount.php';
    }

    function check($cart, $options)
    {
        $conditions='';
        if (isset($options->operator) && isset($options->value) && $options->value > 0) {
            if($user = get_current_user_id()){
                $conditions = array('numberposts' => 1, 'meta_key' => '_customer_user', 'meta_value' => $user);
            }else{
                $billing_email = self::$woocommerce_helper->getBillingEmailFromPost();
                if(!empty($billing_email)) {
                    $conditions = array('numberposts' => 1, 'meta_key' => '_billing_email', 'meta_value' => $billing_email);
                }
            }

            if (!empty($conditions)) {
                if (isset($options->status) && is_array($options->status) && !empty($options->status)) {
                    $conditions['post_status'] = $options->status;
                }
                $orders = self::$woocommerce_helper->getOrdersByConditions($conditions);
                $last_order_amount = 0;
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        if (!empty($order) && isset($order->ID)) {
                            $order_obj = self::$woocommerce_helper->getOrder($order->ID);
                            $last_order_amount += self::$woocommerce_helper->getOrderTotal($order_obj);
                        }
                    }
                }
                return $this->doComparisionOperation($options->operator, $last_order_amount, $options->value);
            }
        }
        return false;
    }
}