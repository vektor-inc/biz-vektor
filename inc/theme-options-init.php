<?php

/*-------------------------------------------*/
/*	Theme Option の初期設定
/*-------------------------------------------*/
/*	送信した値をデータベースに登録したり、サニタイズする
/*-------------------------------------------*/
/*	Set option default
/*-------------------------------------------*/
/*	入力された値の処理
/*-------------------------------------------*/
/*	テーマオプション取得
/*-------------------------------------------*/
/*	Print option
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Theme Option の初期設定
/*-------------------------------------------*/
function biz_vektor_theme_options_init() {
	// biz_vektor_theme_options が存在しなかったら作る
	if ( false === get_option( 'biz_vektor_theme_options' ) ) {
		add_option( 'biz_vektor_theme_options', biz_vektor_generate_default_options() );
	}

	global $biz_vektor_options;
	$biz_vektor_options = get_option( 'biz_vektor_theme_options' );
}
add_action( 'after_setup_theme', 'biz_vektor_theme_options_init' );

/*-------------------------------------------*/
/*	送信した値をデータベースに登録したり、サニタイズする
/*-------------------------------------------*/
function biz_vektor_option_register() {
	register_setting(
		'biz_vektor_options',                   // 設定のグループ名。ここで指定した名前をsettings_fields関数の引数に指定します。
		'biz_vektor_theme_options',             // 登録するオプションの名前。input要素などのname属性を指定します。
		'biz_vektor_theme_options_validate'     // オプションの値をサニタイズするためのコールバック関数。
	);
}
add_action( 'admin_init', 'biz_vektor_option_register' );

/*-------------------------------------------*/
/*	Theme Option Default
/*-------------------------------------------*/

function biz_vektor_generate_default_options() {
		$default_theme_options = array(
			'font_title'           => 'sanserif',
			'font_menu'            => 'sanserif',
			'global_font'          => 'Open+Sans',
			'gMenuDivide'          => '',
			'head_logo'            => '',
			'foot_logo'            => '',
			'contact_txt'          => '',
			'tel_number'           => '',
			'contact_time'         => '',
			'sub_sitename'         => '',
			'contact_address'      => '',
			'contact_link'         => '',
			'ad_content_moretag'   => '',
			'ad_content_after'     => '',
			// 'topTitle'             => '',
			// 'commonKeyWords'       => '',
			// 'gaID'                 => '',
			// 'gaType'               => 'gaType_normal',
			'enableie8Warning'     => true,
			'topEntryTitleDisplay' => '',
			'topSideBarDisplay'    => false,
			'top3PrDisplay'        => '',
			// 'infoTopCount'         => '5',
			// 'listInfoTop'          => 'listType_set',
			// 'listInfoArchive'      => 'listType_set',
			'postTopCount'         => '5',
			'postTopUrl'           => '',
			'listBlogTop'          => 'listType_set',
			'listBlogArchive'      => 'listType_set',
			'postRelatedCount'     => '6',
			'blogRss'              => '',
			'ad_conent_moretag'    => '',
			'ad_conent_after'      => '',
			'ad_related_after'     => '',
			'side_child_display'   => 'side_child_display',
			'rssLabelName'         => 'Blog entries',
			'favicon'              => '',
			'theme_layout'         => 'content-sidebar',
			'postLabelName'        => __( 'Blog', 'biz-vektor' ),
			'infoLabelName'        => __( 'Information', 'biz-vektor' ),
			'theme_style'          => 'rebuild',
			'enable_google_font'   => 'true',
			'pr1_title'            => __( 'Rich theme options', 'biz-vektor' ),
			'pr1_description'      => __( 'This area can be changed from the theme customizer as well as from the theme options section.', 'biz-vektor' ),
			'pr1_link'             => '',
			'pr1_image'            => get_template_directory_uri() . '/images/samples/pr_image_demo_1.jpg',
			'pr1_image_s'          => get_template_directory_uri() . '/images/samples/pr_image_demo_sq_1.jpg',
			'pr2_title'            => __( 'Various designs available', 'biz-vektor' ),
			'pr2_description'      => __( 'BizVektor will allow you not only to change the color of the site, but also to switch to a different design.', 'biz-vektor' ),
			'pr2_link'             => '',
			'pr2_image'            => get_template_directory_uri() . '/images/samples/pr_image_demo_2.jpg',
			'pr2_image_s'          => get_template_directory_uri() . '/images/samples/pr_image_demo_sq_2.jpg',
			'pr3_title'            => __( 'Optimized for business web sites', 'biz-vektor' ),
			'pr3_description'      => __( 'Various indispensable business features as child page templates or enquiry capture are included.', 'biz-vektor' ),
			'pr3_link'             => '',
			'pr3_image'            => get_template_directory_uri() . '/images/samples/pr_image_demo_3.jpg',
			'pr3_image_s'          => get_template_directory_uri() . '/images/samples/pr_image_demo_sq_3.jpg',
			'version'              => BizVektor_Theme_Version,
			'SNSuse'               => false,
			'slider_slidespeed'    => 5000,
			'slider_animation'     => false,
		);

	for ( $i = 1; $i <= 5; ) {
		$default_theme_options[ 'slide' . $i . 'link' ]    = '';
		$default_theme_options[ 'slide' . $i . 'image' ]   = '';
		$default_theme_options[ 'slide' . $i . 'alt' ]     = '';
		$default_theme_options[ 'slide' . $i . 'display' ] = '';
		$default_theme_options[ 'slide' . $i . 'blank' ]   = '';
		$i++;
	}
	return apply_filters( 'biz_vektor_default_options', $default_theme_options );
}


