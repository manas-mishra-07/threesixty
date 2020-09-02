<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;

class OrderTime extends Base
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'order_time';
        $this->label = __('Time', WDR_PRO_TEXT_DOMAIN);
        $this->group = __('Date & Time', WDR_PRO_TEXT_DOMAIN);
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/DateTime/time.php';
    }

    public function check($cart, $options)
    {
        if (isset($options->from) && isset($options->to)) {
            $date = date('Y-m-d', current_time('timestamp'));
            $from = $date . ' ' . $options->from;
            $to = $date . ' ' . $options->to;
            if (!empty($from) && !empty($to)) {
                return ($this->doComparisionOperation('greater_than_or_equal', current_time('timestamp'), strtotime($from)) && $this->doComparisionOperation('less_than_or_equal', current_time('timestamp'), strtotime($to)));
            } elseif (!empty($from) && empty($to)) {
                return $this->doComparisionOperation('greater_than_or_equal', current_time('timestamp'), strtotime($from));
            } elseif (empty($from) && !empty($to)) {
                return $this->doComparisionOperation('less_than_or_equal', current_time('timestamp'), strtotime($to));
            } else {
                return false;
            }
        }
        return false;
    }
}