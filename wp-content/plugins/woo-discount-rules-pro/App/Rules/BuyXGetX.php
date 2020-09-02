<?php
namespace WDRPro\App\Rules;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Rule;
use Wdr\App\Helpers\Woocommerce;

class BuyXGetX
{
    protected static $calculated_discounts = array();
    protected static $discount_type_key = 'buy_x_get_x_discount';

    /**
     * Initialize
     * */
    public static function init()
    {
        self::hooks();
    }

    /**
     * Add hooks
     * */
    protected static function hooks(){
        add_filter('advanced_woo_discount_rules_discounts_of_each_rule', array(__CLASS__, 'setBXGXDiscountValue'), 10, 9);
        add_filter('advanced_woo_discount_rules_calculated_discounts_of_each_rule', array(__CLASS__, 'setCalculatedBXGXDiscountValue'), 10, 6);
        add_filter('advanced_woo_discount_rules_calculated_discounts_of_each_rule_for_ajax_price', array(__CLASS__, 'setCalculatedBXGXDiscountValue'), 10, 6);
        add_filter('advanced_woo_discount_rules_has_any_discount', array(__CLASS__, 'hasBuyXGetXAdjustment'), 10, 2);
        add_filter('advanced_woo_discount_rules_is_rule_passed_with_out_discount_for_exclusive_rule', array(__CLASS__, 'checkExclusiveRulePassed'), 10, 4);
    }

    /**
     * Check
     * */
    public static function checkExclusiveRulePassed($status, $product, $rule, $cart_item){
        $buy_x_get_x_ranges = self::getBuyXGetXAdjustments($rule);
        if(empty($buy_x_get_x_ranges->ranges->{1}->from)){
            return $status;
        }
        if(isset($buy_x_get_x_ranges->ranges) && !empty($buy_x_get_x_ranges->ranges)){
            $matched_rule = self::getMatchedRule($buy_x_get_x_ranges->ranges, $cart_item['quantity'], $product);
            if($matched_rule){
                $status = true;
            }
        }
        return $status;
    }

    /**
     * Calculate Buy X Get Y Discount
     *
     * @param $rule
     * @param $price
     * @param $quantity
     * @param $product
     * @param $ajax_price
     * @return mixed
     * */
    public static function calculateBuyXGetXDiscount($rule, $price, $quantity, $product, $ajax_price = false, $cart_item = array(), $is_cart = true){
        $buy_x_get_x_ranges = self::getBuyXGetXAdjustments($rule);
        if(empty($buy_x_get_x_ranges->ranges->{1}->from)){
            return null;
        }
        $matched_rule = $return_value = array();
        if(isset($buy_x_get_x_ranges->ranges) && !empty($buy_x_get_x_ranges->ranges)){
            $matched_rule = self::getMatchedRule($buy_x_get_x_ranges->ranges, $quantity, $product);
        }
        if(!empty($matched_rule)){
            $cart_item_key = (isset($cart_item['key']))? $cart_item['key']: Woocommerce::getProductId($product);
            $discount_quantity = $matched_rule->free_qty;
            $discount_type = $matched_rule->free_type;
            if($matched_rule->free_type == "free_product"){
                $discount_type = "buy_x_get_x";
                $discount_price = 0;
            } else {
                $discount_price = BOGO::calculateDiscountPriceFromRuleRange($matched_rule, $price, $discount_quantity, $quantity, $product);
            }
            $discount_value = $matched_rule->free_value;
            $return_value = array(
                "discount_type" => $discount_type,
                "discount_value" => $discount_value,
                "discount_quantity" => $discount_quantity,
                "discount_price_per_quantity" => Cheapest::calculateDiscountPricePerQuantity($matched_rule, $price),
                "discount_price" => $discount_price,
            );
            if(!empty($cart_item)){
                if(isset($cart_item['key'])){
                    $return_value['cart_item_key'] = $cart_item['key'];
                    $return_value['product_id'] = $cart_item['product_id'];
                    $return_value['variation_id'] = $cart_item['variation_id'];
                    $return_value['variation'] = $cart_item['variation'];
                    $return_value['cart_item'] = $cart_item;
                    $return_value['quantity'] = $cart_item['quantity'];
                }
            }

            if($matched_rule->free_type != "free_product"){
                self::setDiscountDetails($rule->rule->id, $cart_item_key, $return_value);
            }
        }

        return $return_value;
    }

    /**
     * Set discount details
     * */
    protected static function setDiscountDetails($rule_id, $cart_item_key, $discount_value){
        if(isset(self::$calculated_discounts[$rule_id])){
            if(isset(self::$calculated_discounts[$rule_id][$cart_item_key])){
            } else {
                self::$calculated_discounts[$rule_id][$cart_item_key] = $discount_value;
            }
        } else {
            self::$calculated_discounts[$rule_id][$cart_item_key] = $discount_value;
        }
    }

