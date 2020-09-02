<?php

namespace WDRPro\App\Rules;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Rule;
use Wdr\App\Helpers\Woocommerce;
use Wdr\App\Helpers\Template;

class BuyXGetY
{

    public static $product_can_be_chosen = array();

    public static $awdr_customer_choice_products_key = 'awdr_customer_choice_products';
    public static $awdr_customer_chosen_product_key = 'awdr_customer_chosen_product';

    protected static $discount_type_key = 'buy_x_get_y_discount';
    protected static $calculated_discounts = array();

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
        add_filter('advanced_woo_discount_rules_discounts_of_each_rule', array(__CLASS__, 'setBXGYDiscountValue'), 10, 9);
        add_filter('advanced_woo_discount_rules_calculated_discounts_of_each_rule', array(__CLASS__, 'setCalculatedDiscountValue'), 10, 6);
        add_filter('advanced_woo_discount_rules_calculated_discounts_of_each_rule_for_ajax_price', array(__CLASS__, 'setCalculatedDiscountValue'), 10, 6);
        add_filter('advanced_woo_discount_rules_has_any_discount', array(__CLASS__, 'getBuyXGetYAdjustment'), 10, 2);
        add_action('woocommerce_after_cart_item_name', array(__CLASS__, 'loadCustomizableProductsAfterCartItemName'), 10, 2);
        add_filter('advanced_woo_discount_rules_process_discount_for_product_which_do_not_matched_filters', array(__CLASS__, 'applyDiscountForNonMatchedFilterProduct'), 10, 4);
        add_filter('advanced_woo_discount_rules_advance_table_based_on_rule', array(__CLASS__, 'addAdvanceTableForBuyXGetY'), 10, 6);
        add_filter('advanced_woo_discount_rules_filter_passed', array(__CLASS__, 'checkFilterPassed'), 10, 4);
        add_filter('advanced_woo_discount_rules_is_rule_passed_with_out_discount_for_exclusive_rule', array(__CLASS__, 'checkExclusiveRulePassed'), 10, 4);
    }

    public static function checkExclusiveRulePassed($status, $product, $rule, $cart_item){
        if(self::hasBuyXGetYDiscount($rule->rule)){
            $buy_x_get_y_ranges = self::getBuyXGetYAdjustments($rule);
            if(empty($buy_x_get_y_ranges->ranges->{1}->from)){
                return null;
            }

            if(in_array($buy_x_get_y_ranges->operator, array('product', 'variation'))) {
                $matched_rule = self::checkAnyRuleMatchesForTheProduct($buy_x_get_y_ranges, $rule, 0, $cart_item['quantity'], $product, true);
                if(is_string($matched_rule) && $matched_rule == "free_product"){
                    $status = true;
                }
            } else {
                $quantity = $rule->getQuantityBasedOnCountAdjustment($buy_x_get_y_ranges->operator, 0, $product);
                if(isset($buy_x_get_y_ranges->ranges) && !empty($buy_x_get_y_ranges->ranges)) {
                    $matched_rule = self::getMatchedRule($buy_x_get_y_ranges->ranges, $quantity, $product);
                    if(!empty($matched_rule)){
                        $status = true;
                    }
                }
            }
        }

        return $status;
    }

    public static function applyDiscountForNonMatchedFilterProduct($calculate_discount, $product, $rule, $cart_item){
        if(self::hasBuyXGetYDiscount($rule->rule)){
            $calculate_discount = true;
        }
        return $calculate_discount;
    }

    /**
     * Update Customer choice products in session
     *
     * @param $rule_id mixed
     * @param $customer_choice array
     * */
    public static function updateCustomerChoiceProducts($rule_id, $customer_choice){
        $awdr_customer_choice_products = Woocommerce::getSession(self::$awdr_customer_choice_products_key, array());
        $awdr_customer_choice_products[$rule_id] = $customer_choice;
        Woocommerce::setSession(self::$awdr_customer_choice_products_key, $awdr_customer_choice_products);
    }

    /**
     * Get customizable auto add products data
     *
     * @param $cart_item array
     * @param $cart_item_key string
     *
     * @return array
     * */
    protected static function getCustomizableAutoAddProduct($cart_item, $cart_item_key){
        $customer_choice = array();
        if(isset($cart_item['customer_choice']) && !empty($cart_item['customer_choice'])){
            $customer_choice = $cart_item['customer_choice'];
        } else {
            $awdr_customer_choice_products = Woocommerce::getSession(self::$awdr_customer_choice_products_key, array());
            $session_key_auto_added_cart_items = Woocommerce::getSession(BXGYAutoAdd::$session_key_auto_added_cart_items, array());
            if(isset($session_key_auto_added_cart_items[$cart_item_key]) && isset($session_key_auto_added_cart_items[$cart_item_key]['rule_key'])){
                $rule_key = $session_key_auto_added_cart_items[$cart_item_key]['rule_key'];
                if(isset($awdr_customer_choice_products[$rule_key])){
                    $customer_choice = $awdr_customer_choice_products[$rule_key];
                }

            }
        }
        return $customer_choice;
    }

    /**
     * Load customizable products after cart item name
     *
     * @param $cart_item array
     * @param $cart_item_key string
     * */
    public static function loadCustomizableProductsAfterCartItemName($cart_item, $cart_item_key){
        $customer_choice = self::getCustomizableAutoAddProduct($cart_item, $cart_item_key);
        if(!empty($customer_choice)){
            $current_product = $cart_item['data'];
            $product_id = Woocommerce::getProductId($current_product);
            if(isset($customer_choice[$product_id])){
                $customer_product_choice = $customer_choice[$product_id];
                self::displayOptionToChangeProduct($product_id, $customer_product_choice);
            }
        }
    }

    /**
     * Change discounted product in cart as per customer choice
     *
     * @param $rule_id mixed
     * @param $product_id int
     * @param $parent_id int
     *
     * @return int
     * */
    public static function changeDiscountedProductInCart($rule_id, $product_id, $parent_id){
        $awdr_customer_chosen_product = Woocommerce::getSession(self::$awdr_customer_chosen_product_key, array());
        $awdr_customer_chosen_product[$rule_id][$parent_id] = $product_id;
        Woocommerce::setSession(self::$awdr_customer_chosen_product_key, $awdr_customer_chosen_product);
        return 1;
    }

    /**
     * Display option to change product in cart
     *
     * @param $product_id int
     * @param $customer_product_choice array
     * */
    public static function displayOptionToChangeProduct($product_id, $customer_product_choice){
        //TODO: Display in right format
        if(isset($customer_product_choice['available_products']) && !empty($customer_product_choice['available_products'])){
            $template_helper = new Template();
            $available_products = $customer_product_choice['available_products'];
            $override_path = get_theme_file_path('woo-discount-rules-pro/buy-x-get-y-select-auto-add-variant.php');
            $variant_select_box_template_path = WDR_PRO_PLUGIN_PATH . 'App/Views/Templates/buy-x-get-y-select-auto-add-variant.php';
            if (file_exists($override_path)) {
                $variant_select_box_template_path = $override_path;
            }
            $template_helper->setPath($variant_select_box_template_path)->setData(array('available_products' => $available_products, 'customer_product_choice' => $customer_product_choice, 'woocommerce' => new Woocommerce()))->display();
        }
    }

    /**
     * Check any rule matches for the product
     * */
    protected static function checkAnyRuleMatchesForTheProduct($buy_x_get_y_ranges, $rule, $price, $product_quantity, $product, $is_cart){
        $return = array();
        if(in_array($buy_x_get_y_ranges->operator, array('product', 'variation'))){
            $cart = Woocommerce::getCart();
            foreach ($cart as $cart_item){
                if ($rule->isFilterPassed($cart_item['data'])) {
                    if ($rule->hasConditions()) {
                        if (!$rule->isCartConditionsPassed($cart)) {
                            continue;
                        }
                    }
                    $quantity = $cart_item['quantity'];
                    if($buy_x_get_y_ranges->operator == 'variation'){
                        $quantity = $rule->getQuantityBasedOnCountAdjustment($buy_x_get_y_ranges->operator, $quantity, $cart_item['data'], $is_cart);
                    }
                    $matched_rule = self::getMatchedRule($buy_x_get_y_ranges->ranges, $quantity, $cart_item['data']);
                    if(!empty($matched_rule)){
                        $product_id = Woocommerce::getProductId($product);
                        if(in_array($product_id, $matched_rule->products) && $matched_rule->free_type != "free_product"){
                            return $matched_rule;
                        } else {
                            return "free_product";
                        }
                    }
                }
            }
        }
        return $return;
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
    public static function calculateBuyXGetYDiscount($rule, $price, $product_quantity, $product, $ajax_price = false, $cart_item = array(), $is_cart = true){
        $buy_x_get_y_ranges = self::getBuyXGetYAdjustments($rule);
        if(empty($buy_x_get_y_ranges->ranges->{1}->from)){
            return null;
        }
        $matched_rule = $return_value = array();
        $check_for_matched_rule = true;
        if(in_array($buy_x_get_y_ranges->operator, array('product', 'variation'))) {
            $matched_rule = self::checkAnyRuleMatchesForTheProduct($buy_x_get_y_ranges, $rule, $price, $product_quantity, $product, $is_cart);
            $check_for_matched_rule = false;
            if(is_string($matched_rule) && $matched_rule == "free_product"){
                $matched_rule = array();
                $check_for_matched_rule = true;
            }
        }
        if($check_for_matched_rule){
            $quantity = $rule->getQuantityBasedOnCountAdjustment($buy_x_get_y_ranges->operator, $product_quantity, $product);
            if(isset($buy_x_get_y_ranges->ranges) && !empty($buy_x_get_y_ranges->ranges)){
                $matched_rule = self::getMatchedRule($buy_x_get_y_ranges->ranges, $quantity, $product);
                if(!empty($matched_rule)){
                    if($matched_rule->free_type == "free_product"){
                        if(!$rule->isFilterPassed($product)){
                            $matched_rule = array();
                        }
                    }
                }

//                if(in_array($buy_x_get_y_ranges->operator, array('product', 'variation'))) {
//                    if (!empty($matched_rule) && $matched_rule->free_type != "free_product") {
//                        $matched_rule = array();
//                    }
//                }
            }
        }
        $rule_matched_key = self::getBuyXGetYDiscountKey($rule, $buy_x_get_y_ranges->operator, $product);
        BXGYAutoAdd::$auto_add_products[$rule_matched_key] = array();
        BXGYAutoAdd::$matched_products[$rule_matched_key] = array();
        if(!empty($matched_rule)){
            $discount_quantity = $matched_rule->free_qty;
            $discount_type = $matched_rule->free_type;
            $discount_price = 0;
            $discount_product_ids = $matched_rule->products;
            $apply_discount_to_child = apply_filters('advanced_woo_discount_rules_apply_discount_to_variants', true);
            if ($apply_discount_to_child) {
                if (isset($matched_rule->products_variants) && !empty($matched_rule->products_variants)) {
                    $products_variants = $matched_rule->products_variants;
                    $awdr_customer_chosen_product = Woocommerce::getSession(self::$awdr_customer_chosen_product_key, array());
                    foreach ($discount_product_ids as $key => $discount_product_id){
                        if(isset($products_variants->{$discount_product_id}) && !empty($products_variants->{$discount_product_id})){
                            $product_variants = $products_variants->{$discount_product_id};
                            if(isset($product_variants[0])){
                                $chosen_product_id = $product_variants[0];
                                if(isset($awdr_customer_chosen_product[$rule_matched_key][$discount_product_id])){
                                    $chosen_product_id = $awdr_customer_chosen_product[$rule_matched_key][$discount_product_id];
                                }
                                $discount_product_ids[$key] = $chosen_product_id;
                                self::$product_can_be_chosen[$rule_matched_key][$chosen_product_id] = array(
                                    'matched_rule_identification' => $rule_matched_key,
                                    'chosen' => $chosen_product_id,
                                    'parent_product_id' => $discount_product_id,
                                    'available_products' => $product_variants,
                                );
                            }
                        }
                    }
//                    $discount_product_ids = Helper::combineProductArrays($discount_product_ids, $matched_rule->products_variants);
                }

            }
            $cart_item_key = (isset($cart_item['key']))? $cart_item['key']: Woocommerce::getProductId($product);
            if($matched_rule->free_type == "free_product"){
                $discount_type = "buy_x_get_y";
            } else {
                $auto_add = apply_filters('advanced_woo_discount_rules_auto_add_and_remove_products_for_bxgy_limited_discount', true, $rule);// TODO : make it as dynamic option
                if($auto_add){
                    BXGYAutoAdd::$auto_add_products[$rule_matched_key] = self::getProductsWhichDoNotExistsInCart($discount_product_ids, $discount_quantity, $rule);
                    BXGYAutoAdd::$matched_products[$rule_matched_key] = array("product_ids" => $discount_product_ids, "discount_quantity" => $discount_quantity);
                }
                if(!empty($cart_item)){
                    $items_has_discount = self::getDiscountableItemsFromCart($rule, $discount_quantity, $discount_product_ids);
                    $current_cart_item_key = $cart_item['key'];
                    if(isset($items_has_discount[$current_cart_item_key])){
                        $discount_price = BOGO::calculateDiscountPriceFromRuleRange($matched_rule, $price, $items_has_discount[$current_cart_item_key]['cart_item_quantity_to_apply'], $cart_item['quantity'], $product);
                    }
                }
            }

            $discount_value = $matched_rule->free_value;
            $return_value = array(
                "discount_type" => $discount_type,
                "count_based_on" => $buy_x_get_y_ranges->operator,
                "discount_value" => $discount_value,
                "discount_quantity" => $discount_quantity,
                "discount_price_per_quantity" => Cheapest::calculateDiscountPricePerQuantity($matched_rule, $price),
                "discount_price" => $discount_price,
            );
            if(isset(self::$product_can_be_chosen[$rule_matched_key])){
                $return_value['customer_choice'] = self::$product_can_be_chosen[$rule_matched_key];
                self::updateCustomerChoiceProducts($rule_matched_key, self::$product_can_be_chosen[$rule_matched_key]);
            }
            if(!empty($cart_item)){
                if(isset($cart_item['key'])){
                    $return_value['discount_for_cart_item_keys'][] = $cart_item['key'];
                    $return_value['discount_products'] = $discount_product_ids;
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
     * Get products which doesn't exists in cart
     *
     * @param $product_ids array
     * @param $quantity int
     *
     * @return array
     * */
    protected static function getProductsWhichDoNotExistsInCart($product_ids, $quantity, $rule){
        $cart = Woocommerce::getCart();
        $auto_add_products = array();
        foreach ($product_ids as $product_id){
            $quantity_to_add = $quantity;
            foreach ($cart as $key => $item){
                $cart_item_product = $item['data'];
                $cart_item_product_id = Woocommerce::getProductId($cart_item_product);
                if($cart_item_product_id == $product_id){
                    $cart_item_quantity = $item['quantity'];
                    if(apply_filters('advanced_woo_discount_rules_buy_x_get_y_auto_update_quantity', true, $item)){
                        $quantity_to_add -= $cart_item_quantity;
                        if($quantity_to_add <= 0){
                            break;
                        }
                    } else {
                        $quantity_to_add = 0;
                        break;
                    }
                }
            }
            if($quantity_to_add > 0){
                $auto_add_products[$product_id]['quantity'] = $quantity_to_add;
                $auto_add_products[$product_id]['rule_id'] = $rule->rule->id;
            }
        }

        return $auto_add_products;
    }

    /**
     * Get discountable item from cart
     *
     * @param $rule object
     * @param $discount_quantity int
     * @param $discount_products array
     *
     * @return array
     * */
    public static function getDiscountableItemsFromCart($rule, $discount_quantity, $discount_products){
        $cart = Woocommerce::getCart();
        $cheapest_price = null;
        $discount_items = array();
        $discount_item_qty = array();
        if(!empty($cart)){
            foreach ($cart as $key => $item){
                    if(apply_filters('advanced_woo_discount_rules_process_cart_item_for_buy_x_get_y_limited_discounts', true, $item, $rule)){
                        $cart_item_product = $item['data'];
                        $cart_item_product_id = Woocommerce::getProductId($cart_item_product);
                        if(in_array($cart_item_product_id, $discount_products)){
                            $balance_discount_qty = isset($discount_item_qty[$cart_item_product_id])? $discount_item_qty[$cart_item_product_id]: $discount_quantity;
                            $discount_item_qty[$cart_item_product_id] = $balance_discount_qty;
                            if($balance_discount_qty > 0){
                                if($item['quantity'] >= $balance_discount_qty){
                                    $qty_to_apply = $balance_discount_qty;
                                } else {
                                    $qty_to_apply = $item['quantity'];
                                }
                                $discount_item_qty[$cart_item_product_id] -= $qty_to_apply;
                                $discount_items[$key] = array(
                                    'cart_item_key' => $key,
                                    'cart_item_quantity' => $item['quantity'],
                                    'cart_item_quantity_to_apply' => $qty_to_apply,
                                    'cart_item_product_id' => $cart_item_product_id,
                                );
                            }
                        }
                    }
            }
        }

        return $discount_items;
    }

    /**
     * Get Matched Rule
     *
     * @param $buy_x_get_y_ranges object
     * @param $quantity int
     * @param $product object
     *
     * @return mixed
     * */
    protected static function getMatchedRule($buy_x_get_y_ranges, $quantity, $product){
        $matched_rule = array();
        foreach ($buy_x_get_y_ranges as $key => $buy_x_get_y_range){
            $start = (int)($buy_x_get_y_range->from);
            if(!empty($buy_x_get_y_range->recursive) && $buy_x_get_y_range->recursive == 1){
                $free_quantity = (int)($buy_x_get_y_range->free_qty);
                if($quantity < $start){
                    $free_quantity = 0;
                } else {
                    $free_quantity = BOGO::getRecursiveQuantity($start, $quantity, $free_quantity);
                }
                if($free_quantity){
                    $matched_rule = clone $buy_x_get_y_range;
                    $matched_rule->free_qty = $free_quantity;
                }
                return $matched_rule;
            }
            if(empty($buy_x_get_y_range->to)){
                if($buy_x_get_y_range->from <= $quantity){
                    $matched_rule = $buy_x_get_y_range;
                    break;
                }
            } else {
                if($buy_x_get_y_range->from <= $quantity && $buy_x_get_y_range->to >= $quantity){
                    $matched_rule = $buy_x_get_y_range;
                    break;
                }
            }
        }

        return $matched_rule;
    }

    /**
     * check the rule has product discount
     * @return bool
     */
    public static function hasBuyXGetYDiscount($rule)
    {
        if (isset($rule->buy_x_get_y_adjustments)) {
            if (!empty($rule->buy_x_get_y_adjustments) && $rule->buy_x_get_y_adjustments != '{}' && $rule->buy_x_get_y_adjustments != '[]') {
                $rule_data = json_decode($rule->buy_x_get_y_adjustments);
                if(!empty($rule_data)){
                    if(isset($rule_data->type) && $rule_data->type == "bxgy_product"){
                        if(isset($rule_data->mode) && $rule_data->mode == "auto_add"){
                            return true;
                        }
                    }
                }
            }
        }

        return false;
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
    public static function getBuyXGetYDiscountKey($rule, $buy_x_get_y_discount_data, $product){
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
     * Set buy x get y discount value for a product/item
     * */
    public static function setBXGYDiscountValue($discounts, $rule, $product_price, $quantity, $product, $ajax_price, $cart_item, $price_display_condition, $is_cart){
        $buy_x_get_y_discount = 0;
        if(isset($rule->rule)){
            if (self::hasBuyXGetYDiscount($rule->rule)) {
                $buy_x_get_y_discount_data = self::calculateBuyXGetYDiscount($rule, $product_price, $quantity, $product, $ajax_price, $cart_item, $is_cart);
                if(!empty($buy_x_get_y_discount_data)){
                    if($buy_x_get_y_discount_data['discount_type'] == 'buy_x_get_y'){
                        $buy_x_get_y_discount_data['rule_id'] = $rule->rule->id;
                        $key = self::getBuyXGetYDiscountKey($rule, $buy_x_get_y_discount_data, $product);
                        $existing_discounts = array();
                        if(isset(Rule::$additional_discounts['buy_x_get_y_discounts'])){
                            $existing_discounts = Rule::$additional_discounts['buy_x_get_y_discounts'];
                        }
                        if(empty($existing_discounts[$key])){
                            Rule::$additional_discounts['buy_x_get_y_discounts'][$key] = $buy_x_get_y_discount_data;
                        } else {
                            if(!empty($existing_discounts[$key]['discount_for_cart_item_keys']) && is_array($existing_discounts[$key]['discount_for_cart_item_keys'])){
                                if(!empty($buy_x_get_y_discount_data['discount_for_cart_item_keys'])){
                                    $existing_discounts[$key]['discount_for_cart_item_keys'] = array_merge($existing_discounts[$key]['discount_for_cart_item_keys'], $buy_x_get_y_discount_data['discount_for_cart_item_keys']);
                                }
                                Rule::$additional_discounts['buy_x_get_y_discounts'][$key] = $existing_discounts[$key];
                            }
                        }
                    } else {
                        if(isset($buy_x_get_y_discount_data['discount_price'])) $buy_x_get_y_discount = $buy_x_get_y_discount_data['discount_price'];
                    }
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
    public static function getBuyXGetYAdjustments($rule){
        if(isset($rule->rule)){
            if (self::hasBuyXGetYDiscount($rule->rule)) {
                return json_decode($rule->rule->buy_x_get_y_adjustments);
            }
        }

        return false;
    }

    /**
     * Get Buy X Get X settings for the rule
     */
    public static function getBuyXGetYAdjustmentsForAdmin($rule){
        if(isset($rule->rule)){
            if (isset($rule->rule->buy_x_get_y_adjustments)) {
                if (!empty($rule->rule->buy_x_get_y_adjustments) && $rule->rule->buy_x_get_y_adjustments != '{}' && $rule->rule->buy_x_get_y_adjustments != '[]') {
                    return json_decode($rule->rule->buy_x_get_y_adjustments);
                }
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
    public static function getBuyXGetYAdjustment($has_additional_rules, $rule){
        $has_rule = self::getBuyXGetYAdjustments($rule);
        if($has_rule){
            $has_additional_rules = true;
        }

        return $has_additional_rules;
    }

    public static function checkFilterPassed($filter_passed, $rule, $product, $sale_badge){
        $rule_type = $rule->getRuleDiscountType();
        if($sale_badge){
            if ($rule_type == 'wdr_buy_x_get_y_discount') {
                $rule_details = self::getBuyXGetYAdjustmentsForAdmin($rule);
                if (is_object($rule_details)) {
                    $get_y_type = isset($rule_details->type) ? $rule_details->type : '';
                    $get_y_ranges = isset($rule_details->ranges) ? $rule_details->ranges : '';
                    if ($get_y_type == 'bxgy_product') {
                        if (!empty($get_y_ranges)) {
                            foreach ($get_y_ranges as $range) {
                                $product_ids = isset($range->products) ? $range->products : array();
                                $product_id = Woocommerce::getProductId($product);
                                if (in_array($product_id, $product_ids)) {
                                    $filter_passed = true;
                                }
                            }
                        }
                    } elseif ($get_y_type == 'bxgy_category') {
                        if (!empty($get_y_ranges)) {
                            foreach ($get_y_ranges as $range) {
                                $categories_id = isset($range->categories) ? $range->categories : array();
                                $category_id = Woocommerce::getProductCategories($product);
                                if (array_intersect($categories_id, $category_id)) {
                                    $filter_passed = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $filter_passed;
    }

    /**
     * Add advance table / Discount Badge
     *
     * @param $advanced_layout
     * @param $rule
     * @param $discount_calculator
     * @param $product
     * @param $product_price
     * @param $html_content
     * @return mixed
     */
    public static function addAdvanceTableForBuyXGetY($advanced_layout, $rule, $discount_calculator, $product, $product_price, $html_content){
        if ($rule->isFilterPassed($product, true) && !empty($html_content)) {
            $has_buy_x_get_y_discount = self::getBuyXGetYAdjustmentsForAdmin($rule);
            $discounted_title_text = $rule->getTitle();
            if (isset($has_buy_x_get_y_discount) && !empty($has_buy_x_get_y_discount) && isset($has_buy_x_get_y_discount->ranges) && !empty($has_buy_x_get_y_discount->ranges)) {

                foreach ($has_buy_x_get_y_discount->ranges as $range) {
                    $min = intval(isset($range->from) ? $range->from : 0);
                    $max = intval(isset($range->to) ? $range->to : 0);
                    if (!empty($min) || !empty($max)) {
                        $discount_price = 0;
                        $discount_method = "bxgy_discount";
                        $discount_type = isset($range->free_type)? $range->free_type: 'free_product';
                        if($discount_type != 'free_product'){
                            $discount_price = $rule->calculator($discount_type, $product_price, $range->value);
                        }else{
                            $discount_price = $product_price;
                        }
                        $free_value = (isset($range->free_value) && !empty($range->free_value)) ? $range->free_value : 0;
                        $badge_bg_color = $rule->getAdvancedDiscountMessage('badge_color_picker', '#ffffff');
                        $badge_text_color = $rule->getAdvancedDiscountMessage('badge_text_color_picker', '#000000');
                        self::getDiscountBadgeTextForBuyXGetY($advanced_layout, $discount_type, $discount_method, $product_price, $free_value, $discount_price, $discounted_title_text, $html_content, $badge_bg_color, $badge_text_color, $min, $max);
                    }
                }
            }
        }
        return $advanced_layout;
    }

    /**
     * Get discount badge text
     *
     * @param $advanced_layout
     * @param $type
     * @param $discount_method
     * @param $product_price
     * @param $value
     * @param $discount_price
     * @param $discounted_title_text
     * @param $html_content
     * @param $badge_bg_color
     * @param $badge_text_color
     * @param int $min
     * @param int $max
     */
    protected static function getDiscountBadgeTextForBuyXGetY(&$advanced_layout, $type, $discount_method, $product_price, $value, $discount_price, $discounted_title_text, $html_content, $badge_bg_color, $badge_text_color, $min = 0, $max = 0)
    {
        $discount_text = '';
        $discounted_price_text = '';
        switch ($type) {
            case 'free_product':
                if (!empty($product_price)) {
                    $discount_text = Woocommerce::formatPrice($product_price);
                }
                break;
            case 'flat':
                if (!empty($value)) {
                    // $discount = $product_price - $value;
                    $discount_text = Woocommerce::formatPrice($value);
                    // $discounted_price_text = Woocommerce::formatPrice($discount);
                }
                break;
            case 'percentage':
                if (!empty($value) ) {
                    $discount_text = $value . '%';
                }
                break;
        }
        if (!empty($discount_text) ) {
            $dont_allow_duplicate = true;
            $searchForReplace = array('{{title}}');//, '{{min_quantity}}', '{{discount}}', '{{max_quantity}}'
            $string_to_replace = array($discounted_title_text);// $min, $discount_text, $max
            $html_content = str_replace($searchForReplace, $string_to_replace, $html_content);
            $searchForRemove = array('/{{min_quantity}}/', '/{{max_quantity}}/', '/{{discount}}/', '/{{discounted_price}}/');
            $replacements = array('', '');
            $html_content = preg_replace($searchForRemove, $replacements, $html_content);

            if (!empty($advanced_layout)) {
                foreach ($advanced_layout as $layout_options) {
                    $check_exists = array($layout_options['badge_text']);
                    if (in_array($html_content, $check_exists)) {
                        $dont_allow_duplicate = false;
                        break;
                    }
                }
            }
            if ($dont_allow_duplicate) {
                $advanced_layout[] = array(
                    'badge_bg_color' => $badge_bg_color,
                    'badge_text_color' => $badge_text_color,
                    'badge_text' => $html_content,
                );
            }
        }
    }
}
BuyXGetY::init();