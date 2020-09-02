<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<tr>
    <td scope="row">
        <label for="free_shipping_title" class="awdr-left-align"><?php _e('Free shipping title', WDR_PRO_TEXT_DOMAIN) ?></label>
        <span class="wdr_desc_text awdr-clear-both"><?php esc_attr_e('Title for free shipping', WDR_PRO_TEXT_DOMAIN); ?></span>
    </td>
    <td>
        <input type="text" name="free_shipping_title"
               value="<?php echo $configuration->getConfig('free_shipping_title', 'Free shipping'); ?>">
    </td>
</tr>