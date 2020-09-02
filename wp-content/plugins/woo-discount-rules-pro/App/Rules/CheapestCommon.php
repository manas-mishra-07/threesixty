<?php
namespace WDRPro\App\Rules;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Woocommerce;

trait CheapestCommon {

    /**
     * Apply discount for non matched filter products
     * */
    public static function applyDiscountForNonMatchedFilterProduct($calculate_discount, $product, $rule, $cart_item){
        if(self::hasDiscount($rule->rule)){
            $calculate_discount = true;
        }
        return $calculate_discount;
    }

    /**
     * Get Discount key to avoid multiple discount to apply
     *
     * @param $rule object
     * @param $buy_x_get_y_discount_data array
     * @param $product object
     *
     * @return string
     * */
    public static function getDiscountKey($rule, $buy_x_get_y_discount_data, $product){
        $rule_id = 0;
        if(isset($rule->rule) && isset($rule->rule->id)){
            $rule_id = $rule->rule->id;
        }
        $key = $rule_id;
        if(is_array($buy_x_get_y_discount_data)){
            $count_based_on = $buy_x_get_y_discount_data['count_based_on'];
        } else {
            $count_based_on = $buy_x_get_y_discount_data;
        }
        if($count_based_on == 'product'){
            $key = $rule_id.'_'.Woocommerce::getProductId($product);
        } else if($count_based_on == 'variation'){
            $key = $rule_id.'_'.Woocommerce::getProductParentId($product);
        }

        return $key;
    }

    /**
     * Set discount value for a product/item
     * */
    public static function setDiscountValue($discounts, $rule, $product_price, $quantity, $product, $ajax_price, $cart_item, $price_display_condition, $is_cart){
        $buy_x_get_y_discount = 0;
        if(isset($rule->rule)){
            if (self::hasDiscount($rule->rule)) {
                $buy_x_get_y_discount_data = self::calculateDiscount($rule, $product_price, $quantity, $product, $ajax_price, $cart_item, $is_cart);
                if(!empty($buy_x_get_y_discount_data)){
                    if(isset($buy_x_get_y_discount_data['discount_price'])) $buy_x_get_y_discount = $buy_x_get_y_discount_data['discount_price'];
                }
            }
        }

        $discounts[self::$discount_type_key] = $buy_x_get_y_discount;

        return $discounts;
    }

    /**
     * Set calculated discount details for strikeout
     * */
    public static function setCalculatedDiscountValue($total_discounts, $product_id, $rule_id, $filter_passed, $cart_item, $is_cart){
        $cart_item_key = (isset($cart_item['key']))? $cart_item['key']: $product_id;
        if(isset(self::$calculated_discounts[$rule_id])){
            if(isset(self::$calculated_discounts[$rule_id][$cart_item_key])){
                $total_discounts[self::$discount_type_key] = self::$calculated_discounts[$rule_id][$cart_item_key];
            }
        }

        return $total_discounts;
    }

    /**
     * Get Buy X Get X settings for the rule
     */
    public static function getAdjustments($rule){
        if(isset($rule->rule)){
            if (self::hasDiscount($rule->rule)) {
                return json_decode($rule->rule->buy_x_get_y_adjustments);
            }
        }

        return false;
    }

    /**
     * Register having BXGY
     *
     * @param $has_additional_rules boolean
     * @param $rule object
     *
     * @return boolean
     * */
    public static function getAdjustment($has_additional_rules, $rule){
        $has_rule = self::getAdjustments($rule);
        if($has_rule){
            $has_additional_rules = true;
        }

        return $has_additional_rules;
    }

    public static function calculateDiscountForAnItem($cart_item, $quantity, $buy_x_get_y_ranges, $rule, $price, $product_quantity, $product, $is_cart = true){
        if(isset($buy_x_get_y_ranges->ranges) && !empty($buy_x_get_y_ranges->ranges)){
            $matched_rule = Cheapest::getMatchedRule($buy_x_get_y_ranges->ranges, $quantity, $product);
        }
        if(!empty($matched_rule)){
            $matched_rule = Cheapest::setFreeDiscountInMatchedRule($matched_rule);
            $discount_quantity = $matched_rule->free_qty;
            $_key = self::getDiscountKey($rule, $buy_x_get_y_ranges->operator, $product);
            if(!isset(self::$cheapest_items[$_key]) || !$is_cart){
                $type = self::getType($matched_rule);
                $product_page_data['product'] = $product;
                $product_page_data['quantity'] = $product_quantity;
                self::$cheapest_items[$_key] = Cheapest::getCheapestItemsFromCart($rule, $matched_rule, $discount_quantity, $buy_x_get_y_ranges->mode, $type, array(), array(), $is_cart, $product_page_data);
            }
        }
    }

