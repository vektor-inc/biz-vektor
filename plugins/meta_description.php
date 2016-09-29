<?php

/*-------------------------------------------*/
/*  head_description
/*-------------------------------------------*/
add_action( 'wp_head', 'biz_vektor_setHeadDescription', 5 );
function biz_vektor_setHeadDescription(){
    echo '<meta name="description" content="' . getHeadDescription() . '" />'."\n";
}


function getHeadDescription() {
    global $wp_query;
    $post = $wp_query->get_queried_object();
    if ( is_front_page() ) {
        if ( isset($post->post_excerpt) && $post->post_excerpt ) {
            $metadescription = get_the_excerpt();
        } else {
            $metadescription = get_bloginfo( 'description' );
        }
    } else if ( is_home() ) {
        $page_for_posts = biz_vektor_get_page_for_posts();
        if ( $page_for_posts['post_top_use'] ){
            $page = get_post($page_for_posts['post_top_id']);
            $metadescription = $page->post_excerpt;
        } else {
            $metadescription = get_bloginfo( 'description' );
        }
    } else if (is_category() || is_tax()) {
        if ( ! $post->description ) {
            $metadescription = sprintf(__('About %s', 'biz-vektor'),single_cat_title( '' , false )).get_bloginfo('name').' '.get_bloginfo('description');
        } else {
            $metadescription = $post->description;
        }
    } else if (is_tag()) {
        $metadescription = tag_description();
        $metadescription = str_replace(array("\r\n","\r","\n"), '', $metadescription);  // delete br
        if ( ! $metadescription ) {
            $metadescription = sprintf(__('About %s', 'biz-vektor'),single_tag_title( '' , false )).get_bloginfo('name').' '.get_bloginfo('description');
        }
    } else if (is_archive()) {
        if (is_year()){
            $description_date = get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) );
            $metadescription = sprintf(_x('Article of %s.','Yearly archive description', 'biz-vektor'), $description_date );
            $metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
        } else if (is_month()){
            $description_date = get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) );
            $metadescription = sprintf(_x('Article of %s.','Archive description', 'biz-vektor'),$description_date );
            $metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
        } else if (is_author()) {
            $userObj = get_queried_object();
            $metadescription = sprintf(_x('Article of %s.','Archive description', 'biz-vektor'),esc_html($userObj->display_name) );
            $metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
        } else if (is_search()) {
            $metadescription = get_bloginfo('name').' '.get_bloginfo('description');
        } else {
            $postType = get_post_type();
            $metadescription = sprintf(_x('Article of %s.','Archive description', 'biz-vektor'),esc_html(get_post_type_object($postType)->labels->name) );
            $metadescription .= ' '.get_bloginfo('name').' '.get_bloginfo('description');
        }
    } else if (is_page() || is_single()) {
        $metaExcerpt = $post->post_excerpt;
        if ($metaExcerpt) {
            // $metadescription = strip_tags($post->post_excerpt);
            $metadescription = $post->post_excerpt;
        } else {
            $metadescription = mb_substr( strip_tags($post->post_content), 0, 240 ); // kill tags and trim 240 chara
        }
    } else {
        $metadescription = get_bloginfo('description');
    }

    global $paged;
    if ( $paged != '0'){
        $metadescription = '['.sprintf(__('Page of %s', 'biz-vektor' ),$paged).'] '.$metadescription;
    }
    if( empty( $metadescription ) ) $metadescription = get_bloginfo('description');
    $metadescription = str_replace(array("\r\n","\r","\n"), '', $metadescription);  // delete br
    $metadescription = apply_filters( 'metadescriptionCustom', strip_tags($metadescription) );

    return $metadescription;
}