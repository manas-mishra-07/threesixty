<?php
/**
 * Testimonial post/page widget
 *
 * @package the_launcher lite
 */
/**
 * Adds the_launcher_Testimonial widget.
 */
 if(!function_exists('the_launcher_register_info_widget')){
add_action('widgets_init', 'the_launcher_register_info_widget');

function the_launcher_register_info_widget() {
    register_widget('the_launcher_info');
}
}
if(!class_exists('the_launcher_info')){
class the_launcher_info extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'the_launcher_info', 'The Launcher : Footer Info', array(
            'description' => __('A Widget That Shows Information', 'the-launcher')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // This widget has no title
            // Other fields
            'title_info' => array(
                'the_launcher_widgets_name' => 'title_info',
                'the_launcher_widgets_title' => __('Info Title', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'text',
            ),
            'info_description' => array(
                'the_launcher_widgets_name' => 'info_description',
                'the_launcher_widgets_title' => __('Info Description', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'textarea',
            ),
            'location' => array(
                'the_launcher_widgets_name' => 'location',
                'the_launcher_widgets_title' => __('Location', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'text',
            ),
            'phone' => array(
                'the_launcher_widgets_name' => 'phone',
                'the_launcher_widgets_title' => __('Phone', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'text',
            ),
            
            'email' => array(
                'the_launcher_widgets_name' => 'email',
                'the_launcher_widgets_title' => __('Email', 'the-launcher'),
                'the_launcher_widgets_field_type' => 'text',
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

        $title_info = $instance['title_info'];
        $location = $instance['location'];
        $phone = $instance['phone'];
        $info_desc = $instance['info_description'];
        $email = $instance['email'];
        echo $before_widget;
            ?>
                <div class="footer_info_wrap">
                    <?php if($title_info){ ?>
                        <div class="footer_widget_title footer-title-footer">
                            <?php echo esc_attr($title_info); ?>
                            <div class="faq_dot"></div>
                        </div>
                    <?php } ?>
                    
                    <div class="info_wrap">
                        <?php
                        if($info_desc){
                        ?>
                            <div class="desc_info">
                                <span class="desc"><?php echo wp_kses_post($info_desc); ?></span>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="info-wrap-info">
                        <?php
                         if($location){ ?>
                            <div class="location_info">
                                <span class="fa_icon_info"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                <span class="location"><?php echo esc_attr($location); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($phone){ ?>
                            <div class="phone_info">
                                <span class="fa_icon_info"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                <span class="phone"><?php echo esc_attr($phone); ?></span>
                            </div>
                        <?php } ?>
                        <?php if($email){ ?>
                            <div class="email_info">
                                <span class="fa_icon_info"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                <span class="email"><?php echo esc_attr($email); ?></span>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
        <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	the_launcher_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
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