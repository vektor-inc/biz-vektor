<?php




add_action('biz_vektor_options_nav_tab', 'biz_vektor_toppage_options_nav', 13);
function biz_vektor_toppage_options_nav(){?>
<li id="btn_topPage"><a href="#topPage"><?php echo _x( 'Homepage', 'BizVektor option tab label', 'biz-vektor' ); ?></a></li>
<?php }
/*-------------------------------------------*/
/*	Toppage setting
/*-------------------------------------------*/

add_action('biz_vektor_extra_module_config', 'biz_vektor_toppage_render_edit', 13);

function biz_vektor_toppage_render_edit(){
	$options = biz_vektor_get_theme_options();
	$biz_vektor_name = get_biz_vektor_name();

?>
<div id="topPage" class="sectionBox">
<?php get_template_part('inc/views/nav'); ?>
<h3><?php _e('Home page settings', 'biz-vektor') ;?></h3>
<table class="form-table">
<tr>
<th><?php _e('Main visual', 'biz-vektor') ;?></th>
<td><?php _e('You can use a slide show or a still image.', 'biz-vektor') ;?>
<ul>
<li>[ <a href="<?php echo get_admin_url(); ?>themes.php?page=custom-header" target="_blank">
	&raquo; <?php _e('Still image settings', 'biz-vektor') ;?></a> ]</li>
<li>[ <a href="#slideSetting">
	&raquo; <?php _e('Slide show settings', 'biz-vektor') ;?></a> ]</li>
</ul></td>
</tr>
<!-- Page to be displayed below the main visual -->
<tr>
<th id="topEntryTitleHidden"><?php _e('Page to be displayed below the main visual', 'biz-vektor') ;?></th>
<td>
<ol>
<li>
<?php printf( __( 'First you need to create a page to use as a top page for %1$s', 'biz-vektor' ), $postLabelName ); ?><br />
[ <a href="<?php echo admin_url().'edit.php?post_type=page';?>" target="_blank">&raquo; <?php _e( 'Pages', 'biz-vektor' ); ?></a> ]<br />
<?php _e('If the main page content of the set page is blank, the 3PR area will be displayed just below the main visual. Therefore, if you don\'t have any particular content to use it can be left blank.', 'biz-vektor'); ?>
</li>
<li><?php _e( 'Then you can choose the page to use under the Settings > Reading Settings page', 'biz-vektor' ); ?><br />
[ <a href="<?php echo admin_url().'options-reading.php';?>" target="_blank">&raquo; <?php _e( 'Reading Settings', 'biz-vektor' ); ?></a> ]<br />
<p><?php _e('In the pull-down of the &quot;front page&quot;, please select the page that you created for the homepage.', 'biz-vektor') ;?></p>
</li>
<li><?php printf( __( 'Items to be displayed in the top page and their display order can be modified in the <a href="%1$s" target="_blank">%2$s</a>', 'biz-vektor' ), admin_url() . 'widgets.php', __( 'Widgets edition page', 'biz-vektor' ) ); ?>
<?php printf( __( 'Please set the widget called Main content(Homepage) under the <a href="%1$s" target="_blank">%2$s</a>', 'biz-vektor' ), admin_url() . 'widgets.php', __( 'Widgets edition page', 'biz-vektor' ) ); ?>
</li>
</ol>
</td>
</td>
</tr>
<!-- Home 3PR area -->
<tr>
<th><?php _e('Home 3PR area', 'biz-vektor'); ?></th>
<td>
<ul>
<li>[ <a href="#prBox">&raquo; <?php _e('Settings for the Home page 3PR area are here', 'biz-vektor'); ?></a> ]</li>
</ul></td>
</tr>
<!-- Home page side bar hidden -->
<tr>
<th><?php _e('The display of the home page side bar.', 'biz-vektor'); ?></th>
<td><p>
	<?php _e('Check this box if you do not want to display the side bar on the home page.', 'biz-vektor'); ?></p>
<p><input type="checkbox" name="biz_vektor_theme_options[topSideBarDisplay]" id="topSideBarDisplay" value="true" <?php if ($options['topSideBarDisplay']) {?> checked<?php } ?>> <?php _e('I want to hide the sidebar', 'biz-vektor'); ?></p></td>
</tr>
<!-- Display number of Blog -->
<tr>
	<th><?php
	$postLabelName = esc_html( bizVektorOptions('postLabelName'));
	printf(__('Display a number of %s posts', 'biz-vektor'), $postLabelName ); ?></th>
	<td><a href="#postSetting">
		<?php
		$infoLabelName = esc_html( bizVektorOptions('infoLabelName'));
		$postLabelName = esc_html( bizVektorOptions('postLabelName'));
		printf( __('Please set from the [ Setting the %s and %s ] section.', 'biz-vektor'),$infoLabelName,$postLabelName);
		?>
		</a>
	</td>
</tr>
</table>

<?php submit_button(); ?>
</div>
<?php
}





