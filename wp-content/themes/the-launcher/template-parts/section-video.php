<?php
$the_launcher_section_title = get_theme_mod('the_launcher_video_section_title');
$the_launcher_section_sub_title = get_theme_mod('the_launcher_video_section_sub_title');
$the_launcher_section_description = get_theme_mod('the_launcher_video_desc');
$the_launcher_get_video_url = get_theme_mod('the_launcher_video_url');?>
    <div class="launcher_video">
        <?php
            if($the_launcher_section_title || $the_launcher_section_sub_title || $the_launcher_section_description){
        ?>
            <div class="title_desc">
            <div class="ak-container">
            <?php
            if($the_launcher_section_title || $the_launcher_section_sub_title){
            ?>
                <div class="title_sub">
                <?php
                if($the_launcher_section_title){
                ?>
                    <span class="service_title wow fadeInUp"><?php echo esc_attr($the_launcher_section_title); ?></span>
                <?php } 
                if($the_launcher_section_sub_title){
                ?>
                    <span class="service_sub_title wow fadeInUp"><?php echo esc_attr($the_launcher_section_sub_title); ?></span>
                <?php } ?>
                </div>
            <?php } 
            if($the_launcher_section_description){ ?>
                <div class="service_desc wow fadeInUp"><?php echo wp_kses_post($the_launcher_section_description); ?></div>
            <?php } ?>
            </div>
            </div>

        <?php
        }
        if($the_launcher_get_video_url){ ?>
                <?php
                  $the_launcher_vidarr = explode('?v=', $the_launcher_get_video_url); 
                  $the_launcher_vid_id = $the_launcher_vidarr[1];
                ?>
                <div class="video_wrap wow fadeInUp">
                    <button id="togglePlay" class="play-pause-video"></button>
                    <section id="container-1" class="video js-video" data-property="{videoURL:'<?php echo esc_attr($the_launcher_vid_id) ?>',containment:'#container-1',autoPlay:false, mute:true, startAt:0, opacity:1}"></section>
                    <div class="gap"></div>
                </div>
        <?php } ?>
    

    </div>
