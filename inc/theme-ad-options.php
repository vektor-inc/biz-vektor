<?php


add_action( 'admin_menu', array('Biz_Vektor_Advanced_Options', 'init') );

class Biz_Vektor_Advanced_Options {
	
	public static function init() {

		add_theme_page( 
			__('高度な設定', 'biz-vektor'),
			__('高度な設定', 'biz-vektor'),
			'manage_options',
			'theme_advanced_options',
			array('Biz_Vektor_Advanced_Options', 'displayView') 
		);

		add_action( 'admin_enqueue_scripts', array('Biz_Vektor_Advanced_Options', 'loadCss') );
	}

	public static function displayView() {
	
		require( 'theme-ad-options-edit.php' );
	}

	public static function loadCss() {

		Global $hook_suffix;
		if ( $hook_suffix == 'theme_advanced_options' ) {

			wp_register_style( 'style_bizvektor_admin', get_template_directory_uri() . '/css/style_bizvektor_admin.css');
			wp_enqueue_style( 'style_bizvektor_admin' );

		}
			require( 'theme-ad-options.css' );
	}
}