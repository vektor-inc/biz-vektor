<!DOCTYPE html>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<![endif]-->
<?php global $biz_vektor_options;
biz_vektor_get_theme_options(); ?>
<html xmlns:fb="http://ogp.me/ns/fb#" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?></title>
<link rel="start" href="<?php echo home_url(); ?>" title="HOME" />
<link rel="alternate" href="<?php echo home_url(); ?>" hreflang="<?php echo substr(get_bloginfo ( 'language' ), 0, 2);?>" />
<!-- <?php echo get_biz_vektor_name();?> v<?php echo BizVektor_Theme_Version; ?> -->

<?php
/* 子テーマが利用されている場合は旧IEでのCSS上書き用ファイルを出力
/* 備考:file_exists はセーフモードのサーバーで動作しないため不使用
*/
if (get_template_directory_uri() != get_stylesheet_directory_uri()){
	$stylePathOldIe = get_stylesheet_directory_uri()."/style_oldie.css";
	print '<!--[if lte IE 8]>'."\n";
	print '<link rel="stylesheet" type="text/css" media="all" href="'.$stylePathOldIe.'" />'."\n";
	print '<![endif]-->'."\n";
} ?>
<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action('biz_vektor_sns_body'); ?>

<div id="wrap">

<?php if(
!isset($biz_vektor_options['enableie8Warning']) ||
( isset($biz_vektor_options['enableie8Warning']) && $biz_vektor_options['enableie8Warning'] )
): ?>
<!--[if lte IE 8]>
<div id="eradi_ie_box">
<div class="alert_title">ご利用の Internet Exproler は古すぎます。</div>
<p>このウェブサイトはあなたがご利用の Internet Explorer をサポートしていないため、正しく表示・動作しません。<br />
古い Internet Exproler はセキュリティーの問題があるため、新しいブラウザに移行する事が強く推奨されています。<br />
最新の Internet Exproler を利用するか、<a href="https://www.google.co.jp/chrome/browser/index.html" target="_blank">Chrome</a> や <a href="https://www.mozilla.org/ja/firefox/new/" target="_blank">Firefox</a> など、より早くて快適なブラウザをご利用ください。</p>
</div>
<![endif]-->
<?php endif; ?>

<!-- [ #headerTop ] -->
<div id="headerTop">
<div class="innerBox">
<div id="site-description"><?php bloginfo( 'description' ); ?></div>
</div>
</div><!-- [ /#headerTop ] -->

<!-- [ #header ] -->
<div id="header">
<div id="headerInner" class="innerBox">
<!-- [ #headLogo ] -->
<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
<<?php echo $heading_tag; ?> id="site-title">
<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>" rel="home">
<?php biz_vektor_print_headLogo(); ?>
</a>
</<?php echo $heading_tag; ?>>
<!-- [ /#headLogo ] -->

<!-- [ #headContact ] -->
<?php biz_vektor_print_headContact(); ?>
<!-- [ /#headContact ] -->

</div>
<!-- #headerInner -->
</div>
<!-- [ /#header ] -->

<?php
$args = array(
 'theme_location' => 'Header',
 'fallback_cb' => '',
 'echo' => false,
 'walker' => new description_walker()
);
$gMenu = wp_nav_menu( $args ) ;
// メニューがセットされていたら実行
if ($gMenu) {
// ナビのHTMLを一旦変数に格納
$gMenuHtml = '
<!-- [ #gMenu ] -->
<div id="gMenu" class="itemClose">
<div id="gMenuInner" class="innerBox">
<h3 class="assistive-text" onclick="showHide(\'gMenu\');"><span>MENU</span></h3>
<div class="skip-link screen-reader-text">
	<a href="#content" title="'.__('Skip menu', 'biz-vektor').'">'.__('Skip menu', 'biz-vektor').'</a>
</div>'."\n";
$gMenuHtml .= $gMenu."\n";
$gMenuHtml .= '</div><!-- [ /#gMenuInner ] -->
</div>
<!-- [ /#gMenu ] -->'."\n";
// gMenuのHTMLにフックを設定
$gMenuHtml = apply_filters( 'bizvektor_gMenuHtml', $gMenuHtml );
// gMenuのHTMLを出力
echo $gMenuHtml;
} // if ($gMenu) 
?>

<?php echo get_biz_vektor_header_image_home();?>

<?php if (!is_front_page()) { ?>
<?php get_template_part('module_pageTit'); ?>
<?php get_template_part('module_panList'); ?>
<?php } ?>

<div id="main">