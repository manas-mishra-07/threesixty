<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<tr class="" style="">
    <td scope="row">
        <label for="licence_key" class="awdr-left-align"><?php _e('Licence key', WDR_PRO_TEXT_DOMAIN) ?></label>
        <span class="wdr_desc_text awdr-clear-both"><?php esc_html_e('Add licence key to get auto update', WDR_PRO_TEXT_DOMAIN); ?></span>
    </td>
    <td>
        <input type="text" name="licence_key" id="awdr_licence_key"
               value="<?php echo $configuration->getConfig('licence_key', ''); ?>">
        <input type="button" id="validate_licence_key" class="button button-primary"
               value="<?php esc_html_e('Validate', WDR_PRO_TEXT_DOMAIN); ?>">
        <div class="validate_licence_key_status"><?php echo $licence_key_message; ?></div>
    </td>
</tr>