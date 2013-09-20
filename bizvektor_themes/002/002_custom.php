<?php

/*-------------------------------------------*/
/*	今適応されているテーマがcalmlyかどうかの判定
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
/*	今適応されているテーマがcalmlyかどうかの判定
/*-------------------------------------------*/
function is_calmly(){
	if (function_exists('biz_vektor_theme_styleSetting')) {
		$options = biz_vektor_get_theme_options();
		$calmlyLabels = array('calmly','calmlyBrace','calmlyFlat','calmlyBraceFlat');
		$calmlyLabels = apply_filters( 'addCalmlyLabels',$calmlyLabels );
		foreach ($calmlyLabels as $themeLabel) {
			if ($options['theme_style'] == $themeLabel):
				return true;
				break;
			endif;
		}
	}
}

/*-------------------------------------------*/
/*
/*-------------------------------------------*/
add_action( 'admin_init', 'biz_vektor_theme_options_calmly_init' );
function biz_vektor_theme_options_calmly_init() {
	if (is_calmly()){
		if ( false === biz_vektor_get_theme_options_calmly() )
			add_option( 'biz_vektor_theme_options_calmly' );
			register_setting(
				'biz_vektor_options_calmly',
				'biz_vektor_theme_options_calmly',
				'biz_vektor_theme_options_calmly_validate'
			);
		}
}
/*-------------------------------------------*/
/*	functionsで毎回呼び出して$optionsに入れる処理を他でする。
/*-------------------------------------------*/
function biz_vektor_get_theme_options_calmly() {
	return get_option( 'biz_vektor_theme_options_calmly' );
}

/*-------------------------------------------*/
/*	変数設定
/*-------------------------------------------*/
function biz_vektor_theme_options_calmly_validate( $input ) {
	$output = $defaults;
	// 拡張テーマキーカラー
	$output['theme_plusKeyColor'] = $input['theme_plusKeyColor'];
	$output['theme_plusKeyColorLight'] = $input['theme_plusKeyColorLight'];
	$output['theme_plusKeyColorVeryLight'] = $input['theme_plusKeyColorVeryLight'];
	$output['theme_plusKeyColorDark'] = $input['theme_plusKeyColorDark'];
	return apply_filters( 'biz_vektor_theme_options_calmly_validate', $output, $input, $defaults );
}

/*-------------------------------------------*/
/*	テーマカスタマイザーの設定
/*-------------------------------------------*/
add_action( 'customize_register', 'bizvektor_calmly_customize_register' );
function bizvektor_calmly_customize_register($wp_customize) {
	if (is_calmly()){
    // セクションを追加
    $wp_customize->add_section( 'biz_vektor_calmly', array(
        'title'          => 'Calmlyカラー設定',
        'priority'       => 1000,
    ) );
	 // セクションの動作設定
	$wp_customize->add_setting( 'biz_vektor_theme_options_calmly[theme_plusKeyColor]',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	// セクションのUIを作成する
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		'label'    => 'キーカラー',
		'section'  => 'biz_vektor_calmly',
		'settings' => 'biz_vektor_theme_options_calmly[theme_plusKeyColor]',
	)));
	}
}

/*-------------------------------------------*/
/*	管理画面_テーマオプション_デザインプルダウンの下に設定へのリンクを追加
/*-------------------------------------------*/
// 第一引数：フィルターフック名　／　第二引数：実行関数名
add_filter('themePlusSettingNavi','themePlusSettingNaviCalmly');
function themePlusSettingNaviCalmly(){
	global $themePlusSettingNavi;
	if (is_calmly()){
		$themePlusSettingNavi = '<p>[ <a href="'.get_admin_url().'customize.php" target="_blank">→ テーマカスタマイザーで色を設定する</a> ]</p>';
	}
	return $themePlusSettingNavi;
}



/*-------------------------------------------*/
/*	head出力
/*-------------------------------------------*/
add_action( 'wp_head','calmlyWpHead');
function calmlyWpHead(){
	if (is_calmly()){
	$calmlyOptions = biz_vektor_get_theme_options_calmly();
	?>
		<style type="text/css">
/* FontNormal */
a,
a:hover,
a:active,
#header #headContact #headContactTel,
#gMenu .menu li a span,
#content h4,
#content h5,
#content dt,
#content .child_page_block h4 a:hover,
#content .child_page_block p a:hover,
.paging span,
.paging a,
#content .infoList ul li .infoTxt a:hover,
#content .infoList .infoListBox div.entryTxtBox h4.entryTitle a,
#footerSiteMap .menu a:hover,
#topPr h3 a:hover,
#topPr .topPrDescription a:hover,
#content ul.linkList li a:hover,
#content .childPageBox ul li.current_page_item a,
#content .childPageBox ul li.current_page_item ul li a:hover,
#content .childPageBox ul li a:hover,
#content .childPageBox ul li.current_page_item a	{ color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}

/* bg */
::selection			{ background-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}
::-moz-selection	{ background-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}
/* bg */
#gMenu .assistive-text,
#content .mainFootContact .mainFootBt a,
.paging span.current,
.paging a:hover,
#content .infoList .infoCate a:hover,
#sideTower li.sideBnr#sideContact a,
form#searchform input#searchsubmit,
#pagetop a:hover,
a.btn,
.linkBtn a,
input[type=button],
input[type=submit]	{ background-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}

/* border */
#searchform input[type=submit],
p.form-submit input[type=submit],
form#searchform input#searchsubmit,
#content form input.wpcf7-submit,
#confirm-button input,
a.btn,
.linkBtn a,
input[type=button],
input[type=submit],
.moreLink a,
#headerTop,
#content h3,
#content .child_page_block h4 a,
.paging span,
.paging a,
form#searchform input#searchsubmit	{ border-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}

#gMenu	{ border-top-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>;}
#content h2,
#content h1.contentTitle,
#content h1.entryPostTitle,
#sideTower .localHead,
#topPr h3 a	{ border-bottom-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }

@media (min-width: 770px) {
#gMenu { border-top-color:#eeeeee;}
#gMenu	{ border-bottom-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
#footMenu .menu li a:hover	{ color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
}
		</style>
<!--[if lte IE 8]>
<style type="text/css">
#gMenu	{ border-bottom-color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
#footMenu .menu li a:hover	{ color:<?php echo $calmlyOptions['theme_plusKeyColor'] ?>; }
</style>
<![endif]-->
	<?php }
}