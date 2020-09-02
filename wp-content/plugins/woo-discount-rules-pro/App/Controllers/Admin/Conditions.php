<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Template;
use Wdr\App\Helpers\Woocommerce;

class Conditions
{
    public static function init(){
        self::hooks();
    }

    /**
     * Hooks
     * */
    protected static function hooks(){
        add_action( 'advanced_woo_discount_rules_loaded', function() {
           add_filter('advanced_woo_discount_rules_conditions', array(__CLASS__, 'addConditional'));
        });
        add_filter('advanced_woo_discount_rules_conditions', array(__CLASS__, 'addConditional'));
    }

    /**
     * Add rule conditions
     *
     * @param $available_conditions array
     * @return array
     * */
    public static function addConditional($available_conditions){
        //Read the conditions directory and create condition object
        if (file_exists(WDR_PRO_PLUGIN_PATH . 'App/Conditions/')) {
            $conditions_list = array_slice(scandir(WDR_PRO_PLUGIN_PATH . 'App/Conditions/'), 2);
            if (!empty($conditions_list)) {
                $woocommerce_helper = new Woocommerce();
                foreach ($conditions_list as $condition) {
                    $class_name = basename($condition, '.php');
                    if (!in_array($class_name, array('Base'))) {
                        $condition_class_name = 'WDRPro\App\Conditions\\' . $class_name;
                        if (class_exists($condition_class_name)) {
                            $condition_object = new $condition_class_name();
                            if ($condition_object instanceof \Wdr\App\Conditions\Base) {
                                $rule_name = $condition_object->name();
                                if (!empty($rule_name)) {
                                    if ($rule_name == 'cart_item_products_taxonomy') {
                                        if (!empty($woocommerce_helper->getCustomProductTaxonomies())) {
                                            foreach ($woocommerce_helper->getCustomProductTaxonomies() as $taxonomy) {
                                                $available_conditions['wdr_cart_item_' . $taxonomy->name] = array(
                                                    'object' => $condition_object,
                                                    'label' => __($taxonomy->labels->menu_name, WDR_PRO_TEXT_DOMAIN),
                                                    'group' => __('Custom Taxonomy', WDR_PRO_TEXT_DOMAIN),
                                                    'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/product-taxonomy.php',
                                                    'extra_params' => array()
                                                );
                                            }
                                        }else{
                                            $available_conditions['cart_item_products_taxonomy'] = array(
                                                'object' => $condition_object,
                                                'label' => '',
                                                'group' => '',
                                                'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Products/product-taxonomy.php',
                                                'extra_params' => array()
                                            );
                                        }
                                    } else {
                                        $available_conditions[$rule_name] = array(
                                            'object' => $condition_object,
                                            'label' => $condition_object->label,
                                            'group' => $condition_object->group,
                                            'template' => $condition_object->template,
                                            'extra_params' => $condition_object->extra_params,
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $available_conditions;
    }

    /**
     * load filter fields
     *
     * @param $rule object
     * @param $filter object
     * */
    public static function loadFilterFields($rule, $filter){
        $template = new Template();
        $data['rule'] = $rule;
        $data['filter'] = isset($filter)? $filter: null;
        $data['woocommerce_helper'] = new Woocommerce();
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/common_edit.php');
        $template->setData($data);
        $template->display();
    }
}

Conditions::init();