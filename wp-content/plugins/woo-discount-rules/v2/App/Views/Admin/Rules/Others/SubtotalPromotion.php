<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$operator = isset($options->operator) ? $options->operator : 'less_than';
$subtotal_promotion_from = isset($options->subtotal_promotion_from) ? $options->subtotal_promotion_from : false;
$subtotal_promotion_message = isset($options->subtotal_promotion_message) ? $options->subtotal_promotion_message : false;
echo ($render_saved_condition == true) ? '' : '<div class="wdr-subtotal-promo-messeage-main">';
?>

    <div class="wdr_subtotal_promotion_container" style="display: grid;">
        <label style="padding-bottom: 20px;"><b><?php _e('Promotion Message', WDR_TEXT_DOMAIN); ?></b></label>
        <div class="wdr_cart_subtotal_promo_from">
            <label class="awdr-left-align wdr_subtotal_promo_filed_name" style="padding-right: 5px;"><?php _e('Subtotal from', WDR_TEXT_DOMAIN); ?></label>
            <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][subtotal_promotion_from]"
                   type="text" class="float_only_field awdr-left-align"
                   value="<?php echo ($subtotal_promotion_from) ? $subtotal_promotion_from : '' ?>"
                   placeholder="<?php _e('0.00', WDR_TEXT_DOMAIN);?>"
                   min="0">
            <span class="wdr_desc_text awdr-clear-both"><?php _e('Set a threshold from which you want to start showing promotion message', WDR_TEXT_DOMAIN); ?></span>
            <span class="wdr_desc_text awdr-clear-both"><?php _e("<b>Example:</b> Let's say you offer a 10% discount for 1000 and above. you may want to set 900 here. So that the customer can see the promo text when his cart subtotal reaches 900", WDR_TEXT_DOMAIN); ?></span>
        </div>
        <div class="wdr_cart_subtotal_promo_msg">
            <p class="wdr_subtotal_promo_filed_name"><?php _e('Message', WDR_TEXT_DOMAIN); ?></p>
            <textarea
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][subtotal_promotion_message]"
                style="height: 60px;"
                placeholder="<?php _e('Spent {{difference_amount}} more and get 10% discount', WDR_TEXT_DOMAIN); ?>"><?php echo ($subtotal_promotion_message) ? $subtotal_promotion_message : ''; ?></textarea>
            <span class="wdr_desc_text awdr-clear-both"><?php _e('{{difference_amount}} -> Difference amount to get discount', WDR_TEXT_DOMAIN); ?></span>
            <span class="wdr_desc_text awdr-clear-both"><?php _e('<b>Eg:</b> Spent {{difference_amount}} more and get 10% discount', WDR_TEXT_DOMAIN); ?></span>
        </div>
    </div><?php
echo ($render_saved_condition == true) ? '' : '</div>'; ?>

