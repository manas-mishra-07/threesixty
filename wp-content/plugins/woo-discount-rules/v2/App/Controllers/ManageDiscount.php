<?php

namespace Wdr\App\Controllers;

use Wdr\App\Helpers\Helper;
use Wdr\App\Helpers\Rule;
use Wdr\App\Helpers\Woocommerce;
use Wdr\App\Models\DBTable;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ManageDiscount extends Base
{
    public static $available_rules = array(), $calculator, $on_sale_products = array(), $calculated_cart_item_discount = array(), $calculated_cart_discount = array(), $calculated_product_discount = array(), $cart_discounts = array(), $set_total_quantity = 0, $categories_slug = array(), $cart_tot_qty = array();
    public $free_shipping = false, $shipping_obj;

    /**
     * ManageDiscount constructor.
     */
    function __construct()
    {
        parent::__construct();
        // set available rules to static variables
        $this->getDiscountRules();
    }

    /**
     * get available rules
     * @return array|object|null
     */
    function getDiscountRules()
    {
        if (empty(self::$available_rules)) {
            $rule_helper = new Rule();
            self::$available_rules = $rule_helper->getAvailableRules($this->getAvailableConditions());
        }
        self::$calculator = new DiscountCalculator(self::$available_rules);
        return self::$available_rules;
    }

    /**
     * load required styles and scripts needed for site
     */
    function loadAssets()
    {
        $ajax_update_price = self::$config->getConfig('show_strikeout_when', 'show_when_matched');
        wp_enqueue_style(WDR_SLUG . '-customize-table-ui-css', WDR_PLUGIN_URL . 'Assets/Css/customize-table.css');
        wp_enqueue_script('awdr-main', WDR_PLUGIN_URL . 'Assets/Js/site_main.js', array('jquery'));
        $awdr_front_end_script = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'enable_update_price_with_qty' => $ajax_update_price,
            'custom_target_simple_product' => apply_filters('advanced_woo_discount_rules_custom_target_for_simple_product_on_qty_update', ""),
            'custom_target_variable_product' => apply_filters('advanced_woo_discount_rules_custom_target_for_variable_product_on_qty_update', ""),
            'js_init_trigger' => apply_filters('advanced_woo_discount_rules_update_discount_price_init_trigger', ""),
        );
        wp_enqueue_script('awdr-dynamic-price', WDR_PLUGIN_URL . 'Assets/Js/awdr-dynamic-price.js', array('jquery'));
        wp_localize_script('awdr-main', 'awdr_params', $awdr_front_end_script);
    }

    /**
     * Check the product is in sale
     * @param $on_sale
     * @param $product
     * @return bool
     */
    function isProductInSale($on_sale, $product)
    {
        remove_filter('woocommerce_product_is_on_sale', array($this, 'isProductInSale'), 100);
        //Need to check if conditions also passed
        $show_on_sale_badge = self::$config->getConfig('show_on_sale_badge', 'disabled');
        if ($show_on_sale_badge == 'when_condition_matches') {
            if (self::$woocommerce_helper->productTypeIs($product, 'variable')) {
                $price_html = $this->getVariablePriceHtml('', $product);
            } else {
                // pass empty string as first argument in 'woocommerce_get_price_html' method to check if rule has been applied
                // empty result means that price was not change
                $price_html = $this->getPriceHtml('', $product);
            }
        } else {
            $price_html = self::$calculator->saleBadgeDisplayChecker($product, true);
        }
        if($price_html !== '' && $price_html === false){
            $product_id = Woocommerce::getProductId($product);
            self::updateProductsAsOnSale($product_id);
        }
        add_filter('woocommerce_product_is_on_sale', array($this, 'isProductInSale'), 100, 2);
        return $on_sale OR $price_html;
    }

    /**
     * Set product is on sale in static variable for avoid multiple run
     * This helps for sale badge text override
     * */
    protected static function updateProductsAsOnSale($product_id){
        if(!empty(self::$on_sale_products)){
            if(!in_array($product_id, self::$on_sale_products)){
                self::$on_sale_products[] = $product_id;
            }
        } else {
            self::$on_sale_products[] = $product_id;
        }

    }

    /**
     * Is product on sale through our plugin
     * This helps for sale badge text override
     * */
    protected static function isProductOnSale($product_id){
        if(!in_array($product_id, self::$on_sale_products)){
            return true;
        }

        return false;
    }

    /**
     * Replace sale tag text
     * */
    public function replaceSaleTagText($html, $post, $_product){
        $use_sale_badge_customize = apply_filters('advanced_woo_discount_rules_use_sale_badge_customization', false, $post, $_product);
        $product_id = Woocommerce::getProductId($_product);
        if(self::isProductOnSale($product_id) || $use_sale_badge_customize){
            $on_sale_badge_html = self::$config->getConfig('on_sale_badge_html', '<span class="onsale">Sale!</span>');
            $html = __($on_sale_badge_html, WDR_TEXT_DOMAIN);
            $html = apply_filters('advanced_woo_discount_rules_on_sale_badge_html', $html, $post, $_product);
        }


        return $html;
    }

    /**
     * get product sale price
     * @param $value
     * @param $product
     * @return mixed
     */
    function getProductSalePrice($value, $product)
    {
        $prices = self::calculateInitialAndDiscountedPrice($product, 1);
        if (!empty($prices['discounted_price_with_tax']))
            $value = $prices['discounted_price_with_tax'];
        return $value;
    }

    /**
     * get product regular price
     * @param $value
     * @param $product
     * @return mixed
     */
    function getProductRegularPrice($value, $product)
    {
        $prices = self::calculateInitialAndDiscountedPrice($product, 1);
        if (!empty($prices['initial_price_with_tax']))
            $value = $prices['initial_price_with_tax'];
        return $value;
    }

    /**
     * Modify the product's price when discount applicable.
     * @param $price_html
     * @param $product
     * @param int $quantity
     * @param boolean $ajax_price
     * @return mixed
     */
    function getPriceHtml($price_html, $product, $quantity = 1, $ajax_price = false)
    {
        if (empty(self::$available_rules)) {
            if($ajax_price){
                return false;
            }
            return $price_html;
        }
       // $initial_price_html = $price_html;
        $initial_price_html = $this->getCalculateDiscountPriceFrom($product, $price_html, $ajax_price);

        $modify_price = apply_filters('advanced_woo_discount_rules_modify_price_html', true, $price_html, $product, $quantity);
        if (!$modify_price) {
            if($ajax_price){
                return false;
            }
            return $price_html;
        }
        if (is_product() && empty(self::$config->getConfig('modify_price_at_product_page', 1))) {
            if($ajax_price){
                return false;
            }
            return $price_html;
        }
        if (is_shop() && empty(self::$config->getConfig('modify_price_at_shop_page', 1))) {
            if($ajax_price){
                return false;
            }
            return $price_html;
        }
        if (is_product_category() && empty(self::$config->getConfig('modify_price_at_category_page', 1))) {
            if($ajax_price){
                return false;
            }
            return $price_html;
        }
        if ($ajax_price) {
            $price_html = $initial_price_html;
            if(!$price_html){
                return false;
            }
        }

        //Check the product object is from WC_Product Class
        if (is_a($product, 'WC_Product')) {
            if(!$ajax_price) {
                if (self::$woocommerce_helper->productTypeIs($product, array('variable'))) {
                    return $price_html;
                }
            }
            $product_id = Woocommerce::getProductId($product);
            //Calculate the product price
            $prices = self::calculateInitialAndDiscountedPrice($product, $quantity, $is_cart = false, $ajax_price);
            if($ajax_price){
                $discount_details = (isset($prices['total_discount_details'])) ? $prices['total_discount_details'] : false;
                if($discount_details) {
                   // $initial_price = (isset($prices['initial_price_with_tax'])) ? $prices['initial_price_with_tax'] : 0;
                    //$discounted_price = (isset($prices['discounted_price_with_tax'])) ? $prices['discounted_price_with_tax'] : 0;
                    $initial_price = isset($prices['initial_price']) ? $prices['initial_price'] : 0;
                    $discounted_price = isset($prices['discounted_price']) ? $prices['discounted_price'] : 0;
                    if(empty($initial_price) || empty($discounted_price) || empty($discount_details)){
                        return $price_html;
                    }
                    return $this->getSetDiscountItemPriceHtml($discount_details, $initial_price, $discounted_price, $product, $price_html = true, $quantity, $ajax_price);
                }else{
                    return false;
                }
            }else {
                if (!$prices) {
                    return $price_html;
                }
                self::$calculated_product_discount[$product_id] = $prices;
                $initial_price_with_tax_call = $discounted_price_with_tax_call = 0;
                $calculator = self::$calculator;
                $initial_price = isset($prices['initial_price']) ? $prices['initial_price'] : 0;
                $discounted_price = isset($prices['discounted_price']) ? $prices['discounted_price'] : 0;
                if(!empty($initial_price)){
                    $initial_price_with_tax_call = $calculator->mayHaveTax($product, $initial_price);
                }
                if(!empty($discounted_price)){
                    $discounted_price_with_tax_call = $calculator->mayHaveTax($product, $discounted_price);
                }
                $price_html = $this->getStrikeoutPrice($initial_price_with_tax_call, $discounted_price_with_tax_call, true, false, $initial_price_html);
                $price_html = $price_html.Woocommerce::getProductPriceSuffix($product, $discounted_price_with_tax_call, $prices);
            }

        }

        return $price_html;
    }

    /**
     * getCalculateDiscountPriceFrom
     *
     * @param $product
     * @param $price_html
     * @param $ajax_price
     * @return string
     */
    function getCalculateDiscountPriceFrom($product, $price_html, $ajax_price){
        $calculate_discount_from = self::$config->getConfig('calculate_discount_from', 'sale_price');
        if ($calculate_discount_from == 'regular_price') {
            $product_price = self::$woocommerce_helper->getProductRegularPrice($product);
            $price_html = self::$woocommerce_helper->formatPrice($product_price);
            return $price_html.Woocommerce::getProductPriceSuffix($product, $product_price);
        }
        if($ajax_price){
            $product_price = self::$woocommerce_helper->getProductPrice($product);
            $price_html = self::$woocommerce_helper->formatPrice($product_price);
            return $price_html.Woocommerce::getProductPriceSuffix($product, $product_price);
        }
        return $price_html;
    }

    /**
     * Modify the product's price before modified by our plugin to adjust sale price.
     *
     * @param $price_html
     * @param $product
     * @param int $quantity
     * @return mixed
     * */
    function getPriceHtmlSalePriceAdjustment($price_html, $product, $quantity = 1)
    {
        $modify_price = apply_filters('advanced_woo_discount_rules_modify_sale_price_adjustment_html', true, $price_html, $product, $quantity);
        if (!$modify_price) {
            return $price_html;
        }
        $excluded_product_type = apply_filters('advanced_woo_discount_rules_exclude_product_type_for_sale_price_strikeout_adjustment', array('variable', 'subscription_variation', 'variable-subscription', 'grouped', 'composite'), $product);
        if (is_array($excluded_product_type) && !empty($excluded_product_type)) {
            if (!Woocommerce::productTypeIs($product, $excluded_product_type)) {
                $sale_price = Woocommerce::getProductSalePrice($product);
                $regular_price = Woocommerce::getProductRegularPrice($product);
                if ($sale_price <= 0) {
                    if($regular_price > 0){
                        $regular_price = get_option('woocommerce_tax_display_shop') == 'excl' ? Woocommerce::getExcludingTaxPrice($product, 1, $regular_price) : Woocommerce::getIncludingTaxPrice($product, 1, $regular_price);
                        $price_to_display = Woocommerce::formatPrice($regular_price);
                        $price_html = (($price_to_display) . Woocommerce::getProductPriceSuffix($product));
                    }
                    return $price_html;
                }
            }
        }
        return $price_html;
    }

    /**
     * Remove duplicate strikeout price
     * */
    function removeDuplicateStrikeoutPrice($item_price){
        $del_pattern = "/<del>(.*?)<\/del>/s";
        preg_match($del_pattern, $item_price, $matches);
        $del_content = isset($matches[1]) ? $matches[1] : '';
        $del_content = trim(strip_tags($del_content));
        $ins_pattern = "/<ins>(.*?)<\/ins>/s";
        preg_match($ins_pattern, $item_price, $matches);
        $ins_content_org = isset($matches[1]) ? $matches[1] : '';
        $ins_content = trim(strip_tags($ins_content_org));

        if(!empty($del_content) && !empty($ins_content)){
            if($del_content == $ins_content){
                $item_price = $ins_content_org;
            }
        }

        return $item_price;
    }

    /**
     * Variable product
     *
     * @param $price_html
     * @param $product
     * @param int $quantity
     * @return mixed|string
     */
    function getVariablePriceHtml($price_html, $product, $quantity = 1)
    {
        if (empty(self::$available_rules)) {
            return $price_html;
        }
        $modify_price = apply_filters('advanced_woo_discount_rules_modify_price_html', true, $price_html, $product, $quantity);
        if (!$modify_price) {
            return $price_html;
        }
        $original_prices_list = $discount_prices_lists = array();
        $variations = Woocommerce::getProductChildren($product);

        if (!empty($variations)) {
            foreach ($variations as $variation_id) {
                if (empty($variation_id)) {
                    continue;
                }
                $variation = Woocommerce::getProduct($variation_id);
                $prices = self::calculateInitialAndDiscountedPrice($variation, $quantity);
                if (!isset($prices['initial_price']) || !isset($prices['discounted_price'])) {
                    return $this->removeDuplicateStrikeoutPrice($price_html);
                }
                $original_prices_list[] = $prices['initial_price'];
                $discount_prices_lists[] = $prices['discounted_price'];
            }
        }
        $discount_prices_lists = array_unique($discount_prices_lists);
        $original_prices_list = array_unique($original_prices_list);
        $min_price = min($discount_prices_lists);
        $max_price = max($discount_prices_lists);
        $min_original_price = min($original_prices_list);
        $max_original_price = max($original_prices_list);
        $calculator = self::$calculator;
        if(!empty($min_original_price)){
            $min_original_price = $calculator->mayHaveTax($product, $min_original_price);
        }
        if(!empty($max_original_price)){
            $max_original_price = $calculator->mayHaveTax($product, $max_original_price);
        }
        if(!empty($min_price)){
            $min_price = $calculator->mayHaveTax($product, $min_price);
        }
        if(!empty($max_price)){
            $max_price = $calculator->mayHaveTax($product, $max_price);
        }
        $price_range_suffix = self::$woocommerce_helper->getProductPriceSuffix($product);
        if ($min_original_price == $max_original_price) {
            $price_html = self::$woocommerce_helper->formatPrice($min_original_price) . $price_range_suffix;
        } elseif ($min_original_price < $max_original_price) {
            $price_html = self::$woocommerce_helper->formatPriceRange($min_original_price, $max_original_price) . $price_range_suffix;
        }

        if ($min_price == $max_price) {
            $price_html_discounted = self::$woocommerce_helper->formatPrice($min_price) . $price_range_suffix;
            return $this->getStrikeoutPrice($price_html, $price_html_discounted, false, true);
        } elseif ($min_price < $max_price) {
            $price_html_discounted = self::$woocommerce_helper->formatPriceRange($min_price, $max_price) . $price_range_suffix;
            return $this->getStrikeoutPrice($price_html, $price_html_discounted, false, true);
        }

        return $price_html;
    }

    /**
     * override original price html with discounted price html
     * @param $original_price
     * @param $discounted_price
     * @param $format_price
     * @param $is_variable_product
     * @param $initial_price_html
     * @return string
     */
    function getStrikeoutPrice($original_price, $discounted_price, $format_price = true, $is_variable_product = false, $initial_price_html=false)
    {
        if ($original_price == $discounted_price) {
            if ($format_price) {
                $discounted_price = self::$woocommerce_helper->formatPrice($discounted_price);
            }
            $html = '<ins>' . $discounted_price . '</ins>';
        } else {
            if ($format_price) {
                $original_price = self::$woocommerce_helper->formatPrice($original_price);
                $discounted_price = self::$woocommerce_helper->formatPrice($discounted_price);
            }
            $separator = ($is_variable_product) ? '<br>' : '&nbsp;';
            if($initial_price_html){
                $initial_price_html = preg_replace('/<del>.*<\/del>/', '', $initial_price_html);
                $html = '<del>' . $initial_price_html . '</del>' . $separator . '<ins>' . $discounted_price . '</ins>';
            }else{
                $html = '<del>' . $original_price . '</del>' . $separator . '<ins>' . $discounted_price . '</ins>';
            }
        }
        return apply_filters('advanced_woo_discount_rules_strikeout_price_html', $html, $original_price, $discounted_price);
    }

    /**
     * override original price html with set discounted price html
     *
     * @param int $original_price
     * @param array $partially_qualified_sets
     * @param $other_discounts
     * @param $total_discount
     * @param $total_quantity
     * @param $product_obj
     * @param $return_html
     * @param $current_product_quantity
     * @param $discount_operator
     * @param $partially_qualified_set_amount_duplicate
     * @return bool|string
     */
    function getSetStrikeoutPrice($original_price, $partially_qualified_sets, $total_discount, $other_discounts, $total_quantity = 0, $product_obj, $return_html = true, $current_product_quantity, $discount_operator, $partially_qualified_set_amount_duplicate, $multi_strikeout)
    {
        $discounted_price = null;
        if (!empty($original_price) && is_array($partially_qualified_sets) && !empty($partially_qualified_sets) && !empty($total_quantity)) {
            $counts = count($partially_qualified_sets);
            if (!empty($partially_qualified_set_amount_duplicate)) {
                $duplicate_counts = count($partially_qualified_set_amount_duplicate);
                $total_counts = $counts + $duplicate_counts;
                $counts = $total_counts;
                $total_counts_inc = $total_counts;
                $partially_qualified_set = array();
                foreach ($partially_qualified_sets as $amount_key => $quantity_key) {
                    $total_counts_inc++;
                    $partially_qualified_set[$amount_key . '-' . $total_counts_inc] = $quantity_key;
                }
                $partially_qualified_sets = array_merge($partially_qualified_set_amount_duplicate, $partially_qualified_set);
            }
            asort($partially_qualified_sets);

            $price_html = '';
            $calculate_product_price = array();
            $applied_quantity = $discounted_price_for_set = $not_applied = $total_applied = 0;
            $calculator = self::$calculator;
            for ($i = 1; $i <= $counts; $i++) {
                if (is_array($partially_qualified_sets) && !empty($partially_qualified_sets)) {
                    //get smallest discount quantity
                    $min_applied_quantity = min($partially_qualified_sets);
                    //calculate next smallest quantity
                    if (!empty($applied_quantity)) {
                        $last_applied = $min_applied_quantity - $applied_quantity;
                    } else {
                        $last_applied = $min_applied_quantity;
                    }
                    $applied_quantity = $min_applied_quantity;
                    //calculate total applied quantity
                    $total_applied += $last_applied;
                    //Discount price calculation for set
                    if ($i == 1) {
                        $discounted_price = $original_price - $total_discount;
                    } else {
                        foreach ($partially_qualified_sets as $price => $quantity) {
                            if (!empty($partially_qualified_set_amount_duplicate)) {
                                $price_array = explode("-", $price);
                                $price = $price_array[0];
                            }
                            $discounted_price_for_set += $price;
                        }
                        $discounted_price = ($original_price - ($discounted_price_for_set + $other_discounts));
                    }
                    if ($discounted_price <= 0) {
                        $discounted_price = 0;
                    }
                    $original_price_with_tax_call = $discounted_price_with_tax_call = 0;
                    if(!empty($original_price)){
                        $original_price_with_tax_call = $calculator->mayHaveTax($product_obj, $original_price);
                    }
                    if(!empty($discounted_price)){
                        $discounted_price_with_tax_call = $calculator->mayHaveTax($product_obj, $discounted_price);
                    }
                    if (!empty($discounted_price)) {
                        $calculate_product_price[] = $discounted_price * $last_applied;
                    }
                    $price_suffix = Woocommerce::getProductPriceSuffix($product_obj, $discounted_price);
                    $price_html .= '<del>' . self::$woocommerce_helper->formatPrice($original_price_with_tax_call) . '</del>&nbsp;<ins>' . self::$woocommerce_helper->formatPrice($discounted_price_with_tax_call) .$price_suffix. '&nbsp;x&nbsp;' . $last_applied . '</ins><br/>';
                    //remove calculated set
                    $min_applied_range_keys = array_keys($partially_qualified_sets, $min_applied_quantity);
                    foreach ($min_applied_range_keys as $key) {
                        unset($partially_qualified_sets[$key]);
                    }
                }
            }
            $original_price_with_tax_call = $discounted_price_with_tax_call = 0;
            //get original price quantity
            if ($discount_operator === 'total_qty_in_cart') {
                $total_quantity = $current_product_quantity;
            }
            $not_applied = (int)$total_quantity - (int)$total_applied;

            //calculate original price quantities discount.

            if (!empty($other_discounts)) {
                $discounted_price = $original_price - $other_discounts;
                //$discounted_price = $calculator->mayHaveTax($product_obj, $discounted_price);
                if ($discounted_price < 0) {
                    $discounted_price = 0;
                }
                $calculate_product_price[] = $discounted_price * $not_applied;
                if(!empty($original_price)){
                    $original_price_with_tax_call = $calculator->mayHaveTax($product_obj, $original_price);
                }
                if(!empty($discounted_price)){
                    $discounted_price_with_tax_call = $calculator->mayHaveTax($product_obj, $discounted_price);
                }
                $price_suffix = Woocommerce::getProductPriceSuffix($product_obj, $discounted_price_with_tax_call);
                $price_html .= '<del>' . self::$woocommerce_helper->formatPrice($original_price_with_tax_call) . '</del>&nbsp;<ins>' . self::$woocommerce_helper->formatPrice($discounted_price_with_tax_call) .$price_suffix. '&nbsp;x&nbsp;' . $not_applied . '</ins>';
            } else {
                if(!empty($original_price)){
                    $original_price_with_tax_call = $calculator->mayHaveTax($product_obj, $original_price);
                }
                $price_suffix = Woocommerce::getProductPriceSuffix($product_obj, $original_price_with_tax_call);
                $calculate_product_price[] = $original_price * $not_applied;
                $price_html .= '<ins>' . self::$woocommerce_helper->formatPrice($original_price_with_tax_call) .$price_suffix. '&nbsp;x&nbsp;' . $not_applied . '</ins>';
            }
            if ($return_html) {
                return apply_filters('advanced_woo_discount_rules_strikeout_for_set_discount_price_html', $price_html, $original_price, $discounted_price, $total_discount, $other_discounts, $not_applied);
            } else {
                $total_product_price = array_sum($calculate_product_price);
                $single_product_price = $total_product_price / $total_quantity;
                return $single_product_price;
            }
        }
        return false;
    }

    /**
     * Apply cart discount fees
     * @param $cart
     */
    function applyCartDiscount($cart)
    {
        $discount_apply_type = self::$config->getConfig('apply_cart_discount_as', 'fee');
        $combine_all_discounts = self::$config->getConfig('combine_all_cart_discounts', 0);
        $total_combined_discounts = 0;
        $apply_as_cart_fee_details = DiscountCalculator::$price_discount_apply_as_cart_discount;
        $flat_in_subtotal = array();
        if(!empty($apply_as_cart_fee_details)){
            foreach ($apply_as_cart_fee_details as $rule_id => $product_id){
                $discount_value = 0;
                foreach ($product_id as $detail) {
                    if($detail['discount_type'] == 'wdr_cart_discount' && $detail['apply_type'] == 'flat_in_subtotal'){
                        if(!isset($flat_in_subtotal[$rule_id])){
                            $flat_in_subtotal[$rule_id]['value'] = $detail['discounted_price'];
                            $flat_in_subtotal[$rule_id]['label'] = $detail['discount_label'];
                        }
                    }else{
                        $discount_value += $detail['discounted_price'];
                        $label = (isset($detail['discount_label']) && !empty($detail['discount_label'])) ? $detail['discount_label'] : $detail['rule_name'];
                    }
                }
                if ($discount_value > 0) {
                    if (empty($combine_all_discounts)) {
                        $discount_value = -1 * $discount_value;
                        Woocommerce::addCartFee($cart, apply_filters('advanced_woo_discount_rules_additional_fee_label', $label, $cart), apply_filters('advanced_woo_discount_rules_additional_fee_value', $discount_value, $cart));
                    }else{
                        $total_combined_discounts += $discount_value;
                    }
                    self::$calculated_cart_discount['discount'][] = array('price' => $discount_value, 'label' => $label);
                }
            }
        }
        if (!empty($flat_in_subtotal)) {
            foreach ($flat_in_subtotal as $discount){
                if(empty($combine_all_discounts)){
                    $discount_value = -1 * $discount['value'];
                    $label = $discount['label'];
                    Woocommerce::addCartFee($cart, apply_filters('advanced_woo_discount_rules_additional_fee_label', $label, $cart), apply_filters('advanced_woo_discount_rules_additional_fee_value', $discount_value, $cart));
                }else{
                    $total_combined_discounts += $discount['value'];
                }
            }
        }

        //Combine all discounts and add as single discounts
        if (!empty($total_combined_discounts) && !empty($combine_all_discounts)) {
            $label = self::$config->getConfig('discount_label_for_combined_discounts', __('cart discount', WDR_TEXT_DOMAIN));
            if ($discount_apply_type == 'fee') {
                $total_combined_discounts = -1 * $total_combined_discounts;
                self::$woocommerce_helper->addCartFee($cart, apply_filters('advanced_woo_discount_rules_additional_fee_label', $label, $cart), apply_filters('advanced_woo_discount_rules_additional_fee_value', $total_combined_discounts, $cart));
            }
        }
        DiscountCalculator::$price_discount_apply_as_cart_discount = array();
    }

    /**
     * change the coupon label
     * @param $label
     * @param $coupon
     * @return mixed
     */
    function overwriteCouponLabel($label, $coupon)
    {
        $coupon_code = self::$woocommerce_helper->getCouponCode($coupon);
        if (!empty($coupon_code) && isset(self::$calculated_cart_discount['discount'][$coupon_code]['label'])) {
            return self::$calculated_cart_discount['discount'][$coupon_code]['label'];
        }
        return $label;
    }

    /**
     * Manage the virtual coupon provided for cart
     * @param $response
     * @param $coupon_code
     * @return array
     */
    function manageVirtualCoupon($response, $coupon_code)
    {
        if (isset(self::$calculated_cart_discount['discount'][$coupon_code])) {
            return array(
                'id' => 321123 . rand(2, 9),
                'amount' => self::$calculated_cart_discount['discount'][$coupon_code]['price'],
                'individual_use' => false,
                'product_ids' => array(),
                'exclude_product_ids' => array(),
                'usage_limit' => '',
                'usage_limit_per_user' => '',
                'limit_usage_to_x_items' => '',
                'usage_count' => '',
                'expiry_date' => '',
                'apply_before_tax' => 'yes',
                'free_shipping' => false,
                'product_categories' => array(),
                'exclude_product_categories' => array(),
                'exclude_sale_items' => false,
                'minimum_amount' => '',
                'maximum_amount' => '',
                'customer_email' => '',
                'discount_type' => (self::$calculated_cart_discount['discount'][$coupon_code]['type'] == 'flat') ? 'fixed_cart' : 'percent'
            );
        }
        return $response;
    }

    /**
     * Apply the custom coupon for create coupon condition
     * @param $response
     * @param $coupon_code
     * @return array
     */
    function checkCouponToApply($response, $coupon_code)
    {
        $rule_helper = new Rule();
        $available_coupons = $rule_helper->getAllDynamicCoupons();
        if (in_array($coupon_code, $available_coupons)) {
            $amount = 0;
            $coupon = array(
                'id' => time() . rand(2, 9),
                'amount' => $amount,
                'individual_use' => false,
                'product_ids' => array(),
                'exclude_product_ids' => array(),
                'usage_limit' => '',
                'usage_limit_per_user' => '',
                'limit_usage_to_x_items' => '',
                'usage_count' => '',
                'expiry_date' => '',
                'apply_before_tax' => 'yes',
                'free_shipping' => false,
                'product_categories' => array(),
                'exclude_product_categories' => array(),
                'exclude_sale_items' => false,
                'minimum_amount' => '',
                'maximum_amount' => '',
                'customer_email' => '',
                'discount_type' => 'percent'
            );
            return $coupon;
        }
        return $response;
    }

    /**
     * Has third party coupon
     *
     * @return boolean
     * */
    function isCartContainsAnyThirdPartyCoupon(){
        $has_third_party_coupon = false;
        $used_coupons = DiscountCalculator::getUsedCoupons();
        $applied_coupons = Woocommerce::getAppliedCoupons();
        if(!empty($applied_coupons) && is_array($applied_coupons) && !empty($used_coupons)){
            $used_coupons = array_map('\Wdr\App\Helpers\Woocommerce::formatStringToLower', $used_coupons);
            foreach ($applied_coupons as $applied_coupon){
                if(!in_array($applied_coupon, $used_coupons)){
                    $has_third_party_coupon = true;
                    break;
                }
            }
        }elseif(!empty($applied_coupons) && is_array($applied_coupons) && empty($used_coupons)){
            $has_third_party_coupon = true;
        }

        return $has_third_party_coupon;
    }

    /**
     * Remove third party coupon when rule applied
     *
     * @param $calculated_cart_item_discount array
     * @param $processed_rule boolean
     * */
    function removeThirdPartyCouponIfRequired($calculated_cart_item_discount, $processed_rule){
        if($processed_rule === true){
            add_action('woocommerce_after_calculate_totals', array($this, 'removeThirdPartyCoupon'), 20);
        }
    }

    /**
     * Remove third party coupon if exists
     * */
    function removeThirdPartyCoupon(){
        $disable_coupon_when_rule_applied = self::$config->getConfig('disable_coupon_when_rule_applied', 'run_both');//run_both, disable_coupon, disable_rules
        if($disable_coupon_when_rule_applied == 'disable_coupon'){
            $used_coupons = DiscountCalculator::getUsedCoupons();
            $applied_coupons = Woocommerce::getAppliedCoupons();

            if(!empty($applied_coupons) && is_array($applied_coupons)){
                if(!empty($used_coupons)){
                    $used_coupons = array_map('\Wdr\App\Helpers\Woocommerce::formatStringToLower', $used_coupons);
                }
                foreach ($applied_coupons as $applied_coupon){
                    if(empty($used_coupons) || !in_array($applied_coupon, $used_coupons)){
                        $this->removeAppliedCoupon($applied_coupon);
                    }
                }
            }
        }
    }

    /**
     * Remove applied message for the coupon we are going to remove
     * */
    function removeAppliedMessageOfThirdPartyCoupon($msg, $msg_code, $coupon){
        if(!empty($coupon)){
            $disable_coupon_when_rule_applied = self::$config->getConfig('disable_coupon_when_rule_applied', 'run_both');//run_both, disable_coupon, disable_rules
            if($disable_coupon_when_rule_applied == 'disable_coupon'){
                $used_coupons = DiscountCalculator::getUsedCoupons();
                $applied_coupons = Woocommerce::getAppliedCoupons();

                if(!empty($applied_coupons) && is_array($applied_coupons)){
                    if(!empty($used_coupons)){
                        $used_coupons = array_map('\Wdr\App\Helpers\Woocommerce::formatStringToLower', $used_coupons);
                    }
                    foreach ($applied_coupons as $applied_coupon){
                        if(empty($used_coupons) || !in_array($applied_coupon, $used_coupons)){
                            $msg = '';
                        }
                    }
                }
            }
        }
        return $msg;
    }

    /**
     * Remove applied coupon
     *
     * @param $coupon_code string
     * */
    function removeAppliedCoupon($coupon_code){
        $msg = sprintf(__('Sorry, it is not possible to apply coupon <b>"%s"</b> as you already have a discount applied in cart.', WDR_TEXT_DOMAIN), $coupon_code);

        $msg = apply_filters('advanced_woo_discount_rules_notice_on_remove_coupon_while_having_a_discount', $msg, $coupon_code);

        //Remove message: Coupon code applied successfully.
        $this->removeCouponAppliedMessage();
        Woocommerce::remove_coupon($coupon_code);
        Woocommerce::wc_add_notice( $msg, 'notice' );
    }

    /**
     * Remove message: Coupon code applied successfully.
     * */
    function removeCouponAppliedMessage(){
        $msg = __( 'Coupon code applied successfully.', 'woocommerce' );
        $msg = apply_filters('advanced_woo_discount_rules_remove_coupon_applied_message_text', $msg);
        Woocommerce::removeSpecificNoticeFromSession($msg);
    }

    /**
     * Do apply discounts
     *
     * @return boolean
     * */
    function doApplyDiscount($cart_object){
        $run_rule = true;
        $disable_coupon_when_rule_applied = self::$config->getConfig('disable_coupon_when_rule_applied', 'run_both');//run_both, disable_coupon, disable_rules
        if($disable_coupon_when_rule_applied == 'disable_rules'){
            $has_third_party_coupon = $this->isCartContainsAnyThirdPartyCoupon();
            if($has_third_party_coupon === true){
                $run_rule = false;
            }
        }

        return apply_filters('advanced_woo_discount_rules_run_discount_rules', $run_rule, $cart_object);
    }

    /**
     * Apply discount for the products in cart
     * @param $cart_object
     * @return boolean
     */
    function applyCartProductDiscount($cart_object)
    {
        remove_action('woocommerce_cart_calculate_fees', array($this, 'applyCartDiscount'));
        Helper::clearPromotionMessages();
        $do_apply_discount = $this->doApplyDiscount($cart_object);
        if($do_apply_discount){
            $this->calculateCartPageDiscounts();
            $processed_rule = false;
            if (!empty(self::$calculated_cart_item_discount)) {
                if (isset($cart_object->cart_contents) && !empty($cart_object->cart_contents)) {
                    foreach ($cart_object->cart_contents as $key => $cart_item) {
                        if (array_key_exists($key, self::$calculated_cart_item_discount)) {
                            $processed_rule = true;
                            $product_id = isset($cart_item['product_id']) ? $cart_item['product_id'] : 0;
                            if (empty($product_id)) {
                                return false;
                            }
                            if (isset($cart_item['variation_id']) && !empty($cart_item['variation_id'])) {
                                $product_id = $cart_item['variation_id'];
                            }
                            $product_obj = isset($cart_item['data']) ? $cart_item['data'] : $cart_item;
                            $item_quantity = isset($cart_item['quantity']) ? $cart_item['quantity'] : 0;
                            //product price
                            $initial_price = self::$calculated_cart_item_discount[$key]['initial_price'];
                            $discounted_price = self::$calculated_cart_item_discount[$key]['discounted_price'];
                            $calculator = self::$calculator;
                            $total_discounts = $calculator::$total_discounts;
                            //get discount details per product
                            $discount_details = (isset($total_discounts[$key])) ? $total_discounts[$key] : array();
                            $item_price = $this->getSetDiscountItemPriceHtml($discount_details, $initial_price, $discounted_price, $product_obj, $price_html = false, $item_quantity);
                            if ($item_price) {
                                $price = $item_price;
                                $saved_amount = (($initial_price-$item_price)*$item_quantity);
                                self::$calculated_cart_item_discount[$key]['saved_amount'] = $saved_amount;
                                self::$calculated_cart_item_discount[$key]['saved_amount_with_tax'] = $calculator->mayHaveTax($product_obj, $saved_amount);
                            } else {
                                $price = self::$calculated_cart_item_discount[$key]['discounted_price'];
                            }
                            $price = apply_filters('advanced_woo_discount_rules_discounted_price_of_cart_item', $price, $cart_item, $cart_object, self::$calculated_cart_item_discount[$key]);
                            self::$woocommerce_helper->setCartProductPrice($product_obj, $price);

                        }
                    }
                }
            }

            // Disable third party coupon when rule applied
            $this->removeThirdPartyCouponIfRequired(self::$calculated_cart_item_discount, $processed_rule);

            do_action('advanced_woo_discount_rules_after_apply_discount', $cart_object, self::$calculated_cart_item_discount);
        }
        add_action('woocommerce_cart_calculate_fees', array($this, 'applyCartDiscount'));
    }

    /**
     * Calculate cart discounts
     * @return bool
     */
    function calculateCartPageDiscounts()
    {
        $cart_items = self::$woocommerce_helper->getCart();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_key => $cart_item) {
                $product_id = self::$woocommerce_helper->getProductId(isset($cart_item['data']) ? $cart_item['data'] : $cart_item);
                $product = self::$woocommerce_helper->getProductFromCartItem($cart_item, $product_id);
                $quantity = $cart_item['quantity'];
                $calculate_discount_for_item = apply_filters('advanced_woo_discount_rules_calculate_discount_for_cart_item', true, $cart_item);
                if($calculate_discount_for_item){
                    $prices = self::calculateInitialAndDiscountedPrice($product, $quantity, true, false, $cart_item);
                    if ($prices) {
                        //add the cart quantity
                        //Here discounts are calculated for per item
                        $prices['cart_quantity'] = $quantity;
                        $prices['product_id'] = $product_id;
                        $apply_discount = $this->didAppliedDiscountAlready($cart_key, $prices);
                        if ($apply_discount) {
                            self::$calculated_cart_item_discount[$cart_key] = apply_filters('advanced_woo_discount_rules_cart_item_discount_prices', $prices, $cart_item, $product);
                        }
                    }
                }

            }
        }
        return true;
    }

    /**
     * Did applied discount already
     *
     * @param $cart_key string
     * @param $prices array
     * @return boolean
     * */
    public function didAppliedDiscountAlready($cart_key, $prices)
    {
        $apply_discount = true;
        if (isset(self::$calculated_cart_item_discount[$cart_key])) {
            if (isset(self::$calculated_cart_item_discount[$cart_key]['discounted_price'])) {
                if (self::$calculated_cart_item_discount[$cart_key]['discounted_price'] > $prices['discounted_price']) {
                    $apply_discount = false;
                }
            }
        }
        return apply_filters('advanced_woo_discount_rules_did_discount_applied_already', $apply_discount, self::$calculated_cart_item_discount, $cart_key, $prices);
    }

    /**
     * Show the bulk table discount message
     */
    function showBulkTableInPosition()
    {
        global $product;
        if (!empty($product)) {
            $bulk_discounts_ranges = self::$calculator->getDefaultLayoutMessagesByRules($product);
            $override_path = get_theme_file_path('advanced_woo_discount_rules/discount_table.php');
            $bulk_table_template_path = WDR_PLUGIN_PATH . 'App/Views/Templates/discount_table.php';
            if (file_exists($override_path)) {
                $bulk_table_template_path = $override_path;
            }
            self::$template_helper->setPath($bulk_table_template_path)->setData(array('ranges' => $bulk_discounts_ranges, 'woocommerce' => self::$woocommerce_helper, 'base' => $this))->display();
        }
    }

    /**
     * Show the advanced table discount message
     */
    function showAdvancedTableInPosition()
    {
        global $product;
        if (!empty($product)) {
            $bulk_discounts_ranges = self::$calculator->getAdvancedLayoutMessagesByRules($product);
            $bulk_table_template_path = WDR_PLUGIN_PATH . 'App/Views/Templates/discount_table.php';
            self::$template_helper->setPath($bulk_table_template_path)->setData(array('ranges' => $bulk_discounts_ranges, 'woocommerce' => self::$woocommerce_helper))->display();
        }
    }

    /**
     * save discounts of order for future
     *
     * @param $order_id
     * @param $items
     * @return bool
     */
    function orderItemsSaved($order_id, $items)
    {
        $model = new DBTable();
        $applied_rules = array();
        if (!empty(self::$calculated_cart_item_discount)) {
            foreach (self::$calculated_cart_item_discount as $discount) {
                $product_id = isset($discount['product_id']) ? $discount['product_id'] : 0;
                if (empty($product_id)) {
                    return false;
                }
                $initial_price = floatval(isset($discount['initial_price_with_tax']) ? $discount['initial_price_with_tax'] : 0);
                $discounted_price = floatval(isset($discount['discounted_price_with_tax']) ? $discount['discounted_price_with_tax'] : 0);
                $cart_quantity = floatval(isset($discount['cart_quantity']) ? $discount['cart_quantity'] : 0);
                $total_discount_details = isset($discount['total_discount_details']) ? $discount['total_discount_details'] : array();
                $cart_discount_details = isset($discount['cart_discount_details']) ? $discount['cart_discount_details'] : array();
                if (!empty($total_discount_details)) {
                    $save_order_item_discounts_array = isset($total_discount_details[$product_id])? $total_discount_details[$product_id]: array();
                } else {
                    $save_order_item_discounts_array = $cart_discount_details;
                }
                if (!empty($save_order_item_discounts_array)) {
                    foreach ($save_order_item_discounts_array as $key => $value) {
                        $rule_id = $key;
                        $applied_rules[] = $rule_id;
                        $cart_discount = isset($cart_discount_details[$rule_id]['cart_discount']) ? $cart_discount_details[$rule_id]['cart_discount'] : '0';
                        $cart_shipping = (isset($cart_discount_details[$rule_id]['cart_shipping']) && !empty($cart_discount_details[$rule_id]['cart_shipping'])) ? $cart_discount_details[$rule_id]['cart_shipping'] : 'no';
                        $cart_discount_label = isset($cart_discount_details[$rule_id]['cart_discount_label']) ? $cart_discount_details[$rule_id]['cart_discount_label'] : '';
                        $simple_discount = isset($value['simple_discount']) ? $value['simple_discount'] : 0;
                        $bulk_discount = isset($value['bulk_discount']) ? $value['bulk_discount'] : 0;
                        $set_discount = isset($value['set_discount']['discount_value']) ? $value['set_discount']['discount_value'] : 0;
                        $discount_price = $simple_discount + $bulk_discount + $set_discount;
                        if ($discount_price < 0) {
                            $discount_price = 0;
                        }
                        $model::saveOrderItemDiscounts($order_id, $product_id, $initial_price, $discounted_price, $discount_price, $cart_quantity, $rule_id, $simple_discount, $bulk_discount, $set_discount, $cart_discount, $cart_discount_label, $cart_shipping);
                    }
                    if (!empty($cart_discount_details)) {
                        foreach ($cart_discount_details as $key => $value) {
                            if (!in_array($key, $applied_rules)) {
                                $rule_id = $key;
                                $cart_discount = isset($cart_discount_details[$rule_id]['cart_discount']) ? $cart_discount_details[$rule_id]['cart_discount'] : '';
                                $cart_shipping = (isset($cart_discount_details[$rule_id]['cart_shipping']) && !empty($cart_discount_details[$rule_id]['cart_shipping'])) ? $cart_discount_details[$rule_id]['cart_shipping'] : 'no';
                                $cart_discount_label = isset($cart_discount_details[$rule_id]['cart_discount_label']) ? $cart_discount_details[$rule_id]['cart_discount_label'] : '';
                                $model::saveOrderItemDiscounts($order_id, 0, 0, $discount_price, 0, 0, $rule_id, $simple_discount, $bulk_discount, $set_discount, $cart_discount, $cart_discount_label, $cart_shipping);
                            }
                        }
                    }
                }
            }
        } else {
            $cart = self::$woocommerce_helper->getCart();
            $cart_discount_details = self::$calculator->getCartDiscountPrices($cart, true);
            $simple_discount = $bulk_discount = $set_discount = $discount_price = 0;
            foreach ($cart_discount_details as $key => $value) {
                $rule_id = $key;
                $cart_discount = isset($cart_discount_details[$rule_id]['cart_discount']) ? $cart_discount_details[$rule_id]['cart_discount'] : '';
                $cart_shipping = (isset($cart_discount_details[$rule_id]['cart_shipping']) && !empty($cart_discount_details[$rule_id]['cart_shipping'])) ? $cart_discount_details[$rule_id]['cart_shipping'] : 'no';
                $cart_discount_label = isset($cart_discount_details[$rule_id]['cart_discount_label']) ? $cart_discount_details[$rule_id]['cart_discount_label'] : '';
                $model::saveOrderItemDiscounts($order_id, 0, 0, $discount_price, 0, 0, $rule_id, $simple_discount, $bulk_discount, $set_discount, $cart_discount, $cart_discount_label, $cart_shipping);
            }
        }
        $calc = self::$calculator;
        $applied_rules = $calc::$applied_rules;
        if (!empty($applied_rules)) {
            foreach ($applied_rules as $rule) {
                $used_limits = intval($rule->getUsedLimits()) + 1;
                $model::updateRuleUsedCount($rule->getId(), $used_limits);
            }
        }
        if (!empty(self::$calculated_cart_discount)) {
            if (isset(self::$calculated_cart_discount["discount"]) && !empty(self::$calculated_cart_discount["discount"])) {
                $discount_details = json_encode(self::$calculated_cart_discount["discount"]);
                $free_shipping = 'no';
                self::$calculated_cart_discount["free_shipping"] = apply_filters('advanced_woo_discount_rules_isset_free_shipping','no');
                if (isset(self::$calculated_cart_discount["free_shipping"]) && self::$calculated_cart_discount["free_shipping"] == 'yes') {
                    $order = self::$woocommerce_helper->getOrder($order_id);
                    if (!empty($order)) {
                        if (self::$woocommerce_helper->orderHasShippingMethod($order, 'wdr_free_shipping')) {
                            $free_shipping = 'yes';
                        }
                    }
                }
                $model::saveOrderDiscounts($order_id, $free_shipping, $discount_details);
            }
        }
    }

    /**
     * Show the discount promotion message
     */
    function showAppliedRulesMessages()
    {
        $message = self::$config->getConfig('applied_rule_message', 'Discount <strong>"{{title}}"</strong> has been applied to your cart.');
        $calc = self::$calculator;
        $applied_rules = $calc::$applied_rules;
        if (!empty($applied_rules)) {
            foreach ($applied_rules as $rule) {
                $title = $rule->getTitle();
                $message_to_display = str_replace('{{title}}', $title, $message);
                $message_to_display = apply_filters('advanced_woo_discount_rules_message_to_display_when_rules_applied', $message_to_display, $rule);
                self::$woocommerce_helper->printNotice($message_to_display, 'success');
            }
        }
    }

    /**
     * Display promotional message in check out while processing order review
     * */
    public function displayPromotionMessagesInCheckout(){
        echo "<div id='awdr_checkout_promotion_messages_data'>";
        $this->showAppliedRulesMessages();
        echo "</div>";
        echo "<script>";
        echo "jQuery('#awdr_checkout_promotion_messages').html(jQuery('#awdr_checkout_promotion_messages_data').html());jQuery('#awdr_checkout_promotion_messages_data').remove()";
        echo "</script>";
    }

    /**
     * Load outer div for displaying promotional message in check out
     * */
    public function displayPromotionMessagesInCheckoutContainer(){
        echo "<div id='awdr_checkout_promotion_messages'>";
        echo "</div>";
    }

    /**
     * Show the modified price on cart
     * @param $item_price
     * @param $cart_item
     * @param $cart_item_key
     * @return mixed|void
     */
    function getCartProductPriceHtml($item_price, $cart_item, $cart_item_key)
    {
        $original_price_html = $item_price;
        if (isset(self::$calculated_cart_item_discount[$cart_item_key])) {
            $discounted_price = self::$calculated_cart_item_discount[$cart_item_key]['discounted_price'];
            //$discounted_price = self::$calculator->mayHaveTax($product_obj, $discounted_price);

            $show_strikeout_on_cart = self::$config->getConfig('show_strikeout_on_cart', 1);
            if (!empty($show_strikeout_on_cart)) {
                $product_obj = isset($cart_item['data']) ? $cart_item['data'] : $cart_item;
                $cart_item_qty = isset($cart_item['quantity']) ? $cart_item['quantity'] : 0;
                $product_id = self::$woocommerce_helper->getProductId($product_obj);
                //product price
                $initial_price = self::$calculated_cart_item_discount[$cart_item_key]['initial_price'];
               // $initial_price = self::$calculator->mayHaveTax($product_obj, $initial_price);
                $calculator = self::$calculator;
                $total_discounts = $calculator::$total_discounts;
                //get discount details per product
                $discount_details = (isset($total_discounts[$cart_item_key])) ? $total_discounts[$cart_item_key] : array();
                $price = $this->getSetDiscountItemPriceHtml($discount_details, $initial_price, $discounted_price, $product_obj, $price_html = true, $cart_item_qty);
                if ($price) {
                    $item_price = $price;
                } else {
                    $initial_price_with_tax_call = $discounted_price_with_tax_call = 0;
                    if(!empty($initial_price)){
                        $initial_price_with_tax_call = $calculator->mayHaveTax($product_obj, $initial_price);
                    }
                    if(!empty($discounted_price)){
                        $discounted_price_with_tax_call = $calculator->mayHaveTax($product_obj, $discounted_price);
                    }
                    $item_price = $this->getStrikeoutPrice($initial_price_with_tax_call, $discounted_price_with_tax_call);
                }
            } else {
                $item_price = self::$woocommerce_helper->formatPrice($discounted_price);
            }
        }
        return apply_filters('advanced_woo_discount_rules_cart_strikeout_price_html', $item_price, $original_price_html, $cart_item, $cart_item_key);
    }

    /**
     * Show the modified price on cart
     * @param $item_subtotal_price
     * @param $cart_item
     * @param $cart_item_key
     * @return string
     */
    function getCartProductSubtotalPriceHtml($item_subtotal_price, $cart_item, $cart_item_key)
    {
        if (isset(self::$calculated_cart_item_discount[$cart_item_key]) && !empty(self::$calculated_cart_item_discount[$cart_item_key])) {
            $discount = $this->getDiscountPerItem(self::$calculated_cart_item_discount[$cart_item_key]);
            if($discount > 0){
                $total_discount = self::$woocommerce_helper->formatPrice($discount);
                $subtotal_additional_text = '<br>' . $this->getYouSavedText($total_discount);
                $item_subtotal_price .= apply_filters('advanced_woo_discount_rules_line_item_subtotal_saved_text', $subtotal_additional_text, $total_discount, $discount);
            }
        }
        return $item_subtotal_price;
    }

    /**
     * get You saved text
     * @param $discount
     * @return string|null
     */
    function getYouSavedText($discount)
    {
        if (!empty($discount)) {
            $text = self::$config->getConfig('you_saved_text');
            $message = str_replace('{{total_discount}}', $discount, $text);
            return '<div class="awdr-you-saved-text" style="color: green">' . $message . '</div>';
        }
        return NULL;
    }

    /**
     * Get the discount per item
     * @param $discount_details
     * @return float|int
     */
    function getDiscountPerItem($discount_details)
    {
        if(isset($discount_details['saved_amount_with_tax'])){
            if ($discount_details['saved_amount_with_tax'] > 0) {
                return $discount_details['saved_amount_with_tax'];
            }
        }
        $discounted_price = isset($discount_details['discounted_price_with_tax']) ? $discount_details['discounted_price_with_tax'] : 0;
        $initial_price = isset($discount_details['initial_price_with_tax']) ? $discount_details['initial_price_with_tax'] : 0;
        $cart_quantity = isset($discount_details['cart_quantity']) ? $discount_details['cart_quantity'] : 0;
        $total_discount_per_quantity = $initial_price - $discounted_price;
        if ($discounted_price >= 0 && $total_discount_per_quantity > 0) {
            if (empty($total_discount_per_quantity)) {
                $total_discount_per_quantity = $initial_price;
            }
            $total_discount_per_quantity = $total_discount_per_quantity * $cart_quantity;
            return $total_discount_per_quantity;
        }
        return 0;
    }

    /**
     * Show the modified price on cart
     * @param $cart_total_price
     * @return string
     */
    function getCartTotalPriceHtml($cart_total_price)
    {
        if (!empty(self::$calculated_cart_item_discount)) {
            $total_discount = 0;
            foreach (self::$calculated_cart_item_discount as $discount_details) {
                if (!empty($discount_details)) {
                    $total_discount += $this->getDiscountPerItem($discount_details);
                }
            }
            if (empty($total_discount)) {
                return $cart_total_price;
            }
            $total_discount = self::$woocommerce_helper->formatPrice($total_discount);
            $cart_total_price .= '<br>' . $this->getYouSavedText($total_discount);
        }
        return $cart_total_price;
    }

    /**
     * Adding the discount per order item in item meta
     * @param $item
     * @param $cart_item_key
     * @param $values
     * @param $order
     */
    function onCreateWoocommerceOrderLineItem($item, $cart_item_key, $values, $order)
    {
        if (isset(self::$calculated_cart_item_discount[$cart_item_key])) {
            self::$woocommerce_helper->setOrderItemMeta($item, '_advanced_woo_discount_item_total_discount', self::$calculated_cart_item_discount[$cart_item_key]);
        }
    }

    /**
     * Calculate the product's initial and discount price
     * @param $product
     * @param $quantity
     * @param $is_cart
     * @param $ajax_price
     * @return array|bool
     */
    static function calculateInitialAndDiscountedPrice($product, $quantity, $is_cart = false, $ajax_price = false, $cart_item = array())
    {
        return self::$calculator->getProductPriceToDisplay($product, $quantity, $is_cart, $ajax_price, $cart_item);
    }

    /**
     * Re-calculate cart total
     * */
    public static function reCalculateCartTotal()
    {
        WC()->cart->calculate_totals();
    }

    /**
     * @param $discount_details
     * @param $initial_price
     * @param $discounted_price
     * @param $product_obj
     * @param $price_html
     * @param $cart_item_qty
     * @param $ajax_price
     * @return bool|string
     */
    function getSetDiscountItemPriceHtml($discount_details, $initial_price, $discounted_price, $product_obj, $price_html, $cart_item_qty=0, $ajax_price = false)
    {
        if (is_array($discount_details) && !empty($discount_details)) {
            $calculator = self::$calculator;
            $other_discounts = $total_discount_price = $total_quantity = $current_product_quantity = $discount_operator = 0;
            $partially_qualified_set = array();
            $partially_qualified_set_amount_duplicate = array();
            $apply_full_set = false;
            $int_increment = 0;
            foreach ($discount_details as $detail_key => $detail) {
                $bogo_cheapest_discount = $bogo_cheapest_quantity = 0;
                //BOGO cheapest discount
                $bogo_cheap_in_cart = isset($detail['buy_x_get_y_cheapest_in_cart_discount']) ? $detail['buy_x_get_y_cheapest_in_cart_discount'] : '';
                $bogo_cheap_in_products = isset($detail['buy_x_get_y_cheapest_from_products_discount']) ? $detail['buy_x_get_y_cheapest_from_products_discount'] : '';
                $bogo_cheap_in_category = isset($detail['buy_x_get_y_cheapest_from_categories_discount']) ? $detail['buy_x_get_y_cheapest_from_categories_discount'] : '';
                $bogo_auto_add = isset($detail['buy_x_get_y_discount']) ? $detail['buy_x_get_y_discount'] : '';
                $bogo_getx = isset($detail['buy_x_get_x_discount']) ? $detail['buy_x_get_x_discount'] : '';

                if(!empty($bogo_cheap_in_cart)){
                    $bogo_cheapest_discount = isset($bogo_cheap_in_cart['discount_price_per_quantity']) ? $bogo_cheap_in_cart['discount_price_per_quantity'] : 0;
                    $bogo_cheapest_quantity = isset($bogo_cheap_in_cart['discount_quantity']) ? $bogo_cheap_in_cart['discount_quantity'] : 0;
                }elseif(!empty($bogo_cheap_in_products)){
                    $bogo_cheapest_discount = isset($bogo_cheap_in_products['discount_price_per_quantity']) ? $bogo_cheap_in_products['discount_price_per_quantity'] : 0;
                    $bogo_cheapest_quantity = isset($bogo_cheap_in_products['discount_quantity']) ? $bogo_cheap_in_products['discount_quantity'] : 0;
                }elseif (!empty($bogo_cheap_in_category)){
                    $bogo_cheapest_discount = isset($bogo_cheap_in_category['discount_price_per_quantity']) ? $bogo_cheap_in_category['discount_price_per_quantity'] : 0;
                    $bogo_cheapest_quantity = isset($bogo_cheap_in_category['discount_quantity']) ? $bogo_cheap_in_category['discount_quantity'] : 0;
                }elseif(!empty($bogo_auto_add)){
                    $bogo_cheapest_discount = isset($bogo_auto_add['discount_price_per_quantity']) ? $bogo_auto_add['discount_price_per_quantity'] : 0;
                    $bogo_cheapest_quantity = isset($bogo_auto_add['discount_quantity']) ? $bogo_auto_add['discount_quantity'] : 0;
                }else{
                    $bogo_cheapest_discount = isset($bogo_getx['discount_price_per_quantity']) ? $bogo_getx['discount_price_per_quantity'] : 0;
                    $bogo_cheapest_quantity = isset($bogo_getx['discount_quantity']) ? $bogo_getx['discount_quantity'] : 0;
                }
                $bogo_partial_set = '';
                if(!empty($bogo_cheapest_quantity) && $bogo_cheapest_quantity < $cart_item_qty){
                    $bogo_partial_set = 'yes';
                }elseif($bogo_cheapest_quantity == $cart_item_qty){
                    $bogo_cheapest_full_matched_set = $bogo_cheapest_discount;
                }

                $int_increment++;
                //per product quantity for set discount
                $fully_qualified_set = $discounted_price_per_set = $bogo_cheapest_full_matched_set = 0;
                $total_quantity = $cart_item_qty;
                $current_product_quantity = $cart_item_qty;
                if(!empty($detail['set_discount'])){
                    $total_quantity = isset($detail['set_discount']['total_quantity']) ? $detail['set_discount']['total_quantity'] : 0;
                    $discount_operator = isset($detail['set_discount']['discount_operator']) ? $detail['set_discount']['discount_operator'] : "";
                    //original price quantity for set discount
                    $original_price_quantity = isset($detail['set_discount']['original_price_quantity']) ? $detail['set_discount']['original_price_quantity'] : 0;
                    //min set quantity
                    $discounted_price_quantity = isset($detail['set_discount']['discounted_price_quantity']) ? $detail['set_discount']['discounted_price_quantity'] : 0;
                    //set discounted price
                    $discounted_price_per_set = isset($detail['set_discount']['discount_value']) ? $detail['set_discount']['discount_value'] : 0;
                    $discounted_price_quantities = isset($detail['set_discount']['discounted_price_quantity']) ? $detail['set_discount']['discounted_price_quantity'] : 0;
                    if (!empty($total_quantity)) {
                        self::$set_total_quantity = $total_quantity;
                    }
                    if (empty($total_quantity)) {
                        $total_quantity = self::$set_total_quantity;
                    }
                }

                //simple discounted price
                $simple_discount = isset($detail['simple_discount']) ? $detail['simple_discount'] : 0;
                //bulk discounted price
                $bulk_discounts = isset($detail['bulk_discount']) ? $detail['bulk_discount'] : 0;

                //set discounted price quantity
                $total_discount_price += $discounted_price_per_set + $simple_discount + $bulk_discounts + $bogo_cheapest_discount;
                if (empty($original_price_quantity) && empty($discounted_price_quantity) && empty($bogo_partial_set)) {
                    if (!empty($discounted_price_per_set)) {
                        $fully_qualified_set = $discounted_price_per_set;
                    }
                } else {
                    if(!empty($detail['set_discount']) && !empty($discounted_price_per_set) && !empty($discounted_price_quantities)){
                        if (isset($partially_qualified_set[$discounted_price_per_set]) && !empty($partially_qualified_set[$discounted_price_per_set])) {
                            $partially_qualified_set_amount_duplicate[$discounted_price_per_set . '-' . $int_increment] = $discounted_price_quantities;
                        } else {
                            $partially_qualified_set[$discounted_price_per_set] = $discounted_price_quantities;
                        }
                        $multi_strikeout['set_strickout'] = true;
                    }
                    if(!empty($bogo_partial_set)){
                        $int_increment++;
                        if (isset($partially_qualified_set[$bogo_cheapest_discount]) && !empty($partially_qualified_set[$bogo_cheapest_discount])) {
                            $partially_qualified_set_amount_duplicate[$bogo_cheapest_discount . '-' . $int_increment] = $bogo_cheapest_quantity;
                        } else {
                            $partially_qualified_set[$bogo_cheapest_discount] = $bogo_cheapest_quantity;
                        }
                        $multi_strikeout['bogo_strickout'] = true;
                    }

                }
                $other_discounts += $simple_discount + $bulk_discounts + $fully_qualified_set + $bogo_cheapest_full_matched_set;
            }
            $initial_price_with_tax_call = $discounted_price_with_tax_call = 0;
            if (empty($partially_qualified_set) || $apply_full_set == true) {
                if ($price_html) {
                    if($ajax_price){
                        $discounted_price = $initial_price - $discounted_price;
                        if($discounted_price < 0){
                            $discounted_price = 0;
                        }

                        if(!empty($initial_price)){
                            $initial_price_with_tax_call = $calculator->mayHaveTax($product_obj, $initial_price);
                        }
                        if(!empty($discounted_price)){
                            $discounted_price_with_tax_call = $calculator->mayHaveTax($product_obj, $discounted_price);
                        }
                        $item_price = $this->getStrikeoutPrice($initial_price_with_tax_call, $discounted_price_with_tax_call);
                        return $item_price.Woocommerce::getProductPriceSuffix($product_obj, $discounted_price_with_tax_call);
                    }
                    if(!empty($initial_price)){
                        $initial_price_with_tax_call = $calculator->mayHaveTax($product_obj, $initial_price);
                    }
                    if(!empty($discounted_price)){
                        $discounted_price_with_tax_call = $calculator->mayHaveTax($product_obj, $discounted_price);
                    }
                    $item_price = $this->getStrikeoutPrice($initial_price_with_tax_call, $discounted_price_with_tax_call);

                    return $item_price.Woocommerce::getProductPriceSuffix($product_obj, $discounted_price_with_tax_call);
                } else {
                    return false;
                }
            } else {
                $original_item_price_html = $this->getSetStrikeoutPrice($initial_price, $partially_qualified_set, $total_discount_price, $other_discounts, $total_quantity, $product_obj, $price_html, $current_product_quantity, $discount_operator, $partially_qualified_set_amount_duplicate, $multi_strikeout);
                return $original_item_price_html;
            }
        } else {
            return false;
        }
    }

    /**
     * Calculate discount for product or calculate discount from custom price
     * @param $price
     * @param $product
     * @param int $quantity
     * @param int $custom_price
     * @param string $get_only
     * @return bool
     */
    static function calculateProductDiscountPrice($price, $product, $quantity = 1, $custom_price = 0, $get_only = 'discounted_price', $manual_request = false)
    {
        if (!is_a($product, 'WC_Product')) {
            if (is_integer($product)) {
                $product = self::$woocommerce_helper->getProduct($product);
            } else {
                return false;
            }
        }
        if (!$product) {
            return false;
        }
        $discounts = self::$calculator->mayApplyPriceDiscount($product, $quantity, $custom_price, false, array(), true, $manual_request);
        if ($discounts) {
            switch ($get_only) {
                case 'all':
                    $product_id = self::$woocommerce_helper->getProductId($product);
                    if (isset($discounts['total_discount_details'][$product_id])) {
                        $discounts['total_discount_details'] = $discounts['total_discount_details'][$product_id];
                    }
                    if (isset($discounts['cart_discount_details'])) {
                        unset($discounts['cart_discount_details']);
                    }
                    $price = $discounts;
                    break;
                default:
                case 'discounted_price':
                    $price = isset($discounts['discounted_price']) ? $discounts['discounted_price'] : $price;
                    break;
            }
        }
        return $price;
    }

    /**
     * Change the default template for sale badge
     *
     * @param $located string
     * @param $template_name string
     * @param $args array
     * @param $template_path string
     * @param $default_path string
     * @return string
     * */
    public static function changeTemplateForSaleTag($located, $template_name, $args, $template_path, $default_path){
        if($template_name == 'single-product/sale-flash.php'){
            $located = Helper::getTemplatePath('sale-flash.php', WDR_PLUGIN_PATH . 'App/Views/Templates/single-product/sale-flash.php', 'single-product');
        } else if($template_name == 'loop/sale-flash.php'){
            $located = Helper::getTemplatePath('sale-flash.php', WDR_PLUGIN_PATH . 'App/Views/Templates/loop/sale-flash.php', 'loop');
        }

        return $located;
    }

    /**
     * Remove on sale flash except our hooks
     * */
    function removeOnSaleFlashEvent(){
        $allowed_hooks = array(
            //Filters
            "woocommerce_sale_flash"            => array( "Wdr\App\Controllers\ManageDiscount|replaceSaleTagText" ),
        );

        $this->removeOtherEvents($allowed_hooks);
    }

    /**
     * Suppress third party discount plugins from accessing the discount data
     */
    function suppressOtherDiscountPlugins()
    {
        $allowed_hooks = array(
            //Filters
            "woocommerce_get_price_html" => array("Wdr\App\Controllers\ManageDiscount|getPriceHtml", "Wdr\App\Controllers\ManageDiscount|getPriceHtmlSalePriceAdjustment"),
            "woocommerce_product_is_on_sale" => array("Wdr\App\Controllers\ManageDiscount|isProductInSale"),
            "woocommerce_product_get_sale_price" => array(),
            "woocommerce_product_get_regular_price" => array(),
            "woocommerce_variable_price_html" => array(),
            "woocommerce_cart_item_price" => array("Wdr\App\Controllers\ManageDiscount|getCartProductPriceHtml"),
            "woocommerce_cart_item_subtotal" => array("Wdr\App\Controllers\ManageDiscount|getCartProductSubtotalPriceHtml"),
            //Actions
            "woocommerce_checkout_order_processed" => array(),
            "woocommerce_before_calculate_totals" => array("Wdr\App\Controllers\ManageDiscount|applyCartProductDiscount"), //nothing allowed!
        );
        $allowed_hooks = apply_filters('advanced_woo_discount_rules_exclude_hooks_from_removing', $allowed_hooks);
        $this->removeOtherEvents($allowed_hooks);
    }

    /**
     * Remove methods from the event
     * Exclude from the list
     *
     * @param $allowed_hooks array
     * */
    function removeOtherEvents($allowed_hooks){
        global $wp_filter;
        foreach ($wp_filter as $hook_name => $hook_obj) {
            if (preg_match('#^woocommerce_#', $hook_name)) {
                if (isset($allowed_hooks[$hook_name])) {
                    $wp_filter[$hook_name] = $this->removeWrongCallbacks($hook_obj, $allowed_hooks[$hook_name]);
                }
            }
        }
    }

    /**
     * Remove the third party call backs
     * @param $hook_obj
     * @param $allowed_hooks
     * @return mixed
     */
    function removeWrongCallbacks($hook_obj, $allowed_hooks)
    {
        $new_callbacks = array();
        foreach ($hook_obj->callbacks as $priority => $callbacks) {
            $priority_callbacks = array();
            foreach ($callbacks as $idx => $callback_details) {
                if ($this->isCallbackMatch($callback_details, $allowed_hooks)) {
                    $priority_callbacks[$idx] = $callback_details;
                }
            }
            if ($priority_callbacks) {
                $new_callbacks[$priority] = $priority_callbacks;
            }
        }
        $hook_obj->callbacks = $new_callbacks;
        return $hook_obj;
    }

    /**
     * check the call back matched or not
     * @param $callback_details
     * @param $allowed_hooks
     * @return bool
     */
    function isCallbackMatch($callback_details, $allowed_hooks)
    {
        $result = false;
        foreach ($allowed_hooks as $callback_name) {
            list($class_name, $func_name) = explode("|", $callback_name);
            if(empty($callback_details['function'])){
                continue;
            }
            if (count($callback_details['function']) != 2) {
                continue;
            }
            if ($class_name == get_class($callback_details['function'][0]) AND $func_name == $callback_details['function'][1]) {
                $result = true;
                break;// done!
            }
        }
        return $result;
    }

    /**
     * Display you saved text in order pages
     * @param $total
     * @param $order
     * @return string
     */
    function displayTotalSavingsInOrderAfterOrderTotal($total, $order)
    {
        if (!is_object($order)) {
            if (!empty($order) && is_int($order)) {
                $order = self::$woocommerce_helper->getOrder($order);
            }
        }
        $items = $order->get_items();
        $total_discount = $this->getItemTotalDiscount($items);
        $save_text = NULL;
        if (!empty($total_discount)) {
            $total_discounted_price = self::$woocommerce_helper->formatPrice($total_discount, array('currency' => self::$woocommerce_helper->getOrderCurrency($order)));
            $subtotal_additional_text = $this->getYouSavedText($total_discounted_price);
            $save_text = apply_filters('advanced_woo_discount_rules_order_saved_text', $subtotal_additional_text, $total_discounted_price, $total_discount);
        }
        return $total . $save_text;
    }

    /**
     * Calculate items total discount
     * @param $items
     * @return float|int
     */
    function getItemTotalDiscount($items)
    {
        $total_discount = 0;
        if (!empty($items)) {
            foreach ($items as $key => $item) {
                $discount_details = $item->get_meta('_advanced_woo_discount_item_total_discount');
                if (!empty($discount_details)) {
                    $total_discount += $this->getDiscountPerItem($discount_details);
                }
            }
        }
        return $total_discount;
    }

    /**
     * order line item saved text
     * @param $subtotal
     * @param $item
     * @param $order
     * @return string
     */
    function orderSubTotalDiscountDetails($subtotal, $item, $order)
    {
        $discount_details = self::$woocommerce_helper->getOrderItemMeta($item, '_advanced_woo_discount_item_total_discount');
        if (!empty($discount_details)) {
            $total_discount = $this->getDiscountPerItem($discount_details);
            if (!empty($total_discount)) {
                $total_discounted_price = self::$woocommerce_helper->formatPrice($total_discount, array('currency' => self::$woocommerce_helper->getOrderCurrency($order)));
                $subtotal_additional_text = $this->getYouSavedText($total_discounted_price);
                $subtotal .= apply_filters('advanced_woo_discount_rules_order_saved_text', $subtotal_additional_text, $total_discounted_price, $total_discount);
            }
        }
        return $subtotal;
    }

    /**
     * Show order discount details
     * @param $item_id
     * @param $item
     * @param $order
     */
    public function orderItemMetaDiscountDetails($item_id, $item, $order)
    {
        $discount_details = self::$woocommerce_helper->getOrderItemMeta($item, '_advanced_woo_discount_item_total_discount');
        if (!empty($discount_details)) {
            $total_discount = $this->getDiscountPerItem($discount_details);
            if (!empty($total_discount)) {
                $total_discounted_price = self::$woocommerce_helper->formatPrice($total_discount, array('currency' => self::$woocommerce_helper->getOrderCurrency($order)));
                $subtotal_additional_text = $this->getYouSavedText($total_discounted_price);
                echo apply_filters('advanced_woo_discount_rules_order_saved_text', $subtotal_additional_text, $total_discounted_price, $total_discount);
            }
        }
    }

    /**
     * Hide Zero Coupon Value
     * @param $coupon_html
     * @param $coupon
     * @return mixed
     */
    public function hideZeroCouponValue($coupon_html, $coupon)
    {
        $hide_zero_value_coupon = apply_filters('advanced_woo_discount_rules_hide_zero_value_coupon', true, $coupon);
        if ($hide_zero_value_coupon) {
            $rule_helper = new Rule();
            $original_coupon_html = $coupon_html;
            $all_coupon_codes = $rule_helper->getCouponsFromDiscountRules();
            $coupon_code = self::$woocommerce_helper->getCouponCode($coupon);
            $virtual_coupon = (isset($all_coupon_codes['custom_coupons']) && !empty($all_coupon_codes['custom_coupons'])) ? $all_coupon_codes['custom_coupons'] : array();
            $woo_coupons = (isset($all_coupon_codes['woo_coupons'][0]) && !empty($all_coupon_codes['woo_coupons'][0])) ? $all_coupon_codes['woo_coupons'][0] : array();
            if (!empty($woo_coupons) && in_array($coupon_code, $woo_coupons)) {
                $zero_price_html = '-' . self::$woocommerce_helper->formatPrice(0);
                $coupon_html = str_replace($zero_price_html, '', $coupon_html);
            } else if (!empty($virtual_coupon) && in_array($coupon_code, $virtual_coupon)) {
                $zero_price_html = '-' . self::$woocommerce_helper->formatPrice(0);
                $coupon_html = str_replace($zero_price_html, '', $coupon_html);
            }
            $coupon_html = apply_filters('advanced_woo_discount_rules_hide_zero_value_coupon_html', $coupon_html, $original_coupon_html, $coupon);
        }
        return $coupon_html;
    }

    /**
     * Display promotional messages
     * */
    public function displayPromotionMessages(){
        $messages = Helper::getPromotionMessages();
        if(!empty($messages) && is_array($messages)){
            foreach ($messages as $message){
                wc_print_notice($message, "notice");
            }
        }
    }

    /**
     * Load outer div for displaying promotional message in check out
     * */
    public function displaySubTotalPromotionMessagesInCheckoutContainer(){
        echo "<div id='awdr_checkout_subtotal_promotion_messages'>";
        echo "</div>";
    }

    /**
     * Display promotional message in check out while processing order review
     * */
    public function  displaySubTotalPromotionMessagesInCheckout(){
        echo "<div id='awdr_checkout_subtotal_promotion_messages_data'>";
        $this->displayPromotionMessages();
        echo "</div>";
        echo "<script>";
        echo "jQuery('#awdr_checkout_subtotal_promotion_messages').html(jQuery('#awdr_checkout_subtotal_promotion_messages_data').html());jQuery('#awdr_checkout_subtotal_promotion_messages_data').remove()";
        echo "</script>";
    }
}