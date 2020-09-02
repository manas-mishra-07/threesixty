<div class="woocommerce" style="margin: 10px 20px 0 2px;">
	<div class="icon32" id="icon-woocommerce-importer"><br></div>
    <h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
        <a href="<?php echo admin_url('admin.php?page=wf_woocommerce_order_im_ex') ?>" class="nav-tab <?php echo ($tab == 'import') ? 'nav-tab-active' : ''; ?>"><?php _e('Order Import / Export', 'wf_order_import_export'); ?></a>
        <a href="<?php echo admin_url('admin.php?page=wf_coupon_csv_im_ex&tab=coupon') ?>" class="nav-tab <?php echo ($tab == 'coupon') ? 'nav-tab-active' : ''; ?>"><?php _e('Coupon Import / Export', 'wf_order_import_export'); ?></a>
        <a href="<?php echo admin_url('admin.php?page=wf_woocommerce_order_im_ex&tab=subscription') ?>" class="nav-tab <?php echo ($tab == 'subscription') ? 'nav-tab-active' : ''; ?>"><?php _e('Subscription Import / Export', 'wf_order_import_export'); ?></a>
        <a href="https://www.webtoffee.com/product/woocommerce-order-coupon-subscription-export-import/" target="_blank" class="nav-tab nav-tab-premium"><?php _e('Upgrade to Premium for More Features', 'wf_order_import_export'); ?></a>
    </h2>

	<?php
		switch ($tab) {
			case "export" :
				$this->admin_export_page();
			break;
                        case "coupon" :
				$this->admin_coupon_page();
			break;
                    	case "subscription" :
				$this->admin_subscription_page();
			break;
			default :
				$this->admin_import_page();
			break;
		}
	?>
</div>