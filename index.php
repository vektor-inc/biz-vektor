<?php get_header(); ?>
<?php $postType = get_post_type();
if ( !$postType ) {
  global $wp_query;
  if ($wp_query->query_vars['post_type']) {
      $postType = $wp_query->query_vars['post_type'];
  }
} ?>
<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content" class="content">
	<?php
/*-------------------------------------------*/
/*	Archive title
/*-------------------------------------------*/
	if ( is_year()) {
		// $archiveTitle = get_the_date('Y');
		$archiveTitle = sprintf( __( 'Yearly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'Y', 'yearly archives date format', 'biz-vektor' ) ) );
	} else if ( is_month() ) {
		$archiveTitle = sprintf( __( 'Monthly Archives: %s', 'biz-vektor' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'biz-vektor' ) ) );
	} else if ( is_category() || is_tax() ) {
		$archiveTitle = single_term_title( '',false);
	} else if ( is_tag() ) {
		$archiveTitle = __('Tags : ', 'biz-vektor').single_term_title( '',false);
	} else if ( is_author() ) {
		$userObj = get_queried_object();
		$archiveTitle = $userObj->display_name;
	}
	if ( isset($archiveTitle) && $archiveTitle ) {
		$archiveTitle = apply_filters( 'biz_vektor_archiveTitCustom', $archiveTitle );
		echo '<h1 class="contentTitle">'.esc_html( $archiveTitle ).'</h1>';
	}
/*-------------------------------------------*/
/*	Archive description
/*-------------------------------------------*/
	if ( is_category() || is_tax() || is_tag() ) {
		$category_description = term_description();
		$page 				  = get_query_var( 'paged', 0 );
		if ( ! empty( $category_description ) && $page == 0 ) {
			echo '<div class="archive-meta">' . $category_description . '</div>';
		}
	}
	?>
	<?php biz_vektor_archive_loop_before();?>
	<?php
/*-------------------------------------------*/
/*	Archive post list
/*-------------------------------------------*/
	?>
	<div class="infoList">
	<?php if (have_posts()) : ?>
	<?php

	$options = biz_vektor_get_theme_options();

	if (is_biz_vektor_archive_loop()) : ?>

		<?php biz_vektor_archive_loop(); ?>

	<?php elseif (file_exists(get_stylesheet_directory( ).'/module_loop_'.$postType.'.php') && $postType != 'post' ): ?>
		
		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php get_template_part('module_loop_'.$postType); ?>
		
		<?php endwhile; ?>

	<?php elseif ($postType == 'info') : ?>

		<?php if ( $options['listInfoArchive'] == 'listType_set' ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('module_loop_post2'); ?>
			<?php endwhile ?>
		<?php else : ?>
			<ul class="entryList">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('module_loop_post'); ?>
			<?php endwhile; ?>
			</ul>
		<?php endif; //$options['listInfoArchive'] ?>

	<?php else : ?>

		<?php if ( $options['listBlogArchive'] == 'listType_set' ) { ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('module_loop_post2'); ?>
			<?php endwhile ?>
		<?php } else { ?>
			<ul class="entryList">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('module_loop_post'); ?>
			<?php endwhile; ?>
			</ul>
		<?php } ?>

	<?php endif; ?>
	<?php pagination(); ?>
	<?php else: ?>
	<div class="sectionFrame"><p><?php _e('No posts.','biz-vektor');?></p></div>
	<?php endif; // have_post() ?>
	</div><!-- [ /.infoList ] -->
	<?php biz_vektor_archive_loop_after();?>
	</div>
	<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower" class="sideTower">
<?php get_sidebar($postType); ?>
</div>
<!-- [ /#sideTower ] -->
<?php biz_vektor_sideTower_after();?>
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>