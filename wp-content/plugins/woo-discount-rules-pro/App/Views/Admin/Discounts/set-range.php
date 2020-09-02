<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wdr-discount-group" data-index="<?php echo $set_range; ?>">
    <div class="range_setter_inner">
        <div class="wdr-simple-discount-main set-discount-row-main">
            <div class="wdr-simple-discount-inner wdr-input-filed-hight set-discount-row-inner">
                <div class="dashicons dashicons-menu awdr-set-sort-icon"></div>
                <div class="set-min">
                    <input type="number"
                           name="set_adjustments[ranges][<?php echo $set_range; ?>][from]"
                           class="set_discount_min awdr-left-align"
                           value="<?php if (isset($range->from) && !empty($range->from)) {
                               echo $range->from;
                           } ?>"
                           placeholder="<?php _e('Quantity', WDR_PRO_TEXT_DOMAIN); ?>"
                           min="0"
                           step="any"
                    >
                    <span class="wdr_desc_text awdr-clear-both"><?php _e('Quantity ', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>

                <div class="set-for">
                    <p><?php _e('for ', WDR_PRO_TEXT_DOMAIN); ?></p>
                </div>
                <div class="set_amount">
                    <input type="number"
                           name="set_adjustments[ranges][<?php echo $set_range; ?>][value]"
                           class="set_discount_value bulk_value_selector awdr-left-align"
                           value="<?php if (isset($range->value) && !empty($range->value)) {
                               echo $range->value;
                           } ?>"
                           placeholder="<?php _e('Value', WDR_PRO_TEXT_DOMAIN); ?>"
                           min="0"
                            step="any"
                    >
                    <span class="wdr_desc_text awdr-clear-both"><?php _e('Discount Value ', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="bulk_gen_disc_type wdr-select-filed-hight">
                    <select name="set_adjustments[ranges][<?php echo $set_range; ?>][type]" class="set-discount-type bulk_discount_select awdr-left-align ">
                        <option value="fixed_set_price" <?php if (isset($range->type) && $range->type == "fixed_set_price") {
                            echo "selected";
                        } ?>><?php _e('Fixed price for set', WDR_PRO_TEXT_DOMAIN) ?></option>
                        <option value="percentage" <?php if (isset($range->type) && $range->type == "percentage") {
                            echo "selected";
                        } ?>><?php _e('Percentage discount per item', WDR_PRO_TEXT_DOMAIN) ?></option>
                        <option value="flat" <?php if (isset($range->type) && $range->type == "flat") {
                            echo "selected";
                        } ?>><?php _e('Fixed discount per item', WDR_PRO_TEXT_DOMAIN) ?></option>
                    </select>
                    <span class="wdr_desc_text awdr-clear-both"><?php _e('Discount Type', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>

                <div class="set_label">
                    <input type="text" name="set_adjustments[ranges][<?php echo $set_range; ?>][label]"
                           class="bulk_value_selector awdr-left-align"
                           placeholder="<?php _e('label', WDR_PRO_TEXT_DOMAIN); ?>" value="<?php if (isset($range->label) && !empty($range->label)) {
                        echo $range->label;
                    } ?>">
                    <span class="wdr_desc_text awdr-clear-both"><?php _e('Title column For Bulk Table', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="wdr-btn-remove set-remove-icon">
                                            <span class="dashicons dashicons-no-alt wdr_discount_remove"
                                                  data-rmdiv="bulk_range_group"></span>
                </div>
            </div>
        </div>
    </div>
</div>