<?php
// 管理者：10 編集者：7 投稿者：2 寄稿者：1 購読者：0 
global $user_level;
get_currentuserinfo();
if (1 <= $user_level) { ?>
<link rel='stylesheet' id='theme-css'  href='<?php echo get_template_directory_uri(); ?>/style_BizVektor_adminHeader.css' type='text/css' media='all' />
<div id="adminHeaderOuter">
<div id="adminHeaderMenu">
<ul>
<li><a href="<?php echo get_admin_url(); ?>">管理画面</a>
	<ul>
	<li><a href="<?php echo home_url( '/' ); ?>">公開ページを見る</a></li>
	<?php // 管理者のみ
	global $user_level;
	get_currentuserinfo();
	if (10 <= $user_level) { ?>
	<li><a href="<?php echo get_admin_url(); ?>plugins.php">プラグインの管理</a></li>
	<?php } ?>
	</ul>
</li>
<?php // 管理者のみ
if (10 <= $user_level) { ?>
<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options">テーマの管理</a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>customize.php">テーマカスタマイザー</a></li>
	<li><a href="<?php echo get_admin_url(); ?>options-general.php">タイトル・キャッチコピー（説明）</a></li>
	<li><a href="<?php echo get_admin_url(); ?>themes.php?page=custom-header">トップページのメインビジュアル</a></li>
	<li><a href="<?php echo get_admin_url(); ?>options-reading.php">トップページのメインビジュアルの下に表示するページの設定</a></li>
	<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options">テーマオプション</a>
		<ul>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#design">デザインの設定</a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#postSetting">「<?php echo bizVektorOptions('infoLabelName') ?>」と「<?php echo bizVektorOptions('postLabelName') ?>」の設定</a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#contactInfo">連絡先の設定</a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#seoSetting">SEOの設定</a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#topPage">トップページの設定</a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#snsSetting">SNS連携の設定</a></li>
		<li><a href="<?php echo get_admin_url(); ?>themes.php?page=theme_options#slideSetting">スライドショーの設定</a></li>
		</ul>
	</li>
	<li id="adminHead_menuSetting"><a href="<?php echo get_admin_url(); ?>nav-menus.php">メニューの設定</a>
	<?php if ( !function_exists( 'biz_vektor_activation' ) ) { ?>
		<ul>
		<li><a href="http://bizvektor.com/setting/menu/" target="_blank">メニューの設定方法</a></li>
		</ul>
	<?php } ?>
	</li>
	<li><a href="<?php echo get_admin_url(); ?>widgets.php">ウィジェット</a></li>
	<li><a href="<?php echo get_admin_url(); ?>themes.php?page=custom-background">背景の設定</a></li>
	</ul>
</li>
<?php } ?>
<li><a href="<?php echo get_admin_url(); ?>edit.php"><?php echo bizVektorOptions('postLabelName') ?>の管理</a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>edit.php"><?php echo bizVektorOptions('postLabelName') ?>記事一覧</a></li>
	<li><a href="<?php echo get_admin_url(); ?>post-new.php"><?php echo bizVektorOptions('postLabelName') ?>の投稿</a></li>
	<?php // 編集者以上
	if (7 <= $user_level) { ?>
	<li><a href="<?php echo get_admin_url(); ?>edit-tags.php?taxonomy=category"><?php echo bizVektorOptions('postLabelName') ?>のカテゴリー</a></li>
	<?php } ?>
	</ul>
</li>
<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=info"><?php echo bizVektorOptions('infoLabelName') ?>の管理</a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=info"><?php echo bizVektorOptions('infoLabelName') ?>一覧</a></li>
	<li><a href="<?php echo get_admin_url(); ?>post-new.php?post_type=info"><?php echo bizVektorOptions('infoLabelName') ?>の投稿</a></li>
	<?php // 編集者以上
	if (7 <= $user_level) { ?>
	<li><a href="<?php echo get_admin_url(); ?>edit-tags.php?taxonomy=info-cat"><?php echo bizVektorOptions('infoLabelName') ?>のカテゴリー</a></li>
	<?php } ?>
	</ul>
</li>
<?php // 編集者以上
if (7 <= $user_level) { ?>
<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=page">ページの管理</a>
	<ul>
	<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=page">ページ一覧</a>
	<li><a href="<?php echo get_admin_url(); ?>post-new.php?post_type=page">ページの追加</a></li>
	<li><a href="<?php echo get_admin_url(); ?>edit.php?post_type=page&page=mypageorder">ページの並び替え<br />（プラグイン「My Page Order」）</a></li>
	</ul>
</li>
<?php } ?>
<li><?php wp_loginout(); ?></li>
</ul>
</div>
</div>
<?php } ?>