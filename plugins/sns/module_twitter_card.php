<?php
global $biz_vektor_options;
// url
$linkUrl = (is_front_page()) ? home_url():get_permalink();
// image
if ( ( is_single() || is_page() ) && has_post_thumbnail() ) {
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'large', true);
	$card_image_url = $image_url[0];
} else {
	$card_image_url = (isset($biz_vektor_options['ogpImage'])) ? $biz_vektor_options['ogpImage'] : '';
} 
// domain
preg_match( '/https?:\/\/(.+?)\//i', admin_url(), $match );
// image size
if ( isset($biz_vektor_options['twitter']) && $biz_vektor_options['twitter'] && $card_image_url ) :?>
<!-- twitter card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:description" content="<?php (function_exists( "getHeadDescription" ))? getHeadDescription(): ''; ?>">
<meta name="twitter:title" content="<?php echo getHeadTitle(); ?>">
<meta name="twitter:url" content="<?php echo $linkUrl ?>">
<meta name="twitter:image" content="<?php echo esc_url($card_image_url);?>">
<meta name="twitter:domain" content="<?php echo $match[1] ?>">
<meta name="twitter:site" content="@<?php echo $biz_vektor_options['twitter'];?>">
<!-- /twitter card -->
<?php endif; ?>