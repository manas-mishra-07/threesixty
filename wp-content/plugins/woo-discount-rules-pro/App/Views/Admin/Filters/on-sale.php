<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="product_on_sale wdr-condition-type-options">
    <div class="products_group wdr-products_group">
        <div class="wdr-product_filter_method">
            <select name="filters[{i}][method]">
                <option value="not_in_list" selected><?php _e('Exclude', WDR_PRO_TEXT_DOMAIN); ?></option>
                <option value="in_list"><?php _e('Include', WDR_PRO_TEXT_DOMAIN); ?></option>
                <!--<option value="exclude"><?php /*_e('Exclude Product', WDR_PRO_TEXT_DOMAIN); */?></option>-->
            </select>
        </div>
        <!--<div class="wdr-product-selector">
            <select multiple="" name="filters[{i}][value][]"
                    data-placeholder="<?php /*_e('Select values', WDR_PRO_TEXT_DOMAIN);*/?>"
                    data-list="products"
                    data-field="autocomplete"
                    style="width: 100%; max-width: 400px;  min-width: 180px;">
            </select>
        </div>-->
    </div>
</div>