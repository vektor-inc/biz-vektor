<?php /* 検索値が空のときにindex.phpを表示してしまうのでリダイレクト処理 */
if (isset($_GET['s']) && empty($_GET['s'])) {
	header("Location: ".home_url());
	exit;
}
?>
<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content">

<?php if (is_home()) { ?>
	<?php if(have_posts()): ?>
	<div id="topBlog" class="infoList">
	<?php
	$options = biz_vektor_get_theme_options();
	if ( $options['listBlogArchive'] == 'listType_set' ) {
		get_template_part('module_loop_blog2');
	} else {
		get_template_part('module_loop_blog');
	} ?>
	</div><!-- [ /#topBlog ] -->
	<?php else: ?>
	<p><?php _e('No entry.', 'biz-vektor'); ?>記事はありません</p>
	<?php endif; ?>
<?php } ?>

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