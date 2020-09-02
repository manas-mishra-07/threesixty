<?php

namespace WDRPro\App\Rules;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Controllers\DiscountCalculator;
use Wdr\App\Helpers\Rule;
use Wdr\App\Helpers\Woocommerce;

class BOGO
{
    public static $free_product_cart_item_identifier = "wdr_free_product";
    public static $free_product_cart_item_variant_name = "Discount";
    public static $free_product_cart_item_identifier_value = "Free";
    public static $free_product_cart_item_variant_display = "Free";
    public static $cart_item_free_products = array();

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
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddFreeProducts'), 100);
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddFreeProductsBXGY'), 100);
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'removeInvalidFreeProducts'), 101);
        add_action('woocommerce_get_item_data', array(__CLASS__, 'displayFreeProductTextInCart'), 100, 2);
        add_action('woocommerce_order_item_display_meta_key', array(__CLASS__, 'displayFreeProductTextInOrder'), 100, 3);
        add_action('woocommerce_cart_item_quantity', array(__CLASS__, 'disableQuantityFieldForFreeProduct'), 100, 3);
        add_action('woocommerce_cart_item_remove_link', array(__CLASS__, 'disableCloseIconForFreeProduct'), 100, 2);

        add_filter('advanced_woo_discount_rules_include_cart_item_to_count_quantity', array(__CLASS__, 'excludeFreeProductFromQuantityCount'), 100, 2);
        add_filter('advanced_woo_discount_rules_process_cart_item_for_cheapest_rule', array(__CLASS__, 'excludeFreeProductFromQuantityCount'), 100, 2);
        add_action('advanced_woo_discount_rules_after_apply_discount', array(__CLASS__, 'setZeroPriceForFreeProduct'), 10);
        add_filter('advanced_woo_discount_rules_calculate_discount_for_cart_item', array(__CLASS__, 'excludeFreeProductFromDiscount'), 10, 2);
        add_filter('advanced_woo_discount_rules_process_cart_item_for_buy_x_get_y_limited_discounts', array(__CLASS__, 'excludeFreeProductFromDiscount'), 10, 2);
    }

    public static function excludeFreeProductFromDiscount($calculate_discount, $cart_item){
        if(self::isFreeProduct($cart_item)){
            $calculate_discount = false;
        }

        return $calculate_discount;
    }

    /**
     * Check is cart item is an free product
     *
     * @param $cart_item array
     * @return boolean
     * */
    public static function isFreeProduct($cart_item){
        if(!empty($cart_item[self::$free_product_cart_item_identifier])){
            if($cart_item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value){
                return true;
            }
        }

        return false;
    }

    /**
     * Exclude free product from quantity count
     *
     * @param $include boolean
     * @param $cart_item array
     *
     * @return boolean
     * */
    public static function excludeFreeProductFromQuantityCount($include, $cart_item){
        if ( !empty( $cart_item[self::$free_product_cart_item_identifier] ) ){
            $include = false;
        }

        return $include;
    }

    /**
     * For disable Quantity field for free product
     *
     * @param $close_button string
     * @param $cart_item_key string
     * @return string
     * */
    public static function disableCloseIconForFreeProduct($close_button, $cart_item_key){
        if(empty(self::$cart_item_free_products)) return $close_button;
        if(in_array($cart_item_key, self::$cart_item_free_products)){
            $close_button = '';
        }

        return $close_button;
    }

    /**
     * For disable Quantity field for free product
     *
     * @param $product_quantity string
     * @param $cart_item_key string
     * @param $cart_item array
     * @return string
     * */
    public static function disableQuantityFieldForFreeProduct($product_quantity, $cart_item_key, $cart_item = array()){
        if ( empty( $cart_item[self::$free_product_cart_item_identifier] ) ) return $product_quantity;
        if($cart_item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value){
            $product_quantity = '';
            if(isset($cart_item['quantity'])) $product_quantity = $cart_item['quantity'];

        }

        return $product_quantity;
    }

    /**
     * For displaying free product discount in cart
     *
     * @param $item_data array
     * @param $cart_item array
     * @return array
     * */
    public static function displayFreeProductTextInCart($item_data, $cart_item){
        //This have added to display the text in translation file
        $free_text_name = __('Discount', WDR_PRO_TEXT_DOMAIN);
        $free_text_display = __('Free', WDR_PRO_TEXT_DOMAIN);

        if ( empty( $cart_item[self::$free_product_cart_item_identifier] ) ) return $item_data;
        if($cart_item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value){
            $key = esc_html__(self::$free_product_cart_item_variant_name, WDR_PRO_TEXT_DOMAIN);
            $display = esc_html__(self::$free_product_cart_item_variant_display, WDR_PRO_TEXT_DOMAIN);
            $display = '<span class="awdr_free_product_text">'.$display.'</span>';
            $item_data[] = array(
                'key'     => apply_filters('advanced_woo_discount_rules_free_product_option_key', $key),
                'value'   => 1,
                'display' => apply_filters('advanced_woo_discount_rules_free_product_option_display_name', $display),
            );
        }
        return $item_data;
    }

    public static function displayFreeProductTextInOrder($display_key, $meta, $order_item)
    {
        if ($display_key == 'wdr_free_product') {
            $display_key = esc_html__(self::$free_product_cart_item_variant_name, WDR_PRO_TEXT_DOMAIN);
        }

        return $display_key;
    }

    /**
     * Set applied rules in discount calculator
     *
     * @param $rule_id integer
     * */
    public static function setAppliedRuleInDiscountCalculator($rule_id){
        DiscountCalculator::$applied_rules[$rule_id] = DiscountCalculator::$rules[$rule_id];
    }

    /**
     * Handle Auto add product
     * */
    public static function handleAutoAddFreeProducts()
    {
        $bogo_products = isset(Rule::$additional_discounts['buy_x_get_x_discounts'])? Rule::$additional_discounts['buy_x_get_x_discounts'] : array();
        if (!empty($bogo_products) && is_array($bogo_products)) {
            foreach ($bogo_products as $bogo_cart_item_key => $bogo_data) {
                self::setAppliedRuleInDiscountCalculator($bogo_data['rule_id']);
                $quantity = $bogo_data['discount_quantity'];
                $variation_id = $bogo_data['variation_id'];
                $variation = $bogo_data['variation'];
                $bogo_product_id = $bogo_data['product_id'];
                $has_already = $cart_item_key = false;
                $existing_free_quantity = 0;
                $cart_items = Woocommerce::getCart();
                if (!empty($cart_items)) {
                    foreach ($cart_items as $key => $item) {
                        $product_id = $item['product_id'];
                        if ($product_id == $bogo_product_id && isset($item[self::$free_product_cart_item_identifier])) {
                            if ($item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value) {
                                if(!empty($item['wdr_for_cart_item']) && is_array($item['wdr_for_cart_item'])){
                                    if(in_array($bogo_cart_item_key, $item['wdr_for_cart_item'])){
                                        $variation_new = $variation;
                                        $variation_new[self::$free_product_cart_item_identifier] = self::$free_product_cart_item_identifier_value;
                                        $current_variation = $item['variation'];
                                        unset($current_variation['wdr_for_cart_item']);
                                        if($variation_new == $current_variation && $variation_id == $item['variation_id']){
                                            $has_already = true;
                                            $existing_free_quantity = $item['quantity'];
                                            $cart_item_key = $key;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if ($has_already == false) {
                    $cart_item_data = array(
                        self::$free_product_cart_item_identifier => self::$free_product_cart_item_identifier_value,
                        'wdr_for_cart_item' => array($bogo_data['cart_item_key']),
                    );
                    $existing_cart_item = $bogo_data['cart_item'];
                    //To support WooCommerce Extra Product Options Pro
                    if(isset($existing_cart_item['thwepo_options'])){
                        $cart_item_data['thwepo_options'] = $existing_cart_item['thwepo_options'];
                    }

                    $cart_item_data = apply_filters('advanced_woo_discount_rules_free_product_cart_item_data', $cart_item_data, $existing_cart_item);
                    $cart_item_variation = $variation;
                    $cart_item_variation[self::$free_product_cart_item_identifier] = self::$free_product_cart_item_identifier_value;
                    $cart_item_variation = apply_filters('advanced_woo_discount_rules_free_product_cart_item_variation', $cart_item_variation, $variation);
                    $cart_item_key = Woocommerce::add_to_cart($bogo_product_id, $quantity, $variation_id, $cart_item_variation, $cart_item_data);
                    if(!empty($cart_item_key)){
                        self::addFreeProductCartItemKey($cart_item_key);
                        do_action('advanced_woo_discount_rules_after_free_product_added_to_cart', $cart_item_key);
                    }
                } else {
                    if(!empty($cart_item_key)){
                        if ($quantity < $existing_free_quantity || $quantity > $existing_free_quantity) {
                            Woocommerce::set_quantity($cart_item_key, $quantity);
                            do_action('advanced_woo_discount_rules_after_free_product_count_updated', $cart_item_key);
                        }
                        self::addFreeProductCartItemKey($cart_item_key);
                    }
                }
            }
        }
    }

    /**
     * Handle Auto add product
     * */
    public static function handleAutoAddFreeProductsBXGY()
    {
        $bogo_products = isset(Rule::$additional_discounts['buy_x_get_y_discounts'])? Rule::$additional_discounts['buy_x_get_y_discounts'] : array();
        if (!empty($bogo_products) && is_array($bogo_products)) {
            foreach ($bogo_products as $bxgy_key => $bogo_data) {
                self::setAppliedRuleInDiscountCalculator($bogo_data['rule_id']);
                $discount_products = $bogo_data['discount_products'];
                foreach ($discount_products as $discount_product){
                    $variation_id = 0;
                    $bogo_product_id = $discount_product;
                    $product = Woocommerce::getProduct($discount_product);
                    $parent_id = Woocommerce::getProductParentId($product);
                    if(!empty($parent_id)){
                        $bogo_product_id = $parent_id;
                        $variation_id = $discount_product;
                    }
                    $quantity = $bogo_data['discount_quantity'];
                    $variation = array();

                    $has_already = $cart_item_key = false;
                    $existing_free_quantity = 0;
                    $cart_items = Woocommerce::getCart();
                    if (!empty($cart_items)) {
                        foreach ($cart_items as $key => $item) {
                            $product_id = $item['product_id'];
                            if ($product_id == $bogo_product_id && isset($item[self::$free_product_cart_item_identifier])) {
                                if ($item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value) {
                                    if(!empty($item['wdr_for_rule']) && is_array($item['wdr_for_rule'])){
                                        if(in_array($bxgy_key, $item['wdr_for_rule'])){
                                            $variation_new = $variation;
                                            $variation_new[self::$free_product_cart_item_identifier] = self::$free_product_cart_item_identifier_value;
                                            $current_variation = $item['variation'];
                                            unset($current_variation['wdr_for_rule']);
                                            if($variation_new == $current_variation && $variation_id == $item['variation_id']){
                                                $has_already = true;
                                                $existing_free_quantity = $item['quantity'];
                                                $cart_item_key = $key;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($has_already == false) {
                        $cart_item_data = array(
                            self::$free_product_cart_item_identifier => self::$free_product_cart_item_identifier_value,
                            'wdr_for_rule' => array($bxgy_key),
                            'customer_choice' => isset($bogo_data['customer_choice'])? $bogo_data['customer_choice']: array(),
                        );
                        $existing_cart_item = array();
                        if(isset($bogo_data['cart_item'])){
                            $existing_cart_item = $bogo_data['cart_item'];
                            //To support WooCommerce Extra Product Options Pro
                            if(isset($existing_cart_item['thwepo_options'])){
                                $cart_item_data['thwepo_options'] = $existing_cart_item['thwepo_options'];
                            }
                        }

                        $cart_item_data = apply_filters('advanced_woo_discount_rules_free_product_cart_item_data', $cart_item_data, $existing_cart_item);
                        $cart_item_variation = $variation;
                        $cart_item_variation[self::$free_product_cart_item_identifier] = self::$free_product_cart_item_identifier_value;
                        $cart_item_variation = apply_filters('advanced_woo_discount_rules_free_product_cart_item_variation', $cart_item_variation, $variation);
                        $cart_item_key = Woocommerce::add_to_cart($bogo_product_id, $quantity, $variation_id, $cart_item_variation, $cart_item_data);
                        if(!empty($cart_item_key)){
                            self::addFreeProductCartItemKey($cart_item_key);
                            do_action('advanced_woo_discount_rules_after_free_product_added_to_cart', $cart_item_key);
                        }
                    } else {
                        if(!empty($cart_item_key)){
                            if ($quantity < $existing_free_quantity || $quantity > $existing_free_quantity) {
                                Woocommerce::set_quantity($cart_item_key, $quantity);
                                do_action('advanced_woo_discount_rules_after_free_product_count_updated', $cart_item_key);
                            }
                            self::addFreeProductCartItemKey($cart_item_key);
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Remove invalid free products
     * */
    public static function removeInvalidFreeProducts(){
        $cart_items = Woocommerce::getCart();
        if (!empty($cart_items)) {
            foreach ($cart_items as $key => $item) {
                if (isset($item[self::$free_product_cart_item_identifier])) {
                    if ($item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value) {
                        if (!in_array($key, self::$cart_item_free_products)) {
                            Woocommerce::remove_cart_item($key);
                        }
                    }
                }
            }
        }
    }

    /**
     * Add Free Product cart item key
     * */
    protected static function addFreeProductCartItemKey($key){
        if(empty(self::$cart_item_free_products)){
            self::$cart_item_free_products[] = $key;
        } else {
            if(!in_array($key, self::$cart_item_free_products)){
                self::$cart_item_free_products[] = $key;
            }
        }
    }

    /**
     * Set zero price for free products
     * */
    public static function setZeroPriceForFreeProduct(){
        $cart_items = Woocommerce::getCart();
        if(!empty($cart_items)){
            foreach ($cart_items as $key => $item){
                if ( !empty( $item[self::$free_product_cart_item_identifier] ) ){
                    if(!empty($item["data"])){
                        if($item[self::$free_product_cart_item_identifier] == self::$free_product_cart_item_identifier_value){
                            Woocommerce::setCartProductPrice($item["data"], 0);
                        }
                    }
                }
            }
        }
    }

    /**
     * Get free product quantity for recursive range
     *
     * @param $range_start int
     * @param $cart_quantity int
     * @param $free_quantity int
     * @param $increment int
     * @return int
     * */
    /*public static function getRecursiveQuantity_old($range_start, $cart_quantity, $free_quantity, $increment = 1){
        if($cart_quantity < $range_start){
            return $free_quantity*(--$increment);
        } else {
            $range_start = $range_start/$increment;
            $increment++;
            $range_start *= $increment;
            return self::getRecursiveQuantity($range_start, $cart_quantity, $free_quantity, $increment);
        }
    }*/

    /**
     * Get free product quantity for recursive range
     *
     * @param $range_start int
     * @param $cart_quantity int
     * @param $free_quantity int
     * @param $increment int
     * @return int
     * */
    public static function getRecursiveQuantity($range_start, $cart_quantity, $free_quantity, $increment = 1){
        if($cart_quantity < $range_start){
            return $free_quantity;
        } else {
            $customized_range_start = (int)($cart_quantity/$range_start);
            $free_quantity = $customized_range_start * $free_quantity;
            return $free_quantity;
        }
    }

    /**
     * Calculate discount price from rule range
     *
     * @param $matched_rule object
     * @param $price int/float
     * @param $discount_quantity int
     * @param $quantity int
     * @param $product object
     *
     * @return int/float
     * */
    public static function calculateDiscountPriceFromRuleRange($matched_rule, $price, $discount_quantity, $quantity, $product){
        $discount_price = 0;
        if(!empty($matched_rule)){
            if(!empty($matched_rule->free_type)){
                if($matched_rule->free_type == "percentage"){
                    if($matched_rule->free_value > 0){
                        $discount_price = self::getDiscountPriceForProductFromQuantityBasedPercentageDiscount($product, $price, $quantity, $matched_rule->free_value, $discount_quantity);
                    }
                } else if($matched_rule->free_type == "flat"){
                    if($matched_rule->free_value > 0){
                        $discount_price = self::getDiscountPriceForProductFromQuantityBasedFlatDiscount($product, $price, $quantity, $matched_rule->free_value, $discount_quantity);
                    }
                }
            }

        }

        return $discount_price;
    }

    /**
     * Get discount price for product based on percentage for specific quantity
     *
     * @param $product object
     * @param $product_price int/float
     * @param $product_qty int
     * @param $discount_value int/float
     * @param $discount_qty int
     *
     * @return int/float
     * */
    protected static function getDiscountPriceForProductFromQuantityBasedPercentageDiscount($product, $product_price, $product_qty, $discount_value, $discount_qty){
        $discount_amount_per_product = ($discount_value / 100) * $product_price;
        if($product_qty <= $discount_qty){
            $discount_price = $discount_amount_per_product;
        } else {
            $non_discount_qty = $product_qty - $discount_qty;
            $total_price_for_non_discount_qty = $non_discount_qty * $product_price;
            $total_price_for_discount_qty = $discount_qty * ($product_price - $discount_amount_per_product);
            $total_discounted_price = $total_price_for_non_discount_qty + $total_price_for_discount_qty;
            $discounted_price_per_product = $total_discounted_price / $product_qty;
            $discount_price = $product_price - $discounted_price_per_product;
            if($discount_price < 0){
                $discount_price = 0;
            }
        }

        return $discount_price;
    }

    /**
     * Get discount price for product based on flat discount for specific quantity
     *
     * @param $product object
     * @param $product_price int/float
     * @param $product_qty int
     * @param $discount_amount_per_product int/float
     * @param $discount_qty int
     *
     * @return int/float
     * */
    protected static function getDiscountPriceForProductFromQuantityBasedFlatDiscount($product, $product_price, $product_qty, $discount_amount_per_product, $discount_qty){
        if($product_qty <= $discount_qty){
            $discount_price = $discount_amount_per_product;
        } else {
            $non_discount_qty = $product_qty - $discount_qty;
            $total_price_for_non_discount_qty = $non_discount_qty * $product_price;
            $total_price_for_discount_qty = $discount_qty * ($product_price - $discount_amount_per_product);
            $total_discounted_price = $total_price_for_non_discount_qty + $total_price_for_discount_qty;
            $discounted_price_per_product = $total_discounted_price / $product_qty;
            $discount_price = $product_price - $discounted_price_per_product;
            if($discount_price < 0){
                $discount_price = 0;
            }
        }

        return $discount_price;
    }
}

BOGO::init();