<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content" class="content">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<!-- [ #post- ] -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (is_biz_vektor_extra_single()) : ?>

		<?php biz_vektor_extra_single(); ?>
	<?php else: ?>
	<h1 class="entryPostTitle entry-title"><?php the_title(); ?><?php edit_post_link(__('Edit', 'biz-vektor'), ' <span class="edit-link edit-item">[ ', ' ]' ); ?></h1>
	<?php get_template_part('module_entry_meta');?>
	<div class="entry-content post-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>

		<div class="entry-utility">
			<?php
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ):
			?>
			<dl class="tag-links">
			<?php printf( __('<dt>Tags</dt><dd>%1$s</dd>', 'biz-vektor'), $tags_list ); ?>
			</dl>
			<?php endif; ?>
		</div>
		<!-- .entry-utility -->
	</div><!-- .entry-content -->

<?php edit_post_link(__('Edit', 'biz-vektor'),'<div class="adminEdit"><span class="linkBtn linkBtnS linkBtnAdmin">','</span></div>'); ?>

<?php do_action('biz_vektor_snsBtns'); ?>

<?php
/*-------------------------------------------*/
/*	Related posts
/*-------------------------------------------*/
if ( get_post_type() == 'post' ) :
$biz_vektor_options = biz_vektor_get_theme_options();
// Get now post's tag(terms)
if (isset($biz_vektor_options['postRelatedCount']) && $biz_vektor_options['postRelatedCount'] ) {
$terms = get_the_terms($post->ID,'post_tag');
$tag_count = count($terms);
if ($terms) {
$posts_count = mb_convert_kana($biz_vektor_options['postRelatedCount'], "a", "UTF-8");
// Set basic arrays
$args = array( 'post_type' => 'post' ,'post__not_in' => array($post->ID), 'posts_per_page' => $posts_count );
// Set tag(term) arrays
if ( $terms && $tag_count == 1 ) {
	foreach ( $terms as $key => $value) {
		$args['tag_id'] = $value->term_id ;
	}
} else if ( $terms ) {
	foreach ( $terms as $key => $value) {
		$args['tag__in'][] = $value->term_id ;
	}
}
$tag_posts = get_posts($args);
if ( $tag_posts ) { ?>
	<!-- [ .subPostListSection ] -->
	<div class="subPostListSection">
	<h3>関連記事</h3>
	<ul class="child_outer">
	<?php foreach ($tag_posts as $key => $post) { ?>
		<li class="ttBox">
		<div class="entryTxtBox<?php if ( has_post_thumbnail()) echo ' ttBoxTxt ttBoxRight haveThumbnail'; ?>">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</div><!-- [ /.entryTxtBox ] -->
		<?php if ( has_post_thumbnail()) { ?>
			<div class="ttBoxThumb ttBoxLeft"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
		<?php } ?>
		</li>
	<?php } // foreach ?>
	</ul><!-- [ /.child_outer ] -->
	</div><!-- [ /.subPostListSection ] -->
<?php } // if ( $tag_posts )
} // if ( $terms )
} // if ( $biz_vektor_options['postRelatedCount'] ) {
endif;
wp_reset_postdata();

/*-------------------------------------------*/
/*	ad_related_after
/*-------------------------------------------*/
if ( get_post_type() == 'post' ) :
$biz_vektor_options = biz_vektor_get_theme_options();
if (isset($biz_vektor_options['ad_related_after']) && $biz_vektor_options['ad_related_after']) {
	echo '<div class="sectionBox">'.apply_filters('widget_text',$biz_vektor_options['ad_related_after']).'</div>';
}
endif;
?>
<div id="nav-below" class="navigation">
	<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?></div>
	<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ); ?></div>
</div><!-- #nav-below -->
<?php endif; ?>
</div>
<!-- [ /#post- ] -->

<?php do_action('biz_vektor_fbComments'); ?>

<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

<?php do_action('biz_vektor_fbLikeBoxDisplay'); ?>

</div>
<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower" class="sideTower">
<?php get_sidebar(get_post_type()); ?>
</div>
<!-- [ /#sideTower ] -->
<?php biz_vektor_sideTower_after();?>
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>