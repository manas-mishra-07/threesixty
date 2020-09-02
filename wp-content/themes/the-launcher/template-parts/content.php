<?php
/**
 * Template part for displaying posts.
 *
 * @package the launcher
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	 <div class="entry-content"><?php 
            $the_launcher_archive_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'the_launcher_single_page_archive');
            if($the_launcher_archive_img){
                $the_launcher_archive_img_src = $the_launcher_archive_img[0];?>
                <div class="single_post_image wow fadeInUp"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($the_launcher_archive_img_src);?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" /></a></div>
            <?php } 
        if(get_the_title()){
            ?>
            <header class="entry-header wow fadeInUp">
                <div class="entry-meta">
                    <h1 class="entry-title"> <a href="<?php the_permalink() ?>"><?php the_title(); ?> </a></h1>
                </div><!-- .entry-meta -->
            </header><!-- .entry-header -->
        <?php } ?>
        <div class="comment_author_date wow fadeInUp">
            <span class="launcher_date"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo esc_attr(get_the_date('Y M d')); ?></span>
            <?php $the_launcher_author = get_the_author();
            if($the_launcher_author){ ?> 
                <span class="launcher_author"><i class="fa fa-user" aria-hidden="true"></i><?php _e('By ','the-launcher'); echo esc_attr($the_launcher_author); ?></span>
            <?php } ?>
            <span class="launcher_comment"><i class="fa fa-comments" aria-hidden="true"></i><?php echo absint(get_comments_number()); _e(' comment','the-launcher'); ?> </span>
        </div>
        <?php if(get_the_content()){ ?>
            <div class="single_post_content wow fadeInUp"><?php echo apply_filters('the_content' , wp_kses_post(wp_trim_words(get_the_content(),100,'...')));?><div class="read_more"><a href="<?php the_permalink(); ?>"><?php _e('Read More','the-launcher'); ?></a></div></div>
        <?php } ?>
        <?php wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'the-launcher' ),
            'after'  => '</div>',
        ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php the_launcher_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
