<?php

/*-------------------------------------------*/
/*	Judge rebuild
/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
/*	Setting customizer
//*-------------------------------------------*/
/*	Get 'rebuild' options
/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/

/*-------------------------------------------*/
/*	Judge rebuild
/*-------------------------------------------*/
function is_rebuild(){
	if (function_exists('biz_vektor_theme_styleSetting')) {
		$options = biz_vektor_get_theme_options();
		if ( $options['theme_style'] == 'rebuild' || $options['theme_style'] == '' ){
			return true;
		} else {
			/*
			一度保存されているラベルのスキンプラグインが停止またはアンインストールされている事があるので、
			保存されているスキンが使用出来るか判別するために変数の配列を確認。なければ変わりにrebuildを適用するのでtrueとする
			*/
			global $biz_vektor_theme_styles;
			biz_vektor_theme_styleSetting();
			if ( isset( $biz_vektor_theme_styles[$options['theme_style']] )){
				return false;
			} else {
				return true;
			}
			// print '<pre>';print_r($biz_vektor_theme_styles[$options['theme_style']]);print '</pre>';
		}
	}
}

if (is_rebuild()){
	require( dirname( __FILE__ ) . '/functions_003.php' );
}

/*-------------------------------------------*/
/*	Admin page _ Add link bottom of pulldown
/*-------------------------------------------*/
add_filter('themePlusSettingNavi','themePlusSettingNavi_rebuild');
function themePlusSettingNavi_rebuild(){
	global $themePlusSettingNavi;
	if (is_rebuild()){
		$themePlusSettingNavi = '<p>[ <a href="'.get_admin_url().'customize.php">&raquo; '.__('Set the color from theme customizer', 'biz-vektor').'</a> ]</p>';
	}
	return $themePlusSettingNavi;
}

/*-------------------------------------------*/
/*	Setting customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'bizvektor_rebuild_customize_register' );
function bizvektor_rebuild_customize_register($wp_customize) {
	if (is_rebuild()){
    // Add section
    $wp_customize->add_section( 'biz_vektor_rebuild', array(
        'title'          => __('Rebuild color setting', 'biz-vektor'),
        'priority'       => 110,
    ) );

	$wp_customize->add_setting( 'biz_vektor_theme_options_rebuild[theme_plusKeyColor]',
		array('rebuild' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	$wp_customize->add_setting( 'biz_vektor_theme_options_rebuild[theme_plusKeyColorLight]',
		array('rebuild' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	$wp_customize->add_setting( 'biz_vektor_theme_options_rebuild[theme_plusKeyColorVeryLight]',
		array('rebuild' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	// Create section UI
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		'label'    => __('Keycolor', 'biz-vektor'),
		'section'  => 'biz_vektor_rebuild',
		'settings' => 'biz_vektor_theme_options_rebuild[theme_plusKeyColor]',
	)));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'KeyColorLight', array(
		'label'    => __('Keycolor(Light)', 'biz-vektor'),
		'section'  => 'biz_vektor_rebuild',
		'settings' => 'biz_vektor_theme_options_rebuild[theme_plusKeyColorLight]',
	)));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'KeyColorVeryLight', array(
		'label'    => __('Keycolor(VeryLight)', 'biz-vektor'),
		'section'  => 'biz_vektor_rebuild',
		'settings' => 'biz_vektor_theme_options_rebuild[theme_plusKeyColorVeryLight]',
	)));
	}
}

/*-------------------------------------------*/
/*	Get 'rebuild' options
/*-------------------------------------------*/
function biz_vektor_get_theme_options_rebuild() {
	return get_option( 'biz_vektor_theme_options_rebuild' );
}


/*-------------------------------------------*/
/*  keycolor filter
/*-------------------------------------------*/
add_filter( 'biz_vektor_keycolors', 'biz_vektor_rebuild_set_keycolor' );
function biz_vektor_rebuild_set_keycolor($colors){
	if(is_rebuild()){
		$options = biz_vektor_get_theme_options_rebuild();
		$colors['keyColor'] = (isset($options['theme_plusKeyColor']) and $options['theme_plusKeyColor'])? $options['theme_plusKeyColor'] : '#e90000';
	}
	return $colors;
}


