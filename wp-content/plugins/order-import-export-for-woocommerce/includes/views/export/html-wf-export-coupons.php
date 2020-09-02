<div class="tool-box bg-white p-20p">
    <h3 class="title"><?php _e('Export Coupon in CSV Format:', 'wf_order_import_export'); ?></h3>
    <p><?php _e('Export and download your coupons in CSV format. This file can be used to import coupons back into your Woocommerce shop.', 'wf_order_import_export'); ?></p>
    <form action="<?php echo admin_url('admin.php?page=wf_coupon_csv_im_ex&action=export'); ?>" method="post">

        <table class="form-table">
            
        </table>
        <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('Export Coupons', 'wf_order_import_export'); ?>" /></p>
    </form>
</div>
</div>
        <?php include(WT_OrdImpExpCsv_BASE . 'includes/views/market.php'); ?>
        <div class="clearfix"></div>
</div>