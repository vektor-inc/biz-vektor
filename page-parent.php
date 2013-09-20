<?php
/*
 * Template Name: 子ページインデックス
 */
get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content">

<?php if ( have_posts()) : the_post(); ?>
	<?php
	$content = NULL;
	$content = get_the_content();
	if ($content) { ?>
		<div id="post-<?php the_ID(); ?>" class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
	<?php } ?>	
<?php if ( is_user_logged_in() == TRUE ) {　?>
<div class="adminEdit">
<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link('編集'); ?></span>
</div>
<?php } ?>
<?php endif; ?>

<?php 
$parentId = get_the_ID();
$args = 'posts_per_page=-1&post_type=page&orderby=menu_order&order=asc&post_parent='.$parentId;
query_posts($args);
if (have_posts()) : 
  $count = 1;
  while (have_posts()) : 
    the_post();
    if ( ( $count % 2 ) > 0 ) {
		$layout	= 'odd';
	} else {
		$layout	= 'even';
	}
?>
<!-- .child_page_block -->
<div class="child_page_block layout_<?php echo $layout ?>">
<div class="child_page_blockInner">
	<h4 class="entryTitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<?php if ( has_post_thumbnail()) { ?>
		<div class="thumbImage">
		<div class="thumbImageInner">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				</div>
		</div><!-- [ /.thumbImage ] -->
	<?php } ?>
	<div class="childText">
	<p><a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a></p>
	<div class="moreLink"><a href="<?php the_permalink(); ?>">詳しくはこちら</a></div>
	</div>
	<span class="linkBtn linkBtnS linkBtnAdmin"><?php edit_post_link('編集'); ?></span>
</div>
</div>
<!-- /.child_page_block -->
<?php
    $count++;
   endwhile;
endif;
wp_reset_query();
?>

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
		<div class="localSection sideWidget">
		<h3 class="localHead"><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h3>
		<ul class="localNavi">
		<?php echo $children; ?>
		</ul>
		</div>
		<?php } else { ?>
		<?php } ?>
<?php } ?>
	<?php get_sidebar(); ?>
</div>
<!-- [ /#sideTower ] -->
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>