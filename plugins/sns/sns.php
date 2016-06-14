<?php

/*-------------------------------------------*/
/*	Add OGP
/*-------------------------------------------*/
/*	Add twitter card
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
/*	facebook twitter banner
/*-------------------------------------------*/
/*	admin bar のメニューに追加
/*-------------------------------------------*/
/*	アプリケーションIDなど基本パラメーターの出力
/*-------------------------------------------*/

require_once( get_template_directory() . '/plugins/sns/widget.sns.php' );

/*-------------------------------------------*/
/*	Add OGP
/*-------------------------------------------*/

add_filter('biz_vektor_is_plugin_sns', 'biz_vektor_sns_beacon', 10, 1 );
function biz_vektor_sns_beacon($flag){
	$flag = true;
	return $flag;
}

add_action('wp_head', 'biz_vektor_ogp' );
function biz_vektor_ogp() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_front_page()) {
		$linkUrl = home_url();
	} else if (is_single() || is_page()) {
		$linkUrl = get_permalink();
	} else if (is_category()) {
		global $cat;
		$linkUrl = get_category_link($cat);
	} else if (is_tax()) {
		$linkUrl = get_term_link($wp_query->query_vars['term'],$wp_query->query_vars['taxonomy']);
	} else {
		$linkUrl = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	}
	$bizVektorOGP = '<!-- [ '.get_biz_vektor_name().' OGP ] -->'."\n";
	$bizVektorOGP .= '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\n";
	$bizVektorOGP .= '<meta property="og:url" content="'.esc_url($linkUrl).'" />'."\n";
	if (isset($options['fbAppId'])){
		$bizVektorOGP = $bizVektorOGP.'<meta property="fb:app_id" content="'.$options['fbAppId'].'" />'."\n";
	}
	if (is_front_page() || is_home()) {
		$bizVektorOGP .= '<meta property="og:type" content="website" />'."\n";
		if (isset($options['ogpImage'])){
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
		} else if ( isset($options['ogpImage']) && $options['ogpImage'] ) {
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
		if( empty($metadescription) ) $metadescription = getHeadDescription();
		$bizVektorOGP .= '<meta property="og:title" content="'.get_the_title().' | '.get_bloginfo('name').'" />'."\n";
		$bizVektorOGP .= '<meta property="og:description" content="'.esc_html($metadescription).'" />'."\n";
	} else {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
	}
	$bizVektorOGP .= '<!-- [ /'.get_biz_vektor_name().' OGP ] -->'."\n";
	if ( isset($options['ogpTagDisplay']) && $options['ogpTagDisplay'] == 'ogp_off' ) {
		$bizVektorOGP = '';
	}
	$bizVektorOGP = apply_filters('bizVektorOGPCustom', $bizVektorOGP );
	echo $bizVektorOGP;
	//} // function_exist
}

// Add BizVektor SNS module style
add_action('wp_enqueue_scripts','bizVektorAddSnsStyle');
function bizVektorAddSnsStyle(){
	wp_enqueue_style('Biz_Vektor_plugin_sns_style', get_template_directory_uri().'/plugins/sns/style_bizvektor_sns.css', array('Biz_Vektor_Design_style'), false, 'all');
}

/*-------------------------------------------*/
/*	Add twitter card
/*-------------------------------------------*/
add_action('wp_head', 'biz_vektor_twitter_card' );
function biz_vektor_twitter_card() {
	get_template_part('plugins/sns/module_twitter_card');
}

/*-------------------------------------------*/
/*	snsBtns
/*-------------------------------------------*/
add_action('biz_vektor_fbComments', 'biz_vektor_fbComments');
function twitterID() {
	$biz_vektor_options = biz_vektor_get_theme_options();
	return $biz_vektor_options['twitter'];
}

