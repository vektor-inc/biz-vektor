<?php 
/*-------------------------------------------*/
/*	テーマカスタマイザー
/*-------------------------------------------*/
 // https://gist.github.com/2968549
 // http://ottopress.com/tag/customizer/
 

/*	テーマカスタマイザーでテキストエリアが使えるようにclassを作成
/*-------------------------------------------*/
if(class_exists('WP_Customize_Control')):
	class customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="3" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}
endif;

add_action( 'customize_register', 'bizvektor_customize_register' );
function bizvektor_customize_register($wp_customize) {
	
	// 余分なセクションを削除（別にリアルタイムに見ながら設定せんでもええやろ・・・）
	$wp_customize->remove_section( 'static_front_page' );	// 固定フロントページ
	$wp_customize->remove_section( 'nav' );
//	$wp_customize->section( 'colors', array(
	//'title'          => '背景'
	//));
 
	//テーマカスタマイザーの項目を調整中
/*

	$wp_customize->remove_section( 'colors' );

    // セクションを追加
    $wp_customize->add_section( 'biz_vektor_bg', array(
        'title'          => 'BizVektor背景',
        'priority'       => 15,
    ) );
	 // セクションの動作設定
	$wp_customize->add_setting( '???????????',	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
	// セクションのUIを作成する
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		'label'    => '背景色',
		'section'  => 'biz_vektor_bg',
		'settings' => 'background_color',
	)));
*/

// print "<div align='left' style='text-align:left'>";
// print "<pre>";
// print_r($wp_customize);
// print "</pre>";
// print "</div>";
	/*	デザインの設定
	/*-------------------------------------------*/
    // セクションの動作設定
    $wp_customize->add_section( 'biz_vektor_design', array(
        'title'          => 'デザインの設定',
        'priority'       => 100,
    ) );

    $add_setting_array = array(
        'default'        => '',
        'type'           => 'option',
        'capability'     => 'edit_theme_options', // 操作権限
    );
    $wp_customize->add_setting( 'biz_vektor_theme_options[theme_style]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[head_logo]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[foot_logo]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[gMenuDivide]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[theme_layout]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[font_title]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[font_menu]',  $add_setting_array );

		// Create BizVektor　Theme styles Array
		global $biz_vektor_theme_styles;
		biz_vektor_theme_styleSetting();
		foreach( $biz_vektor_theme_styles as $biz_vektor_theme_styleKey => $biz_vektor_theme_styleValues) {
			$biz_vektor_style_array[$biz_vektor_theme_styleKey] = $biz_vektor_theme_styleValues['label'];
		}
		// セクションのUIを作成する
		$wp_customize->add_control( 'theme_style',array(
			'label'     => 'デザイン',
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[theme_style]',
			'type' => 'select',
			'choices' => $biz_vektor_style_array,
			'priority' => 01,
		));
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'head_logo',	// 多分名前は何でもOK
			array(
				'label'     => 'ヘッダーロゴ画像',						// セクションの中での表示名
				'section'   => 'biz_vektor_design', 				// テーマカスタマイザーのどのセクションに入れるか
				'settings'  => 'biz_vektor_theme_options[head_logo]',	// DBのどこに格納するか
				'priority'  => 101,
			)
		) );
		$wp_customize->add_control( 'head_logo_url_txt',
			array(
				'label'     => 'ヘッダーロゴ画像URL',
				'section'   => 'biz_vektor_design', 
				'settings'  => 'biz_vektor_theme_options[head_logo]',
				'type' => 'text',
				'priority' => 102,
			));

		// セクションのUIを作成する
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'foot_logo',	// 多分名前は何でもOK
			array(
				'label'     => 'フッターロゴ画像',						// セクションの中での表示名
				'section'   => 'biz_vektor_design', 				// テーマカスタマイザーのどのセクションに入れるか
				'settings'  => 'biz_vektor_theme_options[foot_logo]',	// DBのどこに格納するか
				'priority' => 111,
			)
		) );
		$wp_customize->add_control( 'foot_logo_url_txt',
			array(
				'label'     => 'フッターロゴ画像URL',
				'section'   => 'biz_vektor_design', 
				'settings'  => 'biz_vektor_theme_options[foot_logo]',
				'type' => 'text',
				'priority' => 112,
			));

		$biz_vektor_gMenuDivides = array('divide_natural' => '指定なし（左詰め）','divide_4' => '4分割','divide_5' => '5分割','divide_6' => '6分割','divide_7' => '7分割');
		$wp_customize->add_control( 'gMenuDivide',array(
			'label'     => 'ヘッダーメニューの数',
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[gMenuDivide]',
			'type' => 'select',
			'choices' => $biz_vektor_gMenuDivides,
			'priority' => 200,
		));

		foreach ( biz_vektor_layouts() as $layout ) {
			$biz_vektor_layout_array[$layout['value']] = $layout['label'];
		}
		$wp_customize->add_control( 'biz_vektor_layout',array(
			'label'     => 'レイアウト',
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[theme_layout]',
			'type' => 'radio',
			'choices' => $biz_vektor_layout_array,
			'priority' => 301,
		));
		// $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'keyColor', array(
		// 	'label'    => '背景色',
		// 	'section'  => 'biz_vektor_design',
		// 	'settings' => 'biz_vektor_theme_options[bg_color]',
		// 	'priority' => 401,
		// )));
		$wp_customize->add_control( 'font',array(
			'label'     => '見出しの書体',
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[font_title]',
			'type' => 'radio',
			'choices' => array(
				'serif' => '明朝',
				'sanserif' => 'ゴシック',
				),
			'priority' => 501,
		));
		$wp_customize->add_control( 'font_menu',array(
			'label'     => 'グローバルメニューの書体',
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[font_menu]',
			'type' => 'radio',
			'choices' => array(
				'serif' => '明朝',
				'sanserif' => 'ゴシック',
				),
			'priority' => 502,
		));


	/*	連絡先の設定
	/*-------------------------------------------*/
	// セクションを追加
	$wp_customize->add_section( 'biz_vektor_contact', array(
	    'title'          => '連絡先の設定',
	    'priority'       => 101,
	));

		$add_setting_array = array(
		    'default'        => '',
		    'type'           => 'option',
		    'capability'     => 'edit_theme_options', // 操作権限
		);
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_txt]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[tel_number]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_time]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[sub_sitename]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_address]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_link]',  $add_setting_array );

		$wp_customize->add_control( 'contact_txt',
			array(
				'label'     => 'お問い合わせメッセージ',
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_txt]',
				'type' => 'text',
				'priority' => 1,
			));
		$wp_customize->add_control( 'tel_number',
			array(
				'label'     => '電話番号',
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[tel_number]',
				'type' => 'text',
				'priority' => 2,
			));
		$wp_customize->add_control( 'contact_time',
			array(
				'label'     => '受付時間',
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_time]',
				'type' => 'text',
				'priority' => 3,
			));		
		$wp_customize->add_control( 'sub_sitename',
			array(
				'label'     => 'フッター左下とフッターコピーライトに表示させるサイト名（あるいは企業名・店舗名・サービス名）',
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[sub_sitename]',
				'type' => 'text',
				'priority' => 4,
			));
		$wp_customize->add_control( new customize_Textarea_Control( $wp_customize,'contact_address',
			array(
				'label'     => '住所',
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_address]',
				//'type' => 'textfield',
				'priority' => 5,
			)));
		$wp_customize->add_control( 'contact_link',
			array(
				'label'     => '問い合わせページのURL',
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_link]',
				'type' => 'text',
				'priority' => 6,
			));

	/*	トップページ3PR
	/*-------------------------------------------*/
    // セクションを追加
    $wp_customize->add_section( 'biz_vektor_top3pr', array(
        'title'          => 'トップページ3PRエリアの設定',
        'priority'       => 102,
    ) );
    
	for ( $i = 1; $i <= 3 ;){
		// セクションの動作設定
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_title]', 		array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_description]', 	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_link]', 			array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_image]', 		array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_image_s]', 		array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		// セクションのUIを作成する
		$wp_customize->add_control( 'pr'.$i.'_title',
			array(
				'label'     => '【'.$i.'】タイトル',
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_title]',
				'type' => 'text',
				'priority' => ($i*10)+1,
			)
		);
		$wp_customize->add_control( new customize_Textarea_Control( $wp_customize, 'pr'.$i.'_description',
			array(
				'label'     => '【'.$i.'】概要',
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_description]',
				'priority' => ($i*10)+2,
			)));
		$wp_customize->add_control( 'pr'.$i.'_link',
			array(
				'label'     => '【'.$i.'】リンク先ページのURL',
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_link]',
				'type' => 'text',
				'priority' => ($i*10)+3,
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'pr'.$i.'_image',
			array(
				'label'     => '【'.$i.'】画像（横 310px 程度長方形推奨）',
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_image]',
				'priority' => ($i*10)+4,
			))
		);
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'pr'.$i.'_image_s',
			array(
				'label'     => '【'.$i.'】スマホ用画像（120×120px 程度推奨）',
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_image_s]',
				'priority' => ($i*10)+5,
			))
		);

	$i++;
	}
}