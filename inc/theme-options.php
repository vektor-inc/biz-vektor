<?php
/*-------------------------------------------*/
/*	Create title
/*-------------------------------------------*/
/*	layout
/*-------------------------------------------*/
/*	Add layout class to body tag
/*-------------------------------------------*/
/*	Add to the body tag class to turn off the side bar
/*-------------------------------------------*/
/*	Theme option edit
/*-------------------------------------------*/
/*	Theme style
/*-------------------------------------------*/
/*	Menu divide
/*-------------------------------------------*/
/*	Header logo
/*-------------------------------------------*/
/*	Header contact info (TEL & Time)
/*-------------------------------------------*/
/*	facebook twitter banner
/*-------------------------------------------*/
/*	Home page _ blogList（RSS）
/*-------------------------------------------*/
/*	Home page _ bottom free area
/*-------------------------------------------*/
/*	Add OGP
/*-------------------------------------------*/
/*	mainfoot _ contact
/*-------------------------------------------*/
/*	snsBtns
/*-------------------------------------------*/
/*	snsBtns _ display page
/*-------------------------------------------*/
/*	facebook comment display page
/*-------------------------------------------*/
/*	facebookLikeBox
/*-------------------------------------------*/
/*	Print facebook Application ID 
/*-------------------------------------------*/
/*	Create keywords
/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
/*	footer
/*-------------------------------------------*/
/*	slide show
/*-------------------------------------------*/
/*	Print option
/*-------------------------------------------*/
/*	Set option default
/*-------------------------------------------*/
/*	Print theme_options js
/*-------------------------------------------*/
/*	Side menu hidden
/*-------------------------------------------*/

function biz_vektor_theme_options_init() {
	if ( false === biz_vektor_get_theme_options() )
		add_option( 'biz_vektor_theme_options', biz_vektor_get_default_theme_options() );

	register_setting(
		'biz_vektor_options',
		'biz_vektor_theme_options',
		'biz_vektor_theme_options_validate'
	);
}
add_action( 'admin_init', 'biz_vektor_theme_options_init' );

function biz_vektor_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_biz_vektor_options', 'biz_vektor_option_page_capability' );

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
/*	Create title
/*-------------------------------------------*/
function getHeadTitle() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_page('home') || is_front_page()) {
		if ($options['topTitle'])	{
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
			$headTitle = single_cat_title()." | ".get_bloginfo('name');
		// Info crchive
		} else if (is_archive()) {
			$headTitle = sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) );
			$headTitle .= " | ".get_bloginfo('name');
		}
	// Single
	} else if (is_single()) {
		$category = get_the_category();
		if (!empty($category)) :
			$headTitle = get_the_title()." | ".$category[0]->cat_name." | ".get_bloginfo('name');
		else :
			$headTitle = get_the_title()." | ".get_bloginfo('name');
		endif;
	// Category
	} else if (is_category()) {
		$headTitle = single_cat_title()." | ".get_bloginfo('name');
	// Tag
	} else if (is_tag()) {
		$headTitle = single_tag_title()." | ".get_bloginfo('name');
	// Archive
	} else if (is_archive()) {
		if (is_month()){
			$headTitle = sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) );
			$headTitle .= " | ".get_bloginfo('name');
		} else {
			$headTitle = single_tag_title();
		}
	// Search
	} else if (is_search()) {
		$headTitle = sprintf(__('Search Result for : %s', 'biz-vektor'),get_search_query())." | ".get_bloginfo('name');
	//Other
	} else {
		$headTitle = get_bloginfo('name');
	}
	$headTitle = apply_filters( 'titleCustom', $headTitle );
    echo $headTitle;
}
/*-------------------------------------------*/
/*	layout
/*-------------------------------------------*/
function biz_vektor_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __('Right sidebar', 'biz-vektor'),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __('Left sidebar', 'biz-vektor'),
			'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
	);
	return apply_filters( 'biz_vektor_layouts', $layout_options );
}

function biz_vektor_get_default_theme_options() {
	$default_theme_options = array(
		'theme_layout' => 'content-sidebar',
	);
}