    /**
     * Get Matched Rule
     *
     * @param $buy_x_get_x_ranges object
     * @param $quantity int
     * @param $product object
     *
     * @return mixed
     * */
    protected static function getMatchedRule($buy_x_get_x_ranges, $quantity, $product){
        $matched_rule = array();
        foreach ($buy_x_get_x_ranges as $key => $buy_x_get_x_range){
            $start = (int)($buy_x_get_x_range->from);
            if(!empty($buy_x_get_x_range->recursive) && $buy_x_get_x_range->recursive == 1){
                $free_quantity = (int)($buy_x_get_x_range->free_qty);
                if($quantity < $start){
                    $free_quantity = 0;
                } else {
                    $free_quantity = BOGO::getRecursiveQuantity($start, $quantity, $free_quantity);
                }
                if($free_quantity){
                    $matched_rule = $buy_x_get_x_range;
                    $matched_rule->free_qty = $free_quantity;
                }
                return $matched_rule;
            }
            if(empty($buy_x_get_x_range->to)){
                if($buy_x_get_x_range->from <= $quantity){
                    $matched_rule = $buy_x_get_x_range;
                    break;
                }
            } else {
                if($buy_x_get_x_range->from <= $quantity && $buy_x_get_x_range->to >= $quantity){
                    $matched_rule = $buy_x_get_x_range;
                    break;
                }
            }
        }

        return $matched_rule;
    }

    /**
     * Get Buy X Get X settings for the rule
     */
    public static function getBuyXGetXAdjustments($rule){
        if(isset($rule->rule)){
            if (self::hasBuyXGetXDiscount($rule->rule)) {
                return json_decode($rule->rule->buy_x_get_x_adjustments);
            }
        }

        return false;
    }

    /**
     * check the rule has product discount
     * @return bool
     */
    public static function hasBuyXGetXDiscount($rule)
    {
        if (isset($rule->buy_x_get_x_adjustments)) {
            if (!empty($rule->buy_x_get_x_adjustments) && $rule->buy_x_get_x_adjustments != '{}' && $rule->buy_x_get_x_adjustments != '[]') {
                return true;
            }
        }
        return false;
    }

    public static function setBXGXDiscountValue($discounts, $rule, $product_price, $quantity, $product, $ajax_price, $cart_item, $price_display_condition, $is_cart){
        $buy_x_get_x_discount = 0;
        if (self::hasBuyXGetXDiscount($rule->rule)) {
            $buy_x_get_x_discount_data = self::calculateBuyXGetXDiscount($rule, $product_price, $quantity, $product, $ajax_price, $cart_item, $is_cart);
            if(!empty($buy_x_get_x_discount_data)){
                if($buy_x_get_x_discount_data['discount_type'] == 'buy_x_get_x'){
                    $buy_x_get_x_discount_data['rule_id'] = $rule->rule->id;
                    if(isset($cart_item['key'])){
                        Rule::$additional_discounts['buy_x_get_x_discounts'][$cart_item['key']] = $buy_x_get_x_discount_data;
                    }
                } else {
                    $buy_x_get_x_discount = $buy_x_get_x_discount_data['discount_price'];
                }
            }
        }

        $discounts[self::$discount_type_key] = $buy_x_get_x_discount;

        return $discounts;
    }

    public static function setCalculatedBXGXDiscountValue($total_discounts, $product_id, $rule_id, $filter_passed, $cart_item, $is_cart){
        /*if(isset(Rule::$additional_discounts['buy_x_get_x_discounts'])){
            if(!empty(Rule::$additional_discounts['buy_x_get_x_discounts'])){
                $buy_x_get_x_discounts = Rule::$additional_discounts['buy_x_get_x_discounts'];
                $total_discounts['buy_x_get_x_discount'] = isset($buy_x_get_x_discounts[$product_id]) ? $buy_x_get_x_discounts[$product_id] : 0;
            }
        }*/

        $cart_item_key = (isset($cart_item['key']))? $cart_item['key']: $product_id;
        if(isset(self::$calculated_discounts[$rule_id])){
            if(isset(self::$calculated_discounts[$rule_id][$cart_item_key])){
                $total_discounts[self::$discount_type_key] = self::$calculated_discounts[$rule_id][$cart_item_key];
            }
        }

        return $total_discounts;
    }

    /**
     * Register having BXGX
     *
     * @param $has_additional_rules boolean
     * @param $rule object
     *
     * @return boolean
     * */
    public static function hasBuyXGetXAdjustment($has_additional_rules, $rule){
        $has_rule = self::hasBuyXGetXDiscount($rule->rule);
        if($has_rule){
            $has_additional_rules = true;
        }

        return $has_additional_rules;
    }
}
BuyXGetX::init();