<?php
/*-------------------------------------------*/
/*	Set content width
/* 	(Auto set up to media max with.)
/*-------------------------------------------*/
/*	Custom menu
/*-------------------------------------------*/
/*	Widget
/*-------------------------------------------*/
/*	Custom header
/*-------------------------------------------*/
/*	Custom background
/*-------------------------------------------*/
/*	Load theme options
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
/*	Admin page _ Add original admin bar
/*-------------------------------------------*/
/*	Admin page _ Hide youkoso
/*-------------------------------------------*/
/*	Admin page _ Eye catch
/*-------------------------------------------*/
/*	Admin page _ Add custom field of keywords
/*-------------------------------------------*/
/*	Admin page _ page _ customize
/*-------------------------------------------*/
/*	Admin page _ post _ customize
/*-------------------------------------------*/
/*	Custom post type _ add info
/*-------------------------------------------*/
/*	head_description
/*-------------------------------------------*/
/*	head_wp_head clean and add items
/*-------------------------------------------*/
/*	footer_wp_footer clean and add items
/*-------------------------------------------*/
/*	Term list no link
/*-------------------------------------------*/
/*	Global navigation add cptions
/*-------------------------------------------*/
/*	Excerpt _ change ... 
/*-------------------------------------------*/
/*	Excerpt _ remove auto mark up to p
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
/*	Pasing
/*-------------------------------------------*/
/*	Comment out short code
/*-------------------------------------------*/

load_theme_textdomain('biz-vektor');

add_theme_support( 'automatic-feed-links' );

get_template_part('plugins/sns/sns');

/*-------------------------------------------*/
/*	Set content width
/* 	(Auto set up to media max with.)
/*-------------------------------------------*/
if ( ! isset( $content_width ) )
    $content_width = 640;

/*-------------------------------------------*/
/*	Custom menu
/*-------------------------------------------*/
register_nav_menus( array( 'Header' => 'Header Navigation', ) );
register_nav_menus( array( 'FooterNavi' => 'Footer Navigation', ) );
register_nav_menus( array( 'FooterSiteMap' => 'Footer SiteMap', ) );

/*-------------------------------------------*/
/*	Widget
/*-------------------------------------------*/
function biz_vektor_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar(Front page only)', 'biz-vektor' ),
		'id' => 'top-side-widget-area',
		'description' => __( 'This widget area appears on the front page only.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Post content only)', 'biz-vektor' ),
		'id' => 'blog-first-widget-area',
		'description' => __( 'This widget area appears only on the post content pages. It is displayed above the Contact banner.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(All pages - top)', 'biz-vektor' ),
		'id' => 'primary-widget-area',
		'description' => __( 'This widget area appears on all pages in the upper section. It is displayed above the facebook & twitter banners.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(All pages - bottom)', 'biz-vektor' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'This widget area appears on all pages in the upper section. It is displayed below the facebook & twitter banners.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );


}
add_action( 'widgets_init', 'biz_vektor_widgets_init' );


/*-------------------------------------------*/
/*	Custom header
/*-------------------------------------------*/

// Use custom header text
define( 'HEADER_TEXTCOLOR', '' );
// Kill custom header test
define( 'NO_HEADER_TEXT', true );

