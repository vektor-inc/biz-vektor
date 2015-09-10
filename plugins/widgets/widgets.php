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
/*	Top Info list widget
/*-------------------------------------------*/
/*	Archive list widget
/*-------------------------------------------*/
/*	Taxonomy list widget
/*-------------------------------------------*/
/*	RSS Widget
/*-------------------------------------------*/
/*	Side Post list widget
/*-------------------------------------------*/




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
		return $new_instance;
	}

} // class WP_Widget_childPageList
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_childPageList");'));

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
	//	echo $before_widget;
		get_template_part( 'module_topPR' );
	//	echo $after_widget;
	}

	function form($instance){
	}

	function update($new_instance,$old_instance){
		return $new_instance;
	}

} // class WP_Widget_topPR
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_topPR");'));

/*-------------------------------------------*/
/*	page widget
/*-------------------------------------------*/
class wp_widget_page extends WP_Widget {

	function __construct() {

		$widget_name = biz_vektor_get_short_name() . '_' . __( 'page content for top', 'biz-vektor' );

		parent::__construct(
			'pudge',
			$widget_name,
			array( 'description' => __( 'Displays the content of a chosen page.', 'biz-vektor' ) )
		);
	}

	function widget($args, $instance){
		global $is_pagewidget;
		$is_pagewidget = true;
		$this->display_page($instance['page_id'],$instance['set_title']);
		$is_pagewidget = false;
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
		<label for="<?php echo $this->get_field_id('set_title'); ?>"> <?php _e( 'display title', 'biz-vektor' ); ?></label>
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
		if ( is_user_logged_in() == TRUE ) {
			global $user_level;
			get_currentuserinfo();
			if (10 <= $user_level) {
				?>
				<div class="adminEdit">
				<a href="<?php echo site_url(); ?>/wp-admin/post.php?post=<?php echo $pageid ;?>&action=edit" class="btn btnS btnAdmin"><?php _e('Edit', 'biz-vektor');?></a>
				</div>
			<?php } }
		echo '</div>';
	}
}
add_action('widgets_init', create_function('', 'return register_widget("wp_widget_page");'));

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
		return $instance;
	}

}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_contact_link");'));

/*-------------------------------------------*/
/*	Top Post list widget
/*-------------------------------------------*/
class WP_Widget_top_list_post extends WP_Widget {

	function __construct() {
		global $biz_vektor_options;
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
	}

	function update($new_instance,$old_instance){
		return $new_instance;
	}
} // class WP_Widget_top_list_post
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_top_list_post");'));

/*-------------------------------------------*/
/*	Top Info list widget
/*-------------------------------------------*/
class WP_Widget_top_list_info extends WP_Widget {

	function __construct() {
		global $biz_vektor_options;
		$biz_vektor_options = biz_bektor_option_validate();

		$widget_name = biz_vektor_get_short_name() . '_' . sprintf( __( '%1$s list for top', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] );

		parent::__construct(
			'top_list_info',
			$widget_name,
			array( 'description' => sprintf( __( 'Displays recent %1$s posts.', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] ) )
		);
	}

	function widget($args, $instance) {
		// echo $before_widget;
		get_template_part( 'module_top_list_info' );
		// echo $after_widget;
	}

	function form($instance){
	}

	function update($new_instance,$old_instance){
		return $new_instance;
	}
} // class WP_Widget_top_list_info
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_top_list_info");'));

/*-------------------------------------------*/
/*	Archive list widget
/*-------------------------------------------*/
class WP_Widget_archive_list extends WP_Widget {
	// ウィジェット定義
	function __construct() {
		global $bizvektor_works_unit;

		$widget_name = biz_vektor_get_short_name() . '_' . __( 'archive list', 'biz-vektor' );

		parent::__construct(
			'WP_Widget_archive_list',
			$widget_name,
			array( 'description' => __( 'Displays a list of archives. You can choose the post type and also to display archives by month or by year.' , 'biz-vektor' ) )
		);
	}

