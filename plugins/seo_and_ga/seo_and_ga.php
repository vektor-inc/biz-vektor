<?php
/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
/*		初期値設定追加
/*-------------------------------------------*/
/*		Admin page _ Add custom field of keywords
/*-------------------------------------------*/
/*		head _ meta にキーワード出力
/*-------------------------------------------*/
/*		head _ GAタグ出力
/*-------------------------------------------*/

add_filter('biz_vektor_is_plugin_seo', 'biz_vektor_seo_beacon', 10, 1 );
function biz_vektor_seo_beacon($flag){
	$flag = true;
	return $flag;
}

/*-------------------------------------------*/
/*		初期値設定追加
/*-------------------------------------------*/
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

/*-------------------------------------------*/
/*		Admin page _ Add custom field of keywords
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
  $theme_option_seo_link = '<a href="'.get_admin_url().'/themes.php?page=theme_options#seoSetting" target="_blank">'._x('SEO Setting','link to seo setting', 'biz-vektor').'</a>';
  sprintf(__('* keywords common to the entire site can be set from %s.', 'biz-vektor'),$theme_option_seo_link);
  echo '</p>';
}

function save_custom_field_metaKeyword($post_id){
	$metaKeyword = isset($_POST['noncename_custom_field_metaKeyword']) ? htmlspecialchars($_POST['noncename_custom_field_metaKeyword']) : null;
	if(!wp_verify_nonce($metaKeyword, plugin_basename(__FILE__))){
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
/*		head _ meta にキーワード出力
/*-------------------------------------------*/
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

/*-------------------------------------------*/
/*		head _ GAタグ出力
/*-------------------------------------------*/
add_action('wp_head', 'biz_vektor_googleAnalytics', 10000 );
function biz_vektor_googleAnalytics(){
	$biz_vektor_options = biz_vektor_get_theme_options();
	$gaType = (isset($biz_vektor_options['gaType'])) ? $biz_vektor_options['gaType'] : '';
	if (isset($biz_vektor_options['gaID']) && $biz_vektor_options['gaID']) {
		if ((!$gaType) || ($gaType == 'gaType_normal') || ($gaType == 'gaType_both')){ ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-<?php echo $biz_vektor_options['gaID'] ?>']);
  _gaq.push(['_trackPageview']);
  <?php do_action('biz_vektor_seo_extend_ga_norm'); ?>
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
<?php do_action('biz_vektor_seo_extend_ga_univ'); ?>
</script>
<?php
		}
	}
    else{ do_action('biz_vektor_seo_extend_ga_none'); }
}