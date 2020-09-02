<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="product_category wdr-condition-type-options">
    <div class="product_category_group products_group wdr-products_group">
        <div class="wdr-product_filter_method">
            <select name="filters[{i}][method]">
                <option value="in_list" selected><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
                <option value="not_in_list"><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            </select>
        </div>
        <div class="awdr-product-selector">
            <select multiple
                    class="awdr_validation"
                    data-list="product_category"
                    data-field="autocomplete"
                    data-placeholder="<?php _e('Select Categories', WDR_PRO_TEXT_DOMAIN);?>"
                    name="filters[{i}][value][]">
            </select>
        </div>
    </div>
</div>