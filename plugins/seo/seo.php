<?php
/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
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

add_action('biz_vektor_options_nav_tab', 'biz_vektor_seo_options_nav', 10);
function biz_vektor_seo_options_nav(){?>
    <li id="btn_seoSetting"><a href="#seoSetting">SEO & GA</a></li>
<?php }

/*-------------------------------------------*/
/*	SEO and Google Analytics Setting
/*-------------------------------------------*/
add_action('biz_vektor_extra_module_config', 'biz_vektor_seo_render_edit', 10);

function biz_vektor_seo_render_edit(){
	$options = biz_vektor_get_theme_options();
	$biz_vektor_name = get_biz_vektor_name();

?>
<div id="seoSetting" class="sectionBox">
<?php get_template_part('inc/views/nav'); ?>
<h3><?php _e('SEO and Google Analytics Settings', 'biz-vektor'); ?></h3>
<table class="form-table">
<tr>
<th><?php _e('&lt;title&gt; tag of homepage', 'biz-vektor'); ?></th>
<td>
<p>
<?php
$sitetitle_link = '<a href="'.get_admin_url().'options-general.php" target="_blank">'.__('title of the site', 'biz-vektor').'</a>';
printf( __( 'Normally, %1$s will include the %2$s in the title tag.', 'biz-vektor' ), $biz_vektor_name, $sitetitle_link );?><br />
<?php _e('For example, it appears in the form of <br />&lt;title&gt;page title | site title&lt;/title&gt;<br /> if using a static page.', 'biz-vektor'); ?>
<?php
printf( __('However, it might have negative impact on search engine rankings if the &lt;title&gt; is too long, <strong>therefore please include the most popular keywords in a summarized manner, keeping the %s as short as possible.</strong>', 'biz-vektor'),$sitetitle_link) ; ?>
<?php _e('However, in the home page, as described above, other title will not be added, it is possible to make the &lt;title&gt; little longer, which can be set separately here.', 'biz-vektor'); ?></p>
<input type="text" name="biz_vektor_theme_options[topTitle]" id="topTitle" value="<?php echo esc_attr( $options['topTitle'] ); ?>" style="width:90%;" />
<p>* <?php _e('Site title will be used if this field is blank.', 'biz-vektor'); ?></p>
</td>
</tr>
<tr>
<th><?php _e('Common keywords', 'biz-vektor'); ?></th>
<td><?php _e('For the keywords meta tag, please enter the keywords to be used throughout the site, comma separated.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[commonKeyWords]" id="commonKeyWords" value="<?php echo esc_attr( $options['commonKeyWords'] ); ?>" style="width:90%;" /><br />
<?php _e('* You do not have to take keywords very seriously, because it does not affect the search engine rankings anymore.', 'biz-vektor'); ?><br />
<?php _e('* The keywords for each particular page are entered from that page\'s edit screen. About up to 10 keywords in conjunction with the number of common keywords is desirable.', 'biz-vektor'); ?><br />
<?php _e('* Not required , at the end of the last keyword.', 'biz-vektor'); ?><br />
<?php _e('ex) WordPress,Template,Theme,Free,GPL', 'biz-vektor'); ?>
</td>
</tr>
<tr>
<th><?php _ex('Description', 'Description settings', 'biz-vektor'); ?></th>
<td>
<?php _e("Content from the particular page's \"excerpt\" field will be reflected in the description meta tag.", 'biz-vektor'); ?><br />
<?php _e('In the Google and other search engine results pages (SERPs), part of the meta tag description appears under the site title.', 'biz-vektor'); ?><br />
<?php _e('If the excerpt field is blank, the first 240 characters from the page\'s content are used.', 'biz-vektor'); ?><br />
<?php _e("Description of the site will be applied to the meta description of the top page.However, the content will be reflected if the excerpt is fill in the page that is set on the home.", 'biz-vektor'); ?><br />
<?php _e("* If the excerpt field is not visible, in the tab called \"View\" in the upper right corner of the edit page, please check the box to display the \"excerpt\" field.", 'biz-vektor'); ?><br />
</td>
</tr>
<!-- Google Analytics -->
<tr>
<th><?php _e('Google Analytics Settings', 'biz-vektor'); ?></th>
<td><?php _e('Please fill in the Google Analytics ID from the Analytics embed code used in the site.', 'biz-vektor'); ?><br />
<p>UA-<input type="text" name="biz_vektor_theme_options[gaID]" id="gaID" value="<?php echo esc_attr( $options['gaID'] ); ?>" style="width:90%;" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>XXXXXXXX-X</p>

	<dl>
	<dt><?php _e('Please select the type of Analytics code . (If you are unsure you can skip this.)', 'biz-vektor'); ?></dt>
	<dd>
	<?php
		if(!isset($options['gaType'])){ $options['gaType'] = 'gaType_normal'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[gaType]" value="gaType_normal" <?php echo ($options['gaType'] != 'gaType_universal' && $options['gaType'] != 'gaType_both')? 'checked' : ''; ?> > <?php _e('To output only normal code (default)', 'biz-vektor'); ?></label><br />
	<label><input type="radio" name="biz_vektor_theme_options[gaType]" value="gaType_universal" <?php echo ($options['gaType'] == 'gaType_universal')? 'checked' : ''; ?> > <?php _e('To output the Universal Analytics code', 'biz-vektor'); ?></label><br />
	<label><input type="radio" name="biz_vektor_theme_options[gaType]" value="gaType_both" <?php echo ($options['gaType'] == 'gaType_both')? 'checked' : ''; ?> > <?php _e('To output both types', 'biz-vektor'); ?></label>
	</dd>
	</dl>
</td>
</tr>
</table>
<?php submit_button(); ?>
</div>
<!-- [ /#seoSetting ] -->
<?php
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
	$options = biz_vektor_get_theme_options();
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