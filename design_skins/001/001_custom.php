<?php

/*-------------------------------------------*/
/*	Judge default
/*-------------------------------------------*/
/*
/*-------------------------------------------*/
/*	Get 'default_design' options
/*-------------------------------------------*/
/*	Variable settings
/*-------------------------------------------*/
/*	Setting customizer
/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Judge default
/*-------------------------------------------*/
function is_bizvektor_default_design(){
	if (function_exists('biz_vektor_theme_styleSetting'))
	{
		$options = biz_vektor_get_theme_options();
		if ( $options['theme_style'] == 'default' || $options['theme_style'] == '' ) {
			return true;
		}
	}
}

/*-------------------------------------------*/
/*
/*-------------------------------------------*/
add_action( 'admin_init', 'biz_vektor_theme_options_default_design_init' );
function biz_vektor_theme_options_default_design_init() {
	if (is_bizvektor_default_design()){
		if ( false === biz_vektor_get_theme_options_default_design() )
			add_option( 'biz_vektor_theme_options_default_design' );
			register_setting(
				'biz_vektor_options_default_design',
				'biz_vektor_theme_options_default_design',
				'biz_vektor_theme_options_default_design_validate'
			);
		}
}
/*-------------------------------------------*/
/*	Get 'default_design' options
/*-------------------------------------------*/
function biz_vektor_get_theme_options_default_design() {
	return get_option( 'biz_vektor_theme_options_default_design' );
}

/*-------------------------------------------*/
/*	Variable settings
/*-------------------------------------------*/
function biz_vektor_theme_options_default_design_validate( $input ) {
	$output = $defaults;
	$output['theme_plusKeyColor'] = $input['theme_plusKeyColor'];
	$output['theme_plusKeyColorLight'] = $input['theme_plusKeyColorLight'];
	$output['theme_plusKeyColorVeryLight'] = $input['theme_plusKeyColorVeryLight'];
	$output['theme_plusKeyColorDark'] = $input['theme_plusKeyColorDark'];
	return apply_filters( 'biz_vektor_theme_options_default_design_validate', $output, $input, $defaults );
}

/*-------------------------------------------*/
/*	Setting customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'bizvektor_default_design_customize_register' );
function bizvektor_default_design_customize_register($wp_customize) {
	if (is_bizvektor_default_design()){
    // Add section
    $wp_customize->add_section( 'biz_vektor_default_design', array(
        'title'          => __( 'Default color settings', 'biz-vektor' ),
        'priority'       => 110,
    ) );
	$wp_customize->add_setting( 'biz_vektor_theme_options_default_design[theme_plusKeyColor]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', 'sanitize_callback'	=> 'maybe_hash_hex_color') );
	$wp_customize->add_setting( 'biz_vektor_theme_options_default_design[theme_plusKeyColorLight]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', 'sanitize_callback'	=> 'maybe_hash_hex_color') );
	$wp_customize->add_setting( 'biz_vektor_theme_options_default_design[theme_plusKeyColorDark]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', 'sanitize_callback'	=> 'maybe_hash_hex_color') );
	// Create section UI
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		'label'    => __('Keycolor', 'biz-vektor'),
		'section'  => 'biz_vektor_default_design',
		'settings' => 'biz_vektor_theme_options_default_design[theme_plusKeyColor]',
	)));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'KeyColorLight', array(
		'label'    => __('Keycolor(Light)', 'biz-vektor'),
		'section'  => 'biz_vektor_default_design',
		'settings' => 'biz_vektor_theme_options_default_design[theme_plusKeyColorLight]',
	)));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'KeyColorDark', array(
		'label'    => __('Keycolor(Dark)', 'biz-vektor'),
		'section'  => 'biz_vektor_default_design',
		'settings' => 'biz_vektor_theme_options_default_design[theme_plusKeyColorDark]',
	)));
	}
}


/*-------------------------------------------*/
/*  keycolor filter
/*-------------------------------------------*/
add_filter( 'biz_vektor_keycolors', 'biz_vektor_calmly_default_keycolor' );
function biz_vektor_calmly_default_keycolor($colors){
	if(is_bizvektor_default_design()){
		$options = biz_vektor_get_theme_options_calmly();
		$colors['keyColor'] = (isset($options['theme_plusKeyColor']) and $options['theme_plusKeyColor'])? $options['theme_plusKeyColor'] : '#c30000';
	}
	return $colors;
}


/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
add_filter('themePlusSettingNavi','themePlusSettingNavi_default_design');
function themePlusSettingNavi_default_design(){
	global $themePlusSettingNavi;
	if (is_bizvektor_default_design()){
		$themePlusSettingNavi = '<p>[ <a href="'.get_admin_url().'customize.php">&raquo; '.__('Set the color from theme customizer', 'biz-vektor').'</a> ]</p>';
	}
	return $themePlusSettingNavi;
}

