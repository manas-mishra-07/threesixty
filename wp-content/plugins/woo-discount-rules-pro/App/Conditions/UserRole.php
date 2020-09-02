<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class UserRole extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'user_role';
        $this->label = __('User role', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Customer', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Customer/user-role.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $user = (is_user_logged_in()) ? get_user_by('ID', get_current_user_id()) : NULL;
            if (!empty($user)) {
                $current_user_role = self::$woocommerce_helper->getRole($user);
                return $this->doCompareInListOperation($options->operator, $current_user_role, $options->value);
            } else {
                $current_user_role = array('woo_discount_rules_guest');
                return $this->doCompareInListOperation($options->operator, $current_user_role, $options->value);
            }
        }
        return false;
    }
}