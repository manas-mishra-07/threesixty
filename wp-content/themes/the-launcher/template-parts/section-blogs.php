<?php
$the_launcher_blogs_cat = get_theme_mod('the_launcher_blog_post1');
$the_launcher_service_title = get_theme_mod('the_launcher_blogs_section_title');
$the_launcher_service_sub_title = get_theme_mod('the_launcher_blogs_section_sub_title');
?>
<div class="ak-container">
    <div class="blogs_section_wrap">
        <?php
        if($the_launcher_service_title || $the_launcher_service_sub_title){
            ?>
            <div class="title_desc">
                <div class="title_sub">
                    <?php
                    if($the_launcher_service_title){
                        ?>
                            <span class="service_title wow fadeInUp"><?php echo esc_attr($the_launcher_service_title); ?></span>
                        <?php
                    }
                    if($the_launcher_service_sub_title){
                        ?>
                            <span class="service_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_service_sub_title); ?></span>
                        <?php
                    }
                    ?>
                </div>
                </div>
            <?php
        }
        if($the_launcher_blogs_cat){
            $the_launcher_blog_args = array(
                    'post_type' => 'post',
                    'cat' => $the_launcher_blogs_cat,
                    'posts_per_page' => '10',
                    'order' => 'DESC'
                );
            $the_launcher_blogs_query = new WP_Query($the_launcher_blog_args);
            if($the_launcher_blogs_query->have_posts()):
            ?>
            <div class="wrap_all_blog wow fadeInUp">
                <div class="v_line"></div>
            <?php
                while($the_launcher_blogs_query->have_posts()):
                    $the_launcher_blogs_query->the_post();
                    if(get_the_title() || get_the_content()){
                        ?>
                                <div class="blogs_post_wrap">
                                    <div class="blogs_date_wrap">
                                       <div class="wrap_blg_dt"><div class="date_blogs"><span><?php echo esc_attr(get_the_date('d M'));?></span><span><?php echo esc_attr(get_the_date('Y'));?></span></div></div>
                                    </div>
                                    <div class="blog_title_content">
                                        <span class="blog_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                                        <span class="blog_content">
                                            <?php echo wp_trim_words(wp_kses_post(get_the_content()),'20','...') ?>
                                        </span>
                                    </div>
                                </div>
                        <?php
                    }
                endwhile;
                ?>
                </div>
            </div>
                <?php
            endif;
        }
        ?>
    </div>