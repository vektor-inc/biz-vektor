<?php

$theme_opt = wp_get_theme('biz-vektor');
define('BizVektor_Theme_Version', preg_replace('/^Version[ :;]*(\d+\.\d+\.\d+.*)$/i', '$1', $theme_opt->Version));

/*-------------------------------------------*/
/*	Theme setup
/*-------------------------------------------*/
/*	Set content width
/* 	(Auto set up to media max with.)
/*-------------------------------------------*/
/*	WidgetArea initiate
/*-------------------------------------------*/
/*	WidgetArea maincontent setting
/*-------------------------------------------*/
/*	Custom header
/*-------------------------------------------*/
/*	Load theme options
/*-------------------------------------------*/
/*	Load Advanced Settings (advanced theme options)
/*-------------------------------------------*/
/*	Load Setting of Default / Calmly
/*-------------------------------------------*/
/*	Load Theme customizer
/*-------------------------------------------*/
/*	Admin page _ Add style
/*-------------------------------------------*/
/*	Admin page _ Add post status to body class
/*-------------------------------------------*/
/*	Admin page _ Add editor css
/*-------------------------------------------*/
/*	head_description
/*-------------------------------------------*/
/*	wp_head add items
/*-------------------------------------------*/
/*	Term list no link
/*-------------------------------------------*/
/*	Global navigation add cptions
/*-------------------------------------------*/
/*	Excerpt _ change ... 
/*-------------------------------------------*/
/*	Year Artchive list 'year' insert to inner </a>
/*-------------------------------------------*/
/*	Category list 'count insert to inner </a>
/*-------------------------------------------*/
/*	Block to delete iframe tag from TinyMCE
/*-------------------------------------------*/
/*	Comment
/*-------------------------------------------*/
/*	Archive page link ( don't erase )
/*-------------------------------------------*/
/*	Paging
/*-------------------------------------------*/
/*	Page _ Child page lists
/*-------------------------------------------*/
/*	HomePage _ add action filters
/*-------------------------------------------*/
/*	Archive _ loop custom filters
/*-------------------------------------------*/
/*	Aceept favicon upload
/*-------------------------------------------*/



get_template_part('plugins/plugins');


function biz_vektor_is_plugin_enable($plugin_name){
	return apply_filters( 'biz_vektor_is_plugin_'. $plugin_name, false );
}

function biz_vektor_wp_css(){
	echo '<link rel="stylesheet" href="'.get_stylesheet_uri().'" type="text/css" media="all" />'."\n";
//	wp_enqueue_style('Biz_Vektor_style', get_stylesheet_uri(), array(), false);
}
add_action('wp_head', 'biz_vektor_wp_css', 190);

/*-------------------------------------------*/
/*	Theme setup
/*-------------------------------------------*/
add_action('after_setup_theme', 'biz_vektor_theme_setup');

function biz_vektor_theme_setup() {
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-header' );

	add_theme_support( 'custom-background', array(
		'default-color' => '#ffffff',
	) );

	/*-------------------------------------------*/
	/*	Admin page _ Eye catch
	/*-------------------------------------------*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 200, 200, true );

	/*-------------------------------------------*/
	/*	Custom menu
	/*-------------------------------------------*/
	register_nav_menus( array( 'Header' => 'Header Navigation', ) );
	register_nav_menus( array( 'FooterNavi' => 'Footer Navigation', ) );
	register_nav_menus( array( 'FooterSiteMap' => 'Footer SiteMap', ) );

	load_theme_textdomain('biz-vektor', get_template_directory() . '/languages');
}

/*-------------------------------------------*/
/*	Set content width
/* 	(Auto set up to media max with.)
/*-------------------------------------------*/
if ( ! isset( $content_width ) )
	$content_width = 640;

