<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class PurchaseLastOrder extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_last_order';
        $this->label = __('Last order', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Purchase History', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/last-order.php';
    }

    function check($cart, $options)
    {
        $conditions = '';
        if (isset($options->operator) && isset($options->value)) {
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
                $date = $this->getDateByString($options->value, 'Y-m-d') . ' 00:00:00';
                switch ($options->operator) {
                    case 'earlier':
                        $conditions['date_query'] = array('before' => $date);
                        break;
                    default:
                        $conditions['date_query'] = array('after' => $date);
                        break;
                }
                $orders = self::$woocommerce_helper->getOrdersByConditions($conditions);
                return !empty($orders);
            }
        }
        return false;
    }
}