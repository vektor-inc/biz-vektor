<?php
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
	<?php printf(__('You can change basic design settings in %s', 'biz-vektor'),$customizer_link); ?> <br />
	<?php _e('You can change other settings in this page.','biz-vektor'); ?>
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
		<?php printf(__('This section is also able to change from %s', 'biz-vektor'), $customizer_link ); ?>
	</span>
</h3>
	<table class="form-table">
	<tr>
	<th><?php _e('Design skin', 'biz-vektor') ?></th>
	<td>
	<select name="biz_vektor_theme_options[theme_style]" id="<?php echo esc_attr( $options['theme_style'] ); ?>">
	<option>[ <?php _e('Select', 'biz-vektor') ?> ]</option>
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
	$themePlusSettingNavi = '<p>'.__('* If there is a setting item of each design skin, after you save your changes, you can set from theme customizer.', 'biz-vektor').'</p>';
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
	<option>[ <?php _e('Select', 'biz-vektor') ?> ]</option>
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
	[ <a href="http://bizvektor.com/setting/menu/" target="_blank">&raquo; <?php _e('How to set up Menus', 'biz-vektor') ;?></a> ]
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
			$toppage_setting_link = '<a href="#topPage">'.__('Home page setting', 'biz-vektor').'</a>';
			printf( __('[Top page] %s', 'biz-vektor'), $toppage_setting_link );?>
		</li>
		<li><?php _e('[page] Edit Page > Page Attributes > Template', 'biz-vektor') ;?></li>
	</ul>
	</td>
	</tr>
	<!-- Font of headings -->
	<tr>
	<th><?php _ex('Font of headings', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
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
	<!-- Font of Menus -->
	<tr>
	<th><?php _ex('Font of Menus', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<?php
	$biz_vektor_font_menus = array('serif' => _x('Serif', 'biz-vektor theme-customizer', 'biz-vektor'),'sanserif' => _x('Sanserif', 'biz-vektor theme-customizer', 'biz-vektor'),);
	foreach( $biz_vektor_font_menus as $biz_vektor_font_menuValue => $biz_vektor_font_menuLavel) {
		if ( $biz_vektor_font_menuValue == $options['font_menu'] ) { ?>
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
		<p><?php _e('If the site hierarchy is deep, you can choose to hide this menu hierarchy other than the fixed page you are currently viewing.', 'biz-vektor');?></p>
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
	<p>* <?php _e('It can not be set from the theme customizer.', 'biz-vektor') ;?></p>
	<td>
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
			<?php printf(__('This section is also able to change from %s', 'biz-vektor'), $customizer_link ); ?>
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
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _ex('Office hours', 'biz-vektor theme-customizer', 'biz-vektor') ;?> 9：00～18：00（<?php _e('Weekdays except holidays', 'biz-vektor') ;?>）</span>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _ex('Site / Company / Store / Service name. This is displayed in footer let bottom and footer copyright.', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br />
	</th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[sub_sitename]" id="sub_sitename" value="" style="width:50%;" /><?php echo esc_attr( $options['sub_sitename'] ); ?></textarea><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?><?php _e('BizVektor, Inc.', 'biz-vektor') ;?></span><br />
	<?php _e('* Use this feature when the site name has become longer for the SEO measures.', 'biz-vektor') ;?>
	</td>
	</tr>
	<!-- Company address -->
	<tr>
	<th scope="row"><?php _ex('Company address', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br /><?php _e('This is displayed in footer let bottom and footer copyright.', 'biz-vektor') ;?></th>
	<td>
	<textarea cols="20" rows="5" name="biz_vektor_theme_options[contact_address]" id="contact_address" value="" style="width:50%;" /><?php echo $options['contact_address'] ?></textarea><br />
		<span><?php _e('ex) ', 'biz-vektor') ;?>
		<?php _e('316, Minami Sakae Building,<br />1-22-16, Sakae, Naka-ku, Nagoya-shi,<br />Aichi 460-0008 JAPAN<br />TEL / FAX +81-52-228-9176', 'biz-vektor') ;?>
		</span>
	</td>
	</tr>
	<!-- he URL of contact page -->
	<tr>
	<th scope="row"><?php _ex('The URL of contact page', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
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
			<?php printf(__('This section is also able to change from %s', 'biz-vektor'), $customizer_link ); ?>
		</span>
	</h3>
	<?php _e('* 3PR area do not appear on the top page in the case of blank all.', 'biz-vektor') ;?><br />
	<?php _e('* It is effective without the image.', 'biz-vektor') ;?><br />
	<span class="alert">
		<?php _e('* You can register image for PC and for smartphone.', 'biz-vektor') ;?>
	</span>
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
<dt><?php _e('Image for PC', 'biz-vektor') ;?></dt>
<dd>
<span class="mediaSet">
<input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_image]" class="media_text" id="pr<?php echo $i; ?>_image" value="<?php echo esc_attr( $options['pr'.$i.'_image'] ); ?>" /> 
<button id="media_pr<?php echo $i; ?>_image" class="media_btn"><?php _e('Select image', 'biz-vektor') ;?></button></span>
<?php _e('310px width is recommended.', 'biz-vektor') ;?></dd>
<dt><?php _e('Image for smartphone', 'biz-vektor') ;?></dt>
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
		printf( __('Settings of [ %s ] and [ %s ].', 'biz-vektor'),$infoLabelName,$postLabelName);
		?>
</h3>
<?php _e('* It does not appear if there is no post at all.', 'biz-vektor') ;?><br />
<?php _e('* If the excerpt field is filled, the content will appear in the &quot;excerpt&quot;. If not, the text will be displayed in a certain number of', 'biz-vektor') ;?><br />
<?php
	$plugin_link = '<a href="'.get_admin_url().'plugins.php" target="_blank">'._x('Plugins page','no link', 'biz-vektor').'</a>';
	?>
  <?php _e('In the case of corporal, full text will be displayed plug-in [WP Multibyte Patch] is not activated if the Japanese version.', 'biz-vektor'); ?>
	
	<?php printf(__('Please enable [WP Multibyte Patch] from the %s.', 'biz-vektor'), $plugin_link ); ?><br />
* <?php _e('<span class="alert">Thumbnail image of the article</span> is displayed.', 'biz-vektor') ;?><br />
	<?php _e('Eye-catching image, you can register from the widget at the bottom right of each article edit screen.', 'biz-vektor') ;?><br />
	<?php _e('If you do not have a widget, please check the item of &quot;thumbnail&quot; at the top right of the screen from the &quot;Screen options&quot; tab.', 'biz-vektor') ;?>

<table class="form-table">
<!-- Information layout -->
<tr>
	<th><?php echo esc_html( bizVektorOptions('infoLabelName')); ?></th>
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
<th><?php printf(__('Number of %s to be displayed on the home page.', 'biz-vektor'),$postLabelName);?></th>
<td>
	<input type="text" name="biz_vektor_theme_options[postTopCount]" id="postTopCount" value="<?php echo esc_attr( $options['postTopCount'] ); ?>" style="width:50px;" /> <?php _ex('posts', 'top page post count', 'biz-vektor') ;?><br />
<?php _e('If you enter &quot0&quot, this section itself will disappear.', 'biz-vektor') ;?></td>
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
<h3><?php _e('SEO and Google Analytics Setting', 'biz-vektor'); ?></h3>
<table class="form-table">
<tr>
<th><?php _e('&lt;title&gt; tag of homepage', 'biz-vektor'); ?></th>
<td>
<p>
<?php
$sitetitle_link = '<a href="'.get_admin_url().'options-general.php" target="_blank">'.__('title of the site', 'biz-vektor').'</a>';
printf( __( 'Normally, BizVektor will include the %s in the title tag.', 'biz-vektor' ), $sitetitle_link );?><br />
<?php _e('For example, it appears in the form of <br />&lt;title&gt;page title | site title&lt;/title&gt;<br /> if fixed page.', 'biz-vektor'); ?>
<?php
printf( __('However, evaluation of the search engines so bad number of characters in the &lt;title&gt; is too long, <strong>and incorporate keywords that wants to be retrieved by most, are summarized as short as possible</strong>, it is desirable that the %s.', 'biz-vektor'),$sitetitle_link) ; ?>
<?php _e('However, it will not be connected to such as a page name, as described above in the top page, it is possible to put the &lt;title&gt; longer bit more, it is now can be set separately here.', 'biz-vektor'); ?></p>
<input type="text" name="biz_vektor_theme_options[topTitle]" id="topTitle" value="<?php echo esc_attr( $options['topTitle'] ); ?>" style="width:90%;" />
<p>* <?php _e('Site title will be applied if this field is blank.', 'biz-vektor'); ?></p>
</td>
</tr>
<tr>
<th><?php _e('Common keywords', 'biz-vektor'); ?></th>
<td><?php _e('In the keywords meta tag, the keywords you put in common throughout the site , Please enter separated.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[commonKeyWords]" id="commonKeyWords" value="<?php echo esc_attr( $options['commonKeyWords'] ); ?>" style="width:90%;" /><br />
<?php _e('* You do not have to think very seriously because it does not affect the evaluation of search engine from now.', 'biz-vektor'); ?><br />
<?php _e('* The keywords of each page individually, enter from edit page of each article. About 10 maximum in conjunction with the common keywords is desirable.', 'biz-vektor'); ?><br />
<?php _e('* Not required , at the end of the keyword column last.', 'biz-vektor'); ?><br />
<?php _e('ex) WordPress,Template,Theme,Free,GPL', 'biz-vektor'); ?>
</td>
</tr>
<tr>
<th><?php _ex('Description', 'Description setting', 'biz-vektor'); ?></th>
<td>
<?php _e('What you have to fill in the edit page of each page in the "excerpt" field is reflected in the description of meta tags.', 'biz-vektor'); ?><br />
<?php _e('In the search results screen of search sites such as Google, description for meta tags appears, for example, under the site title.', 'biz-vektor'); ?><br />
<?php _e('If the excerpt field is blank, it is the specification to be applied as a description is 240 characters from text beginning of a sentence.', 'biz-vektor'); ?><br />
<?php _e('* If the excerpt field is not visible, there is a tab called "View" in the upper right corner of the edit page, check box to display the "excerpt" field because you come out when you click there, check.', 'biz-vektor'); ?>
</td>
</tr>
<!-- Google Analytics -->
<tr>
<th><?php _e('Google Analytics Setting', 'biz-vektor'); ?></th>
<td><?php _e('Please fill in the ID of the Analytics When you embed tags GoogleAnalytics.', 'biz-vektor'); ?><br />
<p>UA-<input type="text" name="biz_vektor_theme_options[gaID]" id="gaID" value="<?php echo esc_attr( $options['gaID'] ); ?>" style="width:90%;" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>XXXXXXXX-X</p>

	<dl>
	<dt><?php _e('Please select the type of analysis to be output tag. (It does not matter if you skip if you do not know well.)', 'biz-vektor'); ?></dt>
	<dd>
<?php
$biz_vektor_gaTypes = array(
	'gaType_normal' => __('To output only tag analysis of normal (default)', 'biz-vektor'),
	'gaType_universal' => __('I want to output only tag analysis of Universal Analytics', 'biz-vektor'),
	'gaType_both' => __('I want to output both tags', 'biz-vektor')
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
<h3><?php _e('Home page setting', 'biz-vektor') ;?></h3>
<table class="form-table">
<tr>
<th><?php _e('Main visual', 'biz-vektor') ;?></th>
<td><?php _e('You can set a slide show or still image.', 'biz-vektor') ;?>
<ul>
<li>[ <a href="<?php echo get_admin_url(); ?>themes.php?page=custom-header" target="_blank">
	&raquo; <?php _e('Still image setting', 'biz-vektor') ;?></a> ]</li>
<li>[ <a href="#slideSetting">
	&raquo; <?php _e('Slide show setting', 'biz-vektor') ;?></a> ]</li>
</ul></td>
</tr>
<!-- Page to be displayed below the main visual -->
<tr>
<th id="topEntryTitleHidden"><?php _e('Page to be displayed below the main visual', 'biz-vektor') ;?></th>
<th><p>[ <a href="<?php echo get_admin_url(); ?>options-reading.php" target="_blank">
	&raquo; <?php _e('Setting of the page to display just below the main visual of home page', 'biz-vektor'); ?></a> ]</p>
<p><?php _e('Select &quot;Recent post&quot; or &quot;page&quot;.', 'biz-vektor') ;?><br />
<span class="alert">
* <?php _e('Do not select the pull-down &quot;post pages&quot;.', 'biz-vektor') ;?></span><br />
* <?php _e('If blank, the body of the page you have set will be displayed 3PR area is just below the main visual. Therefore, it can be a blank text field is Without having to fill in particular.', 'biz-vektor'); ?></p></td>
<p><?php _e('Check this box if you want to display the title of the page to be displayed in the main visual under the home page.', 'biz-vektor'); ?></p>
<p><input type="checkbox" name="biz_vektor_theme_options[topEntryTitleDisplay]" id="topEntryTitleDisplay" value="true" <?php if ($options['topEntryTitleDisplay']) {?> checked<?php } ?>> <?php _e('Display the title', 'biz-vektor'); ?></p></td>
</tr>
<!-- Home 3PR area -->
<tr>
<th><?php _e('Home 3PR area', 'biz-vektor'); ?></th>
<td>
<ul>
<li>[ <a href="#prBox">&raquo; <?php _e('Setting the Home 3PR area is here', 'biz-vektor'); ?></a> ]</li>
</ul></td>
</tr>
<!-- TopEntryTitleHidden -->
<tr>
<th id="topEntryTitleHidden">
	<?php _e('The display of the side bar of a home page.', 'biz-vektor'); ?></th>
<th><p>
	<?php _e('Check this box if you do not want to see the side bar on the home page.', 'biz-vektor'); ?></p>
<p><input type="checkbox" name="biz_vektor_theme_options[topSideBarDisplay]" id="topSideBarDisplay" value="true" <?php if ($options['topSideBarDisplay']) {?> checked<?php } ?>> <?php _e('I want to hide the sidebar', 'biz-vektor'); ?></p></td>
</tr>
<!-- Display number of Blog -->
<tr>
	<th><?php
	$postLabelName = esc_html( bizVektorOptions('postLabelName'));
	printf(__('Display number of %s', 'biz-vektor'), $postLabelName ); ?></th>
	<td><a href="#postSetting">
		<?php
		$infoLabelName = esc_html( bizVektorOptions('infoLabelName'));
		$postLabelName = esc_html( bizVektorOptions('postLabelName'));
		printf( __('Please set from the [ Setting the %s and %s ].', 'biz-vektor'),$infoLabelName,$postLabelName);
		?>
		</a>
	</td>
</tr>
<!-- RSS -->
<tr>
	<th><?php echo esc_html( bizVektorOptions('rssLabelName')); ?>（<?php _e('RSS information display setting', 'biz-vektor'); ?>） </th>
	<td><span style="font-size:14px;font-weight:lighter;">&raquo; <?php _e('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[rssLabelName]" id="rssLabelName" value="<?php echo esc_attr( $options['rssLabelName'] ); ?>" style="width:200px;" /></span>
<p>
	<?php _e('Enter the address of the RSS if you are using the RSS of related sites and external blog, then be posted on the home page of this site for updates.', 'biz-vektor'); ?><br />
	<input type="text" name="biz_vektor_theme_options[blogRss]" id="blogRss" value="<?php echo esc_attr( $options['blogRss'] ); ?>" /><br />
	<span><?php _e('ex) ', 'biz-vektor') ;?>http://www.XXXX.jp/?feed=rss2</span>
</p>
</td>
</tr>
<!-- Home bottom free area -->
<tr>
	<th><?php _e('Home bottom free area', 'biz-vektor'); ?></th>
<td>
<p><?php printf(__('It is displayed in the lower part of the list and [%s] and [%s].', 'biz-vektor'),$infoLabelName,$postLabelName); ?><br />
<textarea cols="50" rows="4" name="biz_vektor_theme_options[topContentsBottom]" id="topContentsBottom" value="" style="width:90%;"><?php echo esc_attr( $options['topContentsBottom'] ); ?></textarea></p>
</td>
</tr>
</table>

<?php submit_button(); ?>
</div>

<?php
/*-------------------------------------------*/
/*	SlideSetting
/*-------------------------------------------*/
?>
<div id="slideSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3><?php _e('Slide　show　Setting', 'biz-vektor'); ?></h3>
<p><?php _e('Please enter the URL of the image, such as that displayed when you want to set the slide show.', 'biz-vektor'); ?><br />
<?php _e('The recommended size of the image is 950 × 250px.', 'biz-vektor'); ?><br />
<?php
$topVisualLink = '<a href="'.get_admin_url().'themes.php?page=custom-header" target="_blank">'.__('Main visual Home', 'biz-vektor').'</a>';
printf(__('%s will be displayed if the slide show is not set.', 'biz-vektor'),$topVisualLink); ?><br />
<?php　_e('It can be only the URL of the image. However, the link is set in the image If you enter a link URL.', 'biz-vektor'); ?><br />
<?php _e('Please enter a character the contents of the image alternate text.', 'biz-vektor'); ?>
<?php _e('It becomes easy to hit to search the direction as which it was entered by the contents. ', 'biz-vektor'); ?>
<?php _e('Moreover, when a visually handicapped person peruses, a text-to-speech-reading browser reads out the character. ', 'biz-vektor'); ?>
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
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideImage ?>]" id="<?php echo $slideImage ?>" value="<?php echo esc_attr( $options[$slideImage] ) ?>" /> <button id="media_<?php echo $slideImage ?>" class="media_btn"><?php _e('Select a image', 'biz-vektor'); ?></button>
</td>
<td><?php _e('Alternate text', 'biz-vektor'); ?>（alt）　[<?php echo $i ?>]<br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideAlt ?>]" id="<?php echo $slideAlt ?>" value="<?php echo esc_attr( $options[$slideAlt] ) ?>" /></td>
<td>
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideDisplay ?>]" id="<?php echo $slideDisplay ?>" value="true" <?php if ($options[$slideDisplay]) :echo ' checked';endif; ?>> <?php _ex('Undisplayed', 'Slide undisplayed', 'biz-vektor'); ?></label><br />
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideBlank ?>]" id="<?php echo $slideBlank ?>" value="true" <?php if ($options[$slideBlank]) :echo ' checked';endif; ?>> <?php _e('Open in a blank window', 'biz-vektor'); ?></label>
</td>
</tr>
<?php
	$i++;
} ?>

</table>
<p><?php _e('* If you visit in the environment in which the communications line is slow, because of the time or bought in the display, it is subject to deduction from search engine or withdrawal of the user, three or less is recommended.', 'biz-vektor'); ?>
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
<h3><?php _e('SNS cooperation', 'biz-vektor'); ?></h3>
<?php _e('There is no problem with setting later if you do not know well.', 'biz-vektor'); ?>
<table class="form-table">
<tr>
<th>facebook</th>
<td><?php _e('Banner will be displayed if you enter a URL if you want to link to a personal account or facebook page.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[facebook]" id="facebook" value="<?php echo esc_attr( $options['facebook'] ); ?>" />
<span><?php _e('ex) ', 'biz-vektor') ;?>https://www.facebook.com/hidekazu.ishikawa</span>
</td>
</tr>
<!-- facebook application ID -->
<tr>
<th><?php _e('facebook application ID', 'biz-vektor'); ?></th>
<td><input type="text" name="biz_vektor_theme_options[fbAppId]" id="fbAppId" value="<?php echo esc_attr( $options['fbAppId'] ); ?>" />
<span>[ <a href="https://developers.facebook.com/apps" target="_blank">&raquo; <?php _e('I will check and get the application ID', 'biz-vektor'); ?></a> ]</span><br />
<?php _e('* If application ID is not inputted, neither a Like button nor the comment field displays and operates correctly.', 'biz-vektor'); ?><br />
<?php _e('Please search such as [facebook application ID acquisition] If you do not know much about how to get application ID of facebook.', 'biz-vektor'); ?>
</td>
</tr>
<!-- facebook user ID -->
<tr>
<th><?php _e('facebook user ID (optional)', 'biz-vektor'); ?></th>
<td><?php _e('Please enter the facebook user ID of the administrator.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[fbAdminId]" id="fbAdminId" value="<?php echo esc_attr( $options['fbAdminId'] ); ?>" /><br />
<?php _e('* It is not the application ID of the facebook page.', 'biz-vektor'); ?><br />
<?php _e('The personal ID of facebook, you can see when you access the http://graph.facebook.com/(own url name(example: hidekazu.ishikawa)).', 'biz-vektor'); ?><br />
<?php _e('Please search such as [Finding facebook user ID] If you still do not know well.', 'biz-vektor'); ?>
</td>
</tr>
<!-- twitter -->
<tr>
<th><?php _e('twitter account', 'biz-vektor'); ?></th>
<td><?php _e('If you want to link to twitter, banner will be displayed if you enter the account name.', 'biz-vektor'); ?><br />
@<input type="text" name="biz_vektor_theme_options[twitter]" id="twitter" value="<?php echo esc_attr( $options['twitter'] ); ?>" /><br />
<?php $twitter_widget = '<a href="'.get_admin_url().'widgets.php" target="_blank">'.__('widget', 'biz-vektor').'</a>';
printf(__('* If you want to use, such as widgets twitter, can be left blank, paste the source code by using the [text] from %s here.', 'biz-vektor'),$twitter_widget);
?>
</td>
</tr>
<!-- OGP -->
<tr>
<th><?php _e('OGP default image', 'biz-vektor'); ?></th>
<td><?php _e('If, for example, they pressed the button of facebook [Like], it is an image that appears in the timeline of facebook.', 'biz-vektor'); ?><br />
<?php _e('If the eye-catching image is specified in the page, eye-catching image takes precedence.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[ogpImage]" id="ogpImage" value="<?php echo esc_attr( $options['ogpImage'] ); ?>" /> 
<button id="media_ogpImage" class="media_btn"><?php _e('Select a image', 'biz-vektor'); ?></button><br />
<span><?php _e('ex) ', 'biz-vektor') ;?>http://www.vektor-inc.co.jp/images/ogpImage.png</span><br />
<?php _e('* Picture sizes are 300x300 pixels or more and picture ratio 16:9 recommendation.', 'biz-vektor'); ?>
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
	<?php echo esc_html(bizVektorOptions('postLabelName')); ?> <?php _ex('single page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsInfo]" id="snsBtnsInfo" value="false" <?php if ($options['snsBtnsInfo']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('infoLabelName')); ?> <?php _ex('single page', 'sns display', 'biz-vektor'); ?></li>
</ul>
<p><?php _e('Also the type of page that checked, if there is a page you do not want to display, and enter by the delimiter , the ID of the page.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[snsBtnsHidden]" id="ogpImage" value="<?php echo esc_attr( $options['snsBtnsHidden'] ); ?>" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>1,3,7</p>
</td>
</tr>
<!-- facebook comment -->
<tr>
<th><?php _e('facebook comments box', 'biz-vektor'); ?></th>
<td><?php _e('Please check the type of the page to display the facebook comments.', 'biz-vektor'); ?>
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsFront]" id="fbCommentsFront" value="false" <?php if ($options['fbCommentsFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPage]" id="fbCommentsPage" value="false" <?php if ($options['fbCommentsPage']) {?> checked<?php } ?>> 
	<?php _ex('Page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPost]" id="fbCommentsPost" value="false" <?php if ($options['fbCommentsPost']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('postLabelName')); ?> <?php _ex('single page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsInfo]" id="fbCommentsInfo" value="false" <?php if ($options['fbCommentsInfo']) {?> checked<?php } ?>> 
	<?php echo esc_html(bizVektorOptions('infoLabelName')); ?> <?php _ex('single page', 'sns display', 'biz-vektor'); ?></li>
</ul>
<p><?php _e('Also the type of page that checked, if there is a page you do not want to display, and enter by the delimiter , the ID of the page.', 'biz-vektor'); ?><br />
<input type="text" name="biz_vektor_theme_options[snsBtnsHidden]" id="ogpImage" value="<?php echo esc_attr( $options['snsBtnsHidden'] ); ?>" /><br />
<?php _e('ex) ', 'biz-vektor') ;?>1,3,7</p>
</td>
</tr>
<!-- facebook LikeBox -->
<tr>
<th>facebook LikeBox</th>
<td><?php _e('If you are installing a facebook LikeBox, please check the installation place.', 'biz-vektor'); ?>
<?php _e('* Please be sure to set facebook application ID.', 'biz-vektor'); ?>
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFront]" id="fbLikeBoxFront" value="false" <?php if ($options['fbLikeBoxFront']) {?> checked<?php } ?>> 
	<?php _ex('Home page', 'sns display', 'biz-vektor'); ?></li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxSide]" id="fbLikeBoxSide" value="false" <?php if ($options['fbLikeBoxSide']) {?> checked<?php } ?>> 
	<?php _ex('Side bar', 'sns display', 'biz-vektor'); ?></li>
</ul>
<dl>
<dt><?php _e('URL of the facebook page.', 'biz-vektor'); ?></dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxURL]" id="fbLikeBoxURL" value="<?php echo esc_attr( $options['fbLikeBoxURL'] ); ?>" /><br />
<span><?php _e('ex) ', 'biz-vektor') ;?>https://www.facebook.com/bizvektor</span></dd>
<dt><?php _e('Display of stream', 'biz-vektor'); ?></dt>
<dd><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxStream]" id="fbLikeBoxStream" value="false" <?php if ($options['fbLikeBoxStream']) {?> checked<?php } ?>> <?php _e('Display', 'biz-vektor'); ?></dd>
<dt><?php _e('Display of face', 'biz-vektor'); ?></dt>
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
<p><?php _e('If the other plug-ins is outputting the OGP, Do not output the OGP of BizVektor.', 'biz-vektor'); ?></p>
<?php
$biz_vektor_ogpTags = array(
	'ogp_on' 	=> __('I want to output the OGP tags BizVektor', 'biz-vektor'),
	'ogp_off' 	=> __('Do not output OGP tags BizVektor', 'biz-vektor')
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
<ul><li><a href="#wpwrap">このページの先頭へ戻る</a></li></ul>
</div>
</form>
</div><!-- [ /#main-content ] -->
</div><!-- [ /#biz_vektor_options ] -->
<?php
}

function biz_vektor_theme_options_validate( $input ) {
	$output = $defaults = biz_vektor_get_default_theme_options();

	// テーマカラー
	$output['theme_style'] = $input['theme_style'];

	$output['font_title'] = $input['font_title'];
	$output['font_menu'] = $input['font_menu'];
	// gMenuの数
	$output['gMenuDivide'] = $input['gMenuDivide'];
	// ヘッダーロゴ
	$output['head_logo'] = $input['head_logo'];
	// フッターロゴ
	$output['foot_logo'] = $input['foot_logo'];
	// 背景色
	// $output['bg_color'] = $input['bg_color'];

	// スライド用
	for ( $i = 1; $i <= 5 ;){
		$output['slide'.$i.'link'] = $input['slide'.$i.'link'];
		$output['slide'.$i.'image'] = $input['slide'.$i.'image'];
		$output['slide'.$i.'alt'] = $input['slide'.$i.'alt'];
		$output['slide'.$i.'display'] = $input['slide'.$i.'display'];
		$output['slide'.$i.'blank'] = $input['slide'.$i.'blank'];
	$i++;
	}

	// お問い合わせメッセージ
	$output['contact_txt'] = $input['contact_txt'];
	// 電話番号
	$output['tel_number'] = $input['tel_number'];
	// 受付時間
	$output['contact_time'] = $input['contact_time'];
	// フッター左下とフッターコピーライトに表示させるサイト名（あるいは企業名・店舗名・サービス名）
	$output['sub_sitename'] = $input['sub_sitename'];
	// 住所
	$output['contact_address'] = $input['contact_address'];

	// お問い合わせページのURL
	$output['contact_link'] = $input['contact_link'];

	// トップページのタイトルタグ
	$output['topTitle'] = $input['topTitle'];
	// 共通キーワード
	$output['commonKeyWords'] = $input['commonKeyWords'];
	// GoogleAnalytics ID
	$output['gaID'] = $input['gaID'];
	$output['gaType'] = $input['gaType'];

	// トップバナー下タイトルの表示
	$output['topEntryTitleDisplay'] = $input['topEntryTitleDisplay'];
	// トップページサイドバーの表示
	$output['topSideBarDisplay'] = $input['topSideBarDisplay'];

	// PRエリア
	for ( $i = 1; $i <= 3 ;){
		// PRタイトル
		$output['pr'.$i.'_title'] = $input['pr'.$i.'_title'];
		// PR概要
		$output['pr'.$i.'_description'] = $input['pr'.$i.'_description'];
		// PRリンクURL
		$output['pr'.$i.'_link'] = $input['pr'.$i.'_link'];
		// PR画像
		$output['pr'.$i.'_image'] = $input['pr'.$i.'_image'];
		// PR画像（スマホ用）
		$output['pr'.$i.'_image_s'] = $input['pr'.$i.'_image_s'];
	$i++;
	}

	// お知らせ、ブログ リスト表示
	$output['infoLabelName'] = $input['infoLabelName'];
	$output['postLabelName'] = $input['postLabelName'];
	$output['postTopCount'] = $input['postTopCount'];
	$output['listInfoTop'] = $input['listInfoTop'];
	$output['listInfoArchive'] = $input['listInfoArchive'];
	$output['listBlogTop'] = $input['listBlogTop'];
	$output['listBlogArchive'] = $input['listBlogArchive'];

	// RSS
	$output['rssLabelName'] = $input['rssLabelName'];
	$output['blogRss'] = $input['blogRss'];

	// topContentsBottom
	$output['topContentsBottom'] = $input['topContentsBottom'];


	// twitterアカウント
	$output['twitter'] = $input['twitter'];

	// facebookへのリンク
	$output['facebook'] = $input['facebook'];
	// facebookのアプリケーションID
	$output['fbAppId'] = $input['fbAppId'];
	// facebookのadminID
	$output['fbAdminId'] = $input['fbAdminId'];

	// OGPイメージ
	$output['ogpImage'] = $input['ogpImage'];
	// OGP非出力
	$output['ogpTagDisplay'] = $input['ogpTagDisplay'];

	// ソーシャルボタン表示指定
	$output['snsBtnsFront'] = $input['snsBtnsFront'];
	$output['snsBtnsPage'] = $input['snsBtnsPage'];
	$output['snsBtnsPost'] = $input['snsBtnsPost'];
	$output['snsBtnsInfo'] = $input['snsBtnsInfo'];
	$output['snsBtnsHidden'] = $input['snsBtnsHidden'];

	// facebookコメント表示指定
	$output['fbCommentsFront'] = $input['fbCommentsFront'];
	$output['fbCommentsPage'] = $input['fbCommentsPage'];
	$output['fbCommentsPost'] = $input['fbCommentsPost'];
	$output['fbCommentsInfo'] = $input['fbCommentsInfo'];
	$output['fbCommentsHidden'] = $input['fbCommentsHidden'];

	// facebookLikeBox指定
	$output['fbLikeBoxFront'] = $input['fbLikeBoxFront'];
	$output['fbLikeBoxSide'] = $input['fbLikeBoxSide'];
	$output['fbLikeBoxURL'] = $input['fbLikeBoxURL'];
	$output['fbLikeBoxStream'] = $input['fbLikeBoxStream'];
	$output['fbLikeBoxFace'] = $input['fbLikeBoxFace'];
	$output['fbLikeBoxHeight'] = $input['fbLikeBoxHeight'];

	// mixiチェックキー
	$output['mixiKey'] = $input['mixiKey'];

	// ガラケーカラー
	$output['galaTheme_style'] = $input['galaTheme_style'];
	// ガラケートップ画像
	$output['galaLogo'] = $input['galaLogo'];

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], biz_vektor_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];
	// sidebar child menu display
	$output['side_child_display'] = $input['side_child_display'];

	return apply_filters( 'biz_vektor_theme_options_validate', $output, $input, $defaults );
}

?>