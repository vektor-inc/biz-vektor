<?php

/*-------------------------------------------*/
/*	Theme Option の初期設定
/*-------------------------------------------*/
/*	Theme Option Default
/*-------------------------------------------*/
/*	Set option default
/*-------------------------------------------*/
/*	入力された値の処理
/*-------------------------------------------*/
/*	出力する
/*-------------------------------------------*/
/*	Print option
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Theme Option の初期設定
/*-------------------------------------------*/
function biz_vektor_theme_options_init() {
	// biz_vektor_theme_options が存在しなかったら作る
	if ( false === get_option('biz_vektor_theme_options') ){
		add_option( 'biz_vektor_theme_options', biz_vektor_generate_default_options() );
	}
	global $biz_vektor_options;
	$biz_vektor_options = get_option('biz_vektor_theme_options' );
}
add_action( 'after_setup_theme', 'biz_vektor_theme_options_init' );

/*-------------------------------------------*/
/*	送信した値をデータベースに登録したり、サニタイズする
/*-------------------------------------------*/
function biz_vektor_option_register(){
	register_setting(
		'biz_vektor_options',					// 設定のグループ名。ここで指定した名前をsettings_fields関数の引数に指定します。
		'biz_vektor_theme_options',				// 登録するオプションの名前。input要素などのname属性を指定します。
		'biz_vektor_theme_options_validate'		// オプションの値をサニタイズするためのコールバック関数。
	);
}
add_action('admin_init', 'biz_vektor_option_register');


/*-------------------------------------------*/
/*	値が空だった場合の初期値だけどもう不要なんじゃね？
/*-------------------------------------------*/
// function biz_vektor_get_default_theme_options() {
// 	$default_theme_options = array(
// 		'theme_layout' => 'content-sidebar',
// 		'postLabelName' => 'Blog',
// 		'infoLabelName' => 'Information',
// 		// 'rssLabelName' => 'Blog entries',
// 		'theme_style' => 'default',
// 		'pr1_title' => __('Rich theme options', 'biz-vektor'),
// 		'pr1_description' => __('This area can be changed from the theme customizer as well as from the theme options section.', 'biz-vektor'),
// 		'pr2_title' => __('Various designs available', 'biz-vektor'),
// 		'pr2_description' => __('BizVektor will allow you not only to change the color of the site, but also to switch to a different design.', 'biz-vektor'),
// 		'pr3_title' => __('Optimized for business web sites', 'biz-vektor'),
// 		'pr3_description' => __('Various indispensable business features as child page templates or enquiry capture are included.', 'biz-vektor'),
// 	);
// //	return apply_filters( 'biz_vektor_default_options', $default_theme_options );
// 	return apply_filters( 'biz_vektor_default_options', biz_vektor_generate_default_options() );
// }

/*-------------------------------------------*/
/*	Theme Option Default
/*-------------------------------------------*/

function biz_vektor_generate_default_options(){
		$default_theme_options = array(
		'font_title' => 'sanserif',
		'font_menu' => 'sanserif',
		'gMenuDivide' => '',
		'head_logo' => '',
		'foot_logo' => '',
		'contact_txt' => '',
		'tel_number' => '',
		'contact_time' => '',
		'sub_sitename' => '',
		'contact_address' => '',
		'contact_link' => '',
		'topTitle' => '',
		'commonKeyWords' => '',
		'gaID' => '',
		'gaType' => 'gaType_normal',
		'topEntryTitleDisplay' => '',
		'topSideBarDisplay' => false,
		'top3PrDisplay' => '',
		'postTopCount' => '0',
		'infoTopCount' => '0',
		'postTopUrl' => '',
		'infoTopUrl' => '',
		'listInfoTop' => 'listType_set',
		'listInfoArchive' => 'listType_set',
		'listBlogTop' => 'listType_set',
		'listBlogArchive' => 'listType_set',
		'blogRss' => '',
		'twitter' => '',
		'facebook' => '',
		'fbAppId' => '',
		'fbAdminId' => '',
		'ogpImage' => '',
		'ogpTagDisplay' => '',
		'snsBtnsFront' => '',
		'snsBtnsPage' => '',
		'snsBtnsPost' => '',
		'snsBtnsInfo' => '',
		'snsBtnsHidden' => '',
		'fbCommentsFront' => '',
		'fbCommentsPage' => '',
		'fbCommentsPost' => '',
		'fbCommentsInfo' => '',
		'fbCommentsHidden' => '',
		'fbLikeBoxFront' => '',
		'fbLikeBoxSide' => '',
		'fbLikeBoxURL' => '',
		'fbLikeBoxStream' => '',
		'fbLikeBoxFace' => '',
		'fbLikeBoxHeight' => '',
		'side_child_display' => 'side_child_display',
		'rssLabelName' => 'Blog entries',
		'favicon' => '',
		'theme_layout' => 'content-sidebar',
		'postLabelName' => 'Blog',
		'infoLabelName' => 'Information',
		'theme_style' => 'rebuild',
		'pr1_title' => __('Rich theme options', 'biz-vektor'),
		'pr1_description' => __('This area can be changed from the theme customizer as well as from the theme options section.', 'biz-vektor'),
		'pr1_link' => '',
		'pr1_image' => '',
		'pr1_image_s' => '',
		'pr2_title' => __('Various designs available', 'biz-vektor'),
		'pr2_description' => __('BizVektor will allow you not only to change the color of the site, but also to switch to a different design.', 'biz-vektor'),
		'pr2_link' => '',
		'pr2_image' => '',
		'pr2_image_s' => '',
		'pr3_title' => __('Optimized for business web sites', 'biz-vektor'),
		'pr3_description' => __('Various indispensable business features as child page templates or enquiry capture are included.', 'biz-vektor'),
		'pr3_link' => '',
		'pr3_image' => '',
		'pr3_image_s' => '',
		'version' => BizVektor_Theme_Version,
		'SNSuse' => false
	);

	for ( $i = 1; $i <= 5 ;){
		$default_theme_options['slide'.$i.'link'] = '';
		$default_theme_options['slide'.$i.'image'] = '';
		$default_theme_options['slide'.$i.'alt'] = '';
		$default_theme_options['slide'.$i.'display'] = '';
		$default_theme_options['slide'.$i.'blank'] = '';
	$i++;
	}
	return apply_filters( 'biz_vektor_default_options', $default_theme_options );
}

