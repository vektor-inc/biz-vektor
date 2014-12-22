<?php


add_action( 'admin_menu', array('Biz_Vektor_Advanced_Options', 'init') );

class Biz_Vektor_Advanced_Options {
	
	public static function init() {

		add_theme_page( 
			__('Advanced Options', 'biz-vektor'),
			__('Advanced Options', 'biz-vektor'),
			'edit_theme_options',
			'theme_advanced_options',
			array('Biz_Vektor_Advanced_Options', 'displayView') 
		);

		add_action( 'admin_enqueue_scripts', array('Biz_Vektor_Advanced_Options', 'loadCss') );
	}

	public static function displayView() {

		//prepares data to display inside view
		$data = array(
			'types' => '',
			'pages' => '',
			'mess' 	=> ''
		);

		//verif form + saves new data
		$data['mess'] 	= self::verifForm();

		//gets advanced options saved in DB
		$adOptions 		= self::getAdvancedOptions();

		$data['types']	= !empty($adOptions['types']) ? implode( ',', $adOptions['types'] ) : '';
		$data['pages']	= !empty($adOptions['pages']) ? implode( ',', $adOptions['pages'] ) : '';


		require( 'theme-ad-options-edit.php' );
	}

	//load Biz Vektor admin css
	public static function loadCss() {

		Global $hook_suffix;
		if ( $hook_suffix == 'theme_advanced_options' ) {

			wp_register_style( 'style_bizvektor_admin', get_template_directory_uri() . '/css/style_bizvektor_admin.css');
			wp_enqueue_style( 'style_bizvektor_admin' );

		}
	}

	//form validation
	private static function verifForm() {
		
		$mess = '';

		if ( isset($_POST['submit']) && !empty($_POST['submit'])
			 && ( isset($_POST['types']) || isset($_POST['pages']) )
			 && wp_verify_nonce( $_POST['nonce-sitemap'], 'submit-sitemap' ) ) {

			if ( self::updateAdvancedOptions( $_POST['types'], $_POST['pages'] ) )
				$mess = '<div id="message" class="updated"><p>' . __( 'Settings were saved.', 'biz-vektor') . '</p></div>';	
		}
		else {
			if ( isset($_POST['submit']) && !empty($_POST['submit']) )
				$mess = '<div id="message" class="error"><p>' . __( 'Error occured. Please try again.', 'biz-vektor') . '</p></div>';
		}

		return $mess;
	}

	//manages update of values
	private static function updateAdvancedOptions( $types, $pages ) {

		//cleaning values before saving to DB
		$toclean = array(
			'types' => $types,
			'pages' => $pages
		);

		$cleaned = array(
			'types' => array(),
			'pages' => array(),
		);

		foreach ( $toclean as $key => $value ) {
			
			$valuesArray 	= explode( ',', $value );
			$cleanedValues 	= array();

			foreach ( $valuesArray as $val ) {

				if ( $val != '' ) {

					$cleanValue = '';

					if( $key == 'pages' && !empty($val) ) 
						$cleanValue = strip_tags(trim(intval($val)));	
					else
						$cleanValue = strip_tags(trim($val));

					$cleanedValues[] = $cleanValue;
				}
 			}

			$cleaned[$key] = $cleanedValues;	
		}

		//saving to DB
		return update_option('biz_vektor_ad_options', $cleaned);
	}

	public static function getAdvancedOptions() {

		$res = get_option('biz_vektor_ad_options');
		return !$res ? '' : $res; 
	}
}