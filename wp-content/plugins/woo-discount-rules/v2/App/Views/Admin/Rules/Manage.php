<?php
    if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>
<div style="overflow:auto">
    <div class="awdr-container"><br/>
        <?php
        $current_time = '';
        if (function_exists('current_time')) {
            $current_time = current_time('timestamp');
        }
        $rule_status = $rule->getRuleVaildStatus();
        $rule_id = $rule->getId();
        if ($rule_status == 'in_future') { ?>
            <div class="notice inline notice notice-warning notice-alt">
            <p>
                <b><?php esc_html_e('This rule is not running currently: ', WDR_TEXT_DOMAIN); ?></b><?php esc_html_e(' Start date and time is set in the future date', WDR_TEXT_DOMAIN); ?>
            </p>
            </div><?php
        } elseif ($rule_status == 'expired') {
            ?>
            <div class="notice inline notice notice-warning notice-alt">
            <p>
                <b><?php esc_html_e('This rule is not running currently: ', WDR_TEXT_DOMAIN); ?></b><?php esc_html_e(' Validity expired', WDR_TEXT_DOMAIN); ?>
            </p>
            </div><?php
        }
        /*if(isset($on_sale_page_rebuild['available']) && $on_sale_page_rebuild['available']){
            $additional_class_for_rebuild = '';
            if($on_sale_page_rebuild['required_rebuild'] === true){
                $additional_class_for_rebuild = ' need_attention';
            }
            */?><!--
            <div class="awdr_rebuild_on_sale_rule_page_con<?php /*echo $additional_class_for_rebuild; */?>">
                <button type="button" class="btn btn-danger" id="awdr_rebuild_on_sale_list_on_rule_page"><?php /*esc_html_e('Rebuild index', WDR_TEXT_DOMAIN); */?></button>
            </div>
        --><?php
