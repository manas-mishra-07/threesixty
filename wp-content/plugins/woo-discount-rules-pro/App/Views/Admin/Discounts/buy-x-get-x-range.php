<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wdr-discount-group buyx_getx_individual_range" data-index="<?php echo $buyx_getx_index; ?>">
    <div class="range_setter_inner">
        <div class="wdr-buyx-getx-discount-main">
            <div class="wdr-buyx-getx-discount-inner wdr-input-filed-hight">
                <div class="dashicons dashicons-menu awdr-set-sort-icon" style="padding-top: 16px !important;"></div>
                <div class="awdr-buyx-getx-min">
                    <input type="number" name="buyx_getx_adjustments[ranges][<?php echo $buyx_getx_index; ?>][from]"
                           class="awdr-buyx-getx-number-box awdr_value_selector awdr_next_value bxgx-min"
                           placeholder="<?php _e('Min Quantity', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php echo (isset($buyx_getx_adjustment->from) && !empty($buyx_getx_adjustment->from)) ? $buyx_getx_adjustment->from : '1';?>"
                    >
                    <span class="wdr_desc_text"><?php echo (isset($buyx_getx_adjustment->recursive) && !empty($buyx_getx_adjustment->recursive)) ? __('Quantity', WDR_PRO_TEXT_DOMAIN) :  __('Minimum Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>

                <div class="awdr-buyx-getx-max" style="<?php echo (isset($buyx_getx_adjustment->recursive) && !empty($buyx_getx_adjustment->recursive)) ? 'display:none' : ''; ?>">
                    <input type="number" name="buyx_getx_adjustments[ranges][<?php echo $buyx_getx_index; ?>][to]"
                           class="awdr-buyx-getx-number-box awdr_value_selector awdr_auto_add_value bxgx-max"
                           placeholder="<?php _e('Max Quantity', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php
                           if(isset($buyx_getx_adjustment->to) && !empty($buyx_getx_adjustment->to)){
                               $buyx_getx_adjustment_to = $buyx_getx_adjustment->to;
                           }elseif(isset($buyx_getx_adjustment->from) && isset($buyx_getx_adjustment->to) && !empty($buyx_getx_adjustment->from) && empty($buyx_getx_adjustment->to)){
                               $buyx_getx_adjustment_to = '';
                           }else{
                               $buyx_getx_adjustment_to = 1;
                           }
                           echo $buyx_getx_adjustment_to; ?>"
                    >
                    <span class="wdr_desc_text"><?php _e('Maximum Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-buyx-getx-free-qty">
                    <input type="number"
                           name="buyx_getx_adjustments[ranges][<?php echo $buyx_getx_index; ?>][free_qty]"
                           class="awdr-buyx-getx-number-box awdr_value_selector bxgx-qty"
                           placeholder="<?php _e('Free Quantity', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php echo (isset($buyx_getx_adjustment->free_qty) && !empty($buyx_getx_adjustment->free_qty)) ? $buyx_getx_adjustment->free_qty : '1';?>"
                    >
                    <span class="wdr_desc_text"><?php _e('Free Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-buyx-getx-option wdr-select-filed-hight">
                    <select name="buyx_getx_adjustments[ranges][<?php echo $buyx_getx_index; ?>][free_type]"
                            class="awdr-bogo-discount-type buyx_getx_discount_select"
                            data-parent="awdr-buyx-getx-option"
                            data-siblings="awdr-getx-value">
                        <option value="free_product" <?php echo (isset($buyx_getx_adjustment->free_type) && $buyx_getx_adjustment->free_type == 'free_product') ? 'selected' : '';?>><?php _e('Free', WDR_PRO_TEXT_DOMAIN) ?></option>
                        <option value="percentage" <?php echo (isset($buyx_getx_adjustment->free_type) && $buyx_getx_adjustment->free_type == 'percentage') ? 'selected' : '';?>><?php _e('Percentage discount', WDR_PRO_TEXT_DOMAIN) ?></option>
                        <option value="flat" <?php echo (isset($buyx_getx_adjustment->free_type) && $buyx_getx_adjustment->free_type == 'flat') ? 'selected' : '';?>><?php _e('Fixed discount', WDR_PRO_TEXT_DOMAIN) ?></option>
                    </select>
                    <span class="wdr_desc_text"><?php _e('Discount type ', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-getx-value" style="<?php echo (isset($buyx_getx_adjustment->free_type) && $buyx_getx_adjustment->free_type != 'free_product') ? '' : 'display: none;';?>">
                    <input type="number" name="buyx_getx_adjustments[ranges][<?php echo $buyx_getx_index; ?>][free_value]"
                           class="awdr-buyx-getx-number-box awdr_value_selector bxgx-value"
                           placeholder="<?php _e('Value', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php echo (isset($buyx_getx_adjustment->free_value) && !empty($buyx_getx_adjustment->free_value)) ? $buyx_getx_adjustment->free_value : '1';?>"
                    >
                    <span class="wdr_desc_text"><?php echo (isset($buyx_getx_adjustment->free_type) && $buyx_getx_adjustment->free_type == 'flat') ? __('Discount value ', WDR_PRO_TEXT_DOMAIN) :  __('Discount percentage ', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-buyx-getx-recursive">
                    <div class="page__toggle">
                        <label class="toggle">
                            <input class="toggle__input awdr-bogo-recurcive" type="checkbox"
                                   name="buyx_getx_adjustments[ranges][<?php echo $buyx_getx_index; ?>][recursive]"
                                   data-recursive-row="buyx_getx_individual_range"
                                   data-recursive-parent="awdr-buyx-getx-recursive"
                                   data-hide-add-range="hide_getx_recursive"
                                   data-bogo-max-range="awdr-buyx-getx-max"
                                   data-bogo-min-range="awdr-buyx-getx-min"
                                   data-bogo-border="buyx_getx_individual_range"
                                   value="1" <?php echo (isset($buyx_getx_adjustment->recursive) && !empty($buyx_getx_adjustment->recursive)) ? 'checked' : ''; ?>>
                            <span class="toggle__label"><span
                                        class="toggle__text"><?php _e('Recursive?', WDR_PRO_TEXT_DOMAIN); ?></span></span>
                        </label>
                    </div>
                </div>
                <div class="wdr-btn-remove" style="vertical-align: middle;">
                    <span class="dashicons dashicons-no-alt wdr_discount_remove" data-rmdiv="bulk_range_group"></span>
                </div>
            </div>
        </div>
    </div>
</div>