/*-------------------------------------------*/
/*	Print head
/*-------------------------------------------*/
add_action( 'wp_head','biz_vektor_rebuild_print_css', 150);
function biz_vektor_rebuild_print_css(){
	if (is_rebuild()){
	$rebuildOptions = biz_vektor_get_theme_options_rebuild();
	$rebuild_array = array(
		array(
			'key' => 'theme_plusKeyColor',
			'name' => 'Keycolor',
			'default' => '#e90000'
			),
		array(
			'key' => 'theme_plusKeyColorLight',
			'name' => 'Keycolor(Light)',
			'default' => '#ff0000'
			),
		array(
			'key' => 'theme_plusKeyColorVeryLight',
			'name' => 'Keycolor(VeryLight)',
			'default' => 'fff5f5'
			)
		);
	// 設定項目をループする
	foreach ($rebuild_array as $key => $value) {
		if (isset($rebuildOptions[$value['key']]) && $rebuildOptions[$value['key']] ) {
			// 保存されている配列の中に ループ中の項目が保存されていれば $color_key に代入
			$color_key[$value['key']] = esc_html($rebuildOptions[$value['key']]);
		} else {
			// 保存されている配列の中に ループ中の項目が保存されていなければ 初期値を代入
			$color_key[$value['key']] = $value['default'];
		}
	}
		if ( $rebuildOptions ) : ?>
		<style type="text/css">

a { color:<?php echo $color_key['theme_plusKeyColorLight'];?> }

#searchform input[type=submit],
p.form-submit input[type=submit],
form#searchform input#searchsubmit,
.content form input.wpcf7-submit,
#confirm-button input,
a.btn,
.linkBtn a,
input[type=button],
input[type=submit],
.sideTower li#sideContact.sideBnr a,
.content .infoList .rssBtn a { background-color:<?php echo $color_key['theme_plusKeyColor'];?>; }

.moreLink a { border-left-color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.moreLink a:hover { background-color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.moreLink a:after { color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.moreLink a:hover:after { color:#fff; }

#headerTop { border-top-color:<?php echo $color_key['theme_plusKeyColor'];?>; }

.headMainMenu li:hover { color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.headMainMenu li > a:hover,
.headMainMenu li.current_page_item > a { color:<?php echo $color_key['theme_plusKeyColor'];?>; }

#pageTitBnr { background-color:<?php echo $color_key['theme_plusKeyColor'];?>; }

.content h2,
.content h1.contentTitle,
.content h1.entryPostTitle,
.sideTower h3.localHead,
.sideWidget h4  { border-top-color:<?php echo $color_key['theme_plusKeyColor'];?>; }

.content h3:after,
.content .child_page_block h4:after { border-bottom-color:<?php echo $color_key['theme_plusKeyColor'];?>; }

.sideTower li#sideContact.sideBnr a:hover,
.content .infoList .rssBtn a:hover,
form#searchform input#searchsubmit:hover { background-color:<?php echo $color_key['theme_plusKeyColorLight'];?>; }

#panList .innerBox ul a:hover { color:<?php echo $color_key['theme_plusKeyColorLight'];?>; }

.content .mainFootContact p.mainFootTxt span.mainFootTel { color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.content .mainFootContact .mainFootBt a { background-color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.content .mainFootContact .mainFootBt a:hover { background-color:<?php echo $color_key['theme_plusKeyColorLight'];?>; }

.content .infoList .infoCate a { background-color:<?php echo $color_key['theme_plusKeyColorVeryLight'];?>;color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.content .infoList .infoCate a:hover { background-color:<?php echo $color_key['theme_plusKeyColorLight'];?>; }

.paging span,
.paging a	{ color:<?php echo $color_key['theme_plusKeyColor'];?>;border-color:<?php echo $color_key['theme_plusKeyColor'];?>; }
.paging span.current,
.paging a:hover	{ background-color:<?php echo $color_key['theme_plusKeyColor'];?>; }

/* アクティブのページ */
.sideTower .sideWidget li > a:hover,
.sideTower .sideWidget li.current_page_item > a,
.sideTower .sideWidget li.current-cat > a	{ color:<?php echo $color_key['theme_plusKeyColor'];?>; background-color:<?php echo $color_key['theme_plusKeyColorVeryLight'];?>; }

.sideTower .ttBoxSection .ttBox a:hover { color:<?php echo $color_key['theme_plusKeyColor'];?>; }

#footMenu { border-top-color:<?php echo $color_key['theme_plusKeyColor'];?>; }
#footMenu .menu li a:hover { color:<?php echo $color_key['theme_plusKeyColor']; ?> }

@media (min-width: 970px) {
.headMainMenu li:hover li a:hover { color:#333; }
.headMainMenu li.current-page-item a,
.headMainMenu li.current_page_item a,
.headMainMenu li.current-menu-ancestor a,
.headMainMenu li.current-page-ancestor a { color:#333;}
.headMainMenu li.current-page-item a span,
.headMainMenu li.current_page_item a span,
.headMainMenu li.current-menu-ancestor a span,
.headMainMenu li.current-page-ancestor a span { color:<?php echo $color_key['theme_plusKeyColor'];?>; }
}

</style>
<!--[if lte IE 8]>
<style type="text/css">
.headMainMenu li:hover li a:hover { color:#333; }
.headMainMenu li.current-page-item a,
.headMainMenu li.current_page_item a,
.headMainMenu li.current-menu-ancestor a,
.headMainMenu li.current-page-ancestor a { color:#333;}
.headMainMenu li.current-page-item a span,
.headMainMenu li.current_page_item a span,
.headMainMenu li.current-menu-ancestor a span,
.headMainMenu li.current-page-ancestor a span { color:<?php echo $color_key['theme_plusKeyColor'];?>; }
</style>
<![endif]-->
<?php endif; // if ( $rebuildOptions )
	}
}