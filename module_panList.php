<?php
/*-------------------------------------------*/
/*	パンくずリスト
/*-------------------------------------------*/

$panListHtml = '<!-- [ #panList ] -->
<div id="panList">
<div id="panListInner" class="innerBox">
';

global $wp_query;
$biz_vektor_options = biz_vektor_get_theme_options();

// カスタム投稿タイプの種類を取得
$postType = get_post_type();
// カスタム投稿タイプ名を取得
$post_type_object = get_post_type_object($postType);
if($post_type_object){
	$postTypeName = esc_html($post_type_object->labels->name);
}

// post のラベル名
$postLabelName = $biz_vektor_options['postLabelName'];
// info のラベル名
$infoLabelName = (isset($biz_vektor_options['infoLabelName']))? $biz_vektor_options['infoLabelName'] : 'info';
// post のトップのURL
$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? $biz_vektor_options['postTopUrl'] : '';
// info のトップのURL
$infoTopUrl = (isset($biz_vektor_options['infoTopUrl']) && $biz_vektor_options['infoTopUrl'])? $biz_vektor_options['infoTopUrl'] : home_url().'/info/';

	$panListHtml .= '<ul>';
	$panListHtml .= '<li id="panHome"><a href="' . home_url() . '"><span>HOME</span></a> &raquo; </li>';
// ▼
if ( is_404() ){
	$panListHtml .= '<li><span>' . __( 'Not found', 'biz-vektor' ) . '</span></li>';
} else if ( is_search() ) {
	$panListHtml .= '<li><span>' . sprintf(__('Search Results for : %s', 'biz-vektor'), get_search_query() ) . '</span></li>';
// ▼▼ 投稿ページをブログに指定された場合
} else if ( is_home() ){
	$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' . $postLabelName . '</span></li>';
// ▼▼ 固定ページ
} elseif ( is_page() ) {
	$post = $wp_query->get_queried_object();
	if ( $post->post_parent == 0 ){
		$panListHtml .= '<li><span>' . get_the_title() . '</span></li>';
	} else {
		$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
		array_push( $ancestors, $post->ID );
		foreach ( $ancestors as $ancestor ) {
			if( $ancestor != end( $ancestors ) ) {
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($ancestor) .'" itemprop="url"><span itemprop="title">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</span></a> &raquo; </li>';
			} else {
				$panListHtml .= '<li><span>' . strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) . '</span></li>';
			}
		}
	}

} else if ( $postType == 'info' ) {
	// マルチサイトや、infoのトップを固定ページで作った場合にURLが変動するため
	if ( is_tax() || is_tag() || is_year() || is_month() || is_single() ) {
		$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url($infoTopUrl) . '" itemprop="url"><span itemprop="title">' . $infoLabelName . '</span></a> &raquo; </li>';
	}
	if ( is_tax() ) {
		$taxonomy   = $wp_query->query_vars['taxonomy'];
		$term_slug  = $wp_query->query_vars['term'];
		$taxonomies = get_the_taxonomies();

		if ( isset( $taxonomy ) && isset( $term_slug ) ):
			$term = get_term_by( 'slug', $term_slug, $taxonomy );
			if ( 0 != $term->parent ) {
				$parent_term = get_term_by( 'id', $term->parent, $taxonomy );
				$parent_url = home_url() . '/' .  $parent_term->taxonomy . '/' . $parent_term->slug . '/';
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $parent_url . '" itemprop="url"><span itemprop="title">' . $parent_term->name . '</span></a> &raquo; </li>';
			}
		endif;	
		$panListHtml .= '<li><span>' . single_cat_title( '', false ) . '</span></li>';
	} else if ( is_tag() ) {
		$panListHtml .= '<li><span>'.single_tag_title('','', FALSE).'</span></li>';
	} else if ( is_year() ) {
		$panListHtml .= '<li><span>' . sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) ) . '</span></li>';
	} else if ( is_month() ) {
		$panListHtml .= '<li><span>' . sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) ) . '</span></li>';
	} else if ( is_single() ) {
		$taxonomies = get_the_taxonomies();
		if ($taxonomies):
			$taxo_catelist  = get_the_terms( get_the_ID(), key( $taxonomies ) );
			//keeps only the first term (categ)
			$taxo_categ 	= reset( $taxo_catelist );
			if ( 0 != $taxo_categ->parent ) {
				$taxo_parent = get_term( $taxo_categ->parent, $taxo_categ->taxonomy );
				$parent_url = home_url() . '/' .  $taxo_parent->taxonomy . '/' . $taxo_parent->slug . '/';
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $parent_url . '" itemprop="url"><span itemprop="title">' . $taxo_parent->name . '</span></a> &raquo; </li>';
			}
			$categ_url		= home_url() . '/' .  $taxo_categ->taxonomy . '/' . $taxo_categ->slug . '/';
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $categ_url . '" itemprop="url"><span itemprop="title">' . $taxo_categ->name . '</span></a> &raquo; </li>';
		endif;
		$panListHtml .= '<li><span>' . get_the_title() . '</span></li>';
	} else {
		$panListHtml .= '<li><span>' . $postTypeName . '</span></li>';
	}

