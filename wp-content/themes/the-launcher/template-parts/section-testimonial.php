<?php
    /**
     * testimonial Section
     */
    $the_launcher_section_title = get_theme_mod('the_launcher_testimonial_section_title');
    $the_launcher_section_sub_title = get_theme_mod('the_launcher_testimonial_section_sub_title');
    $the_launcher_category = get_theme_mod('the_launcher_testimonial_cat');
    $the_launcher_testimonial_args = array('post_type' => 'post', 'cat' => $the_launcher_category, 'order' => 'DESC','posts_per_page' => '-1');
    $the_launcher_testimonial_query = new WP_Query($the_launcher_testimonial_args); ?>
<?php if ($the_launcher_testimonial_query->have_posts() && $the_launcher_category) : ?>
<div class="empty_test"></div>
    <div class="ak-container clearfix">
        <div class="testimonial-posts">
            <?php
            if($the_launcher_section_title || $the_launcher_section_sub_title){
                ?>
                <div class="title_desc">
                    <div class="title_sub">
                        <?php
                        if($the_launcher_section_title){
                            ?>
                                <span class="service_title wow fadeInUp"><?php echo esc_attr($the_launcher_section_title); ?></span>
                            <?php
                        }
                        if($the_launcher_section_sub_title){
                            ?>
                                <span class="service_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_section_sub_title); ?></span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }?>
            <div class="bxslider_testimonial">
                <?php while ($the_launcher_testimonial_query->have_posts()) : $the_launcher_testimonial_query->the_post(); ?>
                    <div class="testimonial-post-wrap">
                        <?php
                            $testimonail_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'the_launcher_testimonial');
                            $testimonail_img_src = $testimonail_img[0];
                            $testimonail_id = get_the_ID(); ?>
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="wrap_test_img_main wow fadeInUp">
                                <div class="testimonial_image"  id="<?php echo esc_attr($testimonail_id); ?>">
                                    <img src="<?php echo esc_url($testimonail_img_src); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                                </div>
                            </div>
                             <?php endif; ?>
                            <div class="testimonial_main wow fadeInUp">
                                <?php if(get_the_title()){ ?>
                                    <h3><?php the_title(); ?></h3>
                                <?php } 
                                
                                if(get_the_content()){?>
                                    <div class="testimonial_content wow fadeInUp">
                                         <?php echo wp_kses_post(get_the_content());?>
                                    </div> 
                                <?php } ?>
                            </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>