<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="product_sku wdr-condition-type-options">
    <div class="product_sku_group products_group wdr-products_group">
        <div class="wdr-product_filter_method">
            <select name="filters[{i}][method]">
                <option value="in_list" selected><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
                <option value="not_in_list"><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            </select>
        </div>
        <div class="awdr-product-selector">
            <select multiple
                    data-list="product_sku"
                    data-field="autocomplete"
                    data-placeholder="<?php _e('Select SKUs', WDR_PRO_TEXT_DOMAIN);?>"
                    name="filters[{i}][value][]"
                    class="wdr_category_filter_value awdr_validation">
            </select>
        </div>
    </div>
</div>