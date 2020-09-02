<?php
/*
Plugin Name: WooCommerce PayU India (PayUmoney & PayUbiz)
Plugin URI: http://www.kdclabs.com/?p=64
Description: PayU India supports both PayUmoney and PayUbiz.
Version: 2.1.1
Author: _KDC-Labs
Author URI: http://www.kdclabs.com
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Donate link: https://www.payumoney.com/webfront/index/kdclabs
Contributors: kdclabs, vachan
*/

add_action('plugins_loaded', 'woocommerce_gateway_payuindia_init', 0);
define('payuindia_IMG', WP_PLUGIN_URL . "/" . plugin_basename(dirname(__FILE__)) . '/assets/img/');

function woocommerce_gateway_payuindia_init() {
	if ( !class_exists( 'WC_Payment_Gateway' ) ) return;

	/**
 	 * Gateway class
 	 */
	class WC_Gateway_PayUindia extends WC_Payment_Gateway {

	     /**
         * Make __construct()
         **/	
		public function __construct(){
			
			$this->id 					= 'payuindia'; // ID for WC to associate the gateway values
			$this->method_title 		= 'PayU India'; // Gateway Title as seen in Admin Dashboad
			$this->method_description	= 'PayU India - Redefining Payments, Simplifying Lives'; // Gateway Description as seen in Admin Dashboad
			$this->has_fields 			= false; // Inform WC if any fileds have to be displayed to the visitor in Frontend 
			
			$this->init_form_fields();	// defines your settings to WC
			$this->init_settings();		// loads the Gateway settings into variables for WC
						
			$key_id   			= $this->settings['key_id'];
			$key_secret 		= $this->settings['key_secret'];
			// Special settigns if gateway is on Test Mode
			$test_title			= '';	
			$test_description	= '';
			if ( 'test' == $this->settings['test_mode'] ) {
				$test_title 		= ' [TEST MODE]';
				$test_description 	= '<br/><br/><u>Test Mode is <strong>ACTIVE</strong>, use following Credit Card details:-</u><br/>'."\n"
									 .'Test Card Name: <strong><em>any name</em></strong><br/>'."\n"
									 .'Test Card Number: <strong>5123 4567 8901 234<u>6</u></strong> <small><em>(last is 6 not <s>5</s>)</em></small><br/>'."\n"
									 .'Test Card CVV: <strong>123</strong><br/>'."\n"
									 .'Test Card Expiry: <strong>12/'.date('y', strtotime('+1 year')).'</strong>';
				if ( 'biz' == $this->settings['service_provider'] ) {
					// @see https://documentation.payubiz.in/hosted-page-copy/
					$key_id		= 'gtKFFx';
					$key_secret	= 'eCwWELxi';
				} else {
					// @see https://www.payumoney.com/dev-guide/development/general.html
					$key_id 	= 'rjQUPktU';
					$key_secret	= 'e5iIg1jwi8';
				}
			} //END--test_mode=yes

			$this->title 			= $this->settings['title'].$test_title; // Title as displayed on Frontend
			$this->description 		= $this->settings['description'].$test_description; // Description as displayed on Frontend
			if ( $this->settings['show_logo'] != "no" ) { // Check if Show-Logo has been allowed
				$this->icon 		= payuindia_IMG . 'logo_' . $this->settings['show_logo'] . '.png';
			}
            $this->key_id 			= $key_id;
            $this->key_secret 		= $key_secret;
			$this->liveurl 			= 'https://'.$this->settings['test_mode'].'.payu.in/_payment';
			$this->redirect_page	= $this->settings['redirect_page']; // Define the Redirect Page.
			$this->service_provider	= $this->settings['service_provider']; // The Service options for PayU India.
			
            $this->msg['message']	= '';
            $this->msg['class'] 	= '';
			
			add_action('init', array(&$this, 'check_payuindia_response'));
            add_action('woocommerce_api_' . strtolower(get_class($this)), array($this, 'check_payuindia_response')); //update for woocommerce >2.0

            if ( version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=' ) ) {
                    add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) ); //update for woocommerce >2.0
                 } else {
                    add_action( 'woocommerce_update_options_payment_gateways', array( &$this, 'process_admin_options' ) ); // WC-1.6.6
                }
            add_action('woocommerce_receipt_payuindia', array(&$this, 'receipt_page'));	
		} //END-__construct
		
        /**
         * Initiate Form Fields in the Admin Backend
         **/
		function init_form_fields(){

			$this->form_fields = array(
				// Activate the Gateway
				'enabled' => array(
					'title' 		=> __('Enable/Disable:', 'woo_payuindia'),
					'type' 			=> 'checkbox',
					'label' 		=> __('Enable PayU India', 'woo_payuindia'),
					'default' 		=> 'no',
					'description' 	=> 'Show in the Payment List as a payment option'
				),
				// Title as displayed on Frontend
      			'title' => array(
					'title' 		=> __('Title:', 'woo_payuindia'),
					'type'			=> 'text',
					'default' 		=> __('Credit & Debit Cards / Netbanking / UPI', 'woo_payuindia'),
					'description' 	=> __('This controls the title which the user sees during checkout.', 'woo_payuindia'),
					'desc_tip' 		=> true
				),
				// Description as displayed on Frontend
      			'description' => array(
					'title' 		=> __('Description:', 'woo_payuindia'),
					'type' 			=> 'textarea',
					'default' 		=> __("Pay securely with:\n - Credit or Debit Cards\n - Internet Banking\n - UPI\n\nPowered by PayUindia.", 'woo_payuindia'),
					'description' 	=> __('This controls the description which the user sees during checkout.', 'woo_payuindia'),
					'desc_tip' 		=> true
				),
				// PayU India - Type
      			'service_provider' => array(
					'title' 		=> __('Service Provider:', 'woo_payuindia'),
					'type' 			=> 'select',
					'options' 		=> array('money'=>'PayUmoney','biz'=>'PayUbiz')
				),
				// LIVE Key-ID
      			'key_id' => array(
					'title' 		=> __('Merchant KEY:', 'woo_payuindia'),
					'type' 			=> 'text',
					'description' 	=> __('Given to Merchant by PayU India team'),
					'desc_tip' 		=> true
				),
  				// LIVE Key-Secret
    			'key_secret' => array(
					'title' 		=> __('Merchant SALT:', 'woo_payuindia'),
					'type' 			=> 'text',
					'description' 	=> __('Given to Merchant by PayU Money'),
					'desc_tip' 		=> true
                ),
  				// Mode of Transaction
      			'test_mode' => array(
					'title' 		=> __('Mode:', 'woo_payuindia'),
					'type' 			=> 'select',
					'label' 		=> __('PayUindia Tranasction Mode.', 'woo_payuindia'),
					'options' 		=> array('test'=>'Test Mode','secure'=>'Live Mode'),
					'default' 		=> 'test',
					'description' 	=> __('Mode of PayUindia activities'),
					'desc_tip' 		=> true
                ),
  				// Page for Redirecting after Transaction
      			'redirect_page' => array(
					'title' 			=> __('Return Page'),
					'type' 			=> 'select',
					'options' 		=> $this->payuindia_get_pages('Select Page'),
					'description' 	=> __('URL of success page', 'woo_payuindia'),
					'desc_tip' 		=> true
                ),
  				// Show Logo on Frontend
      			'show_logo' => array(
					'title' 		=> __('Show Logo:', 'woo_payuindia'),
					'type' 			=> 'select',
					'label' 		=> __('Logo on Checkout Page', 'woo_payuindia'),
					'options' 		=> array('no'=>'No Logo','icon-light'=>'Light - Icon','payu-light'=>'Light - Logo','icon-biz'=>'PayU biz - Icon','payu-biz'=>'PayU biz - Logo','payubiz'=>'PayU biz - Logo (Full)','icon-money'=>'PayU money - Icon','payu-money'=>'PayU money - Logo','payumoney'=>'PayU money - Logo (Full)'),
					'default' 		=> 'no',
					'description' 	=> __('<strong>PayU (Light)</strong> | Icon: <img src="'. payuindia_IMG . 'logo_icon-light.png" height="24px" /> | Logo: <img src="'. payuindia_IMG . 'logo_payu-light.png" height="24px" /><br/>' . "\n"
										 .'<strong>PayU biz&nbsp;&nbsp;&nbsp;&nbsp;</strong> | Icon: <img src="'. payuindia_IMG . 'logo_icon-biz.png" height="24px" /> | Logo: <img src="'. payuindia_IMG . 'logo_payu-biz.png" height="24px" /> | Logo (Full): <img src="'. payuindia_IMG . 'logo_payubiz.png" height="24px" /><br/>' . "\n"
										 .'<strong>PayU money&nbsp;&nbsp;</strong> | Icon: <img src="'. payuindia_IMG . 'logo_icon-money.png" height="24px" /> | Logo: <img src="'. payuindia_IMG . 'logo_payu-money.png" height="24px" /> | Logo (Full): <img src="'. payuindia_IMG . 'logo_payumoney.png" height="24px" />', 'woo_payuindia'),
					'desc_tip' 		=> false
                )
			);

		} //END-init_form_fields
		
        /**
         * Admin Panel Options
         * - Show info on Admin Backend
         **/
		public function admin_options(){
			echo '<h3>'.__('PayU India', 'woo_payuindia').'</h3>';
			echo '<p>'.__('Please make a note if you are using ', 'woo_payuindia').'<strong>'.__('"PayUmoney"', 'woo_payuindia').'</strong>'.__(' or ', 'woo_payuindia').'<strong>'.__('"PayUbiz"', 'woo_payuindia').'</strong>'.__(' as you main account.', 'woo_payuindia').'</p>';
			echo '<p><small><strong>'.__('Confirm your Mode: Is it LIVE or TEST.').'</strong></small></p>';
			echo '<table class="form-table">';
			// Generate the HTML For the settings form.
			$this->generate_settings_html();
			echo '</table>';
		} //END-admin_options

        /**
         *  There are no payment fields, but we want to show the description if set.
         **/
		function payment_fields(){
			if( $this->description ) {
				echo wpautop( wptexturize( $this->description ) );
			}
		} //END-payment_fields
		
        /**
         * Receipt Page
         **/
		function receipt_page($order){
			echo '<p><strong>' . __('Thank you for your order.', 'woo_payuindia').'</strong><br/>' . __('The payment page will open soon.', 'woo_payuindia').'</p>';
			echo $this->generate_payuindia_form($order);
		} //END-receipt_page
    
        /**
         * Generate button link
         **/
		function generate_payuindia_form($order_id){
			global $woocommerce;
			$order = new WC_Order( $order_id );

			// Redirect URL
			if ( '' == $this->redirect_page  || 0 == $this->redirect_page ) {
				$redirect_url = get_site_url() . "/";
			} else {
				$redirect_url = get_permalink( $this->redirect_page );
			}
			// Redirect URL : For WooCoomerce 2.0
			if ( version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=' ) ) {
				$redirect_url = add_query_arg( 'wc-api', get_class( $this ), $redirect_url );
			}

            $productinfo = "Order $order_id";

			$txnid = $order_id.'_'.date("ymds");
			// hash-string = key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||<SALT>
			$str = "$this->key_id|$txnid|$order->order_total|$productinfo|$order->billing_first_name|$order->billing_email|$order_id||||||||||$this->key_secret";
			$hash = strtolower(hash('sha512', $str));
			
			if ( 'biz' == $this->service_provider ) {
				$service_provider = '';
			} else {
				$service_provider = 'payu_paisa';
			}

			$payuindia_args = array(
				'key' 			=> $this->key_id,
				'hash' 			=> $hash,
				'txnid' 		=> $txnid,
				'amount' 		=> $order->order_total,
				'firstname'		=> $order->billing_first_name,
				'email' 		=> $order->billing_email,
				'phone' 		=> substr( $order->billing_phone, -10 ),
				'productinfo'	=> $productinfo,
				'surl' 			=> $redirect_url,
				'furl' 			=> $redirect_url,
				'lastname' 		=> $order->billing_last_name,
				'address1' 		=> $order->billing_address_1,
				'address2' 		=> $order->billing_address_2,
				'city' 			=> $order->billing_city,
				'state' 		=> $order->billing_state,
				'country' 		=> $order->billing_country,
				'zipcode' 		=> $order->billing_postcode,
				'curl'			=> $redirect_url,
				'pg' 			=> 'NB',
				'udf1' 			=> $order_id,
				'service_provider'	=> $service_provider
			);
			$payuindia_args_array = array();
			foreach($payuindia_args as $key => $value){
				$payuindia_args_array[] = "<input type='hidden' name='$key' value='$value'/>";
			}
			
			return '	<form action="'.$this->liveurl.'" method="post" id="payuindia_payment_form">
  				' . implode('', $payuindia_args_array) . '
				<input type="submit" class="button-alt" id="submit_payuindia_payment_form" value="'.__('Pay via PayU', 'woo_payuindia').'" /> <a class="button cancel" href="'.$order->get_cancel_order_url().'">'.__('Cancel order &amp; restore cart', 'woo_payuindia').'</a>
					<script type="text/javascript">
					jQuery(function(){
					jQuery("body").block({
						message: "'.__('Thank you for your order. We are now redirecting you to Payment Gateway to make payment.', 'woo_payuindia').'",
						overlayCSS: {
							background		: "#fff",
							opacity			: 0.6
						},
						css: {
							padding			: 20,
							textAlign		: "center",
							color			: "#555",
							border			: "3px solid #aaa",
							backgroundColor	: "#fff",
							cursor			: "wait",
							lineHeight		: "32px"
						}
					});
					jQuery("#submit_payuindia_payment_form").click();});
					</script>
				</form>';		
		
		} //END-generate_payuindia_form

        /**
         * Process the payment and return the result
         **/
        function process_payment($order_id){
			global $woocommerce;
            $order = new WC_Order($order_id);
			
			if ( version_compare( WOOCOMMERCE_VERSION, '2.1.0', '>=' ) ) { // For WC 2.1.0
			  	$checkout_payment_url = $order->get_checkout_payment_url( true );
			} else {
				$checkout_payment_url = get_permalink( get_option ( 'woocommerce_pay_page_id' ) );
			}

			return array(
				'result' => 'success', 
				'redirect' => add_query_arg(
					'order', 
					$order->id, 
					add_query_arg(
						'key', 
						$order->order_key, 
						$checkout_payment_url						
					)
				)
			);
		} //END-process_payment

        /**
         * Check for valid gateway server callback
         **/
        function check_payuindia_response(){
            global $woocommerce;

			if( isset($_REQUEST['txnid']) && isset($_REQUEST['mihpayid']) ){
				$order_id = $_REQUEST['udf1'];
				if($order_id != ''){
					try{
						$order = new WC_Order( $order_id );
						$hash = $_REQUEST['hash'];
						$status = $_REQUEST['status'];
						//<SALT>|status||||||udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key
						$check = "$this->key_secret|$_REQUEST[status]||||||||||$_REQUEST[udf1]|$_REQUEST[email]|$_REQUEST[firstname]|$_REQUEST[productinfo]|$_REQUEST[amount]|$_REQUEST[txnid]|$this->key_id";
						if($_REQUEST['additionalCharges']){
							$check = $_REQUEST['additionalCharges'].'|'.$check;
						}
						$checkhash = hash('sha512', $check);
						$trans_authorised = false;
						
						if( 'completed' !== $order->status ){
							if($hash == $checkhash){
								$status = strtolower($status);
								if( 'success' == $status ){
									$trans_authorised = true;
									$this->msg['message'] = "Thank you for the order. Your account has been charged and your transaction is successful.";
									$this->msg['class'] = 'success';
									if( 'processing' == $order->status ){
										$order->add_order_note('PayU ID: '.$_REQUEST['mihpayid'].' ('.$_REQUEST['txnid'].')<br/>PG: '.$_REQUEST['PG_TYPE'].'('.$_REQUEST['unmappedstatus'].')<br/>Bank Ref: '.$_REQUEST['bank_ref_num'].'('.$_REQUEST['mode'].')');
									}else{																				
										$order->payment_complete();
										$order->add_order_note('PayU payment successful.<br/>PayU ID: '.$_REQUEST['mihpayid'].' ('.$_REQUEST['txnid'].')<br/>PG: '.$_REQUEST['PG_TYPE'].'('.$_REQUEST['unmappedstatus'].')<br/>Bank Ref: '.$_REQUEST['bank_ref_num'].'('.$_REQUEST['mode'].')');
										$woocommerce->cart->empty_cart();
									}
								}else if( 'pending' == $status ){
									$trans_authorised = true;
									$this->msg['message'] = "Thank you for the order. Right now your payment status is pending. We will keep you posted regarding the status of your order through eMail";
									$this->msg['class'] = 'notice';
									$order->add_order_note('PayU Money payment status is pending<br/>PayU Money ID: '.$_REQUEST['mihpayid'].' ('.$_REQUEST['txnid'].')<br/>PG: '.$_REQUEST['PG_TYPE'].'('.$_REQUEST['unmappedstatus'].')<br/>Bank Ref: '.$_REQUEST['bank_ref_num'].'('.$_REQUEST['mode'].')');
									$order->update_status('on-hold');
									$woocommerce -> cart -> empty_cart();
								}else{
									$this->msg['class'] = 'error';
									$this->msg['message'] = "Thank you for the order. However, the transaction has been declined.";
									$order->add_order_note('Transaction ERROR: '.$_REQUEST['error'].'<br/>PayU Money ID: '.$_REQUEST['mihpayid'].' ('.$_REQUEST['txnid'].')<br/>PG: '.$_REQUEST['PG_TYPE'].'('.$_REQUEST['unmappedstatus'].')<br/>Bank Ref: '.$_REQUEST['bank_ref_num'].'('.$_REQUEST['mode'].')');
								}
							}else{
								$this->msg['class'] = 'error';
								$this->msg['message'] = "Security Error. Illegal access detected.";
								$order->add_order_note('Checksum ERROR: '.json_encode($_REQUEST));
							}
							if( false == $trans_authorised) {
								$order->update_status('failed');
							}
							//removed for WooCommerce 2.0
							//add_action('the_content', array(&$this, 'payupaisa_showMessage'));
						}
					}catch(Exception $e){
                        // $errorOccurred = true;
                        $msg = "Error";
					}
				}


				if ( function_exists( 'wc_add_notice' ) ) {
					wc_add_notice( $msg['message'], $msg['class'] );

				} else {
					if( 'success' == $msg['class'] ) {
						$woocommerce->add_message( $msg['message']);
					}else{
						$woocommerce->add_error( $msg['message'] );

					}
					$woocommerce->set_messages();
				}	
				
				// @see: https://wordpress.org/support/topic/enabling-default-woocommerce-redirects/#post-9728440
				if('success' == $this->msg['class']) {
					if ( '' == $this->redirect_page || 0 == $this->redirect_page ) {
						$redirect_url = $this->get_return_url( $order );
					} else {
						$redirect_url = get_permalink( $this->redirect_page );
					}
				} else {
					$redirect_url = wc_get_checkout_url();
				}
				
				wc_print_notices();
				
				wp_redirect( $redirect_url );
                exit;
	
			}

        } //END-check_payuindia_response

        /**
         * Get Page list from WordPress
         **/
		function payuindia_get_pages($title = false, $indent = true) {
			$wp_pages = get_pages('sort_column=menu_order');
			$page_list = array();
			if ($title) $page_list[] = $title;
			foreach ($wp_pages as $page) {
				$prefix = '';
				// show indented child pages?
				if ($indent) {
                	$has_parent = $page->post_parent;
                	while($has_parent) {
                    	$prefix .=  ' - ';
                    	$next_page = get_post($has_parent);
                    	$has_parent = $next_page->post_parent;
                	}
            	}
            	// add to page list array array
            	$page_list[$page->ID] = $prefix . $page->post_title;
        	}
        	return $page_list;
		} //END-payuindia_get_pages

	} //END-class
	
	/**
 	* Add the Gateway to WooCommerce
 	**/
	function woocommerce_add_gateway_payuindia_gateway($methods) {
		$methods[] = 'WC_Gateway_PayUindia';
		return $methods;
	}//END-wc_add_gateway
	
	add_filter('woocommerce_payment_gateways', 'woocommerce_add_gateway_payuindia_gateway' );
	
} //END-init

/**
* 'Settings' link on plugin page
**/
add_filter( 'plugin_action_links', 'payuindia_add_action_plugin', 10, 5 );
function payuindia_add_action_plugin( $actions, $plugin_file ) {
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="admin.php?page=wc-settings&tab=checkout&section=wc_gateway_payuindia">' . __('Settings') . '</a>');
		
    			$actions = array_merge($settings, $actions);
			
		}
		
		return $actions;
}//END-settings_add_action_link