	function widget($args, $instance) {
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
		$defaults = array(
			'post_type' => 'post',
			'display_type' => 'm',
			'label' => __( 'Monthly archives', 'biz-vektor' ),
			'hide' => __( 'Monthly archives', 'biz-vektor' ),
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		$pages = get_post_types( array('public'=> true, '_builtin' => false),'names');
		$pages[] = 'post';
		?>
		<p>

		<label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Title','biz-vektor');?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" ><br/>
		<input type="hidden" name="<?php echo $this->get_field_name('hide'); ?>" ><br/>

		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post type', 'biz-vektor' ) ?>:</label>
		<select name="<?php echo $this->get_field_name('post_type'); ?>" >
		<?php foreach($pages as $page){ ?>
		<option value="<?php echo $page; ?>" <?php if($instance['post_type'] == $page) echo 'selected="selected"'; ?> ><?php echo $page; ?></option>
		<?php } ?>
		</select>
		<br/>
		<label for="<?php echo $this->get_field_id('display_type'); ?>">表示タイプ</label>
		<select name="<?php echo $this->get_field_name('display_type'); ?>" >
			<option value="m" <?php if($instance['display_type'] != "y") echo 'selected="selected"'; ?> >月別</option>
			<option value="y" <?php if($instance['display_type'] == "y") echo 'selected="selected"'; ?> >年別</option>
		</select>
		</p>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			var post_labels = new Array();
			<?php
				foreach($pages as $page){
					$page_labl = get_post_type_object($page);
					if(isset($page_labl->labels->name)){
						echo 'post_labels["'.$page.'"] = "'.$page_labl->labels->name.'";';
					}
				}
				echo 'post_labels["blog"] = "ブログ";'."\n";
			?>
			var posttype = jQuery("[name=\"<?php echo $this->get_field_name('post_type'); ?>\"]");
			var lablfeld = jQuery("[name=\"<?php echo $this->get_field_name('label'); ?>\"]");
			posttype.change(function(){
				lablfeld.val(post_labels[posttype.val()]+'アーカイブ');
			});
		});
		</script>
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
} // class WP_Widget_top_list_info
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_archive_list");'));

/*-------------------------------------------*/
/*	Taxonomy list widget
/*-------------------------------------------*/
class WP_Widget_taxonomy_list extends WP_Widget {
	// ウィジェット定義
	function __construct() {
		global $bizvektor_works_unit;

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

	function widget($args, $instance) {
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
		$defaults = array(
			'tax_name'     => 'category',
			'label'        => __( 'Category', 'biz-vektor' ),
			'hide'         => __( 'Category', 'biz-vektor' ),
			'title'		=> 'test',
			'_builtin'		=> false,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$taxs = get_taxonomies( array('public'=> true),'objects'); 
		?>
		<p>
		<label for="<?php echo $this->get_field_id('label'); ?>"><?php _e( 'Label to display', 'biz-vektor' ); ?></label>
		<input type="text"  id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" ><br/>
		<input type="hidden" name="<?php echo $this->get_field_name('hide'); ?>" ><br/>

		<label for="<?php echo $this->get_field_id('tax_name'); ?>"><?php _e('Display page', 'biz-vektor') ?></label>
		<select name="<?php echo $this->get_field_name('tax_name'); ?>" >
		<?php foreach($taxs as $tax){ ?>
			<option value="<?php echo $tax->name; ?>" <?php if($instance['tax_name'] == $tax->name) echo 'selected="selected"'; ?> ><?php echo $tax->labels->name; ?></option>
		<?php } ?>
		</select>		</p>
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
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_taxonomy_list");'));

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
			'label' => __( 'Blog entries', 'biz-vektor' ),
		);
		$instance = wp_parse_args((array) $instance, $defaults);

		?>
		<Label for="<?php echo $this->get_field_id('label'); ?>"><?php _e( 'Heading title', 'biz-vektor' ) ?></label><br/>
		<input type="text" id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" />
		<br/>
		<Label for="<?php echo $this->get_field_id('url'); ?>">URL</label><br/>
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
add_action('widgets_init', create_function('', 'return register_widget("wp_widget_bizvektor_rss");'));

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
		echo '<div class="sideWidget">';
		echo '<h3 class="localHead">';
		if ( isset($instance['label']) && $instance['label'] ) {
			echo $instance['label'];
		} else {
			_e('Recent Posts', 'biz-vektor' );
		}
		echo '</h3>';
		echo '<div class="ttBoxSection">';

		$count 		= ( isset($instance['count']) && $instance['count'] ) ? $instance['count'] : 10;
		$post_type 	= ( isset($instance['post_type']) && $instance['post_type'] ) ? $instance['post_type'] : 'post';

		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'paged' => 1,
		);

		if(isset($instance['terms']) && $instance['terms']){
			$taxonomies = get_taxonomies(array());

			$args['tax_query'] = array(
				'relation' => 'OR',
			);

			foreach($taxonomies as $taxonomy){
			$args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field' => 'id',
					'terms' => $instance['terms']
				);
			}
		}
		$post_loop = new WP_Query( $args );

