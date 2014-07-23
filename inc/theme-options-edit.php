<?php
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

function biz_vektor_theme_options_render_page() { ?>
	<div class="wrap" id="biz_vektor_options">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'biz-vektor' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<?php if ( function_exists( 'biz_vektor_activation' ) ) {
		biz_vektor_activation_information();
		} else { ?>
		<div id="sub-content">

		<iframe frameborder="0" height="200" marginheight="0" marginwidth="0" scrolling="auto" src="http://bizvektor.com/info-admin/"></iframe>

		</div>
		<?php } ?>
		
		<div id="main-content">
		<p class="message_intro">
	<?php $customizer_link = '<a href="'.get_admin_url().'customize.php">'.__('Theme customizer','biz-vektor').'</a>'; ?>
	<?php _e('Thank you for using BizVektor.', 'biz-vektor');?> 
	<?php printf(__('You can change basic design settings from %s', 'biz-vektor'),$customizer_link); ?> <br />
	<?php _e('Here you can change social media settings.','biz-vektor'); ?>
		</p>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'biz_vektor_options' );
				$options = biz_vektor_get_theme_options();
				$default_options = biz_vektor_get_default_theme_options();
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
		foreach ( biz_vektor_layouts() as $layout ) {
			?>
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
	$biz_vektor_font_titles = array('serif' => _x('Serif', 'biz-vektor theme-customizer', 'biz-vektor'),'sanserif' => _x('Sanserif', 'biz-vektor theme-customizer', 'biz-vektor'),);
	foreach( $biz_vektor_font_titles as $biz_vektor_font_titleValue => $biz_vektor_font_titleLavel) {
		if ( $biz_vektor_font_titleValue == $options['font_title'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[font_title]" value="<?php echo $biz_vektor_font_titleValue ?>" checked> <?php echo $biz_vektor_font_titleLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[font_title]" value="<?php echo $biz_vektor_font_titleValue ?>"> <?php echo $biz_vektor_font_titleLavel ?></label>
		<?php }
	}
	?>
	<td>
	</tr>
	<!-- Global Menu font -->
	<tr>
	<th><?php _ex('Global Menu font', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<?php
	$biz_vektor_font_menus = array('serif' => _x('Serif', 'biz-vektor theme-customizer', 'biz-vektor'),'sanserif' => _x('Sanserif', 'biz-vektor theme-customizer', 'biz-vektor'),);
	foreach( $biz_vektor_font_menus as $biz_vektor_font_menuValue => $biz_vektor_font_menuLavel) {
		if ($biz_vektor_font_menuValue == $options['font_menu'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[font_menu]" value="<?php echo $biz_vektor_font_menuValue ?>" checked> <?php echo $biz_vektor_font_menuLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[font_menu]" value="<?php echo $biz_vektor_font_menuValue ?>"> <?php echo $biz_vektor_font_menuLavel ?></label>
		<?php }
	}
	?>
	<td>
	</tr>
	<!-- Sidebar Child page menu display -->
	<tr>
	<th><?php _e('Deployment of the sidebar menu', 'biz-vektor') ;?></th>
	<td>
		<p><?php _e('If the site hierarchy is deep, you can choose to hide this menu hierarchy other than the Page you are currently viewing.', 'biz-vektor');?></p>
	<?php
	$biz_vektor_side_childs = array('side_child_display' => __('Display', 'biz-vektor'),'side_child_hidden' => __('Hide', 'biz-vektor'),);
	foreach( $biz_vektor_side_childs as $biz_vektor_side_childValue => $biz_vektor_side_childLavel) {
		if ( $biz_vektor_side_childValue == $options['side_child_display'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[side_child_display]" value="<?php echo $biz_vektor_side_childValue ?>" checked> <?php echo $biz_vektor_side_childLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[side_child_display]" value="<?php echo $biz_vektor_side_childValue ?>"> <?php echo $biz_vektor_side_childLavel ?></label>
		<?php }
	}
	?>
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
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _ex('Office hours', 'biz-vektor theme-customizer', 'biz-vektor') ;?> 9:00 - 18:00 (<?php _e('Weekdays except holidays', 'biz-vektor') ;?>)</span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _ex('Site / Company / Store / Service name. This is displayed in the left part of the footer bottom and footer copyright section.', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br />
	</th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[sub_sitename]" id="sub_sitename" value="" style="width:50%;" /><?php echo esc_attr( $options['sub_sitename'] ); ?></textarea><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _e('BizVektor, Inc.', 'biz-vektor') ;?></span><br />
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
<!-- Information layout -->
<tr>
	<th><?php echo esc_html( $infoLabelName ); ?></th>
	<td>
		&raquo; <?php _e('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[infoLabelName]" id="infoLabelName" value="<?php echo esc_attr( $options['infoLabelName'] ); ?>" style="width:200px;" />
	<dl>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the top page.', 'biz-vektor'), $infoLabelName ); ?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array(
		'listType_title' => __('Title only', 'biz-vektor'),
		'listType_set' => __('With excerpt and thumbnail', 'biz-vektor')
	);
	foreach( $biz_vektor_listTypes as $biz_vektor_listTypeValue => $biz_vektor_listTypeLavel) {
		if ( $biz_vektor_listTypeValue == $options['listInfoTop'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listInfoTop]" value="<?php echo $biz_vektor_listTypeValue ?>" checked> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listInfoTop]" value="<?php echo $biz_vektor_listTypeValue ?>"> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php }
	}
	?>
	</dd>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the archive page.', 'biz-vektor'), $infoLabelName ); ?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array(
		'listType_title' => __('Title only', 'biz-vektor'),
		'listType_set' => __('With excerpt and thumbnail', 'biz-vektor')
	);
	foreach( $biz_vektor_listTypes as $biz_vektor_listTypeValue => $biz_vektor_listTypeLavel) {
		if ( $biz_vektor_listTypeValue == $options['listInfoArchive'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listInfoArchive]" value="<?php echo $biz_vektor_listTypeValue ?>" checked> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listInfoArchive]" value="<?php echo $biz_vektor_listTypeValue ?>"> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php }
	}
	?>
	</dd>
	</dl>
</td>
</tr>
<!-- Post layout -->
<tr>
	<th><?php echo esc_html( bizVektorOptions('postLabelName')); ?></th>
	<td>
		&raquo; <?php _e('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[postLabelName]" id="postLabelName" value="<?php echo esc_attr( $options['postLabelName'] ); ?>" style="width:200px;" />
	<dl>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the top page.', 'biz-vektor'), $postLabelName ); ?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array(
		'listType_title' => __('Title only', 'biz-vektor'),
		'listType_set' => __('With excerpt and thumbnail', 'biz-vektor')
	);
	foreach( $biz_vektor_listTypes as $biz_vektor_listTypeValue => $biz_vektor_listTypeLavel) {
		if ( $biz_vektor_listTypeValue == $options['listBlogTop'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listBlogTop]" value="<?php echo $biz_vektor_listTypeValue ?>" checked> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listBlogTop]" value="<?php echo $biz_vektor_listTypeValue ?>"> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php }
	}
	?>
	</dd>
	<dt><?php printf(__('Display layout of &quot; %s &quot on the archive page.', 'biz-vektor'), $postLabelName ); ?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array(
		'listType_title' => __('Title only', 'biz-vektor'),
		'listType_set' => __('With excerpt and thumbnail', 'biz-vektor')
	);
	foreach( $biz_vektor_listTypes as $biz_vektor_listTypeValue => $biz_vektor_listTypeLavel) {
		if ( $biz_vektor_listTypeValue == $options['listBlogArchive'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listBlogArchive]" value="<?php echo $biz_vektor_listTypeValue ?>" checked> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listBlogArchive]" value="<?php echo $biz_vektor_listTypeValue ?>"> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php }
	}
	?>
	</dd>
	</dl>
</td>
</tr>
<!-- Post display count -->
<tr>
<th><?php printf(__('Number of %s posts to be displayed on the home page.', 'biz-vektor'),$postLabelName);?></th>
<td>
	<input type="text" name="biz_vektor_theme_options[postTopCount]" id="postTopCount" value="<?php echo esc_attr( $options['postTopCount'] ); ?>" style="width:50px;" /> <?php _ex('posts', 'top page post count', 'biz-vektor') ;?><br />
<?php _e('If you enter &quot0&quot, this section will disappear.', 'biz-vektor') ;?></td>
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
printf( __( 'Normally, BizVektor will include the %s in the title tag.', 'biz-vektor' ), $sitetitle_link );?><br />
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
$biz_vektor_gaTypes = array(
	'gaType_normal' => __('To output only normal code (default)', 'biz-vektor'),
	'gaType_universal' => __('To output the Universal Analytics code', 'biz-vektor'),
	'gaType_both' => __('To output both types', 'biz-vektor')
	);
foreach( $biz_vektor_gaTypes as $biz_vektor_gaTypeValue => $biz_vektor_gaTypeLavel) {
	if ( $biz_vektor_gaTypeValue == $options['gaType'] ) { ?>
	<label><input type="radio" name="biz_vektor_theme_options[gaType]" value="<?php echo $biz_vektor_gaTypeValue ?>" checked> <?php echo $biz_vektor_gaTypeLavel ?></label><br />
	<?php } else { ?>
	<label><input type="radio" name="biz_vektor_theme_options[gaType]" value="<?php echo $biz_vektor_gaTypeValue ?>"> <?php echo $biz_vektor_gaTypeLavel ?></label><br />
	<?php }
}
?>
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
<td><p>[ <a href="<?php echo get_admin_url(); ?>options-reading.php" target="_blank">
	&raquo; <?php _e('Setting for the page to display just below the main visual of home page.', 'biz-vektor'); ?></a> ]</p>
<p><?php _e('Select &quot;Recent post&quot; or &quot;page&quot;.', 'biz-vektor') ;?><br />
<span class="alert">
* <?php _e('Do not select the drop-down &quot;post pages&quot;.', 'biz-vektor') ;?></span><br />
* <?php _e('If the main page content of the set page is blank, the 3PR area will be displayed just below the main visual. Therefore, if you don\'t have any particular content to use it can be left blank.', 'biz-vektor'); ?></p></td>
<p><?php _e('Check this box if you want to display the page title below the main visual on the home page.', 'biz-vektor'); ?></p>
<p><input type="checkbox" name="biz_vektor_theme_options[topEntryTitleDisplay]" id="topEntryTitleDisplay" value="true" <?php if ($options['topEntryTitleDisplay']) {?> checked<?php } ?>> <?php _e('Display the title', 'biz-vektor'); ?></p></td>
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
<!-- RSS -->
<tr>
	<th><?php echo esc_html( bizVektorOptions('rssLabelName')); ?>(<?php _e('RSS information display settings', 'biz-vektor'); ?>) </th>
	<td><span style="font-size:14px;font-weight:lighter;">&raquo; <?php _e('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[rssLabelName]" id="rssLabelName" value="<?php echo esc_attr( $options['rssLabelName'] ); ?>" style="width:200px;" /></span>
<p>
	<?php _e('Enter the URL of the RSS feed if you are using feeds from related sites or external blog to be posted on the home page of this site.', 'biz-vektor'); ?><br />
	<input type="text" name="biz_vektor_theme_options[blogRss]" id="blogRss" value="<?php echo esc_attr( $options['blogRss'] ); ?>" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?>http://www.XXXX.jp/?feed=rss2</span>
</p>
</td>
</tr>
<!-- Home bottom free area -->
<tr>
	<th><?php _e('Home bottom free area', 'biz-vektor'); ?></th>
<td>
<p><?php printf(__('Displayed in the lower part of the list, [%s] and [%s].', 'biz-vektor'),$infoLabelName,$postLabelName); ?><br />
<textarea cols="50" rows="4" name="biz_vektor_theme_options[topContentsBottom]" id="topContentsBottom" value="" style="width:90%;"><?php echo esc_attr( $options['topContentsBottom'] ); ?></textarea></p>
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
<dd><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFace]" id="fbLikeBoxFace" value="false" <?php if ($options['fbLikeBoxFace']) {?> checked<?php } ?>> <?php _e('Display', 'biz-vektor'); ?></dd>
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
<p><?php _e('If other plug-ins are used for the OGP, do not output the OGP using BizVektor.', 'biz-vektor'); ?></p>
<?php
$biz_vektor_ogpTags = array(
	'ogp_on' 	=> __('I want to output the OGP tags using BizVektor', 'biz-vektor'),
	'ogp_off' 	=> __('Do not output OGP tags using BizVektor', 'biz-vektor')
	);
foreach( $biz_vektor_ogpTags as $biz_vektor_ogpTagValue => $biz_vektor_ogpTagLavel) {
	if ( $biz_vektor_ogpTagValue == $options['ogpTagDisplay'] ) { ?>
	<label><input type="radio" name="biz_vektor_theme_options[ogpTagDisplay]" value="<?php echo $biz_vektor_ogpTagValue ?>" checked> <?php echo $biz_vektor_ogpTagLavel ?></label><br />
	<?php } else { ?>
	<label><input type="radio" name="biz_vektor_theme_options[ogpTagDisplay]" value="<?php echo $biz_vektor_ogpTagValue ?>"> <?php echo $biz_vektor_ogpTagLavel ?></label><br />
	<?php }
} ?>
</td>
</tr>
</table>
<?php submit_button(); ?>
</div>
<div class="optionNav bottomNav">
<ul><li><a href="#wpwrap"><?php _e('Page top', 'biz-vektor'); ?></a></li></ul>
</div>
</form>
</div><!-- [ /#main-content ] -->
</div><!-- [ /#biz_vektor_options ] -->
<?php
}

function biz_vektor_theme_options_validate( $input ) {
	$output = $defaults = biz_vektor_get_default_theme_options();


	if($input['theme_layout'] == ''){ $input['theme_layout'] = "content-sidebar"; }
	if(preg_match('/^(\s|[ 　]*)$/', $input['postLabelName'])){ $input['postLabelName'] = "Blog"; }
	if(preg_match('/^(\s|[ 　]*)$/', $input['infoLabelName'])){ $input['infoLabelName'] = "Information"; }
	if($input['rssLabelName'] == ''){ $input['theme_layout'] = "Blog entries"; }
	if($input['theme_style'] == ''){ $input['theme_style'] = "default"; }

	if(preg_match('/^(\s|[ 　]*)$/', $input['pr1_title'])){ $input['pr1_title'] = __('Rich theme options', 'biz-vektor'); }
	if(preg_match('/^(\s|[ 　]*)$/', $input['pr1_description'])){ $input['pr1_description'] = __('This area can be changed from the theme customizer as well as from the theme options section.', 'biz-vektor'); }
	if(preg_match('/^(\s|[ 　]*)$/', $input['pr2_title'])){ $input['pr2_title'] = __('Various designs available', 'biz-vektor'); }
	if(preg_match('/^(\s|[ 　]*)$/', $input['pr2_description'])){ $input['pr2_description'] = __('BizVektor will allow you not only to change the color of the site, but also to switch to a different design.', 'biz-vektor'); }
	if(preg_match('/^(\s|[ 　]*)$/', $input['pr3_title'])){ $input['pr3_title'] = __('Optimized for business web sites', 'biz-vektor'); }
	if(preg_match('/^(\s|[ 　]*)$/', $input['pr3_description'])){ $input['pr3_description'] = __('Various indispensable business features as child page templates or enquiry capture are included.', 'biz-vektor'); }



	$keylist = array_keys($input);
	foreach($keylist as $key){
		if(isset($input[$key])) { $output[$key] = $input[$key]; }
	}

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], biz_vektor_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];
	// sidebar child menu display
	if( isset($input['side_child_display']) && $input['side_child_display'] ){ $output['side_child_display'] = $input['side_child_display']; }

	if(!preg_match("/.+\.ico$/i", $output['favicon'])){ $output['favicon'] = ''; }


	return apply_filters( 'biz_vektor_theme_options_validate', $output, $input, $defaults );
}

?>
