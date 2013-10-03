<?php
/*-------------------------------------------*/
/*	title 生成
/*-------------------------------------------*/
/*	レイアウト
/*-------------------------------------------*/
/*	bodyタグにレイアウトのクラス追加
/*-------------------------------------------*/
/*	bodyタグにトップページでサイドバー非表示に設定されていた場合のクラス制御追加
/*-------------------------------------------*/
/*	テーマオプション入力画面
/*-------------------------------------------*/
/*	テーマスタイル
/*-------------------------------------------*/
/*	メニューボタンの数
/*-------------------------------------------*/
/*	ヘッダーロゴ
/*-------------------------------------------*/
/*	ヘッダー電話番号・受付時間
/*-------------------------------------------*/
/*	お問い合わせページURL出力　0.6以降不使用のはず
/*-------------------------------------------*/
/*	facebook twitter バナー出力
/*-------------------------------------------*/
/*	トップページ_blogList（RSS）
/*-------------------------------------------*/
/*	トップページ_下部フリーエリア
/*-------------------------------------------*/
/*	OGP追加
/*-------------------------------------------*/
/*	中ページ下部問い合わせエリア
/*-------------------------------------------*/
/*	snsBtns
/*-------------------------------------------*/
/*	snsBtns 表示ページ設定
/*-------------------------------------------*/
/*	facebookコメント欄表示ページ設定
/*-------------------------------------------*/
/*	facebookLikeBox
/*-------------------------------------------*/
/*	facebookアプリケーションID（faceboo関連パーツを使用する為にbody直下に書くタグに出力）
/*-------------------------------------------*/
/*	キーワード生成
/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
/*	フッター
/*-------------------------------------------*/
/*	スライドショー
/*-------------------------------------------*/
/*	optionの値を単純に引っ張る
/*-------------------------------------------*/
/*	optionの値のデフォルトの値を設定
/*-------------------------------------------*/
/*	theme_optionsページでのみ使うjsを読み込む
/*-------------------------------------------*/

function biz_vektor_theme_options_init() {
	if ( false === biz_vektor_get_theme_options() )
		add_option( 'biz_vektor_theme_options', biz_vektor_get_default_theme_options() );

	register_setting(
		'biz_vektor_options',
		'biz_vektor_theme_options',
		'biz_vektor_theme_options_validate'
	);
}
add_action( 'admin_init', 'biz_vektor_theme_options_init' );

function biz_vektor_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_biz_vektor_options', 'biz_vektor_option_page_capability' );

function biz_vektor_theme_options_add_page() {
	$theme_page = add_theme_page(
		__('Theme Options', 'biz-vektor'),   					// Name of page
		__('Theme Options', 'biz-vektor'),   					// Label in menu
		'edit_theme_options',				// Capability required
		'theme_options',					// Menu slug, used to uniquely identify the page
		'biz_vektor_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;
/* help
	$help = '<p></p>' .
			'<p></p>';
	add_contextual_help( $theme_page, $help );
*/
}
add_action( 'admin_menu', 'biz_vektor_theme_options_add_page' );


/*-------------------------------------------*/
/*	title 生成
/*-------------------------------------------*/
function getHeadTitle() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_page('home') || is_front_page()) {
		if ($options['topTitle'])	{
			$headTitle = $options['topTitle'];
		} else {
			$headTitle = get_bloginfo('name');
		}
	// Author
	} else if (is_author()) {
		$userObj = get_queried_object();
		$headTitle = esc_html($userObj->display_name)." | ".get_bloginfo('name');
	// Page
	} else if (is_page()) {
		// Sub Pages
		if ( $post->post_parent ) {
			if($post->ancestors){
				foreach($post->ancestors as $post_anc_id){
					$post_id = $post_anc_id;
				}
			} else {
				$post_id = $post->ID;
			}
			$headTitle = get_the_title()." | ".get_the_title($post_id)." | ".get_bloginfo('name');
		// Not Sub Pages
		} else {
			$headTitle = get_the_title()." | ".get_bloginfo('name');
		}
	// Info
	} else if (get_post_type() === 'info') {
		// Single
		if (is_single()) {
			$taxo_catelist = get_the_term_list_nolink( $post->ID, 'info-cat', '', ',', '' );
			if (!empty($taxo_catelist)) :
				$headTitle = get_the_title()." | ".$taxo_catelist." | ".get_bloginfo('name');
			else :
				$headTitle = get_the_title()." | ".get_bloginfo('name');
			endif;
		// Info category
		} else if (is_tax()){
			$headTitle = single_cat_title()." | ".get_bloginfo('name');
		// Info crchive
		} else if (is_archive()) {
			$headTitle = sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) );
			$headTitle .= " | ".get_bloginfo('name');
		}
	// Single
	} else if (is_single()) {
		$category = get_the_category();
		if (!empty($category)) :
			$headTitle = get_the_title()." | ".$category[0]->cat_name." | ".get_bloginfo('name');
		else :
			$headTitle = get_the_title()." | ".get_bloginfo('name');
		endif;
	// Category
	} else if (is_category()) {
		$headTitle = single_cat_title()." | ".get_bloginfo('name');
	// Tag
	} else if (is_tag()) {
		$headTitle = single_tag_title()." | ".get_bloginfo('name');
	// Archive
	} else if (is_archive()) {
		if (is_month()){
			$headTitle = sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) );
			$headTitle .= " | ".get_bloginfo('name');
		} else {
			$headTitle = single_tag_title();
		}
	// Search
	} else if (is_search()) {
		$headTitle = sprintf(__('Search Result for : %s', 'biz-vektor'),get_search_query())." | ".get_bloginfo('name');
	//Other
	} else {
		$headTitle = get_bloginfo('name');
	}
	$headTitle = apply_filters( 'titleCustom', $headTitle );
    echo $headTitle;
}
/*-------------------------------------------*/
/*	レイアウト
/*-------------------------------------------*/
function biz_vektor_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __('Right sidebar', 'biz-vektor'),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __('Left sidebar', 'biz-vektor'),
			'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
	);
	return apply_filters( 'biz_vektor_layouts', $layout_options );
}