/*        }*/
        ?>

        <form id="wdr-save-rule" name="rule_generator">
            <div class="wdr-sticky-header" id="ruleHeader">
                <div class="wdr-enable-rule">
                    <div class="wdr-field-title" style="width: 45%">
                        <input class="wdr-title" type="text" name="title" placeholder="Rule Title"
                               value="<?php echo esc_attr($rule->getTitle()); ?>"><!--awdr-clear-both-->
                    </div>
                    <div class="page__toggle">
                        <label class="toggle">
                            <input class="toggle__input" type="checkbox"
                                   name="enabled" <?php echo ($rule->isEnabled()) ? 'checked' : '' ?> value="1">
                            <span class="toggle__label"><span
                                        class="toggle__text"><?php _e('Enable?', WDR_TEXT_DOMAIN); ?></span></span>
                        </label>

                    </div>
                    <div class="page__toggle">
                        <label class="toggle">
                            <input class="toggle__input" type="checkbox"
                                   name="exclusive" <?php echo ($rule->isExclusive()) ? 'checked' : '' ?> value="1">
                            <span class="toggle__label"><span
                                        class="toggle__text"><?php _e('Apply this rule if matched and ignore all other rules', WDR_TEXT_DOMAIN); ?></span></span>
                        </label>

                    </div>


                    <?php
                    if (isset($rule_id) && !empty($rule_id)) { ?>
                        <span class="wdr_desc_text awdr_valide_date_in_desc">
                        <?php esc_html_e('#Rule ID: ', WDR_TEXT_DOMAIN); ?><b><?php echo $rule_id; ?></b>
                        </span><?php
                    } ?>
                    <div class="awdr-common-save">
                        <button type="submit" class="btn btn-primary wdr_save_stay">
                            <?php _e('Save', WDR_TEXT_DOMAIN); ?></button>
                        <button type="button" class="btn btn-success wdr_save_close">
                            <?php _e('Save & Close', WDR_TEXT_DOMAIN); ?></button>
                        <a href="<?php echo admin_url("admin.php?" . http_build_query(array('page' => WDR_SLUG, 'tab' => 'rules'))); ?>"
                           class="btn btn-danger" style="text-decoration: none">
                            <?php _e('Cancel', WDR_TEXT_DOMAIN); ?></a>
                    </div>
                </div>
                <div class="awdr_discount_type_section">
                    <?php
                    $wdr_product_discount_types = $base->getDiscountTypes();
                    $rule_discount_type = $rule->getRuleDiscountType();
                    ?>
                    <div class="wdr-discount-type">
                        <b style="display: block;"><?php _e('Choose a discount type', WDR_TEXT_DOMAIN); ?></b>
                        <select name="discount_type" class="awdr-product-discount-type wdr-discount-type-selector"
                                data-placement="wdr-discount-template-placement">
                            <optgroup label="">
                                <option value="not_selected"><?php _e("Select Discount Type", WDR_TEXT_DOMAIN); ?></option>
                            </optgroup><?php
                            if (isset($wdr_product_discount_types) && !empty($wdr_product_discount_types)) {
                                foreach ($wdr_product_discount_types as $wdr_discount_key => $wdr_discount_value) {
                                    ?>
                                <optgroup label="<?php echo $wdr_discount_key; ?>">
                                    <?php
                                    foreach ($wdr_discount_value as $key => $value) {
                                        $enable_option = true;
                                        if (isset($value['enable']) && $value['enable'] === false) {
                                            $enable_option = false;
                                        }
                                        ?>
                                        <option
                                        <?php if ($enable_option) {
                                            ?>
                                            value="<?php echo $key; ?>"
                                            <?php
                                        } else {
                                            ?>
                                            disabled="disabled"
                                            <?php
                                        } ?>
                                        <?php echo ($rule_discount_type && $rule_discount_type == $key) ? 'selected' : ''; ?>><?php _e($value['label'], WDR_TEXT_DOMAIN); ?></option><?php
                                    } ?>
                                    </optgroup><?php
                                }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="awdr-hidden-new-rule" style="<?php echo (is_null($rule_id)) ? "display:none;" : "" ?>">

                <!-- ------------------------Rule Filter Section Start------------------------ -->
                <div class="wdr-rule-filters-and-options-con awdr-filter-section">
                    <div class="wdr-rule-menu">
                        <h2 class="awdr-filter-heading"><?php _e("Filter", WDR_TEXT_DOMAIN); ?></h2>
                       <div class="awdr-filter-content">
                           <p><?php _e("Choose which <b>gets</b> discount (products/categories/attributes/SKU and so on )", WDR_TEXT_DOMAIN); ?></p>
                           <p><?php _e("Note : You can also exclude products/categories.", WDR_TEXT_DOMAIN); ?></p>
                       </div>
                    </div>
                    <div class="wdr-rule-options-con">
                        <div id="wdr-save-rule" name="rule_generator">
                            <input type="hidden" name="action" value="wdr_ajax">
                            <input type="hidden" name="method" value="save_rule">
                            <input type="hidden" name="wdr_save_close" value="">
                            <div id="rule_template">
                                <?php include 'Filters/Main.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ------------------------Rule Filter Section End-------------------------- -->

                <!-- ------------------------Rule Discount Section Start---------------------- -->
                <?php
                //product adjustments
                $product_adjustments = ($rule->getProductAdjustments()) ? $rule->getProductAdjustments() : false;
                //echo "<pre>"; print_r($product_adjustments); echo "</pre>";
                //cart adjustments
                $cart_adjustment = $rule->getCartAdjustments();
                //Bulk adjustments
                if ($get_bulk_adjustments = $rule->getBulkAdjustments()) {
                    $bulk_adj_operator = (isset($get_bulk_adjustments->operator) && !empty($get_bulk_adjustments->operator)) ? $get_bulk_adjustments->operator : 'product_cumulative';
                    $bulk_adj_as_cart = (isset($get_bulk_adjustments->apply_as_cart_rule) && !empty($get_bulk_adjustments->apply_as_cart_rule)) ? $get_bulk_adjustments->apply_as_cart_rule : '';
                    $bulk_adj_as_cart_label = (isset($get_bulk_adjustments->cart_label) && !empty($get_bulk_adjustments->cart_label)) ? $get_bulk_adjustments->cart_label : '';
                    $bulk_adj_ranges = (isset($get_bulk_adjustments->ranges) && !empty($get_bulk_adjustments->ranges)) ? $get_bulk_adjustments->ranges : false;
                    $bulk_cat_selector = (isset($get_bulk_adjustments->selected_categories) && !empty($get_bulk_adjustments->selected_categories)) ? $get_bulk_adjustments->selected_categories : false;
                } else {
                    $bulk_adj_operator = 'product_cumulative';
                    $bulk_adj_as_cart = '';
                    $bulk_adj_as_cart_label = '';
                    $bulk_adj_ranges = false;
                    $bulk_cat_selector = false;
                }
                $show_bulk_discount = $rule->showHideDiscount($bulk_adj_ranges); ?>
                <div class="awdr-discount-container">
                    <div class="awdr-discount-row">
                        <div class="wdr-rule-filters-and-options-con">
                            <div class="wdr-rule-menu">
                                <h2 class="awdr-discount-heading"><?php _e("Discount", WDR_TEXT_DOMAIN); ?></h2>
                                <div class="awdr-discount-content">
                                    <p><?php _e("Select discount type and its value (percentage/price/fixed price)", WDR_TEXT_DOMAIN); ?></p>
                                </div>
                            </div>
                            <div class="wdr-rule-options-con">
                                <div class="wdr-discount-template">
                                    <div class="wdr-block wdr-discount-template-placement">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ------------------------Rule Discount Section End------------------------ -->

                <!-- ------------------------Rule Condition Section Start--------------------- -->
                <div class="awdr-condition-container">
                    <div class="awdr-condition-row">
                        <div class="wdr-rule-filters-and-options-con">
                            <?php include 'Conditions/Main.php'; ?>
                        </div>
                    </div>
                </div>
                <!-- ------------------------Rule Condition Section End----------------------- -->


                <!-- ------------------------Rule Discount Batch Section Start---------------- -->
                <?php
                if ($rule->hasAdvancedDiscountMessage()) {
                    $badge_display = $rule->getAdvancedDiscountMessage('display', 0);
                    $badge_bg_color = $rule->getAdvancedDiscountMessage('badge_color_picker', '#ffffff');
                    $badge_text_color = $rule->getAdvancedDiscountMessage('badge_text_color_picker', '#000000');
                    $badge_text = $rule->getAdvancedDiscountMessage('badge_text');
                } else {
                    $badge_display = false;
                    $badge_bg_color = '#ffffff';
                    $badge_text_color = '#000000';
                    $badge_text = false;
                }
                ?>
                <?php include 'DiscountBatch/Main.php'; ?>
                <!-- ------------------------Rule Discount Batch Section End------------------ -->

            </div>
        </form>
    </div>
</div>
<?php include 'Discounts/Main.php'; ?>
<div class="awdr-default-template" style="display: none;">
    <?php
    do_action('advanced_woo_discount_rules_admin_after_load_rule_fields', $rule);
    $discount_types = $base->discountElements();
    foreach ($discount_types as $type => $discount_type) {
        (isset($discount_type['template']) && !empty($discount_type['template'])) ? include $discount_type['template'] : '';
    }
    include "Others/CommonTemplates.php";?>
</div>


