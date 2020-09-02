<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class PurchasePreviousOrders extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_previous_orders';
        $this->label = __('Number of orders made', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Purchase History', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/previous-order.php';
    }

    function check($cart, $options)
    {
        if (isset($options->operator) && isset($options->time) && isset($options->count) && !empty($options->count)) {
            $conditions = '';
            if($user = get_current_user_id()){
                $conditions = array('meta_key' => '_customer_user', 'meta_value' => $user);
            }else{
                $billing_email = self::$woocommerce_helper->getBillingEmailFromPost();
                if(!empty($billing_email)) {
                    $conditions = array('meta_key' => '_billing_email', 'meta_value' => $billing_email);
                }
            }

            if (!empty($conditions)) {

                if (isset($options->status) && is_array($options->status) && !empty($options->status)) {
                    $conditions['post_status'] = $options->status;
                }
                if ($options->time != "all_time") {
                    $conditions['date_query'] = array('after' => $this->getDateByString($options->time, 'Y-m-d').' 00:00:00');
                }
                $orders = self::$woocommerce_helper->getOrdersByConditions($conditions);
                return $this->doComparisionOperation($options->operator, count($orders), $options->count);
            }
        }
        return false;
    }
}