<?php
/*-------------------------------------------*/
/*	Post
/*-------------------------------------------*/
$biz_vektor_options = biz_vektor_get_theme_options();
$postTopCount = $biz_vektor_options['postTopCount'];
if ($postTopCount != '0' ) :
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$post_loop = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' => $postTopCount,
	'paged' => $paged
) ); ?>
<?php if ($post_loop->have_posts()): ?>
	<div id="topBlog" class="infoList">
	<h2><?php echo esc_html($biz_vektor_options['postLabelName']); ?></h2>
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
	<?php // pagination($post_loop->max_num_pages);
$postTopUrl = (isset($biz_vektor_options['postTopUrl']))? $biz_vektor_options['postTopUrl'] : '';
if ($postTopUrl) {
	echo '<div class="moreLink right"><a href="'.esc_url($postTopUrl).'">';
	printf( __( '%s List page', 'biz-vektor' ), esc_html($biz_vektor_options['postLabelName']) );
	echo '</a></div>';
} ?>
	</div><!-- [ /#topBlog ] -->
<?php
endif; // $post_loop have_posts()
endif; // $postTopCpunt= 0
wp_reset_query();?>