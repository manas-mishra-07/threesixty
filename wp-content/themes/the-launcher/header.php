<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package the launcher
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<div class="header_form_time">
<div class="header_bg_wrap">
<?php $the_launcher_menu_layout = get_theme_mod('the_launcher_header_menu_style'); 
if($the_launcher_menu_layout == ''){ $the_launcher_menu_layout = 'side_menu'; }?>
<div class="header_menu_bg <?php if($the_launcher_menu_layout == 'bottom_menu'){echo "bottom-menu";} ?>">

    <div class="header_menu">
    	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'the-launcher' ); ?></a>
        <?php
            if(get_theme_mod('the_launcher_header_menu_style') == 'side_menu'){
            $the_launcher_align = get_theme_mod('the_launcher_header_menu_logo_align');
            if($the_launcher_align == ''){
                $the_launcher_align = 'left';
            }
            }
        ?>
    	<header id="masthead" class="site-header <?php if(get_theme_mod('the_launcher_header_menu_style') == 'side_menu'){ echo esc_attr($the_launcher_align); } ?>" role="banner">
        <div class="header_logo <?php if(get_theme_mod('the_launcher_header_menu_style') == 'side_menu'){ echo esc_attr($the_launcher_align); } ?>">
            <?php
                do_action('the_launcher_action_custom_logo');
            ?>
        </div>
            <?php if ( has_nav_menu( 'primary' ) ) { ?>
                <div id="toggle" class="<?php if($the_launcher_menu_layout == 'bottom_menu' || $the_launcher_menu_layout == 'top_menu'){echo 'not_side_menu';}?>">
                    <div class="one"></div>
                    <div class="two"></div>
                    <div class="three"></div>
                </div>
                <nav id="menu">
                <?php 
                if($the_launcher_menu_layout == 'side_menu' || $the_launcher_menu_layout == ''){ ?>
            		<nav id="site-navigation" class="main-navigation <?php echo esc_attr($the_launcher_menu_layout); ?>" role="navigation">
                        <div id="side-menu-title">
                            <span><?php _e('Menu','the-launcher'); ?></span>
                        </div>
            			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'the-launcher' ); ?></button>
            			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
            		</nav><!-- #site-navigation -->
                <?php }
                else{
                    ?>
                    <nav id="site-navigation_normal" class="main-navigation_normal <?php echo esc_attr($the_launcher_menu_layout); ?>" role="navigation">
            			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'the-launcher' ); ?></button>
            			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'sredfg srht ', 'menu_id' => 'primary-menu-simple' ) ); ?>
            		</nav><!-- #site-navigation -->
                    <?php
                } ?>
                </nav>
            <?php } ?>
    	</header>
     </div><!-- #masthead -->
    
