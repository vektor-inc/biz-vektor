<?php

/*-------------------------------------------*/
/*	今適応されているテーマがdefault_designかどうかの判定
/*-------------------------------------------*/
/*
/*-------------------------------------------*/
/*	functionsで毎回呼び出して$optionsに入れる処理を他でする。
/*-------------------------------------------*/
/*	変数設定
/*-------------------------------------------*/
/*	テーマカスタマイザーの設定
/*-------------------------------------------*/
/*	管理画面_拡張設定メニューを追加
/*-------------------------------------------*/
/*	管理画面_拡張設定画面
/*-------------------------------------------*/
/*	管理画面_テーマオプション_デザインプルダウンの下に設定へのリンクを追加
/*-------------------------------------------*/
/*	head出力
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	今適応されているテーマがdefault_designかどうかの判定
/*-------------------------------------------*/
function is_bizvektor_default_design(){
	if (function_exists('biz_vektor_theme_styleSetting'))
	{
		$options = biz_vektor_get_theme_options();
		if ($options['theme_style'] == 'default') {
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
/*	functionsで毎回呼び出して$optionsに入れる処理を他でする。
/*-------------------------------------------*/
function biz_vektor_get_theme_options_default_design() {
	return get_option( 'biz_vektor_theme_options_default_design' );
}

/*-------------------------------------------*/
/*	変数設定
/*-------------------------------------------*/
function biz_vektor_theme_options_default_design_validate( $input ) {
	$output = $defaults;
	// 拡張テーマキーカラー
	$output['theme_plusKeyColor'] = $input['theme_plusKeyColor'];
	$output['theme_plusKeyColorLight'] = $input['theme_plusKeyColorLight'];
	$output['theme_plusKeyColorVeryLight'] = $input['theme_plusKeyColorVeryLight'];
	$output['theme_plusKeyColorDark'] = $input['theme_plusKeyColorDark'];
	return apply_filters( 'biz_vektor_theme_options_default_design_validate', $output, $input, $defaults );
}

/*-------------------------------------------*/
/*	テーマカスタマイザーの設定
/*-------------------------------------------*/
add_action( 'customize_register', 'bizvektor_default_design_customize_register' );
function bizvektor_default_design_customize_register($wp_customize) {
	if (is_bizvektor_default_design()){
    // セクションを追加
    $wp_customize->add_section( 'biz_vektor_default_design', array(
        'title'          => 'Default カラー設定',
        'priority'       => 1000,
    ) );
	 // セクションの動作設定
	$wp_customize->add_setting( 'biz_vektor_theme_options_default_design[theme_plusKeyColor]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	$wp_customize->add_setting( 'biz_vektor_theme_options_default_design[theme_plusKeyColorLight]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	$wp_customize->add_setting( 'biz_vektor_theme_options_default_design[theme_plusKeyColorDark]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	// セクションのUIを作成する
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		'label'    => 'キーカラー',
		'section'  => 'biz_vektor_default_design',
		'settings' => 'biz_vektor_theme_options_default_design[theme_plusKeyColor]',
	)));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'KeyColorLight', array(
		'label'    => 'キーカラー（明）※リンクにマウスオーバーした時の色です',
		'section'  => 'biz_vektor_default_design',
		'settings' => 'biz_vektor_theme_options_default_design[theme_plusKeyColorLight]',
	)));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'KeyColorDark', array(
		'label'    => 'キーカラー（暗）※メニューやフッターに奥行きを出します',
		'section'  => 'biz_vektor_default_design',
		'settings' => 'biz_vektor_theme_options_default_design[theme_plusKeyColorDark]',
	)));
	}
}

/*-------------------------------------------*/
/*	管理画面_テーマオプション_デザインプルダウンの下に設定へのリンクを追加
/*-------------------------------------------*/
// 第一引数：フィルターフック名　／　第二引数：実行関数名
add_filter('themePlusSettingNavi','themePlusSettingNavi_default_design');
function themePlusSettingNavi_default_design(){
	global $themePlusSettingNavi;
	if (is_bizvektor_default_design()){
		$themePlusSettingNavi = '<p>[ <a href="'.get_admin_url().'customize.php" target="_blank">→ テーマカスタマイザーで色を設定する</a> ]</p>';
	}
	return $themePlusSettingNavi;
}



/*-------------------------------------------*/
/*	head出力
/*-------------------------------------------*/
add_action( 'wp_head','default_design_WpHead');
function default_design_WpHead(){
	if (is_bizvektor_default_design()){
	$default_design_options = biz_vektor_get_theme_options_default_design();
	?>
		<style type="text/css">
a	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
a:hover	{ color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>;}

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
#gMenu h3.assistive-text,
#gMenu .menu li.current_page_item a,
#gMenu .menu li.current_page_ancestor a ,
#gMenu .menu li.current-page-ancestor a ,
#gMenu .menu li a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; border-right:1px solid <?php echo $default_design_options['theme_plusKeyColorDark'] ?>;
background: -webkit-gradient(linear, 0 0, 0 bottom, from(<?php echo $default_design_options['theme_plusKeyColor'] ?>), to(<?php echo $default_design_options['theme_plusKeyColorDark'] ?>));
background: -moz-linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
background: linear-gradient(<?php echo $default_design_options['theme_plusKeyColor'] ?>, <?php echo $default_design_options['theme_plusKeyColorDark'] ?>);
-ms-filter: "progid:DXImageTransform.Microsoft.Gradient(StartColorStr=<?php echo $default_design_options['theme_plusKeyColor'] ?>, EndColorStr=<?php echo $default_design_options['theme_plusKeyColorDark'] ?>)";
}
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

#sideTower .localHead	{ border-top-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#sideTower li.sideBnr#sideContact a		{ background-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#sideTower li.sideBnr#sideContact a:hover	{ background-color:<?php echo $default_design_options['theme_plusKeyColorLight'] ?>; }
#sideTower .sideWidget h4	{ border-left-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }

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

}
		</style>
<!--[if lte IE 8]>
<style type="text/css">
#gMenu	{ border-bottom-color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
#footMenu .menu li a:hover	{ color:<?php echo $default_design_options['theme_plusKeyColor'] ?>; }
</style>
<![endif]-->
	<?php }
}