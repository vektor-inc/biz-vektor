<?php
$postType = get_post_type();
if ($postType == 'post') {
	$taxonomySlug = 'category';
} else {
	$taxonomies = get_the_taxonomies();
	if ($taxonomies) {
		foreach ( $taxonomies as $taxonomySlug => $taxonomy ) {}
	} else {
		$taxonomySlug = '';
	}
}
$taxo_catelist = get_the_term_list( $post->ID, $taxonomySlug, ' ','','');
?>
<li id="post-<?php the_ID(); ?>">
<span class="infoDate"><?php echo esc_html( get_the_date() ); ?></span>
<span class="infoCate"><?php echo $taxo_catelist; ?></span>
<?php edit_post_link(__('Edit', 'biz-vektor'), '<span class="edit-link edit-item">[ ', ' ]</span>'); ?>
<span class="infoTxt"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
</li>