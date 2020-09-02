<?php
/**
 * Handles additional widget tab options
 * run on __construct function
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Admin Messages
 * @return void
 */
if( !function_exists( 'woo_login_popup_sc_admin_notices' ) ):
    function woo_login_popup_sc_admin_notices() {
        if( !current_user_can( 'update_plugins' ) )
            return;

        $install_date   = get_option( 'woo_login_popup_sc_installDate' );
        $saved          = get_option( 'woo_login_popup_sc_RatingDiv' );
        $display_date   = date( 'Y-m-d h:i:s' );
        $datetime1      = new DateTime( $install_date );
        $datetime2      = new DateTime( $display_date );
        $diff_intrval   = round( ($datetime2->format( 'U' ) - $datetime1->format( 'U' ) ) / (60*60*24));
        if( 'yes' != $saved && $diff_intrval >= 7 ){
        echo '<div class="woo_login_popup_sc_notice updated" style="box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
            <p>Awesome, you\'ve been using <strong>WooCommerce Login Popup and Shortcodes</strong> for more than 1 week. <br> May i ask you to give it a <strong>5-star rating</strong> on WordPress? </br>
            This will help to spread its popularity and to make this plugin a better one.
            <br><br>Your help is much appreciated. Thank you very much,<br> ~ Jeffrey Carandang <em>(phpbits)</em>
            <ul>
                <li><a href="https://wordpress.org/support/view/plugin-reviews/woocommerce-login-popup-and-shortcodes/" class="thankyou" target="_blank" title="Ok, you deserved it" style="font-weight:bold;">'. __( 'Ok, you deserved it', 'woo-login-popup-shortcodes' ) .'</a></li>
                <li><a href="javascript:void(0);" class="woo_login_popup_sc_bHideRating" title="I already did" style="font-weight:bold;">'. __( 'I already did', 'woo-login-popup-shortcodes' ) .'</a></li>
                <li><a href="javascript:void(0);" class="woo_login_popup_sc_bHideRating" title="No, not good enough" style="font-weight:bold;">'. __( 'No, not good enough, i do not like to rate it!', 'woo-login-popup-shortcodes' ) .'</a></li>
            </ul>
        </div>
        <script>
        jQuery( document ).ready(function( $ ) {

        jQuery(\'.woo_login_popup_sc_bHideRating\').click(function(){
            var data={\'action\':\'woo_login_popup_sc_hideRating\'}
                 jQuery.ajax({

            url: "'. admin_url( 'admin-ajax.php' ) .'",
            type: "post",
            data: data,
            dataType: "json",
            async: !0,
            success: function(e) {
                if (e=="success") {
                   jQuery(\'.woo_login_popup_sc_notice\').slideUp(\'slow\');

                }
            }
             });
            })

        });
        </script>
        ';
        }
    }
    add_action( 'admin_notices', 'woo_login_popup_sc_admin_notices' );
endif;

/* Hide the rating div
 * @return json string
 *
 */
if( !function_exists( 'woo_login_popup_sc_ajax_hide_rating' ) ):
	function woo_login_popup_sc_ajax_hide_rating(){
	    update_option( 'woo_login_popup_sc_RatingDiv', 'yes' );
	    echo json_encode(array("success")); exit;
	}
	add_action( 'wp_ajax_woo_login_popup_sc_hideRating', 'woo_login_popup_sc_ajax_hide_rating' );
endif;
?>
