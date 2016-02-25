<?php

$current_type = get_post_type();

if ( is_home() || is_page() || is_attachment() || is_search() || is_404() || ( $current_type == 'info' && is_archive() ) ) {
	$pageTitTag = 'h1';
} else if ( is_category() || is_tag() || is_author() || is_tax() || is_archive() || is_single() ) {
	$pageTitTag = 'div';
}
$pageTitHtml_before = '<div id="pageTitBnr">'."\n";
$pageTitHtml_before .= '<div class="innerBox">'."\n";
$pageTitHtml_before .= '<div id="pageTitInner">'."\n";
$pageTitHtml_before .= '<'.$pageTitTag.' id="pageTit">'."\n";
$pageTitHtml_after = '</'.$pageTitTag.'>'."\n";
$pageTitHtml_after .= '</div><!-- [ /#pageTitInner ] -->'."\n";
$pageTitHtml_after .= '</div>'."\n";
$pageTitHtml_after .= '</div><!-- [ /#pageTitBnr ] -->'."\n";

/*-------------------------------------------*/
/*	title
/*-------------------------------------------*/
$biz_vektor_options = biz_vektor_get_theme_options();
$pageTitle = '';

if (is_page() || is_attachment()){
    $pageTitle = get_the_title();
} else if ( is_category() || is_tag() || is_tax() || is_home() || is_author() || is_archive() || is_single() ) {
	// get post type
	$postType = get_post_type();
	// 標準の投稿タイプ(post)の場合は、管理画面で設定した名前を取得
	// 投稿が0件の場合はget_post_typeが効かないので is_category()とis_tag()も追加
	if ( $postType == 'post' || is_category() || is_tag() ) {
		$pageTitle = esc_html($biz_vektor_options['postLabelName']);
	// 標準の投稿タイプでない場合は、カスタム投稿タイプ名を取得
	} else {
		// 普通のポストタイプが取得出来る場合
		if ($postType) {
			$pageTitle = get_post_type_object($postType)->labels->name;
		// 該当記事が0件の場合に投稿タイプ名が取得出来ないので$wp_query経由で取得する
		} elseif (is_category() || is_tag()){
			global $wp_query;
			$pageTitle = $wp_query->queried_object->name;
		}
		elseif(is_archive()) {
			global $wp_query;
			$pageTitle = $wp_query->queried_object->label;
		}
	}
} else if (is_search()) {
	$pageTitle = sprintf(__('Search Results for : %s', 'biz-vektor'),get_search_query());
} else if (is_404()){
	$pageTitle = __('Not found', 'biz-vektor');
}
$pageTitle = apply_filters( 'biz_vektor_pageTitCustom', $pageTitle );

/*-------------------------------------------*/
/*	print
/*-------------------------------------------*/
$pageTitHtml = $pageTitHtml_before;
// 特定のダグのみ許可
$allowed_html = array(
    'i' => array(
    		'class' => array (),
    	),
    'br' => array(),
    'strong' => array()
);
$pageTitHtml .= wp_kses($pageTitle,$allowed_html);
$pageTitHtml .= $pageTitHtml_after;
$pageTitHtml = apply_filters( 'bizvektor_pageTitHtml', $pageTitHtml );
echo $pageTitHtml;