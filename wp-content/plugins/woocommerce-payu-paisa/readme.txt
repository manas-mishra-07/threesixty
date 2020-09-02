=== WooCommerce PayU India (PayUmoney - PayUbiz) ===
Contributors: kdclabs, vachan
Donate link: https://www.payumoney.com/webfront/index/kdclabs
Tags: WooCommerce, Payment Gateway, PayU money, PayU biz, PayU India
Requires at least: 3.5.1
Tested up to: 4.9
Stable tag: 2.1.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

PayU India supports both PayUmoney and PayUbiz.

== Description ==

WooCommerce - The most user friendly e-commerce toolkit that helps you sell anything. Beautifully.
[PayU Money](https://kdc.re/payu-in "Get your free account") - Redefining Payments, Simplifying Lives! Empowering any business to collect money online within minutes

The two together is an awsome combination for any INDIAN merchant looking for an eCommerece pressence, without any finiacial load.
*   "WooCommerce" is an open source application
*   "PayU money" is offering payment collection with no setup cost.
*   "PayU biz" is offering enterprise payment collection.

Visit [www.kdcLabs.com](http://www.kdclabs.com/?p=64 "_KDC-Labs : WooCommerce - PayU India") for more info about this plugin.


== Installation ==

1. Ensure you have latest version of WooCommerce plugin installed (WooCommerce 2.0+)
2. Unzip and upload contents of the plugin to your `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Configuration ==

1. Visit the `WooCommerce > Settings > Checkout` tab.
2. Click on *PayU Money* to edit the settings. If you do not see *PayUMoney* in the list at the top of the screen make sure you have activated the plugin in the WordPress Plugin Manager.
3. Enable the Payment Method, name it `Credit Card / Debit Card / Internet Banking` (this will show up on the payment page your customer sees).
4. Add in your `Merchant Key` and `Merchant Salt` as provided by the PayUMoney Team.
5. Choose if you want to show the `PayUMoney` Logo to the customer (You may also insert a custom logo in your discription via `<img ...` tag).
6. Select `Redirect url` (URL you want PayUMoney to redirect after payment).
7. Click Save.

== Screenshots ==

1. WooCommerce > Payment Gateway > PayU India - setting page
2. Checkout Page - Option of Payment by *PayU Money*
3. PayU Money - Client login page
4. PayU Money - Payment slection page
5. PayU Money - Payment processing page
6. Return Page - Transaction status as per *PayU Money* display on return page as per setting

== Changelog ==

= 2.1.1 (2017-11-28) =
* FIX: Return Sucess Redirect Issue - Credit: @xcessinfostore (@see https://wordpress.org/support/topic/enabling-default-woocommerce-redirects/#post-9728440)


= 2.1.0 (2017-07-20) =
* FIX: Sucess/Error Message DISPLAY.
* Added: Hash check with Convenience Fee/Surcharge.
* Updated: Forced Mobile to be 10 digits.
* Updated: TEST Mode - Test Card's Expiry Date.
* Updated: TEST Mode - New set of Key and Salt.
* Updated: CODE - Yoda Conditions (@see https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#yoda-conditions).
* Updated: Default _Title_ and _Description_.
* Updated: WP.org _assests_ and _screenshots_.

= 2.0.10 (2016-01-11) =
* FIX: TEST Mode - Use actual Key and Salt.

= 2.0.9 (2015-12-14) =
* FIX: Test Title ERROR - Credit: Sunitha Thakur

= 2.0.8 (2015-12-14) =
* FIX: Redirect Page - Defined.

= 2.0.5/6/7 (2015-11-25) =
* FIX: Redirect error.

= 2.0.4 (2015-11-18) =
* Return_array for Success.

= 2.0.3 (2015-11-16) =
* Checksum Error corrected - Credit: Dinesh Kumar @ tangien

= 2.0.2 (2015-10-16) =
* Updated text-domain
* Added "Settings" Link

= 2.0.1 (2015-10-16) =
* Updated Test-Mode Title 

= 2.0.0 =
* Complete resscripting as per standards
* Added support for PayU biz

= 1.3.7 =
* FIX - Endpoints for WC 2.1+ - Credit: Nikhil Mozika @ VNN Tech

= 1.3.6 =
* FIX - _KDC-Labs - WC-IPG Conflicts

= 1.3.5 =
* FIX - get_page > get_post

= 1.3.4 =
* Fix: Corrected source error

= 1.3.3 =
* Added: The TEST Mode feature back, with defalut TEST MODE id.

= 1.3.2 =
* Added: Logo Display option

= 1.3.1 =
* Removed Test Mode

= 1.3.0 =
* Updates for WooCommerce 2.1

= 1.2.3 =
* Rectified ERROR: Tag & Trunk MisMatch

= 1.2.2 =
* Rectified ERROR: Thanks to Gautam Kumar (WP @Sksalem)

= 1.2.1 =
* Rectified Conflict 'WooCommerce CCAvenue gateway'
* Changed Configuration

= 1.2.0 =
* Changed 'PayU Paisa' to 'PayU Money'.

= 1.1.0 =
* Replacing the name 'Merchant ID' to 'Merchant KEY'.

= 1.0.0 =
* First Public Release.
