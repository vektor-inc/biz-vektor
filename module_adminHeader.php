<?php
// 管理者：10 編集者：7 投稿者：2 寄稿者：1 購読者：0 
global $user_level;
get_currentuserinfo();
if (1 <= $user_level) { ?>
<link rel='stylesheet' id='theme-css'  href='<?php echo get_template_directory_uri(); ?>/style_BizVektor_adminHeader.css' type='text/css' media='all' />
<div id="adminHeaderOuter">
<div id="adminHeaderMenu">
<ul>
<li><a href="<?php echo get_admin_url(); ?>"><?php echo _x( 'Managing pages', 'BizVektor admin header menu', 'biz-vektor' ); ?></a>
	<ul>
	<li><a href="<?php echo home_url( '/' ); ?>"><?php echo _x( 'Visit site', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<?php // 管理者のみ
	global $user_level;
	get_currentuserinfo();
	if (10 <= $user_level) { ?>
	<li><a href="<?php echo get_admin_url(); ?>plugins.php"><?php echo _x( 'Plugins page', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<?php } ?>
	</ul>
</li>
<?php // 管理者のみ
if (10 <= $user_level) { ?>
<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options"><?php echo _x( 'Theme options', 'BizVektor admin header menu', 'biz-vektor' ); ?></a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>customize.php"><?php echo _x( 'Customizer', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<li><a href="<?php echo get_admin_url(); ?>options-general.php"><?php echo _x( 'Site title & desctiption', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<li><a href="<?php echo get_admin_url(); ?>themes.php?page=custom-header"><?php echo _x( 'Main visual of homepage', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<li><a href="<?php echo get_admin_url(); ?>options-reading.php"><?php echo _x( 'Setting of front page under the main visual', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options"><?php echo _x( 'Theme options', 'BizVektor admin header menu', 'biz-vektor' ); ?></a>
		<ul>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#design"><?php echo _x( 'Design setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#contactInfo"><?php echo _x( 'Contact setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#prBox"><?php echo _x( 'Home 3PR area', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#postSetting">
			<?php printf(_x('Setting of %1$s & %2$s', 'BizVektor admin header menu', 'biz-vektor'),bizVektorOptions('infoLabelName'),bizVektorOptions('postLabelName')); ?>
			</a></li>

		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#seoSetting"><?php echo _x( 'SEO & GA', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#topPage"><?php echo _x( 'Home page setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#snsSetting"><?php echo _x( 'SNS', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#slideSetting"><?php echo _x( 'Slide', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		</ul>
	</li>
	<li id="adminHead_menuSetting"><a href="<?php echo get_admin_url(); ?>nav-menus.php"><?php echo _x( 'Menu setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a>
	<?php if ( !function_exists( 'biz_vektor_activation' ) ) { ?>
		<ul>
		<li><a href="http://bizvektor.com/setting/menu/" target="_blank"><?php echo _x( 'How to menu setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
		</ul>
	<?php } ?>
	</li>
	<li><a href="<?php echo get_admin_url(); ?>widgets.php"><?php echo _x( 'Widget setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<li><a href="<?php echo get_admin_url(); ?>themes.php?page=custom-background"><?php echo _x( 'Background setting', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	</ul>
</li>
<?php } ?>
<li><a href="<?php echo get_admin_url(); ?>edit.php">
	<?php printf( _x( 'Manage of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ); ?></a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>edit.php">
		<?php printf( _x( 'Entry list of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ); ?>
		</a></li>
	<li><a href="<?php echo get_admin_url(); ?>post-new.php">
		<?php printf( _x( 'New post of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ); ?>
	</a></li>
	<?php // 編集者以上
	if (7 <= $user_level) { ?>
	<li><a href="<?php echo get_admin_url(); ?>edit-tags.php?taxonomy=category">
		<?php printf( _x( 'Category of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('postLabelName') ); ?>
	</a></li>
	<?php } ?>
	</ul>
</li>
<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=info">
	<?php printf( _x( 'Manage of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ); ?>
	</a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=info">
		<?php printf( _x( 'Entry list of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ); ?>
		</a></li>
	<li><a href="<?php echo get_admin_url(); ?>post-new.php?post_type=info">
		<?php printf( _x( 'New post of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ); ?>
		</a></li>
	<?php // Editor
	if (7 <= $user_level) { ?>
	<li><a href="<?php echo get_admin_url(); ?>edit-tags.php?taxonomy=info-cat">
		<?php printf( _x( 'Category of %s', 'BizVektor admin header menu', 'biz-vektor' ),bizVektorOptions('infoLabelName') ); ?>
		</a></li>
	<?php } ?>
	</ul>
</li>
<?php // Editor
if (7 <= $user_level) { ?>
<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=page"><?php echo _x( 'Manage of page', 'BizVektor admin header menu', 'biz-vektor' ); ?></a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=page"><?php echo _x( 'Entry list of page', 'BizVektor admin header menu', 'biz-vektor' ); ?></a>
	<li><a href="<?php echo get_admin_url(); ?>post-new.php?post_type=page"><?php echo _x( 'New post of page', 'BizVektor admin header menu', 'biz-vektor' ); ?></a></li>
	<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=page&page=mypageorder">
		<?php echo _x( 'Change page list order <br />[ My page order plugin]', 'BizVektor admin header menu', 'biz-vektor' ); ?>
		</a></li>
	</ul>
</li>
<?php } ?>
<li><?php wp_loginout(); ?></li>
</ul>
</div>
</div>
<?php } ?>