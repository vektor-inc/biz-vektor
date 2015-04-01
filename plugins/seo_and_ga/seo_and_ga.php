<?php
/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
add_filter('biz_vektor_is_plugin_seo', 'biz_vektor_seo_beacon', 10, 1 );
function biz_vektor_seo_beacon($flag){
	$flag = true;
	return $flag;
}

add_action('wp_head', 'biz_vektor_googleAnalytics', 10000 );
function biz_vektor_googleAnalytics(){
	global $biz_vektor_options;
	$gaType = (isset($biz_vektor_options['gaType'])) ? $biz_vektor_options['gaType'] : '';
	if (isset($biz_vektor_options['gaID']) && $biz_vektor_options['gaID']) {
		if ((!$gaType) || ($gaType == 'gaType_normal') || ($gaType == 'gaType_both')){ ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-<?php echo $biz_vektor_options['gaID'] ?>']);
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
ga('create', 'UA-<?php echo $biz_vektor_options['gaID'] ?>', '<?php echo $domain ?>');
ga('send', 'pageview');
</script>
<?php
		}
	}
}

add_filter('biz_vektor_default_options', 'biz_vektor_seo_default_option');
function biz_vektor_seo_default_option($original_options){
	$options = array(
		'topTitle'             => '',
		'commonKeyWords'       => '',
		'gaID'                 => '',
		'gaType'               => 'gaType_normal',
		);
	return array_merge($original_options, $options);
}

add_filter('biz_vektor_theme_options_validate', 'biz_vektor_seo_validate', 10, 2);
function biz_vektor_seo_validate($output, $input){
	// SEO 
	$output['topTitle']               = $input['topTitle'];
	$output['commonKeyWords']         = $input['commonKeyWords'];
	$output['gaID']                   = preg_replace('/^[ 　]*(.*)$/', "$1", $input['gaID']);
	$output['gaType']                 = $input['gaType'];
	return $output;
}

add_action('wp_head', 'biz_vektor_seo_set_HeadKeywords', 1);
function biz_vektor_seo_set_HeadKeywords(){
	$options = biz_bektor_option_validate();
	$commonKeyWords = $options['commonKeyWords'];
	// get custom field
	$entryKeyWords = post_custom('metaKeyword');
	$keywords = array();
	if($commonKeyWords){ $keywords[] = $commonKeyWords; }
	if($entryKeyWords){  $keywords[] = $entryKeyWords;  }
	$key = implode( ',', $keywords);
	// print individual keywords
	if(!$key){ return; }
	echo '<meta name="keywords" content="' . $key. '" />'."\n";
}