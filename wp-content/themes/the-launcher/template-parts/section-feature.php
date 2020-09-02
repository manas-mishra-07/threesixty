<?php
$the_launcher_feature_cat = get_theme_mod('the_launcher_feature_cat');
if($the_launcher_feature_cat){
    $the_launcher_feature_args = array(
            'post_type' => 'post',
            'cat' => $the_launcher_feature_cat,
            'order' => 'DESC',
            'posts_per_page' => -1,
        );
        $the_launcher_feature_query = new WP_Query($the_launcher_feature_args);
        ?>
        <div class="ak-container">
            <div class="main_wrap_feature">
                <div class="feature_slider_wrap">
                    <?php
                        if($the_launcher_feature_query->have_posts()):
                            while($the_launcher_feature_query->have_posts()):
                                $the_launcher_feature_query->the_post();
                                ?>
                                    <div class="feature_wrap_loop">
                                    <div class="feature-content-wrap">
                                    <?php
                                    if(get_the_title() || get_the_content()){
                                    ?>
                                        <div class="title_content_wrap">
                                            <?php
                                            if(get_the_title()){
                                            ?>
                                                <span class="title_feature wow fadeInUp"><?php the_title(); ?></span>
                                            <?php
                                            }
                                            if(get_the_content()){
                                            ?>
                                                <span class="desc_feature wow fadeInUp"><?php the_content(); ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php }
                                        $feature_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'the_launcher_feature');
                                        $feature_image = $feature_image_url[0]; 
                                         if($feature_image){ ?>
                                            <div class="feature_image wow fadeInUp">
                                                <img src="<?php echo esc_url($feature_image); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                                            </div>
                                        <?php } ?>
                                    </div>
                                    </div>
                                <?php
                            endwhile;
                        endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
}