add_action('biz_vektor_options_nav_tab', 'biz_vektor_slidshow_options_nav', 16);
function biz_vektor_slidshow_options_nav(){?>
    <li id="btn_slideSetting"><a href="#slideSetting"><?php echo _x( 'Slide', 'BizVektor option tab label', 'biz-vektor' ); ?></a></li>
<?php }
/*-------------------------------------------*/
/*	Slideshow Settings
/*-------------------------------------------*/

add_action('biz_vektor_extra_module_config', 'biz_vektor_slidshow_render_edit', 16);

function biz_vektor_slidshow_render_edit(){
	$options = biz_vektor_get_theme_options();
	$biz_vektor_name = get_biz_vektor_name();

	?>
<div id="slideSetting" class="sectionBox">
<?php get_template_part('inc/views/nav'); ?>
<h3><?php _e('Slideshow Settings', 'biz-vektor'); ?></h3>
<p><?php _e('Please enter the URL of the image to be used in the slideshow.', 'biz-vektor'); ?><br />
<?php _e('The recommended size of the image is 950 × 250px.', 'biz-vektor'); ?><br />
<?php
$topVisualLink = '<a href="'.get_admin_url().'themes.php?page=custom-header" target="_blank">'.__('Home page Main visual', 'biz-vektor').'</a>';
printf(__('%s will be displayed if the slideshow is not set.', 'biz-vektor'),$topVisualLink); ?><br />
<?php _e('It can be only the URL of an image. However, the link is set for the image if you enter a link URL.', 'biz-vektor'); ?><br />
<?php _e('Please type in the alternate text for the image.', 'biz-vektor'); ?>
<?php _e('When filled in, will be more likely to match the search.', 'biz-vektor'); ?>
<?php _e('Moreover, for visually impaired visitors using a text-to-speech device, it reads out the text.', 'biz-vektor'); ?>
</p>
<table class="form-table">
<?php
for ( $i = 1; $i <= 5 ;){
$slideLink = 'slide'.$i.'link';
$slideImage = 'slide'.$i.'image';
$slideAlt = 'slide'.$i.'alt';
$slideDisplay = 'slide'.$i.'display';
$slideBlank = 'slide'.$i.'blank'; ?>
<tr>
<td><?php _e('Link URL', 'biz-vektor'); ?> [<?php echo $i ?>]<br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideLink ?>]" id="<?php echo $slideLink ?>" value="<?php echo esc_attr( $options[$slideLink] ) ?>" /></td>
<td><?php _e('Image URL', 'biz-vektor'); ?> [<?php echo $i ?>]<br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideImage ?>]" id="<?php echo $slideImage ?>" value="<?php echo esc_attr( $options[$slideImage] ) ?>" /> <button id="media_<?php echo $slideImage ?>" class="media_btn"><?php _e('Select an image', 'biz-vektor'); ?></button>
</td>
<td><?php _e('Alternate text', 'biz-vektor'); ?> (alt) [<?php echo $i ?>]<br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideAlt ?>]" id="<?php echo $slideAlt ?>" value="<?php echo esc_attr( $options[$slideAlt] ) ?>" /></td>
<td>
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideDisplay ?>]" id="<?php echo $slideDisplay ?>" value="true" <?php if ($options[$slideDisplay]) :echo ' checked';endif; ?>> <?php _ex('Do not display', 'Slide not displayed', 'biz-vektor'); ?></label><br />
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideBlank ?>]" id="<?php echo $slideBlank ?>" value="true" <?php if ($options[$slideBlank]) :echo ' checked';endif; ?>> <?php _e('Open in a blank window', 'biz-vektor'); ?></label>
</td>
</tr>
<?php
	$i++;
} ?>

</table>
<p><?php _e('* The slideshow can be set to up to 5 images, but when accessing the site using a slow internet connection, because of the time it takes to display all images, the visitor might leave the page early onwhich might have a negative effect. Therefore using three or less images is recommended.', 'biz-vektor'); ?>
	</p>
<?php submit_button(); ?>
</div>
<?php
}