/*-------------------------------------------*/
/*	WidgetArea initiate
/*-------------------------------------------*/
function biz_vektor_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar(Front page only)', 'biz-vektor' ),
		'id' => 'top-side-widget-area',
		'description' => __( 'This widget area appears on the front page only.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Post content only)', 'biz-vektor' ),
		'id' => 'post-widget-area',
		'description' => __( 'This widget area appears only on the post content pages.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Page content only)', 'biz-vektor' ),
		'id' => 'page-widget-area',
		'description' => __( 'This widget area appears only on the page content pages.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Common top)', 'biz-vektor' ),
		'id' => 'common-side-top-widget-area',
		'description' => __( 'This widget area appears at top of sidebar.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Common bottom)', 'biz-vektor' ),
		'id' => 'common-side-bottom-widget-area',
		'description' => __( 'This widget area appears at bottom of sidebar.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'biz_vektor_widgets_init' );

/*-------------------------------------------*/
/*	WidgetArea maincontent setting
/*-------------------------------------------*/
add_filter('biz_vektor_is_plugin_widgets', 'biz_vektor_widget_beacon', 10, 1 );
function biz_vektor_widget_beacon($flag){
	$flag = true;
	return $flag;
}

function biz_vektor_maincontent_widgetarea_init() {
	register_sidebar( array(
		'name' => __( 'Main content(Homepage)', 'biz-vektor' ),
		'id' => 'top-main-widget-area',
		'description' => __( 'This widget area appears on the front page main content area only.', 'biz-vektor' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'biz_vektor_maincontent_widgetarea_init' );

add_filter('biz_vektor_extra_main_content', 'biz_vektor_widget_extra_content', 512, 1);
function biz_vektor_widget_extra_content($flag){
	if ( !$flag && is_active_sidebar( 'top-main-widget-area' ) ) {
	 	dynamic_sidebar( 'top-main-widget-area' );
		$flag = true;
	}
	return $flag;
}

/*-------------------------------------------*/
/*	Custom header
/*-------------------------------------------*/

// Use custom header text
define( 'HEADER_TEXTCOLOR', '' );
// Kill custom header test
define( 'NO_HEADER_TEXT', true );

define('HEADER_IMAGE', '%s/images/headers/accelerate.jpg');
define('HEADER_IMAGE_WIDTH', 950);
define('HEADER_IMAGE_HEIGHT', 250);
register_default_headers( array(
	'accelerate' => array(
		'url' => '%s/images/headers/accelerate.jpg',
		'thumbnail_url' => '%s/images/headers/accelerate-thumbnail.jpg',
		'description' => 'Accelerate your business'
	),
	'bussines_desk_02' => array(
		'url' => '%s/images/headers/bussines_desk_02.jpg',
		'thumbnail_url' => '%s/images/headers/bussines_desk_02-thumbnail.jpg',
		'description' => 'Bussines desk01'
	),
	'bussines_desk_01' => array(
		'url' => '%s/images/headers/bussines_desk_01.jpg',
		'thumbnail_url' => '%s/images/headers/bussines_desk_01-thumbnail.jpg',
		'description' => 'Bussines desk01'
	),
	'autumn-leaves' => array(
		'url' => '%s/images/headers/autumn-leaves.jpg',
		'thumbnail_url' => '%s/images/headers/autumn-leaves-thumbnail.jpg',
		'description' => 'autumn-leaves'
	),
	'johnny_01' => array(
		'url' => '%s/images/headers/johnny_01.jpg',
		'thumbnail_url' => '%s/images/headers/johnny_01-thumbnail.jpg',
		'description' => 'Johnny'
	),
) );


/*-------------------------------------------*/
/*	Load theme options
/*-------------------------------------------*/
	require( get_template_directory() . '/inc/theme-options.php' );
	require( get_template_directory() . '/inc/theme-options-init.php' );


/*-------------------------------------------*/
/*	Load Advanced Settings (advanced theme options)
/*-------------------------------------------*/
	require( get_template_directory() . '/inc/theme-ad-options.php' );	

/*-------------------------------------------*/
/*	Load Setting of Default / Calmly
/*-------------------------------------------*/
	require( get_template_directory() . '/design_skins/001/001_custom.php' );
	require( get_template_directory() . '/design_skins/002/002_custom.php' );
	require( get_template_directory() . '/design_skins/003/003_custom.php' );

/*-------------------------------------------*/
/*	Load Theme customizer
/*-------------------------------------------*/
	require( get_template_directory() . '/inc/theme-customizer.php' );


/*-------------------------------------------*/
/*	Admin page _ Add style
/*-------------------------------------------*/
function bizVektor_admin_css(){
	// enqueue の場合あとで読み込まれてしまうため
	echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/style_bizvektor_admin.css" />';
	// $adminCssPath = get_template_directory_uri().'/css/style_bizvektor_admin.css';
	// wp_enqueue_style( 'theme', $adminCssPath , false, '2014-08-20');
}
add_action('admin_head', 'bizVektor_admin_css', 11);

/*-------------------------------------------*/
/*	Admin page _ Add post status to body class
/*-------------------------------------------*/
function bizVektor_postStatus(){
		$classes = get_post_status(); ?>
		<script type="text/javascript" charset="utf-8">
		function postStatusColor(){
			// Get class and add post status.
			var newClass = document.getElementsByTagName("body")[0].className + " <?php echo $classes ?>";
			// Replace the class name of the current situation
			document.getElementsByTagName("body")[0].setAttribute("class",newClass);
		}
		window.onload = postStatusColor;
		</script>
<?php
}
add_action('admin_head-post.php', 'bizVektor_postStatus', 12);
add_action('admin_head-post-new.php', 'bizVektor_postStatus', 12);

/*-------------------------------------------*/
/*	Admin page _ Add editor css
/*-------------------------------------------*/
add_editor_style('/css/editor-style.css');

/*-------------------------------------------*/
/*	head_description
/*-------------------------------------------*/
function getHeadDescription() {
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_front_page() ) {
		if ( isset($post->post_excerpt) && $post->post_excerpt ) {
			$metadescription = get_the_excerpt();
		} else {
			$metadescription = get_bloginfo( 'description' );
		}
	} else if (is_category() || is_tax()) {
		if ( ! $post->description ) {
			$metadescription = sprintf(__('About %s', 'biz-vektor'),single_cat_title()).get_bloginfo('name').' '.get_bloginfo('description');
		} else {
			$metadescription = esc_html( $post->description );
		}
	} else if (is_tag()) {
		$metadescription = strip_tags(tag_description());
		$metadescription = str_replace(array("\r\n","\r","\n"), '', $metadescription);  // delete br
		if ( ! $metadescription ) {
			$metadescription = sprintf(__('About %s', 'biz-vektor'),single_tag_title()).get_bloginfo('name').' '.get_bloginfo('description');
		}
	} else if (is_archive()) {
		if (is_year()){
			$description_date = get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) );
			$metadescription = sprintf(_x('Article of %s.','Yearly archive description', 'biz-vektor'), $description_date );
			$metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
		} else if (is_month()){
			$description_date = get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) );
			$metadescription = sprintf(_x('Article of %s.','Archive description', 'biz-vektor'),$description_date );
			$metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
		} else if (is_author()) {
			$userObj = get_queried_object();
			$metadescription = sprintf(_x('Article of %s.','Archive description', 'biz-vektor'),esc_html($userObj->display_name) );
			$metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
		} else {
			$postType = get_post_type();
			$metadescription = sprintf(_x('Article of %s.','Archive description', 'biz-vektor'),esc_html(get_post_type_object($postType)->labels->name) );
			$metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
		}
	} else if (is_page() || is_single()) {
		$metaExcerpt = $post->post_excerpt;
		if ($metaExcerpt) {
			// $metadescription = strip_tags($post->post_excerpt);
			$metadescription = strip_tags($post->post_excerpt);
		} else {
			$metadescription = mb_substr( strip_tags($post->post_content), 0, 240 ); // kill tags and trim 240 chara
			$metadescription = str_replace(array("\r\n","\r","\n"), ' ', $metadescription);  // delete br
		}
	} else {
		$metadescription = get_bloginfo('description');
	}
	global $paged;
	if ( $paged != '0'){
		$metadescription = '['.sprintf(__('Page of %s', 'biz-vektor' ),$paged).'] '.$metadescription;
	}
	$metadescription = apply_filters( 'metadescriptionCustom', $metadescription );
	echo $metadescription;
}

