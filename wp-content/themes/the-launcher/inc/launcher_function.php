<?php
function the_launcher_category_lists(){
        $categories = get_categories(
            array(
                'hide_empty' => 0,
                'exclude' => 1
            )
        );
        $category_lists = array();
        $category_lists[''] = __('Select Category', 'the-launcher');
        foreach($categories as $category) :
            $category_lists[$category->term_id] = $category->name;
        endforeach;
        return $category_lists;
}
function the_launcher_year_list()
{
    $year = date("Y");
    $i= $year + 10;
   for($year = $year;$year<=$i;$year++)
    {
         $year_array[$year] = $year;
          
    }
    return $year_array;
}
function the_launcher_month()
{
    
   for($i = 1;$i<=12;$i++)
    {
         $month_array[$i] = $i;
          
    }
    return $month_array;
}
function the_launcher_day()
{
    for($i = 1;$i<=31;$i++)
    {
         $day_array[$i] = $i;
          
    }
    return $day_array;
}
function the_launcher_hour()
{
    for($i = 1;$i<=24;$i++)
    {
         $day_array[$i] = $i;
          
    }
    return $day_array;
}
function the_launcher_minut()
{
    for($i = 1;$i<=60;$i++)
    {
         $day_array[$i] = $i;
          
    }
    return $day_array;
}
function the_launcher_font_size(){
     $font_size[''] = 'Default';
    for($i=12;$i<=70;$i++)
    {
        $font_size[$i] = $i;
    }
   
    return $font_size;
}
function the_launcher_font()
{
    return $fonts = array(
        ''=>'Default',
        'Raleway'=>'Raleway',
        'Source Sans Pro'=>'Source Sans Pro',
        'Josefin Sans'=>'Josefin Sans'
    );
}
function the_launcher_post_lists1(){
        wp_reset_postdata();
        $posts = get_posts(array('posts_per_page'   => -1));
        $post_lists = array();
        $post_lists[''] = __('Select post', 'the-launcher'); 
        foreach($posts as $post) :
            $post_lists[$post->ID] = $post->post_title;
        endforeach;
        return $post_lists;
    }
    
function the_launcher_get_menu_sections(){
        
    $enable_disables_sections = array('service','feature','blogs','video','pricing','testimonial','client','cta','contact');
    $enabled_section = array();
    foreach($enable_disables_sections as $enable_disables_section) :
        if(get_theme_mod('the_launcher_enable_'.$enable_disables_section) == 1) :
            $enabled_section[] = array(
                'id' => 'plx_'.$enable_disables_section.'_section',
                'section' => $enable_disables_section,
            ); 
        endif;
    endforeach;
    return $enabled_section;
}

function the_launcher_bg()
{
    $enable_disables_sections = array('service','feature','blogs','video','pricing','testimonial','client','cta','contact');
    $enabled_sections = array();
    foreach($enable_disables_sections as $enable_disables_section) :
        if(get_theme_mod('the_launcher_enable_'.$enable_disables_section)) :
            $enabled_sections[] = array(
                'section' => $enable_disables_section,
            ); 
        endif;
    endforeach;?>
        <style>
            <?php foreach($enabled_sections as $enabled_section) :
                    $section = $enabled_section['section'];
                    $section_bg_color =      get_theme_mod('the_launcher_'.$section.'_bg_color');
                    $section_bg_image =    get_theme_mod('the_launcher_'.$section.'_bg_image');
                    $repeat = get_theme_mod('the_launcher_'.$section.'_bg_repeat');
                    $position = get_theme_mod('the_launcher_'.$section.'_position');
                    $attachment = get_theme_mod('the_launcher_'.$section.'_attachment');
                    if($repeat == ''){
                        $repeat = 'no-repeat';
                    }
                    if($position == ''){
                        $position = 'fixed';
                    }
                    if($section_bg_color || $section_bg_image){?>
                #plx_<?php echo esc_attr($section).'_section'; ?>{
                    background: <?php echo esc_attr($section_bg_color).' url('.esc_url($section_bg_image).') '.esc_attr($repeat).' '.esc_attr($position).' '.esc_attr($attachment); ?>
                }
                <?php } ?>
            <?php endforeach; ?>
        </style>
    <?php 
}

    add_action('wp_head','the_launcher_bg');
    
function the_launcher_sanitize_title_span($input){
    $all_tags = array(
        'span'=>array(
            'class'=>array()
        ),
        'br'=>array(
            'class'=>array()
        )
     );
    return wp_kses($input,$all_tags);
    
}
function the_launcher_custom_logo() {
    if(function_exists('get_custom_logo')){
        if (get_theme_mod('custom_logo')){
            echo get_custom_logo();
        }
        else{
            $site_tagline = get_theme_mod('header_textcolor');
            if($site_tagline !== 'blank'){ ?>
                <div class="site-branding clearfix">
                   <h1 class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                   </h1>
                   <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                </div><!-- .site-branding -->
        <?php }
    }
    }
    

}
add_action('the_launcher_action_custom_logo','the_launcher_custom_logo');



function the_launcher_dark_color_function($colourstr, $steps) {
  $colourstr = str_replace('#','',$colourstr);

  $rhex = substr($colourstr,0,2);
  $ghex = substr($colourstr,2,2);
  $bhex = substr($colourstr,4,2);

  $r = hexdec($rhex);
  $g = hexdec($ghex);
  $b = hexdec($bhex);

  $r = dechex(max(0,min(255,$r + $steps)));
  $g = dechex(max(0,min(255,$g + $steps)));  
  $b = dechex(max(0,min(255,$b + $steps)));

  $r = str_pad($r,2,"0");
  $g = str_pad($g,2,"0");
  $b = str_pad($b,2,"0");

  $cor = '#'.$r.$g.$b;

  return $cor;
}