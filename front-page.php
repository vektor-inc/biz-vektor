<?php
/**
 * The main template file.
 */
get_header(); ?>
<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content">

	<?php if ( have_posts()) : the_post(); ?>

	<?php if (get_post_type() === 'page') : ?>
	<?php
	$topFreeContent = NULL;
	$topFreeContent = get_the_content();
	if ($topFreeContent) : ?>
	<div id="topFreeArea">
	<?php if (bizVektorOptions('topEntryTitleDisplay') == true) : ?>
		<h2><?php the_title(); ?></h2>
	<?php endif; // bizVektorOptions('topEntryTitleDisplay') == true ?>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	</div>
	<?php endif; // $topFreeContent ?>
	<?php endif; // get_post_type() === 'page' ?>

	<?php if ( is_user_logged_in() == TRUE ) {
	global $user_level;
	get_currentuserinfo(); ?>
		<div class="adminEdit">
			<?php if (10 <= $user_level) { ?>
			<p class="caption">
			<?php _e('* In the page [Settings] &raquo; [Display Settings], if the setting of the front page is not [page], nothing is displayed in this area.', 'biz-vektor'); ?><br />
			<?php _e('* If empty, the body field of a page that you set on the front page does not display anything.', 'biz-vektor'); ?><br />
			<?php // _e('* If you have set a fixed page to the front page, paging does not appear in the bottom of the post the list at the bottom.', 'biz-vektor'); ?>
			</p>
			<?php } ?>
			<span class="linkBtn linkBtnS linkBtnAdmin" style="float:left;margin-right:10px;"><?php edit_post_link( __('Edit', 'biz-vektor') ); ?></span>
			<?php if (10 <= $user_level) { ?>
			<span style="float:left;margin-right:10px;"><a href="<?php echo site_url(); ?>/wp-admin/themes.php?page=theme_options#topPage" class="btn btnS btnAdmin">
				<?php _e('Title display setting', 'biz-vektor'); ?>
			</a></span>
			<span><a href="<?php echo site_url(); ?>/wp-admin/options-reading.php" class="btn btnS btnAdmin">
				<?php _e('Change display page', 'biz-vektor'); ?>
			</a></span>
			<?php } ?>
		</div>
	<?php } // login ?>

<?php endif; // have_posts() ?>

<?php get_template_part('module_topPR'); ?>

<?php if ( function_exists( 'biz_vektor_topSpecial' ) ): biz_vektor_topSpecial(); endif; ?>

<?php
/*-------------------------------------------*/
/*	info
/*-------------------------------------------*/
?>
<?php $loop = new WP_Query( array( 'post_type' => 'info', 'posts_per_page' => 5 ) ); ?>
<?php while ( $loop->have_posts() ) : $loop->the_post();
$postCount = ++$postCount;
endwhile;
if ($postCount) :
?>
<div id="topInfo" class="infoList">
<h2><?php echo esc_html(bizVektorOptions('infoLabelName')); ?></h2>
<div class="rssBtn"><a href="<?php echo home_url(); ?>/feed/?post_type=info" id="infoRss" target="_blank">RSS</a></div>
<?php
$options = biz_vektor_get_theme_options();
if ( $options['listInfoTop'] == 'listType_set' ) { ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post();?>
		<?php get_template_part('module_loop_post2'); ?>
	<?php endwhile ?>
<?php } else { ?>
	<ul class="entryList">
	<?php while ( $loop->have_posts() ) : $loop->the_post();?>
		<?php get_template_part('module_loop_post'); ?>
	<?php endwhile; ?>
	</ul>
<?php } ?>
</div><!-- [ /#topInfo ] -->
<?php endif;?>

<?php wp_reset_query();?>

<?php
/*-------------------------------------------*/
/*	Post
/*-------------------------------------------*/
?>
<?php
$postTopCount = bizVektorOptions('postTopCount');
$postTopCount = mb_convert_kana($postTopCount, "a", "UTF-8");
if ($postTopCount != '0') : ?>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$post_loop = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' => $postTopCount,
	'paged' => $paged
) ); ?>
<?php if ($post_loop->have_posts()): ?>
	<div id="topBlog" class="infoList">
	<h2><?php echo esc_html(bizVektorOptions('postLabelName')); ?></h2>
	<div class="rssBtn"><a href="<?php echo home_url(); ?>/feed/?post_type=post" id="blogRss" target="_blank">RSS</a></div>
	<?php $options = biz_vektor_get_theme_options();
	if ( $options['listBlogTop'] == 'listType_set' ) { ?>
		<?php while ( $post_loop->have_posts() ) : $post_loop->the_post();?>
			<?php get_template_part('module_loop_post2'); ?>
		<?php endwhile ?>
	<?php } else { ?>
		<ul class="entryList">
		<?php while ( $post_loop->have_posts() ) : $post_loop->the_post();?>
			<?php get_template_part('module_loop_post'); ?>
		<?php endwhile; ?>
		</ul>
	<?php } ?>
	<?php pagination($post_loop->max_num_pages); ?>
	</div><!-- [ /#topBlog ] -->
<?php endif; // $post_loop have_posts() ?>
<?php endif; // $postTopCpunt= 0 ?>
<?php wp_reset_query();?>

<?php biz_vektor_blogList() // RSS import ?>

<?php biz_vektor_topContentsBottom(); ?>

<?php biz_vektor_fbLikeBoxFront(); ?>
<?php biz_vektor_snsBtns(); ?>
<?php biz_vektor_fbComments(); ?>

	</div>
	<!-- [ /#content ] -->

	<!-- [ #sideTower ] -->
	<div id="sideTower">
	<?php get_sidebar(); ?>
	</div>
	<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>