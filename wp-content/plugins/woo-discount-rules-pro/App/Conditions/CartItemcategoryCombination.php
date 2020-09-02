<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use Wdr\App\Controllers\Configuration;
use Wdr\App\Helpers\Helper;
use Wdr\App\Helpers\Woocommerce;

class CartItemcategoryCombination extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'cart_item_category_combination';
        $this->label = __('Category combination', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Cart Items', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/category-combination.php';
        $this->config = new Configuration();
    }

    public function check($cart, $options)
    {
        if(empty($cart)){
            return false;
        }
        $result = false;
        if (isset($options->combination) && isset($options->operator) && isset($options->type) && isset($options->category) && is_array($options->category) && isset($options->from) && isset($options->from) && isset($options->to)) {
            if (empty($options->category)) {
                return true;
            }
            $operator = $options->operator;
            $type = $options->type;
            $value_1 = $options->from;
            $value_2 = $options->to;
            $total_quantities_arr = array();
            $cart = Woocommerce::getCart(true);
            if (!empty($cart)) {
                $total_quantities_arr = array_fill_keys($options->category, array('line_item' => array(0), 'subtotal' => array(0), 'qty' => array(0)));
                foreach ($options->category as $category){
                    foreach ($cart as $cart_item) {
                        $item = (isset($cart_item['data']) && !empty($cart_item['data'])) ? $cart_item['data'] : NULL;
                        if(Helper::isCartItemConsideredForCalculation(true, $cart_item, "category_combination")){
                            $categories =  self::$woocommerce_helper->getProductCategories($item);
                            if (in_array($category, $categories)) {
                                if($type == 'cart_line_item'){
                                    $total_quantities_arr[$category]['line_item'][] = 1;
                                }else if($type == 'cart_subtotal'){
                                    $line_subtotal = Woocommerce::getCartLineItemSubtotal($cart_item);
                                    $line_subtotal = Woocommerce::round($line_subtotal);
                                    $total_quantities_arr[$category]['subtotal'][] = $line_subtotal;
                                }else{
                                    $total_quantities_arr[$category]['qty'][] = intval((isset($cart_item['quantity'])) ? $cart_item['quantity'] : 0);
                                }
                            }
                        }
                    }
                }
            }

            switch ($options->combination) {
                case "any":
                    $response = $this->validation($total_quantities_arr, $operator, $value_1, $value_2, $options->combination, $options->type);
                    $result = !empty($response);
                    break;
                case "combine":
                    $response = $this->validation($total_quantities_arr, $operator, $value_1, $value_2, $options->combination, $options->type);
                    $result = false;
                    if($response > 0){
                        $result = $this->doComparisionOperation($operator, $response, $value_1, $value_2);
                    }
                    break;
                default:
                case "each":
                    $response = $this->validation($total_quantities_arr, $operator, $value_1, $value_2, $options->combination, $options->type);
                    $result = empty($response);
                    break;
            }
        }
        return $result;
    }

    /**
     * @param $total_quantities_arr
     * @param $operator
     * @param $value_1
     * @param $value_2
     * @param $option
     * @param $type
     * @return array|float|int
     */
    function validation($total_quantities_arr, $operator, $value_1, $value_2, $option, $type){
        $result = array();
        $combine_categories = 0;
        foreach ($total_quantities_arr as $quantity) {
            if(isset($quantity['line_item']) && !empty($quantity['line_item']) && $type == 'cart_line_item'){
                $line_items = array_sum($quantity['line_item']);
                if($option == "combine"){
                    $combine_categories += $line_items;
                }else if($option == "any"){
                    if($line_items > 0){
                        if($this->doComparisionOperation($operator, $line_items, $value_1, $value_2)){
                            $result[] = 1;
                        }
                    }
                }else if($option == "each"){
                    if($line_items > 0){
                        if (!$this->doComparisionOperation($operator, $line_items, $value_1, $value_2)) {
                            $result[] = 0;
                            break;
                        }
                    } else {
                        $result[] = 0;
                        break;
                    }
                }
            }else if(isset($quantity['qty']) && !empty($quantity['qty']) && $type == 'cart_quantity'){
                $quantities = array_sum($quantity['qty']);
                if($option == "combine"){
                    $combine_categories += $quantities;
                }else if($option == "any"){
                    if($quantities > 0){
                        if ($this->doComparisionOperation($operator, $quantities, $value_1, $value_2)) {
                            $result[] = 1;
                        }
                    }
                }else if($option == "each"){
                    if($quantities > 0){
                        if (!$this->doComparisionOperation($operator, $quantities, $value_1, $value_2)) {
                            $result[] = 0;
                            break;
                        }
                    } else {
                        $result[] = 0;
                        break;
                    }
                }
            }else{
                if(isset($quantity['subtotal']) && !empty($quantity['subtotal']) && $type == 'cart_subtotal'){
                    $line_sub_total = array_sum($quantity['subtotal']);
                    if($option == "combine"){
                        $combine_categories += $line_sub_total;
                    }else if($option == "any"){
                        if($line_sub_total > 0){
                            if ($this->doComparisionOperation($operator, $line_sub_total, $value_1, $value_2)) {
                                $result[] = 1;
                            }
                        }
                    }else if($option == "each"){
                        if($line_sub_total > 0) {
                            if (!$this->doComparisionOperation($operator, $line_sub_total, $value_1, $value_2)) {
                                $result[] = 0;
                            }
                        } else {
                            $result[] = 0;
                            break;
                        }
                    }
                }
            }
        }
        if($combine_categories != 0 && !empty($combine_categories)){
            return $combine_categories;
        }
        return $result;
    }
}