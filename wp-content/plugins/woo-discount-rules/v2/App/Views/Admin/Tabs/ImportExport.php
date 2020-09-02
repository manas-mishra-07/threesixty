<?php
if (!defined('ABSPATH')) exit;

function forceDownloadFile($filepath)
{
    header('Location: ' . $filepath);
    return true;
} ?>
<br>
<div class="wdr_settings ui-page-theme-a awdr-container">
    <div class="wdr_settings_container">
        <div>
            <h3><?php _e('Export tool', WDR_TEXT_DOMAIN);?></h3>
            <div>
                <p>
                    <!--<select id="wdr-export-select">
                        <optgroup label="Rules">
                            <option value="all">All Rules</option>
                        </optgroup>
                        <optgroup label="Rule Title"><?php
                    /*                            $json_array = array();
                                                if($rules){
                                                    $rule_items = array();
                                                    foreach ($rules as $rule_row) {*/ ?>
                                    <option value="<?php /*echo $rule_row->id; */ ?>"><?php /*echo $rule_row->title; */ ?></option><?php
                    /*                                    $rule_items[] = $rule_row;
                                                    }
                                                }*/ ?>
                        </optgroup>
                    </select>--><?php
                    if (isset($_POST['wdr-export'])) {
                        $file_name = 'advanced-discount-rules-' . date("Y-m-d-h-i-a") . '.csv';
                        if (!file_exists(WDR_PLUGIN_PATH . 'Export')) {
                            if(!mkdir(WDR_PLUGIN_PATH . 'Export', 0777, true)){?>
                                <h4><?php _e('Oops!. Download failed!!', WDR_TEXT_DOMAIN);?></h4><?php
                                return false;
                            }
                        }
                        $file_path = WDR_PLUGIN_PATH . 'Export/' . $file_name;
                        $file = fopen($file_path, "w");
                        fputcsv($file, array('id', 'enabled', 'deleted', 'exclusive', 'title', 'priority', 'apply_to', 'filters', 'conditions', 'product_adjustments', 'cart_adjustments', 'buy_x_get_x_adjustments', 'buy_x_get_y_adjustments', 'bulk_adjustments', 'set_adjustments', 'other_discounts', 'date_from', 'date_to', 'usage_limits', 'rule_language', 'used_limits', 'additional', 'max_discount_sum', 'advanced_discount_message', 'discount_type', 'used_coupons'));
                        foreach ($rules as $rule_row) {
                            $row_data = (array)$rule_row;
                            fputcsv($file, $row_data);
                        }
                        fclose($file);

                        $filepath = WDR_PLUGIN_URL . 'Export/' . $file_name;
                        $rm_dir = WDR_PLUGIN_PATH . 'Export';
                        if (forceDownloadFile($filepath)) {
                            rmdir(WDR_PLUGIN_PATH . 'Export');
                        }else{?>
                            <h4><?php _e('Oops!. Download failed!!', WDR_TEXT_DOMAIN);?></h4><?php
                            return false;
                        }
                    }
                    ?>
                <form method="post">
                    <button type="submit" id="wdr-export" name="wdr-export" class="button button-primary">
                        <?php _e('Export', WDR_TEXT_DOMAIN);?>
                    </button>
                </form>
                </p>

            </div>
        </div><?php
/*        if (isset($_POST['wdr_import'])) {

            if (isset($_FILES["import_rules"]["name"]) && !empty($_FILES["import_rules"]["name"])) {
                $file_name = $_FILES["import_rules"]["name"];
                $ext_info = new SplFileInfo($file_name);
                if ($ext_info->getExtension() == 'csv') {
                    $file = fopen($_FILES['import_rules']['tmp_name'], "r");
                    if( $file  !== FALSE ){
                    while($csv_row =  fgetcsv($file, 1000, ",")) {
                        $rule_helper = new \Wdr\App\Helpers\Rule();
                        $rule_helper->importCsvRules($csv_row, $this->input->post('wdp_import_data_reset_rules'));
                    }
                  }
                   fclose($file);
                } else {
                    echo "Error: Please Upload only CSV File";
                }
            }
        }
        */?>
        <!--<form method="post" enctype="multipart/form-data">
            <div>
                <h3>Import tool</h3>
                <div>
                    <div>
                        <p>
                            <input type="file" name="import_rules"/>
                        </p>
                        <input type="hidden" name="wdp_import_data_reset_rules" value="0">
                        <input type="checkbox" name="wdp_import_data_reset_rules" value="1">
                        <label for="wdp-import-data-reset-rules">
                            Clear all rules before import </label>
                    </div>
                </div>
            </div>
            <p>
                <button type="submit" id="wdr-import" name="wdr_import" class="button button-primary">
                    Import
                </button>
            </p>
        </form>-->

    </div>
</div>