/*-------------------------------------------*/
/*	snsBtns _ display page
/*-------------------------------------------*/
add_action('biz_vektor_snsBtns', 'biz_vektor_snsBtns');
function biz_vektor_snsBtns() {
	$biz_vektor_options = biz_vektor_get_theme_options();
	$options = $biz_vektor_options;
	$snsBtnsFront = ( isset($options['snsBtnsFront']) ) ? $options['snsBtnsFront'] : '';
	$snsBtnsPage = ( isset($options['snsBtnsPage']) ) ? $options['snsBtnsPage'] : '';
	$snsBtnsPost = ( isset($options['snsBtnsPost']) ) ? $options['snsBtnsPost'] : '';
	$snsBtnsInfo = ( isset($options['snsBtnsInfo']) ) ? $options['snsBtnsInfo'] : '';
	$snsBtnsHidden = ( isset($options['snsBtnsHidden']) ) ? $options['snsBtnsHidden'] : '';
	global $wp_query;
	$post = $wp_query->get_queried_object();
	$snsHiddenFlag = false;
	// $snsBtnsHidden divide "," and insert to $snsHiddens by array
	$snsHiddens = explode(",",$snsBtnsHidden);
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
add_action('biz_vektor_fbComments', 'biz_vektor_fbComments');
function biz_vektor_fbComments() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	$fbCommentHiddenFlag = false ;
	// is stored as an array to $snsHiddens to split with "," $snsBtnsHidden

	$fbCommentHiddens = ( isset($options['fbCommentsHidden']) ) ? explode(",",$options['fbCommentsHidden']) : '';
	if ($fbCommentHiddens) :
		foreach( $fbCommentHiddens as $fbCommentHidden ){
			if (get_the_ID() == $fbCommentHidden) {
				$fbCommentHiddenFlag = true ;
			}
		}
	endif;
	// wp_reset_query();
	if (!$fbCommentHiddenFlag) {
		if (
			( is_front_page() && isset($options['fbCommentsFront']) && $options['fbCommentsFront'] ) || 
			( is_page() && isset($options['fbCommentsPage']) && $options['fbCommentsPage'] && !is_front_page() ) || 
			( get_post_type() == 'info' && isset($options['fbCommentsInfo']) && $options['fbCommentsInfo']) || 
			( get_post_type() == 'post' && isset($options['fbCommentsPost']) && $options['fbCommentsPost'])
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

// biz_vektor_fbLikeBoxFront は Global Edition で使われているから残しているだけ。
add_action('biz_vektor_fbLikeBoxFront', 'biz_vektor_fbLikeBox');
add_action('biz_vektor_fbLikeBoxDisplay', 'biz_vektor_fbLikeBox');

add_action('biz_vektor_fbLikeBox', 'biz_vektor_fbLikeBox');
function biz_vektor_fbLikeBox() {
	// 変数を取得
	$biz_vektor_options = biz_vektor_get_theme_options();
	$postType = get_post_type();

	// LikeBoxの要素指定
	// php 初心者への可読性も踏まえてむやみに１行にしないよう注意
	//
	// それならちゃんと{}を使ったほうが・・・

	if ( isset($biz_vektor_options['fbLikeBoxStream']) && $biz_vektor_options['fbLikeBoxStream'] ) :
	  	$biz_vektor_options['fbLikeBoxStream'] = 'true' ;
	else :
		$biz_vektor_options['fbLikeBoxStream'] = 'false' ;
	endif;

	if ( isset($biz_vektor_options['fbLikeBoxFace']) && $biz_vektor_options['fbLikeBoxFace'] ) :
	  	$biz_vektor_options['fbLikeBoxFace'] = 'true' ;
	else :
		$biz_vektor_options['fbLikeBoxFace'] = 'false' ;
	endif;

	if ( isset($biz_vektor_options['fbLikeBoxHideCover']) && $biz_vektor_options['fbLikeBoxHideCover'] ) :
	  	$biz_vektor_options['fbLikeBoxHideCover'] = 'true' ;
	else :
		$biz_vektor_options['fbLikeBoxHideCover'] = 'false' ;
	endif;

	if ( isset($biz_vektor_options['fbLikeBoxHeight']) && $biz_vektor_options['fbLikeBoxHeight'] ) :
	  	$fbLikeBoxHeight = 'data-height="'.esc_attr( $biz_vektor_options['fbLikeBoxHeight'] ).'" ';
	else :
	 	$fbLikeBoxHeight = '';
	endif;

	// 表示の条件指定
	if (
		( is_front_page() && isset($biz_vektor_options['fbLikeBoxFront']) && $biz_vektor_options['fbLikeBoxFront'] ) || 
		( is_page() && isset($biz_vektor_options['fbLikeBoxPage']) && $biz_vektor_options['fbLikeBoxPage'] ) || 
		( is_single() && ($postType == 'post') && isset($biz_vektor_options['fbLikeBoxPost']) && $biz_vektor_options['fbLikeBoxPost'] ) || 
		( is_single() && ($postType == 'info') && isset($biz_vektor_options['fbLikeBoxInfo']) && $biz_vektor_options['fbLikeBoxInfo'] ) 
	) : ?>

<div id="fb-like-box">
	<div class="fb-page fb-like-box" data-href="<?php echo $biz_vektor_options['fbLikeBoxURL'] ?>" data-width="500" <?php echo $fbLikeBoxHeight; ?>data-hide-cover="<?php echo $biz_vektor_options['fbLikeBoxHideCover']; ?>" data-show-facepile="<?php echo $biz_vektor_options['fbLikeBoxFace']; ?>" data-show-posts="<?php echo $biz_vektor_options['fbLikeBoxStream']; ?>">
	<div class="fb-xfbml-parse-ignore">
		<blockquote cite="<?php echo $biz_vektor_options['fbLikeBoxURL'] ?>">
		<a href="<?php echo $biz_vektor_options['fbLikeBoxURL'] ?>">Facebook page</a>
		</blockquote>
	</div>
</div>
</div>
<?php endif; 
}

/*-------------------------------------------*/
/*	Print facebook Application ID 
/*-------------------------------------------*/
add_action('biz_vektor_fbAppId', 'biz_vektor_fbAppId');
function biz_vektor_fbAppId () {
	$biz_vektor_options = biz_vektor_get_theme_options();
	$options = $biz_vektor_options;
	$fbAppId = $options['fbAppId'];
	echo $fbAppId;
}

/*-------------------------------------------*/
/*	facebook twitter banner
/*-------------------------------------------*/
add_action('biz_vektor_snsBnrs', 'biz_vektor_snsBnrs');
function biz_vektor_snsBnrs() {
	$options = biz_vektor_get_theme_options();

	if (isset($options['facebook'])) : $facebook = $options['facebook'] ; else : $facebook = ''; endif ;
	if (isset($options['twitter'])) : $twitter = $options['twitter'] ; else : $twitter = ''; endif ;
	if ($facebook || $twitter) {
		$snsBnrs = '<ul id="snsBnr">';
		if ($facebook) {
			$snsBnrs .= '<li><a href="'.esc_url($facebook).'" target="_blank"><img src="'.get_template_directory_uri().'/images/bnr_facebook.png" alt="facebook" /></a></li>'."\n";
		}
		if ($twitter) {
			$snsBnrs .= '<li><a href="https://twitter.com/#!/'.esc_html($twitter).'" target="_blank"><img src="'.get_template_directory_uri().'/images/bnr_twitter.png" alt="twitter" /></a></li>'."\n";
		}
		$snsBnrs .= '</ul>';
		echo $snsBnrs;
	}
}


add_filter('biz_vektor_theme_options_validate', 'biz_vektor_sns_validate', 19, 3);
function biz_vektor_sns_validate($output, $input, $defaults){

	// SNS
	$output['fbAppId']                = $input['fbAppId'];
	$output['fbAdminId']              = $input['fbAdminId'];
	$output['twitter']                = $input['twitter'];
	$output['facebook']               = $input['facebook'];
	$output['ogpImage']               = (preg_match("/^.+\.(jp(e|)g|png|gif|bmp)$/i", $input['ogpImage']))? $input['ogpImage'] : '';
	$output['snsBtnsFront']           = (isset($input['snsBtnsFront']) && $input['snsBtnsFront'] == 'false')? 'false' : '';
	$output['snsBtnsPage']            = (isset($input['snsBtnsPage']) && $input['snsBtnsPage'] == 'false')? 'false' : '';
	$output['snsBtnsPost']            = (isset($input['snsBtnsPost']) && $input['snsBtnsPost'] == 'false')? 'false' : '';
	$output['snsBtnsInfo']            = (isset($input['snsBtnsInfo']) && $input['snsBtnsInfo'] == 'false')? 'false' : '';
	$output['snsBtnsHidden']          = $input['snsBtnsHidden'];
	$output['fbCommentsFront']        = (isset($input['fbCommentsFront']) && $input['fbCommentsFront'] == 'false')? 'false' : '';
	$output['fbCommentsPage']         = (isset($input['fbCommentsPage']) && $input['fbCommentsPage'] == 'false')? 'false' : '';
	$output['fbCommentsPost']         = (isset($input['fbCommentsPost']) && $input['fbCommentsPost'] == 'false')? 'false' : '';
	$output['fbCommentsInfo']         = (isset($input['fbCommentsInfo']) && $input['fbCommentsInfo'] == 'false')? 'false' : '';
	$output['fbCommentsHidden']       = $input['fbCommentsHidden'];
	$output['fbLikeBoxFront']         = (isset($input['fbLikeBoxFront']) && $input['fbLikeBoxFront'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxPage']          = (isset($input['fbLikeBoxPage']) && $input['fbLikeBoxPage'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxPost']          = (isset($input['fbLikeBoxPost']) && $input['fbLikeBoxPost'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxInfo']          = (isset($input['fbLikeBoxInfo']) && $input['fbLikeBoxInfo'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxURL']	          = $input['fbLikeBoxURL'];
	$output['fbLikeBoxStream']        = (isset($input['fbLikeBoxStream']) && $input['fbLikeBoxStream'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxFace']          = (isset($input['fbLikeBoxFace']) && $input['fbLikeBoxFace'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxHideCover']     = (isset($input['fbLikeBoxHideCover']) && $input['fbLikeBoxHideCover'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxHeight']        = $input['fbLikeBoxHeight'];
	$output['ogpTagDisplay']          = $input['ogpTagDisplay'];
	$output['ogpTagDisplay']          = (!isset($input['ogpTagDisplay']))? 'ogp_on' : $input['ogpTagDisplay'] ;

	return $output;
}

add_filter('biz_vektor_default_options', 'biz_vektor_sns_default_option');
function biz_vektor_sns_default_option($original_options){

	$options = array(
		'fbAppId'              => '',
		'fbAdminId'            => '',
		'twitter'              => '',
		'facebook'             => '',
		'ogpImage'             => '',
		'snsBtnsFront'         => '',
		'snsBtnsPage'          => '',
		'snsBtnsPost'          => '',
		'snsBtnsInfo'          => '',
		'snsBtnsHidden'        => '',
		'fbCommentsFront'      => '',
		'fbCommentsPage'       => '',
		'fbCommentsPost'       => '',
		'fbCommentsInfo'       => '',
		'fbCommentsHidden'     => '',
		'fbLikeBoxFront'       => '',
		'fbLikeBoxPage'        => '',
		'fbLikeBoxPost'        => '',
		'fbLikeBoxInfo'        => '',
		'fbLikeBoxURL'         => '',
		'fbLikeBoxStream'      => '',
		'fbLikeBoxFace'        => '',
		'fbLikeBoxHideCover'   => '',
		'fbLikeBoxHeight'      => '',
		'ogpTagDisplay'        => 'ogp_on',
	);

	return array_merge($original_options, $options);
}

add_action('biz_vektor_options_nav_tab', 'biz_vektor_sns_options_nav', 19);
function biz_vektor_sns_options_nav(){?>
    <li id="btn_snsSetting"><a href="#snsSetting"><?php echo _x( 'SNS', 'BizVektor option tab label', 'biz-vektor' ); ?></a></li>
<?php }

add_action('biz_vektor_extra_module_config', 'biz_vektor_sns_config');
function biz_vektor_sns_config(){
$options = biz_bektor_option_validate();
$biz_vektor_name = get_biz_vektor_name();

/*-------------------------------------------*/
/*	SNS
/*-------------------------------------------*/
?>
<div id="snsSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3><?php _e('Social media', 'biz-vektor'); ?></h3>
<?php _e('If you are unsure, you can leave for later.', 'biz-vektor'); ?>
<table class="form-table">
<tr>
<th>facebook</th>
<td><?php _e('If you wish to link to a personal account or a Facebook page  banner will be displayed if you enter<label> the URL.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[facebook]" id="facebook" value="<?php echo esc_attr( $options['facebook'] ); ?>" class="width-600" /><br/>
<span><?php _e('ex) ', 'biz-vektor') ;?>https://www.facebook.com/FacebookJapan</span>
</td>
</tr>
<!-- facebook application ID -->
<tr>
<th><?php _e('facebook application ID', 'biz-vektor'); ?></th>
<td><input type="text" name="biz_vektor_theme_options[fbAppId]" id="fbAppId" value="<?php echo esc_attr( $options['fbAppId'] ); ?>" />
<span>[ <a href="https://developers.facebook.com/apps" target="_blank">&raquo; <?php _e('I will check and get the application ID', 'biz-vektor'); ?></a> ]</span><br />
<?php _e('* If an application ID is not specified, neither a Like button nor the comment field displays and operates correctly.', 'biz-vektor'); ?><br />
<?php _e('Please search for terms as [get Facebook application ID] If you do not know much about how to get application ID for Facebook.', 'biz-vektor'); ?>
</td>
</tr>
<!-- facebook user ID -->
<tr>
<th><?php _e('Facebook user ID (optional)', 'biz-vektor'); ?></th>
<td><?php _e('Please enter the Facebook user ID of the administrator.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[fbAdminId]" id="fbAdminId" value="<?php echo esc_attr( $options['fbAdminId'] ); ?>" class="width-600" /><br />
<?php _e('* It is not the application ID of the Facebook page.', 'biz-vektor'); ?><br />
<?php _e('You can see the personal Facebook ID when you access the following url http://graph.facebook.com/(own url name(example: TheStig )).', 'biz-vektor'); ?><br />
<?php _e('Please search for terms as [find facebook user ID] if you are still not sure.', 'biz-vektor'); ?>
</td>
</tr>
<!-- twitter -->
<tr>
<th><?php _e('twitter account', 'biz-vektor'); ?></th>
<td><?php _e('If you would like to link to a Twitter account, banner will be displayed if you enter the account name.', 'biz-vektor'); ?><br />
@<input type="text" name="biz_vektor_theme_options[twitter]" id="twitter" value="<?php echo esc_attr( $options['twitter'] ); ?>" /><br />
<?php $twitter_widget = '<a href="'.get_admin_url().'widgets.php" target="_blank">'.__('widget', 'biz-vektor').'</a>';
printf(__('* If you prefer to use Twitter widgets etc, this can be left blank, paste the source code into a [text] %s here.', 'biz-vektor'),$twitter_widget);
?>
</td>
</tr>
<!-- OGP -->
<tr>
<th><?php _e('OGP default image', 'biz-vektor'); ?></th>
<td><?php _e('If, for example someone pressed the Facebook [Like] button, this is the image that appears on the Facebook timeline.', 'biz-vektor'); ?><br />
<?php _e('If a featured image is specified for the page, it takes precedence.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[ogpImage]" id="ogpImage" value="<?php echo esc_attr( $options['ogpImage'] ); ?>" class="width-300" /> 
<button id="media_ogpImage" class="media_btn"><?php _e('Select an image', 'biz-vektor'); ?></button><br />
<span><?php _e('ex) ', 'biz-vektor') ;?>http://www.vektor-inc.co.jp/images/ogpImage.png</span><br />
<?php _e('* Picture sizes are 300x300 pixels or more and picture ratio 16:9 is recommended.', 'biz-vektor'); ?>
</td>
</tr>
<!-- Social buttons -->
<tr>
<th><?php _e('Social buttons', 'biz-vektor'); ?></th>
<td><?php _e('Please check the type of page that displays the social button.', 'biz-vektor'); ?>
<ul>
<li><label><input type="checkbox" name="biz_vektor_theme_options[snsBtnsFront]" id="snsBtnsFront" value="false" <?php if ($options['snsBtnsFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[snsBtnsPage]" id="snsBtnsPage" value="false" <?php if ($options['snsBtnsPage']) {?> checked<?php } ?>> 
	<?php _ex('Page', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[snsBtnsPost]" id="snsBtnsPost" value="false" <?php if ($options['snsBtnsPost']) {?> checked<?php } ?>> 
	<?php echo esc_html($options['postLabelName']); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[snsBtnsInfo]" id="snsBtnsInfo" value="false" <?php if ($options['snsBtnsInfo']) {?> checked<?php } ?>> 
	<?php echo esc_html($options['infoLabelName']); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></label></li>
</ul>
<p><?php _e('Within the type of page that is checked, if there is a particular pa<label>ge you do not wish to display, enter the Page ID. If multiple pages, please separate by commas.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[snsBtnsHidden]" value="<?php echo esc_attr( $options['snsBtnsHidden'] ); ?>" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>1,3,7</p>
</td>
</tr>
<!-- facebook comment -->
<tr>
<th><?php _e('facebook comments box', 'biz-vektor'); ?></th>
<td><?php _e('Please check the type of the page to display Facebook comments.', 'biz-vektor'); ?>
<ul>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbCommentsFront]" id="fbCommentsFront" value="false" <?php if ($options['fbCommentsFront']) {?> checked<?php } ?>>
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPage]" id="fbCommentsPage" value="false" <?php if ($options['fbCommentsPage']) {?> checked<?php } ?>> 
	<?php _ex('Page', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPost]" id="fbCommentsPost" value="false" <?php if ($options['fbCommentsPost']) {?> checked<?php } ?>> 
	<?php echo esc_html($options['postLabelName']); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbCommentsInfo]" id="fbCommentsInfo" value="false" <?php if ($options['fbCommentsInfo']) {?> checked<?php } ?>> 
	<?php echo esc_html($options['infoLabelName']); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></label></li>
</ul>
<p><?php _e('Within the type of page that is checked, if there is a particular page you do not wish to display, enter the Page ID. If multiple pages, please separate by commas.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[fbCommentsHidden]" value="<?php echo esc_attr( $options['fbCommentsHidden'] ); ?>" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>1,3,7</p>
</td>
</tr>
<!-- facebook LikeBox -->
<tr>
<th>facebook LikeBox</th>
<td><?php _e('If you wish to use Facebook LikeBox, please check the location.', 'biz-vektor'); ?><br />
<?php _e('* Please be sure to set Facebook application ID.', 'biz-vektor'); ?>
<ul>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFront]" id="fbLikeBoxFront" value="false" <?php if ($options['fbLikeBoxFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxPage]" id="fbLikeBoxPage" value="false" <?php if ($options['fbLikeBoxPage']) {?> checked<?php } ?>> 
	<?php _ex('Page', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxPost]" id="fbLikeBoxPost" value="false" <?php if ($options['fbLikeBoxPost']) {?> checked<?php } ?>> 
	<?php echo esc_html($options['postLabelName']); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></label></li>
<li><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxInfo]" id="fbLikeBoxInfo" value="false" <?php if ($options['fbLikeBoxInfo']) {?> checked<?php } ?>>
	<?php echo esc_html($options['infoLabelName']); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></label></li>
</ul>
<dl>
<dt><?php _e('URL of the Facebook page.', 'biz-vektor'); ?></dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxURL]" id="fbLikeBoxURL" value="<?php echo esc_attr( $options['fbLikeBoxURL'] ); ?>" class="width-500" /><br />
<span><?php _e('ex) ', 'biz-vektor') ;?>https://www.facebook.com/bizvektor</span></dd>
<dt><?php _e('Display stream', 'biz-vektor'); ?></dt>
<dd><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxStream]" id="fbLikeBoxStream" value="false" <?php if ($options['fbLikeBoxStream']) {?> checked<?php } ?>> <?php _e('Display', 'biz-vektor'); ?></label></dd>
<dt><?php _e('Display faces', 'biz-vektor'); ?></dt>
<dd><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFace]" id="fbLikeBoxFace" value="false" <?php echo ($options['fbLikeBoxFace']=='false')? "checked ":""; ?>> <?php _e('Display', 'biz-vektor'); ?></label></dd>
<dt><?php _e('Hide Cover Photo', 'biz-vektor'); ?></dt>
<dd><label><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxHideCover]" id="fbLikeBoxHideCover" value="false" <?php echo ($options['fbLikeBoxHideCover']=='false')? "checked ":""; ?>> <?php _e('Hide', 'biz-vektor'); ?></label></dd>
<dt><?php _e('Height of LikeBox', 'biz-vektor'); ?></dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxHeight]" id="fbLikeBoxHeight" value="<?php echo esc_attr( $options['fbLikeBoxHeight'] ); ?>" class="width-100" style="text-align:right;" />
px</dd>
</dl>
</td>
</tr>
<!-- OGP hidden -->
<tr>
<th><?php _e('Do not output the OGP', 'biz-vektor'); ?></th>
<td>
<p><?php printf(__('If other plug-ins are used for the OGP, do not output the OGP using %s.', 'biz-vektor'),$biz_vektor_name); ?></p>
<label><input type="radio" name="biz_vektor_theme_options[ogpTagDisplay]" value="ogp_on" <?php echo ($options['ogpTagDisplay']=='ogp_on')? 'checked':''; ?>> <?php printf( __('I want to output the OGP tags using %s', 'biz-vektor'),$biz_vektor_name ); ?></label><br />
<label><input type="radio" name="biz_vektor_theme_options[ogpTagDisplay]" value="ogp_off" <?php echo ($options['ogpTagDisplay']!='ogp_on')? 'checked':'';?>> <?php printf( __('Do not output OGP tags using %s', 'biz-vektor'),$biz_vektor_name ); ?></label><br />
</td>
</tr>
<!-- twitter card -->
<tr>
<th><?php printf( __( '%1$s Settings', 'biz-vektor' ), __( 'Twitter Card','biz-vektor' ) ); ?></th>
<td>
<p>
* <?php printf( __( '%1$s related tags won\'t display if you don\'t fill a Twitter account above.', 'biz-vektor' ), __( 'Twitter Card','biz-vektor' ) ) ?><br />
* <?php printf( __( 'Image used for %1$s is the Featured Image set for each post. In case there is no Featured Image, the default OGP image will be used.', 'biz-vektor' ), __( 'Twitter Card','biz-vektor' ) ); ?>
</p>
</td>
</tr>
</table>
<?php submit_button(); ?>
</div>
<?php
}

/*-------------------------------------------*/
/*	admin bar のメニューに追加
/*-------------------------------------------*/
add_action('biz_vektor_admin_bar_init', 'biz_vektor_sns_admin_bar_init');
function biz_vektor_sns_admin_bar_init(){
	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
		// 'parent' => 'Theme options',
		'parent' => 'bizvektor_theme_setting',
		'id' => 'SNS',
		'title' => _x( 'SNS settings', 'BizVektor admin header menu', 'biz-vektor' ),
		'href' => get_admin_url().'themes.php?page=theme_options#snsSetting',
	));
}

/*-------------------------------------------*/
/*	アプリケーションIDなど基本パラメーターの出力
/*-------------------------------------------*/
add_action('biz_vektor_sns_body', 'biz_vektor_sns_header_output');
function biz_vektor_sns_header_output(){
	$biz_vektor_options = biz_vektor_get_theme_options();
?>
<div id="fb-root"></div>
<?php
if (isset($biz_vektor_options['fbAppId']) && $biz_vektor_options['fbAppId']) :
?>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.3&appId=<?php echo esc_html($biz_vektor_options['fbAppId']); ?>";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<?php endif;
}