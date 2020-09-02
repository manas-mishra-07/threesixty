<?php if ( is_active_sidebar( 'the-launcher-pricing-table' ) ) :
$the_launcher_pricing_section_title = get_theme_mod('the_launcher_pricing_section_title');
$the_launcher_pricing_section_sub_title = get_theme_mod('the_launcher_pricing_section_sub_title');
$the_launcher_pricing_section_desc = get_theme_mod('the_launcher_pricing_desc');?>
<div class="ak-container">  
        <?php
            if($the_launcher_pricing_section_title || $the_launcher_pricing_section_sub_title || $the_launcher_pricing_section_desc){
        ?>
            <div class="title_desc">
            <?php
            if($the_launcher_pricing_section_title || $the_launcher_pricing_section_sub_title){
            ?>
                <div class="title_sub">
                <?php
                if($the_launcher_pricing_section_title){
                ?>
                    <span class="service_title wow fadeInUp"><?php echo esc_attr($the_launcher_pricing_section_title); ?></span>
                <?php } 
                if($the_launcher_pricing_section_sub_title){
                ?>
                    <span class="service_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_pricing_section_sub_title); ?></span>
                <?php } ?>
                </div>
            <?php } ?>
            <?php if($the_launcher_pricing_section_desc){ ?>
                <div class="service_desc wow fadeInUp"><?php echo wp_kses_post($the_launcher_pricing_section_desc); ?></div>
            <?php } ?>
            </div>
        <?php
        }
        ?>
        <div class="pricing_widget wow fadeInUp">
        
        	<ul id="sidebar">
        		<?php dynamic_sidebar( 'the-launcher-pricing-table' ); ?>
        	</ul>
        
        </div>
    </div>
<?php endif; ?> 
