<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package the launcher
 */

if ( ! is_active_sidebar( 'the-launcher-sidebar-1' ) ) {
	return;
} ?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'the-launcher-sidebar-1' ); ?>
</div><!-- #secondary -->
