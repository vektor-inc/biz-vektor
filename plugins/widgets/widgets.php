<?php
/**
 * BizVektor widgets.php
 *
 * @package BizVektor
 * @version 1.6.0
 */

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
/*	Archive list widget
/*-------------------------------------------*/
/*	Taxonomy list widget
/*-------------------------------------------*/
/*	RSS Widget
/*-------------------------------------------*/
/*	Side Post list widget
/*-------------------------------------------*/


add_action( 'widgets_init', 'biz_vektor_register_widgets' );


function biz_vektor_register_widgets(){
    register_widget("WP_Widget_ChildPageList");
    register_widget("WP_Widget_topPR");
    register_widget("wp_widget_page");
    register_widget("WP_Widget_contact_link");
    register_widget("WP_Widget_top_list_post");
    register_widget("WP_Widget_archive_list");
    register_widget("WP_Widget_taxonomy_list");
    register_widget("WP_Widget_bizvektor_post_list");
    if( function_exists( 'wp_safe_remote_get' ) )
	    register_widget("wp_widget_bizvektor_rss");
}


/*-------------------------------------------*/
/*	ChildPageList widget
/*-------------------------------------------*/
class WP_Widget_ChildPageList extends WP_Widget {

	function __construct() {
		$widget_name = biz_vektor_get_short_name() . '_' . __( 'child pages list', 'biz-vektor' );

		parent::__construct(
			'childPageList',
			$widget_name,
			array( 'description' => __( 'Displays list of child page for the current page.', 'biz-vektor' ) )
		);
	}

	function widget($args, $instance) {
		if( biz_vektor_childPageList() ){
			echo $args['before_widget'];
			biz_vektor_childPageList();
			echo $args['after_widget'];
		}
	}

	function form($instance){
?>
<p>固定ページの子ページリストです。</p>
<p>固定ページの詳細ページが表示されている場合に現在のページの階層一覧が表示されます。</p>
<p>※ 固定ページの詳細ページ以外や、階層構造が存在しない場合は何も表示されません。<br/>
※ サイドバー(固定ページ)への設置推奨</p>
<?php
	}

	function update($new_instance,$old_instance){
		return $new_instance;
	}

}

/*-------------------------------------------*/
/*	Top PR widget
/*-------------------------------------------*/
class WP_Widget_topPR extends WP_Widget {

	function __construct() {
		$widget_name = biz_vektor_get_short_name() . '_' . __( '3PR for top', 'biz-vektor' );

		parent::__construct(
			'topPR',
			$widget_name,
			array( 'description' => __( 'Displays 3PR area on the top page (does not adapt well on the sidebar).', 'biz-vektor' ) )
		);
	}

	function widget($args, $instance) {
		get_template_part( 'module_topPR' );
	}

	function form($instance){
?>
<p>3PRを表示します。</p>
<p><a href="<?php echo admin_url(); ?>/themes.php?page=theme_options#prBox" target="_blank" >テーマオプション</a>
で設定した内容を表示します。</p>
<p>※ テーマオプションの「3PRエリアの表示設定は反映されません。<br/>
※ コンテンツエリア（トップページ）への設置推奨</p>
<?php
	}

	function update($new_instance,$old_instance){
		return $new_instance;
	}

}

/*-------------------------------------------*/
/*	page widget
/*-------------------------------------------*/
class wp_widget_page extends WP_Widget {

	function __construct() {

		$widget_name = biz_vektor_get_short_name() . '_' . __( 'page content for top', 'biz-vektor' );
 parent::__construct('pudge',
			$widget_name,
			array( 'description' => __( 'Displays the content of a chosen page.', 'biz-vektor' ) )
		);
	}

	function standardization( $instance=array() ) {
		$defaults = array(
			'page_id' => null,
			'set_title' => true
		);

		$instance = wp_parse_args((array)$instance, $defaults);

		if( empty($instance['page_id'] ) ){
			$_p = $this->get_pages();
			if( $_p ) $instance['page_id'] = $_p[0]->ID;
		}
		return $instance;
	}

