<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<!--Product Filter-->
<div class="wdr-filter-block" id="wdr-filter-block">
    <div class="wdr-block">
        <div class="wdr-row">
            <div class="wdr-filter-group-items">
                <input type="hidden" name="edit_rule"
                       value="<?php echo ($rule->getId()) ? $rule->getId() : ''; ?>"><?php
                if ($rule->hasFilter()) {
                    $filters = $rule->getFilter();
                    $filter_row_count = 1;
                    foreach ($filters as $filter) {
                        ?>
                        <div class="wdr-grid wdr-filter-group" data-index="<?php echo $filter_row_count; ?>">
                            <div class="wdr-filter-type">
                                <select name="filters[<?php echo $filter_row_count; ?>][type]"
                                        class="wdr-product-filter-type"><?php
                                    if (isset($product_filters) && !empty($product_filters)) {
                                        foreach ($product_filters as $wdr_filter_key => $wdr_filter_value) {
                                            ?>
                                            <optgroup label="<?php _e($wdr_filter_key, WDR_TEXT_DOMAIN); ?>" ><?php
                                            foreach ($wdr_filter_value as $key => $value) {
                                                ?>
                                                <option
                                                <?php
                                                if(isset($value['active']) && $value['active'] == false){
                                                    ?>
                                                    disabled="disabled"
                                                    <?php
                                                } else {
                                                    ?>
                                                    value="<?php echo $key; ?>"
                                                    <?php
                                                }
                                                ?>
                                                <?php echo ($filter->type == $key) ? 'selected' : ''; ?>><?php _e($value['label'], WDR_TEXT_DOMAIN); ?></option><?php
                                            } ?>
                                            </optgroup><?php
                                        }
                                    } ?>
                                </select>
                            </div>
                            <?php if ($filter->type != 'all_products') {?>
                                <div class="products_group wdr-products_group"><?php
                                    if(in_array($filter->type, array('products'))){
                                        ?>
                                        <div class="wdr-product_filter_method">
                                            <select name="filters[<?php echo $filter_row_count; ?>][method]">
                                                <option value="in_list"
                                                    <?php echo (isset($filter->method) && $filter->method == 'in_list') ? 'selected' : ''; ?>><?php _e('In List', WDR_TEXT_DOMAIN); ?></option>
                                                <option value="not_in_list" <?php echo (isset($filter->method) && $filter->method == 'not_in_list') ? 'selected' : ''; ?>><?php _e('Not In List', WDR_TEXT_DOMAIN); ?></option>
                                            </select>
                                        </div>
                                        <div class="awdr-product-selector">
                                            <?php
                                            $placeholder = '';
                                            $selected_options = '';
                                            if (!empty($filter->value) && is_array($filter->value)) {
                                                $item_name = '';

                                                foreach ($filter->value as $option) {
                                                    switch ($filter->type) {
                                                        case 'products':
                                                            $item_name = '#'.$option.' '.get_the_title($option);
                                                            $placeholder = 'Products';
                                                            break;
                                                    }
                                                    if (!empty($item_name)) {
                                                        $selected_options .= "<option value={$option} selected>{$item_name}</option>";
                                                    }
                                                }
                                            }
                                            ?>
                                            <select multiple
                                                    class="edit-filters awdr_validation"
                                                    data-list="<?php echo $filter->type; ?>"
                                                    data-field="autocomplete"
                                                    data-placeholder="<?php _e('Select ' . $placeholder, WDR_TEXT_DOMAIN); ?>"
                                                    name="filters[<?php echo $filter_row_count; ?>][value][]">
                                                <?php echo $selected_options; ?>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                    do_action('advanced_woo_discount_rules_admin_filter_fields', $rule, $filter, $filter_row_count);
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="wdr-btn-remove wdr_filter_remove">
                                <span class="dashicons dashicons-no-alt remove-current-row wdr-filter-alert"></span>
                            </div><?php
                            switch($filter->type) {
                                case "products": ?>
                                    <div class="wdr_filter_desc_text"><span><?php _e('Choose products that get the discount using "In List". If you want to exclude a few products, choose "Not In List" and select the products you wanted to exclude from discount. (You can add multiple filters)', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                case "product_category": ?>
                                    <div class="wdr_filter_desc_text"><span><?php _e('Choose categories that get the discount using "In List". If you want to exclude a few categories, choose "Not In List" and select the categories you wanted to exclude from discount. (You can add multiple filters of same type)', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                case "product_attributes": ?>
                                   <div class="wdr_filter_desc_text"><span><?php _e('Choose attributes that get the discount using "In List". If you want to exclude a few attributes, choose "Not In List" and select the attributes you wanted to exclude from discount. (You can add multiple filters of same type)', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                case "product_tags": ?>
                                    <div class="wdr_filter_desc_text"><span><?php _e('Choose tags that get the discount using "In List". If you want to exclude a few tags, choose "Not In List" and select the tags you wanted to exclude from discount. (You can add multiple filters of same type)', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                case "product_sku": ?>
                                    <div class="wdr_filter_desc_text"><span><?php _e('Choose SKUs that get the discount using "In List". If you want to exclude a few SKUs, choose "Not In List" and select the SKUs you wanted to exclude from discount. (You can add multiple filters of same type)', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                case "product_on_sale": ?>
                                    <div class="wdr_filter_desc_text"><span><?php _e('Choose whether you want to include (or exclude) products on sale (those having a sale price) for the discount ', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                case "all_products": ?>
                                    <div class="wdr_filter_desc_text"><span><?php _e('Discount applies to all eligible products in the store', WDR_TEXT_DOMAIN); ?></span></div>
                                    <?php break;
                                default:
                                 ?>
                                     <div class="wdr_filter_desc_text"><span><?php _e('Discount applies to custom taxonomy', WDR_TEXT_DOMAIN); ?></span></div>
                                 <?php break;
                            }
                            ?>
                        </div>
                        <?php
                        $filter_row_count++;
                    }
                } else { ?>
                    <div class="wdr-grid wdr-filter-group" data-index="1">
                        <div class="wdr-filter-type wdr-filter-all-product">
                            <select name="filters[1][type]" class="wdr-product-filter-type"><?php
                                if (isset($product_filters) && !empty($product_filters)) {
                                    foreach ($product_filters as $wdr_filter_key => $wdr_filter_value) {
                                        ?>
                                        <optgroup label="<?php _e($wdr_filter_key, WDR_TEXT_DOMAIN); ?>"><?php
                                        foreach ($wdr_filter_value as $key => $value) {
                                            ?>
                                            <option
                                            <?php
                                            if(isset($value['active']) && $value['active'] == false){
                                                ?>
                                                disabled="disabled"
                                                <?php
                                            } else {
                                                ?>
                                                value="<?php echo $key; ?>"
                                                <?php
                                            }
                                            ?>
                                            ><?php _e($value['label'], WDR_TEXT_DOMAIN); ?></option><?php
                                        } ?>
                                        </optgroup><?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="wdr-btn-remove wdr_filter_remove">
                            <span class="dashicons dashicons-no-alt remove-current-row wdr-filter-alert"></span>
                        </div>
                        <div class="wdr_filter_desc_text">
                            <span>
                                <?php _e('Discount applies to all eligible products in the store', WDR_TEXT_DOMAIN); ?>
                            </span>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="wdr-add-condition add-condition-and-filters">
            <button type="button"
                    class="button add-product-filter"><?php _e('Add filter', WDR_TEXT_DOMAIN); ?></button>
        </div>
    </div>
</div>