</div><?php
if(is_home() || is_front_page()):
$the_launcher_enable_slider = get_theme_mod('the_launcher_enable_counter');
if($the_launcher_enable_slider){
$the_launcher_year = get_theme_mod('the_launcher_year_select');
$the_launcher_month = get_theme_mod('the_launcher_month_select');
$the_launcher_day = get_theme_mod('the_launcher_day_select');
$the_launcher_form_title = get_theme_mod('the_launcher_form_title');
$the_launcher_form_category = get_theme_mod('the_launcher_form_cat');
$the_launcher_form_args = array(
          'post_type' => 'post',
          'cat' => $the_launcher_form_category,
          'order' => 'DESC',
          'posts_per_page' => -1
      );
$the_launcher_form_query = new WP_Query($the_launcher_form_args);
$the_launcher_slider_layout = get_theme_mod('the_launcher_slider_option');
if($the_launcher_slider_layout == ''){
    $the_launcher_slider_layout = 'full';
}
if($the_launcher_slider_layout == 'image-size'){
    $the_launcher_slider_class = 'heade_bg_slider_image_size';
}
else{
    $the_launcher_slider_class = 'heade_bg_slider';
}
$the_launcher_enable_slider_arrow = get_theme_mod('the_launcher_slider_enable_arrow_prev_next');
?>
<div class="banner_timer <?php if($the_launcher_enable_slider_arrow){echo 'arrow-enable ';} echo esc_attr($the_launcher_slider_layout); if($the_launcher_form_category == ''){ echo 'slider-disable'; } ?>">
    <?php if ($the_launcher_form_query->have_posts() && $the_launcher_form_category) : 
    ?>
    <div class="slider_content_wrap <?php if (get_theme_mod('the_launcher_slider_counter_enable') || is_active_sidebar('the-launcher-subscribe-form')){ }else{echo 'disable-counter-form';}  ?>">
        <div class="<?php echo esc_attr($the_launcher_slider_class); ?>">
        <?php
             while ($the_launcher_form_query->have_posts()) : $the_launcher_form_query->the_post();?>
                <div class="slider_under_wrap">
                <?php
                    $the_launcher_img = wp_get_attachment_image_src(get_post_thumbnail_id(), '');
                    $the_launcher_img_src = $the_launcher_img[0];
                    $the_launcher_id = get_the_ID(); ?>
                    <?php $the_launcher_title = get_the_title(); ?>
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="launcer_image">
                        <img src="<?php echo  esc_url($the_launcher_img_src);?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                    </div>
                    <div class="slider_contents">
                    
                    <?php if($the_launcher_title){ ?>
                        <div class="counter_title wow fadeIn"><?php echo the_launcher_sanitize_title_span($the_launcher_title);?></div>
                    <?php } ?>
                    <?php endif; 
                    if(get_the_content()){?>
                        <div class="launcher_form_description wow fadeIn"><?php the_content(); ?></div>
                    <?php } ?>
                    </div>
                </div>                    
            <?php 
            endwhile; ?>
        </div>
        <?php
        if($the_launcher_slider_layout == 'full'){
        ?>
        <a href="" id="arrow_left"><?php if($the_launcher_enable_slider_arrow){ } else{_e('Next','the-launcher');} ?></a>
        <a href="" id="arrow_right"><?php if($the_launcher_enable_slider_arrow){ } else{ _e('Prev','the-launcher');} ?></a>
        <?php } ?>
     </div>      
<?php endif;?>
<div class="form_counter_wrap">
    <div class="ak-container clearfix">
                
        <?php if (get_theme_mod('the_launcher_slider_counter_enable') || is_active_sidebar('the-launcher-subscribe-form')){ ?>
        <div class="form_counter <?php if(is_active_sidebar('the-launcher-subscribe-form')){ } else{ echo 'form_disable'; } if(get_theme_mod('the_launcher_slider_counter_enable') == '') { echo 'is_counter_disable'; }?>">
            <?php if (get_theme_mod('the_launcher_slider_counter_enable')){ ?>
            <div class="launcher_form_counter">
                
                <div class="container">
                <?php
                $the_launcher_day = get_theme_mod('the_launcher_day_select');
                if($the_launcher_day == ''){
                    $the_launcher_day = '0';
                }
                $the_launcher_month = get_theme_mod('the_launcher_month_select');
                if($the_launcher_month == ''){
                    $the_launcher_month = '0';
                }
                $the_launcher_year = get_theme_mod('the_launcher_year_select');
                if($the_launcher_year == ''){
                    $the_launcher_year = '0';
                }
                $the_launcher_hour = get_theme_mod('the_launcher_hour_select');
                if($the_launcher_hour == ''){
                    $the_launcher_hour = '0';
                }
                $the_launcher_minut = get_theme_mod('the_launcher_minut_select');
                if($the_launcher_minut == ''){
                    $the_launcher_minut = '0';
                }?>
                    <div id="lwt-countdown-losange"><?php echo esc_attr($the_launcher_day.'-'.$the_launcher_month.'-'.$the_launcher_year.'-'.$the_launcher_hour.'-'.$the_launcher_minut); ?></div>
                    <div id="countdown_dashboard">
            			<div id="day" class="dash weeks_dash">
            				<span class="dash_title">weeks</span>
            				<div class="digit">0</div>
            				<div class="digit">0</div>
            			</div>
            
            			<div class="dash days_dash">
            				<span class="dash_title">days</span>
            				<div class="digit">0</div>
            				<div class="digit">0</div>
            			</div>
            
            			<div class="dash hours_dash">
            				<span class="dash_title">hours</span>
            				<div class="digit">0</div>
            				<div class="digit">0</div>
            			</div>
            
            			<div class="dash minutes_dash">
            				<span class="dash_title">minutes</span>
            				<div class="digit">0</div>
            				<div class="digit">0</div>
            			</div>
            
            			<div class="dash seconds_dash">
            				<span class="dash_title">seconds</span>
            				<div class="digit">0</div>
            				<div class="digit">0</div>
            			</div>
            
            		</div>
                </div>                
            </div>
            <?php } ?>
            <?php if(is_active_sidebar('the-launcher-subscribe-form')){ ?>
            <div class="launcher_form_contact">
                   <?php dynamic_sidebar('the-launcher-subscribe-form'); ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    </div>   
</div>
<?php } ?>
<?php endif; ?>
</div>
</div>
	<div id="content" class="site-content">