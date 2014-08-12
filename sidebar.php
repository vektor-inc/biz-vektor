<?php
// 共通サイドバーtop
if ( is_active_sidebar( 'common-side-top-widget-area' ) ) dynamic_sidebar( 'common-side-top-widget-area' );
$postType = get_post_type();
if ( !$postType ) {
	// カスタム投稿タイプで該当記事が0件の場合、 get_post_type()で取得できないのでタクソノミーから取得
	$taxonomy = get_queried_object()->taxonomy;
	$postType = get_taxonomy( $taxonomy )->object_type[0];
}
// 投稿タイプのスラッグに紐づいたウィジェットエリアを表示する
$widdget_area_name = $postType.'-widget-area';
if ( is_active_sidebar( $widdget_area_name ) )
	dynamic_sidebar( $widdget_area_name );
// 共通サイドバー下
if ( is_active_sidebar( 'common-side-bottom-widget-area' ) ) dynamic_sidebar( 'common-side-bottom-widget-area' );