	function get_pages( $args=array() ) {
		$defaults = array(
		);
		return get_posts( wp_parse_args( (array)$args, $defaults) );
	}

	function widget($args, $instance){
		global $is_pagewidget;
		$is_pagewidget = true;
		$instance = $this->standardization( $instance );
		if( !empty($instance['page_id'] ) ) $this->display_page($instance['page_id'], $instance['set_title']);
		$is_pagewidget = false;
	}

	function form($instance){
		$instance = $this->standardization( $instance );

		?>
		<p>
		<?php 	$pages = get_pages();	?>
<label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Display page', 'biz-vektor') ?> :</label>
<select name="<?php echo $this->get_field_name('page_id'); ?>" >
		<?php foreach($pages as $page){ ?>
<option value="<?php echo $page->ID; ?>" <?php if($instance['page_id'] == $page->ID) echo 'selected="selected"'; ?> ><?php echo $page->post_title; ?></option>
		<?php } ?>
</select>
</p><p>
<input type="checkbox" name="<?php echo $this->get_field_name('set_title'); ?>" value="true" <?php echo ($instance['set_title'])? 'checked': '' ; ?> id="<?php echo $this->get_field_id('set_title'); ?>" />
<label for="<?php echo $this->get_field_id('set_title'); ?>"> <?php _e( 'display title', 'biz-vektor' ); ?></label>
</p>
<hr/>
<p>固定ページの本文を表示します。</p>
<p>※ コンテンツエリア（トップページ）への設置推奨</p>
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
		if ( is_user_logged_in() == TRUE ) {

			if ( current_user_can('activate_plugins') ) {
				?>
				<div class="adminEdit">
				<?php edit_post_link( '['.__('Edit', 'biz-vektor').']', '<span class="btn btnS btnAdmin">', '</span>', $pageid); ?>
				</div>
			<?php } }
		echo '</div>';
	}
}

/*-------------------------------------------*/
/*	Contact widget
/*-------------------------------------------*/
class WP_Widget_contact_link extends WP_Widget {

	function __construct() {
		$widget_name = biz_vektor_get_short_name().'_'.__('Contact button', 'biz-vektor');

		parent::__construct(
			'contact_link',
			$widget_name,
			array( 'description' => __( '*　It is necessary to set the Theme options page.', 'biz-vektor' ) )
		);
	}

	function widget($args, $instance) {
		biz_vektor_contactBtn();
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
?>
<p>「お問い合わせはこちら」のボタンを表示します。</p>
<p>※ <a href="<?php echo admin_url(); ?>/themes.php?page=theme_options#contactInfo" target="_blank" >テーマオプション</a>
の「問い合わせページのURL」の入力がない場合は表示されません。<br/>
※ サイドバーへの設置を推奨</p>
<?php
		return $instance;
	}

}

/*-------------------------------------------*/
/*	Top Post list widget
/*-------------------------------------------*/
class WP_Widget_top_list_post extends WP_Widget {

	function __construct() {
		$biz_vektor_options = biz_vektor_get_theme_options();

		$widget_name = biz_vektor_get_short_name() . '_' . sprintf( __( '%1$s list for top', 'biz-vektor' ), $biz_vektor_options['postLabelName'] );

		parent::__construct(
			'top_list_post',
			$widget_name,
			array( 'description' => sprintf( __( 'Displays recent %1$s posts.', 'biz-vektor' ), $biz_vektor_options['postLabelName'] ) )
		);
	}

	function widget($args, $instance) {
		// echo $before_widget;
		get_template_part( 'module_top_list_post' );
		// echo $after_widget;
	}

	function form($instance){
?>
<p>投稿リストを表示します。</p>
<p>※ 表示レイアウトは<a href="<?php echo admin_url(); ?>/themes.php?page=theme_options#postSetting" target="_blank" >テーマオプション</a>
の「ブログ のトップページでの表示レイアウト」に準じます。<br/>
※ コンテンツエリア（トップページ）への設置推奨</p>
<?php
	}