// ▼▼ 投稿者ページ
} else if ( is_author() ) {
	$userObj = get_queried_object();
	// 投稿の場合
	if ( $postType == 'post' ) {
		if ( $postTopUrl ) {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.esc_url($postTopUrl).'" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
		} else {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'.$postLabelName.'</span> &raquo; </li>';
		}
	}
	$panListHtml .= '<li><span>' . esc_html( $userObj->display_name ) . '</span></li>';

} elseif ( is_attachment() ) {
	$panListHtml .= '<li><span>'.the_title('','', FALSE).'</span></li>';

// ▼▼ 投稿記事ページ
} elseif ( is_single() ) {
	// 投稿の場合
	if ( $postType == 'post' ) {
		if ($postTopUrl) {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.esc_url($postTopUrl).'" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
		} else {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'.$postLabelName.'</span> &raquo; </li>';
		}
		$category = get_the_category();
		// 今のカテゴリーの親のカテゴリー情報を取得
		$parents_str = get_category_parents( $category[0]->term_id, false, ',' );
		// 親カテゴリーをループしやすいように配列に格納
		$parents_name = explode( ',', $parents_str );
		foreach ( $parents_name as $parent_name ) {
			if ( ! empty( $parent_name ) ) {
				$parent_obj 	= get_term_by( 'name', $parent_name, $category[0]->taxonomy );
				$term_url		= get_term_link( $parent_obj->term_id,$parent_obj->taxonomy );
				$panListHtml 	.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $term_url . '" itemprop="url"><span itemprop="title">' . $parent_obj->name . '</span></a> &raquo; </li>';
			}
		}
	// カスタム投稿タイプのsingleページの場合
	} else {
		$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.home_url().'/'.$postType.'/" itemprop="url"><span itemprop="title">'.$postTypeName.'</span></a> &raquo; </li>';
		$taxonomies = get_the_taxonomies();
		if ($taxonomies):
			$taxo_catelist  = get_the_terms( get_the_ID(), key( $taxonomies ) );
			//keeps only the first term (categ)
			$taxo_categ 	= reset( $taxo_catelist );
			if ( 0 != $taxo_categ->parent ) {
				$taxo_parent 	= get_term( $taxo_categ->parent, $taxo_categ->taxonomy );
				$term_url		= get_term_link( $taxo_parent->term_id,$taxo_parent->taxonomy );
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $term_url . '" itemprop="url"><span itemprop="title">' . $taxo_parent->name . '</span></a> &raquo; </li>';
			}
			$categ_url		= home_url() . '/' .  $taxo_categ->taxonomy . '/' . $taxo_categ->slug . '/';
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $categ_url . '" itemprop="url"><span itemprop="title">' . $taxo_categ->name . '</span></a> &raquo; </li>';
		endif;
	}
	$panListHtml .= '<li><span>' . get_the_title() . '</span></li>';

// ▼▼ タクソノミー
} else if (is_tax()) {
	// 標準の投稿タイプ(post)の場合は、管理画面で設定した名前を取得
	if ( $postType == 'post') {
		$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? esc_html($biz_vektor_options['postTopUrl']) : '';
		if ($postTopUrl) {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$postTopUrl.'" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
		} else {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'.$postLabelName.'</span> &raquo; </li>';
		}
	// 標準の投稿タイプでない場合は、カスタム投稿タイプ名を取得
	} else {
		if ( get_post_type() ) {
			$postTypeSlug = get_post_type();
		} else {
			// カテゴリーに記事が一件も無いとget_post_typeで投稿タイプが取得出来ないため
			$taxonomy = get_queried_object()->taxonomy;
			$postTypeSlug = get_taxonomy( $taxonomy )->object_type[0];
		}
		$postTypeName = get_post_type_object($postTypeSlug)->labels->name;
		$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.home_url().'/'.$postType.'" itemprop="url"><span itemprop="title">'.$postTypeName.'</span></a> &raquo; </li>';

		$now_term = $wp_query->queried_object->term_id;
		$now_term_parent = $wp_query->queried_object->parent;
		$now_taxonomy = $wp_query->queried_object->taxonomy;

		// parent が !0 の場合 = 親カテゴリーが存在する場合
		if($now_term_parent != 0):
			// 祖先のカテゴリー情報を逆順で取得
			$ancestors = array_reverse(get_ancestors( $now_term, $now_taxonomy ));
			// 祖先階層の配列回数分ループ
			foreach($ancestors as $ancestor):
				$pan_term = get_term($ancestor,$now_taxonomy);
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_term_link($ancestor,$now_taxonomy).'">'.$pan_term->name.'</a> &raquo; </li>';
			endforeach;
		endif;

	}
	$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'.single_cat_title('','', FALSE).'</span></li>';
// ▼▼ カテゴリー
} else if ( is_category() ) {
	$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? esc_html($biz_vektor_options['postTopUrl']) : '';
	if ($postTopUrl) {
		$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$postTopUrl.'" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
	} else {
		$panListHtml .= '<li><span>'.$postLabelName.'</span> &raquo; </li>';
	}
	// カテゴリー情報を取得して$catに格納
	$cat = get_queried_object();
	// parent が 0 の場合 = 親カテゴリーが存在する場合
	if($cat->parent != 0):
		// 祖先のカテゴリー情報を逆順で取得
		$ancestors = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
		// 祖先階層の配列回数分ループ
		foreach($ancestors as $ancestor):
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link($ancestor).'" itemprop="url"><span itemprop="title">'.get_cat_name($ancestor).'</span></a> &raquo; </li>';
		endforeach;
	endif;
	$panListHtml .= '<li><span>'. $cat->cat_name. '</span></li>';
// ▼▼ タグ
} elseif ( is_tag() ) {
	// 投稿の場合
	if ($postType == 'post') {
		if ($postTopUrl) {
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.esc_url($postTopUrl).'" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
		} else {
			$panListHtml .= '<li><span>' . $postLabelName . '</span></a> &raquo; </li>';
		}
	// カスタム投稿タイプの場合
	} else {
		$current_post_type = get_post_type_object( $postType );
		$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . home_url() . '/' .$current_post_type->name . '/" itemprop="url"><span itemprop="title">' . $current_post_type->label . '</span></a> &raquo; </li>';
	}
	$tagTitle = single_tag_title( "", false );
	$panListHtml .= '<li><span>'. $tagTitle .'</span></li>';
// ▼▼ アーカイブ
} elseif ( is_archive() && (!is_category() || !is_tax()) ) {
	//here
	if (is_year() || is_month()){
		// 投稿の場合
		if ($postType == 'post') {
			if ($postTopUrl) {
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.esc_url($postTopUrl).'" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
			} else {
				$panListHtml .= '<li><span>' . $postLabelName . '</span> &raquo; </li>';
			}
		// カスタム投稿タイプの場合
		} else {
			$post_type         = $wp_query->query_vars['post_type'];
			$current_post_type = get_post_type_object( $post_type );
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . home_url() . '/' . $post_type . '/" itemprop="url"><span itemprop="title">' . $current_post_type->label . '</span></a> &raquo; </li>';
		}
		$details = $wp_query->query_vars;
		if (is_year()){
			$panListHtml .= '<li><span>' . sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ), strtotime( $details['year'] .'-01-01' ) ) ) . '</span></li>';
		} else if (is_month()){ 
			$month = ( $details['monthnum'] < 10 ) ? '0' . $details['monthnum'] : $details['monthnum'];
			$panListHtml .= '<li><span>' . sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ), strtotime( $details['year'] . '-' . $month . '-01' ) ) ) . '</span></li>';
		}
	} elseif(is_day()) {
		//is_dayの場合
		$query = $wp_query->query_vars;
		if ( empty( $query['post_type'] ) ) {
			//普通の投稿
			if ( $postTopUrl ) {
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url($postTopUrl) . '" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
			} else {
				$panListHtml .= '<li><span>' . $postLabelName . '</span> &raquo; </li>';
			}
		} else {
			//カスタム投稿タイプ
			$current_post_type = get_post_type_object( $query['post_type']);
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . home_url() . '/' . $post_type . '/" itemprop="url"><span itemprop="title">' . $current_post_type->label . '</span></a> &raquo; </li>';
		}
		$panListHtml .= '<li><span>' . sprintf( __( 'Daily Archives: %s', 'biz-vektor' ), date( _x( 'F jS, Y', 'daily archives date format', 'biz-vektor' ), strtotime( $query['year'] . '-' . $query['monthnum'] . '-' . $query['day'] ) ) ) . '</span></li>';
	}
	else{

		$query = $wp_query->query_vars;
		if ( empty( $query['post_type'] ) ) {
			//普通の投稿
			if ( $postTopUrl ) {
				$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url($postTopUrl) . '" itemprop="url"><span itemprop="title">'.$postLabelName.'</span></a> &raquo; </li>';
			} else {
				$panListHtml .= '<li><span>' . $postLabelName . '</span> &raquo; </li>';
			}
		} else {
			//カスタム投稿タイプ
			$current_post_type = get_post_type_object( $query['post_type']);
			$panListHtml .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . home_url() . '/' . $post_type . '/" itemprop="url"><span itemprop="title">' . $current_post_type->label . '</span></a></li>';
		}
	}

}
$panListHtml .= '</ul>';
$panListHtml .= '</div>
</div>
<!-- [ /#panList ] -->
';
$panListHtml = apply_filters( 'bizvektor_panListHtml', $panListHtml );
echo $panListHtml;