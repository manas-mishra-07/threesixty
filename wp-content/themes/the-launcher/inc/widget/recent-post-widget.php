<?php
/**
 * Testimonial post/page widget
 *
 * @package the_launcher lite
 */
/**
 * Adds the_launcher_Testimonial widget.
 */
 if(!function_exists('the_launcher_register_recent_news_widget')){
add_action('widgets_init', 'the_launcher_register_recent_news_widget');

function the_launcher_register_recent_news_widget() {
    register_widget('the_launcher_recent_news');
}
}
if(!class_exists('the_launcher_recent_news')){
class the_launcher_recent_news extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'the_launcher_recent_news', 'The Launcher : Recent News', array(
            'description' => __('A widget that shows Recent News', 'the-launcher')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $categories_list = the_launcher_category_lists();
        $fields = array(
            // This widget has no title
            // Other fields
            'recent_news_title' => array(
                'the_launcher_widgets_name' => 'recent_news_title',
                'the_launcher_widgets_title' => __('Recent News Title', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'text',
            ),
            'recent_news_cat' => array(
                'the_launcher_widgets_name' => 'recent_news_cat',
                'the_launcher_widgets_title' => __('Recent News Category', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'select',
                'the_launcher_widgets_field_options' => $categories_list
            ),
            'recent_news_posts' => array(
                'the_launcher_widgets_name' => 'recent_news_posts',
                'the_launcher_widgets_title' => __('Post To Display', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'number',
            ),
            'recent_news_image' => array(
                'the_launcher_widgets_name' => 'recent_news_image',
                'the_launcher_widgets_title' => __('Hide Image', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'checkbox',
            ),
        );

        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);

        $news_title = $instance['recent_news_title'];
        $news_cat = $instance['recent_news_cat'];
        $recent_news_posts = $instance['recent_news_posts'];
        $image_hide = $instance['recent_news_image'];
        


        echo $before_widget;
        ?>

        <div class="footer_RN_wrap">
            <?php if($news_title){ ?>
                <div class="rn_title footer-title-footer">
                    <?php echo esc_attr($news_title); ?>
                     <div class="faq_dot"></div>
                </div>
               
            <?php } ?>
            <?php if($news_cat){ ?>
            <div class="rn_post_wrap <?php if($image_hide){echo 'no_image';} ?>">
                <?php
                    $rn_args = array(
                        'post_type' => 'post',
                        'cat' => $news_cat,
                        'order' => 'DESC',
                        'posts_per_page' => $recent_news_posts
                    );
                    $rn_query = new WP_Query($rn_args);
                    if($rn_query->have_posts()):
                        while($rn_query->have_posts()):
                            $rn_query->the_post();
                            ?>
                                <div class="rn_post_loop">
                                    <?php if($image_hide == ''){ ?>
                                    <?php 
                                        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'the_launcher_footer_recent_news');
                                        $image = $image_url['0'];
                                    ?>
                                        <?php if($image){ ?>
                                            <div class="rn_image"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image); ?>" /></a></div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="title_content_wrap">
                                        <?php if(get_the_title()){ ?>
                                            <div class="tn_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                                        <?php } ?>
                                        <?php if(get_the_content()){ ?>
                                            <div class="rn_content">
                                                <?php echo wp_trim_words(wp_kses_post(get_the_content()),'10','...'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                        endwhile;
                    endif;
                ?>
            </div>
            <?php } ?>
        </div>

        <?php
        echo $after_widget;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$the_launcher_widgets_name] = the_launcher_widgets_updated_field_value($widget_field, $new_instance[$the_launcher_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	the_launcher_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $the_launcher_widgets_field_value = !empty($instance[$the_launcher_widgets_name]) ? esc_attr($instance[$the_launcher_widgets_name]) : '';
            the_launcher_widgets_show_widget_field($this, $widget_field, $the_launcher_widgets_field_value);
        }
    }

}
}