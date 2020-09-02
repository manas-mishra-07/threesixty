<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$operator = isset($options->operator) ? $options->operator : 'less_than';
$order_status = isset($options->status) ? $options->status : false;
echo ($render_saved_condition == true) ? '' : '<div class="purchase_last_order_amount">';
?>
    <div class="wdr_purchase_last_order_amount_group wdr-condition-type-options">
        <div class="wdr-last-order-amount-method wdr-select-filed-hight">
            <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
                <option value="less_than" <?php echo ($operator == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="less_than_or_equal" <?php echo ($operator == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="greater_than_or_equal" <?php echo ($operator == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="greater_than" <?php echo ($operator == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', WDR_PRO_TEXT_DOMAIN) ?></option>
            </select>
            <span class="wdr_desc_text awdr-clear-both "><?php _e('order amount should be', WDR_PRO_TEXT_DOMAIN); ?></span>
        </div>

        <div class="wdr-last-order-amount-value wdr-input-filed-hight">
            <input name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]"
                   value="<?php echo (isset($options->value)) ? $options->value : '' ?>" type="text"
                   placeholder="<?php _e('0.00', WDR_PRO_TEXT_DOMAIN);?>" class="float_only_field awdr-left-align">
            <span class="wdr_desc_text awdr-clear-both "><?php _e('order amount', WDR_PRO_TEXT_DOMAIN); ?></span>
        </div>
        <div class="wdr-last-order-amount-product-status wdr-select-filed-hight wdr-search-box">
            <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][status][]" multiple
                    class="wdr-wc-order-status <?php echo ($render_saved_condition == true) ? 'edit-all-loaded-values' : '' ?>"
                    data-placeholder="<?php _e('Search Order Status', WDR_PRO_TEXT_DOMAIN);?>"
                    data-list="order_status"
                    data-field="autoloaded"
                    style="width: 100%; max-width: 400px;  min-width: 180px;"><?php
                if ($order_status) {
                    $settings_config = new \Wdr\App\Controllers\Admin\Settings();
                    $woo_order_status = $settings_config->getWoocommerceOrderStatus();
                    foreach ($order_status as $status) {
                        foreach ($woo_order_status as $woo_status) {
                            if ($woo_status['id'] == $status) {
                                $order_status_label = $woo_status['text'];
                            }
                        }
                        if ($order_status_label != '') { ?>
                            <option value="<?php echo $status; ?>"
                                    selected><?php echo $order_status_label; ?></option><?php
                        }
                    }
                }
                ?>
            </select>
            <span class="wdr_select2_desc_text"><?php _e('order status', WDR_PRO_TEXT_DOMAIN); ?></span>
        </div>
    </div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>