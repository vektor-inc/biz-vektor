<?php
/*-------------------------------------------*/
/*	Set content width
/* 	(Auto set up to media max with.)
/*-------------------------------------------*/
/*	カスタムメニュー
/*-------------------------------------------*/
/*	ウィジェット
/*-------------------------------------------*/
/*	カスタムヘッダー
/*-------------------------------------------*/
/*	カスタム背景
/*-------------------------------------------*/
/*	テーマオプションを読み込む
/*-------------------------------------------*/
/*	Calmly用セッティングを読み込む
/*-------------------------------------------*/
/*	テーマカスタマイザーセッティング
/*-------------------------------------------*/
/*	管理画面_スタイルを追加
/*-------------------------------------------*/
/*	管理画面_投稿ステータスをbodyのclassに追加
/*-------------------------------------------*/
/*	管理画面_ビジュアルエディタでのcss指定
/*-------------------------------------------*/
/*	管理画面_オリジナル管理バーを追加
/*-------------------------------------------*/
/*	管理画面_ダッシュボードから余分な項目を削除
/*-------------------------------------------*/
/*	管理画面_アイキャッチが使えるように
/*-------------------------------------------*/
/*	管理画面_keywordのカスタムフィールドを追加
/*-------------------------------------------*/
/*	管理画面_固定ページのカスタマイズ
/*-------------------------------------------*/
/*	管理画面_投稿のカスタマイズ
/*-------------------------------------------*/
/*	カスタム投稿タイプ_お知らせの追加
/*-------------------------------------------*/
/*	head_description 生成
/*-------------------------------------------*/
/*	head_wp_head が吐き出す項目を追加・削除
/*-------------------------------------------*/
/*	カスタム分類名をaタグ無しで出力する
/*-------------------------------------------*/
/*	ナビゲーションメニューの英語併記
/*-------------------------------------------*/
/*	抜粋の後につく [...] を変換
/*-------------------------------------------*/
/*	抜粋のpタグ自動挿入解除
/*-------------------------------------------*/
/*	年別アーカイブリストの“年”を</a>の中に置換
/*-------------------------------------------*/
/*	カテゴリー件数を</a>の中に置換
/*-------------------------------------------*/
/*	TinyMCEでiframeタグ（GoogleMapなど）の自動消去禁止指定
/*-------------------------------------------*/
/*	画像挿入時のwidthとheight指定削除
/*	（スマホ表示の際に画像サイズ自動調整がうまくいかない為）
/*-------------------------------------------*/
/*	Comment
/*-------------------------------------------*/
/*	Archive page link ( don't erase )
/*-------------------------------------------*/
/*	ページング
/*-------------------------------------------*/
/*	Comment out short code
/*-------------------------------------------*/


load_theme_textdomain('biz-vektor');
// ▼管理バー非表示
// ▼メニューに「すべての設定」項目を加える

add_theme_support( 'automatic-feed-links' );

/*-------------------------------------------*/
/*	Set content width
/* 	(Auto set up to media max with.)
/*-------------------------------------------*/
if ( ! isset( $content_width ) )
    $content_width = 640;

/*-------------------------------------------*/
/*	カスタムメニュー
/*-------------------------------------------*/
register_nav_menus( array( 'Header' => 'Header Navigation', ) );
register_nav_menus( array( 'FooterNavi' => 'Footer Navigation', ) );
register_nav_menus( array( 'FooterSiteMap' => 'Footer SiteMap', ) );

/*-------------------------------------------*/
/*	ウィジェット
/*-------------------------------------------*/
function biz_vektor_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar(Front page only)', 'biz-vektor' ),
		'id' => 'top-side-widget-area',
		'description' => __( 'This widget area display front page only.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Post content only)', 'biz-vektor' ),
		'id' => 'blog-first-widget-area',
		'description' => __( 'This widget area display post content only.It is displayed on the Contact banner.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(All pages upper part)', 'biz-vektor' ),
		'id' => 'primary-widget-area',
		'description' => __( 'This widget area display all pages upper part.It is displayed on the facebook & twitter banner.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(All pages under part)', 'biz-vektor' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'This widget area display all pages upper part.It is displayed under the facebook & twitter banner.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );


}
add_action( 'widgets_init', 'biz_vektor_widgets_init' );


