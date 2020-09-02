<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<tr class="" style="">
    <td scope="row">
        <label for="applied_rule_message" class="awdr-left-align"><?php _e('Banner Content', WDR_PRO_TEXT_DOMAIN) ?></label>
        <span class="wdr_desc_text awdr-clear-both"><?php _e('A static banner you that you want to display in your storefront. <br><br> <b>NOTE:</b> It is a static banner. You can use any content or html here.', WDR_PRO_TEXT_DOMAIN); ?></span>
    </td>
    <td>
        <?php
        $banner_content = $configuration->getConfig('awdr_banner_editor', '');
        $editor_id = 'awdr_banner_editor';
        wp_editor($banner_content, $editor_id);
        ?>
    </td>
</tr>

<tr class="" style="">
    <td scope="row">
        <label for="applied_rule_message" class="awdr-left-align"><?php _e('Banner Content display position', WDR_PRO_TEXT_DOMAIN) ?></label>
        <span class="wdr_desc_text awdr-clear-both"><?php esc_attr_e('Choose a display position for the banner in your storefront', WDR_PRO_TEXT_DOMAIN); ?></span>
    </td>
    <td>
        <select name="display_banner_text[]" multiple
                class="edit-all-loaded-values"
                data-list="banner_position"
                data-field="autoloaded"
                data-placeholder="<?php _e('Choose Position', WDR_PRO_TEXT_DOMAIN) ?>"><?php
            $values = $configuration->getConfig('display_banner_text', '');
            if ($values !='' && is_array($values) && !empty($values)) {
                $settings_config = new \Wdr\App\Controllers\Admin\Settings();
                $banner_positions = $settings_config->getBannerPosition();
                foreach ($values as $value) {
                    $awdr_banner_position = '';
                    foreach ($banner_positions as $banner_position) {
                        if ($value == $banner_position['id']) {
                            $awdr_banner_position = $banner_position['text'];
                        }
                    }
                    if ($awdr_banner_position != '') {
                        ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $awdr_banner_position; ?></option><?php
                    }
                }
            }
            ?>
        </select>
        <span class="banner-short-code-setting">
                            <b><?php _e('(or)', WDR_PRO_TEXT_DOMAIN) ?></b>
            <?php _e('Use Short Code ', WDR_PRO_TEXT_DOMAIN) ?><b> [awdr_banner_content]</b></span>
    </td>
</tr>
