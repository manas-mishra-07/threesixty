<?php

namespace WDRPro\App\Helpers;
if (!defined('ABSPATH')) {
    exit;
}
class FreeShippingMethod extends \WC_Shipping_Method
{
    /**
     * Constructor for your shipping class
     * @param $title
     */
    public function __construct($title = '')
    {
        $this->id = 'wdr_free_shipping';
        $this->method_title = __('Free shipping', WDR_PRO_TEXT_DOMAIN);
        $this->method_description = __('Free shipping is a special method which can be triggered with coupons and minimum spends.', WDR_PRO_TEXT_DOMAIN);
        $this->init();
        $this->enabled = true;
        $this->title = (empty($title)) ? __('Wdr Free Shipping', WDR_PRO_TEXT_DOMAIN) : $title;
    }

    /**
     * Initialize Wdr free shipping.
     */
    function init()
    {
        // Load the settings.
        $this->init_settings();
        // Save settings in admin if you have any defined
        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * Called to calculate shipping rates for this method. Rates can be added using the add_rate() method.
     *
     * @param array $package Shipping package.
     * @uses WC_Shipping_Method::add_rate()
     *
     */
    public function calculate_shipping($package = array())
    {
        $this->add_rate(
            array(
                'label' => $this->title,
                'cost' => 0,
                'taxes' => false,
                'package' => $package,
            )
        );
    }
}