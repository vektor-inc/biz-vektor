<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<!-- [ #post- ] -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="entryPostTitle"><?php the_title(); ?><?php edit_post_link(__('Edit', 'biz-vektor'), ' <span class="edit-link edit-item">[ ', ' ]' ); ?></h1>
	<?php $taxo_catelist = get_the_term_list( $post->ID, 'info-cat', '', ', ', '' ); ?>
	<div class="entry-meta">
	<?php _e('Posted on', 'biz-vektor'); ?> : <?php echo esc_html( get_the_date() ); ?>
	<?php if (!empty($taxo_catelist)) : ?> | 
	<?php _e('Category', 'biz-vektor'); ?> : <?php echo $taxo_catelist; ?>
	<?php endif; ?>
	</div><!-- .entry-meta -->

	<div class="entry-content post-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

<?php
if ( is_user_logged_in() ) { ?>
<div class="adminEdit">
	<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link(__('Edit', 'biz-vektor')); ?></span>
</div>
<?php } ?>

<?php biz_vektor_snsBtns(); ?>

</div>
<!-- [ /#post- ] -->

<div id="nav-below" class="navigation">
	<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?></div>
	<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ); ?></div>
</div><!-- #nav-below -->

<?php biz_vektor_fbComments(); ?>

<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

</div>
<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
	<?php get_sidebar('info'); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>