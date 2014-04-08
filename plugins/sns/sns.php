<?php

/*-------------------------------------------*/
/*	Add OGP
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

/*-------------------------------------------*/
/*	Add OGP
/*-------------------------------------------*/
add_action('wp_head', 'biz_vektor_ogp' );
function biz_vektor_ogp() {
	//if ( function_exists('biz_vektor_get_theme_options')) {
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
	$bizVektorOGP = '<!-- [ BizVektorOGP ] -->'."\n";
	$bizVektorOGP .= '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\n";
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
	$bizVektorOGP .= '<!-- [ /BizVektorOGP ] -->'."\n";
	if ( isset($options['ogpTagDisplay']) && $options['ogpTagDisplay'] == 'ogp_off' ) {
		$bizVektorOGP = '';
	}
	$bizVektorOGP = apply_filters('bizVektorOGPCustom', $bizVektorOGP );
	echo $bizVektorOGP;
	//} // function_exist
}

// Add BizVektor SNS module style
add_action('wp_head','bizVektorAddSnsStyle');
function bizVektorAddSnsStyle(){
	$snsStyle = '<link rel="stylesheet" id="bizvektor-sns-css"  href="'.get_template_directory_uri().'/plugins/sns/style_bizvektor_sns.css" type="text/css" media="all" />'."\n";
	$snsStyle = apply_filters('snsStyleCustom', $snsStyle );
	echo $snsStyle;
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
			get_template_part('plugins/sns/module_snsBtns');
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