<?php
if (!defined('ABSPATH')) {
    exit;
}
$range = null;
?>
<!-- Set discount Start-->
<div class="add_set_range" style="display:none;">
    <?php
    $set_range = "{i}";
    include 'set-range.php';
    ?>
</div>
<div class="wdr_set_discount" style="display:none;">
    <div class="wdr-simple-discount-main wdr-set-discount-main">
        <div class="wdr-simple-discount-inner">
            <div class="set_general_adjustment wdr-select-filed-hight">
                <label class="label_font_weight"><?php _e('Count by:', WDR_PRO_TEXT_DOMAIN); ?></label>
                <select name="set_adjustments[operator]" class="wdr-set-type set_discount_select awdr_mode_of_operator">
                    <option value="product_cumulative" <?php if ($set_adj_operator == 'product_cumulative') {
                        echo 'selected';
                    } ?>><?php _e('Product filters together', WDR_PRO_TEXT_DOMAIN) ?></option>
                    <option value="product" <?php if ($set_adj_operator == 'product') {
                        echo 'selected';
                    } ?>><?php _e('Individual product', WDR_PRO_TEXT_DOMAIN) ?></option>
                    <option value="variation" <?php if ($set_adj_operator == 'variation') {
                        echo 'selected';
                    } ?>><?php _e('All variants in each product together', WDR_PRO_TEXT_DOMAIN) ?></option>
                </select>
            </div>
            <div class="awdr-example"></div>
        </div>

        <div class="set_range_setter_group"><?php
            $set_range = 1;
            if ($set_adj_ranges) {
                foreach ($set_adj_ranges as $range) {
                    if (isset($range->from) && !empty($range->from) || isset($range->to) && !empty($range->to) || isset($range->value) && !empty($range->value)) {
                        include 'set-range.php';
                        $set_range++;
                    }
                }
            } else {
                include 'set-range.php';
            } ?>

        </div>
        <div style="padding-left: 14px;">
            <button type="button" class="button add_discount_elements" data-discount-method="add_set_range"
                    data-append="set_range_setter"><?php _e('Add Range', WDR_PRO_TEXT_DOMAIN) ?></button>
        </div>
        <div class="apply_discount_as_cart_section">
            <div class="page__toggle apply_as_cart_checkbox">
                <label class="toggle">
                    <input class="toggle__input apply_fee_coupon_checkbox" type="checkbox"
                           name="set_adjustments[apply_as_cart_rule]" <?php echo (isset($set_adj_as_cart) && !empty($set_adj_as_cart)) ? 'checked' : '' ?> value="1">
                    <span class="toggle__label"><span
                                class="toggle__text toggle_tic"><?php _e('Show discount in cart as coupon instead of changing the product price ?', WDR_PRO_TEXT_DOMAIN); ?></span></span>
                </label>
            </div>
            <div class="simple_discount_value wdr-input-filed-hight apply_fee_coupon_label" style="<?php echo (isset($set_adj_as_cart) && !empty($set_adj_as_cart)) ? '' : 'display: none;' ?>">
                <input name="set_adjustments[cart_label]"
                       type="text"
                       value="<?php echo (isset($set_adj_as_cart_label)) ? $set_adj_as_cart_label : ''; ?>"
                       placeholder="Discount Label">
            </div>
        </div>
    </div>
</div>
<!-- Set discount End-->