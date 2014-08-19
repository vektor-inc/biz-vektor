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
/*	Judge rebuild
/*-------------------------------------------*/
function is_rebuild(){
	if (function_exists('biz_vektor_theme_styleSetting')) {
		$options = biz_vektor_get_theme_options();
		if ( $options['theme_style'] == 'rebuild' || $options['theme_style'] == '' ){
			return true;
			break;
		} else {
			/*
			一度保存されているラベルのスキンプラグインが停止またはアンインストールされている事があるので、
			保存されているスキンが使用出来るか判別するために変数の配列を確認。なければ変わりにrebuildを適用するのでtrueとする
			*/
			global $biz_vektor_theme_styles;
			biz_vektor_theme_styleSetting();
			if ( isset( $biz_vektor_theme_styles[$options['theme_style']] )){
				break;
			} else {
				return true;
			}
			// print '<pre>';print_r($biz_vektor_theme_styles[$options['theme_style']]);print '</pre>';
		}
	}
}

if (is_rebuild()){
	require( dirname( __FILE__ ) . '/functions_003.php' );
}