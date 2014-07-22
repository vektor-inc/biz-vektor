<?php

/*-------------------------------------------*/
/*	Widget area setting
/*-------------------------------------------*/
/*	ChildPageList widget
/*-------------------------------------------*/
/*	Top PR widget
/*-------------------------------------------*/
/*	Page widget
/*-------------------------------------------*/
/*	Top Post list widget
/*-------------------------------------------*/
/*	Top Info list widget
/*-------------------------------------------*/

/*-------------------------------------------*/
/*	Widget area setting
/*-------------------------------------------*/
function biz_vektor_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Homepage main content', 'biz-vektor' ),
		'id' => 'top-main-widget-area',
		'description' => __( 'This widget area appears on the front page main content area only.', 'biz-vektor' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Front page only)', 'biz-vektor' ),
		'id' => 'top-side-widget-area',
		'description' => __( 'This widget area appears on the front page only.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Post content only)', 'biz-vektor' ),
		'id' => 'post-widget-area',
		'description' => __( 'This widget area appears only on the post content pages.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Page content only)', 'biz-vektor' ),
		'id' => 'page-widget-area',
		'description' => __( 'This widget area appears only on the page content pages.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Common top)', 'biz-vektor' ),
		'id' => 'common-side-top-widget-area',
		'description' => __( 'This widget area appears at top of sidebar.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar(Common bottom)', 'biz-vektor' ),
		'id' => 'common-side-bottom-widget-area',
		'description' => __( 'This widget area appears at bottom of sidebar.', 'biz-vektor' ),
		'before_widget' => '<div class="sideWidget" id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="localHead">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'biz_vektor_widgets_init' );

/*-------------------------------------------*/
/*	ChildPageList widget
/*-------------------------------------------*/
class WP_Widget_ChildPageList extends WP_Widget {
	function WP_Widget_childPageList() {
		$widget_ops = array(
			'classname' => 'WP_Widget_childPageList',
			'description' => '表示している固定ページが属する階層のページリストを表示',
		);
		$widget_name = '固定ページ子ページリスト'.' ('.get_biz_vektor_name().')';
		$this->WP_Widget('childPageList', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
		extract( $args );
		if(biz_vektor_childPageList()){
			echo $before_widget;
			biz_vektor_childPageList();
			echo $after_widget;
		}
	}

} // class WP_Widget_childPageList
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_childPageList");'));

/*-------------------------------------------*/
/*	Top PR widget
/*-------------------------------------------*/
class WP_Widget_topPR extends WP_Widget {
	function WP_Widget_topPR() {
		$widget_ops = array(
			'classname' => 'WP_Widget_topPR',
			'description' => 'トップページの３PRエリアウィジェットです。※サイドバーでは正しく表示されません。',
		);
		$widget_name = 'トップページ3PR'.' ('.get_biz_vektor_name().')';
		$this->WP_Widget('topPR', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
		echo $before_widget;
		get_template_part( 'module_topPR' );
		echo $after_widget;
	}
} // class WP_Widget_topPR
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_topPR");'));

/*-------------------------------------------*/
/*	page widget
/*-------------------------------------------*/
class wp_widget_page extends WP_Widget {
	function wp_widget_page() {
		$widget_ops = array(
			'classname' => 'WP_Widget_page_post',
			'description' => '固定ページの出力'
		);
		$widget_name = '固定ページ本文'.' ('.get_biz_vektor_name().')';
		$this->WP_Widget('pudge', $widget_name, $widget_ops);
	}

	function widget($args, $instance){
		$this->display_page($instance['page_id']);
	}

	function form($instance){
		$defaults = array(
			'page_id' => 2
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
		<?php 	$pages = get_pages();	?>
		<label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Title', 'biz-vektor') ?></label>
		<select name="<?php echo $this->get_field_name('page_id'); ?>" >
		<?php foreach($pages as $page){ ?>
		<option value="<?php echo $page->ID; ?>" <?php if($instance['page_id'] == $page->ID) echo 'selected="selected"'; ?> ><?php echo $page->post_title; ?></option>
		<?php } ?>
		</select>
		</p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['page_id'] = $new_instance['page_id'];
		return $instance;
	}

	function display_page($pageid) {
		$page = get_page($pageid);
		echo $page->post_content;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("wp_widget_page");'));



/*-------------------------------------------*/
/*	Top Post list widget
/*-------------------------------------------*/
class WP_Widget_top_list_post extends WP_Widget {
	function WP_Widget_top_list_post() {
		$widget_ops = array(
			'classname' => 'WP_Widget_top_list_post',
			'description' => '投稿の新着記事を表示します。',
		);
		$widget_name = 'トップページ用投稿リスト'.' ('.get_biz_vektor_name().')';
		$this->WP_Widget('top_list_post', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
		echo $before_widget;
		get_template_part( 'module_top_list_post' );
		echo $after_widget;
	}
} // class WP_Widget_top_list_post
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_top_list_post");'));

/*-------------------------------------------*/
/*	Top Info list widget
/*-------------------------------------------*/
class WP_Widget_top_list_info extends WP_Widget {
	function WP_Widget_top_list_info() {
		$widget_ops = array(
			'classname' => 'WP_Widget_top_list_info',
			'description' => '投稿の新着記事を表示します。',
		);
		$widget_name = 'トップページ用infoリスト'.' ('.get_biz_vektor_name().')';
		$this->WP_Widget('top_list_info', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
		echo $before_widget;
		get_template_part( 'module_top_list_info' );
		echo $after_widget;
	}
} // class WP_Widget_top_list_info
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_top_list_info");'));
