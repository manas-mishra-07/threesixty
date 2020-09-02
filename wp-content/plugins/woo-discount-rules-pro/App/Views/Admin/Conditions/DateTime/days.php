<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$values = isset($options->value) ? $options->value : false;
$operator = isset($options->operator) ? $options->operator : 'in_list';
echo ($render_saved_condition == true) ? '' : '<div class="order_days">';
?>
<div class="wdr_days_group wdr-condition-type-options">
    <div class="wdr-days-method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Day should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr-days-value wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="order_days <?php echo ($render_saved_condition == true) ? 'edit-all-loaded-values' : '' ?>"
                data-list="weekdays"
                data-field="autoloaded"
                data-placeholder="<?php _e('Search Days', WDR_PRO_TEXT_DOMAIN) ?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                $settings_config = new \Wdr\App\Controllers\Admin\Settings();
                $week_days = $settings_config->getWeekDays();
                $week_day_label = '';
                foreach ($values as $value) {
                    foreach ($week_days as $week_day) {
                        if ($value == $week_day['id']) {
                            $week_day_label = $week_day['text'];
                        }
                    }
                    if ($week_day_label != '') {
                        ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $week_day_label; ?></option><?php
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select Days', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
