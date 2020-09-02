<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
echo ($render_saved_condition == true) ? '' : '<div class="order_date">';
?>
<div class="wdr_date_group wdr-condition-type-options">
    <div class="wdr-date-from wdr-input-filed-hight">
        <input type="text"
               name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][from]"
               class="wdr-condition-date awdr-from-date awdr-left-align" placeholder="<?php _e('From date', WDR_PRO_TEXT_DOMAIN); ?>" data-field="date"
               value="<?php echo isset($options->from) ? $options->from : ''; ?>" data-class="start_dateonly"
               autocomplete="off">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('select date from', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-date-to wdr-input-filed-hight">
        <input type="text"
               name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][to]"
               value="<?php echo isset($options->to) ? $options->to : ''; ?>"
               class="wdr-condition-date awdr-end-date awdr-left-align" placeholder="<?php _e('To date', WDR_PRO_TEXT_DOMAIN); ?>"
               data-field="date" data-class="end_dateonly"
               autocomplete="off">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('select date to ', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>

