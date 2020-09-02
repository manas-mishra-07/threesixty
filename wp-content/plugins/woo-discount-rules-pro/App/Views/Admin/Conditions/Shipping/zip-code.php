<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
echo ($render_saved_condition == true) ? '' : '<div class="shipping_zipcode">';
$operator = isset($options->operator) ? $options->operator : 'in_list';
?>
<div class="wdr_shipping_zipcode_group wdr-condition-type-options">
    <div class="wdr-shipping-zipcode-method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('zipcode should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr-shipping-zipcode-value wdr-input-filed-hight">
        <input type="text" style="width: 245px;" name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]"
               placeholder="<?php _e('Enter Zipcode ', WDR_PRO_TEXT_DOMAIN);?>" class="awdr-left-align awdr-validation"
               value="<?php echo (isset($options->value)) ? $options->value : '' ?>">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Example: 94027, 90210', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>

