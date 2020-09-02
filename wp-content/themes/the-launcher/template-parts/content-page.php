<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package the launcher
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <div class="entry-content"><?php 
            $the_launcher_page_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'the_launcher_single_page_archive');
            if($the_launcher_page_img){
                $the_launcher_page_img_src = $the_launcher_page_img[0];?>
                <div class="single_post_image"><img src="<?php echo esc_url($the_launcher_page_img_src);?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" /></div>
            <?php } 
        if(get_the_title()){
            ?>
            <header class="entry-header">
                <div class="entry-meta">
                    <?php 
                    the_title( '<h1 class="entry-title">', '</h1>' );
                    ?>
                </div><!-- .entry-meta -->
            </header><!-- .entry-header -->
        <?php } ?>
        <div class="single_post_content"><?php the_content(); ?></div>
        <?php wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'the-launcher' ),
            'after'  => '</div>',
        ) ); ?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'the-launcher' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
    
</article><!-- #post-## -->

