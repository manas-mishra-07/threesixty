<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="add_bulk_range" style="display:none;">
    <?php
    $bulk_index = "{i}";
    include 'Bulk.php';
    ?>
</div>
<!-- Bulk discount Start-->
<div class="wdr_bulk_discount" style="display:none;">
    <div class="wdr-simple-discount-main wdr-bulk-discount-main">
        <div class="wdr-simple-discount-inner">
            <div class="bulk_general_adjustment wdr-select-filed-hight">
                <label class="label_font_weight"><?php _e('Count by:', WDR_TEXT_DOMAIN); ?></label>
                <select name="bulk_adjustments[operator]"
                        class="wdr-bulk-type bulk_discount_select awdr_mode_of_operator">
                    <option value="product_cumulative" <?php if ($bulk_adj_operator == 'product_cumulative') {
                        echo 'selected';
                    } ?>><?php _e('Product filters together', WDR_TEXT_DOMAIN) ?></option>
                    <option value="product" <?php if ($bulk_adj_operator == 'product') {
                        echo 'selected';
                    } ?>><?php _e('Individual product', WDR_TEXT_DOMAIN) ?></option>
                    <option value="variation" <?php if ($bulk_adj_operator == 'variation') {
                        echo 'selected';
                    } ?>><?php _e('All variants in each product together', WDR_TEXT_DOMAIN) ?></option>
                </select>
            </div>
            <div class="awdr-example"></div>
        </div>
        <div class="bulk_range_setter_group" >
            <?php
            $bulk_index = 1;
            if ($bulk_adj_ranges) {
                foreach ($bulk_adj_ranges as $range_value) {
                    include 'Bulk.php';
                    $bulk_index++;
                }
            } else {
                include 'Bulk.php';
            }
            ?>
        </div>
        <div class="add-condition-and-filters awdr-discount-add-row">
            <button type="button" class="button add_discount_elements"
                    data-discount-method="add_bulk_range"
                    data-next-starting-value = ".wdr-discount-group"
                    data-append="bulk_range_setter"><?php _e('Add Range', WDR_TEXT_DOMAIN) ?></button>
        </div>
        <div class="apply_discount_as_cart_section">
            <div class="page__toggle apply_as_cart_checkbox">
                <label class="toggle">
                    <input class="toggle__input apply_fee_coupon_checkbox" type="checkbox"
                           name="bulk_adjustments[apply_as_cart_rule]" <?php echo (isset($bulk_adj_as_cart) && !empty($bulk_adj_as_cart))  ? 'checked' : '' ?> value="1">
                    <span class="toggle__label"><span
                                class="toggle__text toggle_tic"><?php _e('Show discount in cart as coupon instead of changing the product price ?', WDR_TEXT_DOMAIN); ?></span></span>
                </label>
            </div>
            <div class="simple_discount_value wdr-input-filed-hight apply_fee_coupon_label" style="<?php echo (isset($bulk_adj_as_cart) && !empty($bulk_adj_as_cart)) ? '' : 'display: none;' ?>">
                <input name="bulk_adjustments[cart_label]"
                       type="text"
                       value="<?php echo (isset($bulk_adj_as_cart_label)) ? $bulk_adj_as_cart_label : ''; ?>"
                       placeholder="Discount Label">
            </div>
        </div>
    </div>
</div>
<!-- Bulk discount End-->