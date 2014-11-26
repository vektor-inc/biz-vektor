<?php
/**
 * Displays style for BizVektor Global Version on front-end
 * 
 */
class BizVektor_Style_Global {

	static function init() {
		return self::regroup_css();
	}

	/**
	* Regroup css from base style and custom style (font)
	* 
	* @return string css
	*/
	static function regroup_css() {

		$css 	= '';
		$folder = get_template_directory() . '/inc/style-global/';
		require $folder . 'fonts-list.php';

		//Google Web Fonts import 
		if ( isset( $fonts ) ) {

			$font_url = $google_api . $fonts['Lato'] . ':' . $styles;
			$css 	 .= '@import url(' . $font_url . ");\r\n";
			$css 	 .= '* { font-family: \'' . $fonts['Lato'] . "', sans-serif; }\r\n";
		} 

		//default global version style
		$style_base   = file_get_contents( 'css/style-base.css', true );
		$css 		 .= $style_base;

		return $css;
	}

}