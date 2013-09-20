<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" class="entry-content">
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
</div><!-- .entry-content -->
<?php
if ( is_user_logged_in() == TRUE ) {　?>
<div class="adminEdit">
<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link(__('Edit', 'biz-vektor')); ?></span>
</div>
<?php } ?>
<?php endwhile; ?>

<?php //▼ 子ページリスト ?>
<?php
	if($post->ancestors){
		foreach($post->ancestors as $post_anc_id){
			$post_id = $post_anc_id;
		}
	} else {
		$post_id = $post->ID;
	}
	if ($post_id) {
		$children = wp_list_pages("title_li=&child_of=".$post_id."&echo=0");
		if ($children) { ?>
		<div class="childPageBox">
		<h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h4>
		<ul>
		<?php echo $children; ?>
		</ul>
		</div>
		<?php } ?>
<?php } ?>
<?php //▲ 子ページリスト ?>

<?php get_template_part('module_mainfoot'); ?>

<?php biz_vektor_snsBtns(); ?>
<?php biz_vektor_fbComments(); ?>

</div>
<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower">
<?php
	if($post->ancestors){
		foreach($post->ancestors as $post_anc_id){
			$post_id = $post_anc_id;
		}
	} else {
		$post_id = $post->ID;
	}
	if ($post_id) {
		$children = wp_list_pages("title_li=&child_of=".$post_id."&echo=0");
		if ($children) { ?>
		<div class="localSection sideWidget pageListSection">
		<h3 class="localHead"><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h3>
		<ul class="localNavi">
		<?php echo $children; ?>
		</ul>
		</div>
		<?php } ?>
<?php } ?>
	<?php get_sidebar(); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>