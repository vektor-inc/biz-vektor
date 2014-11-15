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
/*	WP_Widget_snsBnrs Class
/*-------------------------------------------*/
/*	WP_Widget_fbLikeBox Class
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Add OGP
/*-------------------------------------------*/
add_action('wp_head', 'biz_vektor_ogp' );
function biz_vektor_ogp() {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_front_page()) {
		$linkUrl = home_url();
	} else if (is_single() || is_page()) {
		$linkUrl = get_permalink();
	} else {
		$linkUrl = get_permalink();
	}
	$bizVektorOGP = '<!-- [ '.get_biz_vektor_name().' OGP ] -->'."\n";
	$bizVektorOGP .= '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\n";
	$bizVektorOGP .= '<meta property="og:url" content="'.$linkUrl.'" />'."\n";
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
		$bizVektorOGP .= '<meta property="og:title" content="'.get_the_title().' | '.get_bloginfo('name').'" />'."\n";
		$bizVektorOGP .= '<meta property="og:description" content="'.$metadescription.'" />'."\n";
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
function twitterID() {
	global $biz_vektor_options;
	return $biz_vektor_options['twitter'];
}

/*-------------------------------------------*/
/*	snsBtns _ display page
/*-------------------------------------------*/
function biz_vektor_snsBtns() {
	global $biz_vektor_options;
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
function biz_vektor_fbComments() {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
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
function biz_vektor_fbLikeBoxFront() {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
	if ( isset($options['fbLikeBoxFront']) && $options['fbLikeBoxFront'] ) {
		biz_vektor_fbLikeBox();
	}
}
function biz_vektor_fbLikeBoxSide() {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
	if ( isset($options['fbLikeBoxSide']) && $options['fbLikeBoxSide'] ) {
		biz_vektor_fbLikeBox();
	}
}
function biz_vektor_fbLikeBox() {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
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
</div>
<?php }

/*-------------------------------------------*/
/*	Print facebook Application ID 
/*-------------------------------------------*/
function biz_vektor_fbAppId () {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
	$fbAppId = $options['fbAppId'];
	echo $fbAppId;
}

/*-------------------------------------------*/
/*	facebook twitter banner
/*-------------------------------------------*/
function biz_vektor_snsBnrs() {
	global $biz_vektor_options;
	$options = $biz_vektor_options;
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

/*-------------------------------------------*/
/*	WP_Widget_snsBnrs Class
/*-------------------------------------------*/

class WP_Widget_snsBnrs extends WP_Widget {
	/** constructor */
	function WP_Widget_snsBnrs() {
		$widget_ops = array(
			'classname' => 'WP_Widget_snsBnrs',
			'description' => __( '*　It is necessary to set the Theme options page.', 'biz-vektor' ),
		);
		$widget_name = biz_vektor_get_short_name().'_'.__('facebook&twitter banner', 'biz-vektor');
		$this->WP_Widget('snsBnrs', $widget_name, $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		if (function_exists('biz_vektor_snsBnrs')) biz_vektor_snsBnrs();
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
	}

} // class WP_Widget_snsBnrs

// register WP_Widget_snsBnrs widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_snsBnrs");'));

/*-------------------------------------------*/
/*	WP_Widget_fbLikeBox Class
/*-------------------------------------------*/

class WP_Widget_fbLikeBox extends WP_Widget {
	/** constructor */
	function WP_Widget_fbLikeBox() {
		$widget_ops = array(
			'classname' => 'WP_Widget_fbLikeBox',
			'description' => __( '*　It is necessary to set the Theme options page.', 'biz-vektor' ),
		);
		$widget_name = biz_vektor_get_short_name().'_facebook Like Box';
		$this->WP_Widget('fbLikeBox', $widget_name, $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		if (function_exists('biz_vektor_fbLikeBoxSide')) biz_vektor_fbLikeBoxSide();
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {	}

} // class WP_Widget_fbLikeBox

// register WP_Widget_fbLikeBox widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_fbLikeBox");'));