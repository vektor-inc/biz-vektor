<!-- [ #sitemapOuter ] -->
<div id="sitemapOuter">
<div id="sitemapPageList">
<ul class="linkList">
<?php wp_list_pages('title_li='); ?>
</ul>
</div>

<!-- [ #sitemapPostList ] -->
<div id="sitemapPostList">

	<!-- [ info ] -->
	<?php
	$args = array( 'post_type' => 'info');
	$posts = get_posts($args);
	if (isset($posts) && $posts): ?>
	<h5><a href="<?php echo home_url(); ?>/info/"><?php echo esc_html(bizVektorOptions('infoLabelName')); ?></a></h5>
	<?php 
	$args = array(
		'taxonomy' => 'info-cat',
		'title_li' => '',
		'orderby' => 'order',
		'show_option_none' => '',
		'echo' => 0
	);
	$term_list = wp_list_categories( $args );
	if ( !empty($term_list) ) {
		echo '<ul class="linkList">'.$term_list.'</ul>';
	}
	endif;
	wp_reset_postdata(); ?>
	<!-- [ /info ] -->
	<!-- [ post ] -->
	<?php
	unset($posts);
	$args = array( 'post_type' => 'post');
	$posts = get_posts($args);
	if (isset($posts) && $posts): ?>
	<h5><?php echo esc_html(bizVektorOptions('postLabelName')); ?></h5>
	<?php 
	$args = array(
		'taxonomy' => 'category',
		'title_li' => '',
		'orderby' => 'order',
		'show_option_none' => '',
		'echo' => 0
	);
	$term_list = wp_list_categories( $args );
	if ( !empty($term_list) ) {
		echo '<ul class="linkList">'.$term_list.'</ul>';
	}
	endif;
	wp_reset_postdata(); ?>
	<!-- [ /post ] -->

</div>
<!-- [ #sitemapPostList ] -->
</div>
<!-- [ /#sitemapOuter ] -->