<?php
/*-------------------------------------------*/
/*	CSSカスタマイズ」のメニュー
/*-------------------------------------------*/

function biz_vektor_css_customize_menu() 
{
	add_theme_page(
		__( 'CSSをカスタマイズ', 'biz_vektor_css_customize_title'),
		__( 'CSSをカスタマイズ', 'biz_vektor_css_customize_menu'),
		'manage_options',
		'biz-vektor-css-customize-menu',
		'biz_vektor_css_customize_render_page'
	);
}

add_action('admin_menu', 'biz_vektor_css_customize_menu');

function biz_vektor_css_customize_render_page()
{
	$data = biz_vektor_css_customize_valid_form();

	include(locate_template('plugins/css_customize/css-customize-html.php'));
}

function biz_vektor_css_customize_valid_form()
{
	$data = array(
		'mess' => '',
		'customCss' => ''
	);

	if( isset($_POST['bv-css-submit']) && !empty($_POST['bv-css-submit'])
		&& isset($_POST['bv-css-css']) 
		&& isset($_POST['biz-vektor-css-nonce']) && wp_verify_nonce( $_POST['biz-vektor-css-nonce'], 'biz-vektor-css-submit' ) )
	{
		require_once(TEMPLATEPATH . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'css_customize' . DIRECTORY_SEPARATOR . 'class.inputfilter_clean.php');	
		$inputFilter 	= new InputFilter();

		$cleanCSS = $inputFilter->process(stripslashes(trim($_POST['bv-css-css'])));;

		$data['customCss'] = $cleanCSS;

		if( update_option('biz_vektor_css_custom', $cleanCSS) )
			$data['mess'] = '<div id="message" class="updated"><p>' . __( 'CSSが保存されました。', 'biz_vektor_css_customize_success') . '</p></div>';
	}
	else
	{
		if( isset($_POST['bv-css-submit']) && !empty($_POST['bv-css-submit']) )
			$data['mess'] = '<div id="message" class="error"><p>' . __( 'エラーが発生しました。', 'biz_vektor_css_customize_error') . '</p></div>';
	}

	$data['customCss'] = biz_vektor_css_customize_get_css();

	return $data;
}

function biz_vektor_css_customize_get_css()
{
	if( get_option('biz_vektor_css_custom') )
		return get_option('biz_vektor_css_custom');
	else
		return '';
}