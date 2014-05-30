<?php

/*-------------------------------------------*/
/*	Custom post type _ add info
/*-------------------------------------------*/
/*	widget setting
/*-------------------------------------------*/
/*	WP_Widget_infoTerms Class
/*-------------------------------------------*/
/*	WP_Widget_infoArchives Class
/*-------------------------------------------*/

/*-------------------------------------------*/
/*	Custom post type _ add info
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
	'supports' => array('title','editor','excerpt','thumbnail','author')
	)
	);
	// Add information category
	register_taxonomy(
		'info-cat',
		'info',
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => $infoLabelName._x('category','admin menu', 'biz-vektor'),
			'singular_label' => $infoLabelName._x('category','admin menu', 'biz-vektor'),
			'public' => true,
			'show_ui' => true,
		)
	);
	}

add_action( 'generate_rewrite_rules', 'my_rewrite' );
function my_rewrite( $wp_rewrite ){
    $taxonomies = get_taxonomies();
    // exclude default post types [category,post_tag,nav_menu,link_category ]
    $taxonomies = array_slice($taxonomies,4,count($taxonomies)-1);
    foreach ( $taxonomies as $taxonomy ) :
        $post_types = get_taxonomy($taxonomy)->object_type;
        foreach ($post_types as $post_type){
        	$new_rules[$post_type.'/'.$taxonomy.'/([^/]+)/page/?([0-9]{1,})/?$'] = 'index.php?'.$taxonomy.'=$matches[1]&paged=$matches[2]';
            $new_rules[$post_type.'/'.$taxonomy.'/(.+?)/?$'] = 'index.php?taxonomy='.$taxonomy.'&term='.$wp_rewrite->preg_index(1);
        }
        $wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);
     endforeach;
}

/*		Archive of custom post type
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
function my_get_archives_link($link_html) {
    global $my_archives_post_type;
    if ($my_archives_post_type != '') {
        $add_link = '?post_type=' . $my_archives_post_type;
        $link_html = preg_replace("/href=\'(.+)\'/", "href='$1" . $add_link. "'", $link_html);
    }
    return $link_html;
}

/*-------------------------------------------*/
/*	widget setting
/*-------------------------------------------*/
function biz_vektor_info_widgets_init() {
	register_sidebar( array(
		// 'name' => __( 'Sidebar(Front page only)', 'biz-vektor' ),
		'name' => sprintf( __( 'Sidebar(%s content only)', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
		'id' => 'info-widget-area',
		'description' => sprintf( __( 'This widget area appears only on the %s content pages.', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'biz_vektor_info_widgets_init' );


/*-------------------------------------------*/
/*	WP_Widget_infoTerms Class
/*-------------------------------------------*/

class WP_Widget_infoTerms extends WP_Widget {
	/** constructor */
	function WP_Widget_infoTerms() {
		$widget_ops = array(
			'classname' => 'WP_Widget_infoTerms',
			'description' => sprintf( __( 'Category list of %s', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
		);
		$widget_name = sprintf( __( '%s category', 'biz-vektor' ),bizVektorOptions('infoLabelName') ).' ('.get_biz_vektor_name().')';
		$this->WP_Widget('infoTerms', $widget_name, $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$args = array(
			'show_option_none'		=> '',
			'title_li'				=> '',
			'taxonomy' 				=> 'info-cat',
			'orderby'				=> 'order',
			'echo'					=> 0    /* 直接出力させない為 */
		);
		$catlist = wp_list_categories( $args );
		if ( !empty($catlist) ) { ?>
			<div class="localSection sideWidget">
			<div class="localNaviBox">
			<h3 class="localHead"><?php _e('Category', 'biz-vektor'); ?></h3>
			<ul class="localNavi">
		    <?php echo $catlist; ?>
			</ul>
			</div>
			</div>
		<?php }
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		/*
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php
		*/
	}

} // class WP_Widget_infoTerms

// register WP_Widget_infoTerms widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_infoTerms");'));

/*-------------------------------------------*/
/*	WP_Widget_infoArchives Class
/*-------------------------------------------*/

class WP_Widget_infoArchives extends WP_Widget {
	/** constructor */
	function WP_Widget_infoArchives() {
		$widget_ops = array(
			'classname' => 'WP_Widget_infoArchives',
			'description' => sprintf( __( 'Yearly archives of %s', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
		);
		$widget_name = sprintf( __( '%s Yearly archives', 'biz-vektor' ),bizVektorOptions('infoLabelName') ).' ('.get_biz_vektor_name().')';
		$this->WP_Widget('infoArchives', $widget_name, $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
?>
	<div class="localSection sideWidget">
	<div class="localNaviBox">
	<h3 class="localHead"><?php _e('Yearly archives', 'biz-vektor'); ?></h3>
	<ul class="localNavi">
	<?php
	$args = array(
		'type' => 'yearly',
		'post_type' => 'info',
		'after' => _x('&nbsp;', 'After year','biz-vektor')
		);
	wp_get_archives($args); ?>
	</ul>
	</div>
	</div>
<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

	}

} // class WP_Widget_infoArchives

// register WP_Widget_infoArchives widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_infoArchives");'));