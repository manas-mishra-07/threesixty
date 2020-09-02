<?php
namespace Wdr\App\Controllers\Admin\Tabs;

use Wdr\App\Helpers\Rule;

if (!defined('ABSPATH')) exit;

class ImportExport extends Base
{
    public $priority = 40;
    protected $tab = 'importexport';

    /**
     * GeneralSettings constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->title = __('Export', WDR_TEXT_DOMAIN);
    }

    /**
     * Render Import Export page
     * @param null $page
     * @return mixed|void
     */
    public function render($page = NULL)
    {
        $rule_helper = new Rule();
        $params = array(
            'rules' => $rule_helper->exportRuleByName('all'),
        );
        self::$template_helper->setPath(WDR_PLUGIN_PATH . 'App/Views/Admin/Tabs/ImportExport.php')->setData($params)->display();
    }
}