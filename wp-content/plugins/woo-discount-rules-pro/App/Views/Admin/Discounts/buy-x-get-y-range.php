<?php
if (!defined('ABSPATH')) {
    exit;
}
$class_name = '';
if(isset($get_buyx_gety_types) && $get_buyx_gety_types == 'bxgy_all'){
    $class_name = 'awdr-bygy-all';
}else if(isset($get_buyx_gety_types) && ($get_buyx_gety_types == 'bxgy_product' || $get_buyx_gety_types == 'bxgy_category')){
    $class_name = 'awdr-bygy-cat-products';
}
?>
<div class="wdr-discount-group buyx_gety_individual_range" data-index="<?php echo $buyx_gety_index; ?>">
    <div class="range_setter_inner">
        <div class="wdr-buyx-gety-discount-main">
            <div class="wdr-buyx-gety-discount-inner wdr-input-filed-hight" style="border-bottom:1px solid #ddd">
                <div class="dashicons dashicons-menu bxgy-icon <?php echo $class_name;?>"></div>
               <fieldset>
                   <legend><?php _e('Buy Quantity', WDR_PRO_TEXT_DOMAIN); ?></legend>
                <div class="awdr-buyx-gety-min">
                    <input type="number" name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][from]"
                           class="awdr-buyx-gety-number-box awdr_value_selector awdr_next_value bxgy-min"
                           placeholder="<?php _e('Min Quantity', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php echo (isset($buyx_gety_adjustment->from) && !empty($buyx_gety_adjustment->from)) ? $buyx_gety_adjustment->from : '1'; ?>"
                    >
                    <span class="wdr_desc_text"><?php echo (isset($buyx_gety_adjustment->recursive) && !empty($buyx_gety_adjustment->recursive)) ? __('Quantity', WDR_PRO_TEXT_DOMAIN) : __('Minimum Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>

                <div class="awdr-buyx-gety-max" style="<?php echo (isset($buyx_gety_adjustment->recursive) && !empty($buyx_gety_adjustment->recursive)) ? 'display:none' : ''; ?>">
                    <input type="number" name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][to]"
                           class="awdr-buyx-gety-number-box awdr_value_selector awdr_auto_add_value bxgy-max"
                           placeholder="<?php _e('Max Quantity', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php
                           if(isset($buyx_gety_adjustment->to) && !empty($buyx_gety_adjustment->to)){
                               $buyx_gety_adjustment_to = $buyx_gety_adjustment->to;
                           }elseif(isset($buyx_gety_adjustment->from) && isset($buyx_gety_adjustment->to) && !empty($buyx_gety_adjustment->from) && empty($buyx_gety_adjustment->to)){
                               $buyx_gety_adjustment_to = '';
                           }else{
                               $buyx_gety_adjustment_to = 1;
                           }
                           echo $buyx_gety_adjustment_to;
                           ?>"
                    >
                    <span class="wdr_desc_text"><?php _e('Maximum Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
               </fieldset>
                <fieldset>
                <legend><?php _e('Get Quantity', WDR_PRO_TEXT_DOMAIN); ?></legend>
                <div class="awdr-buyx-gety-product wdr-select-filed-hight wdr-search-box bxgy_product"
                     style="vertical-align: bottom;<?php echo ($get_buyx_gety_types != 'bxgy_product') ? 'display: none;' : '' ?>">
                    <select multiple
                            class="bxgy-product-selector"
                            data-list="products"
                            data-field="autocomplete"
                            data-placeholder="<?php _e('Select Product', WDR_PRO_TEXT_DOMAIN) ?>"
                            name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][products][]"><?php
                        if (isset($buyx_gety_adjustment->products) && !empty($buyx_gety_adjustment->products)) {
                            $item_name = '';
                            foreach ($buyx_gety_adjustment->products as $product_id) {
                                $item_name = '#'.$product_id.' '.get_the_title($product_id);
                                if ($item_name != '') { ?>
                                    <option value="<?php echo $product_id; ?>"
                                            selected><?php echo $item_name; ?></option><?php
                                }
                            }
                        }
                        ?>
                    </select>
                    <span class="wdr_desc_text"><?php _e('Product', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-buyx-gety-category wdr-select-filed-hight wdr-cart-search_box bxgy_category"
                     style="vertical-align: bottom;min-width: 250px; <?php echo ($get_buyx_gety_types != 'bxgy_category') ? 'display: none;' : '' ?>">
                    <?php $values = isset($buyx_gety_adjustment->categories) ? $buyx_gety_adjustment->categories : array(); ?>
                    <select multiple
                            class="bxgy-category-selector"
                            data-list="product_category"
                            data-field="autocomplete"
                            data-placeholder="<?php _e('Search Categories', WDR_PRO_TEXT_DOMAIN); ?>"
                            name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][categories][]"><?php
                        if ($values) {
                            $item_name = '';
                            foreach ($values as $value) {
                                $term_name = get_term_by('id', $value, 'product_cat');
                                if (!empty($term_name)) {
                                    $parant_name = '';
                                    if(isset($term_name->parent) && !empty($term_name->parent)){
                                        if (function_exists('get_the_category_by_ID')) {
                                            $parant_names = get_the_category_by_ID((int)$term_name->parent);
                                            $parant_name = $parant_names . ' -> ';
                                        }
                                    }
                                    $item_name = $parant_name.$term_name->name; ?>
                                    <option value="<?php echo $value; ?>"
                                            selected><?php echo $item_name; ?></option><?php
                                }
                            }
                        }
                        ?>
                    </select>
                    <span class="wdr_desc_text awdr-clear-both "><?php _e('Select categories', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-buyx-gety-free-qty">
                    <input type="number"
                           name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][free_qty]"
                           class="awdr-buyx-gety-number-box awdr_value_selector bxgy-qty"
                           placeholder="<?php _e('Free Quantity', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php echo (isset($buyx_gety_adjustment->free_qty) && !empty($buyx_gety_adjustment->free_qty)) ? $buyx_gety_adjustment->free_qty : '1'; ?>"
                    >
                    <span class="wdr_desc_text"><?php _e('Free Quantity', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                </fieldset>
                <div class="awdr-buyx-gety-option wdr-select-filed-hight">
                    <select name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][free_type]"
                            class="awdr-bogo-discount-type buyx_gety_discount_select"
                            data-parent="awdr-buyx-gety-option"
                            data-siblings="awdr-gety-value">
                        <option value="free_product" <?php echo (isset($buyx_gety_adjustment->free_type) && $buyx_gety_adjustment->free_type == 'free_product') ? 'selected' : ''; ?>><?php _e('Free', WDR_PRO_TEXT_DOMAIN) ?></option>
                        <option value="percentage" <?php echo (isset($buyx_gety_adjustment->free_type) && $buyx_gety_adjustment->free_type == 'percentage') ? 'selected' : ''; ?>><?php _e('Percentage discount', WDR_PRO_TEXT_DOMAIN) ?></option>
                        <option value="flat" <?php echo (isset($buyx_gety_adjustment->free_type) && $buyx_gety_adjustment->free_type == 'flat') ? 'selected' : ''; ?>><?php _e('Fixed discount', WDR_PRO_TEXT_DOMAIN) ?></option>
                    </select>
                    <span class="wdr_desc_text"><?php _e('Discount type ', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-gety-value"
                     style="<?php echo (isset($buyx_gety_adjustment->free_type) && $buyx_gety_adjustment->free_type != 'free_product') ? '' : 'display: none;'; ?>">
                    <input type="number"
                           name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][free_value]"
                           class="awdr-buyx-gety-number-box awdr_value_selector bxgy-val"
                           placeholder="<?php _e('Value', WDR_PRO_TEXT_DOMAIN); ?>" min="0" step="any"
                           value="<?php echo (isset($buyx_gety_adjustment->free_value) && !empty($buyx_gety_adjustment->free_value)) ? $buyx_gety_adjustment->free_value : ''; ?>"
                    >
                    <span class="wdr_desc_text"><?php echo (isset($buyx_gety_adjustment->free_type) && $buyx_gety_adjustment->free_type == 'flat') ? __('Discount value ', WDR_PRO_TEXT_DOMAIN) : __('Discount percentage ', WDR_PRO_TEXT_DOMAIN); ?></span>
                </div>
                <div class="awdr-buyx-gety-recursive">
                    <?php //echo "<pre>"; var_dump($buyx_gety_adjustment); echo "</pre>";?>
                    <div class="page__toggle">
                        <label class="toggle">
                            <input class="toggle__input awdr-bogo-recurcive" type="checkbox"
                                   name="buyx_gety_adjustments[ranges][<?php echo $buyx_gety_index; ?>][recursive]"
                                   data-recursive-row="buyx_gety_individual_range"
                                   data-recursive-parent="awdr-buyx-gety-recursive"
                                   data-hide-add-range="hide_gety_recursive"
                                   data-bogo-max-range="awdr-buyx-gety-max"
                                   data-bogo-min-range="awdr-buyx-gety-min"
                                   data-bogo-border="wdr-buyx-gety-discount-inner"
                                   value="1" <?php echo (isset($buyx_gety_adjustment->recursive) && !empty($buyx_gety_adjustment->recursive)) ? 'checked' : ''; ?>>
                            <span class="toggle__label">
                                <span class="toggle__text"><?php _e('Recursive?', WDR_PRO_TEXT_DOMAIN); ?></span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="wdr-btn-remove" style="vertical-align: middle;">
                                                    <span class="dashicons dashicons-no-alt wdr_discount_remove"
                                                          data-rmdiv="bulk_range_group"></span>
                </div>
            </div>
        </div>
    </div>
</div>