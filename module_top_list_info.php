<?php
/*-------------------------------------------*/
/*	info
/*-------------------------------------------*/
$biz_vektor_options = biz_bektor_option_validate();

if(isset($biz_vektor_options['infoTopCount']) && $biz_vektor_options['infoTopCount'] != 0):
$infoTopCount = $biz_vektor_options['infoTopCount'];
$loop = new WP_Query( array( 'post_type' => 'info', 'posts_per_page' => $infoTopCount, ) ); ?>
<?php if ($loop->have_posts()) : ?>
<div id="topInfo" class="infoList">
<h2><?php echo esc_html($biz_vektor_options['infoLabelName']); ?></h2>
<div class="rssBtn"><a href="<?php echo home_url(); ?>/feed/?post_type=info" id="infoRss" target="_blank">RSS</a></div>
<?php
if ( isset($biz_vektor_options['listInfoTop']) &&  $biz_vektor_options['listInfoTop'] == 'listType_set' ) { ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post();?>
		<?php get_template_part('module_loop_post2'); ?>
	<?php endwhile ?>
<?php } else { ?>
	<ul class="entryList">
	<?php while ( $loop->have_posts() ) : $loop->the_post();?>
		<?php get_template_part('module_loop_post'); ?>
	<?php endwhile; ?>
	</ul>
<?php }
$infoTopUrl = (isset($biz_vektor_options['infoTopUrl']) && $biz_vektor_options['infoTopUrl'])? $biz_vektor_options['infoTopUrl'] : home_url().'/info/';
echo '<div class="moreLink right"><a href="'.esc_url($infoTopUrl).'">';
printf( __( '%s List page', 'biz-vektor' ), esc_html($biz_vektor_options['infoLabelName']) );
echo '</a></div>';
?>
</div><!-- [ /#topInfo ] -->
<?php endif;
wp_reset_query();
endif; // if ($infoTopCount != 0) :
?>