/*-------------------------------------------*/
/*	入力された値の処理
/*-------------------------------------------*/
function biz_vektor_theme_options_validate( $input ) {
	$output   = biz_bektor_option_validate();
	$defaults = biz_vektor_generate_default_options();
	if ( isset( $_POST['bizvektor_action_mode'] ) && 'reset' === $_POST['bizvektor_action_mode'] ) {
		// 設定の初期化は、確認がすべて通った場合だけ行う.
		if ( '' === biz_vektor_get_reset_error_code( $_POST ) ) {
			return $defaults;
		}
		return $output;
	}

	// Design
	$output['gMenuDivide'] = $input['gMenuDivide'];
	$output['head_logo']   = $input['head_logo'];
	$output['foot_logo']   = $input['foot_logo'];
	$output['font_title']  = $input['font_title'];
	$output['font_menu']   = $input['font_menu'];
	if ( 'ja' != get_locale() ) {
		$output['global_font'] = $input['global_font'];
	}
	$output['side_child_display'] = $input['side_child_display'];
	$output['favicon']            = ( preg_match( '/.+\.ico$/i', $input['favicon'] ) ) ? $input['favicon'] : '';
	$output['enableie8Warning']   = ( isset( $input['enableie8Warning'] ) && $input['enableie8Warning'] == 'true' ) ? true : false;

	// Contact info
	$output['contact_txt']     = $input['contact_txt'];
	$output['tel_number']      = $input['tel_number'];
	$output['contact_time']    = $input['contact_time'];
	$output['sub_sitename']    = $input['sub_sitename'];
	$output['contact_address'] = $input['contact_address'];
	$output['contact_link']    = $input['contact_link'];
	// 3PR
	$output['top3PrDisplay']   = ( isset( $input['top3PrDisplay'] ) && $input['top3PrDisplay'] == 'true' ) ? true : false;
	$output['pr1_title']       = sanitize_text_field( $input['pr1_title'] );
	$output['pr1_description'] = esc_html( $input['pr1_description'] );
	$output['pr1_link']        = esc_url( $input['pr1_link'] );
	$output['pr1_image']       = esc_url( $input['pr1_image'] );
	$output['pr1_image_s']     = esc_url( $input['pr1_image_s'] );
	$output['pr2_title']       = sanitize_text_field( $input['pr2_title'] );
	$output['pr2_description'] = esc_html( $input['pr2_description'] );
	$output['pr2_link']        = esc_url( $input['pr2_link'] );
	$output['pr2_image']       = esc_url( $input['pr2_image'] );
	$output['pr2_image_s']     = esc_url( $input['pr2_image_s'] );
	$output['pr3_title']       = sanitize_text_field( $input['pr3_title'] );
	$output['pr3_description'] = esc_html( $input['pr3_description'] );
	$output['pr3_link']        = esc_url( $input['pr3_link'] );
	$output['pr3_image']       = esc_url( $input['pr3_image'] );
	$output['pr3_image_s']     = esc_url( $input['pr3_image_s'] );
	// Infomation & Blog
	$output['postLabelName'] = ( preg_match( '/^(\s|[ 　]*)$/', $input['postLabelName'] ) ) ? $defaults['postLabelName'] : $input['postLabelName'];
	// $output['infoLabelName']          = (preg_match('/^(\s|[ 　]*)$/', $input['infoLabelName']))?	 $defaults['infoLabelName'] : $input['infoLabelName'] ;
	// $output['listInfoTop']            = $input['listInfoTop'];
	// $output['listInfoArchive']        = $input['listInfoArchive'];
	$output['listBlogTop']     = $input['listBlogTop'];
	$output['listBlogArchive'] = $input['listBlogArchive'];
	// $output['infoTopCount']           = (preg_match('/^(\s|[ 　]*)$/', $input['infoTopCount']))? 5 : $input['infoTopCount'];
	// $output['postTopUrl']         = $input['postTopUrl'];
	$output['postTopCount']       = ( preg_match( '/^(\s|[ 　]*)$/', $input['postTopCount'] ) ) ? 5 : $input['postTopCount'];
	$output['postRelatedCount']   = ( preg_match( '/^(\s|[ 　]*)$/', $input['postRelatedCount'] ) ) ? 6 : $input['postRelatedCount'];
	$output['ad_content_moretag'] = $input['ad_content_moretag'];
	$output['ad_content_after']   = $input['ad_content_after'];
	$output['ad_related_after']   = $input['ad_related_after'];
	// TopPage
	$output['topSideBarDisplay'] = ( isset( $input['topSideBarDisplay'] ) && $input['topSideBarDisplay'] == 'true' ) ? true : false;
	// SlideShow
	for ( $i = 1; $i <= 5; ) {
		$output[ 'slide' . $i . 'link' ]    = $input[ 'slide' . $i . 'link' ];
		$output[ 'slide' . $i . 'image' ]   = $input[ 'slide' . $i . 'image' ];
		$output[ 'slide' . $i . 'alt' ]     = $input[ 'slide' . $i . 'alt' ];
		$output[ 'slide' . $i . 'display' ] = ( isset( $input[ 'slide' . $i . 'display' ] ) && $input[ 'slide' . $i . 'display' ] ) ? 'true' : '';
		$output[ 'slide' . $i . 'blank' ]   = ( isset( $input[ 'slide' . $i . 'blank' ] ) && $input[ 'slide' . $i . 'blank' ] ) ? 'true' : '';
		$i++;
	}

	$output['slider_slidespeed'] = preg_replace( '/[^0-9]/', '', esc_html( $input['slider_slidespeed'] ) );
	$output['slider_animation']  = ( isset( $input['slider_animation'] ) && $input['slider_animation'] == 'slide' ) ? 'slide' : 'fade';

	if ( $input['theme_layout'] == '' ) {
		$output['theme_layout'] = 'content-sidebar'; }

	$output['theme_style'] = ( $input['theme_style'] == '' ) ? 'rebuild' : $input['theme_style'];

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], biz_vektor_layouts() ) ) {
		$output['theme_layout'] = $input['theme_layout'];
	}

	// sidebar child menu display
	if ( isset( $input['side_child_display'] ) && $input['side_child_display'] ) {
		$output['side_child_display'] = $input['side_child_display']; }

	return apply_filters( 'biz_vektor_theme_options_validate', $output, $input, $defaults );
}

