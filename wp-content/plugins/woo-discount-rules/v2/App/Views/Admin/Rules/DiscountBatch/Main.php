<?php

use Wdr\App\Helpers\Helper;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$is_pro = Helper::hasPro();
?>
<button class="awdr-accordion <?php echo ($badge_display) ? 'awdr-accordion-active' : ''; ?>"><?php _e("Discount Bar (Optional)", WDR_TEXT_DOMAIN); ?></button>
<div class="awdr-discount-batch-container awdr-accordion-panel"
     style="<?php echo ($badge_display) ? 'display: block;' : ''; ?>">
    <div class="awdr-discount-batch-row">
        <div class="wdr-rule-filters-and-options-con">
            <div class="wdr-rule-menu">
                <div class="awdr-discount-bar-content">
                    <p><?php _e("It helps to display discount information in product pages.", WDR_TEXT_DOMAIN); ?> <a href="https://docs.flycart.org/en/articles/3946529-discount-bar" target="_blank" ><?php _e("Read docs.", WDR_TEXT_DOMAIN); ?></a> </p>
                    <b><?php _e('Preview', WDR_TEXT_DOMAIN); ?></b><br><br>
                    <div class="awdr_admin_discount_bar awdr_row_0" style="background-color:<?php echo ($badge_bg_color) ? $badge_bg_color : '#ffffff' ?>;color:<?php echo ($badge_text_color) ? $badge_text_color : '#000000' ?>;">
                        <?php echo ($badge_text) ? $badge_text : 'Discount Text';  ?>
                    </div>
                    <p><b><?php _e('Note:', WDR_TEXT_DOMAIN); ?></b><?php _e('Preview contains sample result for original result see product page.', WDR_TEXT_DOMAIN); ?></p>
                </div>
            </div>
            <div class="wdr-rule-options-con">
                <div class="wdr-advanced-layout-block">
                    <div class="wdr-block">
                        <div class="wdr-row">
                            <div class="wdr-advanced-layout-groups">
                                <table class="form-table awdr-discount-badge">
                                    <tbody style="background-color: #fff;">
                                    <tr>
                                        <td scope="row">
                                            <label for=""
                                                   class="awdr-left-align"><b><?php _e('Show Discount Bar?', WDR_TEXT_DOMAIN); ?></b></label>
                                            <span class="wdr_desc_text awdr-clear-both"><?php _e('Show/hide discount bar on product pages', WDR_TEXT_DOMAIN); ?></span>
                                        </td>
                                        <td>
                                            <?php if($is_pro) { ?>
                                            <input type="radio" name="discount_badge[display]"
                                                   id="show_applied_rules_message_on_cart"
                                                   value="1" <?php echo ($badge_display) ? 'checked' : ''; ?>><label
                                                    for="show_applied_rules_message_on_cart"><?php _e('Yes', WDR_TEXT_DOMAIN); ?></label>

                                            <input type="radio"
                                                   name="discount_badge[display]" <?php echo (!$badge_display) ? 'checked' : ''; ?>
                                                   id="dont_show_applied_rules_message_on_cart" value="0"><label
                                                    for="dont_show_applied_rules_message_on_cart"><?php _e('No', WDR_TEXT_DOMAIN); ?></label>
                                            <?php } else { 
                                                _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN);
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <label for=""
                                                   class="awdr-left-align"><b><?php _e('Badge Background Color', WDR_TEXT_DOMAIN); ?></b></label>
                                            <span class="wdr_desc_text awdr-clear-both"><?php _e('Choose background color to be shown in product pages.', WDR_TEXT_DOMAIN); ?></span>
                                        </td>
                                        <td>
                                            <?php if($is_pro) { ?>
                                            <input type="color" id="badge_colorpicker"
                                                   name="discount_badge[badge_color_picker]"
                                                   pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"
                                                   value="<?php echo ($badge_bg_color) ? $badge_bg_color : '#ffffff'; ?>">
                                            <input type="text" name="discount_badge[badge_color_picker]"
                                                   pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"
                                                   value="<?php echo ($badge_bg_color) ? $badge_bg_color : '#ffffff'; ?>"
                                                   id="badge_hexcolor" class="wdr_color_picker">
                                            <?php } else {
                                                _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN);
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <label for=""
                                                   class="awdr-left-align"><b><?php _e('Badge Text Color', WDR_TEXT_DOMAIN); ?></b></label>
                                            <span class="wdr_desc_text awdr-clear-both"><?php _e('Choose text color to be shown in product pages.', WDR_TEXT_DOMAIN); ?></span>
                                        </td>
                                        <td>
                                            <?php if($is_pro) { ?>
                                            <input type="color" id="text_colorpicker"
                                                   name="discount_badge[badge_text_color_picker]"
                                                   pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"
                                                   value="<?php echo ($badge_text_color) ? $badge_text_color : '#000000'; ?>">
                                            <input type="text" name="discount_badge[badge_text_color_picker]"
                                                   pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"
                                                   value="<?php echo ($badge_text_color) ? $badge_text_color : '#000000'; ?>"
                                                   id="text_hexcolor" class="wdr_color_picker">
                                            <?php } else {
                                                _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN);
                                            } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            <label for=""
                                                   class="awdr-left-align"><b><?php _e('Badge Text ', WDR_TEXT_DOMAIN); ?></b></label>
                                            <span class="wdr_desc_text awdr-clear-both"><?php _e('Customise the text that you want to display. <br><b>Note</b> : You can also use shortcodes to show discount amount.', WDR_TEXT_DOMAIN); ?></span>
                                        </td>
                                        <td>
                                            <?php if($is_pro) { ?>
                            <textarea
                                    name="discount_badge[badge_text]"
                                    class="awdr_discount_msg"
                                    id="awdr_discount_bar_content"
                                    rows="4"
                                    cols="50"
                                    placeholder="<?php _e('Discount Text', WDR_TEXT_DOMAIN); ?>"><?php echo ($badge_text) ? $badge_text : ''; ?></textarea>
                                    <br/><span class="wdr_adv_msg_shortcode_text">
                                        <b class="adv-msg-title">{{title}} -&gt; <?php _e(' Rule Title,', WDR_TEXT_DOMAIN); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        if(0){ //Disabled for now
                                        ?>
                                                <b class="adv-msg-discount">{{discount}} -&gt; <?php _e(' Discount (if percentage eg: 20% or Flat, Fixed Price eg:$20),', WDR_TEXT_DOMAIN); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <b class="adv-msg-discount-price">{{discounted_price}} -&gt; <?php _e(' Discounted Product Price,', WDR_TEXT_DOMAIN); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <b class="adv-msg-min-qty">{{min_quantity}} -&gt; <?php _e(' Minimum quantity (shows only for bluk and set discount range),', WDR_TEXT_DOMAIN); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <b class="adv-msg-max-qty">{{max_quantity}} -&gt; <?php _e(' Maximum quantity (shows only for bulk discount range)', WDR_TEXT_DOMAIN); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                        }
                                        ?>
                                            </span>
                                            <?php } else {
                                                _e("Unlock this feature by <a href='https://www.flycart.org/products/wordpress/woocommerce-discount-rules' target='_blank'>Upgrading to Pro</a>", WDR_TEXT_DOMAIN);
                                            } ?>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>