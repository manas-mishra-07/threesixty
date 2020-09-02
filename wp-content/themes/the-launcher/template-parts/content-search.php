<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package the launcher
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php the_launcher_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary archive">
		<div class="single_post_content wow fadeInUp"><?php echo apply_filters('the_content' , wp_kses_post(wp_trim_words(get_the_content(),100,'...')));?><div class="read_more"><a href="<?php the_permalink(); ?>"><?php _e('Read More','the-launcher'); ?></a></div></div>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php the_launcher_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

