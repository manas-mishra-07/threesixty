<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

foreach (\Wdr\App\Helpers\Woocommerce::getCustomProductTaxonomies() as $taxonomy):
    $operator = isset($options->operator) ? $options->operator : 'in_list';
    $cartqty = isset($options->cartqty) ? $options->cartqty : 'less_than_or_equal';
    $values = isset($options->value) ? $options->value : false;
    echo ($render_saved_condition == true) ? '' : '<div class="wdr_cart_item_' . $taxonomy->name . '">'; ?>

<div class="<?php echo 'custom_taxonomy_' . $taxonomy->name . '_group'; ?>  wdr-condition-type-options" id="condition_tax_group">
    <div class="wdr-product_filter_method wdr-select-filed-hight ">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Taxonomy should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr-product-tax-selector wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="<?php echo ($render_saved_condition == true) ? 'edit-filters' : '' ?>"
                data-list="product_taxonomies"
                data-taxonomy="<?php echo $taxonomy->name; ?>"
                data-field="autocomplete"
                data-placeholder="<?php _e('Search Taxonomies', WDR_PRO_TEXT_DOMAIN); ?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                $custome_taxonomy_name = str_replace("wdr_cart_item_", "", $type);
                foreach ($values as $value) {
                    $term_name = get_term_by('id', $value, $custome_taxonomy_name);
                    if (!empty($term_name)) {
                        $parant_name = '';
                        if(isset($term_name->parent) && !empty($term_name->parent)){
                            if (function_exists('get_the_category_by_ID')) {
                                $parant_names = get_the_category_by_ID((int)$term_name->parent);
                                $parant_name = $parant_names . ' -> ';
                            }
                        }
                        $item_name = $parant_name.$term_name->name; ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $item_name; ?></option><?php
                    }
                }
            } ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select Taxonomies', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product-tax wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][cartqty]" class="awdr-left-align">
            <option value="less_than_or_equal" <?php echo ($cartqty == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="less_than" <?php echo ($cartqty == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="greater_than_or_equal" <?php echo ($cartqty == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="greater_than" <?php echo ($cartqty == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Categories Quantity In Cart', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product_filter_qty wdr-input-filed-hight">
        <input type="number" placeholder="<?php _e('qty', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
               name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][qty]"
               class="awdr-left-align"
               value="<?php echo isset($options->qty) ? $options->qty : '1'; ?>">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Category Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    </div><?php
    echo ($render_saved_condition == true) ? '' : '</div>';
endforeach; ?>
