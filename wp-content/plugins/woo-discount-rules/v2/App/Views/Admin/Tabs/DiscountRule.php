<?php
if (!defined('ABSPATH')) exit;

$rules_count = count($rules);
$is_pro = \Wdr\App\Helpers\Helper::hasPro();
?>
<br>
<div id="wpbody-content" class="awdr-container">
    <div class="" style ="<?php if(!$is_pro){ echo "width: 71%; float: left;"; }?>" >
        <div class="col-md-6 col-lg-6 text-left awdr-list-header-btn" <?php if(!$is_pro){ echo 'style="width:100%; float: left"'; }?>>
            <h1 class="wp-heading-inline"><?php _e('Discount Rules', WDR_TEXT_DOMAIN); ?></h1>
            <a href="<?php echo admin_url("admin.php?" . http_build_query(array('page' => WDR_SLUG, 'tab' => 'rules', 'task' => 'create'))); ?>"
               class="btn btn-primary"><?php _e('Add New Rule', WDR_TEXT_DOMAIN); ?></a>
            <?php if($has_migration == true) {
                ?>
                <a class="wdr-popup-link btn btn-primary"><span class="modal-trigger" data-modal="wdr_migration_popup"><?php _e("Migrate rules from v1", WDR_TEXT_DOMAIN); ?></a>

                <div class="modal" id="wdr_migration_popup">
                    <div class="modal-sandbox"></div>
                    <div class="modal-box">
                        <div class="modal-header">
                            <div class="close-modal"><span class="wdr-close-modal-box">&#10006;</span></div>
                            <h1 class="wdr-modal-header-title"><?php _e("Migration", WDR_TEXT_DOMAIN); ?></h1>
                        </div>
                        <div class="modal-body">
                            <h2 class="wdr_tabs_container nav-tab-wrapper">
                                <?php esc_html_e('Migrate rules from v1 to v2', WDR_TEXT_DOMAIN); ?>
                            </h2>
                            <div class="wdr_migration_text_con">
                                <p>
                                    <b><?php esc_html_e('Available price rules', WDR_TEXT_DOMAIN); ?>:</b> <?php echo isset($migration_rule_count['price_rules'])? $migration_rule_count['price_rules']: 0;?>
                                </p>
                                <p>
                                    <b><?php esc_html_e('Available cart rules', WDR_TEXT_DOMAIN); ?>:</b> <?php echo isset($migration_rule_count['cart_rules'])? $migration_rule_count['cart_rules']: 0?>
                                </p>
                                <p>
                                    <?php _e('Once migration is completed, please open the rules and check their configuration once again to make sure it meets your discount scenario. If required, please adjust the rule configuration. If you need any help, just open a ticket at <a href="https://www.flycart.org/support" target="_blank">https://www.flycart.org/support</a>', WDR_TEXT_DOMAIN); ?>
                                </p>
                            </div>
                            <div class="wdr_settings">
                                <div class="wdr_migration_container">
                                    <button class="btn btn-primary" type="button" id="awdr_do_v1_v2_migration"><?php esc_html_e('Migrate', WDR_TEXT_DOMAIN); ?></button>
                                    <span class="close-modal"><button class="btn btn-warning wdr-close-modal-box" type="button"><?php esc_html_e('Skip', WDR_TEXT_DOMAIN); ?></button></span>
                                    <div class="wdr_migration_process">
                                    </div>
                                    <div class="wdr_migration_process_status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }?>
            <a href="https://docs.flycart.org/en/collections/2195266-discount-rules-2-0?utm_source=woo-discount-rules-v2&utm_campaign=doc&utm_medium=text-click&utm_content=examples#commonly-asked-scenarios" target="_blank"
               class="btn btn-info text-right" style="float: right"><?php _e('View Examples', WDR_TEXT_DOMAIN); ?></a>
            <a href="https://docs.flycart.org/en/collections/2195266-discount-rules-2-0?utm_source=woo-discount-rules-v2&utm_campaign=doc&utm_medium=text-click&utm_content=documentation" target="_blank"
               class="btn btn-info text-right" style="float: right"><?php _e('Documentation', WDR_TEXT_DOMAIN); ?></a>
        </div>

        <br/>
        <form id="wdr-search-top" method="get" style="display: none">
            <input type="hidden" name="adminUrl"
                   value="<?php echo admin_url('admin.php?page=woo_discount_rules'); ?>">
                <input type="hidden" name="name" value="" class="wdr-rule-search-key">
                <input type="submit" class="button" class="wdr-trigger-search-key"
                       value="<?php _e('Search Rules', WDR_TEXT_DOMAIN); ?>">
        </form>
        <form id="wdr-bulk-action-top" method="post">
            <div class="tablenav top">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top"
                           class="screen-reader-text"><?php _e('Search Rules', WDR_TEXT_DOMAIN); ?></label>
                    <select name="wdr_bulk_action" id="bulk-action-selector-top">
                        <option value="-1"><?php _e('Bulk Actions', WDR_TEXT_DOMAIN); ?></option>
                        <option value="enable"><?php _e('Enable', WDR_TEXT_DOMAIN); ?></option>
                        <option value="disable"><?php _e('Disable', WDR_TEXT_DOMAIN); ?></option>
                        <option value="delete"><?php _e('Delete', WDR_TEXT_DOMAIN); ?></option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="<?php _e('Apply', WDR_TEXT_DOMAIN);?>">
                    <input type="search" name="awdr-hidden-name" class="awdr-hidden-name" value="<?php echo $input->get('name'); ?>">
                    <input type="button" class="button awdr-hidden-search"
                           value="<?php _e('Search Rules', WDR_TEXT_DOMAIN); ?>">
                </div>
                <div class="tablenav-pages one-page">
                <span class="displaying-num"><?php echo $rules_count . ' ';
                    ($rules_count == 0 || $rules_count == 1) ? _e('item', WDR_TEXT_DOMAIN) : _e('items', WDR_TEXT_DOMAIN); ?></span>
                </div>
                <br class="clear">
            </div>

            <table class="wp-list-table widefat fixed posts">
                <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                    </td>
                    <td id="cb" class="manage-column column-cb check-column">
                        <input name="bulk_check[]" class="wdr-rules-select" type="checkbox" value="off"/>
                    </td>

                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <a href="javascript:void(0);">
                            <span><?php _e('Title', WDR_TEXT_DOMAIN); ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th scope="col" id="author"
                        class="manage-column column-author"><?php _e('Discount Type', WDR_TEXT_DOMAIN); ?></th>
                    <th scope="col" id="author"
                        class="manage-column column-author"><?php _e('Start Date', WDR_TEXT_DOMAIN); ?></th>
                    <th scope="col" id="tags"
                        class="manage-column column-tags"><?php _e('Expired On', WDR_TEXT_DOMAIN); ?></th>
                    <?php
                    if (count($site_languages) > 1) {
                        ?>
                        <th scope="col" id="tags"
                            class="manage-column column-tags"><?php _e('Language(s)', WDR_TEXT_DOMAIN); ?></th>
                        <?php
                    }
                    ?>
                    <!--<th scope="col" id="tags" class="manage-column column-tags">
                        <?php /*_e('Priority',WDR_TEXT_DOMAIN) */?>
                    </th>-->
                    <th scope="col" id="status"
                        class="manage-column column-tags"><?php _e('Status', WDR_TEXT_DOMAIN); ?></th>
                    <th scope="col" id="title"
                        class="manage-column column-title"><?php _e('Action', WDR_TEXT_DOMAIN); ?></th>
                </tr>
                </thead>
                <tbody class="wdr-ruleboard" id="sortable"><?php
                if ($rules) {
                    foreach ($rules as $rule_row) { ?>
                        <tr id="<?php echo $rule_row->getId(); ?>" class="awdr-listing-rule-tr">
                            <th scope="row" class="check-column awdr-listing-rule-check-box-align">
                                <span class="dashicons dashicons-menu" style="padding-left: 5px;"></span>
                            </th>
                            <th scope="row" class="check-column awdr-listing-rule-check-box-align">
                                <input id="cb-select-<?php echo $rule_row->getId(); ?>" class="wdr-rules-selector"
                                       type="checkbox" name="saved_rules[]"
                                       value="<?php echo $rule_row->getId(); ?>">
                            </th>
                            <td class="title column-title has-row-actions column-primary page-title"
                                data-colname="Title">
                                <strong>
                                    <a class="row-title"
                                       href="<?php echo admin_url("admin.php?" . http_build_query(array('page' => WDR_SLUG, 'tab' => 'rules', 'task' => 'view', 'id' => $rule_row->getId()))); ?>"
                                       aria-label="“<?php echo $rule_row->getTitle(); ?>” (Edit)"><?php echo $rule_row->getTitle();
                                       if($rule_row->isExclusive()) {?>
                                               <span class="awdr-exclusive-disable-listing"><?php _e('Exclusive', WDR_TEXT_DOMAIN); ?></span> <?php
                                       }?></a>
                                </strong>
                                <div class="awdr_created_date_html">
                                <?php
                                $created_by = $rule_row->getRuleCreatedBy();
                                if($created_by) {
                                    if (function_exists('get_userdata')) {
                                        if ($user = get_userdata($created_by)) {
                                            if (isset($user->data->display_name)) {
                                                $created_by = $user->data->display_name;
                                            }
                                        }
                                    }
                                }
                                $created_on = $rule_row->getRuleCreatedOn();

                                $modified_by = $rule_row->getRuleModifiedBy();
                                if($modified_by) {
                                    if (function_exists('get_userdata')) {
                                        if ($user = get_userdata($modified_by)) {
                                            if (isset($user->data->display_name)) {
                                                $modified_by = $user->data->display_name;
                                            }
                                        }
                                    }
                                }
                                $modified_on = $rule_row->getRuleModifiedOn();
                                if($created_by && !empty($created_by) && !empty($created_on)){ ?>
                                    <span class="wdr_desc_text"><?php _e('Created by: ' .$created_by.'' , WDR_TEXT_DOMAIN);?>,<?php  _e(' On: ' . $created_on , WDR_TEXT_DOMAIN); ?> &nbsp;</span><?php }
                                if($modified_by && !empty($modified_by) && !empty($modified_on)){?>
                                    <span class="wdr_desc_text"><?php _e('Modified by: ' .$modified_by.'' , WDR_TEXT_DOMAIN);?>,<?php  _e(' On: ' . $modified_on , WDR_TEXT_DOMAIN); ?> </span><?php
                                }?>
                                </div>
                            </td>
                            <td class="author column-author" data-colname="Author"><?php
                                $get_discount_type = $rule_row->getRuleDiscountType();
                                $discount_type_name = '-';
                                switch ($get_discount_type){
                                    case'wdr_simple_discount':
                                        $discount_type_name = __('Product Adjustment', WDR_TEXT_DOMAIN);
                                        break;
                                    case'wdr_cart_discount':
                                        $discount_type_name =  __('Cart Adjustment', WDR_TEXT_DOMAIN);
                                        break;
                                    case'wdr_free_shipping':
                                        $discount_type_name = __('Free Shipping', WDR_TEXT_DOMAIN);
                                        break;
                                    case'wdr_bulk_discount':
                                        $discount_type_name = __('Bulk Discount', WDR_TEXT_DOMAIN);
                                        break;
                                    case'wdr_set_discount':
                                        $discount_type_name = __('Set Discount', WDR_TEXT_DOMAIN);
                                        break;
                                    case'wdr_buy_x_get_x_discount':
                                        $discount_type_name = __('Buy X get X', WDR_TEXT_DOMAIN);
                                        break;
                                    case'wdr_buy_x_get_y_discount':
                                        $discount_type_name = __('Buy X get Y', WDR_TEXT_DOMAIN);
                                        break;
                                }
                                ?>
                                <abbr><?php echo $discount_type_name; ?></abbr>
                            </td>
                            <td class="author column-author" data-colname="Author"><?php
                                $get_start_date = $rule_row->getStartDate($timestamp = false, $format = "Y-m-d H:i");
                                ?>
                                <abbr><?php echo is_null($get_start_date) ? '-' : $get_start_date; ?></abbr>
                            </td>
                            <td class="date column-date" data-colname="Date"><?php
                                $get_end_date = $rule_row->getEndDate($timestamp = false, $format = "Y-m-d H:i");
                                ?>
                                <abbr><?php echo is_null($get_end_date) ? '-' : $get_end_date; ?></abbr>
                            </td>
                            <?php
                            if (count($site_languages) > 1) {
                                ?>
                                <td>
                                    <?php
                                    $chosen_languages = $rule_row->getLanguages();
                                    if (!empty($chosen_languages)) {
                                        $i = 1;
                                        foreach ($chosen_languages as $language) {
                                            echo isset($site_languages[$language]) ? $site_languages[$language] : '';
                                            if (count($chosen_languages) > $i) {
                                                echo ', ';
                                            }
                                            $i++;
                                        }
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <?php
                            }
                            ?>
                           <!-- <td></td>-->
                            <td class="date column-tag" data-colname="wdr-rule-status">
                                <label class="switch switch-left-right">
                                    <input class="switch-input wdr_manage_status" name="toogle_action" type="checkbox" data-manage-status="<?php echo $rule_row->getId(); ?>" <?php echo ($rule_row->isEnabled()) ? 'checked' : '';?>/>
                                    <span class="switch-label" data-on="<?php _e('Enabled', WDR_TEXT_DOMAIN); ?>" data-off="<?php _e('Disabled', WDR_TEXT_DOMAIN); ?>"></span>
                                    <span class="switch-handle"></span>
                                </label>
                                    <span class="awdr-enabled-status" style="<?php echo (!$rule_row->isEnabled()) ? 'display:none' : '';?>">
                                    <?php
                                    $rule_status = $rule_row->getRuleVaildStatus();
                                    $current_time_stamp = current_time('timestamp');
                                    $current_time = $rule_row->formatDate($current_time_stamp, $format = "Y-m-d H:i", false);
                                    if($rule_status == 'in_future'){?>
                                        <span class="awdr-listing-status-text"><?php _e(' - ( Will run in future)', WDR_TEXT_DOMAIN);?></span><br><?php
                                        if(isset($current_time) && !empty($current_time)) {
                                            ?>
                                            <span class="awdr-text-warning"><b><?php _e('Your server current date and time:', WDR_TEXT_DOMAIN);?> </b><?php echo $current_time; ?>
                                            </span><?php
                                        }

                                    }elseif ($rule_status == 'expired'){?>
                                        <span class="awdr-listing-status-text"><?php _e(' - ( Not running - validity expired)', WDR_TEXT_DOMAIN);?></span><br><?php
                                        if(isset($current_time) && !empty($current_time)) {
                                            ?>
                                            <span class="awdr-text-warning"><b><?php _e('Your server current date and time:', WDR_TEXT_DOMAIN);?> </b><?php echo $current_time; ?>
                                            </span><?php
                                        }
                                    }else{?>
                                        <span class="awdr-listing-status-text"><?php _e(' - (Running)', WDR_TEXT_DOMAIN);?></span><?php
                                    }?>
                                    </span>
                            </td>
                            <td class="awdr-rule-buttons">
                                <a class="btn btn-primary"
                                   href="<?php echo admin_url("admin.php?" . http_build_query(array('page' => WDR_SLUG, 'tab' => 'rules', 'task' => 'view', 'id' => $rule_row->getId()))); ?>">
                                    <?php _e('Edit', WDR_TEXT_DOMAIN); ?></a>
                                <a class="btn btn-primary wdr_duplicate_rule"
                                   data-duplicate-rule="<?php echo $rule_row->getId(); ?>"><?php _e('Duplicate', WDR_TEXT_DOMAIN); ?></a>
                                <a class="btn btn-danger wdr_delete_rule"
                                   data-delete-rule="<?php echo $rule_row->getId(); ?>">
                                    <?php _e('Delete', WDR_TEXT_DOMAIN); ?></a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr class="no-items">
                        <td></td>
                        <td></td>
                        <td class="colspanchange" colspan="2"><?php _e('No rules found.', WDR_TEXT_DOMAIN);?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td class="manage-column column-cb check-column">
                    </td>
                    <td class="manage-column column-cb check-column">
                        <input name="bulk_check[]" class="wdr-rules-select" type="checkbox" value="off"/>
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <a href="javascript:void(0);">
                            <span><?php _e('Title', WDR_TEXT_DOMAIN); ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th scope="col" id="author"
                        class="manage-column column-author"><?php _e('Discount Type', WDR_TEXT_DOMAIN); ?></th>
                    <th scope="col" id="author"
                        class="manage-column column-author"><?php _e('Start Date', WDR_TEXT_DOMAIN); ?></th>
                    <th scope="col" id="tags"
                        class="manage-column column-tags"><?php _e('Expired On', WDR_TEXT_DOMAIN); ?></th>
                    <?php
                    if (count($site_languages) > 1) {
                        ?>
                        <th scope="col" id="tags"
                            class="manage-column column-tags"><?php _e('Language(s)', WDR_TEXT_DOMAIN); ?></th>
                        <?php
                    }
                    ?>
                    <!--<th scope="col" id="tags" class="manage-column column-tags">
                        <?php /*_e('Priority',WDR_TEXT_DOMAIN) */?>
                    </th>-->
                    <th scope="col" id="status"
                        class="manage-column column-tags"><?php _e('Status', WDR_TEXT_DOMAIN); ?></th>
                    <th scope="col" id="title"
                        class="manage-column column-title"><?php _e('Action', WDR_TEXT_DOMAIN); ?></th>
                </tr>
                </tfoot>
            </table>


            <div class="tablenav bottom">
                <div class="alignleft actions bulkactions">
                    <!-- <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk
                         action</label><select name="action2" id="bulk-action-selector-bottom">
                         <option value="-1">Bulk Actions</option>
                         <option value="edit" class="hide-if-no-js">Edit</option>
                         <option value="trash">Move to Trash</option>
                     </select>
                     <input type="submit" id="doaction2" class="button action" value="Apply">-->
                </div>
                <div class="alignleft actions">
                </div>
                <div class="tablenav-pages one-page"><span class="displaying-num"><?php echo $rules_count . ' ';
                        ($rules_count == 0 || $rules_count == 1) ? _e('item', WDR_TEXT_DOMAIN) : _e('items', WDR_TEXT_DOMAIN); ?></span></span>
                </div>
                <br class="clear">
            </div>
            <input type="hidden" name="action" value="wdr_ajax">
            <input type="hidden" name="method" value="bulk_action">
            <input type="hidden" name="adminUrl" value="<?php echo admin_url('admin.php?page=woo_discount_rules') ?>">
        </form>
        <br class="clear">
    </div>
    <?php
    if(!$is_pro){ ?>
        <div class="col-md-6 col-lg-6 text-right" style="width: 27%; float: right;">
            <div class="col-md-12">
                <a href="https://www.flycart.org/products/wordpress/woocommerce-discount-rules?utm_source=wpwoodiscountrules&utm_medium=plugin&utm_campaign=inline&utm_content=woo-discount-rules" target="_blank" class="btn btn-success"><?php esc_html_e('Looking for more features? Upgrade to PRO', WDR_TEXT_DOMAIN); ?></a>
            </div>
            <div class="woo-side-panel">
                <div class="panel">
                    <div class="panel-body">
                        <h3><?php esc_html_e('With PRO version, you can create:', WDR_TEXT_DOMAIN)?></h3>
                        <p><?php esc_html_e('- Categories based discounts', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- User roles based discounts', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Buy One Get One Free deals', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Buy X Get Y deals', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Buy 2, get 1 at 50% discount', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Buy 3 for $10 (Package / Bundle [Set] Discount)', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Different discounts with one coupon code', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Purchase history based discounts', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Free product / gift', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Discount for variants', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Conditional discounts', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Fixed cost discounts', WDR_TEXT_DOMAIN)?></p>
                        <p><?php esc_html_e('- Offer fixed price on certain conditions', WDR_TEXT_DOMAIN)?></p>
                        <p><a href="https://www.flycart.org/products/wordpress/woocommerce-discount-rules?utm_source=wpwoodiscountrules&amp;utm_medium=plugin&amp;utm_campaign=inline&amp;utm_content=woo-discount-rules" class="btn btn-success" target="_blank"><?php esc_html_e('Go PRO', WDR_TEXT_DOMAIN); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
