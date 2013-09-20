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
	$archiveTitle = apply_filters( 'biz_vektor_archiveTitCustom', $archiveTitle );
	if ($archiveTitle) {
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
				<?php get_template_part('module_loop_info2'); ?>
			<?php endwhile ?>
		<?php else : ?>
			<ul class="entryList">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('module_loop_info'); ?>
			<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	<?php else : ?>
		<?php if ( $options['listBlogArchive'] == 'listType_title' ) {
			get_template_part('module_loop_blog');
		} else {
			get_template_part('module_loop_blog2');
		} ?>
	<?php endif; ?>
	</div><!-- [ /.infoList ] -->
	<?php pagination($additional_loop->max_num_pages); ?>
	</div>
	<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
	<?php
	if ($postType == 'post') {
		get_template_part('module_side_blog');
	} else if ($postType == 'info') {
		get_template_part('module_side_info');
	} ?>
	<?php get_sidebar(); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>