<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class UserLoggedIn extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'user_logged_in';
        $this->label = __('Is logged in', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Customer', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Customer/is-logged-in.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value)) {
            $is_user_logged_in = (is_user_logged_in()) ? 'yes' : 'no';
            return ($options->value == $is_user_logged_in);
        }
        return false;
    }
}