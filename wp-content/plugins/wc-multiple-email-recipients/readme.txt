=== Plugin Name ===
Contributors: conschneider,dinodesigns87
Donate link: http://conschneider.de
Tags: WooCommerce,emails,notification
Requires at least: 4.0
Tested up to: 4.7.4
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin lets you add up to five additional email addresses to be used with WooCommerce notification mails. 

== Description ==

WooCommerce notification emails only get sent to the customer and admin email. Sometimes you need more than that. This plugin allows you to set up to five additional email addresses that can be used as additional email recipients for WooCommerce notification emails. You can select which email you want to have multiple recipients via the settings. 

This plugin support WooCommerce, WooCommerce Bookings and WooCommerce Subscriptions. 

The duplicated mails sent by this plugin will not show up in an email logger as they are sent using "BCC".

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->WC Multiple Email Recipients screen to configure the plugin


== Frequently Asked Questions ==

= What kind of emails are supported? =

The following WooCommerce notification emails are supported:

= WooCommerce =

* WooCommerce New Order Mail
* WooCommerce Cancelled Order Mail
* WooCommerce Processing Order Mail
* WooCommerce Completed Order Mail
* WooCommerce Order Invoice Mail
* WooCommerce Refunded Order Mail

= WooCommerce Bookings =

* WooCommerce Bookings Cancelled Mail
* WooCommerce Bookings Confirmed Mail
* WooCommerce Bookings Manual Notification Mail
* WooCommerce Bookings Reminder Mail
* WooCommerce Bookings New Booking Mail

= WooCommerce Subscriptions =

* WooCommerce Subscriptions Completed Renewal Order Mail
* WooCommerce Subscriptions Completed Switch Order Mail
* WooCommerce Subscriptions Customer Payment Retry Mail
* WooCommerce Subscriptions Customer Processing Renewal Order Mail
* WooCommerce Subscriptions Customer Renewal Invoice Mail
* WooCommerce Subscriptions Expired Subscription Mail
* WooCommerce Subscriptions New Renewal Order Mail
* WooCommerce Subscriptions New Switch Order Mail
* WooCommerce Subscriptions Suspended Subscription Mail
* WooCommerce Subscriptions Payment Retry Mail

= How do the emails get sent? =

The duplicated mails sent by this plugin are sent using "BCC". Thus they will not show up in an email logger. 

== Screenshots ==

1. Settings page

== Changelog ==

= 1.2.3 =
* Fix: Fix for missing argument of main function. Shoutout to John from digitalproductsnow dot com. Thanks!

= 1.2.3 =
* Fix: Added support to for On-Hold emails in WooCommerce. Shoutout to @dinodesigns87. Thanks!

= 1.2.2 =
* Fix: Ensure WooCommerce 3 compatibility by expanding methods.

= 1.2.1 =
* Fix: Settings did not correctly save for WooCommerce Subscriptions and WooCommerce Bookings.

= 1.2 =
* added support for WooCommerce Subscriptions.

= 1.1 =
* added support for WooCommerce Bookings.

= 1.0 =
* Initial version.
 
