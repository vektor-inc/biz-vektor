<?php /* If search null ,redirect to top */
if (isset($_GET['s']) && empty($_GET['s'])) {
	header("Location: ".home_url());
	exit;
}
?>
<?php get_header(); ?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content" class="content wide">

	<?php if ( have_posts() ) : ?>
	<ul class="linkList">
		<?php while ( have_posts() ) : the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endwhile; ?>
	</ul>
	<?php biz_vektor_content_nav( 'nav-below' ); ?>
	<?php else : ?>
		<p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'biz-vektor'); ?></p>
	<?php endif; ?>
<br />
	<div class="error404">
		<?php get_search_form(); ?>
	</div>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_template_part("module_sitemap"); ?>

</div>
<!-- [ /#content ] -->
</div>
<!-- [ /#container ] -->
<?php get_footer(); ?>