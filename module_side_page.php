<?php
if ( is_active_sidebar( 'post-widget-area' ) ) :
	dynamic_sidebar( 'post-widget-area' );
else :
	// ウィジェットに設定がない場合
	biz_vektor_childPageList();
	if (function_exists('biz_vektor_contactBtn')) biz_vektor_contactBtn();
	if (function_exists('biz_vektor_snsBnrs')) biz_vektor_snsBnrs();
	if (function_exists('biz_vektor_fbLikeBoxSide')) biz_vektor_fbLikeBoxSide();
endif; ?>