/*-------------------------------------------*/
/*	Set option default
/*	$opstions_default = biz_vektor_generate_default_options(); に移行して順次廃止	// 1.0.0
/*-------------------------------------------*/
// function bizVektorOptions_default() {
// 	global $bizVektorOptions_default;
// 	$bizVektorOptions_default = array(
// 		'theme_layout' => 'content-sidebar',
// 		'postLabelName' => 'Blog',
// 		'infoLabelName' => 'Information',
// 		// 'rssLabelName' => 'Blog entries',
// 		'theme_style' => 'default',
// 		'pr1_title' => __('Rich theme options', 'biz-vektor'),
// 		'pr1_description' => __('This area can be changed from the theme customizer as well as from the theme options section.', 'biz-vektor'),
// 		'pr1_link' => '',
// 		'pr1_image' => '',
// 		'pr1_image_s' => '',
// 		'pr2_title' => __('Various designs available', 'biz-vektor'),
// 		'pr2_description' => __('BizVektor will allow you not only to change the color of the site, but also to switch to a different design.', 'biz-vektor'),
// 		'pr2_link' => '',
// 		'pr2_image' => '',
// 		'pr2_image_s' => '',
// 		'pr3_title' => __('Optimized for business web sites', 'biz-vektor'),
// 		'pr3_description' => __('Various indispensable business features as child page templates or enquiry capture are included.', 'biz-vektor'),
// 		'pr3_link' => '',
// 		'pr3_image' => '',
// 		'pr3_image_s' => '',
// 	);
// }

// テーマオプションを読み込み、デフォルト値に上書きして返す。Noticeが出た時の一時的な使用用。現状で使用箇所なし 
// function biz_vektor_veryfi_option(){
// 	$options = get_option( 'biz_vektor_theme_options', biz_vektor_generate_default_options() );
// 	$default_theme_options = biz_vektor_generate_default_options();

// 	$keylist = array_keys($options);
// 	foreach($keylist as $key){
// 		$default_theme_options[$key] = $options[$key];
// 	}
// 	return $default_theme_options;
// }

	/*-------------------------------------------*/
	/*	Updator
	/*-------------------------------------------*/

class biz_vektor_veryfi_tool{
	var $version;

	public function __construct(){
		$this->check_version();
	}

	public function update(){
		switch (BizVektor_Theme_Version) {
			case '1.0.0':
				if($this->version == '0.11.5.2'){
					$this->rebuild_option_0_11_5_2();
				}
				break;
			default:
				break;
		}
	}

	public function check_version(){
		// テーマバージョンの確認
		$options = get_option('biz_vektor_theme_options');
		if(isset($options['version'])){
			$this->version = $options['version'];
		}else{
			$this->version = '0.11.5.2';
		}
	}

	public function rebuild_option_0_11_5_2(){
		$options = get_option('biz_vektor_theme_options');
		$default = biz_vektor_generate_default_options();
		$keylist = array_keys($options);
		foreach($keylist as $key){
			if(isset($options[$key]) && preg_match('/(\s|[ 　]*)/', $options[$key])) { $default[$key] = $options[$key]; }
		}
		delete_option('biz_vektor_theme_options');
		add_option('biz_vektor_theme_options', $default);
		biz_vektor_option_register();
	}
}

