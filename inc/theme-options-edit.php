<?php
/*-------------------------------------------*/
/*  Theme option edit page
/*-------------------------------------------*/
/*	Design setting
/*-------------------------------------------*/
/*	Contact information
/*-------------------------------------------*/
/*	3PR area
/*-------------------------------------------*/
/*	Blog and Information
/*-------------------------------------------*/
/*	SEO and Google Analytics Setting
/*-------------------------------------------*/
/*	Toppage setting
/*-------------------------------------------*/
/*	Slideshow Settings
/*-------------------------------------------*/
/*	SNS
/*-------------------------------------------*/

/*-------------------------------------------*/
/*  Theme option edit page
/*-------------------------------------------*/
function biz_vektor_theme_options_render_page() {
	if(isset($_POST['bizvektor_action_mode'])){ biz_vektor_them_edit_function($_POST); }
	$options = biz_vektor_get_theme_options();
	$biz_vektor_name = get_biz_vektor_name();
 ?>
	<div class="wrap biz_vektor_options">
		<?php screen_icon(); ?>
		<h2>
			<?php
			if (function_exists('biz_vektor_obu_get_options')) {
				$obu_options = biz_vektor_obu_get_options();
				if ($obu_options['system_logo']) {
					echo '<img src="'.$obu_options['system_logo'].'" alt="'.$biz_vektor_name.'" />';
				} else {
					printf( __( '%s Theme Options', 'biz-vektor' ), $biz_vektor_name );
				}
			} else {
				printf( __( '%s Theme Options', 'biz-vektor' ), $biz_vektor_name );
			} ?>
		</h2>
		<div class="bv_version">Version <?php echo BizVektor_Theme_Version; ?></div>
		<?php settings_errors(); ?>

		<?php if ( function_exists( 'biz_vektor_activation_information' ) ) {
		biz_vektor_activation_information();
		} else {
			$iframeUrl = '//bizvektor.com/info-admin/';
			//global edition
			if ( 'ja' != get_locale() ) {
				$iframeUrl = '//bizvektor.com/en/info-admin/';
			} ?>
		<div id="sub-content">
			<iframe frameborder="0" height="200" marginheight="0" marginwidth="0" scrolling="auto" src="<?php echo $iframeUrl; ?>"></iframe>
		</div>
		<?php } ?>

<?php
$biz_vektor_options = biz_vektor_get_theme_options();
?>
		<div id="main-content">
		<div class="message_intro">
	<?php $customizer_link = '<a href="'.get_admin_url().'customize.php">'.__('Theme customizer','biz-vektor').'</a>'; ?>
	<?php printf(__('Thank you for using %s.', 'biz-vektor'),$biz_vektor_name);?>
	<?php printf(__('You can change basic design settings from %s', 'biz-vektor'),$customizer_link); ?> <br />
	<?php _e('Here you can change social media settings.','biz-vektor'); ?>
		</div>
		<form method="post" action="options.php">
		<input type="hidden" name="post_status" value="bvo" />
			<?php
				settings_fields( 'biz_vektor_options' );
			?>
<?php
/*-------------------------------------------*/
/*	Design setting
/*-------------------------------------------*/
?>
<div id="design" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3><?php _e('Design settings', 'biz-vektor' ); ?>
	<span class="message_box">
		<?php printf(__('You can change settings for this section also from %s', 'biz-vektor'), $customizer_link ); ?>
	</span>
</h3>
	<table class="form-table">
	<tr>
	<th><?php _e('Design skin', 'biz-vektor') ?></th>
	<td>
	<select name="biz_vektor_theme_options[theme_style]" id="<?php echo esc_attr( $options['theme_style'] ); ?>">
	<option value="">[ <?php _e('Select', 'biz-vektor') ?> ]</option>
	<?php
	// Read biz_vektor_theme_styles
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();
	// Create pulldown item
	foreach( $biz_vektor_theme_styles as $biz_vektor_theme_styleKey => $biz_vektor_theme_styleValues) {
			if ( $biz_vektor_theme_styleKey == $options['theme_style'] ) {
				print ('<option value="'.$biz_vektor_theme_styleKey.'" selected>'.$biz_vektor_theme_styleValues['label'].'</option>');
			} else {
				print ('<option value="'.$biz_vektor_theme_styleKey.'">'.$biz_vektor_theme_styleValues['label'].'</option>');
			}
	}
	?>
	</select>
	<?php
	global $themePlusSettingNavi;
	$themePlusSettingNavi = '<p>'.__('* If there are settings for the particular design skin, after you save your changes, you can update them from theme customizer.', 'biz-vektor').'</p>';
	$themePlusSettingNavi = apply_filters( 'themePlusSettingNavi', $themePlusSettingNavi );
	echo $themePlusSettingNavi;
	?>
	</td>
	</tr>
	<!-- Menu divide -->
	<tr>
	<th><?php _e('Number of header menus', 'biz-vektor') ;?></th>
	<td>
	<select name="biz_vektor_theme_options[gMenuDivide]" id="<?php echo esc_attr( $options['gMenuDivide'] ); ?>">
	<option value="">[ <?php _e('Select', 'biz-vektor') ?> ]</option>
	<?php
	$biz_vektor_gMenuDivides = array(
		'divide_natural' => __('Not specified (left-justified)', 'biz-vektor'),
		'divide_4' => _x('4', 'biz-vektor-theme-customizer', 'biz-vektor'),
		'divide_5' => _x('5', 'biz-vektor-theme-customizer', 'biz-vektor'),
		'divide_6' => _x('6', 'biz-vektor-theme-customizer', 'biz-vektor'),
		'divide_7' => _x('7', 'biz-vektor-theme-customizer', 'biz-vektor')
	);
	if( $options['gMenuDivide'] == ''){
		$options['gMenuDivide'] = 'divide_natural';
	}
	foreach( $biz_vektor_gMenuDivides as $biz_vektor_gMenuDivideKey => $biz_vektor_gMenuDivideValue) {
		if ( $biz_vektor_gMenuDivideKey == $options['gMenuDivide'] ) {
			print ('<option value="'.$biz_vektor_gMenuDivideKey.'" selected>'.$biz_vektor_gMenuDivideValue.'</option>');
		} else {
			print ('<option value="'.$biz_vektor_gMenuDivideKey.'">'.$biz_vektor_gMenuDivideValue.'</option>');
		}
	}
	?>
	</select>
	<?php if ( !function_exists( 'biz_vektor_activation' ) ) :?>
	[ <a href="http://bizvektor.com/setting/bizvektorsetting/menu/" target="_blank">&raquo; <?php _e('How to set up Menus', 'biz-vektor') ;?></a> ]
	<?php endif;?>
	</td>
	</tr>
	<!-- Head logo -->
	<tr>
	<th scope="row"><?php _e('Header logo image', 'biz-vektor') ;?></th>
	<td><input type="text" name="biz_vektor_theme_options[head_logo]" id="head_logo" value="<?php echo esc_attr( $options['head_logo'] ); ?>" style="width:60%;" />
	<button id="media_head_logo" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button><br />
	<?php _e('Recommended : less than 60px height', 'biz-vektor') ;?><br />
	</td>
	</tr>
	<!-- Footer logo -->
	<tr>
	<th scope="row"><?php _e('Footer logo image', 'biz-vektor') ;?></th>
	<td><input type="text" name="biz_vektor_theme_options[foot_logo]" id="foot_logo" value="<?php echo esc_attr( $options['foot_logo'] ); ?>" style="width:60%;" />
	<button id="media_foot_logo" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button><br />
	<?php _e('Recommended : 180-250px width', 'biz-vektor') ;?><br />
	</td>
	</tr>
	<!-- theme-layout -->
	<tr class="image-radio-option theme-layout">
	<th scope="row"><?php _e('Layout', 'biz-vektor' ) ;?></th>
	<td>
	<?php
		foreach ( biz_vektor_layouts() as $layout ) { ?>
			<div class="layout">
			<label class="description">
				<input type="radio" name="biz_vektor_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
				<span>
					<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>" width="100" alt="" />
				</span>
				<div><?php echo $layout['label']; ?></div>
			</label>
			</div>
			<?php
		}
	?>
	<br clear="all" />
	<?php _e('You can select 1-column from below: ', 'biz-vektor');?>
	<ul>
		<li>
			<?php
			$toppage_setting_link = '<a href="#topPage">'.__('Home page settings', 'biz-vektor').'</a>';
			printf( __('[Top page] %s', 'biz-vektor'), $toppage_setting_link );?>
		</li>
		<li><?php _e('[page] Edit Page > Page Attributes > Template', 'biz-vektor') ;?></li>
	</ul>
	</td>
	</tr>
	<!-- Heading font -->
	<tr>
	<th><?php _e('Heading font', 'biz-vektor') ;?></th>
	<td>
	<?php
		if(!isset($options['font_title'])){ $options['font_title'] = 'sanserif'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[font_title]" value="serif" <?php echo ($options['font_title'] != 'sanserif')? 'checked' : ''; ?> > <?php echo __('Serif', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[font_title]" value="sanserif" <?php echo ($options['font_title'] == 'sanserif')? 'checked' : ''; ?> > <?php echo __('Sanserif', 'biz-vektor'); ?></label>
	<td>
	</tr>
	<!-- Global Menu font -->
	<tr>
	<th><?php _e( 'Global Menu font', 'biz-vektor' ) ;?></th>
	<td>
	<?php
		if(!isset($options['font_menu'])){ $options['font_menu'] = 'sanserif'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[font_menu]" value="serif" <?php echo ($options['font_menu'] != 'sanserif')? 'checked' : ''; ?> > <?php echo __('Serif', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[font_menu]" value="sanserif" <?php echo ($options['font_menu'] == 'sanserif')? 'checked' : ''; ?> > <?php echo __('Sanserif', 'biz-vektor'); ?></label>
	<td>
	</tr>
	<?php
	if ( 'ja' != get_locale() ) { ?>
		<!-- Fonts -->
		<tr>
			<th>
				<?php _e( 'Google Web Fonts', 'biz-vektor' ); ?>
			</th>
			<td>
				<select name="biz_vektor_theme_options[global_font]">
					<?php
					//getting $fonts
					require get_template_directory() . '/inc/fonts-list.php';
					$selected_font = $options['global_font'];

					foreach ( $fonts as $value => $label ) {
						$selected = ( $selected_font == $value ) ? ' selected' : ''; ?>
						<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $label; ?></option><?php
					}

					?>
				</select>
			</td>
		</tr><?php
	} ?>
	<!-- Sidebar Child page menu display -->
	<tr>
	<th><?php _e('Deployment of the sidebar menu', 'biz-vektor') ;?></th>
	<td>
		<p><?php _e('If the site hierarchy is deep, you can choose to hide this menu hierarchy other than the Page you are currently viewing.', 'biz-vektor');?></p>
	<?php
		if(!isset($options['side_child_display'])){ $options['side_child_display'] = 'side_child_display'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[side_child_display]" value="side_child_display" <?php echo ($options['side_child_display'] != 'side_child_hidden')? 'checked' : ''; ?> > <?php _e('Display', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[side_child_display]" value="side_child_hidden" <?php echo ($options['side_child_display'] == 'side_child_hidden')? 'checked' : ''; ?> > <?php _e('Hide', 'biz-vektor'); ?></label>


	<p>* <?php _e('This setting can not be changed from the theme customizer.', 'biz-vektor') ;?></p>
	<td>
	</tr>
	<!-- Favicon -->
	<tr>
	<th><?php _e('Favicon Setting', 'biz-vektor'); ?></th>
	<?php if( !isset( $options['favicon'] ) ){ $options['favicon'] = ''; } ?>
	<td><input type="text" name="biz_vektor_theme_options[favicon]" id="favicon" value="<?php echo esc_attr( $options['favicon'] ); ?>" style="width:60%;" />
	<button id="media_favicon" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button>
	<p><?php _e('Please upload a .ico file.', 'biz-vektor') ; ?></p>
	</td>
	</tr>

	<!-- Ie8Warning -->
	<tr>
	<th><?php _e('IE8 Warning message', 'biz-vektor'); ?></th>
	<td><label><input type="checkbox" name="biz_vektor_theme_options[enableie8Warning]" id="ie8warning" value="true" <?php echo (isset($options['enableie8Warning']) && $options['enableie8Warning'])? 'checked': ''; ?> />
	<span><?php _e('Display a warning message about Internet Explorer 8', 'biz-vektor'); ?></span></label>
	</td>
	</tr>

	</table>
	<?php submit_button(); ?>
</div>
<!-- [ /#design ] -->

<?php
/*-------------------------------------------*/
/*	Contact information
/*-------------------------------------------*/
?>
<div id="contactInfo" class="sectionBox">
	<?php get_template_part('inc/theme-options-nav'); ?>
	<h3><?php _e( 'Contact settings', 'biz-vektor' ) ;?>
		<span class="message_box">
			<?php printf(__('You can change settings for this section also from %s', 'biz-vektor'), $customizer_link ); ?>
		</span>
	</h3>
	<table class="form-table">
	<tr>
	<th scope="row"><?php _e( 'Message', 'biz-vektor' ) ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[contact_txt]" id="contact_txt" value="<?php echo esc_attr( $options['contact_txt'] ); ?>" style="width:50%;" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _e('Please feel free to inquire.', 'biz-vektor') ;?></span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e( 'Phone number', 'biz-vektor' ) ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[tel_number]" id="tel_number" value="<?php echo esc_attr( $options['tel_number'] ); ?>" style="width:50%;" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?>000-000-0000</span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e( 'Office hours', 'biz-vektor' ) ;?></th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[contact_time]" id="contact_time" value="" style="width:50%;" /><?php echo esc_attr( $options['contact_time'] ); ?></textarea><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _ex('Office hours', 'biz-vektor-theme-customizer', 'biz-vektor') ;?> 9:00 - 18:00 [ <?php _e('Weekdays except holidays', 'biz-vektor') ;?> ]</span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e('Site / Company / Store / Service name. This is displayed in the left part of the footer bottom and footer copyright section.', 'biz-vektor') ;?><br />
	</th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[sub_sitename]" id="sub_sitename" value="" style="width:50%;" /><?php echo esc_attr( $options['sub_sitename'] ); ?></textarea><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _e('Sample,Inc.', 'biz-vektor') ;?></span><br />
	<?php _e('* Use this feature when the site name has become too long for SEO purposes.', 'biz-vektor') ;?>
	</td>
	</tr>
	<!-- Company address -->
	<tr>
	<th scope="row"><?php _e('Company address', 'biz-vektor') ;?><br /><?php _e('This is displayed in the left bottom part of the footer.', 'biz-vektor') ;?></th>
	<td>
	<textarea cols="20" rows="5" name="biz_vektor_theme_options[contact_address]" id="contact_address" value="" style="width:50%;" /><?php echo $options['contact_address'] ?></textarea><br />
		<span><?php _e('ex) ', 'biz-vektor') ;?>
		<?php _e('316, Minami Sakae Building,<br />1-22-16, Sakae, Naka-ku, Nagoya-shi,<br />Aichi 460-0008 JAPAN<br />TEL / FAX +81-52-228-9176', 'biz-vektor') ;?>
		</span>
	</td>
	</tr>
	<!-- he URL of contact page -->
	<tr>
	<th scope="row"><?php _e( 'The contact page URL', 'biz-vektor' ) ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[contact_link]" id="contact_link" value="<?php echo esc_attr( $options['contact_link'] ); ?>" class="width-500" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?>http://www.********.co.jp/contact/ <?php _e('or', 'biz-vektor') ;?> /******/</span><br />
	<?php _e('* If you fill in the blank, contact banner will be displayed in the sidebar.', 'biz-vektor') ;?><br />
	<span class="alert"><?php _e('If not, it does not appear.', 'biz-vektor') ;?></span>
	</td>
	</tr>
	</table>
	<?php submit_button(); ?>
</div>
<!-- [ /#contactInfo ] -->

<?php
/*-------------------------------------------*/
/*	3PR area
/*-------------------------------------------*/
?>
<div id="prBox" class="sectionBox">
	<?php get_template_part('inc/theme-options-nav'); ?>
	<h3><?php _e('3PR area settings', 'biz-vektor') ;?>
		<span class="message_box">
			<?php printf(__('You can change settings for this section also from %s', 'biz-vektor'), $customizer_link ); ?>
		</span>
	</h3>

<table class="form-table">
<!-- Home 3PR Area hidden -->
<tr>
<th><?php _e('The display of the home page 3PR area.', 'biz-vektor'); ?></th>
<td><p>
	<?php _e('Check this box if you do not want to see the 3PR area on the home page.', 'biz-vektor'); ?></p>
<p><input type="checkbox" name="biz_vektor_theme_options[top3PrDisplay]" id="top3PrDisplay" value="true" <?php if ($options['top3PrDisplay']) {?> checked<?php } ?>> <?php _e('Do not show the top 3PR area', 'biz-vektor'); ?></p></td>
</tr>
</table>

<div class="sectionbox">
<?php for ( $i = 1; $i <= 3 ;){ ?>

<div class="prItem">
<h5><?php _e('PR area', 'biz-vektor') ?><?php echo $i; ?></h5>
<dl>
<dt><?php _e('Title', 'biz-vektor') ;?></dt>
<dd><input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_title]" id="pr<?php echo $i; ?>_title" value="<?php echo esc_attr( $options['pr'.$i.'_title'] ); ?>" /></dd>
<dt><?php _e('Description', 'biz-vektor') ;?></dt>
<dd><textarea cols="15" rows="3" name="biz_vektor_theme_options[pr<?php echo $i; ?>_description]" id="pr<?php echo $i; ?>_description" value=""><?php echo esc_attr( $options['pr'.$i.'_description'] ); ?></textarea></dd>
<dt><?php _e('URL', 'biz-vektor') ;?></dt>
<dd><input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_link]" id="pr<?php echo $i; ?>_link" value="<?php echo esc_attr( $options['pr'.$i.'_link'] ); ?>" /></dd>
<dt><?php _e('Image (Desktop version)', 'biz-vektor') ;?></dt>
<dd>
<span class="mediaSet">
<input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_image]" class="media_text" id="pr<?php echo $i; ?>_image" value="<?php echo esc_attr( $options['pr'.$i.'_image'] ); ?>" />
<button id="media_pr<?php echo $i; ?>_image" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button></span>
<?php _e('310px width is recommended.', 'biz-vektor') ;?></dd>
<dt><?php _e('Image (Smartphone version)', 'biz-vektor') ;?></dt>
<dd>
<span class="mediaSet">
<input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_image_s]" class="media_text" id="pr<?php echo $i; ?>_image_s" value="<?php echo esc_attr( $options['pr'.$i.'_image_s'] ); ?>" />
<button id="media_pr<?php echo $i; ?>_image_s" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button></span>
<?php _e('120px by 120px is recommended.', 'biz-vektor') ;?></dd>
</dl>
</div>
<?php
$i++;
} ?>
</div>
<br clear="all" /><!-- [ 無いと回りこむ ] -->
	<?php _e('* If you are unsure about the image, you can leave this field blank.', 'biz-vektor') ;?><br />
	<span class="alert">
	<?php _e('* You can set different image for desktop and smartphone versions of the site.', 'biz-vektor') ;?>
	</span>
<?php submit_button(); ?>
</div>

<?php
/*-------------------------------------------*/
/*	Blog and Information
/*-------------------------------------------*/
?>
<div id="postSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3><?php if ( isset( $options['infoLabelName'] ) && ! empty( $options['infoLabelName'] )
    		&& isset( $options['postLabelName'] ) && ! empty( $options['postLabelName'] ) ) {

			echo esc_html( $options['infoLabelName'] ) . ' & ' . esc_html( $options['postLabelName'] );
    	} elseif ( isset( $options['infoLabelName'] ) && ! empty( $options['infoLabelName'] ) ) {

    		echo esc_html( bizVektorOptions('infoLabelName') ) . ' & ' . __( 'Posts', 'biz-vektor' );
    	} elseif ( isset( $options['postLabelName'] ) && ! empty( $options['postLabelName'] ) ) {

    		echo __( 'Posts', 'biz-vektor' ) . ' & ' . esc_html( $options['postLabelName'] );
    	} else {
			echo __( 'Posts', 'biz-vektor' );
    	} ?></h3>

<?php
$infoLabelName = esc_html( bizVektorOptions('infoLabelName'));
$postLabelName = esc_html( bizVektorOptions('postLabelName'));
?>

<?php _e('* Does not appear if there are no posts.', 'biz-vektor') ;?><br />
<?php _e('* If the excerpt field is not empty, the content will appear in the &quot;excerpt&quot;. Otherwise, the text will be displayed in a certain number of', 'biz-vektor') ;?><br />
<?php
	$plugin_link = '<a href="'.get_admin_url().'plugins.php" target="_blank">'.__( 'Plugins page', 'biz-vektor' ).'</a>';
	?>
  <?php _e('The full text will be displayed if the plug-in [WP Multibyte Patch] is not activated (Japanese version).', 'biz-vektor'); ?>

	<?php printf(__('Please enable [WP Multibyte Patch] from the %s.', 'biz-vektor'), $plugin_link ); ?><br />
* <?php _e('<span class="alert">Featured image of the article</span> is displayed.', 'biz-vektor') ;?><br />
	<?php _e('You can set the &quot;featured image&quot;, from the bottom right widget area of particular article edit screen.', 'biz-vektor') ;?><br />
	<?php _e('If there is no widget, please check &quot;Featured image&quot; at the top right of the screen from the &quot;Screen options&quot; tab.', 'biz-vektor') ;?>

<table class="form-table">

<?php do_action('biz_vektor_extra_posttype_config'); ?>

<!-- Post -->
<tr>
	<th><?php echo esc_html( bizVektorOptions('postLabelName')); ?></th>
	<td>
		&raquo; <?php _e('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[postLabelName]" id="postLabelName" value="<?php echo esc_attr( $options['postLabelName'] ); ?>" style="width:200px;" />
	<dl>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the top page.', 'biz-vektor'), $postLabelName ); ?></dt>
	<dd>
	<?php
		if(!isset($options['listBlogTop'])){ $options['listBlogTop'] = 'listType_set'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[listBlogTop]" value="listType_title" <?php echo ($options['listBlogTop'] != 'listType_set')? 'checked' : ''; ?> > <?php _e('Title only', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[listBlogTop]" value="listType_set" <?php echo ($options['listBlogTop'] == 'listType_set')? 'checked' : ''; ?> > <?php _e('With excerpt and thumbnail', 'biz-vektor'); ?></label>
	</dd>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the archive page.', 'biz-vektor'), $postLabelName ); ?></dt>
	<dd>
	<?php
		if(!isset($options['listBlogArchive'])){ $options['listBlogArchive'] = 'listType_set'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[listBlogArchive]" value="listType_title" <?php echo ($options['listBlogArchive'] != 'listType_set')? 'checked' : ''; ?> > <?php _e('Title only', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[listBlogArchive]" value="listType_set" <?php echo ($options['listBlogArchive'] == 'listType_set')? 'checked' : ''; ?> > <?php _e('With excerpt and thumbnail', 'biz-vektor'); ?></label>
	</dd>
	</dl>
	<!-- Post display count -->
	<dl>
		<dt><?php printf(__('Number of %s posts to be displayed on the home page.', 'biz-vektor'),$postLabelName);?></dt>
		<dd><input type="text" name="biz_vektor_theme_options[postTopCount]" id="postTopCount" value="<?php echo esc_attr( $options['postTopCount'] ); ?>" style="width:50px;text-align:right;" /> <?php _ex('posts', 'top page post count', 'biz-vektor') ;?><br />
		<?php _e('If you enter &quot0&quot, this section will disappear.', 'biz-vektor') ;?></dd>
	</dl>
	<!-- /Post display count -->
	<dl>
		<dt><?php printf( __( 'Top URL for %1$s', 'biz-vektor' ), $postLabelName ); ?></dt>
		<dd><?php $postTopUrl = esc_html(home_url().'/post/'); ?>
			<?php printf( __( '* If you don\'t want to set a top page for %1$s just leave this field blank.', 'biz-vektor' ), $postLabelName ); ?><br />
			<input type="text" name="biz_vektor_theme_options[postTopUrl]" id="postTopUrl" value="<?php echo esc_attr( $options['postTopUrl'] ); ?>" style="width:80%" />
			<dl class="showHideSection">
				<dt class="showHideBtn">[ <a><?php printf( __( 'How to set a top page for %1$s', 'biz-vektor' ), $postLabelName ); ?></a> ]</dt>
				<dd class="showHideBody">
					<ol>
					<li>
					<?php printf( __( 'First you need to create a page to use as a top page for %1$s', 'biz-vektor' ), $postLabelName ); ?>
					[ <a href="<?php echo admin_url().'post-new.php?post_type=page';?>" target="_blank">&raquo; <?php _e('Make new page', 'biz-vektor'); ?></a> ]
					</li>
					<li>
						<?php printf( __( 'Next select the page you want to use as %1$s top page in the Posts page dropdown menu of the <a href="%2$s" target="_blank">%3$s</a> page (Front page displays section)', 'biz-vektor' ), $postLabelName, admin_url() . 'options-reading.php', __( 'Reading', 'biz-vektor' ) );?>
					</li>
					</ol>
				</dd>
			</dl>
		</dd>
	</dl>
	<dl>
		<?php if(!isset($options['postRelatedCount'])){ $options['postRelatedCount'] = 0; } ?>
		<dt><?php _e('Number of related posts', 'biz-vektor'); ?></dt>
		<dd><?php _e('Post of the same tag appears as a related posts under the content.', 'biz-vektor'); ?><br />
			<?php _e('Nothing is displayed when there is no article of the same tag.', 'biz-vektor'); ?><br />
			<input type="text" name="biz_vektor_theme_options[postRelatedCount]" id="postRelatedCount" value="<?php echo esc_attr( $options['postRelatedCount'] ); ?>" style="width:50px;text-align:right;" /> <?php _ex('posts', 'post count', 'biz-vektor') ;?><br />
			<?php _e('If you enter &quot0&quot, this section will disappear.', 'biz-vektor') ;?>
		</dd>
	</dl>

	<dl>
		<dt><?php printf( __( 'Insert ad after %1$s', 'biz-vektor' ), __( 'more tag', 'biz-vektor' ) ); ?></dt>
		<dd><textarea cols="20" rows="5" name="biz_vektor_theme_options[ad_content_moretag]" id="ad_content_moretag" value="" style="width:90%;" /><?php echo isset($options['ad_content_moretag']) ? $options['ad_content_moretag'] : ''; ?></textarea>
		</dd>
	</dl>
	<dl>
		<dt><?php printf( __( 'Insert ad after %1$s', 'biz-vektor' ), __( 'main content', 'biz-vektor' ) ); ?></dt>
		<dd><textarea cols="20" rows="5" name="biz_vektor_theme_options[ad_content_after]" id="ad_content_after" value="" style="width:90%;" /><?php echo isset($options['ad_content_after']) ? $options['ad_content_after'] : ''; ?></textarea>
		</dd>
	</dl>
	<dl>
		<dt><?php printf( __( 'Insert ad after %1$s', 'biz-vektor' ), __( 'related articles', 'biz-vektor' ) ); ?></dt>
		<dd><textarea cols="20" rows="5" name="biz_vektor_theme_options[ad_related_after]" id="ad_related_after" value="" style="width:90%;" /><?php echo isset($options['ad_related_after']) ? $options['ad_related_after'] : ''; ?></textarea>
		</dd>
	</dl>

</td>
</tr>

</table>
<?php submit_button(); ?>

</div>
<!-- [ /#postSetting ] -->

<?php
/*-------------------------------------------*/
/*	Toppage setting
/*-------------------------------------------*/
?>
<div id="topPage" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
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
/*-------------------------------------------*/
/*	Slideshow Settings
/*-------------------------------------------*/
?>
<div id="slideSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
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
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideDisplay ?>]" id="<?php echo $slideDisplay ?>" value="true" <?php if ($options[$slideDisplay]) :echo ' checked';endif; ?>> <?php _e('Do not display', 'biz-vektor'); ?></label><br />
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideBlank ?>]" id="<?php echo $slideBlank ?>" value="true" <?php if ($options[$slideBlank]) :echo ' checked';endif; ?>> <?php _e('Open in a blank window', 'biz-vektor'); ?></label>
</td>
</tr>
<?php
	$i++;
} ?>

<?php
	if( !isset( $options["slider_slidespeed"] ) || !$options["slider_slidespeed"] ) $options["slider_slidespeed"] = 5000;
	if( !isset( $options["slider_animation"] ) ) $options["slider_animation"] = "fade";
?>
<tr>
	<th><label for="bv_sliderspeed"><?php _e("Slider speed", "biz-vektor"); ?></label></th>
	<td><input type="text" id="bv_sliderspeed" name="biz_vektor_theme_options[slider_slidespeed]" value="<?php echo esc_attr( $options['slider_slidespeed'] ); ?>" style="text-align:right" />ms</td>
</tr>
<tr>
	<th><label for="bv_slideranimation"><?php _e("Slide Animation", 'biz-vektor'); ?></label></th>
	<td>
	<select id="bv_slideranimation" name="biz_vektor_theme_options[slider_animation]">
		<option value="fade" <?php echo ($options['slider_animation'] != 'slide')? 'selected':''; ?> ><?php _e('fade in-out', 'biz-vektor'); ?></option>
		<option value="slide" <?php echo ($options['slider_animation'] == 'slide')? 'selected':''; ?> ><?php _e('slide animation', 'biz-vektor'); ?></option>
	</select>
</tr>
</table>
<p><?php _e('* The slideshow can be set to up to 5 images, but when accessing the site using a slow internet connection, because of the time it takes to display all images, the visitor might leave the page early onwhich might have a negative effect. Therefore using three or less images is recommended.', 'biz-vektor'); ?>
	</p>
<?php submit_button(); ?>
</div>

<?php do_action('biz_vektor_extra_module_config'); ?>

</form>

<?php $resetkey = rand(1000,9999); ?>
<div class="option Advanced" ><form action="" method="post">
<?php settings_fields( 'biz_vektor_options' ); ?>
<input type="hidden" name="bizvektor_action_mode" value="reset" />
<input type="hidden" name="bizvektor_reset_key"  value="<?php echo $resetkey; ?>" />
<p style="font-weight: bold;font-size: 23px;font-family: ariel;color:red"><?php echo $resetkey; ?></p>
<p><?php _e( 'Reset all settings options incluing design customization you\'ve modified through the Theme Customizer. The theme is entirely reset. To reset the theme please enter the number above and click on Reset Settings button.', 'biz-vektor' );?></p>
<input type="text" name="bizvektor_reset_key_port" value="" />
<label><input type="checkbox" name="bizvektor_reset_check" value="True" /><?php _e( 'I want to reset ALL theme settings', 'biz-vektor' ); ?></label>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Reset Settings', 'biz-vektor' ); ?>"  /></p>
</form></div>

<div class="optionNav bottomNav">
<ul><li><a href="#wpwrap"><?php _e('Page top', 'biz-vektor'); ?></a></li></ul>
</div>

</div><!-- [ /#main-content ] -->
</div><!-- [ /#biz_vektor_options ] -->
<script type="text/javascript">
</script>
<?php } ?>
