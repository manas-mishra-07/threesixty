<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class OrderDate extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'order_date';
        $this->label = __('Date', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Date & Time', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/DateTime/date.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->from) && isset($options->to)) {
            $from = $options->from;
            $to = $options->to;
            if (!empty($from) && !empty($to)) {
                return ($this->doComparisionOperation('greater_than_or_equal', current_time('timestamp'), strtotime($from . ' 00:00:00')) && $this->doComparisionOperation('less_than_or_equal', current_time('timestamp'), strtotime($to . ' 23:59:59')));
            } elseif (!empty($from) && empty($to)) {
                return $this->doComparisionOperation('greater_than_or_equal', current_time('timestamp'), strtotime($from . ' 00:00:00'));
            } elseif (empty($from) && !empty($to)) {
                return $this->doComparisionOperation('less_than_or_equal', current_time('timestamp'), strtotime($to . ' 23:59:59'));
            } else {
                return false;
            }
        }
        return false;
    }
}