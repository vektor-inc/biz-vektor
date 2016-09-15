<!DOCTYPE html>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<![endif]-->
<html xmlns:fb="http://ogp.me/ns/fb#" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title(); ?></title>
<link rel="start" href="<?php echo home_url(); ?>" title="HOME" />

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

<?php if( bizVektorOptions('enableie8Warning') ): ?>
<!--[if lte IE 8]>
<div id="eradi_ie_box">
<div class="alert_title">ご利用の <span style="font-weight: bold;">Internet Exproler</span> は古すぎます。</div>
<p>あなたがご利用の Internet Explorer はすでにサポートが終了しているため、正しい表示・動作を保証しておりません。<br />
古い Internet Exproler はセキュリティーの観点からも、<a href="https://www.microsoft.com/ja-jp/windows/lifecycle/iesupport/" target="_blank" >新しいブラウザに移行する事が強く推奨されています。</a><br />
<a href="http://windows.microsoft.com/ja-jp/internet-explorer/" target="_blank" >最新のInternet Exproler</a> や <a href="https://www.microsoft.com/ja-jp/windows/microsoft-edge" target="_blank" >Edge</a> を利用するか、<a href="https://www.google.co.jp/chrome/browser/index.html" target="_blank">Chrome</a> や <a href="https://www.mozilla.org/ja/firefox/new/" target="_blank">Firefox</a> など、より早くて快適なブラウザをご利用ください。</p>
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

<?php if ( !is_front_page() && !is_page_template( 'page-lp.php' ) ) { ?>
<?php get_template_part('module_pageTit'); ?>
<?php get_template_part('module_panList'); ?>
<?php } ?>

<div id="main">