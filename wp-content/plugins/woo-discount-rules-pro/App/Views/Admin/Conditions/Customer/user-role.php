<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$operator = isset($options->operator) ? $options->operator : 'in_list';
$values = isset($options->value) ? $options->value : false;
$settings = new \Wdr\App\Controllers\Admin\Settings();
$user_roles = $settings->getUserRoles();
echo ($render_saved_condition == true) ? '' : '<div class="user_role">';
?>
<div class="wdr_user_role_group wdr-condition-type-options">
    <div class="wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('in list', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('not in list', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('user role should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="wdr_user_role <?php echo ($render_saved_condition == true) ? 'edit-all-loaded-values' : '' ?>"
                data-list="user_roles"
                data-field="autoloaded"
                data-placeholder="<?php _e('Search User Roles', WDR_PRO_TEXT_DOMAIN);?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                foreach ($values as $value) {
                    foreach ($user_roles as $user_key => $user_role) {
                        if ($user_role['id'] == $value) {
                            ?>
                            <option value="<?php echo $value; ?>" selected><?php echo $user_role['text']; ?></option>
                            <?php
                        }
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select User Roles', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
