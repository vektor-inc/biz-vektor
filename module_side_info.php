<?php
/*
投稿タイプのトップの固定ページで使われた場合に、
どの投稿タイプ用のサイドバーを表示するのか自動判別する手段が無いため保留

global $wp_query;
// カスタム投稿タイプの種類を取得
$postType = get_post_type();
// カスタム投稿タイプ名を取得
$postTypeName = esc_html(get_post_type_object(get_post_type())->labels->name);
// 標準のpost のラベル名
$postLabelName = bizVektorOptions('postLabelName');
*/
?>
<?php
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
	<h3 class="localHead">カテゴリー</h3>
	<ul class="localNavi">
    <?php echo $catlist; ?>
	</ul>
	</div>
	</div>
<?php } ?>

<div class="localSection sideWidget">
<div class="localNaviBox">
<h3 class="localHead">アーカイブ</h3>
<ul class="localNavi">
<?php wp_get_archives('type=yearly&post_type=info&after=年'); ?>
</ul>
</div>
</div>