		if ($post_loop->have_posts()):
			while ( $post_loop->have_posts() ) : $post_loop->the_post(); ?>
				<div class="ttBox" id="post-<?php the_ID(); ?>">
				<?php if ( has_post_thumbnail()) : ?>
					<div class="ttBoxTxt ttBoxRight"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
					<div class="ttBoxThumb ttBoxLeft"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
				<?php else : ?>
					<div>
						<a href="<?php the_permalink();?>"><?php the_title();?></a>
					</div>
				<?php endif; ?>
				</div>
			<?php endwhile;
		endif;
		echo '</div>';
		echo '</div>';
		wp_reset_postdata();
		wp_reset_query();

	} // widget($args, $instance)

	function form ($instance) {

		$defaults = array(
			'count' 	=> 10,
			'label' 	=> __('Recent Posts', 'biz-vektor' ),
			'post_type' => 'post',
			'terms'     => ''
		);

		$instance = wp_parse_args((array) $instance, $defaults);

		?>
		<?php //タイトル ?>
		<label for="<?php echo $this->get_field_id('label');  ?>"><?php _e('Title:'); ?></label><br/>
		<input type="text" id="<?php echo $this->get_field_id('label'); ?>-title" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $instance['label']; ?>" />
		<br/><br/>

		<?php //表示件数 ?>
		<label for="<?php echo $this->get_field_id('count');  ?>"><?php _e('Display count','biz-vektor'); ?>:</label><br/>
		<input type="text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
		<br /><br/>

		<?php //投稿タイプ ?>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Slug for the custom type you want to display', 'biz-vektor') ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" value="<?php echo esc_attr($instance['post_type']) ?>" /><br />
		<?php
		global $biz_vektor_options;
		printf(  __('For %1$s use "post"<br />for %2$s use "info"', 'biz-vektor' ), esc_html( $biz_vektor_options['postLabelName']), esc_html( $biz_vektor_options['infoLabelName']) ); ?>
		<br/><br/>
		<?php // Terms ?>
		<label for="<?php echo $this->get_field_id('terms'); ?>"><?php _e('taxonomy ID', 'biz-vektor') ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id('terms'); ?>" name="<?php echo $this->get_field_name('terms'); ?>" value="<?php echo esc_attr($instance['terms']) ?>" /><br />
		<?php _e('if you need filtering by term, add the term ID separate by ",".', 'biz-vektor'); 
		echo "<br/>";
		_e('if empty this area, I will do not filtering.', 'biz-vektor'); 
		echo "<br/><br/>";

	}

	function update ($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['count'] 		= $new_instance['count'];
		$instance['label'] 		= $new_instance['label'];
		$instance['post_type']	= !empty($new_instance['post_type']) ? strip_tags($new_instance['post_type']) : 'post';
		$instance['terms'] 		= preg_replace('/([^0-9,]+)/', '', $new_instance['terms']);

		return $instance;
	}

} // class WP_Widget_top_list_post
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_bizvektor_post_list");'));