/*-------------------------------------------*/
/*	wp_head add items
/*-------------------------------------------*/

// Add Font Awesome
add_action('wp_enqueue_scripts','bizVektorAddFontAwesome');
function bizVektorAddFontAwesome(){
	wp_enqueue_style('Biz_Vektor_add_font_awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", array(), false, 'all');
}

// Add Google Web Fonts
add_action('wp_enqueue_scripts','bizVektorAddWebFonts');
function bizVektorAddWebFonts(){
	wp_enqueue_style('Biz_Vektor_add_web_fonts', "http://fonts.googleapis.com/css?family=Droid+Sans:700|Lato:900|Anton", array(), false, 'all');
}

// Add BizVektor option css
add_action('wp_enqueue_scripts', 'bizVektorSetCommonStyle');
function bizVektorSetCommonStyle(){
	wp_enqueue_style('Biz_Vektor_common_style', get_template_directory_uri().'/css/bizvektor_common_min.css', array(), '20141106', 'all');
}

// add pingback
add_action('wp_head','bizVektorAddPingback');
function bizVektorAddPingback(){
	$pingback = '<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'."\n";
	$pingback = apply_filters('pingbackCustom', $pingback );
	echo $pingback;
}

//html5 shiv
add_action( 'wp_enqueue_scripts', 'biz_vektor_load_scripts_html5shiv' );

if ( ! function_exists( 'biz_vektor_load_scripts_html5shiv' ) ) {
	function biz_vektor_load_scripts_html5shiv() {
		wp_enqueue_script( 'html5shiv', '//html5shiv.googlecode.com/svn/trunk/html5.js', array(), null );
	}
}

add_action('wp_head','bizVektorAddJsScripts');
function bizVektorAddJsScripts(){
	wp_register_script( 'biz-vektor-min-js' , get_template_directory_uri().'/js/biz-vektor-min.js', array('jquery'), '20140820' );
	wp_enqueue_script( 'biz-vektor-min-js' );
}
function add_defer_to_bizVektor_js( $url )
{
	if ( FALSE === strpos( $url, 'biz-vektor/js' ) or FALSE === strpos( $url, '.js' ) )
	{ // not our file
		return $url;
	}
	// Must be a ', not "!
	return "$url' defer='defer";
}
add_filter( 'clean_url', 'add_defer_to_bizVektor_js', 11, 1 );

/*-------------------------------------------*/
/*	Term list no link
/*-------------------------------------------*/
function get_the_term_list_nolink( $id = 0, $taxonomy, $before = '', $sep = '', $after = '' ) {
	$terms = get_the_terms( $id, $taxonomy );
	if ( is_wp_error( $terms ) )
		return $terms;
	if ( empty( $terms ) )
		return false;
	foreach ( $terms as $term ) {
		$term_names[] =  $term->name ;
	}
	return $before . join( $sep, $term_names ) . $after;
}

/*-------------------------------------------*/
/*	Global navigation add cptions
/*-------------------------------------------*/
class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$prepend = '<strong>';
		$append = '</strong>';
		$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

		if($depth != 0) {
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
/*-------------------------------------------*/
/*	Excerpt _ change ... 
/*-------------------------------------------*/
function change_excerpt_more($post) {
	return ' ...';
}
add_filter('excerpt_more', 'change_excerpt_more');

/*-------------------------------------------*/
/*	Year Artchive list 'year' insert to inner </a>
/*-------------------------------------------*/
function my_archives_link($html){
  return preg_replace('@</a>(.+?)</li>@', '\1</a></li>', $html);
}
add_filter('get_archives_link', 'my_archives_link');

/*-------------------------------------------*/
/*	Category list 'count insert to inner </a>
/*-------------------------------------------*/
function my_list_categories( $output, $args ) {
	$output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
	return $output;
}
add_filter( 'wp_list_categories', 'my_list_categories', 10, 2 );


/*-------------------------------------------*/
/*	Block to delete iframe tag from TinyMCE
/*-------------------------------------------*/
function add_iframe($initArray) {
$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
return $initArray;
}
add_filter('tiny_mce_before_init', 'add_iframe');

/*-------------------------------------------*/
/*	Comment
/*-------------------------------------------*/
if ( ! function_exists( 'biz_vektor_comment' ) ) :
function biz_vektor_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="commentBox">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf(sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e('Your comment is awaiting approval.', 'biz-vektor'); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
		<?php printf( '%1$s at %2$s', get_comment_date(),  get_comment_time() ); ?> <?php edit_comment_link( 'Edit', '<span class="edit-link">(', ')</span>' ); ?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>
		<div class="linkBtn linkBtnS">
		<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('Reply', 'biz-vektor'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p>Pingback: <?php comment_author_link(); ?> <?php edit_comment_link( __('Edit', 'biz-vektor'), '<span class="edit-link">(', ')</span>' ); ?>
	<?php
			break;
	endswitch;
}
endif;

/*-------------------------------------------*/
/*	Archive page link ( don't erase )
/*-------------------------------------------*/
function biz_vektor_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="<?php echo $nav_id; ?>">
			<h4 class="assistive-text"><?php _e('Navigation', 'biz-vektor'); ?></h4>
			<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older post', 'biz-vektor')); ?></div>
			<div class="nav-next"><?php previous_posts_link(__('New post <span class="meta-nav">&rarr;</span>', 'biz-vektor')); ?></div>
		</div><!-- #nav -->
	<?php endif;
	wp_reset_query();
}

/*-------------------------------------------*/
/*	Paging
/*-------------------------------------------*/
function pagination($max_num_pages = '', $range = 1) {
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($max_num_pages == '') {
		global $wp_query;
		// 最後のページ
		$max_num_pages = $wp_query->max_num_pages;
		if(!$max_num_pages) {
			 $max_num_pages = 1;
		}
	}

	if(1 != $max_num_pages) {
		echo '<div class="paging">'."\n";

		// Prevリンク
		// 現在のページが２ページ目以降の場合
		if ($paged > 1) echo '<a class="prev_link" href="'.get_pagenum_link($paged - 1).'">&laquo;</a>'."\n";

		// 今のページからレンジを引いて2以上ある場合 && 最大表示アイテム数より最第ページ数が大きい場合
		// （レンジ数のすぐ次の場合は表示する）
		// 1...３４５
		if ( $paged-$range >= 2 && $max_num_pages > $showitems ) echo '<a href="'.get_pagenum_link(1).'">1</a>'."\n";
		// 今のページからレンジを引いて3以上ある場合 && 最大表示アイテム数より最第ページ数が大きい場合
		if ( $paged-$range >= 3 && $max_num_pages > $showitems ) echo '<span class="txt_hellip">&hellip;</span>'."\n";

		// レンジより前に追加する数
		$addPrevCount = $paged+$range-$max_num_pages;
		// レンジより後に追加する数
		$addNextCount = -($paged-1-$range); // 今のページ数を遡ってカウントするために-1
		// アイテムループ
		for ($i=1; $i <= $max_num_pages; $i++) {
			// 表示するアイテム
			if ($paged == $i) {
				$pageItem = '<span class="current">'.$i.'</span>'."\n";
			} else {
				$pageItem = '<a href="'.get_pagenum_link($i).'" class="inactive">'.$i.'</a>'."\n";
			}

			// 今のページからレンジを引いた数～今のページからレンジを足した数まで || 最大ページ数が最大表示アイテム数以下の場合
			if ( ( $paged-$range <= $i && $i<= $paged+$range ) || $max_num_pages <= $showitems ) {
				echo $pageItem;
				// 今のページからレンジを引くと負数になる場合 && 今のページ+レンジ+負数をレンジに加算した数まで
			} else if ( $paged-1-$range < 0 && $paged+$range+$addNextCount >= $i ) {
				echo $pageItem;
			// 今のページからレンジを足すと　最後のページよりも大きくなる場合 && 今のページ+レンジ+負数をレンジに加算した数まで
			} else if ( $paged+$range > $max_num_pages && $paged-$range-$addPrevCount <= $i ) {
				echo $pageItem;
			}
		}

		// 現在のページにレンジを足しても最後のページ数より２以上小さい時 && 最大表示アイテム数より最第ページ数が大きい場合
		if ( $paged+$range <= $max_num_pages-2 && $max_num_pages > $showitems ) echo '<span class="txt_hellip">&hellip;</span>'."\n";
		if ( $paged+$range <= $max_num_pages-1 && $max_num_pages > $showitems ) echo '<a href="'.get_pagenum_link($max_num_pages).'">'.$max_num_pages.'</a>'."\n";
		// Nextリンク
		if ($paged < $max_num_pages) echo '<a class="next_link" href="'.get_pagenum_link($paged + 1).'">&raquo;</a>'."\n";
		echo "</div>\n";
	 }
}

/*-------------------------------------------*/
/*	Page _ Child page lists
/*-------------------------------------------*/
function biz_vektor_childPageList(){
	global $post;
	if (is_page()) {
		if($post->ancestors){
				foreach($post->ancestors as $post_anc_id){
					$post_id = $post_anc_id;
				}
			} else {
				$post_id = $post->ID;
			}
			if ($post_id) {
				$children = wp_list_pages("title_li=&child_of=".$post_id."&echo=0");
				if ($children) { ?>
				<div class="localSection sideWidget pageListSection">
				<h3 class="localHead"><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h3>
				<ul class="localNavi">
				<?php echo $children; ?>
				</ul>
				</div>

		<?php }
		}
	} // is_page
}

/*-------------------------------------------*/
/*	HomePage _ add action filters
/*-------------------------------------------*/
function biz_vektor_contentMain_before(){
	do_action('biz_vektor_contentMain_before');
}
function biz_vektor_contentMain_after(){
	do_action('biz_vektor_contentMain_after');
}
function biz_vektor_sideTower_after(){
	do_action('biz_vektor_sideTower_after');
}
/*-------------------------------------------*/
/*	Archive _ loop custom filters
/*-------------------------------------------*/
function biz_vektor_archive_loop(){
	do_action('biz_vektor_archive_loop');
}
function is_biz_vektor_archive_loop(){
	return apply_filters('is_biz_vektor_archive_loop', false);
}
function is_biz_vektor_extra_single(){
	return apply_filters('is_biz_vektor_single_loop', false);
}
function biz_vektor_extra_single(){
	do_action('biz_vektor_extra_single');
}

/*-------------------------------------------*/
/*	Aceept favicon upload
/*-------------------------------------------*/
function my_mime_type($a) {
    $a['ico'] = 'image/x-icon';
    return $a;
}
add_filter('upload_mimes', 'my_mime_type');

add_action('wp_enqueue_scripts','biz_vektor_comment_reply');
function biz_vektor_comment_reply(){
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}


function biz_vektor_get_short_name(){
	$lab = get_biz_vektor_name();
	if($lab == 'BizVektor'){
		$lab = 'BV';
	}

	return $lab;
}