<?php
/**
 * service Section
 */
$the_launcher_service_title = get_theme_mod('the_launcher_service_section_title');
$the_launcher_service_sub_title = get_theme_mod('the_launcher_service_section_sub_title');
$the_launcher_service_description = get_theme_mod('the_launcher_service_desc');
$the_launcher_service_post = get_theme_mod('the_launcher_service_post_1');
?>

<div class="ak-container clearfix">
    <div class="service_section_wrap">
        <?php if($the_launcher_service_title || $the_launcher_service_sub_title || $the_launcher_service_description){ ?>
            <div class="title_desc">
            <?php if($the_launcher_service_title || $the_launcher_service_sub_title){ ?>
                <div class="title_sub">
                <?php if($the_launcher_service_title){ ?>
                    <span class="service_title wow fadeInUp"><?php echo esc_attr($the_launcher_service_title); ?></span>
                <?php }
                if($the_launcher_service_sub_title){
                    ?>
                        <span class="service_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_service_sub_title); ?></span>
                    <?php } ?>
                </div>
            <?php }
            if($the_launcher_service_description){ ?>
                <div class="service_desc wow fadeInUp"><?php echo wp_kses_post($the_launcher_service_description); ?></div>
            <?php } ?>
            </div>
        <?php
        }
        ?>
        
        <div class="service_posts_wrap wow fadeInUp">
            <?php
                for($the_launcher_post = 1;$the_launcher_post <=6;$the_launcher_post++){
                    $the_launcher_service_post = get_theme_mod('the_launcher_service_post_'.$the_launcher_post);
                    if($the_launcher_service_post){
                        $the_launcher_posts = get_post($the_launcher_service_post);
                        $the_launcher_title_post =  $the_launcher_posts->post_title;
                        $the_launcher_content_post =  $the_launcher_posts->post_content;
                        $the_launcher_feat_image = wp_get_attachment_url( get_post_thumbnail_id($the_launcher_service_post),'the_launcher_service' );
                        if($the_launcher_title_post || $the_launcher_content_post || $the_launcher_feat_image){
                        ?>
                            <div class="service_post_<?php echo esc_attr($the_launcher_post); ?>">
                                <?php
                                if($the_launcher_feat_image || $the_launcher_title_post || $the_launcher_content_post){
                                ?>
                                <div class="service_post-inner-wrap">
                                    <div class="image_service">
                                        <img src="<?php echo esc_url($the_launcher_feat_image); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                                    </div>
                                    <?php
                                    if($the_launcher_title_post || $the_launcher_content_post){
                                    ?>
                                    <div class="title_content_wrap">
                                        <?php
                                            if($the_launcher_title_post){
                                        ?>
                                                <span class="service_title"><a href="<?php echo esc_url(get_permalink($the_launcher_service_post)); ?>"><?php echo esc_attr($the_launcher_title_post); ?></a></span>
                                        <?php 
                                            }
                                            if($the_launcher_content_post){
                                        ?>
                                            <span class="service_content"><?php echo wp_trim_words(wp_kses_post($the_launcher_content_post),'10','...'); ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>                                    
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                    }
                }
            ?>
            <div class="circle_div">
                <div class="circle_point"></div>
            </div>
        </div>
    </div>
</div>