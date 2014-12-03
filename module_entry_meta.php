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
$taxo_catelist = get_the_term_list( $post->ID, $taxonomySlug, ' ', ', ' ,'' );
?>
<div class="entry-meta">
<span class="published"><?php _e('Posted on', 'biz-vektor'); ?> : <?php echo esc_html( get_the_date() ); ?></span>
<span class="updated entry-meta-items"><?php _e('Last updated'); ?> : <?php the_modified_date('') ?></span>
<span class="vcard author entry-meta-items"><?php _e('Author'); ?> : <span class="fn"><?php echo esc_html(get_the_author_meta( 'display_name' ));?></span></span>
<?php if (!empty($taxo_catelist)) : ?>
<span class="tags entry-meta-items"><?php _e('Category', 'biz-vektor'); ?> : <?php echo $taxo_catelist; ?></span>
<?php endif; ?>
</div>
<!-- .entry-meta -->