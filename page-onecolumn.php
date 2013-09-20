<?php
/*
 * Template Name: サイドバーなし
 */
get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content" class="wide">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

<?php
if ( is_user_logged_in() == TRUE ) {　?>
<div class="adminEdit">
<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link('編集'); ?></span>
</div>
<?php } ?>

<?php biz_vektor_snsBtns(); ?>
<?php biz_vektor_fbComments(); ?>

	<?php endwhile; ?>
</div>
<!-- [ /#content ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>