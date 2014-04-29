<?php
if ( is_active_sidebar( 'post-widget-area' ) ) :
	dynamic_sidebar( 'post-widget-area' );
else :
	// ウィジェットに設定がない場合
	?>
	<div class="localSection sideWidget">
	<div class="localNaviBox">
	<h3 class="localHead"><?php _e('Category', 'biz-vektor'); ?></h3>
	<ul class="localNavi">
	<?php wp_list_categories('title_li=&orderby=order'); ?> 
	</ul>
	</div>
	</div>
	<?php 
	$options = biz_vektor_get_theme_options();
	if ($options['contact_link']) :?>
	<div class="sideWidget">
	<ul>
	<li class="sideBnr" id="sideContact"><a href="<?php echo $options['contact_link'] ?>">
	<img src="<?php echo get_template_directory_uri(); ?>/images/<?php _e('bnr_contact.png', 'biz-vektor'); ?>" alt="<?php _e('Contact us by e-mail', 'biz-vektor'); ?>"></a></li>
	</ul>
	</div>
	<?php endif;
	if (function_exists('biz_vektor_contactBtn')) biz_vektor_contactBtn();
	if (function_exists('biz_vektor_snsBnrs')) biz_vektor_snsBnrs();
	if (function_exists('biz_vektor_fbLikeBoxSide')) biz_vektor_fbLikeBoxSide();
	?>
<?php endif; ?>