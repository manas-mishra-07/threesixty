<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package the launcher
 */

get_header(); ?>
<div class="ak-container">
	<div id="primary" class="content-area content-area-no">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404', 'the-launcher' ); ?><span><?php esc_html_e( 'Error', 'the-launcher' ); ?></span></h1>
                    <span class="page_desc_404"><?php esc_html_e('Page Not Found','the-launcher'); ?></span>
				</header><!-- .page-header -->
				<!-- .page-content -->
                
			</section><!-- .error-404 -->

		</main><!-- #main -->

	</div><!-- #primary -->
	</div>

<?php get_footer(); ?>
