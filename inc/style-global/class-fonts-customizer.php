<?php
/**
 * Adds Google Web Fonts option to the theme customization screen of BizVektor Global Version.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class BizVektor_Style_Global_Customize {

	//bdfg
	public static function register ( $wp_customize ) {


	  $wp_customize->add_section( 'bizvektor_global', 
	     array(
	        'title' 	  => _x( 'Google Web Fonts', 'biz-vektor theme-customizer', 'biz-vektor' ),
	        'priority'    => 99,
	        'capability'  => 'edit_theme_options',
	        'description' => __x( 'Choose the font you want to use for your website.', 'biz-vektor theme-customizer', 'biz-vektor' ),
	     ) 
	 );
	}
}