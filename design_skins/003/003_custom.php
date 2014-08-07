<?php

/*-------------------------------------------*/
/*	Judge calmly
/*-------------------------------------------*/
/*
/*-------------------------------------------*/
/*	Get 'calmly' options
/*-------------------------------------------*/
/*	Variable settings
/*-------------------------------------------*/
/*	Setting customizer
/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Judge 003
/*-------------------------------------------*/
function is_003(){
	if (function_exists('biz_vektor_theme_styleSetting')) {
		$options = biz_vektor_get_theme_options();
		if ($options['theme_style'] == '003'):
			return true;
			break;
		endif;
	}
}

if (is_003()){
	require( dirname( __FILE__ ) . '/functions_003.php' );
}