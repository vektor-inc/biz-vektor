<?php


Biz_Vektor_plugin_controller::$enable_packages = array(
		'sns',
		'add_post_type',
		'css_customize',
		'dashboard_info_widget',
		'extra_module',
		'widgets',
		'theme-ad-options',
		'seo',
	);


//////



Biz_Vektor_plugin_controller::init();

class Biz_Vektor_plugin_controller{
	public static $enable_packages = array();
	public static $packages_dir = 'plugins/';

	public static function init(){
		if(count( self::$enable_packages ) == 0){ return; }

		foreach( self::$enable_packages as $package ){
			require(  $package . '/' . $package . '.php' );
		}
	}
}