<?php

$the_launcher_enable_disables=array('service','blogs','testimonial','feature','client','cta','video','pricing','contact');
$the_launcher_section_titles = array('service','blogs','client','testimonial','video','pricing','contact');
$section_sub_titles = array('service','blogs','client','testimonial','video','pricing','contact');
$the_launcher_section_descriptions = array('service','video','cta','pricing','contact');
$the_launcher_the_launcher_bgs = array('service','feature','blogs','pricing','testimonial','client','cta','contact');

$the_launcher_year_list = the_launcher_year_list();
$the_launcher_month_list = the_launcher_month();
$the_launcher_day_list = the_launcher_day();
$the_launcher_hour_list = the_launcher_hour();
$the_launcher_minut_list = the_launcher_minut();
$the_launcher_category = the_launcher_category_lists();
$the_launcher_posts = the_launcher_post_lists1();
$the_launcher_bg_repeat = array(
        'no-repeat'  => __('No Repeat', 'the-launcher'),
        'repeat'     => __('Tile', 'the-launcher'),
        'repeat-x'   => __('Tile Horizontally', 'the-launcher'),
        'repeat-y'   => __('Tile Vertically', 'the-launcher'),
);
        
$the_launcher_bg_position = array(
    'left'       => __('Left', 'the-launcher'),
    'center'     => __('Center', 'the-launcher'),
    'right'      => __('Right', 'the-launcher'),
);

$the_launcher_bg_attachment = array(
    'fixed'      => __('Fixed', 'the-launcher'),
    'scroll'     => __('Scroll', 'the-launcher'),
);
$the_launcher_font_size = the_launcher_font_size();
$the_launcher_fonts = the_launcher_font();
/** ==============================================================**/
/** The Launcher pannels **/
$the_launcher_add_panel_arrays = array(
    'the_launcher_home_page_panel'=> array(
        'id'=>'the_launcher_home_page_panel',
        'args'=> array(
            'title'=>__('Home Sections','the-launcher'),
            'description'=>__('This is setting for home page','the-launcher'),
            'priority'=>5
        )
    ),
    'the_launcher_typography_panel' => array(
        'id'=>'the_launcher_typography_panel',
        'args'=>array(
            'title'=>__('Typography','the-launcher'),
            'priority'=>6
        )
    ),
    'the_launcher_general_panel' => array(
        'id'=>'the_launcher_general_panel',
        'args'=>array(
            'title'=>__('General Setting','the-launcher'),
            'priority'=>2
        )
    ),
    'the_launcher_header_panel' => array(
        'id'=>'the_launcher_header_panel',
        'args'=>array(
            'title'=>__('Header Setting','the-launcher'),
            'priority'=>2
        )
    ),
);


