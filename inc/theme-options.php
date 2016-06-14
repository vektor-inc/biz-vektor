<?php
/*-------------------------------------------*/
/*	テーマオプションのメニューとページを設定
/*-------------------------------------------*/
/*	テーマオプションの編集権限設定
/*-------------------------------------------*/
/*	テーマオプションの編集画面の読み込み
/*-------------------------------------------*/
/*	Create title
/*-------------------------------------------*/
/*	layout
/*-------------------------------------------*/
/*	Add layout class to body tag
/*-------------------------------------------*/
/*	Add to the body tag class to turn off the side bar
/*-------------------------------------------*/
/*	Theme style
/*-------------------------------------------*/
/*	Favicon
/*-------------------------------------------*/
/*	Menu divide
/*-------------------------------------------*/
/*	Header logo
/*-------------------------------------------*/
/*	Header contact info (TEL & Time)
/*-------------------------------------------*/
/*	Home page _ blogList（RSS）
/*-------------------------------------------*/
/*	mainfoot _ contact
/*-------------------------------------------*/
/*	Create keywords
/*-------------------------------------------*/
/*	footer
/*-------------------------------------------*/
/*	slide show
/*-------------------------------------------*/
/*	Print theme_options js
/*-------------------------------------------*/
/*	Change fonts
/*-------------------------------------------*/
/*	Side menu hidden
/*-------------------------------------------*/
/*	Contact Btn
/*-------------------------------------------*/
/*	Updata
/*-------------------------------------------*/
/* CSS and Google Web Fonts for Global Version
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	テーマオプションのメニューとページを設定
/*-------------------------------------------*/
function biz_vektor_theme_options_add_page() {
	$theme_page = add_theme_page(
		__('Theme Options', 'biz-vektor'),   					// Name of page
		__('Theme Options', 'biz-vektor'),   					// Label in menu
		'edit_theme_options',				// Capability required
		'theme_options',					// Menu slug, used to uniquely identify the page
		'biz_vektor_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;
/* help
	$help = '<p></p>' .
			'<p></p>';
	add_contextual_help( $theme_page, $help );
*/
}
add_action( 'admin_menu', 'biz_vektor_theme_options_add_page' );

/*-------------------------------------------*/
/*	テーマオプションの編集権限設定
/*-------------------------------------------*/
function biz_vektor_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_biz_vektor_options', 'biz_vektor_option_page_capability' );

/*-------------------------------------------*/
/*	テーマオプションの編集画面の読み込み
/*-------------------------------------------*/

get_template_part('inc/theme-options-edit');

/*-------------------------------------------*/
/*	Create title
/*-------------------------------------------*/
function getHeadTitle() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_front_page()) {
		if (isset($options['topTitle']) && $options['topTitle'])	{
			$headTitle = $options['topTitle'];
		} else {
			$headTitle = get_bloginfo('name');
		}
	} else if (is_home()) {
		if (isset($options['postLabelName']) && $options['postLabelName'])	{
			$headTitle = $options['postLabelName']." | ".get_bloginfo('name');
		} else {
			$headTitle = get_bloginfo('name');
		}
	// Author
	} else if (is_author()) {
		$userObj = get_queried_object();
		$headTitle = esc_html($userObj->display_name)." | ".get_bloginfo('name');
	// Page
	} else if (is_page()) {
		// Sub Pages
		if ( $post->post_parent ) {
			if($post->ancestors){
				foreach($post->ancestors as $post_anc_id){
					$post_id = $post_anc_id;
				}
			} else {
				$post_id = $post->ID;
			}
			$headTitle = get_the_title()." | ".get_the_title($post_id)." | ".get_bloginfo('name');
		// Not Sub Pages
		} else {
			$headTitle = get_the_title()." | ".get_bloginfo('name');
		}
	// Info
	} else if (get_post_type() === 'info') {
		// Single
		if (is_single()) {
			$taxo_catelist = get_the_term_list_nolink( $post->ID, 'info-cat', '', ',', '' );
			if (!empty($taxo_catelist)) :
				$headTitle = get_the_title()." | ".$taxo_catelist." | ".get_bloginfo('name');
			else :
				$headTitle = get_the_title()." | ".get_bloginfo('name');
			endif;
		// Info category
		} else if (is_tax()){
			$headTitle = single_cat_title('',false)." | ".get_bloginfo('name');
		// Info crchive
		} else if (is_archive()) {
			if ( is_year()) {
				$headTitle = sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) );
			} if ( is_month()) {
				$headTitle = sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) );
			} else {
				$headTitle = esc_html(bizVektorOptions('infoLabelName'));
			}
			$headTitle .= " | ".get_bloginfo('name');
		}
	// Single
	} else if (is_single()) {
		// $category = get_the_category();
		// if (!empty($category)) :
		// 	$headTitle = get_the_title()." | ".$category[0]->cat_name." | ".get_bloginfo('name');
		// else :
			$headTitle = get_the_title()." | ".get_bloginfo('name');
		// endif;
	// Category
	} else if (is_category()) {
		$headTitle = single_cat_title('',false)." | ".get_bloginfo('name');
	// Tag
	} else if (is_tag()) {
		$headTitle = single_tag_title('',false)." | ".get_bloginfo('name');
	// Archive
	} else if (is_archive()) {
		if (is_month()){
			$headTitle = sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) );
		} else if (is_year()){
			$headTitle = sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) );
		} else if (is_tax()){
			$headTitle = single_term_title('',false);
		} else if (!is_day() || !is_tax()){
			global $wp_query;
			$postTypeName = esc_html($wp_query->queried_object->labels->name);
			$headTitle = $postTypeName;
		}
		$headTitle .= " | ".get_bloginfo('name');
	// Search
	} else if (is_search()) {
		$headTitle = sprintf(__('Search Results for : %s', 'biz-vektor'),get_search_query())." | ".get_bloginfo('name');
	//Other
	} else {
		$headTitle = get_bloginfo('name');
	}
	global $paged;
	if ( $paged != '0' ){
		$headTitle = '['.sprintf(__('Page of %s', 'biz-vektor' ),$paged).'] '.$headTitle;
	}
	$headTitle = apply_filters( 'titleCustom', $headTitle );
	return strip_tags($headTitle);
}
add_filter( 'wp_title', 'getHeadTitle', 10, 2 );