	function update($new_instance,$old_instance){
		return $new_instance;
	}
} // class WP_Widget_top_list_post


/*-------------------------------------------*/
/*	Archive list widget
/*-------------------------------------------*/
class WP_Widget_archive_list extends WP_Widget {
	// ウィジェット定義
	function __construct() {
		$widget_name = biz_vektor_get_short_name() . '_' . __( 'archive list', 'biz-vektor' );

		parent::__construct(
			'WP_Widget_archive_list',
			$widget_name,
			array( 'description' => __( 'Displays a list of archives. You can choose the post type and also to display archives by month or by year.' , 'biz-vektor' ) )
		);
	}

	function standardization( $instance=array() ) {
		$defaults = array(
			'post_type' => 'post',
			'display_type' => 'm',
			'label' => __( 'archives', 'biz-vektor' ),
			'hide' => __( 'archives', 'biz-vektor' ),
		);

		return wp_parse_args((array)$instance, $defaults);
	}

	function widget($args, $instance) {
		$instance = $this->standardization($instance);

		$arg = array(
			'echo' => 1,
			);

		if($instance['display_type'] == 'y'){
			$arg['type'] = "yearly";
			$arg['post_type'] = $instance['post_type'];
			$arg['after'] = '年';
		}
		else{
			$arg['type'] = "monthly";
			$arg['post_type'] = $instance['post_type'];
		}

	?>
	<div class="localSection sideWidget">
	<div class="sectionBox">
		<h3 class="localHead"><?php echo $instance['label']; ?></h3>
		<ul class="localNavi">
			<?php wp_get_archives($arg); ?>
		</ul>
	</div>
	</div>
	<?php
	}

	function form($instance){
		$instance = $this->standardization($instance);

		$pages = get_post_types( array('public'=> true, '_builtin' => false),'names');
		$pages[] = 'post';
		?>
<p>
<label for="<?php echo $this->get_field_id('label'); ?>-title"><?php _e('Title','biz-vektor');?> : </label>
<input type="text" id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" ><br/>
<input type="hidden" name="<?php echo $this->get_field_name('hide'); ?>" ><br/>

<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post type', 'biz-vektor' ) ?> : </label>
<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>" >
<?php foreach($pages as $page){ ?>
<option value="<?php echo $page; ?>" <?php if($instance['post_type'] == $page) echo 'selected="selected"'; ?> ><?php echo $page; ?></option>
<?php } ?>
</select>
<br/>
<label for="<?php echo $this->get_field_id('display_type'); ?>"><?php _e('Display Type', 'biz-vektor'); ?> : </label>
<select name="<?php echo $this->get_field_name('display_type'); ?>" id="<?php echo $this->get_field_id('display_type'); ?>">
	<option value="m" <?php if($instance['display_type'] != "y") echo 'selected="selected"'; ?> >月別</option>
	<option value="y" <?php if($instance['display_type'] == "y") echo 'selected="selected"'; ?> >年別</option>
</select>
</p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['post_type'] = $new_instance['post_type'];
		$instance['display_type'] = $new_instance['display_type'];
		if(!$new_instance['label']){
			$new_instance['label'] = $new_instance['hide'];
		}
		$instance['label'] = $new_instance['label'];
		return $instance;
	}
}



/*-------------------------------------------*/
/*	Taxonomy list widget
/*-------------------------------------------*/
class WP_Widget_taxonomy_list extends WP_Widget {
	// ウィジェット定義
	function __construct() {
		$lab = get_biz_vektor_name();
		if($lab == 'BizVektor'){
			$lab = 'BV';
		}
		$widget_name = $lab . '_' . __( 'categories/tags list', 'biz-vektor' );

		parent::__construct(
			'WP_Widget_taxonomy_list',
			$widget_name,
			array( 'description' => __( 'Displays a categories, tags or format list.', 'biz-vektor' ) )
		);
	}

