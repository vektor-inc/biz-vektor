<?php 
$biz_vektor_options = biz_vektor_get_theme_options();

/*------------------------
--SITEMAP ADVANCED OPTIONS
----------------------------*/

//post types to display on sitemap
$types 	= array(
			array(
				'post-type' => 'info',
				'taxonomy' 	=> array(
									array(
										'taxoName' 	=> 'info-cat',
										'taxoLabel' => '')
								),
				'label' 	=> $biz_vektor_options['infoLabelName'],
				'link'		=> home_url( '/info/' )
			),
			array(
				'post-type' => 'post',
				'taxonomy' 	=> array(
									array(
										'taxoName' 	=> 'category',
										'taxoLabel' => '')
									),
				'label' 	=> $biz_vektor_options['postLabelName'],
				'link'		=> $biz_vektor_options['postTopUrl']
			));

//pages to exclude
$pages 	= '';


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
				$types[$i]['link'] 		= home_url( '/' . $typeName );
				$types[$i]['label']		= get_post_type_object( $typeName )->labels->name;

				//gets all taxonomies of custom type
				$typeTaxo = get_object_taxonomies( $typeName, 'objects' );

				//looks for category (hierarchical taxonomy)
				if ( isset($typeTaxo) && !empty($typeTaxo) ) {

					$j = 0;

					foreach ( $typeTaxo as $taxoName => $taxoObj ) {

						if ( $taxoObj->hierarchical ) {
							
							$types[$i]['taxonomy'][$j]['taxoName'] 	= $taxoName;
							$types[$i]['taxonomy'][$j]['taxoLabel'] = $taxoObj->labels->name;
							$j++;
						}
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

		<?php foreach ( $types as $type ) { 

			//test query to know if there is posts in this post type
			$args =  array( 
				'posts_per__page' => 1,
				'post_type'		  => $type['post-type'],	
			);
			$query = new WP_Query( $args );
			
			if ( $query->found_posts > 0 ) {
				?>
				<div class="sectionBox">
					<h5><?php 
						if ( isset( $type['link'] ) && ! empty( $type['link'] ) ) { ?>
							<a href="<?php echo $type['link']; ?>">
								<?php echo isset( $type['label'] ) ? $type['label'] : ''; ?>
							</a><?php
						} else {
							echo isset( $type['label'] ) ? $type['label'] : '';
						} ?>
					</h5>

					<?php foreach ( $type['taxonomy'] as $i => $taxonomy ) {

						if ( count( $type['taxonomy'] ) > 1 ) { ?>

							<h6><?php echo $taxonomy['taxoLabel'] ?></h6><?php

						} ?>
						<ul class="linkList"><?php

							$args = array(
								'taxonomy' => $taxonomy['taxoName'],
								'title_li' => '',
								'orderby' => 'order',
								'show_option_none' => '',
							);

							wp_list_categories( $args ); ?>
						</ul>
					<?php } ?>
				</div>
			<?php }
		} ?>

	</div><!-- [ /#sitemapPostList ] -->
</div><!-- [ /#sitemapOuter ] -->