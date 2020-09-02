<?php
    $the_launcher_contact_title = get_theme_mod('the_launcher_contact_section_title');
    $the_launcher_contact_sub_title = get_theme_mod('the_launcher_contact_section_sub_title');
    $the_launcher_contact_desc = get_theme_mod('the_launcher_contact_desc');
?>
<div class="contact_section_wrap">
    <div class="ak-container clearfix">
        <?php if($the_launcher_contact_title || $the_launcher_contact_sub_title || $the_launcher_contact_desc){ ?>
            <div class="title_desc">
            <?php if($the_launcher_contact_title || $the_launcher_contact_sub_title){ ?>
                <div class="title_sub">
                <?php if($the_launcher_contact_title){ ?>
                    <span class="contact_title wow fadeInUp"><?php echo esc_attr($the_launcher_contact_title); ?></span>
                <?php }
                if($the_launcher_contact_sub_title){
                    ?>
                        <span class="contact_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_contact_sub_title); ?></span>
                    <?php } ?>
                </div>
            <?php }
            if($the_launcher_contact_desc){ ?>
                <div class="contact_desc wow fadeInUp"><?php echo wp_kses_post($the_launcher_contact_desc); ?></div>
            <?php } ?>
            </div>
        <?php
        }
        if(is_active_sidebar('the-launcher-contact')):
        ?>
            <div class="home-map-section clearfix">
            <?php
                dynamic_sidebar('the-launcher-contact');
            ?>
            </div>
        <?php
        endif;
        ?>
    </div>
</div>