/*-------------------------------------------*/
/*	カスタムヘッダー
/*-------------------------------------------*/

// カスタムヘッダーのテキスト機能を利用する場合
define( 'HEADER_TEXTCOLOR', '' );
// カスタムヘッダーのテキスト機能をオフにする
define( 'NO_HEADER_TEXT', true );

define('HEADER_IMAGE', '%s/images/headers/bussines_desk_02.jpg');
define('HEADER_IMAGE_WIDTH', 950);
define('HEADER_IMAGE_HEIGHT', 250);
register_default_headers( array(
	'bussines_desk_02' => array(
		'url' => '%s/images/headers/bussines_desk_02.jpg',
		'thumbnail_url' => '%s/images/headers/bussines_desk_02-thumbnail.jpg',
		'description' => 'Bussines desk01'
	),
	'bussines_desk_01' => array(
		'url' => '%s/images/headers/bussines_desk_01.jpg',
		'thumbnail_url' => '%s/images/headers/bussines_desk_01-thumbnail.jpg',
		'description' => 'Bussines desk01'
	),
	'autumn-leaves' => array(
		'url' => '%s/images/headers/autumn-leaves.jpg',
		'thumbnail_url' => '%s/images/headers/autumn-leaves-thumbnail.jpg',
		'description' => 'autumn-leaves'
	),
	'johnny_01' => array(
		'url' => '%s/images/headers/johnny_01.jpg',
		'thumbnail_url' => '%s/images/headers/johnny_01-thumbnail.jpg',
		'description' => 'Johnny'
	),
) );
add_custom_image_header('admin_header_style', '');
if ( ! function_exists( 'admin_header_style' ) ) ://wp_headで<head>にCSSを追加。無いとエラーが出るので削除不可
function admin_header_style() { }
endif;

/*-------------------------------------------*/
/*	カスタム背景
/*-------------------------------------------*/

function biz_vektor_setup(){
	add_theme_support( 'custom-background', array(
		'default-color' => 'f5f5f5',
	) );
}
add_action( 'after_setup_theme', 'biz_vektor_setup' );


/*-------------------------------------------*/
/*	テーマオプションを読み込む
/*-------------------------------------------*/
	require( dirname( __FILE__ ) . '/inc/theme-options.php' );

/*-------------------------------------------*/
/*	Calmly用セッティングを読み込む
/*-------------------------------------------*/
	require( dirname( __FILE__ ) . '/bizvektor_themes/002/002_custom.php' );

/*-------------------------------------------*/
/*	テーマカスタマイザーセッティング
/*-------------------------------------------*/
	require( dirname( __FILE__ ) . '/inc/theme-customizer.php' );

/*-------------------------------------------*/
/*	管理画面_スタイルを追加
/*-------------------------------------------*/
function bizVektor_admin_css(){
	// echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/style_BizVektor_admin.css" />';
	$adminCssPath = get_template_directory_uri().'/style_BizVektor_admin.css';
	wp_enqueue_style( 'theme', $adminCssPath , false, '2012-06-24');
}
add_action('admin_head', 'bizVektor_admin_css', 11);

/*-------------------------------------------*/
/*	管理画面_投稿ステータスをbodyのclassに追加
/*-------------------------------------------*/
function bizVektor_postStatus(){
		$classes = get_post_status() // 投稿の状態を取得; ?>
		<script type="text/javascript" charset="utf-8">
		function postStatusColor(){
			// 現状のクラス名を取得して投稿ステータスを足す
			var newClass = document.getElementsByTagName("body")[0].className + " <?php echo $classes ?>";
			// 現状のクラス名を置き換える
			document.getElementsByTagName("body")[0].setAttribute("class",newClass);
		}
		window.onload = postStatusColor;
		</script>
<?php
}
add_action('admin_head-post.php', 'bizVektor_postStatus', 12);
add_action('admin_head-post-new.php', 'bizVektor_postStatus', 12);

/*-------------------------------------------*/
/*	管理画面_ビジュアルエディタでのcss指定
/*-------------------------------------------*/
add_editor_style('editor-style.css');

