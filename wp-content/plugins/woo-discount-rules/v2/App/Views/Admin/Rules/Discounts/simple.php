<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$is_pro = \Wdr\App\Helpers\Helper::hasPro();
?>
<div class="wdr_simple_discount">
    <div class="wdr-discount-group" data-index="{i}">
        <div class="wdr-simple-discount-main">
            <div class="wdr-simple-discount-inner">
                <div class="simple_discount_option wdr-select-filed-hight">
                    <select name="product_adjustments[type]" class="product_discount_option  awdr-left-align">
                        <option value="percentage" <?php echo (isset($product_adjustments->type) && $product_adjustments->type == 'percentage') ? 'selected' : ''; ?>><?php _e('Percentage discount', WDR_TEXT_DOMAIN); ?></option>
                        <option value="flat" <?php echo (isset($product_adjustments->type) && $product_adjustments->type == 'flat') ? 'selected' : ''; ?>><?php _e('Fixed discount', WDR_TEXT_DOMAIN); ?></option>
                        <?php if($is_pro){ ?>
                            <option value="fixed_price" <?php echo (isset($product_adjustments->type) && $product_adjustments->type == 'fixed_price') ? 'selected' : ''; ?>><?php _e('Fixed price per item', WDR_TEXT_DOMAIN); ?></option>
                        <?php } else {
                            ?>
                            <option disabled><?php _e('Fixed price per item -PRO-', WDR_TEXT_DOMAIN); ?></option>
                        <?php
                        }?>
                    </select>
                    <span class="wdr_desc_text awdr-clear-both"><?php _e('Discount Type', WDR_TEXT_DOMAIN); ?></span>
                </div>
                <div class="simple_discount_value wdr-input-filed-hight">
                    <input name="product_adjustments[value]"
                           type="number"
                           class="product_discount_value"
                           value="<?php echo (isset($product_adjustments->value)) ? $product_adjustments->value : ''; ?>"
                           placeholder="0.00" min="0" step="any" style="width: 100%;">
                    <span class="wdr_desc_text"><?php _e('Value', WDR_TEXT_DOMAIN); ?></span>
                </div>
            </div>
            <div class="apply_discount_as_cart_section">
                <div class="page__toggle apply_as_cart_checkbox">
                    <label class="toggle">
                        <input class="toggle__input apply_fee_coupon_checkbox" type="checkbox"
                               name="product_adjustments[apply_as_cart_rule]" <?php echo (isset($product_adjustments->apply_as_cart_rule) && !empty($product_adjustments->apply_as_cart_rule)) ? 'checked' : '' ?> value="1">
                        <span class="toggle__label"><span
                                    class="toggle__text toggle_tic"><?php _e('Show discount in cart as coupon instead of changing the product price ?', WDR_TEXT_DOMAIN); ?></span></span>
                    </label>
                </div>
                <div class="simple_discount_value wdr-input-filed-hight apply_fee_coupon_label" style="<?php echo (isset($product_adjustments->apply_as_cart_rule) && !empty($product_adjustments->apply_as_cart_rule)) ? '' : 'display: none;' ?>">
                    <input name="product_adjustments[cart_label]"
                           type="text"
                           value="<?php echo (isset($product_adjustments->cart_label)) ? $product_adjustments->cart_label : ''; ?>"
                           placeholder="Discount Label">
                </div>
            </div>
        </div>
    </div>
</div>