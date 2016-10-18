<?php
function bizVektor_adminbar_remove( $wp_admin_bar ) {
	// $wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('site-name');
	// $wp_admin_bar->remove_node('updates');
	// $wp_admin_bar->remove_node('comments');
	// $wp_admin_bar->remove_node('new-content');

	// $wp_admin_bar->remove_node('new-media');
	// $wp_admin_bar->remove_node('new-link');
	// $wp_admin_bar->remove_node('new-page');
	// $wp_admin_bar->remove_node('new-user');
	// $wp_admin_bar->remove_node('view');

	// $wp_admin_bar->remove_node('my-account');

	// $wp_admin_bar->remove_node('edit-profile');
	// $wp_admin_bar->remove_node('user-info');
	// $wp_admin_bar->remove_node('logout');
}
add_action( 'admin_bar_menu', 'bizVektor_adminbar_remove', 1000 );

function bizvektor_adminbar_custom_menu() {

	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'id' => 'admin_top',
		'title' => __( 'Admin pages', 'biz-vektor' ),
		'href' =>  get_admin_url()
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'admin_top',
			'id' => 'public_page',
			'title' => __( 'Visit site', 'biz-vektor' ),
			'href' => home_url( '/' )
		));
		if ( current_user_can('activate_plugins') ) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'admin_top',
				'id' => 'general_setting_page',
				'title' => __( 'General settings', 'biz-vektor' ),
				'href' => get_admin_url().'options-general.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'admin_top',
				'id' => 'plugins_page',
				'title' => __( 'Plugins page', 'biz-vektor' ),
				'href' => get_admin_url().'plugins.php',
			));
		} // level 10
	if ( current_user_can('edit_theme_options') ) {
		$wp_admin_bar->add_menu( array(
			'id' => 'bizvektor_theme_setting',
			'title' => __( 'Theme options', 'biz-vektor' ),
			'href' =>  get_admin_url().'themes.php?page=theme_options',
		));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'customize_page',
				'title' => __( 'Customizer', 'biz-vektor' ),
				'href' => get_admin_url().'customize.php',
			));
			if ( current_user_can('activate_plugins') ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'bizvektor_theme_setting',
					'id' => 'Site title & description',
					'title' => __( 'Site title & description', 'biz-vektor' ),
					'href' => get_admin_url().'options-general.php',
				));
			}
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Widget settings',
				'title' => __( 'Widget settings', 'biz-vektor' ),
				'href' => get_admin_url().'widgets.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Menu settings',
				'title' => __( 'Menu settings', 'biz-vektor' ),
				'href' => get_admin_url().'nav-menus.php',
			));
			// $wp_admin_bar->add_menu( array(
			// 	'parent' => 'bizvektor_theme_setting',
			// 	'id' => 'Homepage feature',
			// 	'title' => __( 'Homepage feature', 'biz-vektor' ),
			// 	'href' => get_admin_url().'themes.php?page=custom-header',
			// ));
			// $wp_admin_bar->add_menu( array(
			// 	'parent' => 'bizvektor_theme_setting',
			// 	'id' => 'Settings for area below homepage feature',
			// 	'title' => __( 'Settings for area below homepage feature', 'biz-vektor' ),
			// 	'href' => get_admin_url().'options-reading.php',
			// ));
			// $wp_admin_bar->add_menu( array(
			// 	'parent' => 'bizvektor_theme_setting',
			// 	'id' => 'Theme options',
			// 	'title' => __( 'Theme options', 'biz-vektor' ),
			// 	'href' => get_admin_url().'themes.php?page=theme_options',
			// ));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Design settings',
				'title' => __( 'Design settings', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options#design',
			));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Contact details',
				'title' => __( 'Contact details', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options#contactInfo',
			));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Home 3PR area',
				'title' => __( 'Home 3PR area', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options#prBox',
			));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'post setting',
				'title' => sprintf(__('Posts setting', 'biz-vektor')),
				'href' => get_admin_url().'themes.php?page=theme_options#postSetting',
			));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'SEO & GA',
				'title' => __( 'SEO & GA', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options#seoSetting',
			));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Homepage setting',
				'title' => __( 'Homepage settings', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options#topPage',
			));
			$wp_admin_bar->add_menu( array(
				// 'parent' => 'Theme options',
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Slide',
				'title' => __( 'Slideshow settings', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options#slideSetting',
			));

			do_action('biz_vektor_admin_bar_init');

			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Background settings',
				'title' => __( 'Background settings', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=custom-background',
			));
	} // lebel 10

	// page
	if ( current_user_can('edit_pages') ) {
	$wp_admin_bar->add_menu( array(
		'id' => 'page_adminMenu',
		'title' => __( 'Managing pages', 'biz-vektor' ),
		'href' => get_admin_url().'edit.php?post_type=page',
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'page_adminMenu',
			'id' => 'adminMenu_post_list',
			'title' => __( 'Pages - List of entries', 'biz-vektor' ),
			'href' => get_admin_url().'edit.php?post_type=page',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => 'page_adminMenu',
			'id' => 'adminMenu_post_new',
			'title' => __( 'Pages - Add new', 'biz-vektor' ),
			'href' => get_admin_url().'post-new.php?post_type=page',
		));
	}

	// post
	$wp_admin_bar->add_menu( array(
		'id' => 'postLabelName',
		'title' => sprintf( __( 'Managing %s', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
		'href' => get_admin_url().'edit.php',
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'postLabelName',
			'id' => 'postAdminMenu_list',
			'title' => sprintf( __( '%s - List of entries', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
			'href' => get_admin_url().'edit.php',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => 'postLabelName',
			'id' => 'postAdminMenu_new',
			'title' => sprintf( __( '%s - Add new', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
			'href' => get_admin_url().'post-new.php',
		));
		if ( current_user_can('edit_pages') ) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'postLabelName',
				'id' => 'postAdminMenu_category',
				'title' => sprintf( __( '%s - Categories', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
				'href' => get_admin_url().'edit-tags.php?taxonomy=category',
			));
		}

}
add_action( 'admin_bar_menu', 'bizvektor_adminbar_custom_menu',20 );

function bizvektor_adminbar_custom_edit_guide(){
	global $wp_admin_bar;
	if ( current_user_can('edit_pages') && !is_admin() ) {
	$wp_admin_bar->add_menu( array(
		'id' => 'editGuide',
		'title' => __( 'Edit guide : OPEN', 'biz-vektor' ),
		'href' => '',
	));
	}
}
add_action( 'admin_bar_menu', 'bizvektor_adminbar_custom_edit_guide',1000 );