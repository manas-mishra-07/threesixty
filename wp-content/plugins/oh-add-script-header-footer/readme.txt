=== SOGO Add Script to Individual Pages Header Footer  ===
Contributors: orenhav
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z5H7VVZLSPYUE
Tags: javascript,js, re-marketing code, header, footer
Requires at least: 3.5
Tested up to: 4.9.8
Stable tag: 3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Simple plugin to add script to header and footer for individual pages & posts


== Description ==

Tested with Gutenberg

Create a simple way to add javascript code to individual page post or custom post type header and footer,
for example: add conversion code to thank you pages
add google re-marketing code to individual pages
and much more...
added in version 1.3 the option to add script  \ style to all pages not only individual pages,
 this will allow you to add Google re-marketing code to the entire site or Google Analytics
 to use it goto "settings" - "Header Footer Settings"

 New Features (version 3.0):
Added option for terms  / category pages


 New Features (version 2.3):
 Added support for WooCommerce shop page.



1. we support now exclude individual pages form printing the header and footer scripts, this is supported by 2 checkboxes in each page\post
 buy check it the script will not be display on this page

2. we added support to limit the script only for certain post type \ page


if you like it \ use it - please rate us.

usage:
You need to paste the code with the script tag, for example:
<script type="text/javascript">   you js code </script>



== Installation ==

1. Upload the plugin to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to page, post or custom post type
4. paste your code to the header or footer box
5. save you post or page


== Frequently Asked Questions ==



== Screenshots ==
1. edit page meta box


== Changelog ==

= 1.0 =
* initial version

= 1.1 =
* resolve header script not being echo to the page

= 1.2 =
* resolve issue with WordPress Version 3.7

= 1.2.1 =
* added usage description

= 1.3 =
* add site wide header footer script (e.g. for Google analytics or remarking code)

= 1.3 =
* add 2 new features:
1. option to limit the script per post type - we added a checkbox in the option which give you the ability to select on
which page \post \custom post type the header or footer script will be printed.
2. option to exclude a  page \post \custom post type from header and or footer script. yo will find 2 new checkbox on each page
which enable you to exclude the script from this individual page

= 1.6 =
change labels

= 2.2 =
fix bug :When I paste the script into an individual post from a category then the same script is appearing in category listing page as well.
(thanks to Shane (@ugrasen1989))

= 2.3 =
fix bug : Added support for WooCommerce shop page .
(thanks to Birdie‏  )


== Upgrade Notice ==