    /**
     * Calculate discount for cart items
     * */
    public static function calculateDiscountForCartItems($buy_x_get_y_ranges, $rule, $price, $product_quantity, $product, $is_cart){
        if(in_array($buy_x_get_y_ranges->operator, array('product', 'variation'))){
            $cart = Woocommerce::getCart();
            foreach ($cart as $cart_item){
                if ($rule->isFilterPassed($cart_item['data'])) {
                    $quantity = $cart_item['quantity'];
                    if($buy_x_get_y_ranges->operator == 'variation'){
                        $quantity = $rule->getQuantityBasedOnCountAdjustment($buy_x_get_y_ranges->operator, $product_quantity, $cart_item['data'], $is_cart);
                    }

                    self::calculateDiscountForAnItem($cart_item, $quantity, $buy_x_get_y_ranges, $rule, $price, $product_quantity, $product);
                }
            }
        }
    }

    /**
     * Calculate Buy X Get Y Discount
     *
     * @param $rule
     * @param $price
     * @param $product_quantity
     * @param $product
     * @param $ajax_price
     * @return mixed
     * */
    public static function calculateDiscount($rule, $price, $product_quantity, $product, $ajax_price = false, $cart_item = array(), $is_cart = true){
        $buy_x_get_y_ranges = self::getAdjustments($rule);
        if(empty($buy_x_get_y_ranges->ranges->{1}->from)){
            return null;
        }
        if ($rule->hasConditions()) {
            $cart = Woocommerce::getCart();
            if (!$rule->isCartConditionsPassed($cart)) {
                return null;
            }
        }
        $return_value = array();
        if(in_array($buy_x_get_y_ranges->operator, array('product', 'variation'))) {
            self::calculateDiscountForCartItems($buy_x_get_y_ranges, $rule, $price, $product_quantity, $product, $is_cart);
        } else {
            $quantity = $rule->getQuantityBasedOnCountAdjustment($buy_x_get_y_ranges->operator, $product_quantity, $product, $is_cart);
            self::calculateDiscountForAnItem($cart_item, $quantity, $buy_x_get_y_ranges, $rule, $price, $product_quantity, $product, $is_cart);
        }
        $cart_item_key = (isset($cart_item['key']))? $cart_item['key']: Woocommerce::getProductId($product);

        if(!empty(self::$calculated_discounts[$rule->rule->id]) && !empty(self::$calculated_discounts[$rule->rule->id][$cart_item_key])){
            return self::$calculated_discounts[$rule->rule->id][$cart_item_key];
        } else {
            if(!empty(self::$cheapest_items)){
                foreach (self::$cheapest_items as $cheapest_item_data){
                    if(!empty($cheapest_item_data)){
                        foreach ($cheapest_item_data as $cheapest_item_data_values){
                            if($cheapest_item_data_values['cart_item_key'] == $cart_item_key){
                                $quantity_to_apply = $cheapest_item_data_values['cart_item_quantity_to_apply'];
                                if($quantity_to_apply > 0){
                                    $quantity = (isset($cart_item['key']))? $cart_item['quantity']: $product_quantity;
                                    $matched_rule = $cheapest_item_data_values['matched_rule'];
                                    $discount_price = Cheapest::calculateDiscountPriceFromRuleRange($matched_rule, $price, $quantity_to_apply, $quantity, $product);
                                    $discount_value = $matched_rule->free_value;
                                    $discount_type = $matched_rule->free_type;
                                    $return_value = array(
                                        "discount_type" => $discount_type,
                                        "count_based_on" => $buy_x_get_y_ranges->operator,
                                        "discount_value" => $discount_value,
                                        "discount_quantity" => $quantity_to_apply,
                                        "discount_price_per_quantity" => Cheapest::calculateDiscountPricePerQuantity($matched_rule, $price),
                                        "discount_price" => $discount_price,
                                    );
                                    if(!empty($cart_item)){
                                        if(isset($cart_item['key'])){
                                            $return_value['discount_for_cart_item_keys'][] = $cart_item['key'];
                                        }
                                    }
                                    self::$calculated_discounts[$rule->rule->id][$cart_item_key] = $return_value;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $return_value;
    }
}