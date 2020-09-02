<?php
add_action('widgets_init', 'the_launcher_register_pricing_widget');

function the_launcher_register_pricing_widget() {
    register_widget('the_launcher_pricing');
}

class the_launcher_Pricing extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'the_launcher_pricing', 'The Launcher : Pricing Table', array(
            'description' => __('A widget that shows Pricing Table', 'the-launcher')
                )
        );
    }
    
    private function widget_fields()
    {
        $fields = array(
            'the_launcher_pricing_title'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_title',
                'the_launcher_widgets_title'=>__('Title','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_title_sub'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_title_sub',
                'the_launcher_widgets_title'=>__('Sub Title','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_price_currency'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_price_currency',
                'the_launcher_widgets_title'=>__('Currency','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_price'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_price',
                'the_launcher_widgets_title'=>__('Price','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_duration'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_duration',
                'the_launcher_widgets_title'=>__('Duration','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_field1'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_field1',
                'the_launcher_widgets_title'=>__('Field 1','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_field2'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_field2',
                'the_launcher_widgets_title'=>__('Field 2','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_field3'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_field3',
                'the_launcher_widgets_title'=>__('Field 3','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_field4'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_field4',
                'the_launcher_widgets_title'=>__('Field 4','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_field5'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_field5',
                'the_launcher_widgets_title'=>__('Field 5','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_field6'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_field6',
                'the_launcher_widgets_title'=>__('Field 6','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_button'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_button',
                'the_launcher_widgets_title'=>__('Butten Text','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_button_link'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_button_link',
                'the_launcher_widgets_title'=>__('Button Link','the-launcher'),
                'the_launcher_widgets_field_type'=>'text'
            ),
            'the_launcher_pricing_heghlite'=>array(
                'the_launcher_widgets_name'=>'the_launcher_pricing_heghlite',
                'the_launcher_widgets_title'=>__('Highlite Pricing Table','the-launcher'),
                'the_launcher_widgets_field_type'=>'checkbox'
            ),
        );
        return $fields;
    }
    public function widget($args,$instance)
    {
        extract($args);
        
        $pricing_title = $instance['the_launcher_pricing_title'];
        $pricing_sub_title = $instance['the_launcher_pricing_title_sub'];
        $price_currency = $instance['the_launcher_pricing_price_currency'];
        $pricing_price = $instance['the_launcher_pricing_price'];
        $pricing_duration = $instance['the_launcher_pricing_duration'];
        $pricing_field1 = $instance['the_launcher_pricing_field1'];
        $pricing_field2 = $instance['the_launcher_pricing_field2'];
        $pricing_field3 = $instance['the_launcher_pricing_field3'];
        $pricing_field4 = $instance['the_launcher_pricing_field4'];
        $pricing_field5 = $instance['the_launcher_pricing_field5'];
        $pricing_field6 = $instance['the_launcher_pricing_field6'];
        $pricing_button_text = $instance['the_launcher_pricing_button'];
        $button_link = $instance['the_launcher_pricing_button_link'];
        $highlite_table = $instance['the_launcher_pricing_heghlite'];?>
            <div class="the_launcher_pricing_widget <?php if($highlite_table){echo 'highlite_table';} ?>">
                <?php if($pricing_title) { ?><div class="the_launcher_pricing_title_class"><?php echo esc_attr($pricing_title); ?></div><?php } ?>
                <?php if($pricing_sub_title){ ?><div class="the_launcher_pricing_sub_title"><?php echo esc_attr($pricing_sub_title); ?></div><?php } ?>
                <div class="pricong_bg_top"></div>
                <div class="the_launcher_pricing_price_class"><?php echo '<span><span class="currency">'.esc_attr($price_currency).'</span>'.esc_attr($pricing_price).'</span><span>'.esc_attr($pricing_duration).'</span>'; ?></div>
                <?php if($pricing_field1){ ?><div class="the_launcher_pricing_field1_class pricing-field"><?php echo the_launcher_sanitize_title_span($pricing_field1); ?></div> <?php } ?>
                <?php if($pricing_field2){ ?><div class="the_launcher_pricing_field2_class pricing-field"><?php echo the_launcher_sanitize_title_span($pricing_field2); ?></div><?php } ?>
                <?php if($pricing_field3){ ?><div class="the_launcher_pricing_field3_class pricing-field"><?php echo the_launcher_sanitize_title_span($pricing_field3); ?></div><?php } ?>
                <?php if($pricing_field4){ ?><div class="the_launcher_pricing_field4_class pricing-field"><?php echo the_launcher_sanitize_title_span($pricing_field4); ?></div><?php } ?>
                <?php if($pricing_field5){ ?><div class="the_launcher_pricing_field5_class pricing-field"><?php echo the_launcher_sanitize_title_span($pricing_field5); ?></div><?php } ?>
                <?php if($pricing_field6){ ?><div class="the_launcher_pricing_field6_class pricing-field"><?php echo the_launcher_sanitize_title_span($pricing_field6); ?></div><?php } ?>
                <?php if($button_link || $pricing_button_text){ ?><div class="the_launcher_pricing_button_link_class"><a target="_blank" href="<?php echo esc_url($button_link); ?>"><?php echo esc_attr($pricing_button_text); ?></a></div><?php } ?>
            </div>
        <?php }
    
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