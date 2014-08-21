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
/*	Contact widget
/*-------------------------------------------*/
/*	Top Post list widget
/*-------------------------------------------*/
/*	Top Info list widget
/*-------------------------------------------*/
/*	RSS Widget
/*-------------------------------------------*/


/*-------------------------------------------*/
/*	Widget area setting
/*-------------------------------------------*/
function biz_vektor_widgets_init() {
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
		'name' => __( 'Main content(Homepage)', 'biz-vektor' ),
		'id' => 'top-main-widget-area',
		'description' => __( 'This widget area appears on the front page main content area only.', 'biz-vektor' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
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
		$widget_name = get_biz_vektor_name().'_固定ページ子ページリスト';
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
	function form($instance){
	}
	function update($new_instance,$old_instance){
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
		$widget_name = get_biz_vektor_name().'_トップ用_3PR';
		$this->WP_Widget('topPR', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
	//	echo $before_widget;
		get_template_part( 'module_topPR' );
	//	echo $after_widget;
	}
	function form($instance){
	}
	function update($new_instance,$old_instance){
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
			'description' => '固定ページの内容を出力します',
		);
		$widget_name = get_biz_vektor_name().'_トップ用_固定ページ本文';
		$this->WP_Widget('pudge', $widget_name, $widget_ops);
	}

	function widget($args, $instance){
		$this->display_page($instance['page_id'],$instance['set_title']);
	}

	function form($instance){
		$defaults = array(
			'page_id' => 2,
			'set_title' => true
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
		<?php 	$pages = get_pages();	?>
		<label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Display page', 'biz-vektor') ?></label>
		<select name="<?php echo $this->get_field_name('page_id'); ?>" >
		<?php foreach($pages as $page){ ?>
		<option value="<?php echo $page->ID; ?>" <?php if($instance['page_id'] == $page->ID) echo 'selected="selected"'; ?> ><?php echo $page->post_title; ?></option>
		<?php } ?>
		</select>
		<br/>
		<input type="checkbox" name="<?php echo $this->get_field_name('set_title'); ?>" value="true" <?php echo ($instance['set_title'])? 'checked': '' ; ?> >
		<label for="<?php echo $this->get_field_id('set_title'); ?>"> タイトルを表示させる</label>
		</p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['page_id'] = $new_instance['page_id'];
		$instance['set_title'] = ($new_instance['set_title'] == 'true')? true : false;
		return $instance;
	}

	function display_page($pageid,$titleflag=false) {
		$page = get_page($pageid);
		echo '<div id="widget-page-'.$pageid.'" class="sectionBox">';
		if($titleflag){ echo "<h2>".$page->post_title."</h2>"; }
		echo apply_filters('the_content', $page->post_content );
		echo '</div>';
	}
}
add_action('widgets_init', create_function('', 'return register_widget("wp_widget_page");'));

/*-------------------------------------------*/
/*	Contact widget
/*-------------------------------------------*/
class WP_Widget_contact_link extends WP_Widget {
	function WP_Widget_contact_link() {
		$widget_ops = array(
			'classname' => 'WP_Widget_contact_link',
			'description' => __( '*　It is necessary to set the Theme options page.', 'biz-vektor' ),
		);
		$widget_name = get_biz_vektor_name().'_'.__('Contact button', 'biz-vektor');
		$this->WP_Widget('contact_link', $widget_name, $widget_ops);
	}

	function widget($args, $instance) {
		biz_vektor_contactBtn();
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
	}

}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_contact_link");'));

/*-------------------------------------------*/
/*	Top Post list widget
/*-------------------------------------------*/
class WP_Widget_top_list_post extends WP_Widget {
	function WP_Widget_top_list_post() {
		global $biz_vektor_options;
		$biz_vektor_options = biz_vektor_get_theme_options();
		$widget_ops = array(
			'classname' => 'WP_Widget_top_list_post',
			'description' => $biz_vektor_options['postLabelName'].'の新着記事を表示します。',
		);
		$widget_name = get_biz_vektor_name().'_トップ用_'.$biz_vektor_options['postLabelName'].'リスト';
		$this->WP_Widget('top_list_post', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
		// echo $before_widget;
		get_template_part( 'module_top_list_post' );
		// echo $after_widget;
	}
	function form($instance){
	}
	function update($new_instance,$old_instance){
	}
} // class WP_Widget_top_list_post
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_top_list_post");'));

/*-------------------------------------------*/
/*	Top Info list widget
/*-------------------------------------------*/
class WP_Widget_top_list_info extends WP_Widget {
	function WP_Widget_top_list_info() {
		global $biz_vektor_options;
		$biz_vektor_options = biz_vektor_get_theme_options();
		$widget_ops = array(
			'classname' => 'WP_Widget_top_list_info',
			'description' => $biz_vektor_options['infoLabelName'].'の新着記事を表示します。',
		);
		$widget_name = get_biz_vektor_name().'_トップ用_'.$biz_vektor_options['infoLabelName'].'リスト';
		$this->WP_Widget('top_list_info', $widget_name, $widget_ops);
	}
	function widget($args, $instance) {
		// echo $before_widget;
		get_template_part( 'module_top_list_info' );
		// echo $after_widget;
	}
	function form($instance){
	}
	function update($new_instance,$old_instance){
	}
} // class WP_Widget_top_list_info
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_top_list_info");'));

/*-------------------------------------------*/
/*	RSS widget
/*-------------------------------------------*/
class wp_widget_bektor_rss extends WP_Widget {
	function wp_widget_bektor_rss() {
		$widget_ops = array(
			'classname' => 'wp_widget_bektor_rss',
			//'description' => __( 'this is RSS', 'biz-vektor' ),
			'description' => 'RSSエントリーを設置します',
		);
		$widget_name = get_biz_vektor_name().'_トップ用_RSSエントリー';
		$this->WP_Widget('rsswidget', $widget_name, $widget_ops);
	}
    function widget($args, $instance){
    	$options = biz_vektor_get_theme_options();
		if(preg_match('/^http.*$/',$instance['url'])){
			echo '<div id="rss_widget">';
			biz_vektor_blogList($instance);
			echo '</div>';
		}
    }
    function form($instance){
        $defaults = array(
            'url' => '',
            'label' => 'ブログエントリー',
		);
		$instance = wp_parse_args((array) $instance, $defaults);

		?>
		<Label for="<?php echo $this->get_field_id('url');  ?>">見出しタイトル</label><br/>
		<input type="text" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" />
		<br/>
		<Label for="<?php echo $this->get_field_id('url');  ?>">URL</label><br/>
		<input type="text" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $instance['url']; ?>" />
		<?php
    }
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['url'] = $new_instance['url'];
		$instance['label'] = $new_instance['label'];
        return $instance;
    }
}
add_action('widgets_init', create_function('', 'return register_widget("wp_widget_bektor_rss");'));
