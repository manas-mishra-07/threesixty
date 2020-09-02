<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$common_filters = array('product_category', 'product_attributes',
    'product_tags', 'product_sku');
$placeholder = '';
if (in_array($filter->type, $common_filters)) {
    ?>
    <div class="wdr-product_filter_method">
        <select name="filters[<?php echo $filter_row_count; ?>][method]">
            <option value="in_list"
                <?php echo (isset($filter->method) && $filter->method == 'in_list') ? 'selected' : ''; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo (isset($filter->method) && $filter->method == 'not_in_list') ? 'selected' : ''; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
    </div>
    <div class="awdr-product-selector">

    <?php
    $item_name = '';
    $selected_options = '';
    if (!empty($filter->value) && is_array($filter->value)) {
        foreach ($filter->value as $option) {
            switch ($filter->type) {
                case 'product_category':
                    $term_name = get_term_by('term_taxonomy_id', $option);
                    if (!empty($term_name)) {
                        $parant_name = '';
                        if(!empty($term_name->parent)){
                            if (function_exists('get_the_category_by_ID')) {
                                $parant_names = get_the_category_by_ID((int)$term_name->parent);
                                $parant_name = $parant_names . ' -> ';
                            }
                        }
                        $item_name = $parant_name.$term_name->name;
                        $placeholder = 'Categories';
                    }
                    break;
                case 'product_attributes':
                    global $wc_product_attributes;
                    foreach (array_keys($wc_product_attributes) as $att_key) {
                        $attribute_name = '';
                        $att_object = get_term_by('id', $option, $att_key);
                        $tax_attribute = isset($att_object->taxonomy) ? $att_object->taxonomy : '';
                        if(!empty($tax_attribute)) {
                           $attribute_name =  isset($wc_product_attributes[$tax_attribute]->attribute_label) ? $wc_product_attributes[$tax_attribute]->attribute_label. ': ' : '';
                        }
                        if (!empty($att_object) && is_object($att_object)) {
                            $item_name = $attribute_name.$att_object->name;
                        }
                    }
                    $placeholder = 'Attributes';
                    break;
                case 'product_tags':
                    $term_name = get_term_by('id', $option, 'product_tag');
                    if (!empty($term_name)) {
                        $item_name = $term_name->name;
                    }
                    $placeholder = 'Tags';
                    break;
                case  'product_sku':
                    $item_name = 'SKU: ' . $option;
                    $placeholder = 'SKUs';
                    break;
                default:
                    $term_name = get_term_by('id', $option, $filter->type);
                    if (!empty($term_name)) {
                        $item_name = $term_name->name;
                    }
                    $placeholder = 'Values';
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
            data-placeholder="<?php _e('Select ' . $placeholder, WDR_PRO_TEXT_DOMAIN); ?>"
            name="filters[<?php echo $filter_row_count; ?>][value][]">
        <?php echo $selected_options; ?>
    </select>
    </div><?php
} else if($filter->type == 'product_on_sale'){
    ?>
    <div class="wdr-product_filter_method">
        <select name="filters[<?php echo $filter_row_count; ?>][method]">
            <option value="in_list"
                <?php echo (isset($filter->method) && $filter->method == 'in_list') ? 'selected' : ''; ?>><?php _e('Include', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo (isset($filter->method) && $filter->method == 'not_in_list') ? 'selected' : ''; ?>><?php _e('Exclude', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
    </div>
    <?php
} else if (!empty($woocommerce_helper->getCustomProductTaxonomies())) {
    ?>
    <div class="wdr-product_filter_method">
        <select name="filters[<?php echo $filter_row_count; ?>][method]">
            <option value="in_list"
                <?php echo (isset($filter->method) && $filter->method == 'in_list') ? 'selected' : ''; ?>><?php _e('In List', WDR_PRO_TEXT_DOMAIN); ?></option>
            <option value="not_in_list" <?php echo (isset($filter->method) && $filter->method == 'not_in_list') ? 'selected' : ''; ?>><?php _e('Not In List', WDR_PRO_TEXT_DOMAIN); ?></option>
        </select>
    </div>
    <div class="awdr-product-selector">
        <?php
        if (!empty($filter->value) && is_array($filter->value)) {
            $item_name = '';
            $placeholder = '';
            $selected_options = '';
            foreach ($filter->value as $option) {
                $term_name = get_term_by('id', $option, $filter->type);
                if (!empty($term_name)) {
                    $parant_name = '';
                    if(!empty($term_name->parent)){
                        if (function_exists('get_the_category_by_ID')) {
                            $parant_names = get_the_category_by_ID((int)$term_name->parent);
                            $parant_name = $parant_names . ' -> ';
                        }
                    }
                    $item_name = $parant_name.$term_name->name;
                }
                $placeholder = 'Values';
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
                data-placeholder="<?php _e('Select ' . $placeholder, WDR_PRO_TEXT_DOMAIN); ?>"
                name="filters[<?php echo $filter_row_count; ?>][value][]">
            <?php echo $selected_options; ?>
        </select>
    </div>
    <?php
}
?>