	function standardization( $instance=array() ) {
		$defaults = array(
			'tax_name'     => 'category',
			'label'        => __( 'Category', 'biz-vektor' ),
			'hide'         => __( 'Category', 'biz-vektor' ),
			'title'		   => 'test',
			'_builtin'	=> false,
		);
		return wp_parse_args((array)$instance, $defaults);
	}

	function widget($args, $instance) {
		$instance = $this->standardization($instance);

		$arg = array(
			'echo'               => 1,
			'style'              => 'list',
			'show_count'         => false,
			'show_option_all'    => false,
			'hierarchical'       => true,
			'title_li'           => '',
			);

		$arg['taxonomy'] = $instance['tax_name'];

	?>
	<div class="localSection sideWidget">
	<div class="sectionBox">
		<h3 class="localHead"><?php echo $instance['label']; ?></h3>
		<ul class="localNavi">
			<?php wp_list_categories($arg); ?>
		</ul>
	</div>
	</div>
	<?php
	}

	function form($instance){
		$instance = $this->standardization($instance);

		$taxs = get_taxonomies( array('public'=> true,'show_ui' => true),'objects');
		?>
<p>
<label for="<?php echo $this->get_field_id('label'); ?>"><?php _e( 'Label to display', 'biz-vektor' ); ?></label>
<input type="text"  id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" ><br/>
<input type="hidden" name="<?php echo $this->get_field_name('hide'); ?>" ><br/>

<label for="<?php echo $this->get_field_id('tax_name'); ?>"><?php _e('Display Taxonomy', 'biz-vektor') ?></label>
<select name="<?php echo $this->get_field_name('tax_name'); ?>" >
<?php foreach($taxs as $tax){ ?>
	<option value="<?php echo $tax->name; ?>" <?php if($instance['tax_name'] == $tax->name) echo 'selected="selected"'; ?> ><?php echo $tax->labels->name; ?></option>
<?php } ?>
</select></p>
<script type="text/javascript">
jQuery(document).ready(function($){
	var post_labels = new Array();
			<?php
				foreach($taxs as $tax){
					if(isset($tax->labels->name)){
						echo 'post_labels["'.$tax->name.'"] = "'.$tax->labels->name.'";';
					}
				}
				echo 'post_labels["blog"] = "'. __( 'Blog', 'biz-vektor' ) . '";'."\n";
			?>
	var posttype = jQuery("[name=\"<?php echo $this->get_field_name('tax_name'); ?>\"]");
	var lablfeld = jQuery("[name=\"<?php echo $this->get_field_name('label'); ?>\"]");
	posttype.change(function(){
		lablfeld.val(post_labels[posttype.val()]+" <?php _e( 'Archives', 'biz-vektor' ) ?>");
	});
});
</script>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['tax_name'] = $new_instance['tax_name'];
		if(!$new_instance['label']){
			$new_instance['label'] = $new_instance['hide'];
		}
		$instance['label'] = esc_html($new_instance['label']);
		return $instance;
	}
} // class WP_Widget_top_list_info

/*-------------------------------------------*/
/*	RSS widget
/*-------------------------------------------*/
class wp_widget_bizvektor_rss extends WP_Widget {

	function __construct() {

		$widget_name = biz_vektor_get_short_name().'_' . __( 'RSS entries for top', 'biz-vektor' );

		parent::__construct(
			'rsswidget',
			$widget_name,
			array( 'description' => __( 'Displays entries list from a RSS feed link.', 'biz-vektor' ) )
		);
	}

	function standardization( $instance=array() ) {
		$defaults = array(
			'url'       => 'https://bizvektor.com/feed/?post_type=info',
			'label'     => 'BizVektorからのお知らせ',
		);
		return wp_parse_args((array)$instance, $defaults);
	}

	function widget($args, $instance){
		$instance = $this->standardization( $instance );
		$options = biz_vektor_get_theme_options();
		if(preg_match('/^http.*$/',$instance['url'])){
			echo '<div id="rss_widget">';
			biz_vektor_blogList($instance);
			echo '</div>';
		}
	}

