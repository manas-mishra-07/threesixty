<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class PurchaseFirstOrder extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_first_order';
        $this->label = __('First order', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Purchase History', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/first-order.php';
    }

    function check($cart, $options)
    {
        $conditions = '';
        if($user = get_current_user_id()){
            $conditions = array('numberposts' => 1, 'meta_key' => '_customer_user', 'meta_value' => $user);
        }else{
            $billing_email = self::$woocommerce_helper->getBillingEmailFromPost();
            if(!empty($billing_email)) {
                $conditions = array('numberposts' => 1, 'meta_key' => '_billing_email', 'meta_value' => $billing_email);
            }
        }
        if (!empty($conditions)) {
            $orders = self::$woocommerce_helper->getOrdersByConditions($conditions);
            $first_order = (int)isset($options->value) ? $options->value : 1;
            if ($first_order) {
                return empty($orders);
            } else {
                return !empty($orders);
            }
        }
        return false;
    }
}