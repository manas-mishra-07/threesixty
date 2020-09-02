<?php

add_filter( 'ig_es_settings_tabs', 'ig_es_add_settings_tabs', 10, 1 );
add_filter( 'ig_es_registered_settings', 'ig_es_add_upsale', 10, 2 );
add_filter( 'ig_es_mailers', 'ig_es_mailers_promo', 10, 1 );

// Add additional tab "Comments" in Audience > Sync
add_filter( 'ig_es_sync_users_tabs', 'ig_es_add_sync_users_tabs', 11, 1 );

add_action( 'ig_es_sync_users_tabs_comments', 'ig_es_add_comments_tab_settings' );
add_action( 'ig_es_sync_users_tabs_woocommerce', 'ig_es_add_woocommerce_tab_settings' );
add_action( 'ig_es_sync_users_tabs_cf7', 'ig_es_add_cf7_tab_settings' );
add_action( 'ig_es_sync_users_tabs_give', 'ig_es_add_give_tab_settings' );
add_action( 'ig_es_sync_users_tabs_wpforms', 'ig_es_add_wpforms_tab_settings' );
add_action( 'ig_es_sync_users_tabs_ninja_forms', 'ig_es_add_ninja_forms_tab_settings' );
add_action( 'ig_es_sync_users_tabs_edd', 'ig_es_add_edd_tab_settings' );

add_action( 'edit_form_advanced', 'add_spam_score_utm_link' );

add_action( 'ig_es_add_additional_options', 'ig_es_add_captcha_option', 10, 1 );
add_action( 'ig_es_after_broadcast_content_left_pan_settings','ig_es_additional_send_email_option');
add_action( 'ig_es_after_broadcast_tracking_options_settings', 'ig_es_additional_track_option');
add_action( 'ig_es_broadcast_scheduling_options_settings', 'ig_es_additional_schedule_option');
add_action( 'ig_es_after_broadcast_right_pan_settings', 'ig_es_additional_spam_score_option');

/**
 * Promote SMTP mailer for free
 *
 * @param $mailers
 *
 * @return mixed
 *
 * @since 4.4.5
 */
function ig_es_mailers_promo( $mailers ) {

	if ( ! ES()->is_premium() ) {

		$mailers['smtp'] = array(
			'name'       => 'SMTP',
			'logo'       => ES_PLUGIN_URL . 'lite/admin/images/smtp.png',
			'is_premium' => true,
			'url'        => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'smtp_mailer' )
		)
		);

	}

	return $mailers;
}

/**
 * Promote User Permission Settings
 *
 * @return false|string
 *
 * @since 4.4.5
 */
