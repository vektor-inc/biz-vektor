<?php
/*-------------------------------------------*/
/*	CSSカスタマイズ」のメニュー
/*-------------------------------------------*/

function biz_vektor_css_customize_menu() 
{
	add_theme_page(
		__( 'CSSカスタマイズ', 'biz_vektor_css_customize_title'),
		__( 'CSSカスタマイズ', 'biz_vektor_css_customize_menu'),
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
/*-------------------------------------------*/
/*	設定画面のCSSとJS
/*-------------------------------------------*/
add_action( 'admin_footer', 'css_customize_page_js_and_css');
function css_customize_page_js_and_css( $hook_suffix ) {
	global $hook_suffix;
	if ( $hook_suffix == 'appearance_page_biz-vektor-css-customize-menu' ){
	?>
<style type="text/css">
#tipsList h3 { background-color: #333; color:#fff; padding: 5px 10px; border-left:4px solid #e50000; }
#tipsList ul li { font-size:16px; }
#tipsBody { margin-top:20px; border-top:1px solid #ccc;padding-top:20px; }
#tipsBody code{ display:block; overflow:hidden; }
#tipsBody dl { margin-bottom:20px; }
#tipsBody dl dt { margin-bottom:5px; }
</style>
 <script type="text/javascript">
jQuery(document).ready(function($){
	jQuery("#tipsBody dl").each(function(){
		var targetId = jQuery(this).attr("id");
		var targetTxt = jQuery(this).find("dt").text();
		// console.log(targetId+" : "+targetTxt);
		var listItem = '<li><a href="#'+ targetId +'">'+ targetTxt +'</a></li>'
		jQuery('#tipsList ul').append(listItem);
	});
});
</script>


	<?php
	}
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