<?php


Biz_Vektor_plugin_controller::$enable_packages = array(
		'sns',
		'add_post_type',
		'css-customize',
		'dashboard_info_widget',

	);


//////



Biz_Vektor_plugin_controller::init();

class Biz_Vektor_plugin_controller{
	public static $enable_packages = array();
	public static $packages_dir = 'plugin/';

	public static function init(){
		if(count( self::$enable_packages ) == 0){ return; }

		foreach( self::$enable_packages as $package ){
			get_template( locate_template( self::$packages_dir . $package . '/' . $package ) );
		}
	}
}