/** ==============================================================**/
/** Home panel section **/
$the_launcher_add_section_arrays = array(

    'the_launcher_skinn_color_section' => array(
        'id'=>'the_launcher_skinn_color_section',
        'args'=>array(
            'title'=>__('Skin Color','the-launcher'),
            'description'=>__('General Section Setting','the-launcher'),
            'priority'=>1,
            'capability'=>'edit_theme_options',
            'panel' => 'the_launcher_general_panel',
            'theme_support'=>'',
            
        )
    ),
    'the_launcher_mennu_section'=>array(
        'id'=>'the_launcher_mennu_section',
        'args'=>array(
            'title'=>__('Menu Setting','the-launcher'),
            'priority'=>2,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel' => 'the_launcher_header_panel',
            
        )
    ),
    'the_launcher_form_section'=>array(
        'id'=>'the_launcher_form_section',
        'args'=>array(
            'title'=>__('Slider/Counter Setting','the-launcher'),
            'description'=>__('Info: Install "NewsLetter" and "AccessPress Social Icon" plugin to add subscribe form and Social icon below the Countdown. Use "Subscribe Form" widget area to add the Widgets','the-launcher'),
            'priority'=>3,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_service_section'=>array(
        'id'=>'the_launcher_service_section',
        'args'=>array(
            'title'=>__('Service Section Setting','the-launcher'),
            'priority'=>7,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_feature_section'=>array(
        'id'=>'the_launcher_feature_section',
        'args'=>array(
            'title'=>__('Feature Section Setting','the-launcher'),
            'priority'=>9,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_blogs_section'=>array(
        'id'=>'the_launcher_blogs_section',
        'args'=>array(
            'title'=>__('Blog Section Setting','the-launcher'),
            'priority'=>11,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_video_section'=>array(
        'id'=>'the_launcher_video_section',
        'args'=>array(
            'title'=>__('Video Section Setting','the-launcher'),
            'priority'=>13,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_pricing_section'=>array(
        'id'=>'the_launcher_pricing_section',
        'args'=>array(
            'title'=>__('Pricing Section Setting','the-launcher'),
            'description'=>__('Adding Pricing Table<br/> Go to Appearance->Widget and Drag "The Launcher: Pricing Table" into "Pricing Table" WIdget Area','the-launcher'),
            'priority'=>15,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_testimonial_section'=>array(
        'id'=>'the_launcher_testimonial_section',
        'args'=>array(
            'title'=>__('Testimonial Section Setting','the-launcher'),
            'priority'=>17,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_client_section'=>array(
        'id'=>'the_launcher_client_section',
        'args'=>array(
            'title'=>__('Client Section Setting','the-launcher'),
            'priority'=>19,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_cta_section'=>array(
        'id'=>'the_launcher_cta_section',
        'args'=>array(
            'title'=>__('CTA Section Setting','the-launcher'),
            'priority'=>21,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_contact_section'=>array(
        'id'=>'the_launcher_contact_section',
        'args'=>array(
            'title'=>__('Contact Section','the-launcher'),
            'description'=>__('Info: "Ultimate Form Builder Lite" Plugin is required to add the contact form. <br/>To add map and contact form, go to Appearance->Widget and drag Text Widget into "Home Contact Section" Widget Area and add Map Iframe and Contact Form shortcode','the-launcher'),
            'priority'=>23,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_section_reorder_section'=>array(
        'id'=>'the_launcher_section_reorder_section',
        'args'=>array(
            'title'=>__('Home Section Re-Order','the-launcher'),
            'priority'=>40,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_home_page_panel'
        )
    ),
    'the_launcher_footer_section'=>array(
        'id'=>'the_launcher_footer_section',
        'args'=>array(
            'title'=>__('Footer Setting','the-launcher'),
            'priority'=>6,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            
        )
    ),
    'the_launcher_body_typography_section'=>array(
        'id'=>'the_launcher_body_typography_section',
        'args'=>array(
            'title'=>__('Body','the-launcher'),
            'priority'=>1,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
    'the_launcher_h1_typography_section'=>array(
        'id'=>'the_launcher_h1_typography_section',
        'args'=>array(
            'title'=>__('Heading 1','the-launcher'),
            'priority'=>2,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
    'the_launcher_h2_typography_section'=>array(
        'id'=>'the_launcher_h2_typography_section',
        'args'=>array(
            'title'=>__('Heading 2','the-launcher'),
            'priority'=>3,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
    'the_launcher_h3_typography_section'=>array(
        'id'=>'the_launcher_h3_typography_section',
        'args'=>array(
            'title'=>__('Heading 3','the-launcher'),
            'priority'=>4,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
    'the_launcher_h4_typography_section'=>array(
        'id'=>'the_launcher_h4_typography_section',
        'args'=>array(
            'title'=>__('Heading 4','the-launcher'),
            'priority'=>5,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
     'the_launcher_h5_typography_section'=>array(
        'id'=>'the_launcher_h5_typography_section',
        'args'=>array(
            'title'=>__('Heading 5','the-launcher'),
            'priority'=>5,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
    'the_launcher_h6_typography_section'=>array(
        'id'=>'the_launcher_h6_typography_section',
        'args'=>array(
            'title'=>__('Heading 6','the-launcher'),
            'priority'=>7,
            'capability'=>'edit_theme_options',
            'theme_support'=>'',
            'panel'=>'the_launcher_typography_panel'
        )
    ),
);

/** ==============================================================**/
/** Form section seting **/

/** ==============================================================**/
/** Enable disable setting **/
$wp_customize->add_setting(
    'the_launcher_enable_counter',
    array(
        'default'=>0,
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_contact',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_pricing',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_cta',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_service',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_feature',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_form',
    array(
        'default'=>0,
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_blogs',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_video',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_client',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_testimonial',
    array(
        'default'=>0,
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);


/** ==============================================================**/
/** Header Settings **/
$wp_customize->add_setting(
    'the_launcher_header_menu_logo_align',
    array(
        'default' => 'left',
        'sanitize_callback' => 'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_disable_menu_dark_overlay',
    array(
        'default' => '',
        'sanitize_callback' => 'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_header_menu_style',
    array(
        'default' => 'side_menu',
        'sanitize_callback' => 'sanitize_text_field'
    )
);

/** Section title setting **/
$wp_customize->add_setting(
    'the_launcher_service_section_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_section_sub_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_content_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_content_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_content_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_section_title',
    array(
        'transport' => 'postMessage',
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_section_sub_title',
    array(
        'default'=>'',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_client_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);

$wp_customize->add_setting(
    'the_launcher_client_section_title',
    array(
        'default'=>'',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_client_section_sub_title',
    array(
        'default'=>'',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_content_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_content_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_section_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_section_sub_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_section_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_section_sub_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_content_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_section_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_section_sub_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_video_section_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_video_section_sub_title',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);


/** ==============================================================**/
/** Section descriptiion setting **/
$wp_customize->add_setting(
    'the_launcher_video_desc',
    array(
        'default'=>'',
        'transport' => 'postMessage', 
        'sanitize_callback'=>'the_launcher_sanitize_textarea'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_desc',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_textarea'
    )
);

$wp_customize->add_setting(
    'the_launcher_cta_desc',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_textarea'
    )
);
$wp_customize->add_setting(
    'the_launcher_cta_title_color',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);

$wp_customize->add_setting(
    'the_launcher_contact_desc',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_textarea'
    )
);

$wp_customize->add_setting(
    'the_launcher_pricing_desc',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_textarea'
    )
);
$wp_customize->add_setting(
    'the_launcher_form_cat',
    array(
        'default'=>'',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_slider_option',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_slider_enable_arrow_prev_next',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_client_cat',
    array(
        'default'=>'',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_cat',
    array(
        'default'=>'',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_cat',
    array(
        'default'=>'',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_post',
    array(
        'default'=>'',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_blog_post1',
    array(
        'default'=>'',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_video_url',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_button_link_cta',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_button_text_cta',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_enable_footer',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_footer_copy_right',
    array(
        'default'=>'',
        'transport' => 'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_form_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);

$wp_customize->add_setting(
    'the_launcher_client_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_cta_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_bg_image',
    array(
        'default'=>'',
        'sanitize_callback'=>'esc_url_raw'
    )
);

$wp_customize->add_setting(
    'the_launcher_service_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);

$wp_customize->add_setting(
    'the_launcher_client_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_cta_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_bg_color',
    array(
        'default'=>'',
        'sanitize_callback'=>'sanitize_text_field'
    )
);

$wp_customize->add_setting(
    'the_launcher_slider_counter_enable',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_checkbox'
    )
);
$wp_customize->add_setting(
    'the_launcher_year_select',
    array(
        'default'=>'',
        'transport'   => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_year'
    )
);
$wp_customize->add_setting(
    'the_launcher_month_select',
    array(
        'default'=>'',
        'transport'   => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_month'
    )
);
$wp_customize->add_setting(
    'the_launcher_day_select',
    array(
        'default'=>'',
        'transport'   => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_day'
    )
);
$wp_customize->add_setting(
    'the_launcher_hour_select',
    array(
        'default'=>'',
        'transport'   => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_day'
    )
);
$wp_customize->add_setting(
    'the_launcher_minut_select',
    array(
        'default'=>'',
        'transport'   => 'postMessage',
        'sanitize_callback'=>'the_launcher_sanitize_day'
    )
);

$wp_customize->add_setting(
    'the_launcher_service_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_attachment',
    array(
        'default'=>'left',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_feature_attachment',
    array(
        'default'=>'left',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_blogs_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_video_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_video_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_video_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_client_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_client_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_client_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_contact_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_cta_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_cta_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_cta_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_testimonial_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_bg_repeat',
    array(
        'default'=>'no-repeat',
        'sanitize_callback'=>'the_launcher_sanitize_repeat'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_position',
    array(
        'default'=>'fixed',
        'sanitize_callback'=>'the_launcher_sanitize_position'
    )
);
$wp_customize->add_setting(
    'the_launcher_pricing_attachment',
    array(
        'default'=>'',
        'sanitize_callback'=>'the_launcher_sanitize_attachment'
    )
);

 
 
$wp_customize->add_setting(
    'the_launcher_body_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_h1_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_h2_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_h3_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_h4_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_h5_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_h6_font_size',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_body_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_h1_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_h2_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_h3_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_h4_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_h5_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_h6_font',
    array(
        'default' => '',
        'transport'=>'postMessage',
        'sanitize_callback'=>'sanitize_text_field'
    )
);

/** ==============================================================**/
/** Service Sectoin post**/
$wp_customize->add_setting(
    'the_launcher_service_post_1',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_post_2',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_post_3',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_post_4',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_service_post_5',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
)
);
$wp_customize->add_setting(
    'the_launcher_service_post_6',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);

$wp_customize->add_setting(
    'the_launcher_site_title_font_size',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_site_title_font_color',
    array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    )
);
$wp_customize->add_setting(
    'the_launcher_site_tagline_font_size',
    array(
        'default' => '',
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_setting(
    'the_launcher_site_tagline_color',
    array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    )
);
/** ==============================================================**/
/** Genetal section control **/
$the_launcher_add_control_arrays = array(
    'the_launcher_enable_counter'=>array(
           'id'=>'the_launcher_enable_counter',
           'args'=>array(
               'label'      => __( 'Enable Section', 'the-launcher' ),
               'section'    => 'the_launcher_form_section',
               'type'   =>'checkbox',
               'priority'=>2,
          
       )
    ),
    'the_launcher_disable_menu_dark_overlay' => array(
        'id'=>'the_launcher_disable_menu_dark_overlay',
        'args'=>array(
            'label'=>__('Disable Sticky Menu Overlay','the-launcher'),
            'section'=>'the_launcher_mennu_section',
            'type'=>'checkbox',
            'priority'=>23,
            'active_callback' => 'the_launcher_side_menu_activate',
        )
    ),
    'the_launcher_header_menu_logo_align' => array(
        'id'=>'the_launcher_header_menu_logo_align',
        'args'=>array(
            'label'=>__('Header Menu Logo Align','the-launcher'),
            'section'=>'the_launcher_mennu_section',
            'type'=>'radio',
            'choices'=>array(
                'left'=>'Left Align',
                'center'  => 'Center Align',
                
            ),
            'active_callback' => 'the_launcher_side_menu_activate',
            'priority'=>22
        )
    ),
    'the_launcher_header_menu_style' => array(
        'id'=>'the_launcher_header_menu_style',
        'args'=>array(
            'label'=>__('Header Menu Layout','the-launcher'),
            'section'=>'the_launcher_mennu_section',
            'type'=>'radio',
            'choices'=>array(
                'side_menu'=>'Default',
                'side_menu' => 'Side Menu',
                'top_menu'  => 'Top Menu',
                'bottom_menu'=>'Bottom Menu',
                
            ),
            'priority'=>20
        )
    ),
    'the_launcher_form_cat'=>array(
        'id'=>'the_launcher_form_cat',
        'args'=>array(
            'label' =>__('Slider Category','the-launcher'),
            'description' => __('Recommend Image Size Is 1900 x 800','the-launcher'),
            'section' =>'the_launcher_form_section',
            'type'=>'select',
            'choices'=>$the_launcher_category,
            'priority'=>3
        )
    ),
    'the_launcher_slider_option'=>array(
        'id'=>'the_launcher_slider_option',
        'args'=>array(
            'label' =>__('Slider Layout','the-launcher'),
            'section' =>'the_launcher_form_section',
            'type'=>'radio',
            'choices'=> array(
                'full' => __('Fullscreen','the-launcher'),
                'image-size' => __('Normal','the-launcher')
            ),
            'priority'=>4
        )
    ),
    'the_launcher_slider_enable_arrow_prev_next'=>array(
        'id'=>'the_launcher_slider_enable_arrow_prev_next',
        'args'=>array(
            'label' =>__('Enable Prev & Next Arrow','the-launcher'),
            'section' =>'the_launcher_form_section',
            'type'=>'checkbox',
            'priority'=>4
        )
    ),
    'the_launcher_client_cat'=>array(
        'id'=>'the_launcher_client_cat',
        'args'=>array(
            'label' =>__('Choose category for client','the-launcher'),
            'section' =>'the_launcher_client_section',
            'type'=>'select',
            'choices'=>$the_launcher_category,
            'priority'=>6
        )
    ),
    'the_launcher_feature_cat'=>array(
        'id'=>'the_launcher_feature_cat',
        'args'=>array(
            'label' =>__('Category For Feature Slide','the-launcher'),
            'section' =>'the_launcher_feature_section',
            'type'=>'select',
            'choices'=>$the_launcher_category,
            'priority'=>4
        )
    ),
    'the_launcher_testimonial_cat'=>array(
        'id'=>'the_launcher_testimonial_cat',
        'args'=>array(
            'label' =>__('Choose Category for Testimonial','the-launcher'),
            'section' =>'the_launcher_testimonial_section',
            'type'=>'select',
            'choices'=>$the_launcher_category,
            'priority'=>4
        )
    ),
    'the_launcher_blog_post1'=>array(
        'id'=>'the_launcher_blog_post1',
        'args'=>array(
            'label'=>__('Choose Category for Blog','the-launcher'),
            'section'=>'the_launcher_blogs_section',
            'type'=>'select',
            'choices'=>$the_launcher_category,
            'priority'=>4
        )
    ),
    'the_launcher_service_post_1'=>array(
        'id'=>'the_launcher_service_post_1',
        'args'=>array(
            'label'=>__('Service Post 1','the-launcher'),
            'section'=>'the_launcher_service_section',
            'type'=>'select',
            'choices'=>$the_launcher_posts,
            'priority'=>7
        )
    ),
    'the_launcher_service_post_2'=>array(
        'id'=>'the_launcher_service_post_2',
        'args'=>array(
            'label'=>__('Service Post 2','the-launcher'),
            'section'=>'the_launcher_service_section',
            'type'=>'select',
            'choices'=>$the_launcher_posts,
            'priority'=>7
        )
    ),
    
    'the_launcher_service_post_3'=>array(
        'id'=>'the_launcher_service_post_3',
        'args'=>array(
            'label'=>__('Service Post 3','the-launcher'),
            'section'=>'the_launcher_service_section',
            'type'=>'select',
            'choices'=>$the_launcher_posts,
            'priority'=>9
        )
    ),
    'the_launcher_service_post_4'=>array(
        'id'=>'the_launcher_service_post_4',
        'args'=>array(
            'label'=>__('Service Post 4','the-launcher'),
            'section'=>'the_launcher_service_section',
            'type'=>'select',
            'choices'=>$the_launcher_posts,
            'priority'=>11
        )
    ),
    'the_launcher_service_post_5'=>array(
        'id'=>'the_launcher_service_post_5',
        'args'=>array(
            'label'=>__('Service Post 5','the-launcher'),
            'section'=>'the_launcher_service_section',
            'type'=>'select',
            'choices'=>$the_launcher_posts,
            'priority'=>13
        )
    ),
    'the_launcher_service_post_6'=>array(
        'id'=>'the_launcher_service_post_6',
        'args'=>array(
            'label'=>__('Service Post 6','the-launcher'),
            'section'=>'the_launcher_service_section',
            'type'=>'select',
            'choices'=>$the_launcher_posts,
            'priority'=>15
        )
    ),
    
    'the_launcher_video_url'=>array(
        'id'=>'the_launcher_video_url',
        'args'=>array(
            'label'=>__('Video URL (Only Youtube Video Is Support Link: youtube.com)','the-launcher'),
            'section'=>'the_launcher_video_section',
            'type'=>'text',
            'priority'=>6
        )
    ),
    'the_launcher_button_link_cta'=>array(
        'id'=>'the_launcher_button_link_cta',
        'args'=>array(
            'label'=>__('Please input button Link','the-launcher'),
            'section'=>'the_launcher_cta_section',
            'type'=>'text',
            'priority'=>6
        )
    ),
    'the_launcher_button_text_cta'=>array(
        'id'=>'the_launcher_button_text_cta',
        'args'=>array(
            'label'=>__('Please input button Text','the-launcher'),
            'section'=>'the_launcher_cta_section',
            'type'=>'text',
            'priority'=>5
        )
    ),
    'the_launcher_enable_footer'=>array(
        'id'=>'the_launcher_enable_footer',
        'args'=>array(
            'label'=>__('Disable Footer Text','the-launcher'),
            'section'=>'the_launcher_footer_section',
            'type'=>'checkbox',
            'priority'=>4
        )
    ),
    'the_launcher_footer_copy_right'=>array(
        'id'=>'the_launcher_footer_copy_right',
        'args'=>array(
            'label'=>__('Footer Copyright text','the-launcher'),
            'section'=>'the_launcher_footer_section',
            'type'=>'text',
            'priority'=>6
        )
    ),
    'the_launcher_slider_counter_enable'=>array(
        'id'=>'the_launcher_slider_counter_enable',
        'args'=>array(
            'label'=>__('Enable Countdown','the-launcher'),
            'section'=>'the_launcher_form_section',
            'type'=>'checkbox',
            'priority'=>4
        )
    ),
    'the_launcher_year_select'=>array(
        'id'=>'the_launcher_year_select',
        'args'=>array(
            'label'=>__('Choose year for countdown','the-launcher'),
            'section'=>'the_launcher_form_section',
            'type'=>'select',
            'choices'=>$the_launcher_year_list,
            'priority'=>5
        )
    ),
    'the_launcher_month_select'=>array(
        'id'=>'the_launcher_month_select',
        'args'=>array(
            'label'=>__('Choose month for countdown','the-launcher'),
            'section'=>'the_launcher_form_section',
            'type'=>'select',
            'choices'=>$the_launcher_month_list,
            'priority'=>5
        )
    ),
    'the_launcher_day_select'=>array(
        'id'=>'the_launcher_day_select',
        'args'=>array(
            'label'=>__('Choose day for countdown','the-launcher'),
            'section'=>'the_launcher_form_section',
            'type'=>'select',
            'choices'=>$the_launcher_day_list,
            'priority'=>5
        )
    ),
    'the_launcher_hour_select'=>array(
        'id'=>'the_launcher_hour_select',
        'args'=>array(
            'label'=>__('Choose hour for countdown','the-launcher'),
            'section'=>'the_launcher_form_section',
            'type'=>'select',
            'choices'=>$the_launcher_hour_list,
            'priority'=>5
        )
    ),
    'the_launcher_minut_select'=>array(
        'id'=>'the_launcher_minut_select',
        'args'=>array(
            'label'=>__('Choose minute for countdown','the-launcher'),
            'section'=>'the_launcher_form_section',
            'type'=>'select',
            'choices'=>$the_launcher_minut_list,
            'priority'=>5
        )
    ),
    'the_launcher_body_font_size'=>array(
        'id'=>__('the_launcher_body_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Body Font Size','the-launcher'),
            'section'=>'the_launcher_body_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
    'the_launcher_h1_font_size'=>array(
        'id'=>__('the_launcher_h1_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Heading 1 Font Size','the-launcher'),
            'section'=>'the_launcher_h1_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
      'the_launcher_h2_font_size'=>array(
        'id'=>__('the_launcher_h2_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Heading 2 Font Size','the-launcher'),
            'section'=>'the_launcher_h2_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
      'the_launcher_h3_font_size'=>array(
        'id'=>__('the_launcher_h3_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Heading 3 Font Size','the-launcher'),
            'section'=>'the_launcher_h3_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
      'the_launcher_h4_font_size'=>array(
        'id'=>__('the_launcher_h4_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Heading 4 Font Size','the-launcher'),
            'section'=>'the_launcher_h4_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
      'the_launcher_h5_font_size'=>array(
        'id'=>__('the_launcher_h5_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Heading 5 Font Size','the-launcher'),
            'section'=>'the_launcher_h5_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
      'the_launcher_h6_font_size'=>array(
        'id'=>__('the_launcher_h6_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Heading 6 Font Size','the-launcher'),
            'section'=>'the_launcher_h6_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>1
        )
    ),
    'the_launcher_body_font'=>array(
        'id'=>('the_launcher_body_font'),
        'args'=>array(
            'label'=>__('Body Font','the-launcher'),
            'section'=>'the_launcher_body_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),'the_launcher_h1_font'=>array(
        'id'=>('the_launcher_h1_font'),
        'args'=>array(
            'label'=>__('Heading 1','the-launcher'),
            'section'=>'the_launcher_h1_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),
    'the_launcher_h2_font'=>array(
        'id'=>('the_launcher_h2_font'),
        'args'=>array(
            'label'=>__('Heading 2','the-launcher'),
            'section'=>'the_launcher_h2_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),
    'the_launcher_h3_font'=>array(
        'id'=>('the_launcher_h3_font'),
        'args'=>array(
            'label'=>__('Heading 3','the-launcher'),
            'section'=>'the_launcher_h3_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),
    'the_launcher_h4_font'=>array(
        'id'=>('the_launcher_h4_font'),
        'args'=>array(
            'label'=>__('Heading 4 Font','the-launcher'),
            'section'=>'the_launcher_h4_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),
    'the_launcher_h5_font'=>array(
        'id'=>('the_launcher_h5_font'),
        'args'=>array(
            'label'=>__('Heading 5 Font','the-launcher'),
            'section'=>'the_launcher_h5_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),
    'the_launcher_h6_font'=>array(
        'id'=>('the_launcher_h6_font'),
        'args'=>array(
            'label'=>__('Heading 6','the-launcher'),
            'section'=>'the_launcher_h6_typography_section',
            'type'=>'select',
            'choices'=>$the_launcher_fonts,
            'priority'=>2
        )
    ),
    'the_launcher_site_title_font_size'=>array(
        'id'=>__('the_launcher_site_title_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Site Title Font Size','the-launcher'),
            'section'=>'title_tagline',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>10
        )
    ),
    'the_launcher_site_tagline_font_size'=>array(
        'id'=>__('the_launcher_site_tagline_font_size','the-launcher'),
        'args'=>array(
            'label'=>__('Site Tagline Font Size','the-launcher'),
            'section'=>'title_tagline',
            'type'=>'select',
            'choices'=>$the_launcher_font_size,
            'priority'=>14
        )
    ),
    
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_site_title_font_color', array(
	'label'        => __( 'Site Title Color', 'the-launcher' ),
	'section'    => 'title_tagline',
	'settings'   => 'the_launcher_site_title_font_color',
    'priority'=>12
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_site_tagline_color', array(
	'label'        => __( 'Site Tagline Color', 'the-launcher' ),
	'section'    => 'title_tagline',
	'settings'   => 'the_launcher_site_tagline_color',
    'priority'=>16
) ) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_service_title_color', array(
	'label'        => __( 'Title Color', 'the-launcher' ),
	'section'    => 'the_launcher_service_section',
	'settings'   => 'the_launcher_service_title_color',
    'priority'=>5
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_service_content_color', array(
	'label'        => __( 'Description Color', 'the-launcher' ),
	'section'    => 'the_launcher_service_section',
	'settings'   => 'the_launcher_service_content_color',
    'priority'=>6
) ) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_feature_title_color', array(
	'label'        => __( 'Title Color', 'the-launcher' ),
	'section'    => 'the_launcher_feature_section',
	'settings'   => 'the_launcher_feature_title_color',
    'priority'=>5
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_feature_content_color', array(
	'label'        => __( 'Description Color', 'the-launcher' ),
	'section'    => 'the_launcher_feature_section',
	'settings'   => 'the_launcher_feature_content_color',
    'priority'=>6
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_blogs_title_color', array(
	'label'        => __( 'Title Color', 'the-launcher' ),
	'section'    => 'the_launcher_blogs_section',
	'settings'   => 'the_launcher_blogs_title_color',
    'priority'=>5
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_blogs_content_color', array(
	'label'        => __( 'Description Color', 'the-launcher' ),
	'section'    => 'the_launcher_blogs_section',
	'settings'   => 'the_launcher_blogs_content_color',
    'priority'=>6
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_pricing_title_color', array(
	'label'        => __( 'Title Color', 'the-launcher' ),
	'section'    => 'the_launcher_pricing_section',
	'settings'   => 'the_launcher_pricing_title_color',
    'priority'=>5
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_pricing_content_color', array(
	'label'        => __( 'Description Color', 'the-launcher' ),
	'section'    => 'the_launcher_pricing_section',
	'settings'   => 'the_launcher_pricing_content_color',
    'priority'=>6
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_testimonial_title_color', array(
	'label'        => __( 'Title Color', 'the-launcher' ),
	'section'    => 'the_launcher_testimonial_section',
	'settings'   => 'the_launcher_testimonial_title_color',
    'priority'=>5
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_testimonial_content_color', array(
	'label'        => __( 'Description Color', 'the-launcher' ),
	'section'    => 'the_launcher_testimonial_section',
	'settings'   => 'the_launcher_testimonial_content_color',
    'priority'=>6
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_contact_content_color', array(
	'label'        => __( 'Description Color', 'the-launcher' ),
	'section'    => 'the_launcher_contact_section',
	'settings'   => 'the_launcher_contact_content_color',
    'priority'=>6
) ) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'the_launcher_contact_title_color', array(
	'label'        => __( 'Title Color', 'the-launcher' ),
	'section'    => 'the_launcher_contact_section',
	'settings'   => 'the_launcher_contact_title_color',
    'priority'=>5
) ) );
/** ==============================================================**/
/** controls loop **/

/** loof for enable disable section **/
foreach($the_launcher_enable_disables as $enable_disable):
$the_launcher_add_control_arrays []= array(
                'id'=>'the_launcher_enable_'.$enable_disable,
                'args'=>array(
                    'label'=>__('Check To Enable Section','the-launcher'),
                    'section'=>'the_launcher_'.$enable_disable.'_section',
                    'type'=>'checkbox',
                    'priority'=>1,
                )
            );
endforeach;

/** loof for section title section **/
foreach($the_launcher_section_titles as $section_title):
$the_launcher_add_control_arrays []= array(
                'id'=>'the_launcher_'.$section_title.'_section_title',
                'args'=>array(
                    'label'=>__('Section Title' ,'the-launcher'),
                    'section'=>'the_launcher_'.$section_title.'_section',
                    'type'=>'text',
                    'priority'=>2,
                )
            );
endforeach;
foreach($section_sub_titles as $section_sub_title):
$the_launcher_add_control_arrays []= array(
                'id'=>'the_launcher_'.$section_sub_title.'_section_sub_title',
                'args'=>array(
                    'label'=>__('Section Sub Title' ,'the-launcher'),
                    'section'=>'the_launcher_'.$section_sub_title.'_section',
                    'type'=>'text',
                    'priority'=>3,
                )
            );
endforeach;
/** loof for section description section **/
foreach($the_launcher_section_descriptions as $section_description):
$the_launcher_add_control_arrays []= array(
                'id'=>'the_launcher_'.$section_description.'_desc',
                'args'=>array(
                    'label'=>__('Please Enter Section Description','the-launcher'),
                    'section'=>'the_launcher_'.$section_description.'_section',
                    'type'=>'textarea',
                    'priority'=>3,
                )
            );
endforeach;

$the_launcher_bg_controlls = array();
foreach($the_launcher_the_launcher_bgs as $the_launcher_bg):
        $the_launcher_bg_controlls[] = array(
            'id'=>'the_launcher_'.$the_launcher_bg.'_bg_image',
            'args'=>array(
                'label'=>__('Select Background Image','the-launcher'),
                'section'=> 'the_launcher_'.$the_launcher_bg.'_section',
                'settings'=>'the_launcher_'.$the_launcher_bg.'_bg_image',
                'priority'=>20,
            )
            
);
endforeach;
foreach($the_launcher_the_launcher_bgs as $the_launcher_bg):
        $the_launcher_bg_color_controls[] = array(
            'id'=> 'the_launcher_'.$the_launcher_bg.'bg_color',
            'args'=>array(
                'label'=>__('Select Background Color','the-launcher'),
                'section'=> 'the_launcher_'.$the_launcher_bg.'_section',
                'settings'=>'the_launcher_'.$the_launcher_bg.'_bg_color',
                'priority'=>19,
            )
        );
    endforeach;
   
foreach($the_launcher_the_launcher_bgs as $the_launcher_bg):
    $the_launcher_add_control_arrays[] = array(
        'id'=> 'the_launcher_'.$the_launcher_bg.'_bg_repeat',
        'args'=>array(
            'label'=>__('Background Style','the-launcher'),
            'section'=> 'the_launcher_'.$the_launcher_bg.'_section',
            'type'=>'select',
            'choices'=>$the_launcher_bg_repeat,
            'priority'=>21,
            'active_callback'=>'the_launcher_bg_image_option_'.$the_launcher_bg
        )
    );
endforeach;
    
    /** Multiple bg image position control **/         
foreach($the_launcher_the_launcher_bgs as $the_launcher_bg):
    $the_launcher_add_control_arrays[] = array(
        'id'=> 'the_launcher_'.$the_launcher_bg.'_position',
        'args'=>array(
            'label'=>__('Background Position','the-launcher'),
            'section'=> 'the_launcher_'.$the_launcher_bg.'_section',
            'type'=>'select',
            'choices'=>$the_launcher_bg_position,
            'priority'=>22,
            'active_callback'=>'the_launcher_bg_image_option_'.$the_launcher_bg
        )
    );
endforeach;
    
    /** Multiple bg image attachment control **/         
foreach($the_launcher_the_launcher_bgs as $the_launcher_bg):
    $the_launcher_add_control_arrays[] = array(
        'id'=> 'the_launcher_'.$the_launcher_bg.'_attachment',
        'args'=>array(
            'label'=>__('Background Attachment','the-launcher'),
            'section'=> 'the_launcher_'.$the_launcher_bg.'_section',
            'type'=>'select',
            'choices'=>$the_launcher_bg_attachment,
            'priority'=>23,
            'active_callback'=>'the_launcher_bg_image_option_'.$the_launcher_bg
        )
    );
endforeach;