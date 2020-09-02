<?php
/**
 * The template for displaying all single posts.
 *
 * @package the launcher
 */

get_header();
$the_launcher_page_id = get_the_ID();
$the_launcher_side_bar = get_post_meta($the_launcher_page_id,'the_launcher_sidebar_layout',true);

    if ($the_launcher_side_bar == 'both-sidebar') {
        $the_launcher_ak = 'ak-container';
        $the_launcher_content_area = 'content-area-both';
    }
    if ($the_launcher_side_bar == 'no-sidebar') {
        $the_launcher_ak = 'ak-container';
        $the_launcher_content_area = 'content-area-no';
    }
    if ($the_launcher_side_bar == 'right-sidebar') {
        $the_launcher_ak = 'ak-container';
        $the_launcher_content_area = 'content-area-right';
    }
    if ($the_launcher_side_bar == 'left-sidebar') {
        $the_launcher_ak = 'ak-container';
        $the_launcher_content_area = 'content-area-left';
    }
    if ($the_launcher_side_bar == '') {
        $the_launcher_ak = 'ak-container';
        $the_launcher_content_area = 'content-area-right';
    }?>
            <div class="<?php echo esc_attr($the_launcher_ak); ?>">
            
            	<div id="primary" class="<?php echo esc_attr($the_launcher_content_area); ?>">
            		<main id="main" class="site-main" role="main">
            
            		<?php while ( have_posts() ) : the_post(); ?>
            
            			<?php get_template_part( 'template-parts/content', 'single' ); ?>
            
            			<?php the_post_navigation(); ?>
            
            			<?php // If comments are open or we have at least one comment, load up the comment template.
            				if ( comments_open() || get_comments_number() ) :
            					comments_template();
            				endif;?>
            
            		<?php endwhile; // End of the loop. ?>
            
            		</main><!-- #main -->
            	</div><!-- #primary -->
                 <?php 
                     if(is_active_sidebar('the-launcher-left-sidebar')){
                        if ($the_launcher_side_bar == 'left-sidebar') {
                        $the_launcher_widget_area = 'widget-area-left';?>
                            <div id="secondary" class="widget-area <?php echo esc_attr($the_launcher_widget_area); ?>" role="complementary">
                                <?php dynamic_sidebar('the-launcher-left-sidebar');?>
                            </div> <?php
                            }
                        }
                        
                        if(is_active_sidebar('the-launcher-left-sidebar')){
                            if ($the_launcher_side_bar == 'both-sidebar') {
                                $the_launcher_widget_area = 'widget-area-left-both';?>
                                <div id="secondary" class="widget-area <?php echo esc_attr($the_launcher_widget_area); ?>" role="complementary">
                                    <?php dynamic_sidebar('the-launcher-left-sidebar');?>
                                </div> 
                            <?php }
                        }
                        
                        if(is_active_sidebar('the-launcher-sidebar-1')){
                            if ($the_launcher_side_bar == 'right-sidebar') {
                                $the_launcher_widget_area = 'widget-area-right';?> 
                                <div id="secondary" class="widget-area <?php echo esc_attr($the_launcher_widget_area); ?>" role="complementary"> <?php
                                    get_sidebar();?> 
                                </div> <?php
                            }
                        }
            
                        if(is_active_sidebar('the-launcher-the-launcher-sidebar-1')){
                            if ($the_launcher_side_bar == 'both-sidebar') {
                                $the_launcher_widget_area = 'widget-area-right-both';?> 
                                <div id="secondary" class="widget-area <?php echo esc_attr($the_launcher_widget_area); ?>" role="complementary"> <?php
                                    get_sidebar();?> 
                                </div> <?php
                            }
                        }
                        if(is_active_sidebar('the-launcher-sidebar-1')){
                            if ($the_launcher_side_bar == '') {
                                $the_launcher_widget_area = 'widget-area-right';?> 
                            <div id="secondary" class="widget-area <?php echo esc_attr($the_launcher_widget_area); ?>" role="complementary"> <?php
                                get_sidebar();?> 
                            </div>
                            <?php }
                        }?>
            </div>
<?php get_footer(); ?>