define('HEADER_IMAGE', '%s/images/headers/bussines_desk_02.jpg');
define('HEADER_IMAGE_WIDTH', 950);
define('HEADER_IMAGE_HEIGHT', 250);
register_default_headers( array(
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
add_theme_support( 'custom-header' );
if ( ! function_exists( 'admin_header_style' ) ) :
function admin_header_style() { }
endif;



/*-------------------------------------------*/
/*	Custom background
/*-------------------------------------------*/

function biz_vektor_setup(){
	add_theme_support( 'custom-background', array(
		'default-color' => 'f5f5f5',
	) );
}
add_action( 'after_setup_theme', 'biz_vektor_setup' );


/*-------------------------------------------*/
/*	Load theme options
/*-------------------------------------------*/
	require( dirname( __FILE__ ) . '/inc/theme-options.php' );

/*-------------------------------------------*/
/*	Load Setting of Default / Calmly
/*-------------------------------------------*/
	require( dirname( __FILE__ ) . '/bizvektor_themes/001/001_custom.php' );
	require( dirname( __FILE__ ) . '/bizvektor_themes/002/002_custom.php' );

/*-------------------------------------------*/
/*	Load Theme customizer
/*-------------------------------------------*/
	require( dirname( __FILE__ ) . '/inc/theme-customizer.php' );

/*-------------------------------------------*/
/*	Admin admin_bar_custom
/*-------------------------------------------*/
	get_template_part('module_adminBarCustom');

/*-------------------------------------------*/
/*	Admin page _ Add style
/*-------------------------------------------*/
function bizVektor_admin_css(){
	// echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/style_BizVektor_admin.css" />';
	$adminCssPath = get_template_directory_uri().'/style_bizvektor_admin.css';
	wp_enqueue_style( 'theme', $adminCssPath , false, '2014-01-03');
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
add_editor_style('editor-style.css');

/*-------------------------------------------*/
/*	Admin page _ Add original admin bar
/*-------------------------------------------*/
// function original_header_menu_output() {
// 	get_template_part('module_adminHeader');
// }
// add_action('admin_notices','original_header_menu_output');

/*-------------------------------------------*/
/*	Admin page _ Hide youkoso
/*-------------------------------------------*/
function hide_welcome_panel() {
	$user_id = get_current_user_id();
		if ( 1 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
	update_user_meta( $user_id, 'show_welcome_panel', 0 );
}
add_action( 'load-index.php', 'hide_welcome_panel' );

/*-------------------------------------------*/
/*	Admin page _ Eye catch
/*-------------------------------------------*/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 200, 200, true );

/*-------------------------------------------*/
/*	Admin page _ Add custom field of keywords
/*-------------------------------------------*/
add_action('admin_menu', 'add_custom_field_metaKeyword');
add_action('save_post', 'save_custom_field_metaKeyword');

function add_custom_field_metaKeyword(){
  if(function_exists('add_custom_field_metaKeyword')){
    add_meta_box('div1', __('Meta Keywords', 'biz-vektor'), 'insert_custom_field_metaKeyword', 'page', 'normal', 'high');
    add_meta_box('div1', __('Meta Keywords', 'biz-vektor'), 'insert_custom_field_metaKeyword', 'post', 'normal', 'high');
    add_meta_box('div1', __('Meta Keywords', 'biz-vektor'), 'insert_custom_field_metaKeyword', 'info', 'normal', 'high');
  }
}

function insert_custom_field_metaKeyword(){
  global $post;
  echo '<input type="hidden" name="noncename_custom_field_metaKeyword" id="noncename_custom_field_metaKeyword" value="'.wp_create_nonce(plugin_basename(__FILE__)).'" />';
  echo '<label class="hidden" for="metaKeyword">'.__('Meta Keywords', 'biz-vektor').'</label><input type="text" name="metaKeyword" size="50" value="'.get_post_meta($post->ID, 'metaKeyword', true).'" />';
  echo '<p>'.__('To distinguish between individual keywords, please enter a , delimiter (optional).', 'biz-vektor').'<br />';
  $theme_option_seo_link = '<a href="'.get_admin_url().'/themes.php?page=theme_options#seoSetting" target="_blank">'._x('','link to seo setting', 'biz-vektor').'</a>';
  sprintf(__('* keywords common to the entire site can be set from %s.', 'biz-vektor'),$theme_option_seo_link);
  echo '</p>';
}

function save_custom_field_metaKeyword($post_id){
  if(!wp_verify_nonce($_POST['noncename_custom_field_metaKeyword'], plugin_basename(__FILE__))){
    return $post_id;
  }
  if('page' == $_POST['post_type']){
    if(!current_user_can('edit_page', $post_id)) return $post_id;
  }else{
    if(!current_user_can('edit_post', $post_id)) return $post_id;
  }

  $data = $_POST['metaKeyword'];

  if(get_post_meta($post_id, 'metaKeyword') == ""){
    add_post_meta($post_id, 'metaKeyword', $data, true);
  }elseif($data != get_post_meta($post_id, 'metaKeyword', true)){
    update_post_meta($post_id, 'metaKeyword', $data);
  }elseif($data == ""){
    delete_post_meta($post_id, 'metaKeyword', get_post_meta($post_id, 'metaKeyword', true));
  }
}

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

/*-------------------------------------------*/
/*	Custom post type _ add info
/*-------------------------------------------*/
add_action( 'init', 'create_post_type', 0 );
function create_post_type() {
	$infoLabelName = esc_html( bizVektorOptions('infoLabelName'));
	register_post_type( 'info', /* post-type */
	array(
		'labels' => array(
		'name' => $infoLabelName,
		'singular_name' => $infoLabelName
	),
	'public' => true,
	'menu_position' =>5,
	'has_archive' => true,
	'supports' => array('title','editor','excerpt','thumbnail','author')
	)
	);
	// Add information category
	register_taxonomy(
		'info-cat',
		'info',
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => $infoLabelName._x('category','admin menu', 'biz-vektor'),
			'singular_label' => $infoLabelName._x('category','admin menu', 'biz-vektor'),
			'public' => true,
			'show_ui' => true,
		)
	);
	}

add_action( 'generate_rewrite_rules', 'my_rewrite' );
function my_rewrite( $wp_rewrite ){
    $taxonomies = get_taxonomies();
    $taxonomies = array_slice($taxonomies,4,count($taxonomies)-1);
    foreach ( $taxonomies as $taxonomy ) :
         $post_types = get_taxonomy($taxonomy)->object_type;

        foreach ($post_types as $post_type){
            $new_rules[$post_type.'/'.$taxonomy.'/(.+?)/?$'] = 'index.php?taxonomy='.$taxonomy.'&term='.$wp_rewrite->preg_index(1);
        }
         $wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);
     endforeach;
}

/*		Archive of custom post type
/*-------------------------------------------*/
global $my_archives_post_type;
add_filter( 'getarchives_where', 'my_getarchives_where', 10, 2 );
function my_getarchives_where( $where, $r ) {
  global $my_archives_post_type;
  if ( isset($r['post_type']) ) {
    $my_archives_post_type = $r['post_type'];
    $where = str_replace( '\'post\'', '\'' . $r['post_type'] . '\'', $where );
  } else {
    $my_archives_post_type = '';
  }
  return $where;
}
add_filter( 'get_archives_link', 'my_get_archives_link' );
function my_get_archives_link($link_html) {
    global $my_archives_post_type;
    if ($my_archives_post_type != '') {
        $add_link = '?post_type=' . $my_archives_post_type;
        $link_html = preg_replace("/href=\'(.+)\'/", "href='$1" . $add_link. "'", $link_html);
    }
    return $link_html;
}
/*-------------------------------------------*/
/*	head_description
/*-------------------------------------------*/
function getHeadDescription() {
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_page('home') || is_front_page()) {
		$metaExcerpt = $post->post_excerpt;
		if ( $metaExcerpt ) {
			$metadescription = $metaExcerpt;
		} else {
			$metadescription = get_bloginfo( 'description' );
		}
	} else if (is_category() || is_tax()) {
		$metadescription = $post->category_description;
		if ( ! $metadescription ) {
			$metadescription = sprintf(__('About %s', 'biz-vektor'),single_cat_title()).get_bloginfo('name').' '.get_bloginfo('description');
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
	$metadescription = apply_filters( 'metadescriptionCustom', $metadescription );
    echo $metadescription;
}

/*-------------------------------------------*/
/*	head_wp_head clean and add items
/*-------------------------------------------*/

//	Remove WordPress information
remove_action('wp_head', 'wp_generator');

//	Remove prev,next
// remove_action('wp_head','adjacent_posts_rel_link_wp_head',10);

// Add Google Web Fonts
add_action('wp_head','bizVektorAddWebFonts');
function bizVektorAddWebFonts(){
	$webFonts = '<link href="http://fonts.googleapis.com/css?family=Droid+Sans:700|Lato:900|Anton" rel="stylesheet" type="text/css" />'."\n";
	$webFonts = apply_filters('webFontsCustom', $webFonts );
	echo $webFonts;
}

// Add BizVektor option css
add_action('wp_head','bizVektorAddOptionStyle');
function bizVektorAddOptionStyle(){
	$optionStyle = '<link rel="stylesheet" id="bizvektor-option-css"  href="'.get_template_directory_uri().'/css/style_bizvektor_options.css" type="text/css" media="all" />'."\n";
	$optionStyle = apply_filters('optionStyleCustom', $optionStyle );
	echo $optionStyle;
}

// add pingback
add_action('wp_head','bizVektorAddPingback');
function bizVektorAddPingback(){
	$pingback = '<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'."\n";
	$pingback = apply_filters('pingbackCustom', $pingback );
	echo $pingback;
}

// add js
add_action('wp_head','bizVektorAddHeadJs');
function bizVektorAddHeadJs(){
	if (is_front_page()) {
	if (biz_vektor_slideExist()) {
		echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/js/FlexSlider/flexslider.css" type="text/css">';
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'flexSlider' , get_template_directory_uri().'/js/FlexSlider/jquery.flexslider.js', array('jquery'), '20120609');
		wp_enqueue_script( 'flexSlider' );
	}
	}
}

/*-------------------------------------------*/
/*	footer_wp_footer clean and add items
/*-------------------------------------------*/
add_action('wp_footer','bizVektorAddJsScripts');
function bizVektorAddJsScripts(){
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/js/res-vektor/res-vektor.css" type="text/css">';
	wp_register_script( 'masterjs' , get_template_directory_uri().'/js/master.js', array('jquery'), '20130708' );
	wp_enqueue_script( 'masterjs' );
}

add_action( 'wp_enqueue_scripts', 'add_ResVektor' );
function add_ResVektor() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'res-vektor-js' , get_template_directory_uri().'/js/res-vektor/res-vektor.js', array('jquery'), '20131228' );
	wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() . '/js/res-vektor/jquery.cookie.js', array( 'jquery' ), true );
}
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
    function start_el(&$output, $item, $depth, $args) {
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
/*	Excerpt _ remove auto mark up to p
/*-------------------------------------------*/
remove_filter('the_excerpt', 'wpautop');

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
/*	Pasing
/*-------------------------------------------*/
function pagination($pages = '', $range = 1) {
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages) {
             $pages = 1;
         }
     }

     if(1 != $pages) {
         echo "<div class=\"paging\"><span class=\"pageIndex\">Page ".$paged." / ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++) {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
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