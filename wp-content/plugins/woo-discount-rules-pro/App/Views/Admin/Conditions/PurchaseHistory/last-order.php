<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$operator = isset($options->operator) ? $options->operator : 'later';
$values = isset($options->value) ? $options->value : 'now';
$order_status = isset($options->status) ? $options->status : false;
echo ($render_saved_condition == true) ? '' : '<div class="purchase_last_order">';
?>
<div class="wdr_purchase_last_order_group wdr-condition-type-options">
    <div class="wdr-lastorder-method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="later" <?php echo ($operator == "later") ? "selected" : ""; ?>><?php _e('within past', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="earlier" <?php echo ($operator == "earlier") ? "selected" : ""; ?>><?php _e('earlier than', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('order should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr-last-order-value wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value]" class="awdr-left-align">
            <optgroup label="<?php _e('Current', WDR_PRO_TEXT_DOMAIN) ?>">
                <option value="now" <?php echo ($values == "now") ? "selected" : ""; ?>><?php _e('current day', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="this_week" <?php echo ($values == "this_week") ? "selected" : ""; ?>><?php _e('current week', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="first_day_of_this_month" <?php echo ($values == "first_day_of_this_month") ? "selected" : ""; ?>><?php _e('current month', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="first_day_of_january_this_year" <?php echo ($values == "first_day_of_january_this_year") ? "selected" : ""; ?>><?php _e('current year', WDR_PRO_TEXT_DOMAIN) ?></option>
            </optgroup>
            <optgroup label="<?php _e('Days', WDR_PRO_TEXT_DOMAIN) ?>">
                <option value="-1_day" <?php echo ($values == "-1_day") ? "selected" : ""; ?>>
                    1 <?php _e('day', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-2_days" <?php echo ($values == "-2_days") ? "selected" : ""; ?>>
                    2 <?php _e('days', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-3_days" <?php echo ($values == "-3_days") ? "selected" : ""; ?>>
                    3 <?php _e('days', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-4_days" <?php echo ($values == "-4_days") ? "selected" : ""; ?>>
                    4 <?php _e('days', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-5_days" <?php echo ($values == "-5_days") ? "selected" : ""; ?>>
                    5 <?php _e('days', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-6_days" <?php echo ($values == "-6_days") ? "selected" : ""; ?>>
                    6 <?php _e('days', WDR_PRO_TEXT_DOMAIN) ?></option>
            </optgroup>
            <optgroup label="<?php _e('Weeks', WDR_PRO_TEXT_DOMAIN) ?>">
                <option value="-1_week" <?php echo ($values == "-1_week") ? "selected" : ""; ?>>
                    1 <?php _e('week', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-2_weeks" <?php echo ($values == "-2_weeks") ? "selected" : ""; ?>>
                    2 <?php _e('weeks', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-3_weeks" <?php echo ($values == "-3_weeks") ? "selected" : ""; ?>>
                    3 <?php _e('weeks', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-4_weeks" <?php echo ($values == "-4_weeks") ? "selected" : ""; ?>>
                    4 <?php _e('weeks', WDR_PRO_TEXT_DOMAIN) ?></option>
            </optgroup>
            <optgroup label="<?php _e('Months', WDR_PRO_TEXT_DOMAIN) ?>">
                <option value="-1_month" <?php echo ($values == "-1_month") ? "selected" : ""; ?>>
                    1 <?php _e('month', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-2_months" <?php echo ($values == "-2_months") ? "selected" : ""; ?>>
                    2 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-3_months" <?php echo ($values == "-3_months") ? "selected" : ""; ?>>
                    3 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-4_months" <?php echo ($values == "-4_months") ? "selected" : ""; ?>>
                    4 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-5_months" <?php echo ($values == "-5_months") ? "selected" : ""; ?>>
                    5 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-6_months" <?php echo ($values == "-6_months") ? "selected" : ""; ?>>
                    6 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-7_months" <?php echo ($values == "-7_months") ? "selected" : ""; ?>>
                    7 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-8_months" <?php echo ($values == "-8_months") ? "selected" : ""; ?>>
                    8 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-9_months" <?php echo ($values == "-9_months") ? "selected" : ""; ?>>
                    9 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-10_months" <?php echo ($values == "-10_months") ? "selected" : ""; ?>>
                    10 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-11_months" <?php echo ($values == "-11_months") ? "selected" : ""; ?>>
                    11 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-12_months" <?php echo ($values == "-12_months") ? "selected" : ""; ?>>
                    12 <?php _e('months', WDR_PRO_TEXT_DOMAIN) ?></option>
            </optgroup>
            <optgroup label="<?php _e('Years', WDR_PRO_TEXT_DOMAIN) ?>">
                <option value="-2_years" <?php echo ($values == "-2_years") ? "selected" : ""; ?>>
                    2 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-3_years" <?php echo ($values == "-3_years") ? "selected" : ""; ?>>
                    3 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-4_years" <?php echo ($values == "-4_years") ? "selected" : ""; ?>>
                    4 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-5_years" <?php echo ($values == "-5_years") ? "selected" : ""; ?>>
                    5 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-6_years" <?php echo ($values == "-6_years") ? "selected" : ""; ?>>
                    6 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-7_years" <?php echo ($values == "-7_years") ? "selected" : ""; ?>>
                    7 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-8_years" <?php echo ($values == "-8_years") ? "selected" : ""; ?>>
                    8 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-9_years" <?php echo ($values == "-9_years") ? "selected" : ""; ?>>
                    9 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
                <option value="-10_years" <?php echo ($values == "-10_years") ? "selected" : ""; ?>>
                    10 <?php _e('years', WDR_PRO_TEXT_DOMAIN) ?></option>
            </optgroup>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('order time', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
    <div class="wdr-last-order-product-status wdr-select-filed-hight wdr-search-box">
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
                        <option value="<?php echo $status; ?>" selected><?php echo $order_status_label; ?></option><?php
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('order status', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
