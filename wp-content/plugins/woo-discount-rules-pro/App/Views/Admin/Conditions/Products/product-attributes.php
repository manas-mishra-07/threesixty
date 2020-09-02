<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$operator = isset($options->operator) ? $options->operator : 'in_list';
$cartqty = isset($options->cartqty) ? $options->cartqty : 'less_than_or_equal';
$values = isset($options->value) ? $options->value : false;
echo ($render_saved_condition == true) ? '' : '<div class="cart_item_product_attributes">';
?>
<div class="product_attributes_group wdr-condition-type-options">
    <div class="wdr-product_filter_method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Attributes should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product-attributes-selector wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="awdr-attribute-validation <?php echo ($render_saved_condition == true) ? 'edit-filters' : '' ?>"
                data-list="product_attributes"
                data-field="autocomplete"
                data-placeholder="<?php _e('Search Attributes', WDR_PRO_TEXT_DOMAIN);?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                foreach ($values as $value) {
                    global $wc_product_attributes;
                    $item_name = '';
                    foreach (array_keys($wc_product_attributes) as $att_key) {
                        $att_object = get_term_by('id', $value, $att_key);
                        if (!empty($att_object) && is_object($att_object)) {
                            $item_name = $att_object->name;
                        }
                    }
                    if ($item_name != '') { ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $item_name; ?></option><?php
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select Attributes', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product-attributes wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][cartqty]" class="awdr-left-align">
            <option value="less_than_or_equal" <?php echo ($cartqty == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="less_than" <?php echo ($cartqty == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="greater_than_or_equal" <?php echo ($cartqty == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="greater_than" <?php echo ($cartqty == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Attributes Quantity in cart', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product_filter_qty wdr-input-filed-hight">
        <input type="number" placeholder="<?php _e('qty', WDR_PRO_TEXT_DOMAIN);?>" min="0" step="any"
               class="awdr-left-align awdr-num-validation"
               name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][qty]"
               value="<?php echo isset($options->qty) ? $options->qty : '1'; ?>">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Attributes Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
