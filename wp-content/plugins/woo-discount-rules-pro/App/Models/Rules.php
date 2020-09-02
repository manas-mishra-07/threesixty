<?php
namespace WDRPro\App\Models;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Helpers\Rule;
use Wdr\App\Models\DBTable;

if (!defined('ABSPATH')) exit;

class Rules extends Rule
{
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
        $current_object = new self();
        //add_action('advanced_woo_discount_rules_after_save_rule', array($current_object, 'saveAdditionalRules'), 10, 3);
    }

    /**
     * Save additional rules
     */
    public function saveAdditionalRules($rule_id, $post, $arg)
    {
        $bxgy_cheapest_in_cart_adjustments = $this->getFromArray($post, 'bxgy_cheapest_in_cart_adjustments', array());
        $bxgy_cheapest_from_products_adjustments = $this->getFromArray($post, 'bxgy_cheapest_from_products_adjustments', array());
        $bxgy_cheapest_from_categories_adjustments = $this->getFromArray($post, 'bxgy_cheapest_from_categories_adjustments', array());
        $arg = array(
            'bxgy_cheapest_in_cart_adjustments' => json_encode($bxgy_cheapest_in_cart_adjustments),
            'bxgy_cheapest_from_products_adjustments' => json_encode($bxgy_cheapest_from_products_adjustments),
            'bxgy_cheapest_from_categories_adjustments' => json_encode($bxgy_cheapest_from_categories_adjustments),
        );
        $column_format = array('%s', '%s', '%s');
        $rule_id = DBTable::saveRule($column_format, $arg, $rule_id);
    }
}
Rules::init();