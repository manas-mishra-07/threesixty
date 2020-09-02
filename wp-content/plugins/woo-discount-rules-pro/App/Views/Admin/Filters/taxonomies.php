<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
foreach (\Wdr\App\Helpers\Woocommerce::getCustomProductTaxonomies() as $taxonomy): ?>
    <div class="<?php echo $taxonomy->name; ?>  wdr-condition-type-options" >
        <div class="<?php echo 'custom_taxonomy_' . $taxonomy->name . '_group'; ?> products_group wdr-products_group" >
            <div class="wdr-product_filter_method">
                <select name="filters[{i}][method]">
                    <option value="in_list"
                            selected><?php _e('In list', WDR_PRO_TEXT_DOMAIN) ?></option>
                    <option value="not_in_list"><?php _e('Not in list', WDR_PRO_TEXT_DOMAIN) ?></option>
                </select>
            </div>

            <div class="awdr-product-selector">
                <select multiple
                        class="awdr_validation"
                        data-list="product_taxonomies"
                        data-taxonomy="<?php echo $taxonomy->name; ?>"
                        data-field="autocomplete"
                        data-placeholder="<?php _e('Select values', WDR_PRO_TEXT_DOMAIN);?>"
                        name="filters[{i}][value][]">
                </select>
            </div>
        </div>
    </div>
<?php endforeach; ?>