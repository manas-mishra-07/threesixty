<div class="orderimpexp-main-box">
    <div class="orderimpexp-view" style="width:68%;">
        <div class="tool-box bg-white p-20p">
            <div id="message" class="updated woocommerce-message wc-connect">
                <div class="squeezer">
                    <h4><?php _e('<strong>This Feature is only available in Premium version</strong>', 'wf_order_import_export'); ?></h4>
                    <p class="submit">
                        <a href="https://www.webtoffee.com/product/woocommerce-order-coupon-subscription-export-import/" target="_blank" class="button button-primary"><?php _e('Upgrade to Premium Version', 'wf_order_import_export'); ?></a>
                        <a href="https://www.webtoffee.com/setting-up-order-import-export-plugin-for-woocommerce/" target="_blank" class="button"><?php _e('Documentation', 'wf_order_import_export'); ?></a>
                        <a href="<?php echo plugins_url('Sample_Subscription.csv', WF_OrderImpExpCsv_FILE); ?>" target="_blank" class="button"><?php _e('Sample Subscription CSV', 'wf_order_import_export'); ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php include(WT_OrdImpExpCsv_BASE . 'includes/views/market.php'); ?>
    <div class="clearfix"></div>
</div>