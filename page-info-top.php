<?php
/*
 * Template Name: お知らせトップ（スラッグ:info-top）
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
$wp_query = new WP_Query( array( 'post_type' => 'info', /*'posts_per_page' => 20, */'paged' => $paged ) ); ?>
	<div class="infoList">
<?php
$options = biz_vektor_get_theme_options();
if ( $options['listInfoArchive'] == 'listType_set' ) { ?>
	<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		<?php get_template_part('module_loop_info2'); ?>
	<?php endwhile; ?>
<?php } else { ?>
	<ul class="entryList">
	<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
		<?php get_template_part('module_loop_info'); ?>
	<?php endwhile; ?>
	</ul>
<?php } ?>

	</div><!-- [ /.infoList ] -->
	<?php pagination($additional_loop->max_num_pages); ?>
	<?php wp_reset_query();?>
	</div>
	<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
	<?php get_template_part('module_side_info'); ?>
	<?php get_sidebar(); ?>
</div>
<!-- [ /#sideTower ] -->

</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>