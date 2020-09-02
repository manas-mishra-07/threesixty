<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$operator = isset($options->operator) ? $options->operator : 'in_list';
$values = isset($options->value) ? $options->value : false;
echo ($render_saved_condition == true) ? '' : '<div class="user_list">';
?>
<div class="wdr_user_list_group wdr-condition-type-options">
    <div class="wdr_operator wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('in list', WDR_PRO_TEXT_DOMAIN) ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('not in list', WDR_PRO_TEXT_DOMAIN) ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('User should be', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>

    <div class="wdr_value wdr-select-filed-hight wdr-search-box">
        <select multiple
                class="wdr_user_list <?php echo ($render_saved_condition == true) ? 'edit-filters' : ''; ?>"
                data-list="users_list"
                data-field="autocomplete"
                data-placeholder="<?php _e('Search User', WDR_PRO_TEXT_DOMAIN);?>"
                name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"><?php
            if ($values) {
                $users = get_users(array('fields' => array('ID', 'user_nicename'), 'orderby' => 'user_nicename'));
                $user_name = '';
                foreach ($values as $value) {
                    foreach ($users as $user) {
                        if ($user->ID == $value) {
                            $user_name = $user->user_nicename;
                        }
                    }
                    if ($user_name != '') {
                        ?>
                        <option value="<?php echo $value ?>" selected><?php echo $user_name; ?></option>
                        <?php
                    }
                }
            }
            ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select User', WDR_PRO_TEXT_DOMAIN); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
