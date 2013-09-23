<!DOCTYPE html>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="edge" />
<![endif]-->
<html xmlns:fb="http://ogp.me/ns/fb#" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=1.0, minimum-scale=1.0">
<title><?php getHeadTitle(); ?></title>
<meta name="description" content="<?php getHeadDescription(); ?>" />
<meta name="keywords" content="<?php biz_vektor_getHeadKeywords(); ?>" />
<link rel="start" href="<?php echo site_url(); ?>" title="HOME" />
<?php biz_vektor_ogp(); ?>
<?php biz_vektor_theme_style(); ?>
<?php
if (is_front_page()) {
	// ▼スライドショーがある場合
	if (biz_vektor_slideExist()) {
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/js/FlexSlider/flexslider.css" type="text/css">';
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'flexSlider' , get_template_directory_uri().'/js/FlexSlider/jquery.flexslider.js', array('jquery'), '20120609');
	wp_enqueue_script( 'flexSlider' );
	}
} ?>

<?php
wp_register_script( 'masterjs' , get_template_directory_uri().'/js/master.js', array('jquery'), '20130708' );
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'masterjs' );
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
wp_head();
?>
<?php biz_vektor_theme_styleOldIe(); ?>
<?php biz_vektor_gMenuDivide(); ?>
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
<?php biz_vektor_googleAnalytics(); ?>
</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=<?php biz_vektor_fbAppId(); ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
if ( is_user_logged_in() == TRUE ) { ?>
<?php get_template_part('module_adminHeader'); ?>
<?php } ?>
<div id="wrap">
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
<!-- [ #headLogo ] -->

<!-- [ #headContact ] -->
<?php biz_vektor_print_headContact(); ?>
<!-- [ /#headContact ] -->


</div>
<!-- #headerInner -->
</div>
<!-- [ /#header ] -->


<?php
$gMenuExist = wp_nav_menu( array( 'theme_location' => 'Header' , 'fallback_cb' => '' , 'echo' => false ) ) ;
if ($gMenuExist) { ?>
<!-- [ #gMenu ] -->
<div id="gMenu" class="itemClose" onclick="showHide('gMenu');">
<div id="gMenuInner" class="innerBox">
<h3 class="assistive-text"><span>MENU</span></h3>
<div class="skip-link screen-reader-text"><a href="#content" title="<?php _e('Skip menu', 'biz-vektor'); ?>"><?php _e('Skip menu', 'biz-vektor'); ?></a></div>
<?php wp_nav_menu( array(
 'theme_location' => 'Header',
 'fallback_cb' => '',
 'walker' => new description_walker()
));
?>
</div><!-- [ /#gMenuInner ] -->
</div>
<!-- [ /#gMenu ] -->
<?php } ?>

<?php if (!is_front_page()) { ?>
<div id="pageTitBnr">
<div class="innerBox">
<div id="pageTitInner">
<?php get_template_part('module_pageTit'); ?>
</div><!-- [ /#pageTitInner ] -->
</div>
</div><!-- [ /#pageTitBnr ] -->
<!-- [ #panList ] -->
<div id="panList">
<div id="panListInner" class="innerBox">
<?php get_template_part('module_panList'); ?>
</div>
</div>
<!-- [ /#panList ] -->
<?php } ?>

<?php if (is_front_page() && (biz_vektor_slideExist() || get_header_image()) ) { ?>
<div id="topMainBnr">
<div id="topMainBnrFrame" class="flexslider">
<?php if(biz_vektor_slideExist()) { ?>
	<ul class="slides">
	<?php biz_vektor_slideBody(); ?>
	</ul>
<?php } else { ?>
	<div class="slideFrame"><img src="<?php header_image(); ?>" alt="" /></div>
<?php } ?>
</div>
</div>
<?php } ?>
<div id="main">