/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/
add_action( 'wp_head','biz_vektor_default_design_WpHead', 150);
function biz_vektor_default_design_WpHead(){
	if (is_bizvektor_default_design()){
		$default_design_options = biz_vektor_get_theme_options_default_design();
		if( !isset($default_design_options['theme_plusKeyColor']) || $default_design_options['theme_plusKeyColor'] == '' ) $default_design_options['theme_plusKeyColor'] = '#c30000';
		if( !isset($default_design_options['theme_plusKeyColorLight']) || $default_design_options['theme_plusKeyColorLight'] == '' ) $default_design_options['theme_plusKeyColorLight'] = '#ff0000';
		if( !isset($default_design_options['theme_plusKeyColorDark']) || $default_design_options['theme_plusKeyColorDark'] == '' ) $default_design_options['theme_plusKeyColorDark'] = '#990000';
?>
		<style type="text/css">
a	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
a:hover	{ color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>;}

a.btn,
.linkBtn.linkBtnS a,
.linkBtn.linkBtnM a,
.moreLink a,
.btn.btnS a,
.btn.btnM a,
.btn.btnL a,
#content p.btn.btnL input,
input[type=button],
input[type=submit],
#searchform input[type=submit],
p.form-submit input[type=submit],
form#searchform input#searchsubmit,
#content form input.wpcf7-submit,
#confirm-button input	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;color:#f5f5f5; }

.moreLink a:hover,
.btn.btnS a:hover,
.btn.btnM a:hover,
.btn.btnL a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>; color:#f5f5f5;}

#headerTop { border-top-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;}
#header #headContact #headContactTel	{color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;}

#gMenu	{ border-top:2px solid <?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#gMenu h3.assistive-text {
background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;
border-right:1px solid <?php echo $default_design_options['theme_plusKeyColorDark'] ?>;
background: -webkit-gradient(linear, 0 0, 0 bottom, from(<?php echo $default_design_options['theme_plusKeyColor'] ?>), to(<?php echo $default_design_options['theme_plusKeyColorDark'] ?>));
background: -moz-linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
background: linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
-ms-filter: "progid:DXImageTransform.Microsoft.Gradient(StartColorStr=<?php echo $default_design_options['theme_plusKeyColor'] ?>, EndColorStr=<?php echo $default_design_options['theme_plusKeyColorDark'] ?>)";
}

#gMenu .menu li.current_page_item > a,
#gMenu .menu li > a:hover { background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#pageTitBnr	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#panList a	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#panList a:hover	{ color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>; }

#content h2,
#content h1.contentTitle,
#content h1.entryPostTitle { border-top:2px solid <?php echo $default_design_options['theme_plusKeyColor'] ?>;}
#content h3	{ border-left-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;}
#content h4,
#content dt	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#content .infoList .infoCate a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#content .child_page_block h4 a	{ border-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#content .child_page_block h4 a:hover,
#content .child_page_block p a:hover	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#content .childPageBox ul li.current_page_item li a	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#content .mainFootContact p.mainFootTxt span.mainFootTel	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#content .mainFootContact .mainFootBt a			{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#content .mainFootContact .mainFootBt a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>; }

.sideTower .localHead	{ border-top-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
.sideTower li.sideBnr#sideContact a		{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
.sideTower li.sideBnr#sideContact a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>; }
.sideTower .sideWidget h4	{ border-left-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

#pagetop a	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#footMenu	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;border-top-color:<?php echo $default_design_options['theme_plusKeyColorDark'] ?>; }

#topMainBnr	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#topMainBnrFrame a.slideFrame:hover	{ border:4px solid <?php echo $default_design_options['theme_plusKeyColorLight'] ?>; }

#topPr .topPrInner h3	{ border-left-color:<?php echo $default_design_options['theme_plusKeyColor'] ?> ; }
#topPr .topPrInner p.moreLink a	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#topPr .topPrInner p.moreLink a:hover { background-color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>; }

.paging span,
.paging a	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;border:1px solid <?php echo $default_design_options['theme_plusKeyColor'] ?>; }
.paging span.current,
.paging a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

@media (min-width: 770px) {
#gMenu .menu > li.current_page_item > a,
#gMenu .menu > li.current-menu-item > a,
#gMenu .menu > li.current_page_ancestor > a ,
#gMenu .menu > li.current-page-ancestor > a ,
#gMenu .menu > li > a:hover	{
background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;
border-right:1px solid <?php echo $default_design_options['theme_plusKeyColorDark'] ?>;
background: -webkit-gradient(linear, 0 0, 0 bottom, from(<?php echo $default_design_options['theme_plusKeyColor'] ?>), to(<?php echo $default_design_options['theme_plusKeyColorDark'] ?>));
background: -moz-linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
background: linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
-ms-filter: "progid:DXImageTransform.Microsoft.Gradient(StartColorStr=<?php echo $default_design_options['theme_plusKeyColor'] ?>, EndColorStr=<?php echo $default_design_options['theme_plusKeyColorDark'] ?>)";
}
}
		</style>
<!--[if lte IE 8]>
<style type="text/css">
#gMenu .menu > li.current_page_item > a,
#gMenu .menu > li.current_menu_item > a,
#gMenu .menu > li.current_page_ancestor > a ,
#gMenu .menu > li.current-page-ancestor > a ,
#gMenu .menu > li > a:hover	{
background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>;
border-right:1px solid <?php echo $default_design_options['theme_plusKeyColorDark'] ?>;
background: -webkit-gradient(linear, 0 0, 0 bottom, from(<?php echo $default_design_options['theme_plusKeyColor'] ?>), to(<?php echo $default_design_options['theme_plusKeyColorDark'] ?>));
background: -moz-linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
background: linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
-ms-filter: "progid:DXImageTransform.Microsoft.Gradient(StartColorStr=<?php echo $default_design_options['theme_plusKeyColor'] ?>, EndColorStr=<?php echo $default_design_options['theme_plusKeyColorDark'] ?>)";
}
</style>
<![endif]-->

	<?php }
}