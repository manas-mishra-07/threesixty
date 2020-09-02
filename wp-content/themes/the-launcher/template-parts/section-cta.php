<?php
$the_launcher_cta_enable = get_theme_mod('the_launcher_enable_cta');
if($the_launcher_cta_enable == 1){?>
<div class="footer_call_to_action">
    <?php 
    $the_launcher_cta_section_description = get_theme_mod('the_launcher_cta_desc');
    $the_launcher_cta_button = get_theme_mod('the_launcher_button_text_cta');
    $the_launcher_cta_button_link = get_theme_mod('the_launcher_button_link_cta');?>
    <div class="cta_content_wrap">
        <div class="ak-container">
            <div class="cta_wrap">
                <div class="cta_description wow fadeInUp"><?php echo the_launcher_sanitize_title_span($the_launcher_cta_section_description); ?></div>
                <div class="cta_button wow fadeInUp">
                    <a target="_blank" href="<?php echo esc_url($the_launcher_cta_button_link); ?>">
                        <button><?php echo esc_attr($the_launcher_cta_button); ?></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>