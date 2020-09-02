<?php
$the_launcher_section_title = get_theme_mod('the_launcher_client_section_title');
$the_launcher_section_title_sub = get_theme_mod('the_launcher_client_section_sub_title');
$the_launcher_client_category = get_theme_mod('the_launcher_client_cat'); ?>
<div class="ak-container">
    <div class="launcher_client_section">
        <?php
        if($the_launcher_section_title || $the_launcher_section_title_sub){
            ?>
            <div class="title_desc">
                <div class="title_sub">
                    <?php
                    if($the_launcher_section_title){
                        ?>
                            <span class="service_title wow fadeInUp"><?php echo esc_attr($the_launcher_section_title); ?></span>
                        <?php
                    }
                    if($the_launcher_section_title_sub){
                        ?>
                            <span class="service_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_section_title_sub); ?></span>
                        <?php
                    }
                    ?>
                </div>
                </div>
            <?php
        }?>
        <div class="client_images wow fadeInUp">
            <?php 
            $the_launcher_client_args = array(
                'post_type' => 'post',
                 'cat' => $the_launcher_client_category,
                  'order' => 'DESC',
                  'posts_per_page' => -1
                 );
            $the_launcher_client_query = new WP_Query($the_launcher_client_args); ?>
            <?php if ($the_launcher_client_query->have_posts() && $the_launcher_client_category) : ?>
                <div id="carousel_client">
                    <?php while ($the_launcher_client_query->have_posts()) : $the_launcher_client_query->the_post(); ?>
                        <div class="client_images_item wow fadeInUp"><?php
                            $client_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'the_launcher_client');
                            $client_img_src = $client_img[0];
                            if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url($client_img_src); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>