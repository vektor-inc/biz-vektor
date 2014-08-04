<!DOCTYPE html>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="edge" />
<![endif]-->
<?php global $biz_vektor_options;
$biz_vektor_options = biz_vektor_get_theme_options(); ?>
<html xmlns:fb="http://ogp.me/ns/fb#" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo getHeadTitle(); ?></title>
<meta name="description" content="<?php getHeadDescription(); ?>" />
<meta name="keywords" content="<?php biz_vektor_getHeadKeywords(); ?>" />
<link rel="start" href="<?php echo site_url(); ?>" title="HOME" />
<?php
/* We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
 */
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */
wp_head(); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
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
<meta id="viewport" name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=1.0, minimum-scale=1.0">
</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<?php
if ($biz_vektor_options['fbAppId']) :
?>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=<?php echo esc_html($biz_vektor_options['fbAppId']); ?>";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>

<div id="wrap">

<!--[if lte IE 8]>
<div id="eradi_ie_box">
<div class="alert_title">ご利用の Internet Exproler は古すぎます。</div>
<p>このウェブサイトはあなたがご利用の Internet Explorer をサポートしていないため、正しく表示・動作しません。<br />
古い Internet Exproler はセキュリティーの問題があるため、新しいブラウザに移行する事が強く推奨されています。<br />
最新の Internet Exproler を利用するか、<a href="https://www.google.co.jp/chrome/browser/index.html" target="_blank">Chrome</a> や <a href="https://www.mozilla.org/ja/firefox/new/" target="_blank">Firefox</a> など、より早くて快適なブラウザを使用するようにしてください。</p>
</div>
<![endif]-->

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
<div id="gMenu" class="itemClose" onclick="showHide(\'gMenu\');">
<div id="gMenuInner" class="innerBox">
<h3 class="assistive-text"><span>MENU</span></h3>
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