<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<!-- [ #post- ] -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="entryPostTitle"><?php the_title(); ?><?php edit_post_link(__('Edit', 'biz-vektor'), ' <span class="edit-link edit-item">[ ', ' ]' ); ?></h1>
	<div class="entry-meta">
		<?php _e('Posted on', 'biz-vektor'); ?> : <?php echo esc_html( get_the_date() ); ?> | 
		<?php _e('Category', 'biz-vektor'); ?> : <?php the_category(', ') ?>
	</div>
	<!-- .entry-meta -->
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
<?php get_template_part('module_side_'.get_post_type()); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>