<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class UserList extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'user_list';
        $this->label = __('User', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Customer', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Customer/user.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $user_id = (is_user_logged_in()) ? get_current_user_id() : 0;
            return $this->doCompareInListOperation($options->operator, $user_id, $options->value);
        }
        return false;
    }
}