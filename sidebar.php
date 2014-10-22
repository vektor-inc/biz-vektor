<?php
// 共通サイドバーtop
if ( is_active_sidebar( 'common-side-top-widget-area' ) ) dynamic_sidebar( 'common-side-top-widget-area' );
$postType = get_post_type();
if ( !$postType ) {
  global $wp_query;
  if ($wp_query->query_vars['post_type']) {
      $postType = $wp_query->query_vars['post_type'];
  }
}
// 投稿タイプのスラッグに紐づいたウィジェットエリアを表示する
$widdget_area_name = $postType.'-widget-area';
if ( is_active_sidebar( $widdget_area_name ) )
	dynamic_sidebar( $widdget_area_name );
// 共通サイドバー下
if ( is_active_sidebar( 'common-side-bottom-widget-area' ) ) dynamic_sidebar( 'common-side-bottom-widget-area' );