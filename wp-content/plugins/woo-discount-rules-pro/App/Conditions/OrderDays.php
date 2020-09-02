<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class OrderDays extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'order_days';
        $this->label = __('Days', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Date & Time', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/DateTime/days.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->value) && isset($options->operator)) {
            $day = strtolower(date('l', current_time('timestamp')));
            return $this->doCompareInListOperation($options->operator, $day, $options->value);
        }
        return false;
    }
}