	function form( $instance ){
		$instance = $this->standardization( $instance );

		?>
<Label for="<?php echo $this->get_field_id('label'); ?>"><?php _e( 'Heading title', 'biz-vektor' ) ?></label><br/>
<input type="text" id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" />
<br/>
<Label for="<?php echo $this->get_field_id('url'); ?>">URL</label><br/>
<input type="text" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $instance['url']; ?>" />
<p></p>
<p>外部ブログなどにRSS機能がある場合、RSSのURLを入力することにより一覧を表示することができます。</p>
<p>URLの先がRSSでなかったりと正しくない場合は何も表示されません。<br/>
RSSページの接続が遅い場合はウィジェットの表示速度もそのまま遅くなるのでURLの設定には注意を払う必要があります。</p>
<p>※ コンテンツエリア（トップページ）への設置推奨</p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['url'] = $new_instance['url'];
		$instance['label'] = $new_instance['label'];
		return $instance;
	}
}



/*-------------------------------------------*/
/*	Side Post list widget
/*-------------------------------------------*/
class WP_Widget_bizvektor_post_list extends WP_Widget {

	function __construct() {
		$widget_name = biz_vektor_get_short_name(). '_' . __( 'Recent Posts', 'biz-vektor' );

		parent::__construct(
			'bizvektor_post_list',
			$widget_name,
			array( 'description' => __( 'Displays a list of your most recent posts', 'biz-vektor' ) )
		);
	}

	function widget($args, $instance) {

		$count 		= ( isset($instance['count']) && $instance['count'] ) ? $instance['count'] : 10;
		$post_type 	= ( isset($instance['post_type']) && $instance['post_type'] ) ? $instance['post_type'] : 'post';

		$query_args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'paged' => 1,
		);

