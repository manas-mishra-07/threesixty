<?php
add_action('customize_register','the_launcher_option_add');
function the_launcher_option_add($wp_customize)
{
    $wp_customize->get_section( 'title_tagline' )->panel = 'the_launcher_general_panel';
    $wp_customize->get_section( 'background_image' )->panel = 'the_launcher_general_panel';
    $wp_customize->remove_control('header_image');
    require get_template_directory().'/inc/admin-panel/launcher-theme-option.php';
    require get_template_directory().'/inc/admin-panel/launcher-sanitize.php';
    /** Remove unuse default section**/
    $wp_customize->remove_section( 'header_image');
    $wp_customize->remove_section( 'background_image');
    $wp_customize->remove_section( 'colors');
    
    foreach($the_launcher_add_panel_arrays as $the_launcher_add_panel_array):
        $wp_customize->add_panel($the_launcher_add_panel_array['id'],$the_launcher_add_panel_array['args']);
    endforeach;
    foreach($the_launcher_add_section_arrays as $the_launcher_add_section_array):
        $wp_customize->add_section($the_launcher_add_section_array['id'],$the_launcher_add_section_array['args']);
    endforeach;
    foreach($the_launcher_add_control_arrays as $the_launcher_add_control_array):
        $wp_customize->add_control($the_launcher_add_control_array['id'],$the_launcher_add_control_array['args']);
    endforeach;
    foreach($the_launcher_bg_controlls as $the_launcher_bg_controll):
        $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,$the_launcher_bg_controll['id'],$the_launcher_bg_controll['args']));
    endforeach;
    foreach($the_launcher_bg_color_controls as $the_launcher_bg_color_control):
        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize,$the_launcher_bg_color_control['id'],$the_launcher_bg_color_control['args']));
    endforeach;
    
    function the_launcher_bg_image_option_form( $control ) {
            if($control->manager->get_setting('the_launcher_form_bg_image')->value() != ''){
                return true;
                
            }else{
                return false;
            }
        }
    function the_launcher_bg_image_option_service( $control ) {
        if($control->manager->get_setting('the_launcher_service_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_feature( $control ) {
        if($control->manager->get_setting('the_launcher_feature_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_blogs( $control ) {
        if($control->manager->get_setting('the_launcher_blogs_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_video( $control ) {
        if($control->manager->get_setting('the_launcher_video_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_client( $control ) {
        if($control->manager->get_setting('the_launcher_client_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_testimonial( $control ) {
        if($control->manager->get_setting('the_launcher_testimonial_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_pricing( $control ) {
        if($control->manager->get_setting('the_launcher_pricing_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_cta( $control ) {
        if($control->manager->get_setting('the_launcher_cta_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_bg_image_option_contact( $control ) {
        if($control->manager->get_setting('the_launcher_contact_bg_image')->value() != ''){
            return true;
            
        }else{
            return false;
        }
    }
    function the_launcher_side_menu_activate( $control ){
        if($control->manager->get_setting('the_launcher_header_menu_style')->value() == 'side_menu'){
            return true;
        }
        else
        {
            return false;
        }
    }
}