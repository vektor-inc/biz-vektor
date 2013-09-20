<?php
if ( is_category() || is_tag() || is_tax() || is_home() || is_author() || is_archive() || is_single() ) {
	// ポストタイプを取得
	$postType = get_post_type();
	// 標準の投稿タイプ(post)の場合は、管理画面で設定した名前を取得
	// 投稿が0件の場合はget_post_typeが効かないので is_category()とis_tag()も追加
	if ( $postType == 'post' || is_category() || is_tag() ) {
		$pageTitle = esc_html(bizVektorOptions('postLabelName'));
	// 標準の投稿タイプでない場合は、カスタム投稿タイプ名を取得
	} else {
		// 普通のポスト退部が取得出来る場合
		if ($postType) {
			$pageTitle = get_post_type_object($postType)->labels->name;
		// 該当記事が0件の場合に投稿タイプ名が取得出来ないのでタクソノミー経由で取得する
		} else if ( is_tax( ) ) {
			$taxonomy = get_queried_object()->taxonomy;
			$postTypeSlug = get_taxonomy( $taxonomy )->object_type[0];
			$pageTitle = get_post_type_object($postTypeSlug)->labels->name;
		}
	} 
} else if (is_page() || is_attachment()) {
	$pageTitle = get_the_title();
} else if (is_search()) {
	$pageTitle = '『'.get_search_query().'』の検索結果';
} else if (is_404()){ 
	$pageTitle = 'ページが見つかりません';
}
/*-------------------------------------------*/
/*	出力
/*-------------------------------------------*/
$pageTitle = apply_filters( 'biz_vektor_pageTitCustom', $pageTitle );
if ( is_home() || is_page() || is_attachment() || is_search() || is_404() ){ ?>
<h1 id="pageTit"><?php echo esc_html( $pageTitle ); ?><?php if (is_page()) : edit_post_link('編集', '<span class="edit-link">（', '）' ); endif; ?></h1>
<?php } else if ( is_category() || is_tag() || is_author() ||  is_tax() || is_archive() || is_single() ) { ?>
<div id="pageTit"><?php echo esc_html( $pageTitle ); ?></div>
<?php } ?>