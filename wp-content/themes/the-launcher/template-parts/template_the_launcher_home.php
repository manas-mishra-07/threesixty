<?php
/**
 * Template Name: The Launcher Home
 * */
 get_header();
$the_launcher_enabled_sections = the_launcher_get_menu_sections();
foreach($the_launcher_enabled_sections as $the_launcher_section) :?>
    <section id="<?php echo esc_attr($the_launcher_section['id']) ?>" class="plx-sections">
        <?php get_template_part('template-parts/section', $the_launcher_section['section']); ?>
    </section>
 <?php
endforeach;
get_footer();