/*-------------------------------------------*/
/*	管理画面_オリジナル管理バーを追加
/*-------------------------------------------*/
function original_header_menu_output() {
	get_template_part('module_adminHeader');
}
add_action('admin_notices','original_header_menu_output');


/*-------------------------------------------*/
/*	管理画面_ダッシュボードから余分な項目を削除
/*-------------------------------------------*/
// function remove_dashboard_widgets() {
//   global $wp_meta_boxes;
// //  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);	
// //被リンク
// //  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);		//現在の状況
// //  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);			//プラグイン
// //	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);	//最近のコメント
// //  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);		//クイック投稿
// //  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);		//最近の下書き
// //  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);			//WordPress開発ブログ
// //  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);			//WordPressフォーラム
// }
// add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/*		「ようこそ」をとりあえず削除（完全に機能停止ではなくチェックすれば再表示可能になってしまう）
/*-------------------------------------------*/
function hide_welcome_panel() {
	$user_id = get_current_user_id();
		if ( 1 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
	update_user_meta( $user_id, 'show_welcome_panel', 0 );
}
add_action( 'load-index.php', 'hide_welcome_panel' );

/*-------------------------------------------*/
/*	管理画面_アイキャッチが使えるように
/*-------------------------------------------*/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 200, 200, true );

/*-------------------------------------------*/
/*	管理画面_keywordのカスタムフィールドを追加
/*-------------------------------------------*/
add_action('admin_menu', 'add_custom_field_metaKeyword');
add_action('save_post', 'save_custom_field_metaKeyword');

function add_custom_field_metaKeyword(){
  if(function_exists('add_custom_field_metaKeyword')){
    add_meta_box('div1', 'キーワード', 'insert_custom_field_metaKeyword', 'page', 'normal', 'high');
    add_meta_box('div1', 'キーワード', 'insert_custom_field_metaKeyword', 'post', 'normal', 'high');
    add_meta_box('div1', 'キーワード', 'insert_custom_field_metaKeyword', 'info', 'normal', 'high');
  }
}

function insert_custom_field_metaKeyword(){
  global $post;
  echo '<input type="hidden" name="noncename_custom_field_metaKeyword" id="noncename_custom_field_metaKeyword" value="'.wp_create_nonce(plugin_basename(__FILE__)).'" />';
  echo '<label class="hidden" for="metaKeyword">キーワード</label><input type="text" name="metaKeyword" size="50" value="'.get_post_meta($post->ID, 'metaKeyword', true).'" />';
  echo '<p>このページで個別に設定するキーワードを , 区切りで入力して下さい（任意）<br />';
  echo '※サイト全体に共通して設定するキーワードは<a href="'.get_admin_url().'/themes.php?page=theme_options#seoSetting" target="_blank">テーマオプション</a>から設定出来ます。</p>';
}

function save_custom_field_metaKeyword($post_id){
  if(!wp_verify_nonce($_POST['noncename_custom_field_metaKeyword'], plugin_basename(__FILE__))){
    return $post_id;
  }
  if('page' == $_POST['post_type']){
    if(!current_user_can('edit_page', $post_id)) return $post_id;
  }else{
    if(!current_user_can('edit_post', $post_id)) return $post_id;
  }

  $data = $_POST['metaKeyword'];

  if(get_post_meta($post_id, 'metaKeyword') == ""){
    add_post_meta($post_id, 'metaKeyword', $data, true);
  }elseif($data != get_post_meta($post_id, 'metaKeyword', true)){
    update_post_meta($post_id, 'metaKeyword', $data);
  }elseif($data == ""){
    delete_post_meta($post_id, 'metaKeyword', get_post_meta($post_id, 'metaKeyword', true));
  }
}

/*-------------------------------------------*/
/*	管理画面_固定ページのカスタマイズ
/*-------------------------------------------*/
add_post_type_support( 'page', 'excerpt' ); // 抜粋欄を追加

function remove_default_page_screen_metaboxes() {
//	remove_meta_box( 'postcustom','page','normal' );		// カスタムフィールド
//	remove_meta_box( 'postexcerpt','page','normal' );		// 抜粋
	remove_meta_box( 'commentstatusdiv','page','normal' );	// ディスカッション
	remove_meta_box( 'commentsdiv','page','normal' );		// コメント
	remove_meta_box( 'trackbacksdiv','page','normal' );		// トラックバック
//	remove_meta_box( 'authordiv','page','normal' );			// 作成者
//	remove_meta_box( 'slugdiv','page','normal' );			// スラッグ
//	remove_meta_box( 'revisionsdiv','page','normal' );		// リビジョン
 }
