<?php
function biz_vektor_theme_options_render_page() { ?>
	<div class="wrap" id="biz_vektor_options">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'biz-vektor' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<?php if ( function_exists( 'biz_vektor_activation' ) ) {
		biz_vektor_activation_information();
		} else { ?>
		<div id="sub-content">
		<iframe frameborder="0" height="200" marginheight="0" marginwidth="0" scrolling="auto" src="http://bizvektor.com/info-admin/"></iframe>
		</div>
		<?php } ?>
		
		<div id="main-content">
		<form method="post" action="options.php">
			<?php
				settings_fields( 'biz_vektor_options' );
				$options = biz_vektor_get_theme_options();
				$default_options = biz_vektor_get_default_theme_options();
			?>
<?php /*
		<script language="JavaScript">
		jQuery(document).ready(function(jQuery){
			jQuery("#tabSection").easyResponsiveTabs({
				type: 'default', //Types: default, vertical, accordion           
				width: 'auto', //auto or any custom width
				fit: true   // 100% fits in a container
			});
		});
		</script>
<div id="tabSection">
<ul class="resp-tabs-list">
<li>タブの名前</li>
</ul> 
<div class="resp-tabs-container">
<div>aaaaaaaa</div>
</div><!-- [ /.resp-tabs-container ] -->
</div><!-- [ #tabSection ] -->
*/ ?>

<div id="design" class="sectionBox">
<p class="message_intro"><?php echo _x('Thank you for using BizVektor.', 'biz-vektor theme-options-edit-l44', 'biz-vektor');?> <?php echo _x('You can change basic design setting in', 'biz-vektor theme-options-edit-l44', 'biz-vektor');?> <a href="<?php echo get_admin_url(); ?>customize.php"><?php echo _x('Theme customizer', 'biz-vektor theme-options-edit-l44', 'biz-vektor'); ?></a> <?php echo _x('.', 'biz-vektor theme-options-edit-l44', 'biz-vektor'); ?><br />
	<?php echo _x('You can change other settings in this page.', 'biz-vektor theme-options-edit', 'biz-vektor'); ?></p>
<?php get_template_part('inc/theme-options-nav'); ?>

<h3><?php echo _x('Design settings', 'biz-vektor theme-options-edit', 'biz-vektor'); ?><span class="message_box"><?php echo _x('This section is also able to change from ', 'biz-vektor theme-options-edit', 'biz-vektor'); ?><a href="<?php echo get_admin_url(); ?>customize.php"><?php echo __('Theme customizer', 'biz-vektor'); ?></a><?php echo _x('.', 'biz-vektor theme-options-edit-l47', 'biz-vektor'); ?></span></h3>
	<table class="form-table">
	<tr>
	<th><?php echo __('Theme add-on', 'biz-vektor') ?></th>
	<td>
	<select name="biz_vektor_theme_options[theme_style]" id="<?php echo esc_attr( $options['theme_style'] ); ?>">
	<option>[ <?php echo __('Select', 'biz-vektor') ?> ]</option>
	<?php
	// biz_vektor_theme_styles配列読み込み
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();
	// プルダウン項目生成
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
	$themePlusSettingNavi = "<p>If you choose theme add-on, don't forget saving changes before checking out.</p>";
	// 第一引数：フィルターフック名　／　第二引数：フィルターフックをかける変数名
	$themePlusSettingNavi = apply_filters( 'themePlusSettingNavi', $themePlusSettingNavi );
	echo __($themePlusSettingNavi, 'biz-vektor');
	?>
	</td>
	</tr>
	<tr>
	<th><?php echo _x('Number of header menus', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<select name="biz_vektor_theme_options[gMenuDivide]" id="<?php echo esc_attr( $options['gMenuDivide'] ); ?>">
	<option>[ <?php echo __('Select', 'biz-vektor') ?> ]</option>
	<?php
	$biz_vektor_gMenuDivides = array('divide_natural' => _x('Depend on contents', 'biz-vektor theme-customizer', 'biz-vektor'),'divide_4' => _x('4', 'biz-vektor theme-customizer', 'biz-vektor'),'divide_5' => _x('5', 'biz-vektor theme-customizer', 'biz-vektor'),'divide_6' => _x('6', 'biz-vektor theme-customizer', 'biz-vektor'),'divide_7' => _x('7', 'biz-vektor theme-customizer', 'biz-vektor'));
	foreach( $biz_vektor_gMenuDivides as $biz_vektor_gMenuDivideKey => $biz_vektor_gMenuDivideValue) {
		if ( $biz_vektor_gMenuDivideKey == $options['gMenuDivide'] ) {
			print ('<option value="'.$biz_vektor_gMenuDivideKey.'" selected>'.$biz_vektor_gMenuDivideValue.'</option>');
		} else {
			print ('<option value="'.$biz_vektor_gMenuDivideKey.'">'.$biz_vektor_gMenuDivideValue.'</option>');
		}
	}
	?>
	</select>
	[ <a href="http://bizvektor.com/setting/menu/" target="_blank">→ <?php echo __('How to set up Menus', 'biz-vektor') ;?></a> ]
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('Header logo image', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td><input type="text" name="biz_vektor_theme_options[head_logo]" id="head_logo" value="<?php echo esc_attr( $options['head_logo'] ); ?>" style="width:60%;" /> 
	<button id="media_head_logo" class="media_btn"><?php echo __('Select image', 'biz-vektor') ;?></button><br />
	<?php echo __('Recommended : less than 60px height', 'biz-vektor') ;?><br />
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('Footer logo image', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td><input type="text" name="biz_vektor_theme_options[foot_logo]" id="foot_logo" value="<?php echo esc_attr( $options['foot_logo'] ); ?>" style="width:60%;" /> 
	<button id="media_foot_logo" class="media_btn"><?php echo __('Select image', 'biz-vektor') ;?></button><br />
	<?php echo __('Recommended : 180-250px width', 'biz-vektor') ;?><br />
	</td>
	</tr>
	<tr valign="top" class="image-radio-option theme-layout"><th scope="row"><?php echo _x('Layout', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
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
	<?php echo __('You can select 1-column from below: ', 'biz-vektor');?>
	<ul>
		<li><?php echo __('[Top page] ', 'biz-vektor');?><a href="#topPage"><?php echo __('Top page settings', 'biz-vektor');?></a><?php echo _x('. ', 'biz-vektor theme-options-edit-l128', 'biz-vektor');?></li>
		<li><?php echo __('[page] Edot Page > Page Attributes > Template', 'biz-vektor') ;?></li>
	</ul>
	</td>
<!-- 	</tr>
	<tr valign="top"><th scope="row">背景色</th>
	<td><input type="text" name="biz_vektor_theme_options[bg_color]" id="bg_color" value="<?php echo esc_attr( $options['bg_color'] ); ?>" /></td>
	</tr> -->
	<tr>
	<th><?php echo _x('Font of headings', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
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
	<tr>
	<th><?php echo _x('Font of Menus', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
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
	<tr>
	<th><?php echo __('Deployment of the sidebar menu', 'biz-vektor') ;?></th>
	<td>
		<p><?php echo __('If the site hierarchy is deep, you can choose to hide this menu hierarchy other than the fixed page you are currently viewing.', 'biz-vektor');?></p>
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
	<p>※<?php echo __('It can not be set from the theme customizer.', 'biz-vektor') ;?></p>
	<td>
	</tr>
	</table>
	<?php submit_button(); ?>
	</div>
	<!-- [ /#design ] -->
	<?php
	/*-------------------------------------------*/
	/*	連絡先の設定
	/*-------------------------------------------*/
	?>
	<div id="contactInfo" class="sectionBox">
	<?php get_template_part('inc/theme-options-nav'); ?>
	<h3><?php echo _x('Contact settings', 'biz-vektor theme-customizer', 'biz-vektor') ;?><span class="message_box"><?php echo _x('This section is also able to change from ', 'biz-vektor theme-options-edit', 'biz-vektor'); ?><a href="<?php echo get_admin_url(); ?>customize.php"><?php echo __('Theme customizer', 'biz-vektor'); ?></a><?php echo _x('.', 'biz-vektor theme-options-edit-l47', 'biz-vektor'); ?></span></h3>
	<table class="form-table">
	<tr valign="top"><th scope="row"><?php echo _x('Message', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[contact_txt]" id="contact_txt" value="<?php echo esc_attr( $options['contact_txt'] ); ?>" style="width:50%;" /><br />
	<span><?php echo __('ex) ', 'biz-vektor') ;?><?php echo __('Please feel free to inquire.', 'biz-vektor') ;?></span>
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('Phone number', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[tel_number]" id="tel_number" value="<?php echo esc_attr( $options['tel_number'] ); ?>" style="width:50%;" /><br />
	<span><?php echo __('ex) ', 'biz-vektor') ;?>000-000-0000</span>
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('Office hours', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[contact_time]" id="contact_time" value="" style="width:50%;" /><?php echo esc_attr( $options['contact_time'] ); ?></textarea><br />
	<span><?php echo __('ex) ', 'biz-vektor') ;?><?php echo _x('Office hours', 'biz-vektor theme-customizer', 'biz-vektor') ;?> 9：00～18：00（<?php echo __('Weekdays except holidays', 'biz-vektor') ;?>）</span>
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('Site / Company / Store / Service name. This is displayed in footer let bottom and footer copyright.', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br />
	</th>
	<td>
	<textarea cols="20" rows="2" name="biz_vektor_theme_options[sub_sitename]" id="sub_sitename" value="" style="width:50%;" /><?php echo esc_attr( $options['sub_sitename'] ); ?></textarea><br />
	<span><?php echo __('ex) ', 'biz-vektor') ;?><?php echo __('BizVektor, Inc.', 'biz-vektor') ;?></span><br />
	<?php echo __('※Use this feature when the site name has become longer for the SEO measures.', 'biz-vektor') ;?>
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('Company address', 'biz-vektor theme-customizer', 'biz-vektor') ;?><br /><?php echo __('This is displayed in footer let bottom and footer copyright.', 'biz-vektor') ;?></th>
	<td>
	<textarea cols="20" rows="5" name="biz_vektor_theme_options[contact_address]" id="contact_address" value="" style="width:50%;" /><?php echo $options['contact_address'] ?></textarea><br />
		<span><?php echo __('ex) ', 'biz-vektor') ;?>
		<?php echo __('316, Minami Sakae Building,<br />1-22-16, Sakae, Naka-ku, Nagoya-shi,<br />Aichi 460-0008 JAPAN<br />TEL / FAX +81-52-228-9176', 'biz-vektor') ;?>
		</span>
	</td>
	</tr>
	<tr valign="top"><th scope="row"><?php echo _x('The URL of contact page', 'biz-vektor theme-customizer', 'biz-vektor') ;?></th>
	<td>
	<input type="text" name="biz_vektor_theme_options[contact_link]" id="contact_link" value="<?php echo esc_attr( $options['contact_link'] ); ?>" />
	<span><?php echo __('ex) ', 'biz-vektor') ;?>http://www.********.co.jp/contact/ <?php echo __('or', 'biz-vektor') ;?> /******/</span><br />
	<?php echo __('※If you fill in the blank, contact banner will be displayed in the sidebar.', 'biz-vektor') ;?><br />
	<span class="alert"><?php echo __('If not, it does not appear.', 'biz-vektor') ;?></span>
	</td>
	</tr>
	</table>
	<?php submit_button(); ?>
	</div>
	<!-- [ /#contactInfo ] -->

	<?php
	/*-------------------------------------------*/
	/*	3PRエリア
	/*-------------------------------------------*/
	?>
	<div id="prBox" class="sectionBox">
	<?php get_template_part('inc/theme-options-nav'); ?>
	<h3><?php echo __('3PR area settings', 'biz-vektor') ;?><span class="message_box"><?php echo _x('This section is also able to change from ', 'biz-vektor theme-options-edit', 'biz-vektor'); ?><a href="<?php echo get_admin_url(); ?>customize.php"><?php echo __('Theme customizer', 'biz-vektor'); ?></a><?php echo _x('.', 'biz-vektor theme-options-edit-l47', 'biz-vektor'); ?></span></h3>
	<?php echo __('※3PR area do not appear on the top page in the case of blank all.<br />※It is effective without the image.', 'biz-vektor') ;?><br /><span class="alert"><?php echo __('※You can register image for PC and for smartphone.', 'biz-vektor') ;?></span>
<?php
// PRエリア
for ( $i = 1; $i <= 3 ;){ ?>

<div class="prItem">
<h5><?php echo __('PR area', 'biz-vektor') ?><?php echo $i; ?></h5>
<dl>
<dt><?php echo __('Title', 'biz-vektor') ;?></dt>
<dd><input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_title]" id="pr<?php echo $i; ?>_title" value="<?php echo esc_attr( $options['pr'.$i.'_title'] ); ?>" /></dd>
<dt><?php echo __('Description', 'biz-vektor') ;?></dt>
<dd><textarea cols="15" rows="3" name="biz_vektor_theme_options[pr<?php echo $i; ?>_description]" id="pr<?php echo $i; ?>_description" value=""><?php echo esc_attr( $options['pr'.$i.'_description'] ); ?></textarea></dd>
<dt><?php echo __('URL', 'biz-vektor') ;?></dt>
<dd><input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_link]" id="pr<?php echo $i; ?>_link" value="<?php echo esc_attr( $options['pr'.$i.'_link'] ); ?>" /></dd>
<dt><?php echo __('Image for PC', 'biz-vektor') ;?></dt>
<dd>
<span class="mediaSet">
<input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_image]" class="media_text" id="pr<?php echo $i; ?>_image" value="<?php echo esc_attr( $options['pr'.$i.'_image'] ); ?>" /> 
<button id="media_pr<?php echo $i; ?>_image" class="media_btn"><?php echo __('Select image', 'biz-vektor') ;?></button></span>
<?php echo __('310px width is recommended.', 'biz-vektor') ;?></dd>
<dt><?php echo __('Image for smartphone', 'biz-vektor') ;?></dt>
<dd>
<span class="mediaSet">
<input type="text" name="biz_vektor_theme_options[pr<?php echo $i; ?>_image_s]" class="media_text" id="pr<?php echo $i; ?>_image_s" value="<?php echo esc_attr( $options['pr'.$i.'_image_s'] ); ?>" /> 
<button id="media_pr<?php echo $i; ?>_image_s" class="media_btn"><?php echo __('Select image', 'biz-vektor') ;?></button></span>
<?php echo __('120px by 120px is recommended.', 'biz-vektor') ;?></dd>
</dl>
</div>

<?php
$i++;
} ?>
<?php submit_button(); ?>
</div>

<?php
/*-------------------------------------------*/
/*	入力_「お知らせ」と「ブログ」の表示設定
/*-------------------------------------------*/
?>
<div id="postSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3><?php echo _x('Settings of', 'biz-vektor theme-options-edit-l294', 'biz-vektor') ;?> <?php echo esc_html( bizVektorOptions('infoLabelName')); ?> <?php echo _x('and', 'biz-vektor theme-options-edit-l294', 'biz-vektor') ;?> <?php echo esc_html( bizVektorOptions('postLabelName')); ?><?php echo _x('.', 'biz-vektor theme-options-edit-l294', 'biz-vektor') ;?></h3>
※ <?php echo __('It does not appear if there is no post at all.', 'biz-vektor') ;?><br />
※ <?php echo __('If the excerpt field is filled, the content will appear in the &quot;excerpt&quot;. If not, the text will be displayed in a certain number of', 'biz-vektor') ;?><br />
　 <?php echo __('characters from the beginning of a sentence. Please activate', 'biz-vektor') ;?> <span class="alert"><?php echo __('&quot;WP Multibyte Patch&quot;', 'biz-vektor') ;?></span> <?php echo __('in order to display properly from', 'biz-vektor') ;?> <br />
　 <a href="<?php echo get_admin_url(); ?>plugins.php" target="_blank">"Plugins" page</a> where you can change plugin settings.<br />
※ <span class="alert"><?php echo __('Thumbnail image of the article', 'biz-vektor') ;?></span> <?php echo __('is displayed.', 'biz-vektor') ;?><br />
　 <?php echo __('There is a registration widget of thumbnail image in the lower right corner of each article edit screen.', 'biz-vektor') ;?><br />
　 <?php echo __('If you do not have a widget, please check the item of &quot;thumbnail&quot; at the top right of the screen from the &quot;Screen options&quot; tab.', 'biz-vektor') ;?>

<table class="form-table">
<tr>
	<th><?php echo esc_html( bizVektorOptions('infoLabelName')); ?></th>
	<td>
		→ <?php echo __('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[infoLabelName]" id="infoLabelName" value="<?php echo esc_attr( $options['infoLabelName'] ); ?>" style="width:200px;" />
	<dl>
	<dt><?php echo __('Display layout of &quot;', 'biz-vektor theme-options-edit-l309', 'biz-vektor') ;?><?php echo esc_html( bizVektorOptions('infoLabelName')); ?><?php echo __('&quot on the top page', 'biz-vektor theme-options-edit-l309', 'biz-vektor') ;?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array('listType_title' => __('title only', 'biz-vektor'),'listType_set' => __('With excerpt and thumbnail', 'biz-vektor'));
	foreach( $biz_vektor_listTypes as $biz_vektor_listTypeValue => $biz_vektor_listTypeLavel) {
		if ( $biz_vektor_listTypeValue == $options['listInfoTop'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listInfoTop]" value="<?php echo $biz_vektor_listTypeValue ?>" checked> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listInfoTop]" value="<?php echo $biz_vektor_listTypeValue ?>"> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php }
	}
	?>
	</dd>
	<dt><?php echo __('Display layout of &quot;', 'biz-vektor theme-options-edit-l322', 'biz-vektor') ;?><?php echo esc_html( bizVektorOptions('infoLabelName')); ?><?php echo __('&quot on the archive page', 'biz-vektor theme-options-edit-l322', 'biz-vektor') ;?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array('listType_title' => __('title only', 'biz-vektor'),'listType_set' => __('With excerpt and thumbnail', 'biz-vektor'));
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
<tr>
	<th><?php echo esc_html( bizVektorOptions('postLabelName')); ?></th>
	<td>
		→ <?php echo __('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[postLabelName]" id="postLabelName" value="<?php echo esc_attr( $options['postLabelName'] ); ?>" style="width:200px;" />
	<dl>
	<dt><?php echo __('Display layout of &quot;', 'biz-vektor theme-options-edit-l309', 'biz-vektor') ;?><?php echo esc_html( bizVektorOptions('postLabelName')); ?><?php echo __('&quot on the top page', 'biz-vektor theme-options-edit-l309', 'biz-vektor') ;?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array('listType_title' => __('title only', 'biz-vektor'),'listType_set' => __('With excerpt and thumbnail', 'biz-vektor'));
	foreach( $biz_vektor_listTypes as $biz_vektor_listTypeValue => $biz_vektor_listTypeLavel) {
		if ( $biz_vektor_listTypeValue == $options['listBlogTop'] ) { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listBlogTop]" value="<?php echo $biz_vektor_listTypeValue ?>" checked> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php } else { ?>
		<label><input type="radio" name="biz_vektor_theme_options[listBlogTop]" value="<?php echo $biz_vektor_listTypeValue ?>"> <?php echo $biz_vektor_listTypeLavel ?></label>
		<?php }
	}
	?>
	</dd>
	<dt><?php echo __('Display layout of &quot;', 'biz-vektor theme-options-edit-l322', 'biz-vektor') ;?><?php echo esc_html( bizVektorOptions('postLabelName')); ?><?php echo __('&quot on the archive page', 'biz-vektor theme-options-edit-l322', 'biz-vektor') ;?></dt>
	<dd>
	<?php
	$biz_vektor_listTypes = array('listType_title' => __('title only', 'biz-vektor'),'listType_set' => __('With excerpt and thumbnail', 'biz-vektor'));
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
<tr>
<th><?php echo __('Display layout of &quot;', 'biz-vektor theme-options-edit-l309', 'biz-vektor') ;?><?php echo esc_html( bizVektorOptions('postLabelName')); ?><?php echo __('&quot on the top page', 'biz-vektor theme-options-edit-l309', 'biz-vektor') ;?></th>
<td><input type="text" name="biz_vektor_theme_options[postTopCount]" id="postTopCount" value="<?php echo esc_attr( $options['postTopCount'] ); ?>" style="width:50px;" /><?php echo __('posts', 'biz-vektor theme-options-edit-l374', 'biz-vektor') ;?><br />
<?php echo __('If you enter &quot0&quot, this section itself will disappear.', 'biz-vektor') ;?></td>
</tr>
</table>
<?php submit_button(); ?>

</div>
<!-- [ /#postSetting ] -->





<?php
/*-------------------------------------------*/
/*	SEO設定
/*-------------------------------------------*/
?>
<div id="seoSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3>SEO設定</h3>
<table class="form-table">
<tr>
<th>トップページの&lt;title&gt;タグ</th>
<td>
<p>BizVektorは<a href="<?php echo get_admin_url(); ?>options-general.php" target="_blank">サイトのタイトル</a>が全ページの&lt;title&gt;に入ります。例えば固定ページであれば<br />
&lt;title&gt;固定ページ名 | サイトタイトル&lt;/title&gt; <br />
というような形式で出力されます。<br />
このように固定ページ名や投稿名と<a href="<?php echo get_admin_url(); ?>options-general.php" target="_blank">サイトのタイトル</a>が連結して出力されますが、&lt;title&gt;の文字数が長くなりすぎると検索エンジンからの評価が逆に悪くなるので、<a href="<?php echo get_admin_url(); ?>options-general.php" target="_blank">サイトのタイトル</a>は<strong>一番検索されたいキーワードを盛り込みつつなるべく短くまとめる</strong>事が望ましいです。<br />
しかし、トップページにおいては上記のように他のタイトルと連結されないので、もう少し長めの&lt;title&gt;をつける事が出来るために、ここで別途設定する事ができるようになっています。</p>
<input type="text" name="biz_vektor_theme_options[topTitle]" id="topTitle" value="<?php echo esc_attr( $options['topTitle'] ); ?>" style="width:90%;" />
<p>※未記入の場合はサイトのタイトルが反映されます。</p>
</td>
</tr>
<tr>
<th>共通キーワード</th>
<td>metaタグのキーワードで、サイト全体で共通して入れるキーワードを , 区切りで入力して下さい。<br />
<input type="text" name="biz_vektor_theme_options[commonKeyWords]" id="commonKeyWords" value="<?php echo esc_attr( $options['commonKeyWords'] ); ?>" style="width:90%;" /><br />
※現在は検索エンジンからの評価に影響しませんのであまり真剣に考えなくてもかまいません。
※各ページ個別のキーワードについては、それぞれの記事の編集画面より入力して下さい。共通キーワードと合わせて最大10個程度が望ましいです。<br />
※最後のキーワード欄の末尾には , は必要ありません。<br />
<?php echo __('ex) ', 'biz-vektor') ;?>WordPress,テンプレート,無料,GPL
</td>
</tr>
<tr>
<th>ディスクリプション</th>
<td>各ページの編集画面の「抜粋」欄に記入した内容がmetaタグのディスクリプションに反映されます。<br />
metaタグのディスクリプションはGoogleなどの検索サイトの検索結果画面で、サイトタイトルの下などに表示されます。<br />
抜粋欄が未記入の場合は、本文文頭より240文字がディスクリプションとして適応される仕様となっています。<br />
※抜粋欄が表示されていない場合は、編集画面の右上に「表示」というタブがありますので、そこをクリックすると「抜粋」欄を表示するチェックボックスが出てきますので、チェックして下さい。
</td>
</tr>
<tr>
<th>Google Analytics設定</th>
<td>GoogleAnalyticsのタグを埋め込む場合はアカウントIDを記入して下さい。<br />
<p>UA-<input type="text" name="biz_vektor_theme_options[gaID]" id="gaID" value="<?php echo esc_attr( $options['gaID'] ); ?>" style="width:90%;" /><br />
<?php echo __('ex) ', 'biz-vektor') ;?>XXXXXXXX-X</p>

	<dl>
	<dt>出力する解析タグの種類を選択して下さい。（よくわからない場合は飛ばしてかまいません。）</dt>
	<dd>
<?php
$biz_vektor_gaTypes = array(
	'gaType_normal' => '通常の解析タグのみ出力する（デフォルト）',
	'gaType_universal' => 'Universal Analyticsの解析タグのみ出力する',
	'gaType_both' => '両方の解析タグを出力する'
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
/*	トップページの設定
/*-------------------------------------------*/
?>
<div id="topPage" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3><?php echo __('Top page settings', 'biz-vektor') ;?></h3>
<table class="form-table">
<tr>
<th><?php echo __('Main visua', 'biz-vektor') ;?></th>
<td><?php echo __('You can set a slide show or still image.', 'biz-vektor') ;?>
<ul>
<li>[ <a href="<?php echo get_admin_url(); ?>themes.php?page=custom-header" target="_blank">→ <?php echo __('Still image setting', 'biz-vektor') ;?></a> ]</li>
<li>[ <a href="#slideSetting">→ <?php echo __('Slide show setting', 'biz-vektor') ;?></a> ]</li>
</ul></td>
</tr>
<tr>
<th id="topEntryTitleHidden"><?php echo __('Page to be displayed below the main visual', 'biz-vektor') ;?></th>
<th><p>[ <a href="<?php echo get_admin_url(); ?>options-reading.php" target="_blank">→ Reading Settings</a> ]</p>
<p><?php echo __('Select &quot;Recent post&quot; or &quot;page&quot;.', 'biz-vektor') ;?><br />
 <span class="alert">※<?php echo __('Do not select the pull-down &quot;post pages&quot;.', 'biz-vektor') ;?></span><br />
 ※設定したページの本文が未記入の場合、メインビジュアルの下にはすぐに３ＰＲボックスが表示されますので、特に記入する事がなければ本文欄は未記入でも構いません。</p></td>
</tr>
<tr>
<th id="topEntryTitleHidden">トップページのメインビジュアルの下のタイトルの表示</th>
<th><p>トップページのメインビジュアル下に表示するページのタイトルを表示する場合はチェックを入れて下さい。</p>
<p><input type="checkbox" name="biz_vektor_theme_options[topEntryTitleDisplay]" id="topEntryTitleDisplay" value="true" <?php if ($options['topEntryTitleDisplay']) {?> checked<?php } ?>> タイトルを表示する</p></td>
</tr>
<tr>
<th>トップページ3PRエリア</th>
<td>
<ul>
<li>[ <a href="#prBox">→ トップページ3PRエリアの設定はこちら</a> ]</li>
</ul></td>
</tr>
<tr>
<th id="topEntryTitleHidden">トップページのサイドバーの表示</th>
<th><p>トップページのサイドバーを表示しない場合はチェックを入れて下さい。</p>
<p><input type="checkbox" name="biz_vektor_theme_options[topSideBarDisplay]" id="topSideBarDisplay" value="true" <?php if ($options['topSideBarDisplay']) {?> checked<?php } ?>> サイドバーを非表示にする</p></td>
</tr>
<tr>
	<th><?php echo esc_html( bizVektorOptions('postLabelName')); ?>の表示件数</th>
	<td><a href="#postSetting">「<?php echo esc_html( bizVektorOptions('postLabelName')); ?>」と「<?php echo esc_html( bizVektorOptions('postLabelName')); ?>」の設定</a>より設定下さい。</td>
</tr>
<tr>
	<th><?php echo esc_html( bizVektorOptions('rssLabelName')); ?>（RSS情報表示設定） </th>
	<td><span style="font-size:14px;font-weight:lighter;">→ <?php echo __('Change the title', 'biz-vektor') ;?> <input type="text" name="biz_vektor_theme_options[rssLabelName]" id="rssLabelName" value="<?php echo esc_attr( $options['rssLabelName'] ); ?>" style="width:200px;" /></span>
<p>外部ブログや関連サイトのRSSを利用していて、更新情報をこのサイトのトップページに掲載する場合はRSSのアドレスを入力して下さい。<br />
<input type="text" name="biz_vektor_theme_options[blogRss]" id="blogRss" value="<?php echo esc_attr( $options['blogRss'] ); ?>" />
<span><?php echo __('ex) ', 'biz-vektor') ;?>http://www.XXXX.jp/?feed=rss2</span></p>
</td>
</tr>
<tr>
	<th>トップページ下部フリーエリア</th>
<td>
<p>「お知らせ」や「<?php echo esc_html(bizVektorOptions('postLabelName')); ?>」のリストの下の部分に表示されます。<br />
<textarea cols="50" rows="4" name="biz_vektor_theme_options[topContentsBottom]" id="topContentsBottom" value="" style="width:90%;"><?php echo esc_attr( $options['topContentsBottom'] ); ?></textarea></p>
</td>
</tr>
</table>

<?php submit_button(); ?>
</div>

<?php
/*-------------------------------------------*/
/*	スライドショーの設定
/*-------------------------------------------*/
?>
<div id="slideSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3>スライドショーの設定</h3>
<p>スライドショーを設定する場合は表示する画像のURLなどを入力下さい。<br />
画像の推奨サイズは950×250pxです。<br />
スライドショーが設定されていない場合は<a href="<?php echo get_admin_url(); ?>themes.php?page=custom-header" target="_blank">トップページのメインビジュアル</a>が表示されます。<br />
画像のURLだけでも構いませんがリンク先を入力すると画像クリックでリンクするようになります。<br />
代替テキストはその画像の内容を文字で入力して下さい。記入した方がその内容で検索にヒットしやすくなると共に、目の不自由な人が閲覧した際には音声読み上げブラウザがその文字を読み上げます。</p>
<table class="form-table">
<?php
for ( $i = 1; $i <= 5 ;){
$slideLink = 'slide'.$i.'link';
$slideImage = 'slide'.$i.'image';
$slideAlt = 'slide'.$i.'alt';
$slideDisplay = 'slide'.$i.'display';
$slideBlank = 'slide'.$i.'blank'; ?>
<tr>
<td>リンク先URL<?php echo $i ?><br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideLink ?>]" id="<?php echo $slideLink ?>" value="<?php echo esc_attr( $options[$slideLink] ) ?>" /></td>
<td>画像URL<?php echo $i ?><br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideImage ?>]" id="<?php echo $slideImage ?>" value="<?php echo esc_attr( $options[$slideImage] ) ?>" /> <button id="media_<?php echo $slideImage ?>" class="media_btn">画像を選択</button>
</td>
<td>代替テキスト<?php echo $i ?>（alt）<br />
	<input type="text" name="biz_vektor_theme_options[<?php echo $slideAlt ?>]" id="<?php echo $slideAlt ?>" value="<?php echo esc_attr( $options[$slideAlt] ) ?>" /></td>
<td>
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideDisplay ?>]" id="<?php echo $slideDisplay ?>" value="true" <?php if ($options[$slideDisplay]) :echo ' checked';endif; ?>> 非表示にする</label><br />
<label><input type="checkbox" name="biz_vektor_theme_options[<?php echo $slideBlank ?>]" id="<?php echo $slideBlank ?>" value="true" <?php if ($options[$slideBlank]) :echo ' checked';endif; ?>> 別ウィンドウで開く</label>
</td>
</tr>
<?php
	$i++;
} ?>

</table>
<p>※スライドショーは最大５枚まで設定出来ますが、3G回線のスマートフォンなど通信回線が遅い環境で閲覧した場合、表示に時間がかったり、ユーザーの離脱や検索エンジンからの減点対象となる為、３枚以内推奨です。</p>
<?php submit_button(); ?>
</div>

<?php
/*-------------------------------------------*/
/*	SNS連携
/*-------------------------------------------*/
?>
<div id="snsSetting" class="sectionBox">
<?php get_template_part('inc/theme-options-nav'); ?>
<h3>SNS連携</h3>
よくわからない場合は後で設定しても問題ありません。
<table class="form-table">
<tr>
<th>facebook</th>
<td>facebookページか個人アカウントにリンクする場合はリンク先アドレスを入力するとバナーが表示されます。<br />
<input type="text" name="biz_vektor_theme_options[facebook]" id="facebook" value="<?php echo esc_attr( $options['facebook'] ); ?>" />
<span><?php echo __('ex) ', 'biz-vektor') ;?>https://www.facebook.com/hidekazu.ishikawa</span><br />
※facebookが発行するバナー・ウィジェットを利用したい場合は、空欄のままにして、<a href="<?php echo get_admin_url(); ?>widgets.php" target="_blank">ウィジェット</a>より『テキスト』を利用してソースコードを貼り付けて下さい。
</td>
</tr>
<tr>
<th>facebookアプリケーションID</th>
<td><input type="text" name="biz_vektor_theme_options[fbAppId]" id="fbAppId" value="<?php echo esc_attr( $options['fbAppId'] ); ?>" />
<span>[ <a href="https://developers.facebook.com/apps" target="_blank">→アプリケーションIDを確認・取得する</a> ]</span><br />
※アプリケーションIDを入力しないとボタンやコメント欄が表示・正しく動作しません。
facebookのアプリケーションIDの取得方法についてよくわからない場合は「facebook アプリケーションID 取得」などで検索して下さい。
</td>
</tr>
<tr>
<th>facebookユーザーID （任意）</th>
<td>管理者のfacebookユーザーIDを入力して下さい。<br />
<input type="text" name="biz_vektor_theme_options[fbAdminId]" id="fbAdminId" value="<?php echo esc_attr( $options['fbAdminId'] ); ?>" /><br />
※facebookページのアプリケーションIDではありません。<br />
facebookの個人IDは、http://graph.facebook.com/★自分のURL名（例：hidekazu.ishikawa）★ にアクセスするとわかります。それでもよくわからない場合は「facebook ユーザーID 調べ方」などで検索して下さい。
</td>
</tr>
<tr>
<th>twitterアカウント</th>
<td>twitterにリンクする場合はリンク先アドレスを入力するとバナーが表示されます。<br />
@<input type="text" name="biz_vektor_theme_options[twitter]" id="twitter" value="<?php echo esc_attr( $options['twitter'] ); ?>" /><br />
※twitterのウィジェットなどを利用したい場合は空欄のままにして、<a href="<?php echo get_admin_url(); ?>widgets.php" target="_blank">ウィジェット</a>より『テキスト』を利用してソースコードを貼り付けて下さい。
</td>
</tr>
<tr>
<th>デフォルトのOGPイメージ</th>
<td>facebookの「いいね」ボタンを押された場合などに、facebookのタイムラインに表示される画像です。<br />
ページにアイキャッチ画像が指定されてる場合はそちらが優先されます。<br />
画像サイズは250×250ピクセル以上、画像比率3:1以下推奨。<br />
[ <a href="<?php echo get_admin_url(); ?>media-new.php" target="_blank">→ OGP画像をアップロードする</a> ] ※アップロードした後、ファイルのURLを下記に貼り付けて下さい。<br />
<input type="text" name="biz_vektor_theme_options[ogpImage]" id="ogpImage" value="<?php echo esc_attr( $options['ogpImage'] ); ?>" /><br />
<span><?php echo __('ex) ', 'biz-vektor') ;?>http://www.vektor-inc.co.jp/images/ogpImage.png</span>
</td>
</tr>
<tr>
<th>ソーシャルボタン</th>
<td>
ソーシャルボタンを表示するページの種類にチェックを入れて下さい。
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsFront]" id="snsBtnsFront" value="false" <?php if ($options['snsBtnsFront']) {?> checked<?php } ?>> トップページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsPage]" id="snsBtnsPage" value="false" <?php if ($options['snsBtnsPage']) {?> checked<?php } ?>> 固定ページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsPost]" id="snsBtnsPost" value="false" <?php if ($options['snsBtnsPost']) {?> checked<?php } ?>> <?php echo esc_html(bizVektorOptions('postLabelName')); ?>投稿ページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[snsBtnsInfo]" id="snsBtnsInfo" value="false" <?php if ($options['snsBtnsInfo']) {?> checked<?php } ?>> お知らせ投稿ページ</li>
</ul>
<p>チェックを入れたページの種類でも表示したくないページがある場合はIDを , 区切りで入力して下さい。<br />
<input type="text" name="biz_vektor_theme_options[snsBtnsHidden]" id="ogpImage" value="<?php echo esc_attr( $options['snsBtnsHidden'] ); ?>" /><br />
<?php echo __('ex) ', 'biz-vektor') ;?>1,3,7</p>

</td>
</tr>
<tr>
<th>facebook コメント欄</th>
<td>
facebookコメント欄を表示するページにはチェックを入れて下さい。
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsFront]" id="fbCommentsFront" value="false" <?php if ($options['fbCommentsFront']) {?> checked<?php } ?>> トップページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPage]" id="fbCommentsPage" value="false" <?php if ($options['fbCommentsPage']) {?> checked<?php } ?>> 固定ページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsPost]" id="fbCommentsPost" value="false" <?php if ($options['fbCommentsPost']) {?> checked<?php } ?>> ブログ投稿ページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbCommentsInfo]" id="fbCommentsInfo" value="false" <?php if ($options['fbCommentsInfo']) {?> checked<?php } ?>> お知らせ投稿ページ</li>
</ul>
チェックを入れたページの種類でも表示したくないページがある場合はIDを , 区切りで入力して下さい。<br />
<input type="text" name="biz_vektor_theme_options[fbCommentsHidden]" id="ogpImage" value="<?php echo esc_attr( $options['fbCommentsHidden'] ); ?>" /><br />
<?php echo __('ex) ', 'biz-vektor') ;?>1,3,7
</td>
</tr>
<tr>
<th>facebook LikeBox</th>
<td>
facebook LikeBox を設置する場合は設置個所にチェックを入れて下さい。
<ul>
<li><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFront]" id="fbLikeBoxFront" value="false" <?php if ($options['fbLikeBoxFront']) {?> checked<?php } ?>> トップページ</li>
<li><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxSide]" id="fbLikeBoxSide" value="false" <?php if ($options['fbLikeBoxSide']) {?> checked<?php } ?>> サイドバー</li>
</ul>
<dl>
<dt>facebookページのURL</dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxURL]" id="fbLikeBoxURL" value="<?php echo esc_attr( $options['fbLikeBoxURL'] ); ?>" />
<span><?php echo __('ex) ', 'biz-vektor') ;?>https://www.facebook.com/bizvektor</span></dd>
<dt>ストリームの表示</dt>
<dd><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxStream]" id="fbLikeBoxStream" value="false" <?php if ($options['fbLikeBoxStream']) {?> checked<?php } ?>> 表示する</dd>
<dt>顔の表示</dt>
<dd><input type="checkbox" name="biz_vektor_theme_options[fbLikeBoxFace]" id="fbLikeBoxFace" value="false" <?php if ($options['fbLikeBoxFace']) {?> checked<?php } ?>> 表示する</dd>
<dt>LikeBoxの高さ</dt>
<dd><input type="text" name="biz_vektor_theme_options[fbLikeBoxHeight]" id="fbLikeBoxHeight" value="<?php echo esc_attr( $options['fbLikeBoxHeight'] ); ?>" />
<span>単位：ピクセル</span></dd>
</dl>
</td>
</tr>
<tr>
<th>mixiイイネ！ボタン</th>
<td>識別キー <input type="text" name="biz_vektor_theme_options[mixiKey]" id="twitter" value="<?php echo esc_attr( $options['mixiKey'] ); ?>" /><br />
mixiイイネ！ボタンを利用するためには「mixi Platform 利用登録」が必要となります。<br />
詳しくは「<a href="https://developer.mixi.co.jp/about-platform/overview/" target="_blank">mixi Platform 利用登録の概要</a>」をご覧ください。<br />
識別キー は mixiの「<a href="https://sap.mixi.jp/home.pl" target="_blank">Partner Dashboard</a>」より、<br />
Partner Dashboard　＞　mixi Plugin　 ＞　新規サービス追加　<br />
にて、イイネ！ボタンを設置するサービスの登録を行ってください。<br />
（新規サービスの登録、管理の詳細は<a href="https://developer.mixi.co.jp/connect/mixi_plugin/mixi_check/mixicheck/" target="_blank">こちら</a>）
</td>
</tr>
<tr>
<th>OGPを出力しない</th>
<td>
<p>他のプラグインがOGPを出力している場合はBizVektorのOGPを出力しないようにして下さい。</p>
<?php
$biz_vektor_ogpTags = array('ogp_on' => 'BizVektorのOGPタグを出力する','ogp_off' => 'BizVektorのOGPタグを出力しない');
foreach( $biz_vektor_ogpTags as $biz_vektor_ogpTagValue => $biz_vektor_ogpTagLavel) {
	if ( $biz_vektor_ogpTagValue == $options['ogpTagDisplay'] ) { ?>
	<label><input type="radio" name="biz_vektor_theme_options[ogpTagDisplay]" value="<?php echo $biz_vektor_ogpTagValue ?>" checked> <?php echo $biz_vektor_ogpTagLavel ?></label>
	<?php } else { ?>
	<label><input type="radio" name="biz_vektor_theme_options[ogpTagDisplay]" value="<?php echo $biz_vektor_ogpTagValue ?>"> <?php echo $biz_vektor_ogpTagLavel ?></label>
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