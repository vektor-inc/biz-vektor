<?php get_header(); ?>
<?php $postType = get_post_type();
if ( !$postType ) {
	// カスタム投稿タイプで該当記事が0件の場合、 get_post_type()で取得できないのでタクソノミーから取得
	$taxonomy = get_queried_object()->taxonomy;
	$postType = get_taxonomy( $taxonomy )->object_type[0];
} ?>
<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">
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
	}
	if ( ! empty( $category_description ) ) 
		echo '<div class="archive-meta">' . $category_description . '</div>';
	?>
	<?php
/*-------------------------------------------*/
/*	Archive post list
/*-------------------------------------------*/
	?>
	<div class="infoList">
	<?php
	$options = biz_vektor_get_theme_options();
	if ($postType == 'info') : ?>
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
	<?php elseif (function_exists(is_biz_vektor_archive_loop()) && is_biz_vektor_archive_loop()) : ?>
		<?php biz_vektor_archive_loop();?>
	<?php else : ?>
		<?php $options = biz_vektor_get_theme_options();
		if ( $options['listBlogArchive'] == 'listType_set' ) { ?>
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

	<?php endif; // $postType == 'info' ?>
	<?php pagination(); ?>
	</div><!-- [ /.infoList ] -->
	</div>
	<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
<?php get_sidebar($postType); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>