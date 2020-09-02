<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}?>
<div class="awdr-select-free-variant-product-toggle"><?php _e('Change Variant', WDR_PRO_TEXT_DOMAIN) ?></div>
<div class="awdr-select-variant-product">
<?php
foreach ($available_products as $available_product) { //parent_id
    if ($available_product != $customer_product_choice['chosen']) {
        $product_variation = new WC_Product_Variation( $available_product );
        // get variation featured image
        $variation_image = $product_variation->get_image(array( 50, 50));
        ?>
        <div class="awdr_free_product_variants">
            <span class="awdr_change_product" data-pid="<?php echo $available_product; ?>"
                data-rule_id="<?php echo $customer_product_choice['matched_rule_identification']; ?>"
                data-parent_id="<?php echo $customer_product_choice['parent_product_id']; ?>"><span class="awdr_variation_image"><?php echo $variation_image; ?></span><span class="awdr-product-name"><?php echo  get_the_title($available_product); ?></span></span>
        </div>
        <?php
    }
}
/*echo "<pre>";
print_r($available_products);
echo "</pre>";
echo "<pre>";
print_r($customer_product_choice);
echo "</pre>";*/
?>
</div>

