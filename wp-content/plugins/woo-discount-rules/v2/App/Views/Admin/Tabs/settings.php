    <?php
    if (!defined('ABSPATH')) {
        exit; // Exit if accessed directly
    }
    ?>
    <br>

    <div id="wpbody-content" class="awdr-container">
        <?php
        do_action('advanced_woo_discount_rules_on_settings_header');
        ?>
        <div class="awdr-configuration-form">
            <form name="configuration_form" id="configuration-form" method="post">

                <h1><?php _e('General', WDR_TEXT_DOMAIN) ?></h1>
                <table class="wdr-general-setting form-table">
                    <tbody style="background-color: #fff;">
                    <?php
                    do_action('advanced_woo_discount_rules_before_general_settings_fields', $configuration);
                    ?>
                    <tr>
                        <td scope="row">
                            <label for="calculate_discount_from" class="awdr-left-align"><?php _e('Calculate discount from', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('sale price or regular price', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <select name="calculate_discount_from">
                                <option value="sale_price" <?php echo ($configuration->getConfig('calculate_discount_from', 'sale_price') == 'sale_price') ? 'selected' : ''; ?>><?php _e('Sale price', WDR_TEXT_DOMAIN); ?></option>
                                <option value="regular_price" <?php echo ($configuration->getConfig('calculate_discount_from', 'sale_price') == 'regular_price') ? 'selected' : ''; ?> ><?php _e('Regular price', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="apply_product_discount_to" class="awdr-left-align"><?php _e('Apply discount', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Highest/Lowest/First/All matched rules', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <select name="apply_product_discount_to" class="apply_product_and_cart_discount_to" data-subsequent="apply_product_discount_subsequently_row">
                                <option value="biggest_discount" <?php echo ($configuration->getConfig('apply_product_discount_to', 'biggest_discount') == 'biggest_discount') ? 'selected' : ''; ?>><?php _e('Biggest one from matched rules', WDR_TEXT_DOMAIN); ?></option>
                                <option value="lowest_discount" <?php echo ($configuration->getConfig('apply_product_discount_to', 'biggest_discount') == 'lowest_discount') ? 'selected' : ''; ?>><?php _e('Lowest one from matched rules', WDR_TEXT_DOMAIN); ?></option>
                                <option value="first" <?php echo ($configuration->getConfig('apply_product_discount_to', 'biggest_discount') == 'first') ? 'selected' : ''; ?> ><?php _e('First matched rules', WDR_TEXT_DOMAIN); ?></option>
                                <option value="all" <?php echo ($configuration->getConfig('apply_product_discount_to', 'biggest_discount') == 'all') ? 'selected' : ''; ?>><?php _e('All matched rules', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr class="apply_product_discount_subsequently_row" style="<?php echo ($configuration->getConfig('apply_product_discount_to', 'biggest_discount') != 'all') ? 'display:none' : ''; ?>">
                        <td scope="row">
                            <label for="awdr_subsequent_discount" class="awdr-left-align"><?php _e('Apply discount subsequently', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('discounts applied subsequently', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="apply_discount_subsequently" id="do_apply_discount_subsequently"
                                   value="1" <?php echo($configuration->getConfig('apply_discount_subsequently', 0) ? 'checked' : '') ?>><label
                                    for="do_apply_discount_subsequently"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>
                            <input type="radio" name="apply_discount_subsequently"
                                   id="do_not_apply_discount_subsequently"
                                   value="0" <?php echo(!$configuration->getConfig('apply_discount_subsequently', 0) ? 'checked' : '') ?>><label
                                    for="do_not_apply_discount_subsequently"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="disable_coupon_when_rule_applied" class="awdr-left-align"><?php _e('Choose how discount rules should work', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Choose how discount rules should work when WooCommerce coupons (or third party) coupons are used?', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <?php
                            $disable_coupon_when_rule_applied = $configuration->getConfig('disable_coupon_when_rule_applied', 'run_both');
                            ?>
                            <select name="disable_coupon_when_rule_applied" class="disable_coupon_when_rule_applied">
                                <option value="run_both" <?php echo ($disable_coupon_when_rule_applied == 'run_both') ? 'selected' : ''; ?>><?php _e('Let both coupons and discount rules run together', WDR_TEXT_DOMAIN); ?></option>
                                <option value="disable_coupon" <?php echo ($disable_coupon_when_rule_applied == 'disable_coupon') ? 'selected' : ''; ?>><?php _e('Disable the coupons (discount rules will work)', WDR_TEXT_DOMAIN); ?></option>
                                <option value="disable_rules" <?php echo ($disable_coupon_when_rule_applied == 'disable_rules') ? 'selected' : ''; ?> ><?php _e('Disable the discount rules (coupons will work)', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="suppress_other_discount_plugins" class="awdr-left-align"><?php _e('Suppress third party discount plugins', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('suppress third party plugins from modifying the prices. other discount plugins may not works!', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="suppress_other_discount_plugins" id="suppress_other_discount_plugins"
                                   value="1" <?php echo($configuration->getConfig('suppress_other_discount_plugins', 0) ? 'checked' : '') ?>><label
                                    for="modify_price_at_product_page"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>
                            <input type="radio" name="suppress_other_discount_plugins"
                                   id="do_not_suppress_other_discount_plugins"
                                   value="0" <?php echo(!$configuration->getConfig('suppress_other_discount_plugins', 0) ? 'checked' : '') ?>><label
                                    for="do_not_suppress_other_discount_plugins"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <?php
                    do_action('advanced_woo_discount_rules_general_settings_fields', $configuration);
                    ?>
                    </tbody>
                </table>

                <h1><?php _e('Product', WDR_TEXT_DOMAIN) ?></h1>

                <table class="wdr-general-setting form-table">
                    <tbody style="background-color: #fff;">
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('On-sale badge', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('show on-sale badge', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <?php
                            $show_on_sale_badge = $configuration->getConfig('show_on_sale_badge', 'disabled');
                            ?>
                            <select name="show_on_sale_badge" class="on_sale_badge_condition">
                                <option value="when_condition_matches" <?php echo ($show_on_sale_badge == 'when_condition_matches') ? 'selected' : ''; ?> ><?php _e('Show only after a rule condition is matched exactly', WDR_TEXT_DOMAIN); ?></option>
                                <option value="at_least_has_any_rules" <?php echo ($show_on_sale_badge == 'at_least_has_any_rules') ? 'selected' : ''; ?>><?php _e('Show on products that are covered under any discount rule in the plugin', WDR_TEXT_DOMAIN); ?></option>
                                <option value="disabled" <?php echo ($show_on_sale_badge == 'disabled') ? 'selected' : ''; ?>><?php _e('Do not show', WDR_TEXT_DOMAIN); ?></option>
                             </select>
                        </td>
                    </tr>
                    <tr class="sale_badge_toggle" style="<?php echo ($show_on_sale_badge == 'disabled')? 'display:none;':''?>">
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Do you want to customize the sale badge?', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Customize the sale badge', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <?php
                            $customize_on_sale_badge = $configuration->getConfig('customize_on_sale_badge', '');
                            $force_override_on_sale_badge = $configuration->getConfig('force_override_on_sale_badge', '');
                            ?>
                            <input type="checkbox" name="customize_on_sale_badge" id="customize_on_sale_badge"
                                   value="1" <?php echo ( $customize_on_sale_badge == 1 ? 'checked' : '') ?>><label
                                    for="customize_on_sale_badge" class="padding10"><?php _e('Yes, I would like to customize the sale badge', WDR_TEXT_DOMAIN); ?></label>
                            <br>
                            <input type="checkbox" name="force_override_on_sale_badge" id="force_override_on_sale_badge"
                                   value="1" <?php echo ( $force_override_on_sale_badge == 1 ? 'checked' : '') ?>><label
                                    for="force_override_on_sale_badge" class="padding10"><?php _e('Force override the label for sale badge (useful when your theme has override for sale badge).', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr class="sale_badge_customizer" style="<?php echo ($show_on_sale_badge != 'disabled' && $customize_on_sale_badge == 1) ? '':'display:none;'?>">
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Sale badge content', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php _e('You can use HTML inside. <br><b>IMPORTANT NOTE:</b> This customized sale badge will be applicable only for products that are part of the discount rules configured in this plugin <b>Eg:</b><span class="onsale">Sale!</span>', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <textarea name="on_sale_badge_html"
                                      placeholder='<span class="onsale">Sale!</span>'
                                      rows="5"
                                      cols="30"><?php echo $configuration->getConfig('on_sale_badge_html', '<span class="onsale">Sale!</span>'); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Show discount table ', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show discount table on product page', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="show_bulk_table" id="show_bulk_table_layout" class="bulk_table_layout settings_option_show_hide"
                                   value="1" <?php echo($configuration->getConfig('show_bulk_table', 0) ? 'checked' : '') ?> data-name="hide_table_position"><label
                                    for="show_bulk_table_layout"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>
                            <input type="radio" name="show_bulk_table" id="dont_show_bulk_table_layout" class="bulk_table_layout settings_option_show_hide"
                                   value="0" <?php echo(!$configuration->getConfig('show_bulk_table', 0) ? 'checked' : '') ?> data-name="hide_table_position"><label
                                    for="dont_show_bulk_table_layout"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                            <a class="wdr-popup-link" style="<?php echo (!$configuration->getConfig('show_bulk_table', 0)) ? 'display:none' : ''; ?>"><span class="modal-trigger" data-modal="modal-name"><?php _e("Customize Discount Table", WDR_TEXT_DOMAIN); ?></a>
                        </td>

                    </tr>
                    <tr class="hide_table_position"
                        style="<?php echo (!$configuration->getConfig('show_bulk_table', 0) ? 'display:none' : ''); ?>">
                        <td scope="row">
                            <label for="position_to_show_bulk_table" class="awdr-left-align"><?php _e('Position to show discount table', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Position to show discount table on product page', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <select name="position_to_show_bulk_table">
                                <option value="woocommerce_before_add_to_cart_form" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_before_add_to_cart_form') ? 'selected' : ''; ?> ><?php _e('Woocommerce before add to cart form', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_product_meta_end" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_product_meta_end') ? 'selected' : ''; ?>><?php _e('Woocommerce product meta end', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_product_meta_start" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_product_meta_start') ? 'selected' : ''; ?>><?php _e('Woocommerce product meta start', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_after_add_to_cart_form" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_after_add_to_cart_form') ? 'selected' : ''; ?>><?php _e('Woocommerce after add to cart form', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_after_single_product" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_after_single_product') ? 'selected' : ''; ?>><?php _e('Woocommerce after single product', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_before_single_product" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_before_single_product') ? 'selected' : ''; ?>><?php _e('Woocommerce before single product', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_after_single_product_summary" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_after_single_product_summary') ? 'selected' : ''; ?>><?php _e('Woocommerce after single product summary', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_before_single_product_summary" <?php echo ($configuration->getConfig('position_to_show_bulk_table', 'woocommerce_before_add_to_cart_form') == 'woocommerce_before_single_product_summary') ? 'selected' : ''; ?>><?php _e('Woocommerce before single product summary', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="position_to_show_discount_bar" class="awdr-left-align"><?php _e('Position to show discount bar', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Position to show discount bar on product page', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <select name="position_to_show_discount_bar">
                                <option value="woocommerce_before_add_to_cart_form" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_before_add_to_cart_form') ? 'selected' : ''; ?> ><?php _e('Woocommerce before add to cart form', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_product_meta_end" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_product_meta_end') ? 'selected' : ''; ?>><?php _e('Woocommerce product meta end', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_product_meta_start" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_product_meta_start') ? 'selected' : ''; ?>><?php _e('Woocommerce product meta start', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_after_add_to_cart_form" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_after_add_to_cart_form') ? 'selected' : ''; ?>><?php _e('Woocommerce after add to cart form', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_after_single_product" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_after_single_product') ? 'selected' : ''; ?>><?php _e('Woocommerce after single product', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_before_single_product" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_before_single_product') ? 'selected' : ''; ?>><?php _e('Woocommerce before single product', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_after_single_product_summary" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_after_single_product_summary') ? 'selected' : ''; ?>><?php _e('Woocommerce after single product summary', WDR_TEXT_DOMAIN); ?></option>
                                <option value="woocommerce_before_single_product_summary" <?php echo ($configuration->getConfig('position_to_show_discount_bar', 'woocommerce_before_add_to_cart_form') == 'woocommerce_before_single_product_summary') ? 'selected' : ''; ?>><?php _e('Woocommerce before single product summary', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Show strikeout price', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show product strikeout price on', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="checkbox" name="modify_price_at_shop_page" id="modify_price_at_shop_page"
                                   value="1" <?php echo($configuration->getConfig('modify_price_at_shop_page', 1) ? 'checked' : '') ?>><label
                                    for="modify_price_at_shop_page" class="padding10"><?php _e('On shop page?', WDR_TEXT_DOMAIN); ?></label>
                            <input type="checkbox" name="modify_price_at_product_page" id="modify_price_at_product_page"
                                   value="1" <?php echo($configuration->getConfig('modify_price_at_product_page', 1) ? 'checked' : '') ?>><label
                                    for="modify_price_at_product_page" class="padding10"><?php _e('On product page?', WDR_TEXT_DOMAIN); ?></label>
                            <input type="checkbox" name="modify_price_at_category_page" id="modify_price_at_category_page"
                                   value="1" <?php echo($configuration->getConfig('modify_price_at_category_page', 1) ? 'checked' : '') ?>><label
                                    for="modify_price_at_category_page" class="padding10"><?php _e('On category page?', WDR_TEXT_DOMAIN); ?></label>

                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Show Strikeout when', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show Strikeout when this option is matched', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <select name="show_strikeout_when">
                                <option value="show_when_matched" <?php echo ($configuration->getConfig('show_strikeout_when', 'show_when_matched') == 'show_when_matched') ? 'selected' : ''; ?> ><?php _e('Show when a rule condition is matched', WDR_TEXT_DOMAIN); ?></option>
                                <option value="show_after_matched" <?php echo ($configuration->getConfig('show_strikeout_when', 'show_when_matched') == 'show_after_matched') ? 'selected' : ''; ?>><?php _e('Show after a rule condition is matched', WDR_TEXT_DOMAIN); ?></option>
                                <option value="show_dynamically" <?php echo ($configuration->getConfig('show_strikeout_when', 'show_when_matched') == 'show_dynamically') ? 'selected' : ''; ?>><?php _e('Shown on quantity update (dynamic)', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <?php
                    do_action('advanced_woo_discount_rules_product_settings_fields', $configuration);
                    ?>

                    </tbody>
                </table>

                <h1><?php _e('Cart', WDR_TEXT_DOMAIN); ?></h1>

                <table class="wdr-general-setting form-table">
                    <tbody style="background-color: #fff;">
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Show strikeout on cart', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show price strikeout on cart', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="show_strikeout_on_cart" id="show_strikeout_on_cart"
                                   value="1" <?php echo($configuration->getConfig('show_strikeout_on_cart', 1) ? 'checked' : '') ?>><label
                                    for="show_strikeout_on_cart"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>

                            <input type="radio" name="show_strikeout_on_cart" id="dont_show_strikeout_on_cart"
                                   value="0" <?php echo(!$configuration->getConfig('show_strikeout_on_cart', 1) ? 'checked' : '') ?>><label
                                    for="dont_show_strikeout_on_cart"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Combine all cart discounts', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Combine all cart discounts in single discount label', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="combine_all_cart_discounts" id="combine_all_cart_discounts"
                                   data-name="combine_all_cart_discounts"
                                   value="1"
                                   class="settings_option_show_hide" <?php echo($configuration->getConfig('combine_all_cart_discounts', 0) ? 'checked' : '') ?>><label
                                    for="combine_all_cart_discounts"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>

                            <input type="radio" name="combine_all_cart_discounts" id="dont_combine_all_cart_discounts"
                                   data-name="combine_all_cart_discounts"
                                   value="0"
                                   class="settings_option_show_hide" <?php echo(!$configuration->getConfig('combine_all_cart_discounts', 0) ? 'checked' : '') ?>><label
                                    for="dont_combine_all_cart_discounts"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr class="combine_all_cart_discounts"
                        style="<?php echo(!$configuration->getConfig('combine_all_cart_discounts', 0) ? 'display:none' : '') ?>">
                        <td scope="row">
                            <label for="discount_label_for_combined_discounts" class="awdr-left-align"><?php _e('Discount label for combined discounts', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Discount label for combined discounts', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="text" name="discount_label_for_combined_discounts"
                                   value="<?php echo $configuration->getConfig('discount_label_for_combined_discounts', 'Cart discount'); ?>">
                        </td>
                    </tr>
                    <?php
                    do_action('advanced_woo_discount_rules_cart_settings_fields', $configuration);
                    ?>
                    </tbody>
                </table>
                <h1><?php _e('Promotion', WDR_TEXT_DOMAIN); ?></h1>
                <table class="wdr-general-setting form-table">
                    <tbody style="background-color: #fff;">
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Subtotal based promotion', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php _e('Display subtotal based promotion messages in cart/product/shop pages<br>If enabled an option to add promotion message will displays on each rule(when subtotal condition is added)', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="show_subtotal_promotion" id="show_subtotal_promotion"
                                   data-name="show_promo_text_con"
                                   value="1"
                                   class="settings_option_show_hide" <?php echo($configuration->getConfig('show_subtotal_promotion', 0) ? 'checked' : '') ?>><label
                                    for="show_subtotal_promotion"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>

                            <input type="radio" name="show_subtotal_promotion" id="dont_show_subtotal_promotion"
                                   data-name="show_promo_text_con"
                                   value="0"
                                   class="settings_option_show_hide" <?php echo(!$configuration->getConfig('show_subtotal_promotion', 0) ? 'checked' : '') ?>><label
                                    for="dont_show_subtotal_promotion"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr class="show_promo_text_con" style="<?php echo(!$configuration->getConfig('show_subtotal_promotion', 0) ? 'display:none' : '') ?>">
                        <td scope="row">
                            <label for="show_promo_text" class="awdr-left-align"><?php _e('Subtotal based promo text', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Subtotal based promo text (available only for subtotal based discounts) ', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <?php $show_promo_text = $configuration->getConfig('show_promo_text', ''); ?>
                            <select name="show_promo_text[]" multiple class="edit-all-loaded-values" id="show_promo_text" data-placeholder="<?php esc_attr_e("Select the page to display promotion message", WDR_TEXT_DOMAIN);?>">
                                <option value="shop_page" <?php echo (!empty($show_promo_text) && is_array($show_promo_text) && in_array('shop_page', $show_promo_text)) ? 'selected' : ''; ?>><?php _e('Shop page', WDR_TEXT_DOMAIN); ?></option>
                                <option value="product_page" <?php echo (!empty($show_promo_text) && is_array($show_promo_text) && in_array('product_page', $show_promo_text)) ? 'selected' : ''; ?> ><?php _e('Product page', WDR_TEXT_DOMAIN); ?></option>
                                <option value="cart_page" <?php echo (!empty($show_promo_text) && is_array($show_promo_text) && in_array('cart_page', $show_promo_text)) ? 'selected' : ''; ?> ><?php _e('Cart page', WDR_TEXT_DOMAIN); ?></option>
                                <option value="checkout_page" <?php echo (!empty($show_promo_text) && is_array($show_promo_text) && in_array('checkout_page', $show_promo_text)) ? 'selected' : ''; ?> ><?php _e('Checkout page', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="display_saving_text" class="awdr-left-align"><?php _e('Display you saved text', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Display you saved text when rule applied', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <select name="display_saving_text" class="settings_option_show_hide_on_change">
                                <option value="disabled" <?php echo ($configuration->getConfig('display_saving_text', 'disabled') == 'disabled') ? 'selected' : ''; ?>><?php _e('Disabled', WDR_TEXT_DOMAIN); ?></option>
                                <option value="on_each_line_item" <?php echo ($configuration->getConfig('display_saving_text', 'disabled') == 'on_each_line_item') ? 'selected' : ''; ?> ><?php _e('On each line item', WDR_TEXT_DOMAIN); ?></option>
                                <option value="after_total" <?php echo ($configuration->getConfig('display_saving_text', 'disabled') == 'after_total') ? 'selected' : ''; ?> ><?php _e('On after total', WDR_TEXT_DOMAIN); ?></option>
                                <option value="both_line_item_and_after_total" <?php echo ($configuration->getConfig('display_saving_text', 'disabled') == 'both_line_item_and_after_total') ? 'selected' : ''; ?> ><?php _e('Both in line item and after total', WDR_TEXT_DOMAIN); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr class="display_you_saved_text"
                        style="<?php echo ($configuration->getConfig('display_saving_text', 'disabled') == 'disabled') ? 'display:none' : ''; ?>">
                        <td scope="row">
                            <label for="you_saved_text" class="awdr-left-align"><?php _e('Savings text to show', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('You save text to show when rule applied', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <textarea name="you_saved_text" rows="5"
                                      cols="30"><?php echo $configuration->getConfig('you_saved_text', 'You saved {{total_discount}}'); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                            <label for="" class="awdr-left-align"><?php _e('Show a discount applied message on cart?', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show message in cart page on rule applied', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <input type="radio" name="show_applied_rules_message_on_cart" class="settings_option_show_hide"
                                   id="show_applied_rules_message_on_cart" data-name="hide_alert_message_text"
                                   value="1" <?php echo($configuration->getConfig('show_applied_rules_message_on_cart', 0) ? 'checked' : '') ?>><label
                                    for="show_applied_rules_message_on_cart"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>

                            <input type="radio" name="show_applied_rules_message_on_cart" class="settings_option_show_hide"
                                   id="dont_show_applied_rules_message_on_cart" data-name="hide_alert_message_text"
                                   value="0" <?php echo(!$configuration->getConfig('show_applied_rules_message_on_cart', 0) ? 'checked' : '') ?>><label
                                    for="dont_show_applied_rules_message_on_cart"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr class="hide_alert_message_text" style="<?php echo (!$configuration->getConfig('show_applied_rules_message_on_cart', 0)) ? 'display:none' : ''; ?>">
                        <td scope="row">
                            <label for="applied_rule_message" class="awdr-left-align"><?php _e('Applied rule message text on cart', WDR_TEXT_DOMAIN) ?></label>
                            <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Text to show when rule applied', WDR_TEXT_DOMAIN); ?></span>
                        </td>
                        <td>
                            <textarea name="applied_rule_message"
                                      rows="5"
                                      cols="30"><?php echo $configuration->getConfig('applied_rule_message', 'You saved {{total_discount}}'); ?></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <h1><?php _e('Banner', WDR_TEXT_DOMAIN); ?></h1>
                <table class="wdr-general-setting form-table">
                    <tbody style="background-color: #fff;">
                    <?php if(!$is_pro) { ?>
                        <tr class="" style="">
                            <td scope="row">
                                <label for="applied_rule_message"
                                       class="awdr-left-align"><?php _e('Banner Content', WDR_TEXT_DOMAIN) ?></label>
                                <span class="wdr_desc_text awdr-clear-both"><?php _e('A static banner you that you want to display in your storefront. <br><br> <b>NOTE:</b> It is a static banner. You can use any content or html here.', WDR_TEXT_DOMAIN); ?></span>
                            </td>
                            <td>
                                <?php _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN); ?>
                            </td>
                        </tr>
                        <tr class="" style="">
                            <td scope="row">
                                <label for="applied_rule_message"
                                       class="awdr-left-align"><?php _e('Banner Content display position', WDR_TEXT_DOMAIN) ?></label>
                                <span class="wdr_desc_text awdr-clear-both"><?php _e('Choose a display position for the banner in your storefront', WDR_TEXT_DOMAIN); ?></span>
                            </td>
                            <td><?php _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN); ?></td>
                        </tr>
                    <?php } ?>

                    <?php
                    do_action('advanced_woo_discount_rules_promotion_settings_fields', $configuration);
                    ?>
                    </tbody>
                </table>
                <h1><?php _e('On-Sale page', WDR_TEXT_DOMAIN); ?></h1>
                <table class="wdr-general-setting form-table">
                    <tbody style="background-color: #fff;">
                    <tr>
                        <td scope="row">
                            <?php
                            _e('Select rules for the On Sale Page', WDR_TEXT_DOMAIN );
                            ?>
                        </td>
                        <td scope="row">
                            <?php if($is_pro){ ?>
                            <div class="awdr_rebuild_on_sale_list_progress">
                            </div>
                            <div class="awdr_rebuild_on_sale_list_con">
                                <div class="wdr-select-filed-hight wdr-search-box">
                                    <select id="awdr_rebuild_on_sale_rules" name="awdr_rebuild_on_sale_rules[]" multiple
                                            class="edit-all-loaded-values"
                                            data-list=""
                                            data-field="autoloaded"
                                            data-placeholder="<?php esc_attr_e("Type the name of the rule to select it", WDR_TEXT_DOMAIN);?>"
                                            style="">
                                        <option value="all"
                                            <?php if(!empty($awdr_rebuild_on_sale_rules) && is_array($awdr_rebuild_on_sale_rules)){
                                                if(in_array("all", $awdr_rebuild_on_sale_rules)){
                                                    echo ' selected ';
                                                }
                                            } ?>
                                        ><?php esc_attr_e("All active rules", WDR_TEXT_DOMAIN); ?></option>
                                        <?php
                                        $awdr_rebuild_on_sale_rules = $configuration->getConfig('awdr_rebuild_on_sale_rules', array());
                                        $rules = \Wdr\App\Controllers\ManageDiscount::$available_rules;
                                        if(!empty($rules) && is_array($rules)){
                                            foreach ($rules as $rule){
                                                if($rule->rule->enabled == 1){
                                                    ?>
                                                    <option value="<?php echo $rule->rule->id; ?>"
                                                    <?php if(!empty($awdr_rebuild_on_sale_rules) && is_array($awdr_rebuild_on_sale_rules)){
                                                        if(in_array($rule->rule->id, $awdr_rebuild_on_sale_rules)){
                                                            echo ' selected ';
                                                        }
                                                    } ?>
                                                    ><?php echo $rule->rule->title; ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="awdr_rebuild_on_sale_list_notice">
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning" id="awdr_rebuild_on_sale_list"><?php _e('Save and Build Index', WDR_TEXT_DOMAIN ); ?></button>
                            <?php } else {
                                _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN);
                            }?>
                        </td>
                    </tr>
                    <?php if($is_pro){ ?>
                    <tr>
                        <td scope="row" colspan="2">
                            <?php
                            _e('ShortCode to load all products which has discount through Woo Discount Rules', WDR_TEXT_DOMAIN );
                            ?>
                            <span id="awdr_shortcode_text">[awdr_sale_items_list]</span>
                            <button type="button" class="btn btn-warning" id="awdr_shortcode_copy_btn"><?php _e('Copy ShortCode', WDR_TEXT_DOMAIN ); ?></button>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
                do_action('advanced_woo_discount_rules_after_settings_fields', $configuration);
                ?>

            <!--Bulk Table Popup start-->

            <div class="modal" id="modal-name">
                <div class="modal-sandbox"></div>
                <div class="modal-box">
                    <div class="modal-header">
                        <div class="close-modal"><span class="wdr-close-modal-box">&#10006;</span></div>
                        <h1 class="wdr-modal-header-title"><?php _e("Customize Discount Table", WDR_TEXT_DOMAIN); ?></h1>
                    </div>
                    <div class="modal-body">
                        <p class="awdr-save-green wdr-alert-success" style="display: none;"><?php _e('Settings Saved', WDR_TEXT_DOMAIN) ?></p>
                        <p class="wdr-customizer-notes"><b><?php _e('Note:', WDR_TEXT_DOMAIN) ?></b><?php _e(" This table contains sample content for design purpose.", WDR_TEXT_DOMAIN); ?></p>
                        <div style="width: 100%">
                            <div class="wdr-customizer-container">
                                <div class="wdr-customizer-grid">
                                    <div class="wdr_customize_table_settings">
                                        <table class="form-table popup-bulk-table">
                                            <tbody style="background-color: #fff;">

                                                <tr>
                                                    <th scope="row">
                                                        <label for="" class="awdr-left-align"><?php _e('Table Header', WDR_TEXT_DOMAIN) ?></label>
                                                        <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show/Hide table header column names', WDR_TEXT_DOMAIN); ?></span>
                                                    </th>
                                                    <td >
                                                        <input type="radio" name="table_column_header" id="show_table_header" class="bulk_table_customizer_preview"
                                                               value="1" data-colname="wdr_bulk_table_thead" data-showhide="show" <?php echo($configuration->getConfig('table_column_header', 1) ? 'checked' : '') ?>><label
                                                                for="show_table_header"><?php _e('Show', WDR_TEXT_DOMAIN); ?></label>
                                                        <input type="radio" name="table_column_header" id="dont_show_table_header" class="bulk_table_customizer_preview"
                                                               value="0" data-colname="wdr_bulk_table_thead" data-showhide="hide" <?php echo(!$configuration->getConfig('table_column_header', 1) ? 'checked' : '') ?>><label
                                                                for="dont_show_table_header"><?php _e("Don't Show", WDR_TEXT_DOMAIN); ?></label>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <th scope="row">
                                                        <label for="" class="awdr-left-align"><?php _e('Title column Name on table', WDR_TEXT_DOMAIN) ?></label>
                                                        <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Give name for rule title column', WDR_TEXT_DOMAIN); ?></span>
                                                    </th>
                                                    <td class="awdr_table_columns">
                                                        <input type="checkbox" name="table_title_column" value="1" class="bulk_table_customizer_show_hide_column"
                                                               data-colname="popup_table_title_column"
                                                            <?php echo($configuration->getConfig('table_title_column', 1) ? 'checked' : '') ?>>
                                                        <input type="text" class="awdr_popup_col_name_text_box awdr_popup_col_title_keyup" data-keyup="title_on_keyup" name="table_title_column_name" value="<?php echo $configuration->getConfig('table_title_column_name', 'Title');?>">
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <th scope="row">
                                                        <label for="" class="awdr-left-align"><?php _e('Discount column Name on table', WDR_TEXT_DOMAIN) ?></label>
                                                        <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Give name for discount column', WDR_TEXT_DOMAIN); ?></span>
                                                    </th>
                                                    <td class="awdr_table_columns">
                                                        <input type="checkbox" name="table_discount_column" value="1" class="bulk_table_customizer_show_hide_column"
                                                               data-colname="popup_table_discount_column"
                                                            <?php echo($configuration->getConfig('table_discount_column', 1) ? 'checked' : '') ?>>
                                                        <input type="text" class="awdr_popup_col_name_text_box" data-keyup="discount_on_keyup" name="table_discount_column_name" value="<?php echo $configuration->getConfig('table_discount_column_name', 'Discount');?>">
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <th scope="row">
                                                        <label for="" class="awdr-left-align"><?php _e('Range column Name on table', WDR_TEXT_DOMAIN) ?></label>
                                                        <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Give name for range column', WDR_TEXT_DOMAIN); ?></span>
                                                    </th>
                                                    <td class="awdr_table_columns">
                                                        <input type="checkbox" name="table_range_column" value="1" class="bulk_table_customizer_show_hide_column"
                                                               data-colname="popup_table_range_column"
                                                            <?php echo($configuration->getConfig('table_range_column', 1) ? 'checked' : '') ?>>
                                                        <input type="text" class="awdr_popup_col_name_text_box" data-keyup="range_on_keyup" name="table_range_column_name" value="<?php echo $configuration->getConfig('table_range_column_name', 'Range');?>">
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <th scope="row">
                                                        <label for="" class="awdr-left-align"><?php _e('Discount column value on table', WDR_TEXT_DOMAIN) ?></label>
                                                        <span class="wdr_settings_desc_text awdr-clear-both"><?php esc_attr_e('Show Discount value/price in table', WDR_TEXT_DOMAIN); ?></span>
                                                    </th>
                                                    <td>
                                                        <input type="radio" name="table_discount_column_value" id="show_table_discount_column_value" class="popup_table_discount_column_value"
                                                               value="1" <?php echo($configuration->getConfig('table_discount_column_value', 1) ? 'checked' : '') ?>><label
                                                                for="show_table_discount_column_value"><?php _e('Discount Value', WDR_TEXT_DOMAIN); ?></label>
                                                        <input type="radio" name="table_discount_column_value" id="dont_show_table_discount_column_value" class="popup_table_discount_column_value"
                                                               value="0" <?php echo(!$configuration->getConfig('table_discount_column_value', 1) ? 'checked' : '') ?>><label
                                                                for="dont_show_table_discount_column_value"><?php _e("Discounted Price", WDR_TEXT_DOMAIN); ?></label>
                                                    </td>
                                                </tr>
                                               <!-- <tr>
                                                    <th scope="row">
                                                        <label for=""><?php /*_e('Color Picker', WDR_TEXT_DOMAIN) */?></label>
                                                        <span style="float: right" class="wdr-tool-tip"
                                                              title="<?php /*_e("Rule name / title", WDR_TEXT_DOMAIN); */?>"> &#63</span>
                                                    </th>
                                                    <td>
                                                        <input type="color" id="colorpicker" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                                                        <input type="text" name="wdr_color_picker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor">
                                                    </td>
                                                </tr>-->
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="wdr_customize_table" style="background-color: #fff;"><?php
                                            $tbl_title = $configuration->getConfig('customize_bulk_table_title', 0);
                                            $tbl_range = $configuration->getConfig('customize_bulk_table_range', 1);
                                            $tbl_discount = $configuration->getConfig('customize_bulk_table_discount', 2);


                                            $tbl_title_text = $configuration->getConfig('table_title_column_name', 'Title');
                                            $tbl_discount_text = $configuration->getConfig('table_discount_column_name', 'Discount');
                                            $tbl_range_text = $configuration->getConfig('table_range_column_name', 'Range');

                                            $table_sort_by_columns = array(
                                                'tbl_title' => $tbl_title,
                                                'tbl_range' => $tbl_range,
                                                'tbl_discount' => $tbl_discount,
                                            );
                                            asort($table_sort_by_columns);
                                            ?>
                                            <table id="sort_customizable_table" class="wdr_bulk_table_msg sar-table">
                                                <thead class="wdr_bulk_table_thead">
                                                    <tr class="wdr_bulk_table_tr wdr_bulk_table_thead" style="">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {
                                                                ?>
                                                            <th id="customize-bulk-table-title" class="wdr_bulk_table_td popup_table_title_column awdr-dragable"
                                                                style="<?php if(!$configuration->getConfig('table_column_header', 0)){
                                                                    echo 'display:none';
                                                                }else{
                                                                    echo((!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '');
                                                                } ?>"><span class="title_on_keyup"><?php _e($tbl_title_text, WDR_TEXT_DOMAIN) ?></span>
                                                                </th><?php
                                                            } elseif ($column == "tbl_discount") {
                                                                ?>
                                                            <th id="customize-bulk-table-discount" class="wdr_bulk_table_td popup_table_discount_column awdr-dragable"
                                                                style="<?php if(!$configuration->getConfig('table_column_header', 0)){
                                                                    echo 'display:none';
                                                                }else{
                                                                    echo((!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '');
                                                                } ?>"><span class="discount_on_keyup"><?php _e($tbl_discount_text, WDR_TEXT_DOMAIN) ?></span>
                                                                </th><?php
                                                            } else {
                                                                ?>
                                                            <th id="customize-bulk-table-range" class="wdr_bulk_table_td popup_table_range_column awdr-dragable"
                                                                style="<?php if(!$configuration->getConfig('table_column_header', 0)){
                                                                    echo 'display:none';
                                                                }else{
                                                                    echo((!$configuration->getConfig('table_range_column', 0)) ? 'display:none' : '');
                                                                }?>"><span class="range_on_keyup"><?php _e($tbl_range_text, WDR_TEXT_DOMAIN) ?></span></th><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Bulk Rule', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(12);
                                                                    _e(' flat', WDR_TEXT_DOMAIN); ?></span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(33); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('1 - 5', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Bulk Rule', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>">
                                                                     14%
                                                                </span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(38.70); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('11 - 15', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Bulk Flat discount', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(10);
                                                                    _e(' flat', WDR_TEXT_DOMAIN); ?> </span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(35); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('50 - 60', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Bulk percentage discount', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>">
                                                                    10% </span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(40.50); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('70 - 80', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Bulk % discount', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>">
                                                                    50% </span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(22.50); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('450 - 500', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Bulk flat', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(10);
                                                                    _e(' flat', WDR_TEXT_DOMAIN); ?></span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(35); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('600 - 700', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('set percentage discount', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>">
                                                                   10%</span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(40.50); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('5', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('Fixed discount for set', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(20); ?></span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                    echo  \Wdr\App\Helpers\Woocommerce::formatPrice(2); ?></span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('10', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                    <tr class="wdr_bulk_table_tr bulk_table_row">
                                                        <?php foreach ($table_sort_by_columns as $column => $order) {
                                                            if ($column == "tbl_title") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_title popup_table_title_column col_index_1" data-colindex="1"
                                                                style="<?php echo (!$configuration->getConfig('table_title_column', 0)) ? 'display:none' : '';?>">
                                                                <?php _e('set flat discount', WDR_TEXT_DOMAIN); ?>
                                                                </td><?php

                                                            } elseif ($column == "tbl_discount") {?>
                                                            <td class="wdr_bulk_table_td wdr_bulk_table_discount  popup_table_discount_column col_index_2" data-colindex="2"
                                                                style="<?php echo (!$configuration->getConfig('table_discount_column', 0)) ? 'display:none' : '';?>">
                                                                <span class="wdr_table_discounted_value" style="<?php echo ( !$configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                echo  \Wdr\App\Helpers\Woocommerce::formatPrice(30); ?></span>
                                                                <span class="wdr_table_discounted_price" style="<?php echo ( $configuration->getConfig('table_discount_column_value', 0)) ? 'display: none' : '';?>"><?php
                                                                echo  \Wdr\App\Helpers\Woocommerce::formatPrice(2);?> </span>
                                                                </td><?php
                                                            } else {?>
                                                                <td class="wdr_bulk_table_td wdr_bulk_range popup_table_range_column col_index_3" data-colindex="3"
                                                                    style="<?php echo (!$configuration->getConfig('table_range_column', 0)) ? 'display:none':'';?>"><?php _e('15', WDR_TEXT_DOMAIN); ?></td><?php
                                                            }
                                                        }?>
                                                    </tr>
                                                </tbody>
                                            </table>





                                            <p class="advanced_layout_preview"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <a class="bulk-table-customized-setting wdr-model-bottom-btn btn btn-primary" style="text-decoration: none">Save</a>
                            <a class="close-modal wdr-model-bottom-btn btn btn-danger" style="text-decoration: none">Close</a>
                        </div>
                </div>
            </div>

                <!--Bulk Table Popup end-->


                <div class="save-configuration">
                    <input type="hidden" class="customizer_save_alert" name="customizer_save_alert" value="">
                    <input type="hidden" name="customize_bulk_table_title" class="customize_bulk_table_title" value="<?php echo $configuration->getConfig('customize_bulk_table_title', 0); ?>">
                    <input type="hidden" name="customize_bulk_table_discount" class="customize_bulk_table_discount" value="<?php echo $configuration->getConfig('customize_bulk_table_discount', 2); ?>">
                    <input type="hidden" name="customize_bulk_table_range" class="customize_bulk_table_range" value="<?php echo $configuration->getConfig('customize_bulk_table_range', 1); ?>">

                    <input type="hidden" name="method" value="save_configuration">
                    <input type="hidden" name="action" value="wdr_ajax">
                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary save-configuration-submit"
                                             value="Save Changes"></p>
                </div>
            </form>
        </div>
    </div>





