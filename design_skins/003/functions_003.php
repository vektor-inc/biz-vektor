<?php

/*-------------------------------------------*/
/*  Print header menu to head contact area
/*-------------------------------------------*/
add_filter('headContactCustom','rebuild_head_contact_custom');
function rebuild_head_contact_custom($headContact){
	$gMenuHtml = '';

	// ////////////// SubMenu
	// $sub_menu_args = array(
	//  'theme_location' => 'headerSubMenu',
	//  'fallback_cb' => '',
	//  'echo' => false,
	//  // 'walker' => new description_walker()
	// );
	// $headSubMenu = wp_nav_menu( $sub_menu_args ) ;

	////////////// Global menu
	$args = array(
	 'theme_location' => 'Header',
	 'fallback_cb' => '',
	 'echo' => false,
	 'walker' => new description_walker()
	);
	$gMenu = wp_nav_menu( $args ) ;

	// メニューがセットされていたら実行
	if ($gMenu || $gMenuHtml) {
	// ナビのHTMLを一旦変数に格納
	$gMenuHtml .= '
	<!-- [ #gMenu ] -->
	<div id="gMenu">
	<div id="gMenuInner" class="innerBox">
	<h3 class="assistive-text" onclick="showHide(\'header\');"><span>MENU</span></h3>
	<div class="skip-link screen-reader-text">
		<a href="#content" title="'.__('Skip menu', 'biz-vektor').'">'.__('Skip menu', 'biz-vektor').'</a>
	</div>'."\n";

	// メニューがセットされていたら実行
	// if ($headSubMenu) {
	// 	$gMenuHtml .= '<div class="headSubMenu">'."\n";
	// 	$gMenuHtml .= $headSubMenu;
	// 	$gMenuHtml .= '</div>'."\n";
	// }
	$gMenuHtml .= '<div class="headMainMenu">'."\n";
	$gMenuHtml .= $gMenu."\n";
	$gMenuHtml .= '</div>'."\n";
	$gMenuHtml .= '</div><!-- [ /#gMenuInner ] -->
	</div>
	<!-- [ /#gMenu ] -->'."\n";
	} // if ($gMenu) 
	$headContact = $gMenuHtml;
	return $headContact;
}

/*-------------------------------------------*/
/*  元のグローバルメニューは空にする
/*-------------------------------------------*/
add_filter('bizvektor_gMenuHtml','rebuild_gMenu_custom');
function rebuild_gMenu_custom(){
	$gMenuHtml = '';
	return $gMenuHtml;
}

/*-------------------------------------------*/
/*  メニューの横幅指定を一旦無効化
/*-------------------------------------------*/
remove_action('wp_head','biz_vektor_gMenuDivide',170);