<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$operator = isset($options->operator) ? $options->operator : 'custom_coupon';
$values = isset($options->value) ? $options->value : false;
$custom_value = isset($options->custom_value) ? $options->custom_value : false;
$coupon_msg = false;
if($custom_value){
    $coupon_msg = \Wdr\App\Helpers\Woocommerce::validateDynamicCoupon($custom_value);
}
echo ($render_saved_condition == true) ? '' : '<div class="cart_coupon">';
?>
    <div class="wdr_cart_coupon_group wdr-condition-type-options">
        <div class="wdr-cart-coupon wdr-select-filed-hight">
            <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="wdr_copon_type awdr-left-align">
                <option value="custom_coupon" <?php echo ($operator == "custom_coupon") ? "selected" : ""; ?>><?php _e('Create your own coupon ', WDR_PRO_TEXT_DOMAIN) ?></option>
                <!--<option value="at_least_one_any" <?php /*echo ($operator == "at_least_one_any") ? "selected" : ""; */?>><?php /*_e('at least one of any', WDR_PRO_TEXT_DOMAIN) */?></option>-->
                <option value="at_least_one" <?php echo ($operator == "at_least_one") ? "selected" : ""; ?>><?php _e('Apply if any one coupon is applied (Select from Woocommerce)', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="all" <?php echo ($operator == "all") ? "selected" : ""; ?>><?php _e('Apply if all coupon is applied (Select from Woocommerce)', WDR_PRO_TEXT_DOMAIN) ?></option>
               <!-- <option value="only" <?php /*echo ($operator == "only") ? "selected" : ""; */?>><?php /*_e('only selected', WDR_PRO_TEXT_DOMAIN) */?></option>
                <option value="none" <?php /*echo ($operator == "none") ? "selected" : ""; */?>><?php /*_e('none of selected', WDR_PRO_TEXT_DOMAIN) */?></option>-->
                <!--<option value="none_at_all" <?php /*echo ($operator == "none_at_all") ? "selected" : ""; */?>><?php /*_e('none at all', WDR_PRO_TEXT_DOMAIN) */?></option>-->
            </select>
            <span class="wdr_desc_text awdr-clear-both "><?php _e('select coupon by', WDR_PRO_TEXT_DOMAIN); ?></span>
        </div>
        <div class="wdr-cart-coupon-search wdr-coupon-search_box wdr-select-filed-hight"
             style="<?php echo ($operator != "custom_coupon" && $operator != "none_at_all" && $operator != "at_least_one_any") ? 'display: block' : 'display: none' ?>">
            <select multiple="" name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"
                    class="awdr-left-align <?php echo ($render_saved_condition == true) ? 'edit-filters' : '' ?>"
                    id="rm-coupon"
                    data-placeholder="<?php _e('Search Coupon', WDR_PRO_TEXT_DOMAIN);?>"
                    data-list="cart_coupon"
                    data-field="autocomplete"
                    style="width: 100%;min-width: 400%;">
                <?php
                if ($values) {
                    foreach ($values as $value) { ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
                    <?php }
                }
                ?>
            </select>
            <span class="wdr_desc_text awdr-clear-both "><?php _e('Select coupon', WDR_PRO_TEXT_DOMAIN); ?></span>
        </div>
        <div class="wdr-cart-coupon-value wdr-input-filed-hight"
             style="<?php echo ($operator == "custom_coupon") ? 'display: block' : 'display: none' ?>">
            <input class="coupon_name_msg awdr-left-align"
                    type="text"
                    name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][custom_value]"
                    placeholder="Coupon Name"
                    value="<?php if($custom_value){ echo $custom_value; }?>"
            >
            <span class="wdr_desc_text awdr-clear-both"><?php _e('Enter Coupon name', WDR_PRO_TEXT_DOMAIN); ?></span>
            <?php
            if(isset($coupon_msg['status']))
            if($coupon_msg['status'] == false && isset($coupon_msg['message']) && !empty($coupon_msg['message'])) { ?>
                <span class="wdr_desc_text coupon_error_msg" style="color: #FF0000"><?php echo $coupon_msg['message'] ?></span><?php
            }
            ?>
        </div>
    </div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>