add_action('admin_menu','remove_default_page_screen_metaboxes');

/*-------------------------------------------*/
/*	管理画面_投稿のカスタマイズ
/*-------------------------------------------*/
function remove_default_post_screen_metaboxes() {
//	remove_meta_box( 'postcustom','post','normal' );			// カスタムフィールド
//	remove_meta_box( 'postexcerpt','post','normal' );			// 抜粋
//	remove_meta_box( 'commentstatusdiv','post','normal' );		// コメント
//	remove_meta_box( 'trackbacksdiv','post','normal' );			// トラックバック
//	remove_meta_box( 'slugdiv','post','normal' );				// スラッグ
//	remove_meta_box( 'authordiv','post','normal' );				// 作成者
 }
 add_action('admin_menu','remove_default_post_screen_metaboxes');

/*-------------------------------------------*/
/*	カスタム投稿タイプ_お知らせの追加
/*-------------------------------------------*/
add_action( 'init', 'create_post_type', 0 );
function create_post_type() {
	$infoLabelName = esc_html( bizVektorOptions('infoLabelName'));
	register_post_type( 'info', /* post-type */
	array(
		'labels' => array(
		'name' => $infoLabelName,
		'singular_name' => $infoLabelName
	),
	'public' => true,
	'menu_position' =>5,
	'has_archive' => true,
	'supports' => array('title','editor','excerpt','thumbnail')
	)
	);
	// お知らせのカテゴリーを設定
	register_taxonomy(
		'info-cat',
		'info',
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => $infoLabelName.'カテゴリー',
			'singular_label' => $infoLabelName.'カテゴリー',
			'public' => true,
			'show_ui' => true,
		)
	);
	}

add_action( 'generate_rewrite_rules', 'my_rewrite' );
function my_rewrite( $wp_rewrite ){
    $taxonomies = get_taxonomies();
    $taxonomies = array_slice($taxonomies,4,count($taxonomies)-1);
    foreach ( $taxonomies as $taxonomy ) :
         $post_types = get_taxonomy($taxonomy)->object_type;

        foreach ($post_types as $post_type){
            $new_rules[$post_type.'/'.$taxonomy.'/(.+?)/?$'] = 'index.php?taxonomy='.$taxonomy.'&term='.$wp_rewrite->preg_index(1);
        }
         $wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);
     endforeach;
}

/*		カスタム投稿タイプのアーカイブ出力
/*-------------------------------------------*/
global $my_archives_post_type;
add_filter( 'getarchives_where', 'my_getarchives_where', 10, 2 );
function my_getarchives_where( $where, $r ) {
  global $my_archives_post_type;
  if ( isset($r['post_type']) ) {
    $my_archives_post_type = $r['post_type'];
    $where = str_replace( '\'post\'', '\'' . $r['post_type'] . '\'', $where );
  } else {
    $my_archives_post_type = '';
  }
  return $where;
}
add_filter( 'get_archives_link', 'my_get_archives_link' );
function my_get_archives_link( $link_html ) {
  global $my_archives_post_type;
  if ( '' != $my_archives_post_type )
    $add_link .= '?post_type=' . $my_archives_post_type;
	$link_html = preg_replace("/href=\'(.+)\'\s/","href='$1".$add_link."'",$link_html);
  return $link_html;
}

