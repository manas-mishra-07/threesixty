<?php
	/** Woocommerce Hooks **/

	/** Configuring Necessary Wrappers for the woocommerce pages **/
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_before_main_content', 'the_launcher_starter_wrap', 11 );

	function the_launcher_starter_wrap() {
		?>
			<div class="ak-container">
    			<div id="primary" class="content-area-right">
		<?php
	}

	add_action( 'woocommerce_after_main_content', 'the_launcher_end_wrap', 11 );

	function the_launcher_end_wrap() {
		?>
				</div>
		<?php
	}

	add_action('woocommerce_sidebar', 'the_launcher_after_sidebar', 11);

	function the_launcher_after_sidebar() {
		?>
			<div id="secondary" class="widget-area widget-area-right" role="complementary">
                <?php dynamic_sidebar('the-launcher-sidebar-1');?>
            </div>
		</div>
		<?php
	}

	/**
	* Woo Commerce Number of row filter Function
	**/

	add_filter('loop_shop_columns', 'scrollme_loop_columns');
	if (!function_exists('scrollme_loop_columns')) {
	   function scrollme_loop_columns() {
	       $xr = 3;
	       return $xr;
	   }
	}

	add_action( 'body_class', 'scrollme_woo_body_class');
	if (!function_exists('scrollme_woo_body_class')) {
	   function scrollme_woo_body_class( $class ) {
	          $class[] = 'columns-'.scrollme_loop_columns();
	          return $class;
	   }
	}