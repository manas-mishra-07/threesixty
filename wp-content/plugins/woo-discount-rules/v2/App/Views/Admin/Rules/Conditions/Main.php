<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="wdr-rule-menu">
    <h2><?php _e('Rules (Optional)', WDR_TEXT_DOMAIN); ?></h2>
    <div class="awdr-rules-content">
        <p><?php _e('Include additional conditions (if necessary) to apply discount for product filters.', WDR_TEXT_DOMAIN); ?></p>
    </div>
</div>
<div class="wdr-rule-options-con"><?php
    if ($conditions = $rule->getConditions()) {
        $condition_relationship = $rule->getRelationship('condition', 'and');
        $wdr_product_conditions = $base->getProductConditionsTypes();
        $awdr_discount_type = $rule->getRuleDiscountType();?>
        <!--Product Condition Start  promo_show_hide_-->
        <div class="wdr-condition-template">
        <div class="wdr-block">
            <div class="wdr-conditions-relationship">
                <label><b><?php _e('Conditions Relationship ', WDR_TEXT_DOMAIN); ?></b></label>&nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="additional[condition_relationship]"
                              value="and" <?php echo ($condition_relationship == 'and') ? 'checked' : '' ?>
                    ><?php _e('Match All', WDR_TEXT_DOMAIN); ?></label>
                <label><input type="radio" name="additional[condition_relationship]"
                              value="or" <?php echo ($condition_relationship == 'or') ? 'checked' : '' ?>><?php _e('Many Any', WDR_TEXT_DOMAIN); ?>
                </label>
            </div>
            <div class="wdr-condition-group-items">
                <div class="wdr-conditions-container wdr-condition-group" data-index="1"></div><?php
                $i = 2;
                $render_saved_condition = false;
                foreach ($conditions as $condition) {
                    $type = isset($condition->type) ? $condition->type : NULL;
                    if($awdr_discount_type != 'wdr_free_shipping' && $type == 'cart_item_product_onsale'){
                        continue;
                    }
                    if (!empty($type) && isset($rule->available_conditions[$type]['object'])) {
                        $template = $rule->available_conditions[$type]['template'];
                        $extra_params = isset($rule->available_conditions[$type]['extra_params']) ? $rule->available_conditions[$type]['extra_params'] : array();
                        if (file_exists($template)) {
                            $options = isset($condition->options) ? $condition->options : array(); ?>
                            <div class="wdr-grid wdr-conditions-container wdr-condition-group" data-index="<?php echo $i; ?>">
                                <div class="wdr-condition-type">
                                    <select name="conditions[<?php echo $i; ?>][type]"
                                            class="wdr-product-condition-type awdr-left-align"
                                            style="width: 100%"><?php
                                        if (isset($wdr_product_conditions) && !empty($wdr_product_conditions)) {
                                            foreach ($wdr_product_conditions as $wdr_condition_key => $wdr_condition_value) {
                                                ?>
                                                <optgroup
                                                label="<?php _e($wdr_condition_key, WDR_TEXT_DOMAIN); ?>"><?php
                                                foreach ($wdr_condition_value as $key => $value) {?>
                                                    <option class="<?php echo ($awdr_discount_type != 'wdr_free_shipping' && $key == 'cart_item_product_onsale') ? 'wdr-hide awdr-free-shipping-special-condition' : 'awdr-free-shipping-special-condition'; ?>"
                                                    <?php
                                                    if(isset($value['enable']) && $value['enable'] === false){
                                                        ?>
                                                        disabled="disabled"
                                                        <?php
                                                    } else {
                                                        ?>
                                                        value="<?php echo $key; ?>"
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php if ($key == $type) {
                                                        echo 'selected';
                                                    } ?>><?php _e($value['label'], WDR_TEXT_DOMAIN); ?></option><?php
                                                } ?>
                                                </optgroup><?php
                                            }
                                        } ?>
                                    </select>
                                    <span class="wdr_desc_text awdr-clear-both"><?php _e('Condition Type', WDR_TEXT_DOMAIN); ?></span>
                                </div><?php
                                extract($extra_params);
                                $render_saved_condition = true;
                                include $template;

                                ?>
                                <div class="wdr-btn-remove" style="float: left">
                                    <span class="dashicons dashicons-no-alt remove-current-row"></span>
                                </div>
                            </div><?php
                            $config = new \Wdr\App\Controllers\Configuration();
                            $subtotal_promo = $config->getConfig("show_subtotal_promotion", '');
                            if($type == 'cart_subtotal' && $subtotal_promo == 1){
                                $operator = isset($options->operator) ? $options->operator : 'less_than';?>
                                <div class="wdr-grid wdr-conditions-container wdr-condition-group <?php echo 'promo_show_hide_'.$i; ?>" data-index="<?php echo $i; ?>" style="<?php echo ($operator == 'greater_than_or_equal' || $operator == 'greater_than') ? '': 'display: none'; ?>">
                                    <?php include(WDR_PLUGIN_PATH . 'App/Views/Admin/Rules/Others/SubtotalPromotion.php'); ?>
                                </div>
                               <?php

                            }
                            $i++;
                        }
                    }
                } ?>
            </div>
            <div class="add-condition add-condition-and-filters">
                <button type="button"
                        class="button add-product-condition"><?php _e('Add condition', WDR_TEXT_DOMAIN); ?></button>
            </div>
        </div>
        </div><?php
    } else {?>
        <div class="wdr-condition-template">
            <div class="wdr-block">
                <div class="wdr-conditions-relationship">
                    <label><b><?php _e('Conditions Relationship', WDR_TEXT_DOMAIN); ?></b></label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="additional[condition_relationship]"
                                  value="and" checked><?php _e('Match All', WDR_TEXT_DOMAIN); ?></label>
                    <label><input type="radio" name="additional[condition_relationship]"
                                  value="or"><?php _e('Many Any', WDR_TEXT_DOMAIN); ?>
                    </label>
                </div>
                <div class="wdr-condition-group-items">
                    <div class="wdr-conditions-container wdr-condition-group" data-index="1"></div>
                </div>
                <div class="wdp-block add-condition">
                    <button type="button"
                            class="button add-product-condition"><?php _e('Add condition', WDR_TEXT_DOMAIN); ?></button>
                </div>
            </div>
        </div>
    <?php } ?>
    <!--Product Condition End-->
    <!--Rule Limit Start-->
    <div class="wdr-condition-template">
        <div class="wdr-block">
            <div class="wdr-conditions-relationship">
                <label><b><?php _e('Rule Limits', WDR_TEXT_DOMAIN); ?></b>
                    <span class="awdr-rule-limit-timestamp"><?php
                        if(!empty($current_time)) echo sprintf(esc_html__('Current date and time: %s', WDR_TEXT_DOMAIN), '<b>' . date('Y-m-d H:i', $current_time) . '</b>'); ?>
                    </span>
                </label>

            </div>
            <div class="awdr-general-settings-section">
                <div class="wdr-rule-setting">
                    <div class="wdr-apply-to" style="float:left;"><?php
                        $usage_limits = $rule->getUsageLimits();?>
                        <select class="wdr-title" name="usage_limits">
                            <option value="0" <?php echo ($usage_limits == 0) ? 'selected' : ''; ?>><?php _e('Unlimited', WDR_TEXT_DOMAIN); ?></option><?php
                            for ($limit = 1; $limit <= 20; $limit++) {
                                ?>
                                <option
                                value="<?php echo $limit; ?>" <?php echo ($usage_limits == $limit) ? 'selected' : ''; ?>><?php _e($limit, WDR_TEXT_DOMAIN); ?></option><?php
                            } ?>
                        </select><span
                                class="wdr_desc_text"><?php _e('Maximum usage limit', WDR_TEXT_DOMAIN); ?></span>
                    </div>
                    <div class="wdr-rule-date-valid">
                        <div class="wdr-dateandtime-value">
                            <input type="text"
                                   name="date_from"
                                   class="wdr-condition-date wdr-title"
                                   data-class="start_datetimeonly"
                                   placeholder="<?php _e('Rule Vaild From', WDR_TEXT_DOMAIN); ?>"
                                   data-field="date"
                                   autocomplete="off"
                                   id="rule_datetime_from"
                                   value="<?php echo $rule->getStartDate(false, 'Y-m-d H:i'); ?>">
                            <span class="wdr_desc_text"><?php _e('Vaild from', WDR_TEXT_DOMAIN); ?></span>
                        </div>
                        <div class="wdr-dateandtime-value">
                            <input type="text"
                                   name="date_to"
                                   class="wdr-condition-date wdr-title"
                                   data-class="end_datetimeonly"
                                   placeholder="<?php _e('Rule Valid To', WDR_TEXT_DOMAIN); ?>"
                                   data-field="date" autocomplete="off"
                                   id="rule_datetime_to"
                                   value="<?php echo $rule->getEndDate(false, 'Y-m-d H:i'); ?>">
                            <span class="wdr_desc_text"><?php _e('Vaild to', WDR_TEXT_DOMAIN); ?></span>
                        </div>
                    </div>
                    <?php
                    if (!empty($site_languages) && is_array($site_languages) && count($site_languages) > 1) {
                        ?>
                        <div class="wdr-language-value">
                            <select multiple
                                    class="edit-preloaded-values"
                                    data-list="site_languages"
                                    data-field="preloaded"
                                    data-placeholder="<?php _e('Select values', WDR_TEXT_DOMAIN) ?>"
                                    name="rule_language[]"><?php
                                $chosen_languages = $rule->getLanguages();
                                foreach ($site_languages as $language_key => $name) {
                                    if (in_array($language_key, $chosen_languages)) {
                                        ?>
                                        <option value="<?php echo $language_key; ?>"
                                                selected><?php echo $name; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <span class="wdr_desc_text"><?php _e('Language', WDR_TEXT_DOMAIN); ?></span>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <!--Rule Limit End-->
</div>