/*-------------------------------------------*/
/*	head_description 生成
/*-------------------------------------------*/
function getHeadDescription() {
	global $wp_query;
	$post = $wp_query->get_queried_object();
	// ▼トップページ
	if (is_home() || is_page('home') || is_front_page()) {
		$metadescription = get_bloginfo( 'description' );
	// ▼カテゴリーページ
	} else if (is_category() || is_tax()) {
		$metadescription = $post->category_description;
		if ( ! $metadescription ) {
			$metadescription = single_cat_title()."について。".get_bloginfo('name').' '.get_bloginfo('description');
		}
	// ▼タグアーカイブ */
	} else if (is_tag()) {
		$metadescription = strip_tags(tag_description());
		$metadescription = str_replace(array("\r\n","\r","\n"), '', $metadescription);  // 改行コード削除
		if ( ! $metadescription ) {
			$metadescription = single_tag_title()."について。".get_bloginfo('name').' '.get_bloginfo('description');
		}
	// ▼アーカイブ */
	} else if (is_archive()) {
		if (is_year()){
			$metadescription = get_the_time('Y')."年の記事。".get_bloginfo('name').' '.get_bloginfo('description');
		} else if (is_month()){
			$metadescription = get_the_date('Y'."年".'M')."の記事。".get_bloginfo('name').' '.get_bloginfo('description');
		} else if (is_auuthor()) {
			$userObj = get_queried_object();
			$metadescription = esc_html($userObj->display_name)."の記事。".get_bloginfo('name').' '.get_bloginfo('description');
		}
	// ▼固定ページ || 投稿記事
	} else if (is_page() || is_single()) {
		$metaExcerpt = $post->post_excerpt;
		if ($metaExcerpt) {
			$metadescription = $post->post_excerpt;
		} else {
			$metadescription = mb_substr( strip_tags($post->post_content), 0, 240 ); // タグを無効化して240文字でトリム
			$metadescription = str_replace(array("\r\n","\r","\n"), ' ', $metadescription);  // 改行コード削除
		}
	// ▼それ以外
	} else {
		$metadescription = get_bloginfo('description');
	}
	$metadescription = apply_filters( 'metadescriptionCustom', $metadescription );
    echo $metadescription;
}

/*-------------------------------------------*/
/*	head_wp_head が吐き出す項目を追加・削除
/*-------------------------------------------*/

//	WordPressの情報を削除
remove_action('wp_head', 'wp_generator');

//	prev,nextを削除
remove_action('wp_head','adjacent_posts_rel_link_wp_head',10);

//　Google Web Fonts を追加
add_action('wp_head','bizVektorAddWebFonts');
function bizVektorAddWebFonts(){
	$webFonts = '<link href="http://fonts.googleapis.com/css?family=Droid+Sans:700|Lato:900|Anton" rel="stylesheet" type="text/css" />'."\n";
	$webFonts = apply_filters('webFontsCustom', $webFonts );
	echo $webFonts;
}

//　オプションのスタイルを追加
add_action('wp_head','bizVektorAddOptionStyle');
function bizVektorAddOptionStyle(){
	$optionStyle = '<link rel="stylesheet" id="bizvektor-option-css"  href="'.get_template_directory_uri().'/css/style_bizvektor_options.css" type="text/css" media="all" />'."\n";
	$optionStyle = apply_filters('optionStyleCustom', $optionStyle );
	echo $optionStyle;
}

//　SNS連携のスタイルを追加
add_action('wp_head','bizVektorAddSnsStyle');
function bizVektorAddSnsStyle(){
	$snsStyle = '<link rel="stylesheet" id="bizvektor-sns-css"  href="'.get_template_directory_uri().'/css/style_bizvektor_sns.css" type="text/css" media="all" />'."\n";
	$snsStyle = apply_filters('snsStyleCustom', $snsStyle );
	echo $snsStyle;
}

//　pingbackを追加
add_action('wp_head','bizVektorAddPingback');
function bizVektorAddPingback(){
	$pingback = '<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'."\n";
	$pingback = apply_filters('pingbackCustom', $pingback );
	echo $pingback;
}

/*-------------------------------------------*/
/*	カスタム分類名をaタグ無しで出力する
/*-------------------------------------------*/
function get_the_term_list_nolink( $id = 0, $taxonomy, $before = '', $sep = '', $after = '' ) {
    $terms = get_the_terms( $id, $taxonomy );
    if ( is_wp_error( $terms ) )
        return $terms;
    if ( empty( $terms ) )
        return false;
    foreach ( $terms as $term ) {
        $term_names[] =  $term->name ;
    }
    return $before . join( $sep, $term_names ) . $after;
}


