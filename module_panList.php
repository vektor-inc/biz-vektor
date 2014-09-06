<?php
/*-------------------------------------------*/
/*	パンくずリスト
/*-------------------------------------------*/

$panListHtml = '<!-- [ #panList ] -->
<div id="panList">
<div id="panListInner" class="innerBox">
';

global $wp_query;
global $biz_vektor_options;

// カスタム投稿タイプの種類を取得
$postType = get_post_type();
// カスタム投稿タイプ名を取得
$post_type_object = get_post_type_object($postType);
if($post_type_object){
	$postTypeName = esc_html($post_type_object->labels->name);
}

// 標準のpost のラベル名
$postLabelName = $biz_vektor_options['postLabelName'];
// 標準のpost のトップのURL
$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? $biz_vektor_options['postTopUrl'] : '';

	$panListHtml .= '<ul>';
	$panListHtml .= '<li id="panHome"><a href="'. home_url() .'">HOME</a> &raquo; </li>';
// ▼
if ( is_404() ){
	$panListHtml .= "<li>".__('Not found', 'biz-vektor')."</li>";
} else if ( is_search() ) {
	$panListHtml .= "<li>".sprintf(__('Search Results for : %s', 'biz-vektor'),get_search_query())."</li>";
// ▼▼ 投稿ページをブログに指定された場合
} else if ( is_home() ){
	$panListHtml .= '<li>'.$postLabelName.'</li>';
// ▼▼ 固定ページ
} elseif ( is_page() ) {
	$post = $wp_query->get_queried_object();
	if ( $post->post_parent == 0 ){
		$panListHtml .= "<li>".the_title('','', FALSE)."</li>";
	} else {
		$title = the_title('','', FALSE);
		$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
		array_push($ancestors, $post->ID);
		foreach ( $ancestors as $ancestor ){
			if( $ancestor != end($ancestors) ){
				$panListHtml .= '<li><a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a> &raquo; </li>';
			} else {
				$panListHtml .= '<li>'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
			}
		}
	}

// ▼▼ 投稿者ページ
} else if (is_author()) {
	$userObj = get_queried_object();
	// 投稿の場合
	if ($postType == 'post') {
		if ($postTopUrl) {
			$panListHtml .= '<li><a href="'.esc_url($postTopUrl).'">'.$postLabelName.'</a> &raquo; </li>';
		} else {
			$panListHtml .= '<li>'.$postLabelName.' &raquo; </li>';
		}
	}
	$panListHtml .= '<li>'.esc_html($userObj->display_name).'</li>';

// ▼▼ 投稿記事ページ
} elseif ( is_single() ) {
	// 投稿の場合
	if ($postType == 'post') {
		if ($postTopUrl) {
			$panListHtml .= '<li><a href="'.esc_url($postTopUrl).'">'.$postLabelName.'</a> &raquo; </li>';
		} else {
			$panListHtml .= '<li>'.$postLabelName.' &raquo; </li>';
		}
		$category = get_the_category();
		$category_id = get_cat_ID( $category[0]->cat_name );
		if ($category_id) :  // カスタム投稿タイプを追加した場合にカテゴリー指定が無い場合の為
			$panListHtml .= '<li>'. get_category_parents( $category_id, TRUE, ' &raquo; ' ).'</li>';
		endif;
	// カスタム投稿タイプのsingleページの場合
	} else {
		$panListHtml .= '<li><a href="'.home_url().'/'.$postType.'">'.$postTypeName.'</a> &raquo; </li>';
		$taxonomies = get_the_taxonomies();
		// 複数のタクソノミーを跨ぐ事が無い前提なので、forechじゃなくても良いはず...
		foreach ( $taxonomies as $taxonomySlug => $taxonomy ) {}
		if ($taxonomies):
			$taxo_catelist = get_the_term_list( $post->ID, $taxonomySlug, '', ' , ', '' );
			$panListHtml .= '<li>'.$taxo_catelist.' &raquo; </li>';
		endif;
	}
	$panListHtml .= '<li>'.get_the_title()."</li>";

// ▼▼ タクソノミー
} else if (is_tax()) { // 階層構造を反映しないので要検討
	// 標準の投稿タイプ(post)の場合は、管理画面で設定した名前を取得
	if ( $postType == 'post') {
		$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? esc_html($biz_vektor_options['postTopUrl']) : '';
		if ($postTopUrl) {
			$panListHtml .= '<li><a href="'.$postTopUrl.'">'.$postLabelName.'</a> &raquo; </li>';
		} else {
			$panListHtml .= '<li>'.$postLabelName.' &raquo; </li>';
		}
	// 標準の投稿タイプでない場合は、カスタム投稿タイプ名を取得
	} else {
		if (get_post_type()) {
			$postTypeSlug = get_post_type();
		} else {
			// カテゴリーに記事が一件も無いとget_post_typeで投稿タイプが取得出来ないため
			$taxonomy = get_queried_object()->taxonomy;
			$postTypeSlug = get_taxonomy( $taxonomy )->object_type[0];
		}
		$postTypeName = get_post_type_object($postTypeSlug)->labels->name;
		$panListHtml .= '<li><a href="'.home_url().'/'.$postType.'">'.$postTypeName.'</a> &raquo; </li>';
	}
	$panListHtml .= '<li>'.single_cat_title('','', FALSE).'</li>';
// ▼▼ カテゴリー
} else if ( is_category() ) {
	$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? esc_html($biz_vektor_options['postTopUrl']) : '';
	if ($postTopUrl) {
		$panListHtml .= '<li><a href="'.$postTopUrl.'">'.$postLabelName.'</a> &raquo; </li>';
	} else {
		$panListHtml .= '<li>'.$postLabelName.' &raquo; </li>';
	}
	// カテゴリー情報を取得して$catに格納
	$cat = get_queried_object();
	// parent が 0 の場合 = 親カテゴリーが存在する場合
	if($cat -> parent != 0):
		// 祖先のカテゴリー情報を逆順で取得
		$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
		// 祖先階層の配列回数分ループ
		foreach($ancestors as $ancestor):
			$panListHtml .= '<li><a href="'.get_category_link($ancestor).'">'.get_cat_name($ancestor).'</a> &raquo; </li>';
		endforeach;
	endif;
	$panListHtml .= '<li>'. $cat -> cat_name. '</li>';	
// ▼▼ タグ
} elseif ( is_tag() ) {
	// 投稿の場合
	if ($postType == 'post') {
		if ($postTopUrl) {
			$panListHtml .= '<li><a href="'.esc_url($postTopUrl).'">'.$postLabelName.'</a> &raquo; </li>';
		} else {
			$panListHtml .= '<li>'.$postLabelName.' &raquo; </li>';
		}
	// カスタム投稿タイプの場合
	} else {
		$panListHtml .= '<li>'.$postTypeName.' &raquo; </li>';
	}
	$tagTitle = single_tag_title( "", false );
	$panListHtml .= "<li>". $tagTitle ."</li>";
// ▼▼ アーカイブ
} elseif ( is_archive() && (!is_category() || !is_tax()) ) {

	if (is_year() || is_month()){
		// 投稿の場合
		if ($postType == 'post') {
			if ($postTopUrl) {
				$panListHtml .= '<li><a href="'.esc_url($postTopUrl).'">'.$postLabelName.'</a> &raquo; </li>';
			} else {
				$panListHtml .= '<li>'.$postLabelName.' &raquo; </li>';
			}
		// カスタム投稿タイプの場合
		} else {
			$panListHtml .= '<li><a href="'.home_url().'/'.$postType.'">'.$postTypeName.'</a> &raquo; </li>';
		}
		if (is_year()){
			$panListHtml .= "<li>".sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) )."</li>";
		} else if (is_month()){
			$panListHtml .= "<li>".sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) )."</li>";
		}
	} else {
		$panListHtml .= '<li>'.$postTypeName.'</li>';
	}

} elseif ( is_attachment() ) {
	$panListHtml .= '<li>'.the_title('','', FALSE).'</li>';
}
$panListHtml .= '</ul>';
$panListHtml .= '</div>
</div>
<!-- [ /#panList ] -->
';
$panListHtml = apply_filters( 'bizvektor_panListHtml', $panListHtml );
echo $panListHtml;