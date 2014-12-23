<?php

/*-------------------------------------------*/
/*	Theme Option の初期設定
/*-------------------------------------------*/
/*	送信した値をデータベースに登録したり、サニタイズする
/*-------------------------------------------*/
/*	Set option default
/*-------------------------------------------*/
/*	入力された値の処理
/*-------------------------------------------*/
/*	テーマオプション取得
/*-------------------------------------------*/
/*	Print option
/*-------------------------------------------*/


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
/*	GoogleAnalytics
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

get_template_part('inc/views/edit');

/*-------------------------------------------*/
/*	Create title
/*-------------------------------------------*/
function getHeadTitle() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_page('home') || is_front_page()) {
		if (isset($options['topTitle']) && $options['topTitle'])	{
			$headTitle = $options['topTitle'];
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
	return esc_html($headTitle);
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

	wp_enqueue_style('Biz_Vektor_Design_style', $themePath, array('Biz_Vektor_common_style'), false, 'all');

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

echo '<style type="text/css">
/*-------------------------------------------*/
/*	menu divide
/*-------------------------------------------*/
@media (min-width: 970px) {
#gMenu .menu > li { width:'.$menuWidthNonActive.'px; text-align:center; }
#gMenu .menu > li.current_menu_item,
#gMenu .menu > li.current-menu-ancestor,
#gMenu .menu > li.current_page_item,
#gMenu .menu > li.current_page_ancestor,
#gMenu .menu > li.current-page-ancestor { width:'.$menuWidthActive.'px; }
}
</style>
<!--[if lte IE 8]>
<style type="text/css">
#gMenu .menu li { width:'.$menuWidthNonActive.'px; text-align:center; }
#gMenu .menu li.current_page_item,
#gMenu .menu li.current_page_ancestor { width:'.$menuWidthActive.'px; }
</style>
<![endif]-->'."\n";
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
		echo bloginfo('name');
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
function biz_vektor_blogList($option = array('url'=>null,'label'=>null)){
	if ($option['url']){ $blogRss = $option['url']; }
	else{
		$options = biz_vektor_get_theme_options();
		$blogRss = $options['blogRss'];
	}
	if ($blogRss) {
		$titlelabel = 'ブログエントリー';
		if($option['label']){ $titlelabel = $option['label']; }
		elseif($blogRss['rssLabelName']){ $titlelabel = esc_html($option['rssLabelName']); }
?>
	<div id="topBlog" class="infoList">
	<h2><?php echo $titlelabel; ?></h2>
	<div class="rssBtn"><a href="<?php echo $blogRss ?>" id="blogRss" target="_blank">RSS</a></div>
		<?php
		$xml = simplexml_load_file($blogRss);
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

/*-------------------------------------------*/
/*	slide show
/*-------------------------------------------*/
function biz_vektor_slideExist () {
	global $biz_vektor_options;
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

function get_biz_vektor_slide_body(){
	global $biz_vektor_options;
	$biz_vektor_slide_body = '';
	for ( $i = 1; $i <= 5 ; $i++){
		if ( $biz_vektor_options['slide'.$i.'image'] && !$biz_vektor_options['slide'.$i.'display']) {
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
	$biz_vektor_slider_class = (biz_vektor_slideExist()) ? ' class="flexslider"':'';
	$biz_vektor_header_image = '<div id="topMainBnr">'."\n";
	$biz_vektor_header_image .= '<div id="topMainBnrFrame"'.$biz_vektor_slider_class.'>'."\n";
	if(biz_vektor_slideExist()) {
		$biz_vektor_header_image .= '<ul class="slides">'."\n";
		$biz_vektor_header_image .= get_biz_vektor_slide_body();
		$biz_vektor_header_image .= '</ul>'."\n";
	} else {
		$biz_vektor_header_image .= '<div class="slideFrame"><img src="'.esc_url( get_header_image() ).'" alt="" /></div>'."\n";
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
	wp_register_script( 'biz_vektor-theme-options', get_template_directory_uri().'/inc/theme-options.js', array('jquery'), '20120902' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'biz_vektor-theme-options' );
}

/*-------------------------------------------*/
/*	Change fonts
/*-------------------------------------------*/

add_action( 'wp_head','biz_vektor_fontStyle',170);
function biz_vektor_fontStyle(){
	if ( 'ja' != get_locale() ) { return; }
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
	global $biz_vektor_options;
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

/*-------------------------------------------*/
/*	Theme Option の初期設定
/*-------------------------------------------*/
function biz_vektor_theme_options_init() {
	// biz_vektor_theme_options が存在しなかったら作る
	if ( false === get_option('biz_vektor_theme_options') ){
		add_option( 'biz_vektor_theme_options', biz_vektor_generate_default_options() );
	}

	global $biz_vektor_options;
	$biz_vektor_options = get_option('biz_vektor_theme_options' );
}
add_action( 'after_setup_theme', 'biz_vektor_theme_options_init' );

/*-------------------------------------------*/
/*	送信した値をデータベースに登録したり、サニタイズする
/*-------------------------------------------*/
function biz_vektor_option_register(){
	register_setting(
		'biz_vektor_options',					// 設定のグループ名。ここで指定した名前をsettings_fields関数の引数に指定します。
		'biz_vektor_theme_options',				// 登録するオプションの名前。input要素などのname属性を指定します。
		'biz_vektor_theme_options_validate'		// オプションの値をサニタイズするためのコールバック関数。
	);
}
add_action('admin_init', 'biz_vektor_option_register');

/*-------------------------------------------*/
/*	Theme Option Default
/*-------------------------------------------*/

function biz_vektor_generate_default_options(){
		$default_theme_options = array(
		'font_title'           => 'sanserif',
		'font_menu'            => 'sanserif',
		'global_font'          => 'Open+Sans',
		'gMenuDivide'          => '',
		'head_logo'            => '',
		'foot_logo'            => '',
		'contact_txt'          => '',
		'tel_number'           => '',
		'contact_time'         => '',
		'sub_sitename'         => '',
		'contact_address'      => '',
		'contact_link'         => '',
		'enableie8Warning'     => true,
		'topEntryTitleDisplay' => '',
		'topSideBarDisplay'    => false,
		'top3PrDisplay'        => '',
		'postTopCount'         => '5',
		'postTopUrl'           => '',
		'listBlogTop'          => 'listType_set',
		'listBlogArchive'      => 'listType_set',
		'postRelatedCount'     => '6',
		'blogRss'              => '',
		'ad_conent_moretag'    => '',
		'ad_conent_after'      => '',
		'ad_related_after'     => '',
		'side_child_display'   => 'side_child_display',
		'rssLabelName'         => 'Blog entries',
		'favicon'              => '',
		'theme_layout'         => 'content-sidebar',
		'postLabelName'        => __('Blog', 'biz-vektor'),
		'theme_style'          => 'rebuild',
		'enable_google_font'   => 'true',
		'pr1_title'            => __('Rich theme options', 'biz-vektor'),
		'pr1_description'      => __('This area can be changed from the theme customizer as well as from the theme options section.', 'biz-vektor'),
		'pr1_link'             => '',
		'pr1_image'            => get_template_directory_uri().'/images/samples/pr_image_demo_1.jpg',
		'pr1_image_s'          => get_template_directory_uri().'/images/samples/pr_image_demo_sq_1.jpg',
		'pr2_title'            => __('Various designs available', 'biz-vektor'),
		'pr2_description'      => __('BizVektor will allow you not only to change the color of the site, but also to switch to a different design.', 'biz-vektor'),
		'pr2_link'             => '',
		'pr2_image'            => get_template_directory_uri().'/images/samples/pr_image_demo_2.jpg',
		'pr2_image_s'          => get_template_directory_uri().'/images/samples/pr_image_demo_sq_2.jpg',
		'pr3_title'            => __('Optimized for business web sites', 'biz-vektor'),
		'pr3_description'      => __('Various indispensable business features as child page templates or enquiry capture are included.', 'biz-vektor'),
		'pr3_link'             => '',
		'pr3_image'            => get_template_directory_uri().'/images/samples/pr_image_demo_3.jpg',
		'pr3_image_s'          => get_template_directory_uri().'/images/samples/pr_image_demo_sq_3.jpg',
		'version'              => BizVektor_Theme_Version,
		'SNSuse'               => false
	);

	for ( $i = 1; $i <= 5 ;){
		$default_theme_options['slide'.$i.'link'] = '';
		$default_theme_options['slide'.$i.'image'] = '';
		$default_theme_options['slide'.$i.'alt'] = '';
		$default_theme_options['slide'.$i.'display'] = '';
		$default_theme_options['slide'.$i.'blank'] = '';
	$i++;
	}
	return apply_filters( 'biz_vektor_default_options', $default_theme_options );
}


/*-------------------------------------------*/
/*	入力された値の処理
/*-------------------------------------------*/
function biz_vektor_theme_options_validate( $input ) {
	$output = biz_bektor_option_validate();
	$defaults = biz_vektor_generate_default_options();
	if(isset($_POST['bizvektor_action_mode']) && $_POST['bizvektor_action_mode'] == 'reset'){ return $defaults; }

	// Design
	$output['gMenuDivide']            = $input['gMenuDivide'];
	$output['head_logo']              = $input['head_logo'];
	$output['foot_logo']              = $input['foot_logo'];
	$output['font_title']             = $input['font_title'];
	$output['font_menu']              = $input['font_menu'];
	if ( 'ja' != get_locale() ) {
		$output['global_font']            = $input['global_font'];
	}
	$output['side_child_display']     = $input['side_child_display'];
	$output['favicon']                = (preg_match("/.+\.ico$/i", $input['favicon']))? $input['favicon'] : '';
	$output['enableie8Warning']       = (isset($input['enableie8Warning']) && $input['enableie8Warning'] == 'true')? true: false;

	// Contact info
	$output['contact_txt']            = $input['contact_txt'];
	$output['tel_number']             = $input['tel_number'];
	$output['contact_time']           = $input['contact_time'];
	$output['sub_sitename']           = $input['sub_sitename'];
	$output['contact_address']        = $input['contact_address'];
	$output['contact_link']           = $input['contact_link'];
	// 3PR
	$output['top3PrDisplay']          = (isset($input['top3PrDisplay']) && $input['top3PrDisplay'] == 'true')?	 true : false;
	$output['pr1_title']              = ($input['pr1_title'] == '')?		$defaults['pr1_title'] : $input['pr1_title'] ;
	$output['pr1_description']        = ($input['pr1_description'] == '')?	 $defaults['pr1_description'] : $input['pr1_description'] ;
	$output['pr1_link']               = $input['pr1_link'];
	$output['pr1_image']              = $input['pr1_image'];
	$output['pr1_image_s']            = $input['pr1_image_s'];
	$output['pr2_title']              = ($input['pr2_title'] == '')?		$defaults['pr2_title'] : $input['pr2_title'] ;
	$output['pr2_description']        = ($input['pr2_description'] == '')?	 $defaults['pr2_description'] : $input['pr2_description'] ;
	$output['pr2_link']               = $input['pr2_link'];
	$output['pr2_image']              = $input['pr2_image'];
	$output['pr2_image_s']            = $input['pr2_image_s'];
	$output['pr3_title']              = ($input['pr3_title'] == '')?		$defaults['pr3_title'] : $input['pr3_title'] ;
	$output['pr3_description']        = ($input['pr3_description'] == '')?	 $defaults['pr3_description'] : $input['pr3_description'] ;
	$output['pr3_link']               = $input['pr3_link'];
	$output['pr3_image']              = $input['pr3_image'];
	$output['pr3_image_s']            = $input['pr3_image_s'];
	// Infomation & Blog	
	$output['postLabelName']          = (preg_match('/^(\s|[ 　]*)$/', $input['postLabelName']))?	 $defaults['postLabelName'] : $input['postLabelName'] ;
	$output['listBlogTop']            = $input['listBlogTop'];
	$output['listBlogArchive']        = $input['listBlogArchive'];
	$output['postTopUrl']             = $input['postTopUrl'];
	$output['postTopCount']           = (preg_match('/^(\s|[ 　]*)$/', $input['postTopCount']))? 5 : $input['postTopCount'];
	$output['postRelatedCount']       = (preg_match('/^(\s|[ 　]*)$/', $input['postRelatedCount']))? 6 : $input['postRelatedCount'];
	$output['ad_content_moretag']     = $input['ad_content_moretag'];
	$output['ad_content_after']       = $input['ad_content_after'];
	$output['ad_related_after']       = $input['ad_related_after'];
	// TopPage
	$output['topSideBarDisplay']      = (isset($input['topSideBarDisplay']) && $input['topSideBarDisplay'] == 'true')? true : false;
	// SlideShow
	for ( $i = 1; $i <= 5 ;){
		$output['slide'.$i.'link']     = $input['slide'.$i.'link'];
		$output['slide'.$i.'image']    = $input['slide'.$i.'image'];
		$output['slide'.$i.'alt']      = $input['slide'.$i.'alt'];
		$output['slide'.$i.'display']  = (isset($input['slide'.$i.'display']) && $input['slide'.$i.'display'])? "true" : '';
		$output['slide'.$i.'blank']    = (isset($input['slide'.$i.'blank']) && $input['slide'.$i.'blank'])? "true" : '';
	$i++;
	}

	if($input['theme_layout'] == ''){ $output['theme_layout'] = "content-sidebar"; }

	$output['theme_style'] = ($input['theme_style'] == '') ? "rebuild" : $input['theme_style'] ;

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], biz_vektor_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	// sidebar child menu display
	if( isset($input['side_child_display']) && $input['side_child_display'] ){ $output['side_child_display'] = $input['side_child_display']; }

	return apply_filters( 'biz_vektor_theme_options_validate', $output, $input, $defaults );
}

function biz_vektor_them_edit_function($post){
	switch ($post['bizvektor_action_mode']) {
		case 'reset':
			$default_theme_options = biz_vektor_generate_default_options();
			delete_option('biz_vektor_theme_options');
			add_option('biz_vektor_theme_options', $default_theme_options);
			biz_vektor_theme_options_init();
			break;
		default:
			break;
	}
}

/*-------------------------------------------*/
/*	テーマオプション取得
/*-------------------------------------------*/
function biz_vektor_get_theme_options() {
	global $biz_vektor_options;
	// global 変数が上手く取得出来てない場合はDBから持ってくる。
	// if (!isset($biz_vektor_options)) 
	// やはりDBから持ってこないとカスタマイザーが効かない。
	$biz_vektor_options = get_option('biz_vektor_theme_options', biz_vektor_generate_default_options());
	return $biz_vektor_options;
}

/*-------------------------------------------*/
/*	Print option
/*	global $biz_vektor_options に順次移行
/*-------------------------------------------*/
function bizVektorOptions($optionLabel) {
	$options = biz_vektor_get_theme_options();
	if ( isset($options[$optionLabel]) && $options[$optionLabel] ) {
		return $options[$optionLabel];
	} else {
		$options_default = biz_vektor_generate_default_options();
		if (isset($options_default[$optionLabel]))
		return $options_default[$optionLabel];
	}
}

/*-------------------------------------------*/
/*	
/*	@return array(options)
/*-------------------------------------------*/
function biz_bektor_option_validate(){
	$option = get_option('biz_vektor_theme_options');
	$default = biz_vektor_generate_default_options();

	if($option && is_array($option)){
		$keys = array_keys($option);
		foreach($keys as $key){
			if( !isset($option[$key]) && $key != 'version'){
				$option[$key] = $default[$key];
			}
		}
	}
	else {
		$option = $default;
	}
	return $option;
}

