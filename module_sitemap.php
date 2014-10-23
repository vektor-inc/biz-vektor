<?php 
global $biz_vektor_options;

/*------------------------
--SITEMAP ADVANCED OPTIONS
----------------------------*/

//post types to display on sitemap
$types 			= array(
					array(
						'post-type' => 'info',
						'taxonomy' 	=> array('info-cat'),
						'label' 	=> $biz_vektor_options['infoLabelName'],
						'link'		=> get_bloginfo('url') . '/info/'
					),
					array(
						'post-type' => 'post',
						'taxonomy' 	=> array('category'),
						'label' 	=> $biz_vektor_options['postLabelName'],
						'link'		=> $biz_vektor_options['postTopUrl']
					));

//pages to exclude
$pages 			= '';


//gets advanced options saved by administrator from DB
$advancedOptions = Biz_Vektor_Advanced_Options::getAdvancedOptions();

if ( isset($advancedOptions) ) {
	
	//adds custom post types names, hierarchical taxonomies (categories), details to $types array
	if ( isset($advancedOptions['types']) && !empty($advancedOptions['types']) ) {

		$i = count($types);

		foreach ( $advancedOptions['types'] as $typeName ) {

			//checks if post type exists
			$typeObj = get_post_type_object($typeName);

			if ( isset($typeObj) ) {

				$types[$i]['post-type'] = $typeName;
			
				//gets custom post type infos based on default Wordpress behaviour
				$types[$i]['link'] 		= get_bloginfo('url') . '/' . $typeName . '/';
				$types[$i]['label']		= get_post_type_object( $typeName )->labels->name;

				//gets all taxonomies of custom type
				$typeTaxo = get_object_taxonomies( $typeName, 'objects' );

				//looks for category (hierarchical taxonomy)
				if ( isset($typeTaxo) && !empty($typeTaxo) ) {

					foreach ( $typeTaxo as $taxoName => $taxoObj ) {

						if ( $taxoObj->hierarchical )
							$types[$i]['taxonomy'][] = $taxoName;
					}
				}
				$i++;
			}
		}
	}
	
	//adds id of pages to remove from sitemap (array to string)
	if ( isset($advancedOptions['pages']) && !empty($advancedOptions['pages']) ) {

		$length = count($advancedOptions['pages']);

		if ( $length > 1 )
			$pages = implode( ',', $advancedOptions['pages'] );
		else
			$pages = $advancedOptions['pages'][0];
	}
}
?>
<!-- [ #sitemapOuter ] -->
<div id="sitemapOuter">
	
	<div id="sitemapPageList">
		<ul class="linkList">
			<?php 

			//pages
			$args = array(
				'title_li' 	=> '',
				'exclude_tree'	=> $pages //hides children
			);

			wp_list_pages($args); ?>
		</ul>
	</div>

	<!-- [ #sitemapPostList ] -->
	<div id="sitemapPostList">

		<?php foreach ( $types as $type ) { ?>

			<h5>
				<a href="<?php echo isset($type['link']) ? $type['link'] : '' ?>">
					<?php echo isset($type['label']) ? $type['label'] : '' ?>
				</a>
			</h5>

			<ul class="linkList">

				<?php foreach ($type['taxonomy'] as $taxonomy)
				{
					
					$args = array(
						'taxonomy' => $taxonomy,
						'title_li' => '',
						'orderby' => 'order',
						'show_option_none' => '',
					);

					wp_list_categories( $args ); 
				} ?>
			</ul><?php 
		} ?>

	</div><!-- [ /#sitemapPostList ] -->
</div><!-- [ /#sitemapOuter ] -->