<?php

namespace Wdr\App\Controllers\Admin\Tabs;

use Wdr\App\Controllers\Configuration;
use Wdr\App\Helpers\Rule;
use Wdr\App\Controllers\Admin\Tabs\Reports;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Statistics extends Base
{
    public $priority = 30;
    protected $tab = 'statistics';
    protected $reports;

    /**
     * GeneralSettings constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->title = __('Reports', WDR_TEXT_DOMAIN);

        $this->reports = array(
            'rule_amount' => array(
               'handler' => new Reports\RuleAmount(),
                'label'   => __( 'Rule amount', WDR_TEXT_DOMAIN ),
                'group'   => __( 'Rule', WDR_TEXT_DOMAIN ),
            ),
            'rule_amount_extra' => array(
                'handler' => new Reports\RuleAmountWithCartDiscount(),
                'label'   => __( 'Rule amount with cart discount', WDR_TEXT_DOMAIN ),
                'group'   => __( 'Rule', WDR_TEXT_DOMAIN ),
            ),
        );
    }

    /**
     * Render settings page
     * @param null $page
     * @return mixed|void
     */
    public function render($page = NULL)
    {

        $charts = array();
        foreach ( $this->reports as $k => $item ) {
            $group = $item['group'];
            if ( ! isset( $charts[ $group ] ) ) {
                $charts[ $group ] = array();
            }
            $charts[ $group ][ $k ] = $item['label'];
        }

        $params = array(
          'charts' => $charts,
        );
        self::$template_helper->setPath(WDR_PLUGIN_PATH . 'App/Views/Admin/Tabs/Statistics.php')->setData($params)->display();
    }

    /**
     * Get chart data for analytics
     */
    protected function ajax_get_chart_data() {
        parse_str( $_POST['params'], $params );
        $type = $params['type'];
        if ( isset( $this->reports[ $type ] ) ) {
            $handler = $this->reports[ $type ]['handler'];
            $data = $handler->get_data( $params );
            wp_send_json_success( $data );
        } else {
            wp_send_json_error();
        }
    }

}