function render_user_permissions_settings_fields_premium() {
	$wp_roles   = new WP_Roles();
	$roles      = $wp_roles->get_names();
	$user_roles = array();

	$url = ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'user_roles' ) );

	ob_start();
	?>

	<div class="text-center py-4 lg:px-4 my-8">
		<div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex mx-4 leading-normal" role="alert">
			<span class="font-semibold text-left flex-auto">
				Customize user roles permissions with <a href="<?php echo $url; ?>" target="_blank" class="text-indigo-400">Email Subscribers PRO</a>
			</span>
		</div>
	</div>


	<table class="min-w-full rounded-lg">
		<thead>
			<tr class="bg-gray-100 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
				<th class="px-5 py-4"><?php _e( 'Roles', 'email-subscribers' ); ?></th>
				<th class="px-2 py-4 text-center"><?php _e( 'Audience', 'email-subscribers' ); ?></th>
				<th class="px-2 py-4 text-center"><?php _e( 'Forms', 'email-subscribers' ); ?></th>
				<th class="px-2 py-4 text-center"><?php _e( 'Campaigns', 'email-subscribers' ); ?></th>
				<th class="px-2 py-4 text-center"><?php _e( 'Reports', 'email-subscribers' ); ?></th>
				<th class="px-2 py-4 text-center"><?php _e( 'Sequences', 'email-subscribers' ); ?></th>
				<th class="px-2 py-4 text-center"><?php _e( 'Workflows', 'email-subscribers' ); ?></th>
			</tr>
		</thead>
		<tbody class="bg-white">
			<?php foreach ( $roles as $key => $value ) {
				?>
				<tr class="border-b border-gray-200">
					<td class="pl-8 py-4 ">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<span class="text-sm leading-5 font-medium text-center text-gray-800"><?php echo $value; ?></span>
							</div>
						</div>
					</td>
					<td class="whitespace-no-wrap text-center">
						<input type="checkbox" name="" disabled <?php ! empty( $user_roles['audience'][ $key ] ) ? checked( 'yes', $user_roles['audience'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
					</td>
					<td class="whitespace-no-wrap text-center">
						<input type="checkbox" name="" disabled<?php ! empty( $user_roles['forms'][ $key ] ) ? checked( 'yes', $user_roles['forms'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
					</td>
					<td class="whitespace-no-wrap text-center">
						<input type="checkbox" name="" disabled <?php ! empty( $user_roles['campaigns'][ $key ] ) ? checked( 'yes', $user_roles['campaigns'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
					</td>
					<td class="whitespace-no-wrap text-center">
						<input type="checkbox" name="" disabled <?php ! empty( $user_roles['reports'][ $key ] ) ? checked( 'yes', $user_roles['reports'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
					</td>
					<td class="whitespace-no-wrap text-center">
						<input type="checkbox" name="" disabled <?php ! empty( $user_roles['sequences'][ $key ] ) ? checked( 'yes', $user_roles['sequences'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
					</td>
					<td class="whitespace-no-wrap text-center">
						<input type="checkbox" name="" disabled <?php ! empty( $user_roles['workflows'][ $key ] ) ? checked( 'yes', $user_roles['workflows'][ $key ] ) : '' ?> value="yes" class=" form-checkbox text-indigo-600">
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>


	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * @param $es_settings_tabs
 *
 * @return mixed
 */
function ig_es_add_settings_tabs( $es_settings_tabs ) {

	if ( ! ES()->is_premium() ) {
		$es_settings_tabs['user_roles'] = array( 'icon' => 'groups', 'name' => __( 'User Roles', 'email-subscribers' ) );
	}

	return $es_settings_tabs;
}

function ig_es_add_upsale( $fields ) {

	if ( ! ES()->is_pro() ) {

		$utm_args = array(
			'utm_medium' => 'track_clicks'
		);

		$premium_url = ES_Common::get_utm_tracking_url( $utm_args );
		// General Settings
		$track_link_click = array(
			'ig_es_track_link_click' => array(
				'id'            => 'ig_es_track_link_click_p',
				'name'          => __( 'Track Clicks', 'email-subscribers' ),
				'type'          => 'checkbox',
				'default'       => 'no',
				'is_premium'    => true,
				'link'          => $premium_url,
				'disabled'      => true,
				'upgrade_title' => sprintf( __( "<a href='%s' target='_blank'>Upgrade to ES PRO</a>", 'email-subscribers' ), $premium_url ),
				'upgrade_desc'  => __( 'Get insights about link clicks. See who are clicking on which links?', 'email-subscribers' )
			)
		);

		$utm_args = array(
			'utm_medium' => 'track_utm'
		);

		$premium_url = ES_Common::get_utm_tracking_url( $utm_args );

		$track_utm = array(
			'ig_es_track_utm'	=> array(
				'id'      		=> 'ig_es_track_utm',
				'name'    		=> __( 'UTM Tracking', 'email-subscribers' ),
				'type'    		=> 'checkbox',
				'default' 		=> 'no',
				'is_premium'    => true,
				'link'          => $premium_url,
				'disabled'      => true,
				'upgrade_title' => sprintf( __( "<a href='%s' target='_blank'>Upgrade to ES PRO</a>", 'email-subscribers' ), $premium_url ),
				'upgrade_desc'  => __( 'Get insights about UTM tracking.', 'email-subscribers' )

			)
		);

		$general_fields = $fields['general'];

		$general_fields = ig_es_array_insert_after( $general_fields, 'ig_es_track_email_opens', $track_link_click );
		$general_fields = ig_es_array_insert_after( $general_fields, 'ig_es_track_link_click', $track_utm );

		$fields['general'] = $general_fields;
	}

	if ( ! ES()->is_premium_installed() ) {

		$utm_args = array(
			'utm_medium' => 'enable_captcha'
		);

		$premium_url = ES_Common::get_utm_tracking_url( $utm_args );

		// Security Settings
		$fake_domains['ig_es_enable_known_attackers_domains'] = array(
			'id'         => 'ig_es_enable_known_attackers_domains_p',
			'name'       => __( 'Block Known Attackers', 'email-subscribers' ),
			'info'       => __( 'Stop known spam bot attacker domains from signing up. Keeps this list up-to-date with Icegram servers.', 'email-subscribers' ),
			'type'       => 'checkbox',
			'default'    => 'no',
			'is_premium' => true,
			'link'       => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'known_attackers' ) ),
			'disabled'   => true
		);

		$managed_blocked_domains['ig_es_enable_disposable_domains'] = array(
			'id'         => 'ig_es_enable_disposable_domains_p',
			'name'       => __( 'Block Temporary / Fake Emails', 'email-subscribers' ),
			'info'       => __( 'Plenty of sites provide disposable / fake / temporary email addresses. People use them when they don\'t want to give you their real email. Block these to keep your list clean. Automatically updated.', 'email-subscribers' ),
			'type'       => 'checkbox',
			'default'    => 'no',
			'is_premium' => true,
			'link'       => ES_Common::get_utm_tracking_url( array( 'utm_medium' => 'disposable_domains' ) ),
			'disabled'   => true
		);

		//add captcha setting
		$field_captcha['enable_captcha'] = array(
			'id'            => 'ig_es_enable_captcha_p',
			'name'          => __( 'Enable Captcha', 'email-subscribers' ),
			'info'          => __( 'Show a captcha in subscription forms to protect from bot signups.', 'email-subscribers' ),
			'type'          => 'checkbox',
			'default'       => 'no',
			'is_premium'    => true,
			'link'          => $premium_url,
			'disabled'      => true,
			'upgrade_title' => sprintf( __( "<a href='%s' target='_blank'>Upgrade to ES PRO</a>", 'email-subscribers' ), $premium_url ),
			'upgrade_desc'  => __( 'Secure your form and avoid spam signups with form Captcha', 'email-subscribers' ),
		);

		$fields['security_settings'] = array_merge( $fields['security_settings'], $fake_domains, $managed_blocked_domains, $field_captcha );

		$fields['user_roles'] = array(
			'ig_es_user_roles' => array(
				'id'   => 'ig_es_user_roles',
				'name' => '',
				'type' => 'html',
				'html' => render_user_permissions_settings_fields_premium()
			)
		);

	}

	return $fields;
}

function ig_es_add_sync_users_tabs( $tabs ) {
	global $ig_es_tracker;

	// Show integrations only if ES Premium is not installed.
	if ( ! ES()->is_starter() ) {

		$tabs['comments'] = array(
			'name'             => __( 'Comments', 'email-subscribers' ),
			'indicator_option' => 'ig_es_show_sync_comment_users_indicator',
			'indicator_label'  => 'Starter'
		);

		$woocommerce_plugin = 'woocommerce/woocommerce.php';

		// Is WooCommmerce active? Show WooCommerce integration
		$active_plugins = $ig_es_tracker::get_active_plugins();
		if ( in_array( $woocommerce_plugin, $active_plugins ) ) {
			$tabs['woocommerce'] = array(
				'name'             => __( 'WooCommerce', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_woocommerce_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Is Contact Form 7 active? Show CF7 integration.
		$contact_form_7 = 'contact-form-7/wp-contact-form-7.php';
		if ( in_array( $contact_form_7, $active_plugins ) ) {
			$tabs['cf7'] = array(
				'name'             => __( 'Contact Form 7', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_cf7_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		$wpforms_plugin = 'wpforms-lite/wpforms.php';
		if ( in_array( $wpforms_plugin, $active_plugins ) ) {
			$tabs['wpforms'] = array(
				'name'             => __( 'WPForms', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_wpforms_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Show only if Give is installed & activated
		$give_plugin = 'give/give.php';
		if ( in_array( $give_plugin, $active_plugins ) ) {
			$tabs['give'] = array(
				'name'             => __( 'Give', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_give_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Show only if Ninja Forms is installed & activated
		$ninja_forms_plugin = 'ninja-forms/ninja-forms.php';
		if ( in_array( $ninja_forms_plugin, $active_plugins ) ) {
			$tabs['ninja_forms'] = array(
				'name'             => __( 'Ninja Forms', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_ninja_forms_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

		// Show only if EDD is installed & activated
		$edd_plugin = 'easy-digital-downloads/easy-digital-downloads.php';
		if ( in_array( $edd_plugin, $active_plugins ) ) {
			$tabs['edd'] = array(
				'name'             => __( 'EDD', 'email-subscribers' ),
				'indicator_option' => 'ig_es_show_sync_edd_users_indicator',
				'indicator_label'  => 'Starter'
			);
		}

	}

	return $tabs;
}

function ig_es_add_comments_tab_settings( $tab_options ) {

	// If you want to hide once shown. Set it to 'no'
	// If you don't want to hide. do not use following code or set value as 'yes'
	/*
	if ( ! empty( $tab_options['indicator_option'] ) ) {
		update_option( $tab_options['indicator_option'], 'yes' ); // yes/no
	}
	*/

	$info = array(
		'type' => 'info'
	);

	ob_start();
	?>
	<div class="">
		<h2><?php _e( 'Sync Comment Users', 'email-subscribers' ) ?></h2>
		<p><?php _e( 'Quickly add to your mailing list when someone post a comment on your website.', 'email-subscribers' ) ?></p>
		<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
		<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=comment_sync&utm_campaign=es_upsell#sync_comment_users"><?php _e( 'Email Subscribers Starter', 'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Comment user sync and select the list in which you want to add people whenever someone post a
		comment.', 'email-subscribers' ) ?></p>
		<hr>
		<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=comment_sync&utm_campaign=es_upsell#sync_comment_users"><?php _e( 'Email Subscribers Starter', 'email-subscribers' ) ?></a> <?php _e( 'now', 'email-subscribers' ) ?></p>
	</div>
	<?php

	$content = ob_get_clean();

	?>
	<a target="_blank" href="https://www.icegram.com/quickly-add-people-to-your-mailing-list-whenever-someone-post-a-comment/?utm_source=in_app&utm_medium=es_comment_upsale&utm_campaign=es_upsell#sync_comment_users">
		<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/es-comments.png' ?> "/>
	</a>
	<?php
	ES_Common::prepare_information_box( $info, $content );
}

function ig_es_add_woocommerce_tab_settings( $tab_options ) {

	$info = array(
		'type' => 'info',
	);

	ob_start();
	?>
	<div class="">
		<h2><?php _e( 'Sync WooCommerce Customers', 'email-subscribers' ) ?></h2>
		<p><?php _e( 'Are you using WooCommerce for your online business? You can use this integration to add to a specific list whenever someone make a purchase from you', 'email-subscribers' ) ?></p>
		<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
		<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=woocommerce_sync&utm_campaign=es_upsell#sync_woocommerce_customers"><?php _e( 'Email Subscribers Starter', 'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable WooCommerce sync and select the list in which you want to add people whenever they
			purchase something
			from you.', 'email-subscribers' ) ?></p>
			<hr>
			<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=woocommerce_sync&utm_campaign=es_upsell#sync_woocommerce_customers">Email Subscribers Starter</a> Now</p>
		</div>
		<?php $content = ob_get_clean(); ?>

		<a target="_blank" href="https://www.icegram.com/quickly-add-customers-to-your-mailing-list/?utm_source=in_app&utm_medium=woocommerce_sync&utm_campaign=es_upsell#sync_woocommerce_customers">
			<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/woocommerce-sync.png' ?> "/>
		</a>

		<?php

		ES_Common::prepare_information_box( $info, $content );

		?>

		<?php
	}

	function ig_es_add_cf7_tab_settings( $tab_options ) {

		$info = array(
			'type' => 'info',
		);

		ob_start();
		?>
		<div class="">
			<h2><?php _e( 'Sync Contact Form 7 users', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Are you using Contact Form 7 for your list building? You can use this integration to add to a specific list whenever new subscribers added from Contact Form 7', 'email-subscribers' ) ?></p>
			<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=cf7_sync&utm_campaign=es_upsell#sync_cf7_subscribers"><?php _e( 'Email Subscribers Starter',
			'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Contact form 7 sync and select the list in which you want to add people whenever they fill any of the Contact Form.', 'email-subscribers' ) ?></p>
			<hr>
			<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=cf7_sync&utm_campaign=es_upsell#sync_cf7_subscribers">Email Subscribers Starter</a> Now</p>
		</div>
		<?php $content = ob_get_clean(); ?>

		<a target="_blank" href="https://www.icegram.com/add-people-to-your-mailing-list-whenever-they-submit-any-of-the-contact-form-7-form/?utm_source=in_app&utm_medium=cf7_sync&utm_campaign=es_upsell#sync_cf7_subscribers">
			<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/cf7-sync.png' ?> "/>
		</a>

		<?php

		ES_Common::prepare_information_box( $info, $content );

		?>

		<?php
	}

	function ig_es_add_give_tab_settings( $tab_options ) {

		$info = array(
			'type' => 'info',
		);

		ob_start();
		?>
		<div class="">
			<h2><?php _e( 'Sync Donors', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'We found that you are using Give WordPress plugin to collect donations. Now, with this integration, you can add your donors to any of your subscriber list and send them Newsletters in future.', 'email-subscribers' ) ?></p>
			<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=give_sync&utm_campaign=es_upsell#sync_give_donors"><?php _e( 'Email Subscribers Starter',
			'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Give integration and select the list in which you want to add people whenever they make donation.', 'email-subscribers' ) ?></p>
			<hr>
			<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=give_sync&utm_campaign=es_upsell#sync_give_donors">Email Subscribers Starter</a> Now</p>
		</div>
		<?php $content = ob_get_clean(); ?>

		<a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=give_sync&utm_campaign=es_upsell#sync_give_donors">
			<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/give-sync.png' ?> "/>
		</a>

		<?php

		ES_Common::prepare_information_box( $info, $content );

		?>

		<?php
	}

	function ig_es_add_wpforms_tab_settings( $tab_options ) {

		$info = array(
			'type' => 'info',
		);

		ob_start();
		?>
		<div class="">
			<h2><?php _e( 'Sync Donors', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Are you using Give WordPress plugin to collect donations? Want to send Thank You email to them? You can use this integration to be in touch with them.', 'email-subscribers' ) ?></p>
			<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=wpforms_sync&utm_campaign=es_upsell#sync_wpforms_contacts"><?php _e( 'Email Subscribers Starter',
			'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Give sync and select the list in which you want to add people whenever they make donation.', 'email-subscribers' ) ?></p>
			<hr>
			<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=wpforms_sync&utm_campaign=es_upsell#sync_wpforms_contacts">Email Subscribers Starter</a> Now</p>
		</div>
		<?php $content = ob_get_clean(); ?>

		<a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=wpforms_sync&utm_campaign=es_upsell#sync_wpforms_contacts">
			<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/wpforms-sync.png' ?> "/>
		</a>

		<?php

		ES_Common::prepare_information_box( $info, $content );

		?>

		<?php
	}

	function ig_es_add_ninja_forms_tab_settings( $tab_options ) {

		$info = array(
			'type' => 'info',
		);

		ob_start();
		?>
		<div class="">
			<h2><?php _e( 'Sync Contacts', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'We found that you are using Ninja Forms. Want to add your contact to a mailing list? You can use this integration to add your contact to add into mailing list', 'email-subscribers' ) ?></p>
			<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=ninja_forms_sync&utm_campaign=es_upsell#sync_ninja_forms_contacts"><?php _e( 'Email Subscribers Starter',
			'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable Give sync and select the list in which you want to add people whenever they make donation.', 'email-subscribers' ) ?></p>
			<hr>
			<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=ninja_forms_sync&utm_campaign=es_upsell#sync_ninja_forms_contacts">Email Subscribers Starter</a> Now</p>
		</div>
		<?php $content = ob_get_clean(); ?>

		<a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=ninja_forms_sync&utm_campaign=es_upsell#sync_ninja_forms_contacts">
			<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/ninja-forms-sync.png' ?> "/>
		</a>

		<?php

		ES_Common::prepare_information_box( $info, $content );

		?>

		<?php
	}

	function ig_es_add_edd_tab_settings( $tab_options ) {

		$info = array(
			'type' => 'info',
		);

		ob_start();
		?>
		<div class="">
			<h2><?php _e( 'Sync Customers', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'We found that you are using EDD to sell digital goods online. You can use this integration to send Newsletters/ Post Notifications to your customers.', 'email-subscribers' ) ?></p>
			<h2><?php _e( 'How to setup?', 'email-subscribers' ) ?></h2>
			<p><?php _e( 'Once you upgrade to ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-starter/?utm_source=in_app&utm_medium=edd_sync&utm_campaign=es_upsell#sync_edd_customers"><?php _e( 'Email Subscribers Starter',
			'email-subscribers' ) ?></a>, <?php _e( 'you will have settings panel where you need to enable EDD sync and select the list in which you want to add people whenever they purchase something from you.', 'email-subscribers' ) ?></p>
			<hr>
			<p class="help"><?php _e( 'Checkout ', 'email-subscribers' ) ?><a target="_blank" href="https://www.icegram.com/email-subscribers-pricing/?utm_source=in_app&utm_medium=edd_sync&utm_campaign=es_upsell#sync_edd_customers">Email Subscribers Starter</a> Now</p>
		</div>
		<?php $content = ob_get_clean(); ?>

		<a target="_blank" href="https://www.icegram.com/email-subscribers/?utm_source=in_app&utm_medium=edd_sync&utm_campaign=es_upsell#sync_edd_customers">
			<img src=" <?php echo ES_PLUGIN_URL . 'lite/admin/images/edd-sync.png' ?> "/>
		</a>

		<?php

		ES_Common::prepare_information_box( $info, $content );

		?>

		<?php
	}


	function add_spam_score_utm_link() {
		global $post, $pagenow, $ig_es_tracker;
		if ( $post->post_type !== 'es_template' ) {
			return;
		}

		if ( ! ES()->is_starter() ) {
			?>
			<script>
				jQuery('#submitdiv').after('<div class="es_upsale"><a style="text-decoration:none;" target="_blank" href="https://www.icegram.com/documentation/how-ready-made-template-in-in-email-subscribers-look/?utm_source=in_app&utm_medium=es_template&utm_campaign=es_upsell"><img title="Get readymade templates" style="width:100%;border:0.3em #d46307 solid" src="<?php echo ES_PLUGIN_URL?>lite/admin/images/starter-tmpl.png"/><p style="background: #d46307; color: #FFF; padding: 4px; width: 100%; text-align:center">Get readymade beautiful email templates</p></a></div>');
			</script>
			<?php
		}
	}

/**
 * Upsale ES PRO on Form Captcha
 *
 * @param $form_data
 *
 * @since 4.4.7
 */
function ig_es_add_captcha_option( $form_data ) {

	if ( ! ES()->is_premium_installed() ) {

		$utm_args = array(
			"utm_medium" => "es_form_captcha"
		);

		$pricing_url = ES_Common::get_utm_tracking_url( $utm_args );

		?>

		<div class="flex border-b border-gray-100 ">
			<div class="w-2/5 mr-16">
				<div class="flex flex-row w-full">
					<div class="flex w-2/4">
						<div class="ml-4 mr-8 mr-4 pt-4 mb-2">
							<label for="tag-link"><span class="block ml-4 pr-4 text-sm font-medium text-gray-600 pb-2"><?php echo __( 'Enable Captcha' ); ?></span></label>
							<p class="italic text-xs text-gray-400 mt-2 ml-4 leading-snug pb-4"><?php _e( 'Show a captcha to protect from bot signups.', 'email-subscribers' ); ?></p>
						</div>
					</div>
					<div class="flex">
						<div class="ml-16 mb-4 mr-4 mt-12">
							<label for="captcha" class=" inline-flex items-center cursor-pointer">
								<span class="relative">
									<span class="relative es-mail-toggle-line block w-10 h-6 bg-gray-300 rounded-full shadow-inner"></span>
									<span class="es-mail-toggle-dot absolute transition-all duration-300 ease-in-out block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline "></span>
								</span>
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="w-3/6 mt-3.5 pr-4">
				<div class="inline-flex rounded-md bg-teal-50 px-2 pt-1 w-full">
					<div class="px-2 pt-2 pb-2">
						<div class="flex">
							<div class="flex-shrink-0">
								<svg class='h-5 w-5 text-teal-400' fill='currentColor' viewBox='0 0 20 20'>
									<path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z' clip-rule='evenodd'/>
								</svg>
							</div>
							<div class="ml-3">
								<h3 class="text-sm leading-5 font-medium text-blue-800">
									<?php _e( sprintf("<a href='%s' target='_blank'>Upgrade to ES PRO</a>", $pricing_url), 'email-subscribers' ); ?>
								</h3>
								<div class="mt-2 text-sm leading-5 text-teal-700">
									<p>
										<?php _e( 'Secure your form and avoid spam signups with form Captcha', 'email-subscribers' ); ?>

										<?php if(ES_Common::can_show_coupon('PREMIUM10')) { _e( 'Get <b>10% flat discount</b> if you upgrade now!. <br /><br />Use coupon code <b>PREMIUM10</b>', 'email-subscribers' );}?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }
}

function ig_es_additional_send_email_option() {

	if ( ! ES()->is_pro() ) {  ?>

		<div>
			<input type="radio" name="preview_option" disabled="disabled" class="form-radio" id="preview_in_email" value="" >
			<label class=" text-sm font-normal leading-5 text-gray-700"><?php echo esc_html__( 'Email', 'email-subscribers' ); ?><span class="cursor-auto mx-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php _e('Premium','email-subscribers');?></span></label>
			<div id="preview_in_email" class="display_email_field px-4">
				<div class="flex py-2" >
					<div class="flex w-5/6">
						<input id="es_test_send_email" name="es_test_send_email" style="display: none;" class="border-gray-400 form-input text-sm relative rounded-md shadow-sm block w-3/4 sm:leading-5" placeholder="<?php echo esc_html__( 'Enter email', 'email-subscribers' ); ?>" />
					</div>
				</div>
			</div>
	<?php	}
}

function ig_es_additional_track_option() {

	if ( ! ES()->is_pro() ) { ?>

		<div class="flex w-full pt-3">
				<div class="w-11/12 text-sm font-normal text-gray-600"><?php echo esc_html__( 'Link Tracking', 'email-subscribers' ); ?><span class="mx-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php _e('Premium','email-subscribers');?></span>
				</div>

				<div>
					<label for="enable_link_tracking" class=" inline-flex items-center cursor-pointer">
						<span class="relative">
							<span class="es-mail-toggle-line block w-8 h-5 bg-gray-300 rounded-full shadow-inner"></span>
							<span class="es-mail-toggle-dot absolute transition-all duration-300 ease-in-out block w-3 h-3 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline"></span>
						</span>
					</label>
				</div>
			</div>

			<div class="flex w-full pt-3 pb-3 border-b border-gray-200">
							<div class="w-11/12 text-sm font-normal text-gray-600"><?php echo esc_html__( 'UTM Tracking', 'email-subscribers' ); ?><span class="mx-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php _e('Premium','email-subscribers');?></span>
				</div>

				<div >
					<label for="enable_utm_tracking" class=" inline-flex items-center cursor-pointer">
						<span class="relative">
							<span class="es-mail-toggle-line block w-8 h-5 bg-gray-300 rounded-full shadow-inner"></span>
							<span class="es-mail-toggle-dot absolute transition-all duration-300 ease-in-out block w-3 h-3 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline"></span>
						</span>
					</label>
				</div>
			</div>


	<?php	}

}

function ig_es_additional_schedule_option(){

	if ( ! ES()->is_pro() ) {

	   $utm_args = array(
			'utm_medium' => 'broadcast_summary'
		);

		$premium_url = ES_Common::get_utm_tracking_url( $utm_args );
	    ?>

		<div class="block w-full px-4 py-2">
				<span class="block text-sm font-medium leading-5 text-gray-700"><?php echo esc_html__( 'Send Options', 'email-subscribers' ); ?><span class=" mx-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php _e('Premium','email-subscribers');?></span></span>
				<div class="py-2">
					<input type="radio" class="form-radio" id="schedule_later" checked disabled>
					<label for="schedule_later" class="text-sm font-normal text-gray-600"><?php echo esc_html__( 'Schedule for Later', 'email-subscribers' ); ?>
				</label>
				<br>
				<div id="schedule_later" class="px-6">
				<div class="flex pt-4" >
					<div class="flex w-full w-11/12">
						<label class="text-sm font-normal leading-5 text-gray-700 pt-1"><?php echo esc_html__( 'Date', 'email-subscribers' ); ?></label>
						<input class="cursor-pointer font-normal text-sm py-1 ml-2 form-input" type="text" value="<?php echo date_i18n('Y-m-d');?>" disabled>
					</div>
					<div>
						<svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="text-gray-600 w-5 h-5 my-1 ml-2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
					</div>
				</div>
				<div class="flex pt-3" >
					<div class="flex w-11/12">
						<label class="text-sm font-normal leading-5 text-gray-700 pt-1"><?php echo esc_html__( 'Time', 'email-subscribers' ); ?></label>
						<input class="cursor-pointer font-normal text-sm py-1 ml-2 form-input" type="text" value="<?php echo date_i18n("h:i A");?>" disabled>

					</div>
					<div>
						<svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="text-gray-600 w-5 h-5 my-1 ml-2 float-right"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
					</div>
				</div>
				<div class="pb-3">
					<div class="block px-2 py-2 mt-4 bg-gray-300 rounded-md ">
						<h3 class="text-gray-700 text-sm font-normal"><?php echo esc_html__( 'Local Time: ', 'email-subscribers' ); ?>&nbsp;&nbsp;
							<?php echo date_i18n("Y-m-d H:i a" ) ?>
						</h3>
					</div>
				</div>
			</div>

				<div class="block py-2 mt-2 ">
					<div class="inline-flex rounded-md bg-teal-100 px-2 pt-1 w-full">
						<div class="px-2 pt-2 pb-2">
							<div class="flex">
								<div class="flex-shrink-0">
									<svg class='h-5 w-5 text-teal-400' fill='currentColor' viewBox='0 0 20 20'>
										<path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z' clip-rule='evenodd'/>
									</svg>
								</div>
								<div class="ml-3">
									<h3 class="text-sm leading-5 font-medium text-blue-800">
										<?php echo sprintf( __( "<a href='%s' target='_blank'>Upgrade to ES PRO</a>", 'email-subscribers' ), $premium_url ); ?>
									</h3>
									<div class="mt-2 text-sm leading-5 text-teal-700">
										<p>
											<?php _e( 'Link Tracking, UTM Tracking and Scheduling Options are part of Email Subscribers PRO', 'email-subscribers' ); ?>
											<?php if(ES_Common::can_show_coupon('PREMIUM10')) {  echo "<br /><br />"; _e( 'Get <b>10% flat discount</b> if you upgrade now!. <br /><br />Use coupon code <b>PREMIUM10</b>', 'email-subscribers' );}?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php }
}

function ig_es_additional_spam_score_option() {
		if ( ! ES()->is_pro() ) { ?>

		<div class="block mx-4 my-3">
				<span class="pt-3 text-sm font-medium leading-5 text-gray-700"><?php echo esc_html__( 'Get Spam Score','email-subscribers');?><span class=" mx-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php _e('Premium', 'email-subscribers' ); ?></span></span>
				<button type="button" id="spam_score" disabled class="float-right es_spam rounded-md border text-indigo-600 border-indigo-500 text-sm leading-5 font-medium inline-flex justify-center px-3 py-1"><?php echo esc_html__( 'Check', 'email-subscribers' ); ?>
				</button>
			</div>
		<?php } 
	
}

