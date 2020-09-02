<?php
/**
 * the launcher Theme Customizer
 *
 * @package the launcher
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function the_launcher_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    /*------------------------------------------------------------------------------------*/
    /**
     * Upgrade to Uncode Pro
    */
    // Register custom section types.
    $wp_customize->register_section_type( 'Launcher_Customize_Section_Pro' );

    // Register sections.
    $wp_customize->add_section(
        new Launcher_Customize_Section_Pro(
            $wp_customize,
            'revolve-pro',
            array(
                'title1'    => esc_html__( 'Free Vs Pro', 'the-launcher' ),
                'pro_text1' => esc_html__( 'Compare','the-launcher' ),
                'pro_url1'  => admin_url( 'themes.php?page=thelauncher-welcome&section=free_vs_pro'),
                'priority' => 1,
            )
        )
    );
    $wp_customize->add_setting(
        'launcher_pro_upbuton',
        array(
            'section' => 'launcher-pro',
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'launcher_pro_upbuton',
        array(
            'section' => 'launcher-pro',
            'priority' => 0,
        )
    );

    $wp_customize->add_setting( 'the_launcher_skin_color', array( 'default'=>'#FF7E00', 'transport'   => 'postMessage', 'sanitize_callback'=>'sanitize_text_field' ) );
    $wp_customize->add_control( 
            new WP_Customize_Color_Control(
            $wp_customize, 
            'the_launcher_skin_color', 
            array(
                'label'      => esc_html__( 'Template Color', 'the-launcher' ),
                'description' => esc_html__( 'Set the Template Skin color for the site.', 'the-launcher' ),
                'section'    => 'the_launcher_skinn_color_section',
                'settings'   => 'the_launcher_skin_color',
            ) ) 
        );
}
add_action( 'customize_register', 'the_launcher_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function the_launcher_customize_preview_js() {
	wp_enqueue_script( 'the_launcher_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'the_launcher_customize_preview_js' );
// Our Product detail's
if(class_exists( 'WP_Customize_control')){

    /**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Launcher_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'launcher-pro';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text1 = '';
        public $title1 = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url1 = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();
            $json['title1'] = $this->title1;
            $json['pro_text1'] = $this->pro_text1;
            $json['pro_url1']  = $this->pro_url1;
            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title1 }}
                    <# if ( data.pro_text1 && data.pro_url1 ) { #>
                        <a href="{{ data.pro_url1 }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text1 }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }
}