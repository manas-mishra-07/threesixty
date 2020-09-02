<?php

namespace WDRPro\App\Controllers\Admin;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Template;
use Wdr\App\Helpers\Woocommerce;

class Filters
{
    public static function init(){
        self::hooks();
    }

    /**
     * Hooks
     * */
    protected static function hooks(){
        add_filter('advanced_woo_discount_rules_filters', array(__CLASS__, 'addFilters'));
        add_action('advanced_woo_discount_rules_admin_filter_fields', array(__CLASS__, 'loadFilterFields'), 10, 3);
    }

    /**
     * Add rule filters
     *
     * @param $filter_types array
     * @return array
     * */
    public static function addFilters($filter_types){
        $filter_types['product_category'] = array(
            'label' => __('Category', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Product', WDR_PRO_TEXT_DOMAIN),
            'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/category.php',
        );
        $filter_types['product_attributes'] = array(
            'label' => __('Attributes', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Product', WDR_PRO_TEXT_DOMAIN),
            'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/attributes.php',
        );
        $filter_types['product_tags'] = array(
            'label' => __('Tags', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Product', WDR_PRO_TEXT_DOMAIN),
            'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/tags.php',
        );
        $filter_types['product_sku'] = array(
            'label' => __('SKUs', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Product', WDR_PRO_TEXT_DOMAIN),
            'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/sku.php',
        );
        $filter_types['product_on_sale'] = array(
            'label' => __('On sale products', WDR_PRO_TEXT_DOMAIN),
            'group' => __('Product', WDR_PRO_TEXT_DOMAIN),
            'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/on-sale.php',
        );
        $woocommerce_helper = new Woocommerce();
        if (!empty($woocommerce_helper->getCustomProductTaxonomies())) {
            foreach ($woocommerce_helper->getCustomProductTaxonomies() as $taxonomy) {
                $filter_types[$taxonomy->name] = array(
                    'label' => __($taxonomy->labels->menu_name, WDR_PRO_TEXT_DOMAIN),
                    'group' => __('Custom Taxonomy', WDR_PRO_TEXT_DOMAIN),
                    'template' => WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/taxonomies.php',
                );
            }
        }

        return $filter_types;
    }

    /**
     * load filter fields
     * @param $rule
     * @param $filter
     * @param $filter_row_count
     * @return bool
     */
    public static function loadFilterFields($rule, $filter, $filter_row_count){
        if(isset($filter->type) && $filter->type == "products"){
            return false;
        }
        $template = new Template();
        $data['rule'] = $rule;
        $data['filter'] = isset($filter)? $filter: null;
        $data['woocommerce_helper'] = new Woocommerce();
        $data['filter_row_count'] = $filter_row_count;
        $template->setPath(WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Filters/common_edit.php');
        $template->setData($data);
        $template->display();
    }
}

Filters::init();