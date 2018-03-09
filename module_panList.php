<?php
/*-------------------------------------------*/
/*	パンくずリスト
/*-------------------------------------------*/

// Microdata
// http://schema.org/BreadcrumbList
/*-------------------------------------------*/
$microdata_li        = ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"';
$microdata_li_a      = ' itemprop="item"';
$microdata_li_a_span = ' itemprop="name"';

global $wp_query;
$biz_vektor_options = biz_vektor_get_theme_options();

// カスタム投稿タイプの種類を取得
$post_type = get_post_type();
// カスタム投稿タイプ名を取得
$post_type_object = get_post_type_object( $post_type );
if ( $post_type_object ) {
	$post_type_name = esc_html( $post_type_object->labels->name );
}

// post のラベル名
$postLabelName = $biz_vektor_options['postLabelName'];

$post_type = biz_vektor_get_post_type();

$breadcrumb_array = array(
	array(
		'name'             => 'HOME',
		'id'               => 'panHome',
		'url'              => home_url(),
		'class_additional' => '',
	),
);

// ▼▼ 投稿ページをブログに指定された場合
if ( is_home() ) {
	$page_for_posts     = biz_vektor_get_page_for_posts();
	$breadcrumb_array[] = array(
		'name'             => esc_html( $page_for_posts['post_top_name'] ),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_404() ) {
	$breadcrumb_array[] = array(
		'name'             => __( 'Not found', 'biz-vektor' ),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_search() ) {
	$breadcrumb_array[] = array(
		'name'             => sprintf( __( 'Search Results for : %s', 'biz-vektor' ), get_search_query() ),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_attachment() ) {
	$breadcrumb_array[] = array(
		'name'             => get_the_title(),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_author() ) {
	$user_obj           = get_queried_object();
	$breadcrumb_array[] = array(
		'name'             => $user_obj->display_name,
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_page() ) {
	$post = $wp_query->get_queried_object();
	// 第一階層
	if ( $post->post_parent == 0 ) {
		$breadcrumb_array[] = array(
			'name'             => strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ),
			'id'               => '',
			'url'              => '',
			'class_additional' => '',
		);
	} else {
		// 子階層がある場合
		$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
		array_push( $ancestors, $post->ID );
		foreach ( $ancestors as $ancestor ) {
			if ( $ancestor != end( $ancestors ) ) {
				$breadcrumb_array[] = array(
					'name'             => strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ),
					'id'               => '',
					'url'              => get_permalink( $ancestor ),
					'class_additional' => '',
				);
			} else {
				$breadcrumb_array[] = array(
					'name'             => strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ),
					'id'               => '',
					'url'              => '',
					'class_additional' => '',
				);
			} // if ( $ancestor != end( $ancestors ) ) {
		} // foreach ( $ancestors as $ancestor ) {
	} // if ( $post->post_parent == 0 ) {
} elseif ( is_post_type_archive() ) {
	$breadcrumb_array[] = array(
		'name'             => $post_type['name'],
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
}

$excrude_post_types = array( 'page', 'attachment' );
	// if ( ! in_array( $post_type['slug'], $excrude_post_types ) ) {
if ( ( is_single() || is_archive() ) && ! is_post_type_archive() ) {
	$breadcrumb_array[] = array(
		'name'             => $post_type['name'],
		'id'               => '',
		'url'              => $post_type['url'],
		'class_additional' => '',
	);
}

if ( is_date() ) {
	$breadcrumb_array[] = array(
		'name'             => get_the_archive_title(),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_tag() ) {
	$breadcrumb_array[] = array(
		'name'             => single_tag_title( '', false ),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_category() ) {

	/* Category
	/*-------------------------------*/

	// Get category information & insert to $cat
	$cat = get_queried_object();

	// parent != 0  >>>  Parent exist
	if ( $cat->parent != 0 ) :
		// 祖先のカテゴリー情報を逆順で取得
		$ancestors = array_reverse( get_ancestors( $cat->cat_ID, 'category' ) );
		// 祖先階層の配列回数分ループ
		foreach ( $ancestors as $ancestor ) :
			$breadcrumb_array[] = array(
				'name'             => get_cat_name( $ancestor ),
				'id'               => '',
				'url'              => get_category_link( $ancestor ),
				'class_additional' => '',
			);
		endforeach;
		endif;
		$breadcrumb_array[] = array(
			'name'             => $cat->cat_name,
			'id'               => '',
			'url'              => '',
			'class_additional' => '',
		);

} elseif ( is_tax() ) {

	/* term
	/*-------------------------------*/
	$now_term        = $wp_query->queried_object->term_id;
	$now_term_parent = $wp_query->queried_object->parent;
	$now_taxonomy    = $wp_query->queried_object->taxonomy;

	// parent が !0 の場合 = 親カテゴリーが存在する場合
	if ( $now_term_parent != 0 ) :
		// 祖先のカテゴリー情報を逆順で取得
		$ancestors = array_reverse( get_ancestors( $now_term, $now_taxonomy ) );
		// 祖先階層の配列回数分ループ
		foreach ( $ancestors as $ancestor ) :
			$pan_term           = get_term( $ancestor, $now_taxonomy );
			$breadcrumb_array[] = array(
				'name'             => esc_html( $pan_term->name ),
				'id'               => '',
				'url'              => get_term_link( $ancestor, $now_taxonomy ),
				'class_additional' => '',
			);
		endforeach;
		endif;
	$breadcrumb_array[] = array(
		'name'             => single_cat_title( '', '', false ),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
} elseif ( is_single() ) {

	/* Single
	/*-------------------------------*/

	// Case of post

	if ( $post_type['slug'] == 'post' ) {
		$category = get_the_category();
		// get parent category info
		$parents = array_reverse( get_ancestors( $category[0]->term_id, 'category', 'taxonomy' ) );
		array_push( $parents, $category[0]->term_id );
		foreach ( $parents as $parent_term_id ) {
			$parent_obj         = get_term( $parent_term_id, 'category' );
			$term_url           = get_term_link( $parent_obj->term_id, $parent_obj->taxonomy );
			$breadcrumb_array[] = array(
				'name'             => $parent_obj->name,
				'id'               => '',
				'url'              => $term_url,
				'class_additional' => '',
			);
		}

		// Case of custom post type

	} else {
		$taxonomies = get_the_taxonomies();
		$taxonomy   = key( $taxonomies );
		if ( $post_type['slug'] == 'info' ) {
			$taxonomy = 'info-cat';
		}

		if ( $taxonomies ) {
			$terms = get_the_terms( get_the_ID(), $taxonomy );

			//keeps only the first term (categ)
			$term = reset( $terms );
			if ( 0 != $term->parent ) {

				// Get term ancestors info
				$ancestors = array_reverse( get_ancestors( $term->term_id, $taxonomy ) );
				// Print loop term ancestors
				foreach ( $ancestors as $ancestor ) :
					$pan_term           = get_term( $ancestor, $taxonomy );
					$breadcrumb_array[] = array(
						'name'             => $pan_term->name,
						'id'               => '',
						'url'              => get_term_link( $ancestor, $taxonomy ),
						'class_additional' => '',
					);
				endforeach;
			} // if ( 0 != $term->parent ) {
			$term_url           = get_term_link( $term->term_id, $taxonomy );
			$breadcrumb_array[] = array(
				'name'             => $term->name,
				'id'               => '',
				'url'              => $term_url,
				'class_additional' => '',
			);
		} // if ( $taxonomies ) {
	} // if ( $post_type['slug'] == 'post' ) {
	$breadcrumb_array[] = array(
		'name'             => get_the_title(),
		'id'               => '',
		'url'              => '',
		'class_additional' => '',
	);
}

$breadcrumb_array = apply_filters( 'bizvektor_panList_array', $breadcrumb_array );

$breadcrumb_html = '<!-- [ #panList ] -->
<div id="panList">
<div id="panListInner" class="innerBox"><ul>';
foreach ( $breadcrumb_array as $key => $value ) {
	$id = ( $value['id'] ) ? ' id="' . esc_attr( $value['id'] ) . '"' : '';
	if ( $value == 'HOME' ) {
		$microdata_li        = '';
		$microdata_li_a      = '';
		$microdata_li_a_span = '';
	}
	$breadcrumb_html .= '<li' . $id . $microdata_li . '>';

	if ( $value['url'] ) {
		$breadcrumb_html .= '<a href="' . esc_url( $value['url'] ) . '"' . $microdata_li_a . '>';
	}

	$breadcrumb_html .= '<span' . $microdata_li_a_span . '>' . esc_html( $value['name'] ) . '</span>';

	if ( $value['url'] ) {
		$breadcrumb_html .= '</a> &raquo; ';
	}

	$breadcrumb_html .= '</li>';
}
$breadcrumb_html .= '</ul>';
$breadcrumb_html .= '</div>
</div>
<!-- [ /#panList ] -->
';
$breadcrumb_html  = apply_filters( 'bizvektor_panListHtml', $breadcrumb_html );
echo $breadcrumb_html;
