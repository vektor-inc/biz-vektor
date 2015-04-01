<?php
/*-------------------------------------------*/
/*	Add Setting Page tab
/*-------------------------------------------*/

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
<?php get_template_part('inc/theme-options-nav'); ?>
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