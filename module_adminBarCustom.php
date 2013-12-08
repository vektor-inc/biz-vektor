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
	global $user_level;
	get_currentuserinfo();
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'id' => 'admin_top',
		'title' => _x( 'Managing pages', 'BizVektor admin header menu', 'biz-vektor' ),
		'href' =>  get_admin_url()
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'admin_top',
			'id' => 'public_page',
			'title' => _x( 'Visit site', 'BizVektor admin header menu', 'biz-vektor' ),
			'href' => home_url( '/' )
		));
		if (10 <= $user_level) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'admin_top',
				'id' => 'general_setting_page',
				'title' => _x( 'General setting', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'options-general.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'admin_top',
				'id' => 'plugins_page',
				'title' => _x( 'Plugins page', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'plugins.php',
			));
		} // level 10
	if (10 <= $user_level) {
		$wp_admin_bar->add_menu( array(
			'id' => 'bizvektor_theme_setting',
			'title' => _x( 'Theme options', 'BizVektor admin header menu', 'biz-vektor' ),
			'href' =>  get_admin_url().'themes.php?page=theme_options',
		));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'customize_page',
				'title' => _x( 'Customizer', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'customize.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Site title & desctiption',
				'title' => _x( 'Site title & desctiption', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'options-general.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Main visual of homepage',
				'title' => _x( 'Main visual of homepage', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=custom-header',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Setting of front page under the main visual',
				'title' => _x( 'Setting of front page under the main visual', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'options-reading.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Theme options',
				'title' => _x( 'Theme options', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=theme_options',
			));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'Design setting',
					'title' => _x( 'Design setting', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#design',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'Contact setting',
					'title' => _x( 'Contact setting', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#contactInfo',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'Home 3PR area',
					'title' => _x( 'Home 3PR area', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#prBox',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'post setting',
					'title' => sprintf(_x('Setting of %1$s & %2$s', 'BizVektor admin header menu', 'biz-vektor'),bizVektorOptions('infoLabelName'),bizVektorOptions('postLabelName')),
					'href' => get_admin_url().'themes.php?page=theme_options#postSetting',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'SEO & GA',
					'title' => _x( 'SEO & GA', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#seoSetting',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'Home page setting',
					'title' => _x( 'Home page setting', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#topPage',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'SNS',
					'title' => _x( 'SNS', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#snsSetting',
				));
				$wp_admin_bar->add_menu( array(
					'parent' => 'Theme options',
					'id' => 'Slide',
					'title' => _x( 'Slide', 'BizVektor admin header menu', 'biz-vektor' ),
					'href' => get_admin_url().'themes.php?page=theme_options#slideSetting',
				));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Menu setting',
				'title' => _x( 'Menu setting', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'nav-menus.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Widget setting',
				'title' => _x( 'Widget setting', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'widgets.php',
			));
			$wp_admin_bar->add_menu( array(
				'parent' => 'bizvektor_theme_setting',
				'id' => 'Background setting',
				'title' => _x( 'Background setting', 'BizVektor admin header menu', 'biz-vektor' ),
				'href' => get_admin_url().'themes.php?page=custom-background',
			));
	} // lebel 10
	// post
	$wp_admin_bar->add_menu( array(
		'id' => 'postLabelName',
		'title' => sprintf( _x( 'Manage of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
		'href' => get_admin_url().'edit.php',
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'postLabelName',
			'id' => 'postAdminMenu_list',
			'title' => sprintf( _x( 'Entry list of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
			'href' => get_admin_url().'edit.php',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => 'postLabelName',
			'id' => 'postAdminMenu_new',
			'title' => sprintf( _x( 'New post of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
			'href' => get_admin_url().'post-new.php',
		));
		if (7 <= $user_level) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'postLabelName',
				'id' => 'postAdminMenu_category',
				'title' => sprintf( _x( 'Category of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ),
				'href' => get_admin_url().'edit-tags.php?taxonomy=category',
			));
		}
	// info
	$wp_admin_bar->add_menu( array(
		'id' => 'infoLabelName',
		'title' => sprintf( _x( 'Manage of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
		'href' => get_admin_url().'edit.php?post_type=info',
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'infoLabelName',
			'id' => 'post_list',
			'title' => sprintf( _x( 'Entry list of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
			'href' => get_admin_url().'edit.php?post_type=info',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => 'infoLabelName',
			'id' => 'post_new',
			'title' => sprintf( _x( 'New post of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
			'href' => get_admin_url().'post-new.php?post_type=info',
		));
		if (7 <= $user_level) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'infoLabelName',
				'id' => 'post_category',
				'title' => sprintf( _x( 'Category of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ),
				'href' => get_admin_url().'edit-tags.php?taxonomy=info-cat',
			));
		}

	// page
	if (7 <= $user_level) {
	$wp_admin_bar->add_menu( array(
		'id' => 'page_adminMenu',
		'title' => _x( 'Manage of page', 'BizVektor admin header menu', 'biz-vektor' ),
		'href' => get_admin_url().'edit.php?post_type=page',
	));
		$wp_admin_bar->add_menu( array(
			'parent' => 'page_adminMenu',
			'id' => 'adminMenu_post_list',
			'title' => _x( 'Entry list of page', 'BizVektor admin header menu', 'biz-vektor' ),
			'href' => get_admin_url().'edit.php?post_type=page',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => 'page_adminMenu',
			'id' => 'adminMenu_post_new',
			'title' => _x( 'New post of page', 'BizVektor admin header menu', 'biz-vektor' ),
			'href' => get_admin_url().'post-new.php?post_type=page',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => 'page_adminMenu',
			'id' => 'adminMenu_post_order',
			'title' => _x( 'Change page list order [ My page order plugin]', 'BizVektor admin header menu', 'biz-vektor' ),
			'href' => get_admin_url().'edit.php?post_type=page&page=mypageorder',
		));
	}

}
add_action( 'admin_bar_menu', 'bizvektor_adminbar_custom_menu',20 );