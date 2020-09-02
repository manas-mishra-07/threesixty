<?php
function the_launcher_dynamic_css (){
    $heading1_font_size = get_theme_mod('the_launcher_h1_font_size');
    $heading2_font_size = get_theme_mod('the_launcher_h2_font_size');
    $heading3_font_size = get_theme_mod('the_launcher_h3_font_size');
    $heading4_font_size = get_theme_mod('the_launcher_h4_font_size');
    $heading5_font_size = get_theme_mod('the_launcher_h5_font_size');
    $heading6_font_size = get_theme_mod('the_launcher_h6_font_size');
    $body_font_size = get_theme_mod('the_launcher_body_font_size');
    
    $heading1_font = get_theme_mod('the_launcher_h1_font');
    $heading2_font = get_theme_mod('the_launcher_h2_font');
    $heading3_font = get_theme_mod('the_launcher_h3_font');
    $heading4_font = get_theme_mod('the_launcher_h4_font');
    $heading5_font = get_theme_mod('the_launcher_h5_font');
    $heading6_font = get_theme_mod('the_launcher_h6_font');
    $body_font = get_theme_mod('the_launcher_body_font');
    
    $site_title_font_size = get_theme_mod('the_launcher_site_title_font_size');
    $site_tagline_font_size = get_theme_mod('the_launcher_site_tagline_font_size');
    $site_title_font_color = get_theme_mod('the_launcher_site_title_font_color');
    $site_tagline_color = get_theme_mod('the_launcher_site_tagline_color');
    if($site_title_font_size || $site_tagline_font_size || $site_title_font_color || $site_tagline_color){
        ?>
            <style>
                .header_logo .site-title a{
                    <?php if($site_title_font_size){ ?> font-size: <?php echo absint($site_title_font_size).'px' ?>;<?php } ?>
                    <?php if($site_title_font_color){ ?>color: <?php echo esc_attr($site_title_font_color) ?>;<?php } ?>
                }
                .header_logo .site-description{
                    <?php if($site_tagline_font_size){ ?>font-size: <?php echo absint($site_tagline_font_size).'px' ?>;<?php } ?>
                    <?php if($site_tagline_color){ ?>color: <?php echo esc_attr($site_tagline_color) ?>;<?php } ?>
                }
            </style>
        <?php
    }
    
    $skin_color = sanitize_hex_color(get_theme_mod('the_launcher_skin_color', '#FF7E00'));
    $dark_color  = the_launcher_dark_color_function($skin_color,'-45');
    $light_color  = the_launcher_dark_color_function($skin_color,'20');
    if($skin_color){
        ?>
            <style>
                input[type="submit"].newsletter-submit:hover, 
                .the_launcher_pricing_button_link_class a:hover,
                 .cta_button button:hover, input[type="reset"], input[type="submit"], 
                 input[type="submit"]:hover, .nav-links .nav-previous a:hover, .nav-links .nav-next a:hover, 
                 .form-submit input[type="submit"]:hover{
                    background-color:<?php echo esc_attr($dark_color)?>;
                }
                .blogs_date_wrap .date_blogs:after{
                    border-left-color: <?php echo esc_attr($dark_color) ?>;
                }
            </style>
        <?php
    }
    if($skin_color){
        ?>
            <style>
                h2.comments-title, .comments-area a:hover, 
                .entry-footer span a:hover, .widget.widget_recent_entries ul li a:hover, 
                #archives-2 ul li a:hover, 
                #categories-2 ul li a:hover, #meta-2 ul li a:hover, 
                #nav_menu-2 ul li a:hover, #pages-2 ul li a:hover, #recent-comments-2 ul li a:hover, 
                #recent-comments-2 ul li span a:hover, .entry-meta span a:hover, 
                .entry-footer span a:hover, .single_post_content a:hover, 
                #recent-comments-3 ul li a:hover, 
                #recent-comments-3 ul li span a:hover, #arrow_left:hover, #arrow_right:hover, 
                .top_menu ul li a:hover, .bottom_menu ul li a:hover, .widget ul li a:hover, 
                .footer_area_launcher .title_content_wrap .tn_title a:hover, 
                .widget.widget_categories ul li a:hover, .header_logo .site-title a, 
                .service_posts_wrap .service_title a:hover, 
                .blog_title_content .blog_title a:hover, footer .site-info span a:hover,
                .woocommerce ul.products li.product .woocommerce-loop-category__title,
                .woocommerce ul.products li.product .woocommerce-loop-product__title,
                .woocommerce ul.products li.product h3,
                .woocommerce ul.products li.product .woocommerce-loop-category__title:hover,
                .woocommerce ul.products li.product .woocommerce-loop-product__title:hover,
                .woocommerce ul.products li.product h3:hover,
                .woocommerce-info::before{
                    color: <?php echo esc_attr($skin_color)?>;
                }

                /** Light Background Color **/
                .woocommerce #respond input#submit,
                .woocommerce a.button,
                .woocommerce button.button,
                .woocommerce input.button,
                .woocommerce a.added_to_cart,
                #add_payment_method .wc-proceed-to-checkout a.checkout-button,
                .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
                .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button,
                .woocommerce #respond input#submit.alt,
                .woocommerce a.button.alt,
                .woocommerce button.button.alt,
                .woocommerce input.button.alt{
                    background-color: <?php echo esc_attr($light_color); ?>;
                }

                input[type="submit"].newsletter-submit, 
                .blogs_date_wrap .date_blogs, 
                .the_launcher_pricing_button_link_class a, 
                .launcher_video .play-pause-video, .main-navigation ul li a:hover, 
                .cta_button button, .archive .single_post_content a:hover, 
                .contact_section_wrap .home-map-section aside form input[type="submit"], .nav-links a, 
                .nav-links span, .archive .single_post_content a, .archive_main_title:before, 
                input[type="reset"], input[type="submit"], .nav-links .nav-previous a, .nav-links .nav-next a, 
                .form-submit input[type="submit"],
                .woocommerce #respond input#submit:hover,
                .woocommerce a.button:hover,
                .woocommerce button.button:hover,
                .woocommerce input.button:hover,
                .woocommerce #respond input#submit.alt:hover,
                .woocommerce a.button.alt:hover,
                .woocommerce button.button.alt:hover,
                .woocommerce input.button.alt:hover,
                .woocommerce #respond input#submit.disabled:hover,
                .woocommerce #respond input#submit:disabled:hover,
                .woocommerce #respond input#submit:disabled[disabled]:hover,
                .woocommerce a.button.disabled:hover,
                .woocommerce a.button:disabled:hover,
                .woocommerce a.button:disabled[disabled]:hover,
                .woocommerce button.button.disabled:hover,
                .woocommerce button.button:disabled:hover,
                .woocommerce button.button:disabled[disabled]:hover,
                .woocommerce input.button.disabled:hover,
                .woocommerce input.button:disabled:hover,
                .woocommerce input.button:disabled[disabled]:hover,
                .woocommerce span.onsale{
                    background-color:<?php echo esc_attr($skin_color); ?>;
                }
                .circle_div:before, 
                .main_wrap_feature .owl-carousel .owl-controls .owl-dot.active span, 
                .main_wrap_feature .owl-carousel .owl-controls .owl-dot span:hover, 
                .blogs_post_wrap .blog_title_content:before, 
                .the_launcher_pricing_button_link_class a, 
                .testimonial_image:before, 
                #plx_testimonial_section .owl-carousel .owl-controls .owl-dot.active span, 
                #plx_testimonial_section .owl-carousel .owl-controls .owl-dot span:hover, 
                .nav-links span, .nav-links a, .cta_button button, 
                .contact_section_wrap .home-map-section aside form input[type="submit"], 
                .archive .single_post_content a, .nav-links .nav-previous a, .nav-links .nav-next a, 
                .form-submit input[type="submit"]{
                    border: 2px solid <?php echo esc_attr($skin_color) ?>;
                }

                .woocommerce #respond input#submit,
                .woocommerce a.button,
                .woocommerce button.button,
                .woocommerce input.button,
                .woocommerce a.added_to_cart,
                .woocommerce-info {
                    border-color: <?php echo esc_attr($skin_color) ?>;
                }
            </style>
        <?php
    }
    
    if($heading1_font){
       wp_register_style('the-launcher-h1-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($heading1_font));
               wp_enqueue_style( 'the-launcher-h1-font');
               ?>
                <style>
                    h1{
                        font-family:<?php echo esc_attr($heading1_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($heading2_font){
       wp_register_style('the-launcher-h2-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($heading2_font));
               wp_enqueue_style( 'the-launcher-h2-font');
               ?>
                <style>
                    h2{
                        font-family:<?php echo esc_attr($heading2_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($heading3_font){
       wp_register_style('the-launcher-h3-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($heading3_font));
               wp_enqueue_style( 'the-launcher-h3-font');
               ?>
                <style>
                    h3{
                        font-family:<?php echo esc_attr($heading3_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($heading4_font){
       wp_register_style('the-launcher-h4-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($heading4_font));
               wp_enqueue_style( 'the-launcher-h4-font');
               ?>
                <style>
                    h4{
                        font-family:<?php echo esc_attr($heading4_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($heading5_font){
       wp_register_style('the-launcher-h5-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($heading5_font));
               wp_enqueue_style( 'the-launcher-h5-font');
               ?>
                <style>
                    h5{
                        font-family:<?php echo esc_attr($heading5_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($heading6_font){
       wp_register_style('the-launcher-h6-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($heading6_font));
               wp_enqueue_style( 'the-launcher-h6-font');
               ?>
                <style>
                    h6{
                        font-family:<?php echo esc_attr($heading6_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($body_font){
       wp_register_style('the-launcher-body-font', '//fonts.googleapis.com/css?family='.sanitize_text_field($body_font));
               wp_enqueue_style( 'the-launcher-body-font');
               ?>
                <style>
                    body{
                        font-family:<?php echo esc_attr($body_font) ?>;
                    }
                </style>
               <?php
    }
    
    if($heading1_font_size){
        ?>
            <style>
                h1{
                    font-size: <?php echo absint($heading1_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    if($heading2_font_size){
        ?>
            <style>
                h2{
                    font-size: <?php echo absint($heading2_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    if($heading3_font_size){
        ?>
            <style>
                h3{
                    font-size: <?php echo absint($heading3_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    if($heading4_font_size){
        ?>
            <style>
                h4{
                    font-size: <?php echo absint($heading4_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    if($heading5_font_size){
        ?>
            <style>
                h5{
                    font-size: <?php echo absint($heading5_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    if($heading6_font_size){
        ?>
            <style>
                h6{
                    font-size: <?php echo absint($heading6_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    if($body_font_size){
        ?>
            <style>
                body{
                    font-size: <?php echo absint($body_font_size).'px' ?>;
                }
            </style>
        <?php
    }
    
    $header_manu_overlay = get_theme_mod('the_launcher_disable_menu_dark_overlay');
    $header_manu_style = get_theme_mod('the_launcher_header_menu_style');
    if($header_manu_overlay == '' || $header_manu_style !=  'side_menu' ){
        ?>
        <style>
            .sticky-wrapper.is-sticky .site-header{
                background-color: rgba(0, 0, 0, .75);
            }
        </style>
        <?php
    }
    
    $service_title_color = get_theme_mod('the_launcher_service_title_color');
    $service_description_color = get_theme_mod('the_launcher_service_content_color');
    $feature_title_color = get_theme_mod('the_launcher_feature_title_color');
    $feature_content_color = get_theme_mod('the_launcher_feature_content_color');
    $blogs_title_color = get_theme_mod('the_launcher_blogs_title_color');
    $blogs_content_color = get_theme_mod('the_launcher_blogs_content_color');
    $pricing_title_color = get_theme_mod('the_launcher_pricing_title_color');
    $pricing_content_color = get_theme_mod('the_launcher_pricing_content_color');
    $testimonial_title_color = get_theme_mod('the_launcher_testimonial_title_color');
    $testimonial_content_color = get_theme_mod('the_launcher_testimonial_content_color');
    $client_content_color = get_theme_mod('the_launcher_client_content_color');
    $contact_title_color = get_theme_mod('the_launcher_contact_title_color');
    $contact_content_color = get_theme_mod('the_launcher_contact_content_color');
    
    ?>
        <style>
        <?php if($service_title_color){ ?>
            #plx_service_section .title_sub .service_title, #plx_service_section .title_sub .service_sub_title, .service_posts_wrap .service_title a{
                color: <?php echo esc_attr($service_title_color) ?>;
            }
        <?php } ?>
        <?php if($service_description_color){ ?>
            #plx_service_section .service_desc, .service_posts_wrap .service_content{
                color: <?php echo esc_attr($service_description_color) ?>;
            }
        <?php } ?>
        <?php if($feature_content_color){ ?>
            .main_wrap_feature .desc_feature p{
                color: <?php echo esc_attr($feature_content_color) ?>;
            }
        <?php } ?>
        <?php if($feature_title_color){ ?>
            .main_wrap_feature .title_feature{
                color: <?php echo esc_attr($feature_title_color) ?>;
            }
        <?php } ?>
        <?php if($blogs_title_color){ ?>
            #plx_blogs_section .title_sub .service_title, #plx_blogs_section .title_sub .service_sub_title, .blog_title_content .blog_title a{
                color: <?php echo esc_attr($blogs_title_color) ?>;
            }
        <?php } ?>
        <?php if($blogs_content_color){ ?>
            .blog_title_content .blog_content{
                color: <?php echo esc_attr($blogs_content_color) ?>;
            }
        <?php } ?>
        <?php if($pricing_title_color){ ?>
            #plx_pricing_section .title_sub .service_title, #plx_pricing_section .title_sub .service_sub_title{
                color: <?php echo esc_attr($pricing_title_color) ?>;
            }
        <?php } ?>
        <?php if($pricing_content_color){ ?>
            #plx_pricing_section .service_desc{
                color: <?php echo esc_attr($pricing_content_color) ?>;
            }
        <?php } ?>
        <?php if($testimonial_title_color){ ?>
            #plx_testimonial_section .title_sub .service_title, #plx_testimonial_section .title_sub .service_sub_title, .testimonial_main h3{
                color: <?php echo esc_attr($testimonial_title_color) ?>;
            }
        <?php } ?>
        <?php if($testimonial_content_color){ ?>
            .testimonial_content{
                color: <?php echo esc_attr($testimonial_content_color) ?>;
            }
        <?php } ?>
        <?php if($client_content_color){ ?>
            #plx_client_section .title_sub .service_title{
                color: <?php echo esc_attr($client_content_color) ?>;
            }
        <?php } ?>
        <?php if($contact_title_color){ ?>
            .contact_section_wrap  .contact_sub_title, .contact_section_wrap .contact_title, .contact_section_wrap .home-map-section .ufbl-default-template .ufbl-form-title{
                color: <?php echo esc_attr($contact_title_color) ?>;
            }
        <?php } ?>
        <?php if($contact_content_color){ ?>
            .contact_section_wrap  .contact_desc{
                color: <?php echo esc_attr($contact_content_color) ?>;
            }
        <?php } ?>
        </style>
    <?php
    
$the_launcher_form_category = get_theme_mod('the_launcher_form_cat');
$the_launcher_form_args = array(
        'post_type' => 'post',
        'cat' => $the_launcher_form_category,
        'order' => 'DESC',
        'posts_per_page' => -1
    );
$the_launcher_form_query = new WP_Query($the_launcher_form_args);
$j = 1;
if ($the_launcher_form_query->have_posts() && $the_launcher_form_category) :
    while ($the_launcher_form_query->have_posts()) : $the_launcher_form_query->the_post();
        $j++;
    endwhile;
endif;
if($j <= '2'){
 ?>
    <style>
        #arrow_left, #arrow_right{
            display:none;
        }
    </style>
 <?php   
}

}
add_filter('wp_head', 'the_launcher_dynamic_css');