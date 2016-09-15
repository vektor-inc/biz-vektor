<?php
/*
 * Template Name: Landing Page
 */
get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content" class="content wide">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <?php
    global $post;
    $widget_id = 'lp-widget-'.$post->ID;
    if ( is_active_sidebar( $widget_id ) ) :
    	dynamic_sidebar( $widget_id );
    endif;

    $content = get_the_content();
    if ( $content ) : ?>

	<div id="post-<?php the_ID(); ?>" class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

<?php
if ( is_user_logged_in() == TRUE ) { ?>
<div class="adminEdit">
<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link(__('Edit', 'biz-vektor')); ?></span>
</div>
<?php } ?>

<?php do_action('biz_vektor_snsBtns'); ?>
<?php do_action('biz_vektor_fbComments'); ?>
<?php do_action('biz_vektor_fbLikeBoxDisplay'); ?>

	<?php endif; ?>
	<?php endwhile; ?>
</div>
<!-- [ /#content ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>