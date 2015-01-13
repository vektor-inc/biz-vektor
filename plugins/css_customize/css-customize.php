<?php

add_filter('biz_vektor_is_css_customize_widgets', 'biz_vektor_csscustom_beacon', 10, 1 );
function biz_vektor_csscustom_beacon($flag){
	$flag = true;
	return $flag;
}

/*-------------------------------------------*/
/*	CSSカスタマイズ」のメニュー
/*-------------------------------------------*/

function biz_vektor_css_customize_menu() 
{
	add_theme_page(
		__( 'CSS Customize', 'biz-vektor' ),
		__( 'CSS Customize', 'biz-vektor' ),
		'edit_theme_options',
		'theme-css-customize',
		'biz_vektor_css_customize_render_page'
	);
}

add_action('admin_menu', 'biz_vektor_css_customize_menu');

function biz_vektor_css_customize_render_page()
{
	$data = biz_vektor_css_customize_valid_form();

	include(locate_template('plugins/css_customize/css-customize-edit.php'));
}

/*-------------------------------------------*/
/*	設定画面のCSSとJS
/*-------------------------------------------*/
add_action( 'admin_footer', 'css_customize_page_js_and_css');
function css_customize_page_js_and_css( $hook_suffix ) {
	global $hook_suffix;
	if (
		$hook_suffix == 'appearance_page_theme-css-customize' ||
		$hook_suffix == 'appearance_page_bv_grid_unit_options'
		){
	?>
 <script type="text/javascript">
jQuery(document).ready(function($){
	jQuery("#tipsBody dl").each(function(){
		var targetId = jQuery(this).attr("id");
		var targetTxt = jQuery(this).find("dt").text();
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
		$cleanCSS = strip_tags(stripslashes(trim($_POST['bv-css-css'])));

		if( update_option('biz_vektor_css_custom', $cleanCSS) )
			$data['mess'] = '<div id="message" class="updated"><p>' . __( 'Your custom CSS was saved.', 'biz-vektor') . '</p></div>';
	}
	else
	{
		if( isset($_POST['bv-css-submit']) && !empty($_POST['bv-css-submit']) )
			$data['mess'] = '<div id="message" class="error"><p>' . __( 'Error occured. Please try again.', 'biz-vektor') . '</p></div>';
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

add_action('wp_head', 'biz_vektor_css_customize_push_css', 200);
function biz_vektor_css_customize_push_css(){

	if( get_option('biz_vektor_css_custom') ){
	?>
<style type="text/css">
<?php echo get_option('biz_vektor_css_custom') ?>
</style>
	<?php
	}
}