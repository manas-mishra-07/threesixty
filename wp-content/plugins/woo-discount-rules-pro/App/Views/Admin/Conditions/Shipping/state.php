<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
echo ($render_saved_condition == true) ? '' : '<div class="shipping_state">';
$operator = isset($options->operator) ? $options->operator : 'in_list';
$values = isset($options->value) ? $options->value : false;
$get_state_list = \Wdr\App\Helpers\Woocommerce::getStatesList();
?>
<div class="wdr_shipping_state_group wdr-condition-type-options">
    <div class="wdr-shipping-state wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('States should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr-shipping-state-value wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="shipping_state <?php echo ($render_saved_condition == true) ? 'edit-preloaded-values' : '' ?>"
                data-list="states"
                data-field="preloaded"
                data-placeholder="<?php _e('Search State', WDR_PRO_TEXT_DOMAIN) ?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                $state_label = '';
                $get_state_list = \Wdr\App\Helpers\Woocommerce::getStatesList();
                foreach ($values as $value) {
                    $state_label = array_column($get_state_list, $value);
                    if (isset($state_label) && is_array($state_label) && $state_label != '') {
                        ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $state_label[0]; ?></option><?php
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select State', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>

