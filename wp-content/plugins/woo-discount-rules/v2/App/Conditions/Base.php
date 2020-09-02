<?php

namespace Wdr\App\Conditions;

use Wdr\App\Helpers\Filter;
use Wdr\App\Helpers\Helper;
use Wdr\App\Helpers\Input;
use Wdr\App\Helpers\Woocommerce;

if (!defined('ABSPATH')) exit;

abstract class Base
{
    public static $woocommerce_helper, $filter;
    public $name = NULL, $rule = null, $label = NULL, $group = NULL, $template = NULL, $input, $extra_params = array('render_saved_condition' => false);

    function __construct()
    {
        self::$woocommerce_helper = (!empty(self::$woocommerce_helper)) ? self::$woocommerce_helper : new Woocommerce();
        self::$filter = (!empty(self::$filter)) ? self::$filter : new Filter();
        $this->input = new Input();
    }

    abstract function check($cart, $options);

    /**
     * return the name of the condition. If condition does not have name, then the condition will not get consider.
     * @return null
     */
    function name()
    {
        return $this->name;
    }

    /**
     * compare cart items with the product filter helper
     * @param $cart
     * @param $options
     * @param $type
     * @return bool
     */
    function doCartItemsCheck($cart, $options, $type)
    {
        if(empty($cart)){
            return false;
        }
        $comparision_operator = isset($options->cartqty) ? $options->cartqty : 'less_than_or_equal';
        $comparision_quantity = isset($options->qty) ? $options->qty : 0;
        if (empty($comparision_quantity)) {
            return true;
        }
       // $comparision_method = isset($options->method) ? $options->method : 'in_list';
        $comparision_method = isset($options->operator) ? $options->operator : 'in_list';
        $comparision_value = (array)isset($options->value) ? $options->value : array();
        $cart_items = array();
        if ($cart instanceof \WC_Cart) {
            $cart_items = self::$woocommerce_helper->getCartItems($cart);
        } elseif (is_array($cart)) {
            $cart_items = $cart;
        }
        $quantity = 0;

        foreach ($cart_items as $cart_item) {
            $product = isset($cart_item['data']) ? $cart_item['data'] : array();
            if(Helper::isCartItemConsideredForCalculation(true, $cart_item, $type)){
                if (self::$filter->match($product, $type, $comparision_method, $comparision_value, $options)) {
                    if ($type != 'products') {
                        $quantity += (int)$cart_item['quantity'];
                    }
                }
            }
        }
        foreach ($cart_items as $item) {
            $product = isset($item['data']) ? $item['data'] : array();
            if(Helper::isCartItemConsideredForCalculation(true, $item, $type)){
                if (self::$filter->match($product, $type, $comparision_method, $comparision_value, $options)) {
                    if($type == 'products'){
                        $quantity = 0;
                        $quantity = (int)$item['quantity'];
                        $product_parant_id = Woocommerce::getProductParentId($product);
                        if(!empty($product_parant_id)){
                            $quantity = $this->getChildVariantCountInCart($options, $product_parant_id, $quantity, $cart_items);
                        }
                    }
                    switch ($comparision_operator) {
                        case 'less_than':
                            if ($quantity < $comparision_quantity) {
                                return true;
                            }
                            break;
                        case 'greater_than_or_equal':
                            if ($quantity >= $comparision_quantity) {
                                return true;
                            }
                            break;
                        case 'greater_than':
                            if ($quantity > $comparision_quantity) {
                                return true;
                            }
                            break;
                        default:
                        case 'less_than_or_equal':
                            if ($quantity <= $comparision_quantity) {
                                return true;
                            }
                            break;
                    }
                }
            }
        }
        return false;
    }

    /**
     * get the date by passing days
     * @param $value string; Example- +1 day,-1 month, now
     * @param $format string
     * @return bool|string
     */
    function getDateByString($value, $format = 'Y-m-d H:i:s')
    {
        if (!empty($value)) {
            $value = str_replace('_', ' ', $value);
            try {
                $date = new \DateTime(current_time('mysql'));
                $date->modify($value);
                return $date->format($format);
            } catch (\Exception $e) {
            }
        }
        return false;
    }

    /**
     * Do the mathematical Comparision operation
     * @param $operation
     * @param $operand1 - user data
     * @param $operand2 - admin condition data 1
     * @param $operand3 - admin condition data 2, if range
     * @return bool
     */
    function doComparisionOperation($operation, $operand1, $operand2, $operand3 = NULL)
    {
        $result = false;
        switch ($operation) {
            case 'equal_to':
                $result = ($operand1 == $operand2);
                break;
            case 'not_equal_to';
                $result = ($operand1 != $operand2);
                break;
            case 'greater_than';
                $result = ($operand1 > $operand2);
                break;
            case 'less_than';
                $result = ($operand1 < $operand2);
                break;
            case 'greater_than_or_equal';
                $result = ($operand1 >= $operand2);
                break;
            case 'less_than_or_equal';
                $result = ($operand1 <= $operand2);
                break;
            case 'in_range';
                if (!empty($operand3)) {
                    $result = (($operand1 >= $operand2) && ($operand1 <= $operand3));
                }
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * check the data is present in loop
     * @param $operation
     * @param $key
     * @param $list
     * @return bool
     */
    function doCompareInListOperation($operation, $key, $list)
    {
        if (!is_array($list))
            return false;
        switch ($operation) {
            case 'not_in_list':
                if (is_array($key) || is_object($key)) {
                    $key = (array)$key;
                    return !array_intersect($key, $list);
                } else {
                    $result = !in_array($key, $list);
                }
                break;
            default:
            case 'in_list';
                if (is_array($key) || is_object($key)) {
                    $key = (array)$key;
                    return array_intersect($key, $list);
                } else {
                    $result = in_array($key, $list);
                }
                break;
        }
        return $result;
    }

    /**
     * @param $options
     * @param $parant_id
     * @param $quantity
     * @param $cart_items
     * @return int
     */
    function getChildVariantCountInCart($options, $parant_id, $quantity, $cart_items){
        $filter_value = (is_object($options) && isset($options->value)) ? $options->value : 0;
        if(in_array($parant_id,$filter_value)){
            $count_quantity = 0;
            foreach ($cart_items as $cart_item){
                $product = isset($cart_item['data']) ? $cart_item['data'] : 0;
                $product_parant_id = Woocommerce::getProductParentId($product);
                if($parant_id == $product_parant_id){
                    $count_quantity += (int)$cart_item['quantity'];
                }
            }
            return $count_quantity;
        }else{
            return $quantity;
        }
    }
}