/**
 * 設定の初期化リクエストを検証し、初期化できない理由を返す.
 *
 * nonce・権限・確認番号・チェックボックスをすべて確認する.
 *
 * @param array $post $_POST 相当の配列（スラッシュ付きのまま渡す）.
 * @return string 初期化してよい場合は空文字。それ以外は 'nonce' / 'capability' / 'key' / 'check'.
 */
function biz_vektor_get_reset_error_code( $post ) {
	// nonce の確認.
	$nonce = isset( $post['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $post['_wpnonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'biz_vektor_options-options' ) ) {
		return 'nonce';
	}

	// 権限の確認.
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return 'capability';
	}

	// 確認番号の一致を確認（空は不一致）.
	$reset_key      = isset( $post['bizvektor_reset_key'] ) ? sanitize_text_field( wp_unslash( $post['bizvektor_reset_key'] ) ) : '';
	$reset_key_port = isset( $post['bizvektor_reset_key_port'] ) ? sanitize_text_field( wp_unslash( $post['bizvektor_reset_key_port'] ) ) : '';
	if ( '' === $reset_key || '' === $reset_key_port || $reset_key !== $reset_key_port ) {
		return 'key';
	}

	// チェックボックスの確認.
	$reset_check = isset( $post['bizvektor_reset_check'] ) ? sanitize_text_field( wp_unslash( $post['bizvektor_reset_check'] ) ) : '';
	if ( 'True' !== $reset_check ) {
		return 'check';
	}

	return '';
}

