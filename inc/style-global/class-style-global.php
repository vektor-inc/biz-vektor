<?php
/**
 * Displays style for BizVektor Global Version on front-end
 * 
 */
class BizVektor_Style_Global {

	static function init() {
		return self::create_css_file();
	}

	//create css file from base style and custom style (font)
	static function create_css_file() {

		$folder = get_template_directory() . '/inc/style-global/';
		require $folder . 'fonts-list.php';

		//Google Web Fonts
		$font_url 	  = $google_api . $fonts[3] . ':' . $styles;
		$style_custom = '@import url(' . $font_url . ');';

		//default global version style
		$style_base   = file_get_contents( 'css/style-base.css', true );

		//comments for css file
		$notes 		  = "/* This is a dynamic file.
		 If you need to edit the css, edit this file: style-base.css.*/ \r\n";	

		 //generates css file
		 $style = fopen( $folder . 'css/style.css', 'w' );
		 fwrite( $style, $notes . $style_custom . $style_base );
		 fclose( $style );
	}

}