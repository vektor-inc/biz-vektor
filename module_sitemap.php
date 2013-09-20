<!-- [ #sitemapOuter ] -->
<div id="sitemapOuter">
<div id="sitemapPageList">
<ul class="linkList">
<?php wp_list_pages('title_li='); ?>
</ul>
</div>


<!-- [ #sitemapPostList ] -->
<div id="sitemapPostList">

	<!-- [ お知らせ ] -->
	<?php $loop = new WP_Query( array( 'post_type' => 'info' ) ); ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post();
	$postCount = ++$postCount;
	endwhile;
	if ($postCount): ?>
	<h5>お知らせ</h5>
	<ul class="linkList">
	<?php wp_list_categories('taxonomy=info-cat&title_li=&orderby=order'); ?>
	</ul>
	<?php endif;?>
	<?php wp_reset_query(); ?>
	<!-- [ /お知らせ ] -->
	<!-- [ 投稿 ] -->
	<?php query_posts("showposts=-0"); ?>
	<?php if(have_posts()): ?>
	<h5><?php echo esc_html(bizVektorOptions('postLabelName')); ?></h5>
	<ul class="linkList">
	<?php wp_list_categories('title_li='); ?> 
	</ul>
	<?php endif;?>
	<?php wp_reset_query(); ?>
	<!-- [ /投稿 ] -->

</div>
<!-- [ #sitemapPostList ] -->
</div>
<!-- [ /#sitemapOuter ] --