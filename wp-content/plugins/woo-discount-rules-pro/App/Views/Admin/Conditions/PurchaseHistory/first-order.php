<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$values = isset($options->value) ? $options->value : 1;
echo ($render_saved_condition == true) ? '' : '<div class="purchase_first_order">';
?>
<div class="wdr_user_first_order_group wdr-condition-type-options">
    <div class="wdr-first-order wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]" width="100%" class="awdr-left-align">
            <option value="1" <?php echo ($values == "1") ? "selected" : ""; ?>><?php _e('Yes', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="0" <?php echo ($values == "0") ? "selected" : ""; ?>><?php _e('No', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('is first order?', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