/*-------------------------------------------*/
/*	ナビゲーションメニューの英語併記
/*-------------------------------------------*/
class description_walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $prepend = '<strong>';
        $append = '</strong>';
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

        if($depth != 0) {
            $description = $append = $prepend = "";
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
        $item_output .= $description.$args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
/*-------------------------------------------*/
/*	抜粋の後につく [...] を変換
/*-------------------------------------------*/
//	あれ、こんなフィルター無いっぽい。特定のテーマが独自につけてたフィルターかも。要確認
function change_excerpt_more($post) {
    return ' ...';
}
add_filter('excerpt_more', 'change_excerpt_more');

/*-------------------------------------------*/
/*	抜粋のpタグ自動挿入解除
/*-------------------------------------------*/
remove_filter('the_excerpt', 'wpautop');

/*-------------------------------------------*/
/*	年別アーカイブリストの“年”を</a>の中に置換
/*-------------------------------------------*/
function my_archives_link($html){
  return preg_replace('@</a>(.+?)</li>@', '\1</a></li>', $html);
}
add_filter('get_archives_link', 'my_archives_link');

/*-------------------------------------------*/
/*	カテゴリー件数を</a>の中に置換
/*-------------------------------------------*/
function my_list_categories( $output, $args ) {
	$output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
	return $output;
}
add_filter( 'wp_list_categories', 'my_list_categories', 10, 2 );


/*-------------------------------------------*/
/*	TinyMCEでiframeタグ（GoogleMapなど）の自動消去禁止指定
/*-------------------------------------------*/
function add_iframe($initArray) {
$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
return $initArray;
}
add_filter('tiny_mce_before_init', 'add_iframe');

/*-------------------------------------------*/
/*	画像挿入時のwidthとheight指定削除
/*	（スマホ表示の際に画像サイズ自動調整がうまくいかない為）
/*	→　キャプションが入らなくなる為削除。サイズは!importantで調整
/*-------------------------------------------*/
/*
function remove_hwstring_from_image_tag( $html, $id, $caption, $title, $align, $url, $size ) {
    list( $img_src, $width, $height ) = image_downsize($id, $size);
    $hwstring = image_hwstring( $width, $height );
    $html = str_replace( $hwstring, '', $html );
    return $html;
}
add_filter( 'image_send_to_editor', 'remove_hwstring_from_image_tag', 10, 7 );
*/

/*-------------------------------------------*/
/*	Comment
/*-------------------------------------------*/
if ( ! function_exists( 'biz_vektor_comment' ) ) :
function biz_vektor_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="commentBox">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf(sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em>あなたのコメントは承認待ちです。</em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
		<?php printf( '%1$s at %2$s', get_comment_date(),  get_comment_time() ); ?> <?php edit_comment_link( 'Edit', '<span class="edit-link">(', ')</span>' ); ?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>
		<div class="linkBtn linkBtnS">
		<?php comment_reply_link( array_merge( $args, array( 'reply_text' => '返信', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p>Pingback: <?php comment_author_link(); ?>  <span class="linkBtn linkBtnS"><?php edit_comment_link( '編集', '<span class="edit-link">(', ')</span>' ); ?></span>
	<?php
			break;
	endswitch;
}
endif;

/*-------------------------------------------*/
/*	Archive page link ( don't erase )
/*-------------------------------------------*/
function biz_vektor_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="<?php echo $nav_id; ?>">
			<h4 class="assistive-text">ナビゲーション</h4>
			<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&larr;</span> 古い投稿'); ?></div>
			<div class="nav-next"><?php previous_posts_link('新しい投稿 <span class="meta-nav">&rarr;</span>'); ?></div>
		</div><!-- #nav -->
	<?php endif;
	wp_reset_query();
}

/*-------------------------------------------*/
/*	ページング
/*-------------------------------------------*/
function pagination($pages = '', $range = 1) {
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '') {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages) {
             $pages = 1;
         }
     }

     if(1 != $pages) {
         echo "<div class=\"paging\"><span class=\"pageIndex\">Page ".$paged." / ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++) {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}
// ▲ページング


/*-------------------------------------------*/
/*	Comment out short code
/*-------------------------------------------*/
/*
本文欄で一時的に非表示にしたい箇所がある場合、
htmlモードで該当箇所を[ignore][/ignore]で囲うと、コメントアウトが出来ます。
*/
function ignore_shortcode( $atts, $content = null ) {
    return null;
}
add_shortcode('ignore', 'ignore_shortcode');