<?php

namespace WDRPro\App\Rules;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Woocommerce;

class BXGYAutoAdd
{
    public static $auto_add_products = array();
    public static $matched_products = array();

    public static $auto_added_cart_item_keys = array();

    public static $session_key_removed_cart_items = 'awdr_removed_cart_items_bxgy';

    public static $session_key_auto_added_cart_items = 'awdr_auto_added_bxgy';

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
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddDiscountProducts'), 100);
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'autoRemoveProducts'), 99);
        add_action('woocommerce_remove_cart_item', array(__CLASS__, 'updateRemovedProductInSession'), 10 ,2);
        add_action('woocommerce_after_cart_item_quantity_update', array(__CLASS__, 'updateAlteredProductInSession'), 10 , 4);
        add_filter('advanced_woo_discount_rules_cart_item_quantity', array(__CLASS__, 'getQuantityOfAutoAddedFreeProduct'), 100, 3);
    }

    /**
     * Get quantity of auto added free product
     *
     * @param $quantity int
     * @param $cart_item array
     * @param $rule object
     *
     * @return int
     * */
    public static function getQuantityOfAutoAddedFreeProduct($quantity, $cart_item, $rule){
        if(isset($cart_item['key'])){
            $key = $cart_item['key'];
            $awdr_auto_added_cart_items = Woocommerce::getSession(self::$session_key_auto_added_cart_items, array());
            if(isset($awdr_auto_added_cart_items[$key])){
                $rule_id = $rule->id;
                if($rule_id == $awdr_auto_added_cart_items[$key]['rule_id']){
                    if(isset($awdr_auto_added_cart_items[$key]['auto_added_quantity'])){
                        $quantity = $quantity - $awdr_auto_added_cart_items[$key]['auto_added_quantity'];
                        if($quantity < 0) $quantity = 0;
                        $quantity = apply_filters('advanced_woo_discount_rules_cart_item_quantity_of_bxgy_on_count_quantity', $quantity, $cart_item, $rule);
                    }
                }
            }
        }

        return $quantity;
    }

    /**
     * On update quantity in cart update the changes in session
     *
     * @param $cart_item_key string
     * @param $quantity integer
     * @param $old_quantity integer
     * @param $cart object
     * */
    public static function updateAlteredProductInSession($cart_item_key, $quantity, $old_quantity, $cart){
        self::updateRemovedProductInSession($cart_item_key, $cart, 0);
    }

    /**
     * Auto remove products
     * */
    public static function autoRemoveProducts(){
        $awdr_auto_added_cart_items = Woocommerce::getSession(self::$session_key_auto_added_cart_items, array());
        $cart = Woocommerce::getCart();
        foreach ($cart as $key => $item){
            if(isset($awdr_auto_added_cart_items[$key])){
                self::processUpdateOrRemoveCartItem($item, $key, $awdr_auto_added_cart_items[$key]);
            }
        }
    }

    /**
     * Remove events before update or remove cart item
     * */
    protected static function removeEventsBeforeUpdateOrRemoveCartItem(){
        remove_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddDiscountProducts'), 100);
        remove_action('woocommerce_remove_cart_item', array(__CLASS__, 'updateRemovedProductInSession'), 10);
        remove_action('woocommerce_after_cart_item_quantity_update', array(__CLASS__, 'updateAlteredProductInSession'), 10);
        remove_action('woocommerce_after_calculate_totals', array(__CLASS__, 'autoRemoveProducts'), 99);
    }

    /**
     * Add events after update or remove cart item
     * */
    protected static function addEventsAfterUpdateOrRemoveCartItem(){
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddDiscountProducts'), 100);
        add_action('woocommerce_remove_cart_item', array(__CLASS__, 'updateRemovedProductInSession'), 10 ,2);
        add_action('woocommerce_after_cart_item_quantity_update', array(__CLASS__, 'updateAlteredProductInSession'), 10 , 4);
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'autoRemoveProducts'), 99);
    }

    /**
     * Process update or remove cart item
     *
     * @param $cart_item array
     * @param $key string
     * @param $auto_added_count integer
     * */
    protected static function processUpdateOrRemoveCartItem($cart_item, $key, $auto_added_count){
        $product = $cart_item['data'];
        $product_id = Woocommerce::getProductId($product);
        if(self::doAutoAddForTheProduct($product_id)){
            self::removeEventsBeforeUpdateOrRemoveCartItem();
            $current_discount_qty = self::getCurrentDiscountQuantity($product_id);
            if($current_discount_qty > 0){
                Woocommerce::set_quantity($key, $current_discount_qty);
            } else {
                Woocommerce::remove_cart_item($key);
                self::updateRemovedCartItemInAddedSession($key);
            }
            self::addEventsAfterUpdateOrRemoveCartItem();
        }
    }

    /**
     * Get current discount quantity for a product
     *
     * @param $product_id int
     * @return int
     * */
    protected static function getCurrentDiscountQuantity($product_id){
        $quantity = 0;
        if(!empty(self::$matched_products)){
            foreach (self::$matched_products as $discount){
                if(isset($discount['product_ids']) && !empty($discount['product_ids'])){
                    if(in_array($product_id, $discount['product_ids'])){
                        if(isset($discount['discount_quantity'])){
                            if($quantity < $discount['discount_quantity']){
                                $quantity = $discount['discount_quantity'];
                            }
                        }
                    }
                }
            }
        }

        return $quantity;
    }

    /**
     * Update removed cart item in session
     *
     * @param $cart_item_key string
     * */
    protected static function updateRemovedCartItemInAddedSession($cart_item_key){
        $awdr_auto_added_cart_items = Woocommerce::getSession(self::$session_key_auto_added_cart_items, array());
        if(isset($awdr_auto_added_cart_items[$cart_item_key])){
            unset($awdr_auto_added_cart_items[$cart_item_key]);
            Woocommerce::setSession(self::$session_key_auto_added_cart_items, $awdr_auto_added_cart_items);
        }
    }

    /**
     * Update removed item in session
     *
     * @param $cart_item_key string
     * @param $cart object
     * */
    public static function updateRemovedProductInSession($cart_item_key, $cart, $is_removed_request = 1){
        $cart_contents = Woocommerce::getCart();
        $awdr_auto_added_cart_items = Woocommerce::getSession(self::$session_key_auto_added_cart_items, array());
        if(!empty($awdr_auto_added_cart_items)){
            $awdr_auto_added_cart_items = array_keys($awdr_auto_added_cart_items);
            if(in_array($cart_item_key, $awdr_auto_added_cart_items)){
                $product = $cart_contents[$cart_item_key]['data'];
                $product_id = Woocommerce::getProductId($product);
                $awdr_removed_cart_items = Woocommerce::getSession(self::$session_key_removed_cart_items, array());
                if(!empty($awdr_removed_cart_items)){
                    if(!in_array($product_id, $awdr_removed_cart_items)){
                        $awdr_removed_cart_items[] = $product_id;
                    }
                } else {
                    $awdr_removed_cart_items[] = $product_id;
                }
                Woocommerce::setSession(self::$session_key_removed_cart_items, $awdr_removed_cart_items);
            }

            if($is_removed_request){
                self::updateRemovedCartItemInAddedSession($cart_item_key);
            }
        }
    }

    /**
     * Do auto add for the product
     *
     * @param $product_id int
     * @return boolean
     * */
    protected static function doAutoAddForTheProduct($product_id){
        $disable_if_customer_removed = apply_filters('advanced_woo_discount_rules_disable_auto_add_after_update_cart_item_by_customer_for_bxgy_limited_discount', false, $product_id);
        if($disable_if_customer_removed){
            $removed_products = Woocommerce::getSession(self::$session_key_removed_cart_items, array());
            if(!empty($removed_products)){
                if(in_array($product_id, $removed_products)){
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Remove events before handle auto add an item to cart
     * */
    protected static function removeEventBeforeHandleAutoAdd(){
        remove_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddDiscountProducts'), 100);
        remove_action('woocommerce_after_cart_item_quantity_update', array(__CLASS__, 'updateAlteredProductInSession'), 10);
    }

    /**
     * Add events after handle auto add an item to cart
     * */
    protected static function addEventAfterHandleAutoAdd(){
        add_action('woocommerce_after_calculate_totals', array(__CLASS__, 'handleAutoAddDiscountProducts'), 100);
        add_action('woocommerce_after_cart_item_quantity_update', array(__CLASS__, 'updateAlteredProductInSession'), 10 , 4);
    }

    /**
     * Handle auto add discount products
     * */
    public static function handleAutoAddDiscountProducts(){
        self::removeEventBeforeHandleAutoAdd();
        $products_to_add = self::getProductsToAdd();
        foreach ($products_to_add as $product_id => $product_data ){
            $quantity = $product_data['quantity'];
            $do_auto_add = self::doAutoAddForTheProduct($product_id);
            if($do_auto_add){
                $cart = Woocommerce::getCart();
                $cart_item_key = null;
                $already_exists = false;
                $cart_item_quantity = 0;
                foreach ($cart as $key => $item) {
                    if(apply_filters('advanced_woo_discount_rules_process_cart_item_for_buy_x_get_y_limited_discounts', true, $item, array())){
                        $cart_item_product = $item['data'];
                        $cart_item_product_id = Woocommerce::getProductId($cart_item_product);
                        if($cart_item_product_id == $product_id){
                            $already_exists = true;
                            $cart_item_key = $item['key'];
                            $cart_item_quantity = $item['quantity'];
                            break;
                        }
                    }
                }
                $product = Woocommerce::getProduct($product_id);
                $product_parent_id = Woocommerce::getProductParentId($product);
                $variation_id = 0;
                if($product_parent_id){
                    $variation_id = $product_id;
                    $product_id = $product_parent_id;
                }
                if($already_exists === true){
                    Woocommerce::set_quantity($cart_item_key, $cart_item_quantity+$quantity);
                } else {
                    $cart_item_key = Woocommerce::add_to_cart($product_id, $quantity, $variation_id, array());
                }
                if($cart_item_key !== null){
                    self::updateCartItemAsAutoAdded($cart_item_key, $quantity, $already_exists, $product_data['rule_key'], $cart_item_quantity, $product_data['rule_id']);
                    if(!in_array($cart_item_key, self::$auto_added_cart_item_keys)){
                        self::$auto_added_cart_item_keys[] = $cart_item_key;
                    }
                }
            }
        }
        self::addEventAfterHandleAutoAdd();
    }

    /**
     * Update the cart item data
     * */
    protected static function updateCartItemAsAutoAdded($cart_item_key, $quantity, $already_exists, $rule_key, $cart_item_quantity, $rule_id){
        $cart = Woocommerce::getCart();
        if(isset($cart[$cart_item_key])){
            $awdr_auto_added_cart_items = Woocommerce::getSession(self::$session_key_auto_added_cart_items, array());
            $add = true;
            if(!empty($awdr_auto_added_cart_items)){
                if(isset($awdr_auto_added_cart_items[$cart_item_key])){
                    if($already_exists){
                        $add = false;
                    }
                }
            }
            if($add === true){
                $awdr_auto_added_cart_items[$cart_item_key]['added'] = $quantity;
            } else {
                $awdr_auto_added_cart_items[$cart_item_key]['updated'] = $quantity;
            }
            $awdr_auto_added_cart_items[$cart_item_key]['rule_key'] = $rule_key;
            $awdr_auto_added_cart_items[$cart_item_key]['rule_id'] = $rule_id;
            if(isset($awdr_auto_added_cart_items[$cart_item_key]['auto_added_quantity'])){
                $awdr_auto_added_cart_items[$cart_item_key]['auto_added_quantity'] += $quantity;
            } else {
                $awdr_auto_added_cart_items[$cart_item_key]['auto_added_quantity'] = $quantity;
            }

            $awdr_auto_added_cart_items[$cart_item_key]['existing_quantity'] = $cart_item_quantity;
            
            Woocommerce::setSession(self::$session_key_auto_added_cart_items, $awdr_auto_added_cart_items);

        }
    }

    /**
     * Get Products to add
     *
     * @return array
     * */
    protected static function getProductsToAdd(){
        $products_to_add = array();
        if(!empty(self::$auto_add_products)){
            foreach (self::$auto_add_products as $key => $auto_add_product){
                if(!empty($auto_add_product)){
                    foreach ($auto_add_product as $product_id => $product_data){
                        $qty = $product_data['quantity'];
                        if(isset($products_to_add[$product_id]['quantity'])){
                            if($products_to_add[$product_id]['quantity'] < $qty){
                                $products_to_add[$product_id]['quantity'] = $qty;
                                $products_to_add[$product_id]['rule_key'] = $key;
                                $products_to_add[$product_id]['rule_id'] = $key;
                            }
                        } else {
                            $products_to_add[$product_id]['quantity'] = $qty;
                            $products_to_add[$product_id]['rule_key'] = $key;
                            $products_to_add[$product_id]['rule_id'] = $key;
                        }
                    }
                }
            }
        }

        return $products_to_add;
    }
}

BXGYAutoAdd::init();