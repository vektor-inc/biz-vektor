<?php
/*-------------------------------------------*/
/*	Admin page _ page _ customize
/*-------------------------------------------*/
add_post_type_support( 'page', 'excerpt' ); // add excerpt

function remove_default_page_screen_metaboxes() {
//	remove_meta_box( 'postcustom','page','normal' );		// cutom field
//	remove_meta_box( 'postexcerpt','page','normal' );		// excerpt
	remove_meta_box( 'commentstatusdiv','page','normal' );	// discussion
	remove_meta_box( 'commentsdiv','page','normal' );		// comment
	remove_meta_box( 'trackbacksdiv','page','normal' );		// trackback
//	remove_meta_box( 'authordiv','page','normal' );			// author
//	remove_meta_box( 'slugdiv','page','normal' );			// slug
//	remove_meta_box( 'revisionsdiv','page','normal' );		// revision
 }
add_action('admin_menu','remove_default_page_screen_metaboxes');

/*-------------------------------------------*/
/*	Admin page _ post _ customize
/*-------------------------------------------*/
function remove_default_post_screen_metaboxes() {
//	remove_meta_box( 'postcustom','post','normal' );			// cutom field
//	remove_meta_box( 'postexcerpt','post','normal' );			// excerpt
//	remove_meta_box( 'commentstatusdiv','post','normal' );		// comment
//	remove_meta_box( 'trackbacksdiv','post','normal' );			// trackback
//	remove_meta_box( 'slugdiv','post','normal' );				// slug
//	remove_meta_box( 'authordiv','post','normal' );				// author
 }
 add_action('admin_menu','remove_default_post_screen_metaboxes');

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
	// remove section
	$wp_customize->remove_section( 'static_front_page' );	// front page
	$wp_customize->remove_section( 'nav' );
}


require( 'adminBarCustom.php' );

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