function biz_vektor_get_default_theme_options() {
	$default_theme_options = array(
		'theme_layout' => 'content-sidebar',
	);
}

function biz_vektor_get_theme_options() {
	return get_option( 'biz_vektor_theme_options', biz_vektor_get_default_theme_options() );
}

/*-------------------------------------------*/
/*	bodyタグにレイアウトのクラス追加
/*-------------------------------------------*/

function biz_vektor_layout_classes( $existing_classes ) {
	$options = biz_vektor_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
		$classes = array( 'two-column' );

	if ( 'content-sidebar' == $current_layout )
		$classes[] = 'right-sidebar';
	elseif ( 'sidebar-content' == $current_layout )
		$classes[] = 'left-sidebar';
	else
		$classes[] = $current_layout;

	$classes = apply_filters( 'biz_vektor_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'biz_vektor_layout_classes' );

/*-------------------------------------------*/
/*	bodyタグにトップページでサイドバー非表示に設定されていた場合のクラス制御追加
/*-------------------------------------------*/
function biz_vektor_topSideBarDisplay( $existing_classes ) {	// $existing_classesは既に存在するbodyのclass
	// トップページでのみ実行
	if (is_front_page()){
		$options = biz_vektor_get_theme_options();
		if ($options['topSideBarDisplay'] ){
			$classes[] = 'one-column';
			// 既に存在するbodyの配列から指定の配列名を削除
			$existing_classes = array_diff( $existing_classes , array('right-sidebar','left-sidebar','two-column') );
			// 既に存在したclass($existing_classes)と今回追加したclass($classes)をマージ
			$existing_classes = array_merge( $existing_classes, $classes );
		}
	}
	// bodyのclassを返す
	return $existing_classes;
}
add_filter( 'biz_vektor_layout_classes', 'biz_vektor_topSideBarDisplay' );

/*-------------------------------------------*/
/*	テーマオプション入力画面
/*-------------------------------------------*/

get_template_part('inc/theme-options-edit');

/*-------------------------------------------*/
/*	テーマスタイル
/*-------------------------------------------*/

//	[1] テーマ配列読み込み
function biz_vektor_theme_styleSetting() {
	global $biz_vektor_theme_styles;
	$biz_vektor_theme_styles = array(
		'calmly' => array(
			'label' => 'Calmly',
			'cssPath' => get_template_directory_uri().'/bizvektor_themes/002/002.css',
			'cssPathOldIe' => get_template_directory_uri().'/bizvektor_themes/002/002_oldie.css',
			),
		'plain' => array(
			'label' => 'プレーン',
			'cssPath' => get_template_directory_uri().'/bizvektor_themes/plain/plain.css',
			'cssPathOldIe' => get_template_directory_uri().'/bizvektor_themes/plain/plain_oldie.css',
			),
		'default' => array(
			'label' => 'Default',
			'cssPath' => get_template_directory_uri().'/bizvektor_themes/001/001_plus.css',
			'cssPathOldIe' => get_template_directory_uri().'/bizvektor_themes/001/001_oldie.css',
			),
	);
	// [2] プラグインからフィルターフックで拡張テーマの配列情報を受け取る
	$biz_vektor_theme_styles = apply_filters( 'biz_vektor_themePlus', $biz_vektor_theme_styles );
}
/* [3]	管理画面のデザイン選択プルダウンで$biz_vektor_theme_stylesを読み込み。
		第一引数を valueとして $options[theme_style] に格納
		第一引数の配列のlavel $biz_vektor_theme_styleValues['label'] をプルダウン項目として表示。*/

// [4] ヘッダーにスタイルを書き出す
function biz_vektor_theme_style() {
	// DBに入っている配列を読み込み
	$options = biz_vektor_get_theme_options();

	// biz_vektor_theme_styles配列読み込み
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();

	$themePath = $biz_vektor_theme_styles[$options['theme_style']]['cssPath'];

	// 空の場合（テーマ選択されていない場合）デフォルトの値を設定
	if (!$themePath) {
		$themePath = get_template_directory_uri().'/bizvektor_themes/002/002.css';
	}
	// 基本スタイルのCSSを出力
	wp_enqueue_style( 'theme', $themePath , false, '2013-01-31');
}

// ▼レスポンシブに非対応なIE８以前用
function biz_vektor_theme_styleOldIe(){
	// DBに入っている配列を読み込み
	$options = biz_vektor_get_theme_options();
	// biz_vektor_theme_styles配列から旧IE用のバスを読み込んで$themePathOldIeに格納
	global $biz_vektor_theme_styles;
	biz_vektor_theme_styleSetting();
	$themePathOldIe = $biz_vektor_theme_styles[$options['theme_style']]['cssPathOldIe'];

	$themePath = $biz_vektor_theme_styles[$options['theme_style']]['cssPath'];
	$themePathOldIe = $biz_vektor_theme_styles[$options['theme_style']]['cssPathOldIe'];

	// 空の場合（テーマ選択されていない場合）デフォルトの値を設定
	if (!$themePath && !$themePathOldIe)
	$themePathOldIe = get_template_directory_uri().'/bizvektor_themes/002/002_oldie.css';
	// $themePathOldIeを意図的に空にする場合はあり得る為、空かどうかの条件分岐は必要
	if ($themePathOldIe){
		print '<!--[if lte IE 8]>'."\n";
		print '<link rel="stylesheet" type="text/css" media="all" href="'.$themePathOldIe.'" />'."\n";
		print '<![endif]-->'."\n";
	}
}

/*-------------------------------------------*/
/*	メニューボタンの数
/*-------------------------------------------*/
function biz_vektor_gMenuDivide() {
	$options = biz_vektor_get_theme_options();
	// メニューボタンが未設定の場合
	if ($options['gMenuDivide'] == __('[ Select ]', 'biz-vektor') || ! $options['gMenuDivide'] || ($options['gMenuDivide'] == 'divide_natural') ) {
	//　それ以外
	} else {
		print '<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/css/g_menu_'.$options['gMenuDivide'].'.css" />'."\n";
		print '<!--[if lte IE 8]>'."\n";
		print '<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/css/g_menu_'.$options['gMenuDivide'].'_oldie.css" />'."\n";
		print '<![endif]-->'."\n";
	}
}
/*-------------------------------------------*/
/*	ヘッダーロゴ
/*-------------------------------------------*/
function biz_vektor_print_headLogo() {
	$options = biz_vektor_get_theme_options();
	$head_logo = $options['head_logo'];
	if ($options['head_logo']) {
		print '<img src="'.$options['head_logo'].'" alt="'.get_bloginfo('name').'" />';
	} else {
		echo bloginfo('name');
	}
}
/*-------------------------------------------*/
/*	ヘッダー電話番号・受付時間
/*-------------------------------------------*/
function biz_vektor_print_headContact() {
	$options = biz_vektor_get_theme_options();
	$contact_txt = $options['contact_txt'];
	$contact_time = nl2br($options['contact_time']);
	if ($options['tel_number']) {
		// 電話番号の入力がある場合
		$headContact = '<div id="headContact" class="itemClose" onclick="showHide(\'headContact\');"><div id="headContactInner">'."\n";
			if ($contact_txt) {
				// お問い合わせメッセージの入力がある場合
				$headContact .= '<div id="headContactTxt">'.$contact_txt.'</div>'."\n";
			}
			// モバイル端末の場合
			if ( function_exists('wp_is_mobile') && wp_is_mobile() ) {
				$headContact .= '<div id="headContactTel">TEL <a href="tel:'.$options['tel_number'].'">'.$options['tel_number'].'</a></div>'."\n";
			// モバイルじゃない場合
			} else {
				$headContact .= '<div id="headContactTel">TEL '.$options['tel_number'].'</div>'."\n";
			}
			if ($contact_time) {
				// お問い合わせ時間の入力がある場合
				$headContact .= '<div id="headContactTime">'.$contact_time.'</div>'."\n";
			}
		$headContact .=	'</div></div>';
	}
	// $headContact にフィルターフックを設定
	$headContact = apply_filters( 'headContactCustom', $headContact );
	echo $headContact;
}

/*-------------------------------------------*/
/*	facebook twitter バナー出力
/*-------------------------------------------*/
function biz_vektor_snsBnrs() {
	$options = biz_vektor_get_theme_options();
	$facebook = $options['facebook'];
	$twitter = $options['twitter'];
	if ($facebook || $twitter) {
		print '<ul id="snsBnr">';
		if ($facebook) { ?>
		<li><a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bnr_facebook.png" alt="facebook" /></a></li>
		<?php }
		if ($twitter) { ?>
		<li><a href="https://twitter.com/#!/<?php echo htmlspecialchars($twitter); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bnr_twitter.png" alt="twitter" /></a></li>
		<?php }
		print '</ul>';
	}
}

/*-------------------------------------------*/
/*	トップページ_blogList（RSS）
/*-------------------------------------------*/
function biz_vektor_blogList()	{
	$options = biz_vektor_get_theme_options();
	$blogRss = $options['blogRss'];
	if ($blogRss) {
?>
	<div id="topBlog" class="infoList">
	<h2><?php echo esc_html( bizVektorOptions('rssLabelName')); ?></h2>
	<div class="rssBtn"><a href="<?php echo $blogRss ?>" id="blogRss" target="_blank">RSS</a></div>
		<?php
		$xml = simplexml_load_file($blogRss);
		$count = 0;
		echo '<ul class="entryList">';
		if ($xml->channel->item){
			// WordPress ／　ameblo
			foreach($xml->channel->item as $entry){
			// アメブロの広告対策
			$entryTitJudge = mb_substr( $entry->title, 0, 3 );	// 先頭3文字でトリム
			if (!($entryTitJudge == 'PR:')) { 					// 先頭3文字がPR:でない記事のみ表示
				 $entrydate = date ( "Y.m.d",strtotime ( $entry->pubDate ) );
				 echo '<li><span class="infoDate">'.$entrydate.'</span>';
				 echo '<span class="infoTxt"><a href="'.$entry->link.'" target="_blank">'.$entry->title.'</a></span></li>';
				 $count++;
			}
			 if ($count > 4){break;}
			}
		} else if ($xml->item){
			// RSS 1.0 (FC2)
			foreach($xml->item as $entry){
				$dc = $entry->children('http://purl.org/dc/elements/1.1/');
				$entrydate = date('Y.m.d', strtotime($dc->date));
				 echo '<li><span class="infoDate">'.$entrydate.'</span>';
				 echo '<span class="infoTxt"><a href="'.$entry->link.'" target="_blank">'.$entry->title.'</a></span></li>';
				 $count++;
			 if ($count > 4){break;}
			}
		} else {
			// ライブドア
			foreach($xml->entry as $entry){
				 $entrydate = substr(( $entry->modified ),0,10);
				 $entrydate = str_replace("-", ".", $entrydate);
				 echo '<li><span class="infoDate">'.$entrydate.'</span>';
				 echo '<span class="infoTxt"><a href="'.$entry->link->attributes()->href.'" target="_blank">'.$entry->title.'</a></span></li>';
				 $count++;
			 if ($count > 4){break;}
			}
		}
		echo "</ul>";
		?>
	</div><!-- [ /#topBlog ] -->
<?php
	}
}
/*-------------------------------------------*/
/*	トップページ_下部フリーエリア
/*-------------------------------------------*/

function biz_vektor_topContentsBottom()	{
	$options = biz_vektor_get_theme_options();
	$topContentsBottom = $options['topContentsBottom'];
	if ($topContentsBottom) {
		echo '<div id="topContentsBottom">'."\n";
		echo $topContentsBottom;
		if ( is_user_logged_in() == TRUE ) {
			echo '<div class="adminEdit edit-item">'."\n";
			echo '<span class="btn btnS btnAdmin"><a href="'.get_admin_url().'/themes.php?page=theme_options#topPage" class="btn btnS btnAdmin">';
			echo __('Edit', 'biz-vektor');
			echo '</a></span>'."\n";
			echo '</div>'."\n";
		}
		echo '</div>'."\n";
	}
}


/*-------------------------------------------*/
/*	OGP追加
/*-------------------------------------------*/
function biz_vektor_ogp () {
	$options = biz_vektor_get_theme_options();
	//$ogpImage = $options['ogpImage'];
	//$fbAppId = $options['fbAppId'];
	global $wp_query;
	$post = $wp_query->get_queried_object();
	if (is_home() || is_front_page()) {
		$linkUrl = home_url();
	} else if (is_single() || is_page()) {
		$linkUrl = get_permalink();
	} else {
		$linkUrl = get_permalink();
	}
	$bizVektorOGP = '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\n";
	$bizVektorOGP .= '<meta property="og:url" content="'.$linkUrl.'" />'."\n";
	if ($options['fbAppId']){
		$bizVektorOGP = $bizVektorOGP.'<meta property="fb:app_id" content="'.$options['fbAppId'].'" />'."\n";
	}
	// ▼ トップページ
	if (is_front_page() || is_home()) {
		$bizVektorOGP .= '<meta property="og:type" content="website" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
		$bizVektorOGP .= '<meta property="og:title" content="'.get_bloginfo('name').'" />'."\n";
		$bizVektorOGP .= '<meta property="og:description" content="'.get_bloginfo('description').'" />'."\n";
	// ▼ カテゴリー＆アーカイブ
	} else if (is_category() || is_archive()) {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
	// ▼ 固定ページ・投稿ページの場合
	} else if (is_page() || is_single()) {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		// image
		if (has_post_thumbnail()) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'large', true);
			$bizVektorOGP .= '<meta property="og:image" content="'.$image_url[0].'" />'."\n";
		} else if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
		// description
		$metaExcerpt = $post->post_excerpt;
		if ($metaExcerpt) {
			$metadescription = $post->post_excerpt;
		} else {
			$metadescription = mb_substr( strip_tags($post->post_content), 0, 240 ); // タグを無効化して240文字でトリム
			$metadescription = str_replace(array("\r\n","\r","\n"), ' ', $metadescription);  // 改行コード削除
		}
		$bizVektorOGP .= '<meta property="og:title" content="'.get_the_title().' | '.get_bloginfo('name').'" />'."\n";
		$bizVektorOGP .= '<meta property="og:description" content="'.$metadescription.'"/>'."\n";
	// 固定ページ・投稿ページ以外
	} else {
		$bizVektorOGP .= '<meta property="og:type" content="article" />'."\n";
		if ($options['ogpImage']){
			$bizVektorOGP .= '<meta property="og:image" content="'.$options['ogpImage'].'" />'."\n";
		}
	}
	// $bizVektorOGP にフィルターフックを設定
	if ( $options['ogpTagDisplay'] == 'ogp_off' ) {
		$bizVektorOGP = '';
	}
	$bizVektorOGP = apply_filters('bizVektorOGPCustom', $bizVektorOGP );
	echo $bizVektorOGP;
	//echo '<meta property="og:locale" content="ja_JP" />'."\n";
}



/*-------------------------------------------*/
/*	中ページ下部問い合わせエリア
/*-------------------------------------------*/
function biz_vektor_mainfootContact() {
	$options = biz_vektor_get_theme_options();
	$contact_txt = $options['contact_txt'];
	$contact_time = nl2br($options['contact_time']);
		if ($contact_txt) {
			print '<span class="mainFootCatch">'.$contact_txt.'</span>'."\n";
		}
	if ($options['tel_number']) {
		// モバイル端末の場合
		if ( function_exists('wp_is_mobile') && wp_is_mobile() ) {
			echo '<span class="mainFootTel">TEL <a href="tel:'.$options['tel_number'].'">'.$options['tel_number'].'</a></span>'."\n";
		// モバイルじゃない場合
		} else {
			echo '<span class="mainFootTel">TEL '.$options['tel_number'].'</span>'."\n";
		}
		if ($contact_time) {
			print '<span class="mainFootTime">'.$contact_time.'</span>'."\n";
		}
	}
}

/*-------------------------------------------*/
/*	snsBtns
/*-------------------------------------------*/
function twitterID() {
	$options = biz_vektor_get_theme_options();
	return $options['twitter'];
}
function mixiKey() {
	$options = biz_vektor_get_theme_options();
	return $options['mixiKey'];
}

/*-------------------------------------------*/
/*	snsBtns 表示ページ設定
/*-------------------------------------------*/
function biz_vektor_snsBtns() {
	$options = biz_vektor_get_theme_options();
	$snsBtnsFront = $options['snsBtnsFront'];
	$snsBtnsPage = $options['snsBtnsPage'];
	$snsBtnsPost = $options['snsBtnsPost'];
	$snsBtnsInfo = $options['snsBtnsInfo'];
	$snsBtnsHidden = $options['snsBtnsHidden'];
	global $wp_query;
	$post = $wp_query->get_queried_object();
	$snsHiddenFlag = false	;
	// $snsBtnsHidden を , で分割して $snsHiddens に配列として格納
	$snsHiddens = spliti(",",$snsBtnsHidden);
	// $snsHiddenに値を順番に入れて実行
	foreach( $snsHiddens as $snsHidden ){
		// 現在のIDと配列の数字が同じだった場合
		if (get_the_ID() == $snsHidden) {
			// $snsHiddenFlagフラグ立てる
			$snsHiddenFlag = true ;
		}
	}
	wp_reset_query();
	// フラグが立ってなかったら実行
	if (!$snsHiddenFlag) {
		if (
			( is_front_page() && $snsBtnsFront ) ||
			( is_page() && $snsBtnsPage && !is_front_page() ) || 
			( get_post_type() == 'info' && $snsBtnsInfo ) || 
			( get_post_type() == 'post' && $snsBtnsPost ) 
		) {
			get_template_part('module_snsBtns');
		}
	}
}

/*-------------------------------------------*/
/*	facebookコメント欄表示ページ設定
/*-------------------------------------------*/
function biz_vektor_fbComments() {
	$options = biz_vektor_get_theme_options();
	global $wp_query;
	$post = $wp_query->get_queried_object();
	$fbCommentHiddenFlag = false ;
	// $snsBtnsHidden を , で分割して $snsHiddens に配列として格納
	$fbCommentHiddens = spliti(",",$options['fbCommentsHidden']);
	// $snsHiddenに値を順番に入れて実行
	foreach( $fbCommentHiddens as $fbCommentHidden ){
		// 現在のIDと配列の数字が同じだった場合
		if (get_the_ID() == $fbCommentHidden) {
			// $snsHiddenFlagフラグ立てる
			$fbCommentHiddenFlag = true ;
		}
	}
	wp_reset_query();
	// フラグが立ってなかったら実行
	if (!$fbCommentHiddenFlag) {
		if (
			( is_front_page() && $options['fbCommentsFront'] ) || 
			( is_page() && $options['fbCommentsPage'] && !is_front_page() ) || 
			( get_post_type() == 'info' && $options['fbCommentsInfo'] ) || 
			( get_post_type() == 'post' && $options['fbCommentsPost'] )
			) 
		{
			?>
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="2" data-width="640"></div>
			<style>
			.fb-comments,
			.fb-comments span,
			.fb-comments iframe[style] { width:100% !important; }
			</style>
			<?php
		}
	}
}

/*-------------------------------------------*/
/*	facebookLikeBox
/*-------------------------------------------*/
function biz_vektor_fbLikeBoxFront() {
	$options = biz_vektor_get_theme_options();
	if ( $options['fbLikeBoxFront'] ) {
		biz_vektor_fbLikeBox();
	}
}
function biz_vektor_fbLikeBoxSide() {
	$options = biz_vektor_get_theme_options();
	if ( $options['fbLikeBoxSide'] ) {
		biz_vektor_fbLikeBox();
	}
}
function biz_vektor_fbLikeBox() {
	$options = biz_vektor_get_theme_options();
	$fbLikeBoxStream = $options['fbLikeBoxStream'];
	$fbLikeBoxFace = $options['fbLikeBoxFace'];
	$fbLikeBoxHeight = $options['fbLikeBoxHeight'];

	if ($fbLikeBoxStream) { $fbLikeBoxStream = 'true'; } else { $fbLikeBoxStream = 'false'; }
	if ($fbLikeBoxFace) { $fbLikeBoxFace = 'true'; } else { $fbLikeBoxFace = 'false'; }
	if ($fbLikeBoxHeight) {
		$fbLikeBoxHeight = 'data-height="'.$fbLikeBoxHeight.'" ';
	}
?>
<div id="fb-like-box">
<div class="fb-like-box" data-href="<?php echo $options['fbLikeBoxURL'] ?>" data-width="640" <?php echo $fbLikeBoxHeight ?>data-show-faces="<?php echo $fbLikeBoxFace ?>" data-stream="<?php echo $fbLikeBoxStream ?>" data-header="true"></div>
<script type="text/javascript">
jQuery(document).ready(function(){
	likeBoxReSize();
});
jQuery(window).resize(function(){
	likeBoxReSize();
});
// 読み込み時／ウィンドウリサイズ時の処理
function likeBoxReSize(){
	// 親要素の幅を取得して element に格納
	var element = jQuery('.fb-like-box').parent().width();
	// Likebox関連の要素のwidthを置換
	jQuery('.fb-like-box').attr('data-width',element);
	jQuery('.fb-like-box').children('span:first').css({"width":element});
	jQuery('.fb-like-box span iframe.fb_ltr').css({"width":element});
}
</script>
</div>
<?php }


/*-------------------------------------------*/
/*	facebookアプリケーションID（faceboo関連パーツを使用する為にbody直下に書くタグに出力）
/*-------------------------------------------*/
function biz_vektor_fbAppId () {
	$options = biz_vektor_get_theme_options();
	$fbAppId = $options['fbAppId'];
	echo $fbAppId;
}

/*-------------------------------------------*/
/*	キーワード生成
/*-------------------------------------------*/
function biz_vektor_getHeadKeywords(){
	$options = biz_vektor_get_theme_options();
	$commonKeyWords = $options['commonKeyWords'];
	// カスタムフィールドの値を取得
	$entryKeyWords = post_custom('metaKeyword');
	// 共通キーワード表示
	echo $commonKeyWords;
	// 共通キーワードと個別キーワードが両方設定されている場合接続の , を出力
	if ($commonKeyWords && $entryKeyWords) {
		echo ',';
	}
	// 個別キーワード出力
	echo $entryKeyWords;
}

/*-------------------------------------------*/
/*	GoogleAnalytics
/*-------------------------------------------*/
function biz_vektor_googleAnalytics(){
	$options = biz_vektor_get_theme_options();
	$gaID = $options['gaID'];
	$gaType = $options['gaType'];
	if ($gaID) {
		// 未選択 or 通常 or 両方 出力設定の場合
		if ((!$gaType) || ($gaType == 'gaType_normal') || ($gaType == 'gaType_both')){ ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-<?php echo $gaID ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
		<?php }
		if (($gaType == 'gaType_both') || ($gaType == 'gaType_universal')){
			$domainUrl = site_url();
			$delete = array("http://", "https://");
			$domain = str_replace($delete, "", $domainUrl); ?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-<?php echo $gaID ?>', '<?php echo $domain ?>');
ga('send', 'pageview');
</script>
<?php
		}
	}
}

/*-------------------------------------------*/
/*	フッター
/*-------------------------------------------*/

function biz_vektor_footerSiteName() 		{
	$options = biz_vektor_get_theme_options();
	// サブのサイトタイトルが登録されている場合
	if ($options['sub_sitename']) {
		$footSiteName = nl2br($options['sub_sitename']);
	} else {
		$footSiteName = get_bloginfo( 'name' );
	}
	// フッターロゴが登録されている場合
	if ($options['foot_logo']) {
		print '<img src="'.$options['foot_logo'].'" alt="'.$footSiteName.'" />';
	} else {
		echo $footSiteName;
	}
}
function biz_vektor_print_footContact() {
	$options = biz_vektor_get_theme_options();
	$contact_address = wp_kses_post(nl2br($options['contact_address']));
	if ($contact_address) {
		print $contact_address;
	}
}
function biz_vektor_footerCopyRight() 		{
	$options = biz_vektor_get_theme_options();
	$subSiteName = ($options['sub_sitename']);
	print '<div id="copy">Copyright &copy; <a href="'.home_url( '/' ).'" rel="home">';
	if ($subSiteName) {
		print $subSiteName;
	} else {
		bloginfo( 'name' );
	}
	print '</a> All Rights Reserved.</div>';

	/**************************************************************
	/* 利用規約上は表示を強制していませんが、差し支えなければなるべく消さないで下さい。
	/* ブログなどで削除方法を紹介する事はごなるべく遠慮下さい。
	/**************************************************************
	BizVektorは拡張テーマの有料販売を行なっておりますが、開発コストに対する収益としては激しく赤字です。
	フッターの著作権非表示プラグインの販売も極めて重要な開発費用です。
	ご自身で削除されるのはかまいませんが、ブログなどで紹介する事はごなるべく遠慮下さい。
	あまり赤字が激しいと会社としてBizVektor本体の無料配布を継続する事が困難になります。
	「BizVektor本体の機能を大幅に制限して、全ての機能は有料プラグインで～」
	というような形にはしたくありません。何卒ご理解とご協力の程宜しく願いいたします。	
	*/
	// id名は個別カスタマイズしてしまっている案件がある為変更不可
	$footerPowerd = '<div id="powerd">Powered by <a href="https://ja.wordpress.org/">WordPress</a> &amp; <a href="http://bizVektor.com" target="_blank" title="'.__('Free WordPress Theme BizVektor for business', 'biz-vektor').'">BizVektor Theme</a> by <a href="http://www.vektor-inc.co.jp" target="_blank" title="'.__('Vektor,Inc.', 'biz-vektor').'">Vektor,Inc.</a> technology.</div>';
	// フィルターフック設定
	// ※変数名・フィルター名は既にプラグインが販売されているので変更不可
	$footerPowerd = apply_filters( 'footerPowerdCustom', $footerPowerd );
	echo $footerPowerd;
}

/*-------------------------------------------*/
/*	スライドショー
/*-------------------------------------------*/
function biz_vektor_slideExist () {
	$options = biz_vektor_get_theme_options();
	if (
		($options['slide1image'] && (!$options['slide1display'])) ||
		($options['slide2image'] && (!$options['slide2display'])) ||
		($options['slide3image'] && (!$options['slide3display'])) ||
		($options['slide4image'] && (!$options['slide4display'])) ||
		($options['slide5image'] && (!$options['slide5display']))
	){
	return true;
	}
}

function biz_vektor_slideBody(){
	$options = biz_vektor_get_theme_options();
	for ( $i = 1; $i <= 5 ; $i++){
		if ($options['slide'.$i.'image']) {
			if (!$options['slide'.$i.'display']) {
				print '<li>';
				if ($options['slide'.$i.'link']) {
					$blank = "";
					if ($options['slide'.$i.'blank']) : $blank = ' target="_blank"'; endif;
					print '<a href="'.$options['slide'.$i.'link'].'" class="slideFrame"'.$blank.'>';
				} else	{
					print '<span class="slideFrame">';
				}
				print '<img src="'.$options['slide'.$i.'image'].'" alt="'.$options['slide'.$i.'alt'].'" />';
				if ($options['slide'.$i.'link']) {
					print '</a>';
				} else {
					print '</span>';
				}
				print '</li>'."\n";
			}
		}
	}
}

/*-------------------------------------------*/
/*	optionの値を単純に引っ張る
/*-------------------------------------------*/
function bizVektorOptions($optionLabel) {
	$options = biz_vektor_get_theme_options();
	if ($options[$optionLabel]){
		return $options[$optionLabel];
	} else {
		bizVektorOptions_default();
		global $bizVektorOptions_default;
		return $bizVektorOptions_default[$optionLabel];
	}
}
/*-------------------------------------------*/
/*	optionの値のデフォルトの値を設定
/*-------------------------------------------*/
function bizVektorOptions_default() {
	global $bizVektorOptions_default;
	$bizVektorOptions_default = array(
		'postLabelName' => 'Blog',
		'infoLabelName' => 'Information',
		'rssLabelName' => 'Blog entries',
		'postTopCount' => '5',
		'theme_style' => 'calmly',
	);
}

/*-------------------------------------------*/
/*	theme_optionsページでのみ使うjsを読み込む
/*-------------------------------------------*/
add_action('admin_print_scripts-appearance_page_theme_options', 'admin_theme_options_plugins');
function admin_theme_options_plugins( $hook_suffix ) {
	wp_enqueue_media();
	wp_register_script( 'biz_vektor-theme-options', get_template_directory_uri().'/inc/theme-options.js', array('jquery'), '20120902' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'biz_vektor-theme-options' );
}

/*-------------------------------------------*/
/*	フォント切り替え
/*-------------------------------------------*/
add_action( 'wp_head','biz_vektor_fontStyle');
function biz_vektor_fontStyle(){
	$options = biz_vektor_get_theme_options();
	$font_face_serif = _x('serif', 'Font select', 'biz-vektor');
	$font_face_serif 		= apply_filters( 'font_face_serif_custom', $font_face_serif );
	$font_face_sans_serif = _x('Meiryo,Osaka,sans-serif', 'Font select', 'biz-vektor');
	$font_face_sans_serif 	= apply_filters( 'font_face_sans_serif_custom', $font_face_sans_serif );
	if ($options['font_title'] == 'serif') {
		$font_title_face = $font_face_serif ;
		$font_title_weight = 'bold';
	} else {
		$font_title_face = $font_face_sans_serif;
		$font_title_weight = 'lighter';
	}
	if ($options['font_menu'] == 'serif') {
		$font_menu_face = $font_face_serif ;
	} else {
		$font_menu_face = $font_face_sans_serif;
	}
?>
	<style type="text/css">
	/*-------------------------------------------*/
	/*	font
	/*-------------------------------------------*/
	h1,h2,h3,h4,h4,h5,h6,
	#header #site-title,
	#pageTitBnr #pageTitInner #pageTit,
	#content .leadTxt,
	#sideTower .localHead {font-family: <?php echo $font_title_face ?> ; }
	#pageTitBnr #pageTitInner #pageTit { font-weight:<?php echo $font_title_weight ?>; }
	#gMenu .menu li a strong {font-family: <?php echo $font_menu_face ?> ; }
	</style>
	<?php
}
/*-------------------------------------------*/
/*	サイドバーメニュー非表示
/*-------------------------------------------*/
add_action( 'wp_head','biz_vektor_sideChildDisplay');
function biz_vektor_sideChildDisplay(){
	$options = biz_vektor_get_theme_options();
	if ( $options['side_child_display'] == 'side_child_hidden' ) { ?>
	<style type="text/css">
	/*-------------------------------------------*/
	/*	sidebar child menu display
	/*-------------------------------------------*/
#sideTower	ul.localNavi ul.children	{ display:none; }
#sideTower	ul.localNavi li.current_page_ancestor	ul.children,
#sideTower	ul.localNavi li.current_page_item		ul.children	{ display:block; }
	</style>
	<?php
	}
}


/*	admin_head JavaScriptのデバッグコンソールにhook_suffixの値を出力
/*-------------------------------------------*/
/*
add_action("admin_head", 'suffix2console');
function suffix2console() {
    global $hook_suffix;
    if (is_user_logged_in()) {
        $str = "<script type=\"text/javascript\">console.log('%s')</script>";
        printf($str, $hook_suffix);
    }
}
*/