<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
echo ($render_saved_condition == true) ? '' : '<div class="shipping_country">';
$operator = isset($options->operator) ? $options->operator : 'in_list';
$values = isset($options->value) ? $options->value : false;
?>
<div class="wdr_shipping_country_group wdr-condition-type-options">
    <div class="wdr-country-method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Countries should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr_country_value wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="shipping_country <?php echo ($render_saved_condition == true) ? 'edit-preloaded-values' : '' ?>"
                data-list="countries"
                data-field="preloaded"
                data-placeholder="<?php _e('Search Country', WDR_PRO_TEXT_DOMAIN) ?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                $countries_list = \Wdr\App\Helpers\Woocommerce::getCountriesList();
                foreach ($values as $value) {
                    if (isset($countries_list[$value])) {
                        ?>
                        <option value="<?php echo $value; ?>"
                                selected><?php echo $countries_list[$value]; ?></option><?php
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select Country', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
