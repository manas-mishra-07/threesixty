<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$type = isset($options->type) ? $options->type : 'combine';
$operator = isset($options->operator) ? $options->operator : 'less_than';
$values = isset($options->product) ? $options->product   : false;
echo ($render_saved_condition == true) ? '' : '<div class="cart_item_product_combination">';
?>
<div class="product_combination_group wdr-condition-type-options">
    <div class="wdr-product-filter_qty wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][type]" class="awdr-left-align">
            <option value="combine" <?php echo ($type == "combine") ? "selected" : ""; ?>><?php _e('Combine', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="any" <?php echo ($type == "any") ? "selected" : ""; ?>><?php _e('Any', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="each" <?php echo ($type == "each") ? "selected" : ""; ?>><?php _e('Each', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Combination type', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product_filter_method wdr-select-filed-hight wdr-search-box">
        <select multiple="" name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][product][]"
                class="awdr-product-validation <?php echo ($render_saved_condition == true) ? 'edit-filters' : '' ?>"
                data-placeholder="<?php _e('Search product', WDR_PRO_TEXT_DOMAIN);?>"
                data-list="products"
                data-field="autocomplete"
                style="width: 100%; max-width: 400px;  min-width: 180px;">
            <?php
            if ($values) {
                $item_name = '';
                foreach ($values as $value) {
                    $item_name = '#'.$value.' '.get_the_title($value);
                    if ($item_name != '') { ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $item_name; ?></option><?php
                    }
                }
            } ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select product', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-product-attributes-selector wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="combination_operator awdr-left-align">
            <option value="less_than" <?php echo ($operator == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="less_than_or_equal" <?php echo ($operator == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="greater_than_or_equal" <?php echo ($operator == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="greater_than" <?php echo ($operator == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="equal_to" <?php echo ($operator == "equal_to") ? "selected" : ""; ?>><?php _e('Equal to ( = )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="not_equal_to" <?php echo ($operator == "not_equal_to") ? "selected" : ""; ?>><?php _e('Not equal to ( != )', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="in_range" <?php echo ($operator == "in_range") ? "selected" : ""; ?>><?php _e('In range', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Comparison should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="product_combination_from wdr-input-filed-hight">
        <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][from]"
               type="number" class="awdr-left-align product_combination_from_placeholder product_from_qty"
               value="<?php if(isset($options->from) && !empty($options->from)){ echo $options->from;}?>"
               placeholder="<?php _e('Quantity', WDR_PRO_TEXT_DOMAIN);?>" min="0" step="any">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="product_combination_to wdr-input-filed-hight" style="<?php echo ($operator != "in_range") ? 'display: none;' : '';?>">
        <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][to]"
               type="number" class="awdr-left-align product_to_qty"
               value="<?php if(isset($options->to) && !empty($options->to)){ echo $options->to;}?>"
               placeholder="<?php _e('To', WDR_PRO_TEXT_DOMAIN);?>" min="0" step="any">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