		if(isset($instance['terms']) && $instance['terms']){
			$taxonomies = get_taxonomies(array());

			$query_args['tax_query'] = array(
				'relation' => 'OR',
			);

			foreach($taxonomies as $taxonomy){
			$query_args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field' => 'id',
					'terms' => $instance['terms']
				);
			}
		}
		$posts = get_posts( $query_args );

		echo $args['before_widget'];

		$title_html = '';
		if ( isset( $instance['label'] ) && $instance['label'] ) {
			$title_html .= $args['before_title'];
			$title_html .= $instance['label'];
			$title_html .= $args['after_title'];
		}

		if( ! empty( $posts ) ):
			if ( !isset( $instance['format'] ) || !$instance['format'] ){
				echo $title_html;
				$this->display_pattern_0($posts);
			} elseif ( $instance['format'] == '1' ) {
				echo '<div class="infoList">';
				echo $title_html;
				$this->display_pattern_1($posts);
				echo '</div>';
			} elseif ( $instance['format'] == '2' ) {
				echo '<div class="infoList">';
				echo $title_html;
				$this->display_pattern_2($posts);
				echo '</div>';
			}
		endif;

		echo $args['after_widget'];

		wp_reset_postdata();
		wp_reset_query();

	}

	function display_pattern_0($posts){
		echo '<div class="ttBoxSection">';
		foreach( $posts as $post ): ?>
				<div class="ttBox" id="post-<?php the_ID($post->ID); ?>">
				<?php if ( has_post_thumbnail($post->ID)) : ?>
					<div class="ttBoxTxt ttBoxRight"><a href="<?php the_permalink($post->ID);?>"><?php echo strip_tags( get_the_title($post->ID) ); ?></a></div>
					<div class="ttBoxThumb ttBoxLeft"><a href="<?php the_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail($post->ID); ?></a></div>
				<?php else : ?>
					<div>
						<a href="<?php the_permalink($post->ID);?>"><?php echo strip_tags( get_the_title($post->ID) ); ?></a>
					</div>
				<?php endif; ?>
				</div>
			<?php
		endforeach;
		echo '</div>';
	}

	function display_pattern_1($posts){
		global $post;
		echo '<ul class="entryList">';
		foreach( $posts as $post ):
			setup_postdata( $post );
			get_template_part('module_loop_post');
		endforeach;
		echo '</ul>';
	}

	function display_pattern_2($posts){
		global $post;
		foreach( $posts as $post ):
			setup_postdata( $post );
			get_template_part('module_loop_post2');
		endforeach;
	}

	function form ($instance) {

		$defaults = array(
			'count' 	=> 10,
			'label' 	=> __('Recent Posts', 'biz-vektor' ),
			'post_type' => 'post',
			'terms'     => ''
		);
		$instance = wp_parse_args((array) $instance, $defaults);


		$post_types = get_post_types( array(
			'public' => true,
			'show_ui' => true,
			'_builtin' => false
		));
		$post_types[] = 'post';
		if( !in_array( $instance['post_type'], $post_types ) ) $post_types[] = $instance['post_type'];
		?>
<label for="<?php echo $this->get_field_id('label');  ?>"><?php _e('Title:'); ?></label><br/>
<input type="text" id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" />
<br/><br/>

<label for="<?php echo $this->get_field_id('count');  ?>"><?php _e('Display count','biz-vektor'); ?>:</label><br/>
<input type="text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
<br /><br/>

<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('post type', 'biz-vektor') ?>:</label><br />
<select type="text" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>"  >
<?php foreach($post_types as $posttype): ?>
	<option value="<?php echo $posttype; ?>" <?php if($instance['post_type'] == $posttype) echo "selected"; ?> ><?php echo $posttype; ?></option>
<?php endforeach; ?>
</select>
</Label>
<br/><br/>


<label for="<?php echo $this->get_field_id('terms'); ?>"><?php _e('taxonomy ID', 'biz-vektor') ?>:</label><br />
<input type="text" id="<?php echo $this->get_field_id('terms'); ?>" name="<?php echo $this->get_field_name('terms'); ?>" value="<?php echo esc_attr($instance['terms']) ?>" /><br />
		<?php _e('if you need filtering by term, add the term ID separate by ",".', 'biz-vektor');
		echo "<br/>";
		_e('if empty this area, I will do not filtering.', 'biz-vektor');
		echo "<br/><br/>";

		echo _e( 'Display Format', 'biz-vektor' ); ?>:<br/>
		<ul>
		<?php $format = ( !isset( $instance['format'] ) || !$instance['format'] ) ? 0 : $instance['format']; ?>
		<li><label><input type="radio" name="<?php echo $this->get_field_name( 'format' );  ?>" value="0" <?php if ( $format == 0 ) { echo 'checked'; } ?>/>
			<?php echo __( 'Thumbnail / Title <br>( Sidebar )', 'biz-vektor' ) ; ?></label>
		</li>
		<li><label><input type="radio" name="<?php echo $this->get_field_name( 'format' );  ?>" value="1" <?php if ( $format == 1 ) { echo 'checked'; } ?>/>
			<?php echo __( 'Date / Category / Title <br>( Main contents area )', 'biz-vektor' ) ; ?></label>
		</li>
		<li><label><input type="radio" name="<?php echo $this->get_field_name( 'format' );  ?>" value="2" <?php if ( $format == 2 ) { echo 'checked'; } ?>/>
			<?php echo __( 'Date / Category / Title / Excerpt / Thumbnail <br>( Main contents area )', 'biz-vektor' ) ; ?></label>
		</li>
		</ul>
<?php

	}

	function update ($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['count'] 		= $new_instance['count'];
		$instance['label'] 		= $new_instance['label'];
		$instance['format'] 	= $new_instance['format'];
		$instance['post_type']	= !empty($new_instance['post_type']) ? strip_tags($new_instance['post_type']) : 'post';
		$instance['terms'] 		= preg_replace('/([^0-9,]+)/', '', $new_instance['terms']);

		return $instance;
	}

} // class WP_Widget_top_list_post
