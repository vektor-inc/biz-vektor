<?php
/*
 * Template Name: 投稿トップ
 */
get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	<?php //	 ▼編集を出力
	if ( is_user_logged_in() == TRUE ) {　?>
	<div class="adminEdit">
	<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link('編集'); ?></span>
	</div>
	<?php }  // ▲編集を出力 ?>
<?php endwhile; ?>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) ); ?>
<?php if(have_posts()): ?>
<div class="infoList">
<?php
$options = biz_vektor_get_theme_options();
if ( $options['listBlogArchive'] == 'listType_set' ) {
	get_template_part('module_loop_blog2');
} else {
	get_template_part('module_loop_blog');
} ?>
	</div><!-- [ /.infoList ] -->
	<?php pagination($additional_loop->max_num_pages); ?>
<?php endif;?>

	</div>
	<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
	<?php get_template_part('module_side_blog'); ?>
	<?php get_sidebar(); ?>
</div>
<!-- [ /#sideTower ] -->

</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>