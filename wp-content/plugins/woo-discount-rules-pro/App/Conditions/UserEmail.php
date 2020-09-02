<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class UserEmail extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'user_email';
        $this->label = __('Email', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Customer', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/Customer/user-email.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $post_data = $this->input->post('post_data');
            $post = array();
            if (!empty($post_data)) {
                parse_str($post_data, $post);
            }
            $user_email = NULL;
            if (isset($post['billing_email']) && !empty($post['billing_email'])) {
                $user_email = $post['billing_email'];
            } elseif (get_current_user_id()) {
                $user_email = get_user_meta(get_current_user_id(), 'billing_email', true);
                if (empty($user_email) || $user_email == '') {
                    $user = (is_user_logged_in()) ? get_user_by('ID', get_current_user_id()) : NULL;
                    if (!empty($user)) {
                        $user_email = isset($user->data->user_email) ? $user->data->user_email : NULL;
                    }
                }
            }
            if (!empty($user_email)) {
                $admin_values = explode(',', $options->value);
                if (is_array($admin_values) && !empty($admin_values)) {
                    foreach ($admin_values as $key => $value) {
                        $admin_values[$key] = trim(trim($value), '.');
                    }
                }
                switch ($options->operator) {
                    case "user_email_tld":
                        $email_part = $this->getTLDFromEmail($user_email);
                        break;
                    default:
                    case "user_email_domain":
                        $email_part = $this->getDomainFromEmail($user_email);
                        break;
                }
                return (in_array($email_part, $admin_values));
            }
        }
        return false;
    }

    /**
     * Get tld from email
     * @param $email
     * @return string
     */
    protected function getTLDFromEmail($email)
    {
        $emailArray = explode('@', $email);
        if (isset($emailArray[1])) {
            $emailDomainArray = explode('.', $emailArray[1]);
            if (count($emailDomainArray) > 1) {
                unset($emailDomainArray[0]);
            }
            return implode('.', $emailDomainArray);
        }
        return $emailArray[0];
    }

    /**
     * Get domain from email
     * @param $email
     * @return mixed
     */
    protected function getDomainFromEmail($email)
    {
        $emailArray = explode('@', $email);
        if (isset($emailArray[1])) {
            return $emailArray[1];
        }
        return $emailArray[0];
    }
}