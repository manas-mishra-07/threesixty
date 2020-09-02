<?php
namespace Wdr\App\Controllers\Admin\Tabs\Reports;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class RuleAmountWithCartDiscount extends RuleAmount {
	public function get_title() {
		return __( 'Rule amount data with cart discounts', WDR_TEXT_DOMAIN );
	}

	public function get_subtitle() {
		return __( 'TOP 5', WDR_TEXT_DOMAIN );
	}

	protected function prepare_params( $params ) {
		$params['include_cart_discount'] = true;

		return $params;
	}
}