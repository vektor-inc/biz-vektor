<?php
get_template_part('plugins/seo_and_ga/seo_and_ga');
if (is_admin()) get_template_part('plugins/seo_and_ga/seo_and_ga_edit');

get_template_part('plugins/sns/sns');

get_template_part('plugins/widgets/widgets');

get_template_part('plugins/extra_module/extra_module');

get_template_part('plugins/add_post_type/add_post_type');

get_template_part('plugins/css_customize/css-customize');

get_template_part('plugins/dashboard_info_widget/dashboard-info-widget');

get_template_part('plugins/meta_description');

// get_template_part('plugins/post-type-manager-config');

function biz_vektor_footerCopyRight() 		{
	$options = biz_vektor_get_theme_options();
	$subSiteName = ($options['sub_sitename']);
	print '<div id="copy">Copyright &copy; <a href="'.home_url( '/' ).'" rel="home">';
	if ($subSiteName) {
		print $subSiteName;
	} else {
		bloginfo( 'name' );
	}
	print '</a> All Rights Reserved.</div>';

	$wordpressUrl = 'https://ja.wordpress.org/';
	$bizvektorUrl = 'http://bizvektor.com';

	//links for Global version
	if ( 'ja' != get_locale() ) {
		$wordpressUrl = 'https://wordpress.org/';
		$bizvektorUrl = 'http://bizvektor.com/en/';
	}

	// **** Don't change id name!
	$footerPowerd = '<div id="powerd">Powered by <a href="' . $wordpressUrl .'">WordPress</a> &amp; ';
	$footerPowerd .= '<a href="' . $bizvektorUrl . '" target="_blank" title="' . __( 'Free WordPress Theme BizVektor for business', 'biz-vektor' ) . '">';
	$footerPowerd .= ' BizVektor Theme</a> by <a href="http://www.vektor-inc.co.jp" target="_blank" title="' . _x( 'Vektor,Inc.', 'footer', 'biz-vektor' ) . '">Vektor,Inc.</a> technology.</div>';
	// **** Dont change filter name! Oh I already know 'Powerd' id miss spell !!!!!
	$footerPowerd = apply_filters( 'footerPowerdCustom', $footerPowerd );
	echo $footerPowerd;
}