function biz_vektor_get_theme_options() {
	return get_option( 'biz_vektor_theme_options', biz_vektor_get_default_theme_options() );
}

/*-------------------------------------------*/
/*	Add layout class to body tag
/*-------------------------------------------*/

function biz_vektor_layout_classes( $existing_classes ) {
	$options = biz_vektor_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
		$classes = array( 'two-column' );

	if ( 'content-sidebar' == $current_layout )
		$classes[] = 'right-sidebar';
	elseif ( 'sidebar-content' == $current_layout )
		$classes[] = 'left-sidebar';
	else
		$classes[] = $current_layout;

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
/*	Theme option edit
/*-------------------------------------------*/

get_template_part('inc/theme-options-edit');

/*-------------------------------------------*/
/*	Theme style
/*-------------------------------------------*/

//	[1] Set theme style array
function biz_vektor_theme_styleSetting() {
	global $biz_vektor_theme_styles;
	$biz_vektor_theme_styles = array(
		'calmly' => array(
			'label' => 'Calmly',
			'cssPath' => get_template_directory_uri().'/bizvektor_themes/002/002.css',
			'cssPathOldIe' => get_template_directory_uri().'/bizvektor_themes/002/002_oldie.css',
			),
		'plain' => array(
			'label' => __('Plain', 'biz-vektor'),
			'cssPath' => get_template_directory_uri().'/bizvektor_themes/plain/plain.css',
			'cssPathOldIe' => get_template_directory_uri().'/bizvektor_themes/plain/plain_oldie.css',
			),
		'default' => array(
			'label' => 'Default',
			'cssPath' => get_template_directory_uri().'/bizvektor_themes/001/001.css',
			'cssPathOldIe' => get_template_directory_uri().'/bizvektor_themes/001/001_oldie.css',
			),
	);
	// [2] Receive 'theme style array' from the plug-in
	$biz_vektor_theme_styles = apply_filters( 'biz_vektor_themePlus', $biz_vektor_theme_styles );
}

// [4] Print theme style css
function biz_vektor_theme_style() {
	$options = biz_vektor_get_theme_options();
	// Set bbiz_vektor_theme_styles
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();
	// load default
	if ( !$options['theme_style'] ) {
		global $bizVektorOptions_default;
		bizVektorOptions_default();
		$options['theme_style'] = $bizVektorOptions_default['theme_style'];
	}
	$themePath = $biz_vektor_theme_styles[$options['theme_style']]['cssPath'];

	wp_enqueue_style( 'theme', $themePath , false, '2013-10-19');
}

// fuck IE
function biz_vektor_theme_styleOldIe(){
	$options = biz_vektor_get_theme_options();
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();
	$themePathOldIe = $biz_vektor_theme_styles[$options['theme_style']]['cssPathOldIe'];

	$themePath = $biz_vektor_theme_styles[$options['theme_style']]['cssPath'];
	$themePathOldIe = $biz_vektor_theme_styles[$options['theme_style']]['cssPathOldIe'];

	// Necessary
	if ($themePathOldIe){
		print '<!--[if lte IE 8]>'."\n";
		print '<link rel="stylesheet" type="text/css" media="all" href="'.$themePathOldIe.'" />'."\n";
		print '<![endif]-->'."\n";
	}
}

/*-------------------------------------------*/
/*	Menu divide
/*-------------------------------------------*/
function biz_vektor_gMenuDivide() {
	$options = biz_vektor_get_theme_options();
	// No select
	if ($options['gMenuDivide'] == __('[ Select ]', 'biz-vektor') || ! $options['gMenuDivide'] || ($options['gMenuDivide'] == 'divide_natural') ) {
	//　other
	} else {
		print '<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/css/g_menu_'.$options['gMenuDivide'].'.css" />'."\n";
		print '<!--[if lte IE 8]>'."\n";
		print '<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/css/g_menu_'.$options['gMenuDivide'].'_oldie.css" />'."\n";
		print '<![endif]-->'."\n";
	}
}
/*-------------------------------------------*/
/*	Header logo
/*-------------------------------------------*/
function biz_vektor_print_headLogo() {
	$options = biz_vektor_get_theme_options();
	$head_logo = $options['head_logo'];
	if ($options['head_logo']) {
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
/*	facebook twitter banner
/*-------------------------------------------*/
function biz_vektor_snsBnrs() {
	$options = biz_vektor_get_theme_options();
	$facebook = $options['facebook'];
	$twitter = $options['twitter'];
	if ($facebook || $twitter) {
		print '<ul id="snsBnr">';
		if ($facebook) { ?>
		<li><a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bnr_facebook.png" alt="facebook" /></a></li>
		<?php }
		if ($twitter) { ?>
		<li><a href="https://twitter.com/#!/<?php echo htmlspecialchars($twitter); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bnr_twitter.png" alt="twitter" /></a></li>
		<?php }
		print '</ul>';
	}
}

/*-------------------------------------------*/
/*	Home page _ blogList（RSS）
/*-------------------------------------------*/
function biz_vektor_blogList()	{
	$options = biz_vektor_get_theme_options();
	$blogRss = $options['blogRss'];
	if ($blogRss) {
?>
	<div id="topBlog" class="infoList">
	<h2><?php echo esc_html( bizVektorOptions('rssLabelName')); ?></h2>
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
/*	Home page _ bottom free area
/*-------------------------------------------*/

function biz_vektor_topContentsBottom()	{
	$options = biz_vektor_get_theme_options();
	$topContentsBottom = $options['topContentsBottom'];
	if ($topContentsBottom) {
		echo '<div id="topContentsBottom">'."\n";
		echo $topContentsBottom;
		if ( is_user_logged_in() == TRUE ) {
			echo '<div class="adminEdit edit-item">'."\n";
			echo '<a href="'.get_admin_url().'/themes.php?page=theme_options#topPage" class="btn btnS btnAdmin">';
			echo __('Edit', 'biz-vektor');
			echo '</a>'."\n";
			echo '</div>'."\n";
		}
		echo '</div>'."\n";
	}
}


/*-------------------------------------------*/
/*	Add OGP
/*-------------------------------------------*/
add_action('wp_head', 'biz_vektor_ogp' );
function biz_vektor_ogp () {
	$options = biz_vektor_get_theme_options();
	//$ogpImage = $options['ogpImage'];
	//$fbAppId = $options['fbAppId'];
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_front_page()) {
		$linkUrl = home_url();
	} else if (is_single() || is_page()) {
		$linkUrl = get_permalink();
	} else {
		$linkUrl = get_permalink();
	}
	$bizVektorOGP = '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\n";
	$bizVektorOGP .= '<meta property="og:url" content="'.$linkUrl.'" />'."\n";
	if ($options['fbAppId']){
		$bizVektorOGP = $bizVektorOGP.'<meta property="fb:app_id" content="'.$options['fbAppId'].'" />'."\n";
	}
	if (is_front_page() || is_home()) {
		$bizVektorOGP .= '<meta property="og:type" content="website" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
		$bizVektorOGP .= '<meta property="og:title" content="'.get_bloginfo('name').'" />'."\n";
		$bizVektorOGP .= '<meta property="og:description" content="'.get_bloginfo('description').'" />'."\n";
	} else if (is_category() || is_archive()) {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
	} else if (is_page() || is_single()) {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		// image
		if (has_post_thumbnail()) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'large', true);
			$bizVektorOGP .= '<meta property="og:image" content="'.$image_url[0].'" />'."\n";
		} else if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
		// description
		$metaExcerpt = $post->post_excerpt;
		if ($metaExcerpt) {
			$metadescription = $post->post_excerpt;
		} else {
			$metadescription = mb_substr( strip_tags($post->post_content), 0, 240 ); // kill tags and trim 240 chara
			$metadescription = str_replace(array("\r\n","\r","\n"), ' ', $metadescription);
		}
		$bizVektorOGP .= '<meta property="og:title" content="'.get_the_title().' | '.get_bloginfo('name').'" />'."\n";
		$bizVektorOGP .= '<meta property="og:description" content="'.$metadescription.'" />'."\n";
	} else {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
	}
	if ( $options['ogpTagDisplay'] == 'ogp_off' ) {
		$bizVektorOGP = '';
	}
	$bizVektorOGP = apply_filters('bizVektorOGPCustom', $bizVektorOGP );
	echo $bizVektorOGP;
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
/*	snsBtns
/*-------------------------------------------*/
function twitterID() {
	$options = biz_vektor_get_theme_options();
	return $options['twitter'];
}

/*-------------------------------------------*/
/*	snsBtns _ display page
/*-------------------------------------------*/
function biz_vektor_snsBtns() {
	$options = biz_vektor_get_theme_options();
	$snsBtnsFront = $options['snsBtnsFront'];
	$snsBtnsPage = $options['snsBtnsPage'];
	$snsBtnsPost = $options['snsBtnsPost'];
	$snsBtnsInfo = $options['snsBtnsInfo'];
	$snsBtnsHidden = $options['snsBtnsHidden'];
	global $wp_query;
	$post = $wp_query->get_queried_object();
	$snsHiddenFlag = false;
	// $snsBtnsHidden divide "," and insert to $snsHiddens by array
	$snsHiddens = spliti(",",$snsBtnsHidden);
	foreach( $snsHiddens as $snsHidden ){
		if (get_the_ID() == $snsHidden) {
			$snsHiddenFlag = true ;
		}
	}
	wp_reset_query();
	if (!$snsHiddenFlag) {
		if (
			( is_front_page() && $snsBtnsFront ) ||
			( is_page() && $snsBtnsPage && !is_front_page() ) || 
			( get_post_type() == 'info' && $snsBtnsInfo ) || 
			( get_post_type() == 'post' && $snsBtnsPost ) 
		) {
			get_template_part('module_snsBtns');
		}
	}
}

/*-------------------------------------------*/
/*	facebook comment display page
/*-------------------------------------------*/
function biz_vektor_fbComments() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	$fbCommentHiddenFlag = false ;
	// is stored as an array to $snsHiddens to split with "," $snsBtnsHidden
	$fbCommentHiddens = spliti(",",$options['fbCommentsHidden']);
	foreach( $fbCommentHiddens as $fbCommentHidden ){
		if (get_the_ID() == $fbCommentHidden) {
			$fbCommentHiddenFlag = true ;
		}
	}
	wp_reset_query();
	if (!$fbCommentHiddenFlag) {
		if (
			( is_front_page() && $options['fbCommentsFront'] ) || 
			( is_page() && $options['fbCommentsPage'] && !is_front_page() ) || 
			( get_post_type() == 'info' && $options['fbCommentsInfo'] ) || 
			( get_post_type() == 'post' && $options['fbCommentsPost'] )
			) 
		{
			?>
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="2" data-width="640"></div>
			<style>
			.fb-comments,
			.fb-comments span,
			.fb-comments iframe[style] { width:100% !important; }
			</style>
			<?php
		}
	}
}

/*-------------------------------------------*/
/*	facebookLikeBox
/*-------------------------------------------*/
function biz_vektor_fbLikeBoxFront() {
	$options = biz_vektor_get_theme_options();
	if ( $options['fbLikeBoxFront'] ) {
		biz_vektor_fbLikeBox();
	}
}
function biz_vektor_fbLikeBoxSide() {
	$options = biz_vektor_get_theme_options();
	if ( $options['fbLikeBoxSide'] ) {
		biz_vektor_fbLikeBox();
	}
}
function biz_vektor_fbLikeBox() {
	$options = biz_vektor_get_theme_options();
	$fbLikeBoxStream = $options['fbLikeBoxStream'];
	$fbLikeBoxFace = $options['fbLikeBoxFace'];
	$fbLikeBoxHeight = $options['fbLikeBoxHeight'];

	if ($fbLikeBoxStream) { $fbLikeBoxStream = 'true'; } else { $fbLikeBoxStream = 'false'; }
	if ($fbLikeBoxFace) { $fbLikeBoxFace = 'true'; } else { $fbLikeBoxFace = 'false'; }
	if ($fbLikeBoxHeight) {
		$fbLikeBoxHeight = 'data-height="'.$fbLikeBoxHeight.'" ';
	}
?>
<div id="fb-like-box">
<div class="fb-like-box" data-href="<?php echo $options['fbLikeBoxURL'] ?>" data-width="640" <?php echo $fbLikeBoxHeight ?>data-show-faces="<?php echo $fbLikeBoxFace ?>" data-stream="<?php echo $fbLikeBoxStream ?>" data-header="true"></div>
<script type="text/javascript">
jQuery(document).ready(function(){
	likeBoxReSize();
});
jQuery(window).resize(function(){
	likeBoxReSize();
});
// When load page / window resize
function likeBoxReSize(){
	var element = jQuery('.fb-like-box').parent().width();
	jQuery('.fb-like-box').attr('data-width',element);
	jQuery('.fb-like-box').children('span:first').css({"width":element});
	jQuery('.fb-like-box span iframe.fb_ltr').css({"width":element});
}
</script>
</div>
<?php }


/*-------------------------------------------*/
/*	Print facebook Application ID 
/*-------------------------------------------*/
function biz_vektor_fbAppId () {
	$options = biz_vektor_get_theme_options();
	$fbAppId = $options['fbAppId'];
	echo $fbAppId;
}

/*-------------------------------------------*/
/*	Create keywords
/*-------------------------------------------*/
function biz_vektor_getHeadKeywords(){
	$options = biz_vektor_get_theme_options();
	$commonKeyWords = $options['commonKeyWords'];
	// get custom field
	$entryKeyWords = post_custom('metaKeyword');
	// display common keywords
	echo $commonKeyWords;
	// If common and individual keywords exist, print ','.
	if ($commonKeyWords && $entryKeyWords) {
		echo ',';
	}
	// print individual keywords
	echo $entryKeyWords;
}

/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
function biz_vektor_googleAnalytics(){
	$options = biz_vektor_get_theme_options();
	$gaID = $options['gaID'];
	$gaType = $options['gaType'];
	if ($gaID) {

		if ((!$gaType) || ($gaType == 'gaType_normal') || ($gaType == 'gaType_both')){ ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-<?php echo $gaID ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
		<?php }
		if (($gaType == 'gaType_both') || ($gaType == 'gaType_universal')){
			$domainUrl = site_url();
			$delete = array("http://", "https://");
			$domain = str_replace($delete, "", $domainUrl); ?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-<?php echo $gaID ?>', '<?php echo $domain ?>');
ga('send', 'pageview');
</script>
<?php
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

	// **** Don't change id name!
	$footerPowerd = '<div id="powerd">Powered by <a href="https://ja.wordpress.org/">WordPress</a> &amp; <a href="http://bizVektor.com" target="_blank" title="'.__('Free WordPress Theme BizVektor for business', 'biz-vektor').'">BizVektor Theme</a> by <a href="http://www.vektor-inc.co.jp" target="_blank" title="'._x('Vektor,Inc.', 'footer', 'biz-vektor').'">Vektor,Inc.</a> technology.</div>';
	// **** Dont change filter name! Oh I already know 'Powerd' id miss spell !!!!!
	$footerPowerd = apply_filters( 'footerPowerdCustom', $footerPowerd );
	echo $footerPowerd;
}

/*-------------------------------------------*/
/*	slide show
/*-------------------------------------------*/
function biz_vektor_slideExist () {
	$options = biz_vektor_get_theme_options();
	if (
		($options['slide1image'] && (!$options['slide1display'])) ||
		($options['slide2image'] && (!$options['slide2display'])) ||
		($options['slide3image'] && (!$options['slide3display'])) ||
		($options['slide4image'] && (!$options['slide4display'])) ||
		($options['slide5image'] && (!$options['slide5display']))
	){
	return true;
	}
}

function biz_vektor_slideBody(){
	$options = biz_vektor_get_theme_options();
	for ( $i = 1; $i <= 5 ; $i++){
		if ($options['slide'.$i.'image']) {
			if (!$options['slide'.$i.'display']) {
				print '<li>';
				if ($options['slide'.$i.'link']) {
					$blank = "";
					if ($options['slide'.$i.'blank']) : $blank = ' target="_blank"'; endif;
					print '<a href="'.$options['slide'.$i.'link'].'" class="slideFrame"'.$blank.'>';
				} else	{
					print '<span class="slideFrame">';
				}
				print '<img src="'.$options['slide'.$i.'image'].'" alt="'.$options['slide'.$i.'alt'].'" />';
				if ($options['slide'.$i.'link']) {
					print '</a>';
				} else {
					print '</span>';
				}
				print '</li>'."\n";
			}
		}
	}
}

/*-------------------------------------------*/
/*	Print option
/*-------------------------------------------*/
function bizVektorOptions($optionLabel) {
	$options = biz_vektor_get_theme_options();
	if ($options[$optionLabel] !='' ) { // If !='' that 0 true
		return $options[$optionLabel];
	} else {
		bizVektorOptions_default();
		global $bizVektorOptions_default;
		return $bizVektorOptions_default[$optionLabel];
	}
}
/*-------------------------------------------*/
/*	Set option default
/*-------------------------------------------*/
function bizVektorOptions_default() {
	global $bizVektorOptions_default;
	$bizVektorOptions_default = array(
		'postLabelName' => 'Blog',
		'infoLabelName' => 'Information',
		'rssLabelName' => 'Blog entries',
		'theme_style' => 'default',
		'pr1_title' => __('Rich theme options item', 'biz-vektor'),
		'pr1_description' => __('Not only this part, you can change from theme customizer and theme options screen various items.', 'biz-vektor'),
		'pr2_title' => __('Various designs available', 'biz-vektor'),
		'pr2_description' => __('BizVektor will allow you not only can change the color of the site, to switch to a different design.', 'biz-vektor'),
		'pr3_title' => __('Optimized for business web site', 'biz-vektor'),
		'pr3_description' => __('It features such as induction to the query and child page list template, a variety of functions essential to business.', 'biz-vektor'),
	);
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
add_action( 'wp_head','biz_vektor_fontStyle');
function biz_vektor_fontStyle(){
	$options = biz_vektor_get_theme_options();
	$font_face_serif = _x('serif', 'Font select', 'biz-vektor');
	$font_face_serif 		= apply_filters( 'font_face_serif_custom', $font_face_serif );
	$font_face_sans_serif = _x('Meiryo,Osaka,sans-serif', 'Font select', 'biz-vektor');
	$font_face_sans_serif 	= apply_filters( 'font_face_sans_serif_custom', $font_face_sans_serif );
	if ($options['font_title'] == 'serif') {
		$font_title_face = $font_face_serif ;
		$font_title_weight = 'bold';
	} else {
		$font_title_face = $font_face_sans_serif;
		$font_title_weight = 'lighter';
	}
	if ($options['font_menu'] == 'serif') {
		$font_menu_face = $font_face_serif ;
	} else {
		$font_menu_face = $font_face_sans_serif;
	}
?>
	<style type="text/css">
	/*-------------------------------------------*/
	/*	font
	/*-------------------------------------------*/
	h1,h2,h3,h4,h4,h5,h6,
	#header #site-title,
	#pageTitBnr #pageTitInner #pageTit,
	#content .leadTxt,
	#sideTower .localHead {font-family: <?php echo $font_title_face ?> ; }
	#pageTitBnr #pageTitInner #pageTit { font-weight:<?php echo $font_title_weight ?>; }
	#gMenu .menu li a strong {font-family: <?php echo $font_menu_face ?> ; }
	</style>
	<?php
}
/*-------------------------------------------*/
/*	Side menu hidden
/*-------------------------------------------*/
add_action( 'wp_head','biz_vektor_sideChildDisplay');
function biz_vektor_sideChildDisplay(){
	$options = biz_vektor_get_theme_options();
	if ( $options['side_child_display'] == 'side_child_hidden' ) { ?>
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