<?php if ( is_active_sidebar( 'common-side-top-widget-area' ) ) dynamic_sidebar( 'common-side-top-widget-area' ); ?>
<?php
if ( is_active_sidebar( 'info-widget-area' ) ) :
	dynamic_sidebar( 'info-widget-area' );
else :
	$args = array(
		'show_option_none'		=> '',
		'title_li'				=> '',
		'taxonomy' 				=> 'info-cat',
		'orderby'				=> 'order',
		'echo'					=> 0    /* 直接出力させない為 */
	);
	$catlist = wp_list_categories( $args );
	if ( !empty($catlist) ) { ?>
		<div class="localSection sideWidget">
		<div class="localNaviBox">
		<h3 class="localHead"><?php _e('Category', 'biz-vektor'); ?></h3>
		<ul class="localNavi">
	    <?php echo $catlist; ?>
		</ul>
		</div>
		</div>
	<?php } ?>

	<div class="localSection sideWidget">
	<div class="localNaviBox">
	<h3 class="localHead"><?php _e('Yearly archives', 'biz-vektor'); ?></h3>
	<ul class="localNavi">
	<?php
	$args = array(
		'type' => 'yearly',
		'post_type' => 'info',
		'after' => _x('&nbsp;', 'After year','biz-vektor')
		);
	wp_get_archives($args); ?>
	</ul>
	</div>
	</div>

	<?php
	if (function_exists('biz_vektor_contactBtn')) biz_vektor_contactBtn();
	if (function_exists('biz_vektor_snsBnrs')) biz_vektor_snsBnrs();
	?>
<?php endif; ?>
<?php if ( is_active_sidebar( 'common-side-bottom-widget-area' ) ) dynamic_sidebar( 'common-side-bottom-widget-area' ); ?>