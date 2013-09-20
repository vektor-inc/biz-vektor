<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<!-- [ #post- ] -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="entryPostTitle"><?php the_title(); ?> <?php edit_post_link('編集', '<span class="edit-link">（', '）' ); ?></h1>
	<div class="entry-meta">投稿日：<?php echo esc_html( get_the_date() ); ?> | カテゴリー：<?php the_category(', ') ?></div><!-- .entry-meta -->

	<div class="entry-content post-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
		<?php /* ▼タグと編集を出力 */ ?>
		<div class="entry-utility">
			<?php
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ):
			?>
			<dl class="tag-links">
			<?php printf( '<dt>投稿タグ</dt><dd>%1$s</dd>', $tags_list ); ?>
			</dl>
			<?php endif; ?>
		</div>
		<!-- .entry-utility -->
	</div><!-- .entry-content -->

<?php
if ( is_user_logged_in() == TRUE ) {　?>
<div class="adminEdit">
	<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link('編集'); ?></span>
</div>
<?php } ?>

<?php biz_vektor_snsBtns(); ?>

<div id="nav-below" class="navigation">
	<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?></div>
	<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ); ?></div>
</div><!-- #nav-below -->

</div>
<!-- [ /#post- ] -->

<?php biz_vektor_fbComments(); ?>

<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

</div>
<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
	<?php if (get_post_type() == 'post') {
		get_template_part('module_side_blog');
	} ?>
	<?php get_sidebar(); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>