/*-------------------------------------------*/
/*	入力された値の処理
/*-------------------------------------------*/
function biz_vektor_theme_options_validate( $input ) {
	$output = $defaults = biz_vektor_generate_default_options();
	if(isset($_POST['bizvektor_action_mode']) && $_POST['bizvektor_action_mode'] == 'reset'){ return $defaults; }

	// Design
	$output['gMenuDivide']					 = $input['gMenuDivide'];
	$output['head_logo']				 = $input['head_logo'];
	$output['foot_logo']				 = $input['foot_logo'];
	$output['font_title']				 = $input['font_title'];
	$output['font_menu']				 = $input['font_menu'];
	$output['side_child_display']		 = $input['side_child_display'];
	$output['favicon']					 = (preg_match("/.+\.ico$/i", $input['favicon']))? $input['favicon'] : '';

	// Contact info
	$output['contact_txt']				 = $input['contact_txt'];
	$output['tel_number']				 = $input['tel_number'];
	$output['contact_time']				 = $input['contact_time'];
	$output['sub_sitename']				 = $input['sub_sitename'];
	$output['contact_address']			 = $input['contact_address'];
	$output['contact_link']				 = $input['contact_link'];
	// 3PR
	$output['top3PrDisplay']			 = (isset($input['top3PrDisplay']) && $input['top3PrDisplay'] == 'true')?	 true : false;
	$output['pr1_title']				 = ($input['pr1_title'] == '')?			 $defaults['pr1_title'] : $input['pr1_title'] ;
	$output['pr1_description']			 = ($input['pr1_description'] == '')?	 $defaults['pr1_description'] : $input['pr1_description'] ;
	$output['pr1_link']					 = $input['pr1_link'];
	$output['pr1_image']				 = $input['pr1_image'];
	$output['pr1_image_s']				 = $input['pr1_image_s'];
	$output['pr2_title']				 = ($input['pr2_title'] == '')?			 $defaults['pr2_title'] : $input['pr2_title'] ;
	$output['pr2_description']			 = ($input['pr2_description'] == '')?	 $defaults['pr2_description'] : $input['pr2_description'] ;
	$output['pr2_link']					 = $input['pr2_link'];
	$output['pr2_image']				 = $input['pr2_image'];
	$output['pr2_image_s']				 = $input['pr2_image_s'];
	$output['pr3_title']				 = ($input['pr3_title'] == '')?			 $defaults['pr3_title'] : $input['pr3_title'] ;
	$output['pr3_description']			 = ($input['pr3_description'] == '')?	 $defaults['pr3_description'] : $input['pr3_description'] ;
	$output['pr3_link']					 = $input['pr3_link'];
	$output['pr3_image']				 = $input['pr3_image'];
	$output['pr3_image_s']				 = $input['pr3_image_s'];
	// Infomation & Blog	
	$output['postLabelName']			 = (preg_match('/^(\s|[ 　]*)$/', $input['postLabelName']))?	 $defaults['postLabelName'] : $input['postLabelName'] ;
	$output['infoLabelName']			 = (preg_match('/^(\s|[ 　]*)$/', $input['infoLabelName']))?	 $defaults['infoLabelName'] : $input['infoLabelName'] ;
	$output['listInfoTop']				 = $input['listInfoTop'];
	$output['listInfoArchive']			 = $input['listInfoArchive'];
	$output['listBlogTop']				 = $input['listBlogTop'];
	$output['listBlogArchive']			 = $input['listBlogArchive'];
	$output['infoTopCount']				 = (preg_match('/^(\s|[ 　]*)$/', $input['infoTopCount']))? 0 : $input['infoTopCount'];
	$output['postTopUrl']				 = $input['postTopUrl'];
	$output['postTopCount']				 = (preg_match('/^(\s|[ 　]*)$/', $input['postTopCount']))? 0 : $input['postTopCount'];
	// SEO 
	$output['topTitle']					 = $input['topTitle'];
	$output['commonKeyWords']			 = $input['commonKeyWords'];
	$output['gaID']						 = preg_replace('/^[ 　]*(.*)$/', "$1", $input['gaID']);
	$output['gaType']					 = $input['gaType'];
	// TopPage
//	$output['topEntryTitleDisplay']		 = $input['topEntryTitleDisplay'];
	$output['topSideBarDisplay']		 = (isset($input['topSideBarDisplay']) && $input['topSideBarDisplay'] == 'true')? true : false;
//	$output['infoTopUrl'] = $input['infoTopUrl'];
	// SlideShow
	for ( $i = 1; $i <= 5 ;){
		$output['slide'.$i.'link']			 = $input['slide'.$i.'link'];
		$output['slide'.$i.'image']			 = $input['slide'.$i.'image'];
		$output['slide'.$i.'alt']			 = $input['slide'.$i.'alt'];
		$output['slide'.$i.'display']		 = (isset($input['slide'.$i.'display']) && $input['slide'.$i.'display'])? "true" : '';
		$output['slide'.$i.'blank']			 = (isset($input['slide'.$i.'blank']) && $input['slide'.$i.'blank'])? "true" : '';
	$i++;
	}
	// SNS
	$output['fbAppId']                = $input['fbAppId'];
	$output['fbAdminId']              = $input['fbAdminId'];
//	$output['blogRss'] = $input['blogRss'];
	$output['twitter']                = $input['twitter'];
	$output['facebook']               = $input['facebook'];
	$output['ogpImage']               = $input['ogpImage'];
	$output['snsBtnsFront']           = (isset($input['snsBtnsFront']) && $input['snsBtnsFront'] == 'false')? 'false' : '';
	$output['snsBtnsPage']            = (isset($input['snsBtnsPage']) && $input['snsBtnsPage'] == 'false')? 'false' : '';
	$output['snsBtnsPost']            = (isset($input['snsBtnsPost']) && $input['snsBtnsPost'] == 'false')? 'false' : '';
	$output['snsBtnsInfo']            = (isset($input['snsBtnsInfo']) && $input['snsBtnsInfo'] == 'false')? 'false' : '';
	$output['snsBtnsHidden']          = $input['snsBtnsHidden'];
	$output['fbCommentsFront']        = (isset($input['fbCommentsFront']) && $input['fbCommentsFront'] == 'false')? 'false' : '';
	$output['fbCommentsPage']         = (isset($input['fbCommentsPage']) && $input['fbCommentsPage'] == 'false')? 'false' : '';
	$output['fbCommentsPost']         = (isset($input['fbCommentsPost']) && $input['fbCommentsPost'] == 'false')? 'false' : '';
	$output['fbCommentsInfo']         = (isset($input['fbCommentsInfo']) && $input['fbCommentsInfo'] == 'false')? 'false' : '';
//	$output['fbCommentsHidden'] = $input['fbCommentsHidden'];
	$output['fbLikeBoxFront']         = (isset($input['fbLikeBoxFront']) && $input['fbLikeBoxFront'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxSide']          = (isset($input['fbLikeBoxSide']) && $input['fbLikeBoxSide'] == 'false')? 'false ': '' ;
	$output['fbLikeBoxURL']	          = $input['fbLikeBoxURL'];
	$output['fbLikeBoxStream']        = (isset($input['fbLikeBoxStream']) && $input['fbLikeBoxStream'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxFace']          = (isset($input['fbLikeBoxFace']) && $input['fbLikeBoxFace'] == 'false')? 'false' : '' ;
	$output['fbLikeBoxHeight']        = $input['fbLikeBoxHeight'];
	$output['ogpTagDisplay']          = $input['ogpTagDisplay'];

	if($input['theme_layout'] == ''){ $output['theme_layout'] = "content-sidebar"; }
//	if($input['rssLabelName'] == ''){ $output['rssLabelName'] = "Blog entries"; }

	$output['theme_style'] = ($input['theme_style'] == '') ? "rebuild" : $input['theme_style'] ;

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], biz_vektor_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	// sidebar child menu display
	if( isset($input['side_child_display']) && $input['side_child_display'] ){ $output['side_child_display'] = $input['side_child_display']; }

	//$output = $defaults;
	return apply_filters( 'biz_vektor_theme_options_validate', $output, $input, $defaults );
}

function biz_vektor_them_edit_function($post){
	switch ($post['bizvektor_action_mode']) {
		case 'reset':
			$default_theme_options = biz_vektor_generate_default_options();
			delete_option('biz_vektor_theme_options');
			add_option('biz_vektor_theme_options', $default_theme_options);
			biz_vektor_theme_options_init();
			break;
		default:
			break;
	}
}

/*-------------------------------------------*/
/*	出力する
/*-------------------------------------------*/
function biz_vektor_get_theme_options() {
	global $biz_vektor_options;
	// global 変数が上手く取得出来てない場合はDBから持ってくる。
	// if (!isset($biz_vektor_options)) 
	// やはりDBから持ってこないとカスタマイザーが効かない。
		$biz_vektor_options = get_option('biz_vektor_theme_options' );
	return $biz_vektor_options;
}

/*-------------------------------------------*/
/*	Print option
/*	global $biz_vektor_options に順次移行
/*-------------------------------------------*/
function bizVektorOptions($optionLabel) {
	$options = biz_vektor_get_theme_options();
	if ( isset($options[$optionLabel]) && $options[$optionLabel] ) {
		return $options[$optionLabel];
	} else {
		$options_default = biz_vektor_generate_default_options();
		if (isset($options_default[$optionLabel]))
		return $options_default[$optionLabel];
	}
}