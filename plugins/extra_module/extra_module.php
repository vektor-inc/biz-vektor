<?php
/**
 * BizVektor extra_module.php
 *
 * @package BizVektor
 * @version 1.6.0
 */


require( 'adminBarCustom.php' );


add_filter('biz_vektor_is_plugin_extra_module', 'biz_vektor_exm_beacon', 10, 1 );
function biz_vektor_exm_beacon($flag){
	$flag = true;
	return $flag;
}

/*-------------------------------------------*/
/*	Admin page _ page _ customize
/*-------------------------------------------*/
add_post_type_support( 'page', 'excerpt' ); // add excerpt

function biz_vektor_ex_remove_default_page_screen_metaboxes() {
//	remove_meta_box( 'postcustom','page','normal' );		// cutom field
//	remove_meta_box( 'postexcerpt','page','normal' );		// excerpt
	remove_meta_box( 'commentstatusdiv','page','normal' );	// discussion
	remove_meta_box( 'commentsdiv','page','normal' );		// comment
	remove_meta_box( 'trackbacksdiv','page','normal' );		// trackback
//	remove_meta_box( 'authordiv','page','normal' );			// author
//	remove_meta_box( 'slugdiv','page','normal' );			// slug
//	remove_meta_box( 'revisionsdiv','page','normal' );		// revision
 }
add_action('admin_menu','biz_vektor_ex_remove_default_page_screen_metaboxes');

/*-------------------------------------------*/
/*	Admin page _ post _ customize
/*-------------------------------------------*/
function biz_vektor_ex_remove_default_post_screen_metaboxes() {
//	remove_meta_box( 'postcustom','post','normal' );			// cutom field
//	remove_meta_box( 'postexcerpt','post','normal' );			// excerpt
//	remove_meta_box( 'commentstatusdiv','post','normal' );		// comment
//	remove_meta_box( 'trackbacksdiv','post','normal' );			// trackback
//	remove_meta_box( 'slugdiv','post','normal' );				// slug
//	remove_meta_box( 'authordiv','post','normal' );				// author
 }
 add_action('admin_menu','biz_vektor_ex_remove_default_post_screen_metaboxes');

//	Remove WordPress information
remove_action('wp_head', 'wp_generator');

//	Remove prev,next
// remove_action('wp_head','adjacent_posts_rel_link_wp_head',10);

/*------------------------------------------*/
/*	Excerpt _ remove auto mark up to p
/*-------------------------------------------*/
remove_filter('the_excerpt', 'wpautop');


add_action('customize_register', 'biz_vektor_exmodule_remove_customizer_section', 5);
function biz_vektor_exmodule_remove_customizer_section(){
	global $wp_customize;
	// remove section
	$wp_customize->remove_section( 'static_front_page' );	// front page
	$wp_customize->remove_section( 'nav' );
}


/*-------------------------------------------*/
/*	Comment out short code
/*-------------------------------------------*/
/*
If there is a place that you want to hide temporarily in the text field,
[ignore] When enclosing [/ ignore], can be commented out the relevant sections in the html mode.
*/
function ignore_shortcode( $atts, $content = null ) {
	return null;
}
add_shortcode('ignore', 'ignore_shortcode');


add_action('wp_head', 'biz_vektor_exmodule_anti_ie8');
function biz_vektor_exmodule_anti_ie8(){
	global $biz_vektor_theme_styles;

	$options     = biz_vektor_get_theme_options();
	$theme_style = $options['theme_style'];

	if( empty( $biz_vektor_theme_styles[$theme_style] ) ) return;

	$themePathOldIe = $biz_vektor_theme_styles[$theme_style]['cssPathOldIe'];

	if ($themePathOldIe){
		print '<!--[if lte IE 8]>'."\n";
		print '<link rel="stylesheet" type="text/css" media="all" href="'.$themePathOldIe.'" />'."\n";
		print '<![endif]-->'."\n";
	}
}


/*-------------------------------------------*/
/*	Ad insert
/*-------------------------------------------*/

add_filter('the_content', 'biz_vektor_ad_contet_more');
function biz_vektor_ad_contet_more($post_content) {
	if (is_single() && get_post_type() == 'post') :
	// moreタグとすぐ次の</p>まで取得
	$moreTag = '/<span id="more-[0-9]+"><\/span>.*[\/a-z]+>/' ;
	// 広告タグ
	$biz_vektor_options = biz_bektor_option_validate();

	$adTags = apply_filters( 'widget_text', $biz_vektor_options['ad_content_moretag'] );

	preg_match($moreTag, $post_content, $matches);
	$match = (isset($matches[0]))? $matches[0] : '';
	if($match){
		// $matchしている（moreタグが存在する）場合
		if(strpos($match, '</p>') !== false){
			$post_content = preg_replace($moreTag, '</p>'.$adTags, $post_content);
		} else {
			$post_content = preg_replace($moreTag, '</p>'.$adTags.'<p>', $post_content);
		}
	}
	if ($biz_vektor_options['ad_content_after']) 
		$post_content = $post_content.'<div class="sectionBox">'.$biz_vektor_options['ad_content_after'].'</div>';
	endif; // post
	return $post_content;
}

/*-------------------------------------------*/
/*	CSS and Google Web Fonts for Global Version
/*-------------------------------------------*/

function displays_global_css() {
	$biz_vektor_options = biz_vektor_get_theme_options();
	$font = $biz_vektor_options['global_font'];
	
	?>
		<style type="text/css">
	<?php

	//Google Web Fonts import 
	if ( isset( $font ) ) { ?>
		@import url(http://fonts.googleapis.com/css?family=<?php echo $font; ?>:400,700,700italic,300,300italic,400italic);

		body {font-family: '<?php echo str_replace( "+", " ", $font ); ?>', sans-serif;}
	<?php } ?>

		/*-------------------------------------------*/
		/*	default global version style
		/*-------------------------------------------*/
		body { font-size: 1.05em; }
				
		.sideTower .localSection li ul li, 
		#sideTower .localSection li ul li { font-size: 0.9em; }
		</style>
	<?php
}
if ( 'ja' != get_locale() ) {
	add_action( 'wp_head','displays_global_css');	
}


/*-------------------------------------------*/
/*	Excerpt _ remove auto mark up to p
/*-------------------------------------------*/
remove_filter('the_excerpt', 'wpautop');