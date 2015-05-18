<?php if ( is_active_sidebar( 'common-side-top-widget-area' ) ) dynamic_sidebar( 'common-side-top-widget-area' ); ?>
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
	<?php wp_list_categories('title_li='); ?> 
	</ul>
	</div>
	</div>
	<?php
	if (function_exists('biz_vektor_contactBtn')) biz_vektor_contactBtn();
	if (function_exists('biz_vektor_snsBnrs')) biz_vektor_snsBnrs();
	?>
<?php endif; ?>
<?php if ( is_active_sidebar( 'common-side-bottom-widget-area' ) ) dynamic_sidebar( 'common-side-bottom-widget-area' ); ?>