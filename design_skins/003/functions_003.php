<?php

/*-------------------------------------------*/
/*  ブローバルメニューを#headerの中に出力
/*-------------------------------------------*/
add_filter('headContactCustom','regenerate_head_contact_custom');
function regenerate_head_contact_custom($headContact){
	$args = array(
	 'theme_location' => 'Header',
	 'fallback_cb' => '',
	 'echo' => false,
	 'walker' => new description_walker()
	);
	$gMenu = wp_nav_menu( $args ) ;
	// メニューがセットされていたら実行
	if ($gMenu) {
	// ナビのHTMLを一旦変数に格納
	$gMenuHtml = '
	<!-- [ #gMenu ] -->
	<div id="gMenu" class="itemClose">
	<div id="gMenuInner" class="innerBox">
	<h3 class="assistive-text" onclick="showHide(\'gMenu\');"><span>MENU</span></h3>
	<div class="skip-link screen-reader-text">
		<a href="#content" title="'.__('Skip menu', 'biz-vektor').'">'.__('Skip menu', 'biz-vektor').'</a>
	</div>'."\n";
	$gMenuHtml .= $gMenu."\n";
	$gMenuHtml .= '</div><!-- [ /#gMenuInner ] -->
	</div>
	<!-- [ /#gMenu ] -->'."\n";
	} // if ($gMenu) 
    $headContact =  $gMenuHtml;
    return $headContact;
}

/*-------------------------------------------*/
/*  元のグローバルメニューは空にする
/*-------------------------------------------*/
add_filter('bizvektor_gMenuHtml','regenerate_gMenu_custom');
function regenerate_gMenu_custom(){
	$gMenuHtml = '';
	return $gMenuHtml;
}


/*-------------------------------------------*/
/*  メニューの横幅指定を一旦無効化
/*-------------------------------------------*/
remove_action('wp_head','biz_vektor_gMenuDivide',170);
