<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use Wdr\App\Controllers\Configuration;
use Wdr\App\Helpers\Helper;

class PurchasePreviousOrdersForSpecificProduct extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_previous_orders_for_specific_product';
        $this->label = __('Number of orders made with following products', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Purchase History', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/previous-order-against-product.php';
        $this->config = new Configuration();
    }

    function check($cart, $options)
    {
        if (isset($options->operator) && isset($options->time) && isset($options->count) && !empty($options->count) && isset($options->products) && is_array($options->products) && !empty($options->products)) {
            $apply_discount_to_child = apply_filters('advanced_woo_discount_rules_apply_discount_to_child', true);
            if($apply_discount_to_child){
                if(isset($options->product_variants) && !empty($options->product_variants) && is_array($options->product_variants)){
                    $options->products = Helper::combineProductArrays($options->products, $options->product_variants);
                }
            }
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
                $order_count = 0;
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        if (!empty($order) && isset($order->ID)) {
                            $order_obj = self::$woocommerce_helper->getOrder($order->ID);
                            $keys = self::$woocommerce_helper->getOrderItemsId($order_obj);
                            if ($count = count(array_intersect($options->products, $keys))) {
                                $order_count += $count;
                            }
                        }
                    }
                }
                return $this->doComparisionOperation($options->operator, $order_count, $options->count);
            }
        }
        return false;
    }
}