/*-------------------------------------------*/
/*	layout
/*-------------------------------------------*/
function biz_vektor_layouts() {
	$layout_options = array(
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __('Left sidebar', 'biz-vektor'),
			'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __('Right sidebar', 'biz-vektor'),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
	);
	return apply_filters( 'biz_vektor_layouts', $layout_options );
}

/*-------------------------------------------*/
/*	Add layout class to body tag
/*-------------------------------------------*/

function biz_vektor_layout_classes( $existing_classes ) {
	$options = biz_vektor_get_theme_options();
	if (isset($options['theme_layout'])) {
		$current_layout = $options['theme_layout'];

		// if $options['theme_layout'] include 'content-sidebar' or 'sidebar-content' 
		if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
			// Set the classname 'two-column' to $classes
			$classes = array( 'two-column' );

		if ( 'content-sidebar' == $current_layout )
			$classes[] = 'right-sidebar';
		elseif ( 'sidebar-content' == $current_layout )
			$classes[] = 'left-sidebar';
		else
			$classes[] = $current_layout;
	} else {
		$current_layout = array();
		$classes = array();
	}

	$classes = apply_filters( 'biz_vektor_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'biz_vektor_layout_classes' );

/*-------------------------------------------*/
/*	Add to the body tag class to turn off the side bar
/*-------------------------------------------*/
function biz_vektor_topSideBarDisplay( $existing_classes ) {
	if (is_front_page()){
		$options = biz_vektor_get_theme_options();
		if ($options['topSideBarDisplay'] ){
			$classes[] = 'one-column';
			// remove layout class
			$existing_classes = array_diff( $existing_classes , array('right-sidebar','left-sidebar','two-column') );
			// merge 'one-column'
			$existing_classes = array_merge( $existing_classes, $classes );
		}
	}
	return $existing_classes;
}
add_filter( 'biz_vektor_layout_classes', 'biz_vektor_topSideBarDisplay' );

/*-------------------------------------------*/
/*	Theme style
/*-------------------------------------------*/

//	[1] Set theme style array
function biz_vektor_theme_styleSetting() {
	global $biz_vektor_theme_styles;
	$biz_vektor_theme_styles = array(
		'rebuild' => array(
			'label' => 'Rebuild',
			'cssPath' => get_template_directory_uri().'/design_skins/003/css/003.css',
			'cssPathOldIe' => get_template_directory_uri().'/design_skins/003/css/003_oldie.css',
			),
		'calmly' => array(
			'label' => 'Calmly',
			'cssPath' => get_template_directory_uri().'/design_skins/002/002.css',
			'cssPathOldIe' => get_template_directory_uri().'/design_skins/002/002_oldie.css',
			),
		'plain' => array(
			'label' => __('Plain', 'biz-vektor'),
			'cssPath' => get_template_directory_uri().'/design_skins/plain/plain.css',
			'cssPathOldIe' => get_template_directory_uri().'/design_skins/plain/plain_oldie.css',
			),
		'default' => array(
			'label' => 'Default',
			'cssPath' => get_template_directory_uri().'/design_skins/001/001.css',
			'cssPathOldIe' => get_template_directory_uri().'/design_skins/001/001_oldie.css',
			),
	);
	// [2] Receive 'theme style array' from the plug-in
	$biz_vektor_theme_styles = apply_filters( 'biz_vektor_themePlus', $biz_vektor_theme_styles );
}

// [4] Print theme style css
add_action('wp_enqueue_scripts','biz_vektor_theme_style',100 );
function biz_vektor_theme_style() {
	$options = biz_vektor_get_theme_options();
	// Set bbiz_vektor_theme_styles
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();

	if ( isset($options['theme_style']) ) {
		$theme_style = $options['theme_style'];
		/*
		一度保存されているラベルのスキンプラグインが停止またはアンインストールされている事があるので、
		保存されているスキンが使用出来るか判別するために変数の配列を確認。なければ変わりにrebuildを適用する
		*/
		if ( !isset($biz_vektor_theme_styles[$theme_style]) ) {
			$theme_style = 'rebuild';
		}
	} else {
		// set default style
		$theme_style = 'rebuild';
	}

	// wp_enqueue_style( 'theme', $themePath , false, '2013-10-19');

	$themePath = $biz_vektor_theme_styles[$theme_style]['cssPath'];
	$system_name = get_biz_vektor_name();
	$version = ( isset($biz_vektor_theme_styles[$theme_style]['ver']) )? $biz_vektor_theme_styles[$theme_style]['ver']: BizVektor_Theme_Version;

	wp_enqueue_style('Biz_Vektor_Design_style', $themePath, array('Biz_Vektor_common_style'), $version, 'all');

}

add_action('wp_head','biz_vektor_theme_style_oldie',100 );
function biz_vektor_theme_style_oldie() {
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();

	if ( isset($options['theme_style']) ) {
		$theme_style = $options['theme_style'];
		/*
		一度保存されているラベルのスキンプラグインが停止またはアンインストールされている事があるので、
		保存されているスキンが使用出来るか判別するために変数の配列を確認。なければ変わりにrebuildを適用する
		*/
		if ( !isset($biz_vektor_theme_styles[$theme_style]) ) {
			$theme_style = 'rebuild';
		}
	} else {
		// set default style
		$theme_style = 'rebuild';
	}
}

/*-------------------------------------------*/
/*	Favicon
/*-------------------------------------------*/
function biz_vektor_favicon(){
	$options = biz_vektor_get_theme_options();
	if(isset($options['favicon']) && $options['favicon']){
		echo '<link rel="SHORTCUT ICON" HREF="'.$options['favicon'].'" />';
	}
}
add_action('wp_head', 'biz_vektor_favicon');
add_action('admin_head', 'biz_vektor_favicon');

/*-------------------------------------------*/
/*	Menu divide
/*-------------------------------------------*/
add_action('wp_head','biz_vektor_gMenuDivide',170 );
function biz_vektor_gMenuDivide() {
	$options = biz_vektor_get_theme_options();
	// No select
	if ($options['gMenuDivide'] == __('[ Select ]', 'biz-vektor') || ! $options['gMenuDivide'] || ($options['gMenuDivide'] == 'divide_natural') ) {
	//　other
	} else {
		$menuWidth = array(
			'divide_4' => array(238,237),
			'divide_5' => array(193,189),
			'divide_6' => array(159,158),
			'divide_7' => array(139,135),
			);
		$menuWidthActive = $menuWidth[$options['gMenuDivide']][0];
		$menuWidthNonActive = $menuWidth[$options['gMenuDivide']][1];
?>
<style type="text/css">
/*-------------------------------------------*/
/*	menu divide
/*-------------------------------------------*/
@media (min-width: 970px) {
#gMenu .menu > li { width:<?php echo $menuWidthNonActive ?>px; text-align:center; }
#gMenu .menu > li.current_menu_item,
#gMenu .menu > li.current-menu-item,
#gMenu .menu > li.current-menu-ancestor,
#gMenu .menu > li.current_page_item,
#gMenu .menu > li.current_page_ancestor,
#gMenu .menu > li.current-page-ancestor { width:<?php echo $menuWidthActive ?>px; }
}
</style>
<!--[if lte IE 8]>
<style type="text/css">
#gMenu .menu li { width:<?php echo $menuWidthNonActive ?>px; text-align:center; }
#gMenu .menu li.current_page_item,
#gMenu .menu li.current_page_ancestor { width:<?php echo $menuWidthActive ?>px; }
</style>
<![endif]-->
<?php
	}
}

/*-------------------------------------------*/
/*	Header logo
/*-------------------------------------------*/
function biz_vektor_print_headLogo() {
	$options = biz_vektor_get_theme_options();
	if (isset($options['head_logo']) && $options['head_logo']){
		print '<img src="'.$options['head_logo'].'" alt="'.get_bloginfo('name').'" />';
	} else {
		bloginfo('name');
	}
}
/*-------------------------------------------*/
/*	Header contact info (TEL & Time)
/*-------------------------------------------*/
function biz_vektor_print_headContact() {
	$options = biz_vektor_get_theme_options();
	$contact_txt = $options['contact_txt'];
	$contact_time = nl2br($options['contact_time']);
	$headContact = '';
	if ($options['tel_number']) {
		// tel_number
		$headContact = '<div id="headContact" class="itemClose" onclick="showHide(\'headContact\');"><div id="headContactInner">'."\n";
			if ($contact_txt) {
				// contact_txt
				$headContact .= '<div id="headContactTxt">'.$contact_txt.'</div>'."\n";
			}
			// mobile
			if ( function_exists('wp_is_mobile') && wp_is_mobile() ) {
				$headContact .= '<div id="headContactTel">TEL <a href="tel:'.$options['tel_number'].'">'.$options['tel_number'].'</a></div>'."\n";
			// not mobile
			} else {
				$headContact .= '<div id="headContactTel">TEL '.$options['tel_number'].'</div>'."\n";
			}
			if ($contact_time) {
				// contact_time
				$headContact .= '<div id="headContactTime">'.$contact_time.'</div>'."\n";
			}
		$headContact .=	'</div></div>';
	}
	// set filter to $headContact
	$headContact = apply_filters( 'headContactCustom', $headContact );
	echo $headContact;
}

/*-------------------------------------------*/
/*	Home page _ blogList（RSS）
/*-------------------------------------------*/
function biz_vektor_blogList($option = array('url'=>null,'label'=>null))	{
	if( ! function_exists( 'wp_safe_remote_get' ) ) return;

	if ($option['url']){ $blogRss = $option['url']; }
	else{
		$options = biz_vektor_get_theme_options();
		$blogRss = $options['blogRss'];
	}
	if ($blogRss) {
		$titlelabel = 'ブログエントリー';
		if($option['label']){ $titlelabel = $option['label']; }
		elseif($blogRss['rssLabelName']){ $titlelabel = esc_html($option['rssLabelName']); }

		$content = wp_safe_remote_get( $blogRss );
		if( $content['response']['code'] != 200 ) return;

		$xml = @simplexml_load_string( $content['body'] );
		if( empty( $xml ) ) return;
?>
	<div id="topBlog" class="infoList">
	<h2><?php echo $titlelabel; ?></h2>
	<div class="rssBtn"><a href="<?php echo $blogRss ?>" id="blogRss" target="_blank">RSS</a></div>
		<?php
		$count = 0;
		echo '<ul class="entryList">';
		if ($xml->channel->item){
			// WordPress ／　ameblo
			foreach($xml->channel->item as $entry){
			// fot ameblo PR
			$entryTitJudge = mb_substr( $entry->title, 0, 3 );	// trim 3 charactors
			if (!($entryTitJudge == 'PR:')) { 					// Display to only not 'PR:
				 $entrydate = date ( "Y.m.d",strtotime ( $entry->pubDate ) );
				 echo '<li><span class="infoDate">'.$entrydate.'</span>';
				 echo '<span class="infoTxt"><a href="'.$entry->link.'" target="_blank">'.$entry->title.'</a></span></li>';
				 $count++;
			}
			 if ($count > 4){break;}
			}
		} else if ($xml->item){
			// RSS 1.0 (FC2)
			foreach($xml->item as $entry){
				$dc = $entry->children('http://purl.org/dc/elements/1.1/');
				$entrydate = date('Y.m.d', strtotime($dc->date));
				 echo '<li><span class="infoDate">'.$entrydate.'</span>';
				 echo '<span class="infoTxt"><a href="'.$entry->link.'" target="_blank">'.$entry->title.'</a></span></li>';
				 $count++;
			 if ($count > 4){break;}
			}
		} else {
			// livedoor
			foreach($xml->entry as $entry){
				 $entrydate = substr(( $entry->modified ),0,10);
				 $entrydate = str_replace("-", ".", $entrydate);
				 echo '<li><span class="infoDate">'.$entrydate.'</span>';
				 echo '<span class="infoTxt"><a href="'.$entry->link->attributes()->href.'" target="_blank">'.$entry->title.'</a></span></li>';
				 $count++;
			 if ($count > 4){break;}
			}
		}
		echo "</ul>";
		?>
	</div><!-- [ /#topBlog ] -->
<?php
	}
}

/*-------------------------------------------*/
/*	mainfoot _ contact
/*-------------------------------------------*/
function biz_vektor_mainfootContact() {
	$options = biz_vektor_get_theme_options();
	$contact_txt = $options['contact_txt'];
	$contact_time = nl2br($options['contact_time']);
		if ($contact_txt) {
			print '<span class="mainFootCatch">'.$contact_txt.'</span>'."\n";
		}
	if ($options['tel_number']) {
		// mobile
		if ( function_exists('wp_is_mobile') && wp_is_mobile() ) {
			echo '<span class="mainFootTel">TEL <a href="tel:'.$options['tel_number'].'">'.$options['tel_number'].'</a></span>'."\n";
		// not mobile
		} else {
			echo '<span class="mainFootTel">TEL '.$options['tel_number'].'</span>'."\n";
		}
		if ($contact_time) {
			print '<span class="mainFootTime">'.$contact_time.'</span>'."\n";
		}
	}
}

/*-------------------------------------------*/
/*	footer
/*-------------------------------------------*/

function biz_vektor_footerSiteName() 		{
	$options = biz_vektor_get_theme_options();
	if ($options['sub_sitename']) {
		$footSiteName = nl2br($options['sub_sitename']);
	} else {
		$footSiteName = get_bloginfo( 'name' );
	}
	if ($options['foot_logo']) {
		print '<img src="'.$options['foot_logo'].'" alt="'.$footSiteName.'" />';
	} else {
		echo $footSiteName;
	}
}
function biz_vektor_print_footContact() {
	$options = biz_vektor_get_theme_options();
	$contact_address = wp_kses_post(nl2br($options['contact_address']));
	if ($contact_address) {
		print $contact_address;
	}
}

/*-------------------------------------------*/
/*	slide show
/*-------------------------------------------*/
function biz_vektor_slideExist () {
	$biz_vektor_options = biz_vektor_get_theme_options();
	if (
		($biz_vektor_options['slide1image'] && (!$biz_vektor_options['slide1display'])) ||
		($biz_vektor_options['slide2image'] && (!$biz_vektor_options['slide2display'])) ||
		($biz_vektor_options['slide3image'] && (!$biz_vektor_options['slide3display'])) ||
		($biz_vektor_options['slide4image'] && (!$biz_vektor_options['slide4display'])) ||
		($biz_vektor_options['slide5image'] && (!$biz_vektor_options['slide5display']))
	){
	return true;
	}
}

function get_biz_vektor_slide_body( $dummy=false ){
	$biz_vektor_options = biz_vektor_get_theme_options();
	$biz_vektor_slide_body = '';
	for ( $i = 1; $i <= 5 ; $i++){
		if ( $biz_vektor_options['slide'.$i.'image'] && !$biz_vektor_options['slide'.$i.'display']) {
			if( $dummy ){
				return '<img id="topMainBnrDummy" src="'.$biz_vektor_options['slide'.$i.'image'].'" />'."\n";
			}
			$biz_vektor_slide_body .= '<li>';
			if ($biz_vektor_options['slide'.$i.'link']) {
				$blank = "";
				if ($biz_vektor_options['slide'.$i.'blank']) : $blank = ' target="_blank"'; endif;
				$biz_vektor_slide_body .= '<a href="'.$biz_vektor_options['slide'.$i.'link'].'" class="slideFrame"'.$blank.'>';
			} else	{
				$biz_vektor_slide_body .= '<span class="slideFrame">';
			}
			$biz_vektor_slide_body .= '<img src="'.$biz_vektor_options['slide'.$i.'image'].'" alt="'.$biz_vektor_options['slide'.$i.'alt'].'" />';
			if ($biz_vektor_options['slide'.$i.'link']) {
				$biz_vektor_slide_body .= '</a>';
			} else {
				$biz_vektor_slide_body .= '</span>';
			}
			$biz_vektor_slide_body .= '</li>'."\n";
		}
	}
	return $biz_vektor_slide_body;
}

function get_biz_vektor_header_image(){
	$biz_vektor_slider_class = (biz_vektor_slideExist()) ? ' class="flexslider '. bizVektorOptions('slider_animation') . '"':'';
	$biz_vektor_header_image = '<div id="topMainBnr">'."\n";
	$biz_vektor_header_image .= '<div id="topMainBnrFrame"'.$biz_vektor_slider_class.'>'."\n";
	if(biz_vektor_slideExist()) {
		$biz_vektor_header_image .= get_biz_vektor_slide_body( true );
		$biz_vektor_header_image .= '<ul class="slides">'."\n";
		$biz_vektor_header_image .= get_biz_vektor_slide_body();
		$biz_vektor_header_image .= '</ul>'."\n";
	} else {
		$biz_vektor_header_image .= '<div class="slideFrame"><img src="'.esc_url( get_header_image() ).'" /></div>'."\n";
	}
	$biz_vektor_header_image .= '</div>'."\n";
	$biz_vektor_header_image .= '</div>'."\n";
	$biz_vektor_header_image = apply_filters( 'biz_vektor_header_image', $biz_vektor_header_image );
	return $biz_vektor_header_image;
}

function get_biz_vektor_header_image_home(){
	if (is_front_page() && ( biz_vektor_slideExist() || get_header_image()) ) {
		$biz_vektor_header_image_front = get_biz_vektor_header_image();
		$biz_vektor_header_image_front = apply_filters( 'biz_vektor_header_image_front', $biz_vektor_header_image_front );
		return $biz_vektor_header_image_front;
	}
}


/*-------------------------------------------*/
/*	Print theme_options js
/*-------------------------------------------*/
add_action('admin_print_scripts-appearance_page_theme_options', 'admin_theme_options_plugins');
function admin_theme_options_plugins( $hook_suffix ) {
	wp_enqueue_media();
	wp_register_script( 'biz_vektor-theme-options', get_template_directory_uri().'/inc/theme-options.js', array('jquery'), BizVektor_Theme_Version );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'biz_vektor-theme-options' );
}

/*-------------------------------------------*/
/*	Change fonts
/*-------------------------------------------*/

if ( 'ja' == get_locale() ) {
	add_action( 'wp_head','biz_vektor_fontStyle',170);
}
function biz_vektor_fontStyle(){
	$options = biz_vektor_get_theme_options();
	$font_face_serif = _x('serif', 'Font select', 'biz-vektor');
	$font_face_serif = apply_filters( 'font_face_serif_custom', $font_face_serif );
	$font_face_sans_serif = _x('Meiryo,Osaka,sans-serif', 'Font select', 'biz-vektor');
	$font_face_sans_serif = apply_filters( 'font_face_sans_serif_custom', $font_face_sans_serif );
	if ( isset($options['font_title']) ) {
		if ( $options['font_title'] == 'serif') {
			$font_title_face = $font_face_serif ;
			$font_title_weight = 'bold';
		} else {
			$font_title_face = $font_face_sans_serif;
			$font_title_weight = 'lighter';
		}
	}
	if ( isset($options['font_menu']) ) {
		if ( $options['font_menu'] == 'serif') {
			$font_menu_face = $font_face_serif ;
		} else {
			$font_menu_face = $font_face_sans_serif;
		}
	}
	if ( ( isset($font_title_face) && $font_title_face ) || ( isset($font_menu_face) && $font_menu_face) ) {
		$font_style_head = '<style type="text/css">
/*-------------------------------------------*/
/*	font
/*-------------------------------------------*/'."\n";
	}
	if ( isset($font_title_face) && $font_title_face ){
		$font_style_head .= 'h1,h2,h3,h4,h4,h5,h6,#header #site-title,#pageTitBnr #pageTitInner #pageTit,#content .leadTxt,#sideTower .localHead {font-family: '.$font_title_face.'; }'."\n";
		$font_style_head .= '#pageTitBnr #pageTitInner #pageTit { font-weight:'.$font_title_weight.'; }'."\n";
	}
	if ( isset($font_menu_face) && $font_menu_face ){
		$font_style_head .= '#gMenu .menu li a strong {font-family: '.$font_menu_face.'; }'."\n";
	}
	if ( ( isset($font_title_face) && $font_title_face ) || ( isset($font_menu_face) && $font_menu_face) ) {
		$font_style_head .= '</style>'."\n";
	}
	// Output font style
	if ( isset($font_style_head) && $font_style_head ) echo $font_style_head;
}


/*-------------------------------------------*/
/*	Side menu hidden
/*-------------------------------------------*/
add_action( 'wp_head','biz_vektor_sideChildDisplay');
function biz_vektor_sideChildDisplay(){
	$options = biz_vektor_get_theme_options();
	if ( isset($options['side_child_display'] ) && $options['side_child_display'] == 'side_child_hidden' ) { ?>
<style type="text/css">
/*-------------------------------------------*/
/*	sidebar child menu display
/*-------------------------------------------*/
#sideTower	ul.localNavi ul.children	{ display:none; }
#sideTower	ul.localNavi li.current_page_ancestor	ul.children,
#sideTower	ul.localNavi li.current_page_item		ul.children,
#sideTower	ul.localNavi li.current-cat				ul.children{ display:block; }
</style>
	<?php
	}
}


add_action( 'wp_head', 'biz_vektor_output_keycolorcss', 5);
function biz_vektor_output_keycolorcss(){
	echo '<style type="text/css">';
	$corlors_default = array(
		'keyColor'       => '#e90000',
	);
	$types = array('_bg'=>'background-color','_txt'=>'color','_border'=>'border-color');
	$types_o = array('_bg'=>'BG','_txt'=>'Cl','_border'=>'Bd');
	$corlors = apply_filters('biz_vektor_keycolors', $corlors_default);
	$corlors['color_key'] = $corlors['keyColor'];
	// unset($corlors['keyColor']);

	reset($corlors);
	while(list($k,$v) = each($corlors)){
		reset($types);
		while(list($kk,$vv) = each($types)){
			echo ".{$k}{$types_o[$kk]},.{$k}{$types_o[$kk]}h:hover,";
			echo ".{$k}{$kk},.{$k}{$kk}_hover:hover{{$vv}: {$v};}";
		}
	}
	echo "</style>\n";
}


/*	admin_head JavaScript debug console hook_suffix
/*-------------------------------------------*/
/*
add_action("admin_head", 'suffix2console');
function suffix2console() {
	global $hook_suffix;
	if (is_user_logged_in()) {
		$str = "<script type=\"text/javascript\">console.log('%s')</script>";
		printf($str, $hook_suffix);
	}
}
*/

/*-------------------------------------------*/
/*	Contact Btn
/*-------------------------------------------*/
function get_biz_vektor_contactBtn(){
	$biz_vektor_options = biz_vektor_get_theme_options();
	if ($biz_vektor_options['contact_link']) :
	$contactBtn = '<ul>';
	$contactBtn .= '<li class="sideBnr" id="sideContact"><a href="'.$biz_vektor_options['contact_link'].'">'."\n";
	$sideContactBtnImage = '<img src="'.get_template_directory_uri().'/images/'.__('bnr_contact.png', 'biz-vektor').'" alt="'.__('Contact us by e-mail', 'biz-vektor').'">';
	$sideContactBtnImage = apply_filters( 'bizvektor_side_contact_btn_image', $sideContactBtnImage );
	$contactBtn .= $sideContactBtnImage."\n";
	$contactBtn .= '</a></li>'."\n";
	$contactBtn .= '</ul>'."\n";
	$contactBtn = apply_filters( 'biz_vektor_side_contactBtn', $contactBtn );
	return $contactBtn;
	endif;
}

function biz_vektor_contactBtn(){
	echo get_biz_vektor_contactBtn();
}

function get_biz_vektor_name() {
	$name = 'BizVektor';
	$name = apply_filters( 'biz_vektor_name', $name );
	return $name;
}
