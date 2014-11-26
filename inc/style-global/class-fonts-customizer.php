<?php
/**
 * Adds Google Web Fonts option to the theme customization screen of BizVektor Global Version.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class BizVektor_Style_Global_Customize {

	/**
    * Adds a section and controls for Google Web Fonts to Theme Customizer screen 
    *
    * @param \WP_Customize_Manager $wp_customize
    */
	public static function register ( $wp_customize ) {

		/* Add Section To Theme Customizer Panel */
		$wp_customize->add_section( 'bizvektor_global_font', 
			array(
			'title' 	  => _x( 'Google Web Fonts', 'biz-vektor theme-customizer', 'biz-vektor' ),
			'priority'    => 99,
			'capability'  => 'edit_theme_options',
			'description' => _x( 'Choose the font for your website.', 'biz-vektor theme-customizer', 'biz-vektor' ),
			) 
		);

		/* Setting In Database */
		$wp_customize->add_setting( 'biz_vektor_theme_options[global_font]',
			array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			) 
		);     

		/* Control That Links Section And Database (Displays Html) */
		//gets fonts list
		require get_template_directory() . '/inc/style-global/fonts-list.php';

		$wp_customize->add_control( 
			new WP_Customize_Control(
				$wp_customize,
				'bizvektor_global_font',
				array(
					'label'          => __( 'Font', 'biz-vektor' ),
					'section'        => 'bizvektor_global_font',
					'settings'       => 'biz_vektor_theme_options[global_font]',
					'type'           => 'select',
					'choices'        => $fonts,
				)
			)
		);
	}

	/**
    * Displays CSS for live preview in Theme Customizer
    *
	* @uses get_theme_mod()
    */
	public static function generate_css() {

		$font_name = get_theme_mod( 'biz_vektor_theme_options[global_font]' );
		var_dump($font_name);
		die();
	}
}