/**
 * テーマオプション画面から送信された操作を処理する.
 *
 * 設定の初期化は検証をすべて通った場合だけ行い、通らなければ画面にエラーを出す.
 *
 * @param array $post $_POST 相当の配列（スラッシュ付きのまま渡す）.
 * @return void
 */
function biz_vektor_them_edit_function( $post ) {
	$action_mode = isset( $post['bizvektor_action_mode'] ) ? sanitize_text_field( wp_unslash( $post['bizvektor_action_mode'] ) ) : '';
	switch ( $action_mode ) {
		case 'reset':
			// 検証に通らなければ初期化せず、理由を画面に出す.
			$error_code = biz_vektor_get_reset_error_code( $post );
			if ( '' !== $error_code ) {
				$messages = array(
					'nonce'      => __( 'The security check failed. Settings were not reset. Please reload the page and try again.', 'biz-vektor' ),
					'capability' => __( 'You do not have permission to reset the settings.', 'biz-vektor' ),
					'key'        => __( 'The number you entered does not match. Settings were not reset.', 'biz-vektor' ),
					'check'      => __( 'Please check the box to confirm. Settings were not reset.', 'biz-vektor' ),
				);
				add_settings_error( 'biz_vektor_options', 'biz_vektor_reset_error', $messages[ $error_code ], 'error' );
				return;
			}
			$default_theme_options = biz_vektor_generate_default_options();
			delete_option( 'biz_vektor_theme_options' );
			add_option( 'biz_vektor_theme_options', $default_theme_options );
			biz_vektor_theme_options_init();
			break;
		default:
			break;
	}
}

/*-------------------------------------------*/
/*	テーマオプション取得
/*-------------------------------------------*/
function biz_vektor_get_theme_options() {
	global $biz_vektor_options;
	$biz_vektor_options = get_option( 'biz_vektor_theme_options', biz_vektor_generate_default_options() );
	return apply_filters( 'biz_vektor_theme_options_custom', $biz_vektor_options );
}

/*-------------------------------------------*/
/*	Print option
/*	global $biz_vektor_options に順次移行
/*-------------------------------------------*/
function bizVektorOptions( $optionLabel ) {
	$options = biz_bektor_option_validate();
	if ( isset( $options[ $optionLabel ] ) ) {
		return $options[ $optionLabel ];
	} else {
		$options_default = biz_vektor_generate_default_options();
		if ( isset( $options_default[ $optionLabel ] ) ) {
			return $options_default[ $optionLabel ];
		}

		return false;
	}
}

/*-------------------------------------------*/
/*
/*	@return array(options)
/*-------------------------------------------*/
function biz_bektor_option_validate() {

	$options = get_option( 'biz_vektor_theme_options' );
	$default = biz_vektor_generate_default_options();

	if ( $options && is_array( $options ) ) {
		$keys = array_keys( $default );
		foreach ( $keys as $key ) {
			if ( ! isset( $options[ $key ] ) && $key != 'version' ) {
				$options[ $key ] = $default[ $key ];
			}
		}
	} else {
		$options = $default;
	}
	return $options;
}
