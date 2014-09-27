<?php
/*-------------------------------------------*/
/*  Theme option edit page
/*-------------------------------------------*/

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
/*	Slide Setting
/*-------------------------------------------*/
/*	SNS
/*-------------------------------------------*/

/*-------------------------------------------*/
/*  Theme option edit page
/*-------------------------------------------*/
function biz_vektor_theme_options_render_page() {
	if(isset($_POST['bizvektor_action_mode'])){ biz_vektor_them_edit_function($_POST); }
	global $options_bizvektor;
	$options_bizvektor = $options = biz_vektor_get_theme_options();
	$biz_vektor_name = get_biz_vektor_name();
	//echo "<pre>";print_r($options);echo "</pre>";
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
		} else { ?>
		<div id="sub-content">
		<iframe frameborder="0" height="200" marginheight="0" marginwidth="0" scrolling="auto" src="http://bizvektor.com/info-admin/"></iframe>
		</div>
		<?php } ?>

<?php 
global $biz_vektor_options;
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
<h3><?php _ex('Design settings', 'biz-vektor theme-options-edit', 'biz-vektor'); ?>
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
	<th><?php _ex('Number of header menus', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<select name="biz_vektor_theme_options[gMenuDivide]" id="<?php echo esc_attr( $options['gMenuDivide'] ); ?>">
	<option value="">[ <?php _e('Select', 'biz-vektor') ?> ]</option>
	<?php
	$biz_vektor_gMenuDivides = array(
		'divide_natural' => _x('Not specified (left-justified)','biz-vektor theme-customizer', 'biz-vektor'),
		'divide_4' => _x('4', 'biz-vektor theme-customizer', 'biz-vektor'),
		'divide_5' => _x('5', 'biz-vektor theme-customizer', 'biz-vektor'),
		'divide_6' => _x('6', 'biz-vektor theme-customizer', 'biz-vektor'),
		'divide_7' => _x('7', 'biz-vektor theme-customizer', 'biz-vektor')
	);
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
	<th scope="row"><?php _ex('Header logo image', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td><input type="text" name="biz_vektor_theme_options[head_logo]" id="head_logo" value="<?php echo esc_attr( $options['head_logo'] ); ?>" style="width:60%;" /> 
	<button id="media_head_logo" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button><br />
	<?php _e('Recommended : less than 60px height', 'biz-vektor') ;?><br />
	</td>
	</tr>
	<!-- Footer logo -->
	<tr>
	<th scope="row"><?php _ex('Footer logo image', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td><input type="text" name="biz_vektor_theme_options[foot_logo]" id="foot_logo" value="<?php echo esc_attr( $options['foot_logo'] ); ?>" style="width:60%;" /> 
	<button id="media_foot_logo" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button><br />
	<?php _e('Recommended : 180-250px width', 'biz-vektor') ;?><br />
	</td>
	</tr>
	<!-- theme-layout -->
	<tr class="image-radio-option theme-layout">
	<th scope="row"><?php _ex('Layout', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
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
	<th><?php _ex('Heading font', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<?php
		if(!isset($options['font_title'])){ $options['font_title'] = 'sanserif'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[font_title]" value="serif" <?php echo ($options['font_title'] != 'sanserif')? 'checked' : ''; ?> > <?php echo _x('Serif', 'biz-vektor theme-customizer', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[font_title]" value="sanserif" <?php echo ($options['font_title'] == 'sanserif')? 'checked' : ''; ?> > <?php echo _x('Sanserif', 'biz-vektor theme-customizer', 'biz-vektor'); ?></label>
	<td>
	</tr>
	<!-- Global Menu font -->
	<tr>
	<th><?php _ex('Global Menu font', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<?php
		if(!isset($options['font_menu'])){ $options['font_menu'] = 'sanserif'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[font_menu]" value="serif" <?php echo ($options['font_menu'] != 'sanserif')? 'checked' : ''; ?> > <?php echo _x('Serif', 'biz-vektor theme-customizer', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[font_menu]" value="sanserif" <?php echo ($options['font_menu'] == 'sanserif')? 'checked' : ''; ?> > <?php echo _x('Sanserif', 'biz-vektor theme-customizer', 'biz-vektor'); ?></label>
	<td>
	</tr>
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
	<th><?php _e('Favicon Setting', 'biz-vektor') ; ?></th>
	<td><input type="text" name="biz_vektor_theme_options[favicon]" id="favicon" value="<?php echo esc_attr( $options['favicon'] ); ?>" style="width:60%;" /> 
	<button id="media_favicon" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button>
	<p>作成したicoファイルをアップロードしてください。</p>
	</td>
	</tr>

	<!-- Ie8Warning -->
	<tr>
	<th>IE8警告表示</th>
	<td><label><input type="checkbox" name="biz_vektor_theme_options[enableie8Warning]" id="ie8warning" value="true" <?php echo (isset($options['enableie8Warning']) && $options['enableie8Warning'])? 'checked': ''; ?> /> 
	<span>Internet Explorer8への警告を表示する</span></label>
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
	<h3><?php _ex('Contact settings', 'biz-vektor theme-customizer', 'biz-vektor') ;?>
		<span class="message_box">
			<?php printf(__('You can change settings for this section also from %s', 'biz-vektor'), $customizer_link ); ?>
		</span>
	</h3>
	<table class="form-table">
	<tr>
	<th scope="row"><?php _ex('Message', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[contact_txt]" id="contact_txt" value="<?php echo esc_attr( $options['contact_txt'] ); ?>" style="width:50%;" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _e('Please feel free to inquire.', 'biz-vektor') ;?></span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _ex('Phone number', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[tel_number]" id="tel_number" value="<?php echo esc_attr( $options['tel_number'] ); ?>" style="width:50%;" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?>000-000-0000</span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _ex('Office hours', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[contact_time]" id="contact_time" value="" style="width:50%;" /><?php echo esc_attr( $options['contact_time'] ); ?></textarea><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _ex('Office hours', 'biz-vektor theme-customizer', 'biz-vektor') ;?> 9:00 - 18:00 [ <?php _e('Weekdays except holidays', 'biz-vektor') ;?> ]</span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _ex('Site / Company / Store / Service name. This is displayed in the left part of the footer bottom and footer copyright section.', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br />
	</th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[sub_sitename]" id="sub_sitename" value="" style="width:50%;" /><?php echo esc_attr( $options['sub_sitename'] ); ?></textarea><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _e('Sample,Inc.', 'biz-vektor') ;?></span><br />
	<?php _e('* Use this feature when the site name has become too long for SEO purposes.', 'biz-vektor') ;?>
	</td>
	</tr>
	<!-- Company address -->
	<tr>
	<th scope="row"><?php _ex('Company address', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br /><?php _e('This is displayed in the left bottom part of the footer.', 'biz-vektor') ;?></th>
	<td>
	<textarea cols="20" rows="5" name="biz_vektor_theme_options[contact_address]" id="contact_address" value="" style="width:50%;" /><?php echo $options['contact_address'] ?></textarea><br />
		<span><?php _e('ex) ', 'biz-vektor') ;?>
		<?php _e('316, Minami Sakae Building,<br />1-22-16, Sakae, Naka-ku, Nagoya-shi,<br />Aichi 460-0008 JAPAN<br />TEL / FAX +81-52-228-9176', 'biz-vektor') ;?>
		</span>
	</td>
	</tr>
	<!-- he URL of contact page -->
	<tr>
	<th scope="row"><?php _ex('The contact page URL', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[contact_link]" id="contact_link" value="<?php echo esc_attr( $options['contact_link'] ); ?>" /><br />
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
<h3>
		<?php
		$infoLabelName = esc_html( bizVektorOptions('infoLabelName'));
		$postLabelName = esc_html( bizVektorOptions('postLabelName'));
		printf( __('Settings for [ %s ] and [ %s ].', 'biz-vektor'),$infoLabelName,$postLabelName);
		?>
</h3>
<?php _e('* Does not appear if there are no posts.', 'biz-vektor') ;?><br />
<?php _e('* If the excerpt field is not empty, the content will appear in the &quot;excerpt&quot;. Otherwise, the text will be displayed in a certain number of', 'biz-vektor') ;?><br />
<?php
	$plugin_link = '<a href="'.get_admin_url().'plugins.php" target="_blank">'._x('Plugins page','no link', 'biz-vektor').'</a>';
	?>
  <?php _e('The full text will be displayed if the plug-in [WP Multibyte Patch] is not activated (Japanese version).', 'biz-vektor'); ?>
	
	<?php printf(__('Please enable [WP Multibyte Patch] from the %s.', 'biz-vektor'), $plugin_link ); ?><br />
* <?php _e('<span class="alert">Featured image of the article</span> is displayed.', 'biz-vektor') ;?><br />
	<?php _e('You can set the &quot;featured image&quot;, from the bottom right widget area of particular article edit screen.', 'biz-vektor') ;?><br />
	<?php _e('If there is no widget, please check &quot;Featured image&quot; at the top right of the screen from the &quot;Screen options&quot; tab.', 'biz-vektor') ;?>

<table class="form-table">
<!-- Information -->
<tr>
	<th><?php echo esc_html( $infoLabelName ); ?></th>
	<td>
		&raquo; <?php _e('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[infoLabelName]" id="infoLabelName" value="<?php echo esc_attr( $options['infoLabelName'] ); ?>" style="width:200px;" />
	<dl>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the top page.', 'biz-vektor'), $infoLabelName ); ?></dt>
	<dd>
	<?php
		if(!isset($options['listInfoTop'])){ $options['listInfoTop'] = 'listType_set'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[listInfoTop]" value="listType_title" <?php echo ($options['listInfoTop'] != 'listType_set')? 'checked' : ''; ?> > <?php _e('Title only', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[listInfoTop]" value="listType_set" <?php echo ($options['listInfoTop'] == 'listType_set')? 'checked' : ''; ?> > <?php _e('With excerpt and thumbnail', 'biz-vektor'); ?></label>
	</dd>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the archive page.', 'biz-vektor'), $infoLabelName ); ?></dt>
	<dd>
	<?php
		if(!isset($options['listInfoArchive'])){ $options['listInfoArchive'] = 'listType_set'; }
	?>
	<label><input type="radio" name="biz_vektor_theme_options[listInfoArchive]" value="listType_title" <?php echo ($options['listInfoArchive'] != 'listType_set')? 'checked' : ''; ?> > <?php _e('Title only', 'biz-vektor'); ?></label>
	<label><input type="radio" name="biz_vektor_theme_options[listInfoArchive]" value="listType_set" <?php echo ($options['listInfoArchive'] == 'listType_set')? 'checked' : ''; ?> > <?php _e('With excerpt and thumbnail', 'biz-vektor'); ?></label>
	</dd>
	</dl>
	<dl>
		<dt><?php printf(__('Number of %s posts to be displayed on the home page.', 'biz-vektor'),$infoLabelName);?></dt>
		<dd><input type="text" name="biz_vektor_theme_options[infoTopCount]" id="postTopCount" value="<?php echo esc_attr( $options['infoTopCount'] ); ?>" style="width:50px;" /> <?php _ex('posts', 'top page post count', 'biz-vektor') ;?><br />
		<?php _e('If you enter &quot0&quot, this section will disappear.', 'biz-vektor') ;?></dd>
	</dl>

	<dl>
		<dt><?php echo $infoLabelName;?> のトップのURL</dt>
		<dd><?php $infoTopUrl = home_url().'/info/'; ?>
			* 通常 <a href="<?php echo esc_url($infoTopUrl);?>" target="_blank"><?php echo $infoTopUrl;?></a> が『<?php echo $infoLabelName;?>』のトップになります。
			<input type="text" name="biz_vektor_theme_options[infoTopUrl]" id="postTopUrl" value="<?php echo esc_attr( $options['infoTopUrl'] ); ?>" style="width:80%" />
		</dd>
	</dl>
</td>
</tr>
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
		<dd><input type="text" name="biz_vektor_theme_options[postTopCount]" id="postTopCount" value="<?php echo esc_attr( $options['postTopCount'] ); ?>" style="width:50px;" /> <?php _ex('posts', 'top page post count', 'biz-vektor') ;?><br />
		<?php _e('If you enter &quot0&quot, this section will disappear.', 'biz-vektor') ;?></dd>
	</dl>
	<!-- /Post display count -->
	<dl>
		<dt><?php echo $postLabelName;?> のトップのURL</dt>
		<dd><?php $postTopUrl = esc_html(home_url().'/post/'); ?>
			* <?php echo $postLabelName;?> 用のトップページを設定していない場合は空欄のままで構いません。
			<input type="text" name="biz_vektor_theme_options[postTopUrl]" id="postTopUrl" value="<?php echo esc_attr( $options['postTopUrl'] ); ?>" style="width:80%" /></dd>
	</dl>
	<dl>
		<dt><?php _e('Number of related posts', 'biz-vektor'); ?></dt>
		<dd><?php _e('Post of the same tag appears as a related posts under the content.', 'biz-vektor'); ?><br />
			<?php _e('Nothing is displayed when there is no article of the same tag.', 'biz-vektor'); ?><br />
			<input type="text" name="biz_vektor_theme_options[postRelatedCount]" id="postRelatedCount" value="<?php echo esc_attr( $options['postRelatedCount'] ); ?>" style="width:50px;" /> <?php _ex('posts', 'post count', 'biz-vektor') ;?><br />
			<?php _e('If you enter &quot0&quot, this section will disappear.', 'biz-vektor') ;?>
		</dd>
	</dl>

	<dl>
		<dt>広告の挿入 [ moreタグ ]</dt>
		<dd><textarea cols="20" rows="5" name="biz_vektor_theme_options[ad_content_moretag]" id="ad_content_moretag" value="" style="width:90%;" /><?php echo isset($options['ad_content_moretag']) ? $options['ad_content_moretag'] : ''; ?></textarea>
		</dd>
	</dl>
	<dl>
		<dt>広告の挿入 [ 本文下 ]</dt>
		<dd><textarea cols="20" rows="5" name="biz_vektor_theme_options[ad_content_after]" id="ad_content_after" value="" style="width:90%;" /><?php echo isset($options['ad_content_after']) ? $options['ad_content_after'] : ''; ?></textarea>
		</dd>
	</dl>
	<dl>
		<dt>広告の挿入 [ 関連記事下 ]</dt>
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
/*	SEO and Google Analytics Setting
/*-------------------------------------------*/
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
まずはトップページ用の固定ページを作成してください。<br />
[ <a href="<?php echo admin_url().'edit.php?post_type=page';?>" target="_blank">&raquo; 固定ページ</a> ]<br />
<?php _e('If the main page content of the set page is blank, the 3PR area will be displayed just below the main visual. Therefore, if you don\'t have any particular content to use it can be left blank.', 'biz-vektor'); ?>
</li>
<li>次に、『設定』→『表示設定』画面より、トップページに割り当てる固定ページを設定します。<br />
[ <a href="<?php echo admin_url().'options-reading.php';?>" target="_blank">&raquo; 表示設定</a> ]<br />
<p><?php _e('In the pull-down of the &quot;front page&quot;, please select the page that you created for the homepage.', 'biz-vektor') ;?><br />
<span class="alert"><?php _e('Do not select the drop-down &quot;post pages&quot;.', 'biz-vektor') ;?></span></p>
</li>
<li>トップページに表示する項目は<a href="<?php echo admin_url().'widgets.php';?>" target="_blank">ウィジェット編集画面</a>より、表示する項目や順番を自由に変更出来ます。
<a href="<?php echo admin_url().'widgets.php';?>" target="_blank">ウィジェット編集画面</a>の『メインコンテンツエリア（トップページ）』ウィジェットにウィジェットアイテムをセットしてください。
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
<td><?php _e('If you wish to link to a personal account or a Facebook page  banner will be displayed if you enter the URL.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[facebook]" id="facebook" value="<?php echo esc_attr( $options['facebook'] ); ?>" />
<span><?php _e('ex) ', 'biz-vektor') ;?>https://www.facebook.com/hidekazu.ishikawa</span>
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
<input type="text" name="biz_vektor_theme_options[fbAdminId]" id="fbAdminId" value="<?php echo esc_attr( $options['fbAdminId'] ); ?>" /><br />
<?php _e('* It is not the application ID of the Facebook page.', 'biz-vektor'); ?><br />
<?php _e('You can see the personal Facebook ID when you access the following url http://graph.facebook.com/(own url name(example: hidekazu.ishikawa)).', 'biz-vektor'); ?><br />
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
<input type="text" name="biz_vektor_theme_options[ogpImage]" id="ogpImage" value="<?php echo esc_attr( $options['ogpImage'] ); ?>" /> 
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
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsFront]" id="snsBtnsFront" value="false" <?php if ($options['snsBtnsFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsPage]" id="snsBtnsPage" value="false" <?php if ($options['snsBtnsPage']) {?> checked<?php } ?>> 
	<?php _ex('Page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsPost]" id="snsBtnsPost" value="false" <?php if ($options['snsBtnsPost']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('postLabelName')); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsInfo]" id="snsBtnsInfo" value="false" <?php if ($options['snsBtnsInfo']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('infoLabelName')); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></li>
</ul>
<p><?php _e('Within the type of page that is checked, if there is a particular page you do not wish to display, enter the Page ID. If multiple pages, please separate by commas.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[snsBtnsHidden]" id="ogpImage" value="<?php echo esc_attr( $options['snsBtnsHidden'] ); ?>" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>1,3,7</p>
</td>
</tr>
<!-- facebook comment -->
<tr>
<th><?php _e('facebook comments box', 'biz-vektor'); ?></th>
<td><?php _e('Please check the type of the page to display Facebook comments.', 'biz-vektor'); ?>
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsFront]" id="fbCommentsFront" value="false" <?php if ($options['fbCommentsFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPage]" id="fbCommentsPage" value="false" <?php if ($options['fbCommentsPage']) {?> checked<?php } ?>> 
	<?php _ex('Page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPost]" id="fbCommentsPost" value="false" <?php if ($options['fbCommentsPost']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('postLabelName')); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsInfo]" id="fbCommentsInfo" value="false" <?php if ($options['fbCommentsInfo']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('infoLabelName')); ?> <?php _ex('Post', 'sns display', 'biz-vektor'); ?></li>
</ul>
<p><?php _e('Within the type of page that is checked, if there is a particular page you do not wish to display, enter the Page ID. If multiple pages, please separate by commas.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[snsBtnsHidden]" id="ogpImage" value="<?php echo esc_attr( $options['snsBtnsHidden'] ); ?>" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>1,3,7</p>
</td>
</tr>
<!-- facebook LikeBox -->
<tr>
<th>facebook LikeBox</th>
<td><?php _e('If you wish to use Facebook LikeBox, please check the location.', 'biz-vektor'); ?><br />
<?php _e('* Please be sure to set Facebook application ID.', 'biz-vektor'); ?>
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFront]" id="fbLikeBoxFront" value="false" <?php if ($options['fbLikeBoxFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxSide]" id="fbLikeBoxSide" value="false" <?php if ($options['fbLikeBoxSide']) {?> checked<?php } ?>> 
	<?php _ex('Side bar', 'sns display', 'biz-vektor'); ?></li>
</ul>
<dl>
<dt><?php _e('URL of the Facebook page.', 'biz-vektor'); ?></dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxURL]" id="fbLikeBoxURL" value="<?php echo esc_attr( $options['fbLikeBoxURL'] ); ?>" /><br />
<span><?php _e('ex) ', 'biz-vektor') ;?>https://www.facebook.com/bizvektor</span></dd>
<dt><?php _e('Display stream', 'biz-vektor'); ?></dt>
<dd><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxStream]" id="fbLikeBoxStream" value="false" <?php if ($options['fbLikeBoxStream']) {?> checked<?php } ?>> <?php _e('Display', 'biz-vektor'); ?></dd>
<dt><?php _e('Display faces', 'biz-vektor'); ?></dt>
<dd><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFace]" id="fbLikeBoxFace" value="false" <?php echo ($options['fbLikeBoxFace']=='false')? "checked ":""; ?>> <?php _e('Display', 'biz-vektor'); ?></dd>
<dt><?php _e('Height of LikeBox', 'biz-vektor'); ?></dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxHeight]" id="fbLikeBoxHeight" value="<?php echo esc_attr( $options['fbLikeBoxHeight'] ); ?>" />
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
<th>Twitter Card の設定</th>
<td>
<p>
* Twitter Card のタグは、上記フォームでtwitterアカウントが入力されていないと表示されません。<br />
* Twitter Card の利用はtwitterへの申請が必要です。<a href="https://cards-dev.twitter.com/validator" target="_blank">こちら</a>から申請してください。<br />
* Twitter Card の画像は各記事のアイキャッチ画像が適用されます。アイキャッチ画像が無いページはデフォルトのOGP画像が適用されます。
</p>
</td>
</tr>
</table>
<?php submit_button(); ?>
</div>
</form>

<?php if(false){ ?>
<?php $resetkey = rand(1000,9999); ?>
<div class="option Advanced"><form action="" method="post">
<?php settings_fields( 'biz_vektor_options' ); ?>
<input type="hidden" name="bizvektor_action_mode" value="reset" />
<input type="hidden" name="bizvektor_reset_key"  value="<?php echo $resetkey; ?>" />
<p style="font-weight: bold;font-size: 23px;font-family: ariel;color:red"><?php echo $resetkey; ?></p>
<p>設定項目のリセットを行います。テーマカスタマイザーを含め全てのBizVektor設定がデフォルトに戻ります。了承される場合は上の数字を入力し、チェックボックスをクリックして「設定を初期化」ボタンをクリックしてください。</p>
<input type="text" name="bizvektor_reset_key_port" value="" />
<label><input type="checkbox" name="bizvektor_reset_check" value="True" />私は設定を初期化します</label>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="設定を初期化"  /></p>
</form></div>

<div class="optionNav bottomNav">
<ul><li><a href="#wpwrap"><?php _e('Page top', 'biz-vektor'); ?></a></li></ul>
</div>
<?php } ?>

</div><!-- [ /#main-content ] -->
</div><!-- [ /#biz_vektor_options ] -->
<?php
}