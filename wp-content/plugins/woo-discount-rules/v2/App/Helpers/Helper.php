<?php

namespace Wdr\App\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Helper
{
    /**
     * Combine two array with unique values
     *
     * @param $products array
     * @param $additional_products array
     * @return array
     * */
    public static function combineProductArrays($products, $additional_products){
        $products = array_merge($products, $additional_products);
        $products = array_unique($products);

        return $products;
    }

    /**
     * Check has pro version
     *
     * @return boolean
     * */
    public static function hasPro(){
        if (defined('WDR_PRO'))
            if(WDR_PRO === true) return true;

        return false;
    }

    /**
     * Format price
     *
     * @param $data mixed
     * @return mixed
     * */
    public static function formatAllPrices($data){
        if(is_array($data)){
            if(isset($data['initial_price']) && !isset($data['initial_price_html'])){
                $data['initial_price_html'] = Woocommerce::formatPrice($data['initial_price']);
            }
            if(isset($data['discounted_price']) && !isset($data['discounted_price_html'])){
                $data['discounted_price_html'] = Woocommerce::formatPrice($data['discounted_price']);
            }
            if(isset($data['initial_price_with_tax']) && !isset($data['initial_price_with_tax_html'])){
                $data['initial_price_with_tax_html'] = Woocommerce::formatPrice($data['initial_price_with_tax']);
            }
            if(isset($data['discounted_price_with_tax']) && !isset($data['discounted_price_with_tax_html'])){
                $data['discounted_price_with_tax_html'] = Woocommerce::formatPrice($data['discounted_price_with_tax']);
            }
            if(!isset($data['currency_symbol'])){
                $data['currency_symbol'] = Woocommerce::get_currency_symbol();
            }
        }

        return $data;
    }

    /**
     * Get template override
     * @param string $template_name
     * @param string $folder
     * @return string
     * */
    public static function getTemplateOverride($template_name, $folder = ''){
        if(!empty($folder)){
            $path = trailingslashit('woo-discount-rules') .$folder."/".$template_name;
        } else {
            $path = trailingslashit( 'woo-discount-rules' ) . $template_name;
        }
        $template = locate_template(
            array(
                $path,
                $template_name,
            )
        );

        return $template;
    }

    /**
     * Get template path
     *
     * @param $template_name string
     * @param $default_path string
     * @param $folder string
     * @return string
     * */
    public static function getTemplatePath($template_name, $default_path, $folder = ''){
        $path_from_template = self::getTemplateOverride($template_name, $folder);
        if($path_from_template) $default_path = $path_from_template;

        return $default_path;
    }

    /**
     * Is Cart item is consider for discount calculation
     *
     * @param $status bool
     * @param $cart_item array
     * @param $type string
     * @return bool
     * */
    public static function isCartItemConsideredForCalculation($status, $cart_item, $type){
        return apply_filters('advanced_woo_discount_rules_include_cart_item_to_count_quantity', $status, $cart_item, $type);
    }

    /**
     * Set messages
     * */
    public static function setPromotionMessage($message, $rule_id = ''){
        $messages = Woocommerce::getSession('awdr_promotion_messages', array());
        if(!is_array($messages)) $messages = array();
        if(!empty($messages) && in_array($message, $messages)){
        } else {
            if(empty($rule_id)){
                $messages[] = $message;
            } else {
                $messages[$rule_id] = $message;
            }
        }

        Woocommerce::setSession('awdr_promotion_messages', $messages);
    }

    /**
     * Get promotion messages
     * */
    public static function getPromotionMessages(){
        return Woocommerce::getSession('awdr_promotion_messages', array());
    }

    /**
     * Clear promotion messages
     * */
    public static function clearPromotionMessages(){
        Woocommerce::setSession('awdr_promotion_messages', array());
    }
}