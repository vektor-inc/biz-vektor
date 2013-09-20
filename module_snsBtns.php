<!-- [ .socialSet ] -->
<?php if (is_home() || is_front_page()) {
	$linkUrl = home_url();
} else if (is_single() || (is_page() && !is_front_page())) {
	//$twitterUrl = home_url().'/?p='.get_the_ID();
	//idだとURLは短くなるが、URLが違うためカウントされない為パーマリンクに戻し
	$twitterUrl = get_permalink();
	$linkUrl = get_permalink();
} else {
	$linkUrl = get_permalink();
}
?>
<div id="socialSet">
<ul style="margin-left:0px;">
<li>
</li>
<li class="sb_hatena"><a href="http://b.hatena.ne.jp/entry65+325/<?php echo $linkUrl; ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php getHeadTitle(); ?>" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async></script></li>
<li class="sb_google"><g:plusone size="medium"></g:plusone></li>
<li class="sb_twitter">
<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $twitterUrl; ?>" data-lang="ja" data-via="<?php echo twitterID() ?>">ツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</li>
<?php if (mixiKey()) : ?>
<li class="sb_mixi">
<div data-plugins-type="mixi-favorite" data-service-key="<?php echo mixiKey() ?>" data-size="medium" data-href="<?php echo $linkUrl; ?>" data-show-faces="false" data-show-count="true" data-show-comment="true" data-width=""></div><script type="text/javascript">(function(d) {var s = d.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//static.mixi.jp/js/plugins.js#lang=ja';d.getElementsByTagName('head')[0].appendChild(s);})(document);</script>
</li>
<?php endif; ?>
<li class="sb_facebook">
<fb:like href="<?php echo $linkUrl; ?>" target="_blank" send="false" width="300" show_faces="false" layout="button_count"></fb:like>
<?php /*
<div class="fb-like" data-send="false" data-width="300" data-show-faces="false"></div>
*/ ?>
</li>
<li class="sb_pocket"><?php /* このspanがないとPocketが表示されない...orz */?><span></span>
<a data-pocket-label="pocket" data-pocket-count="horizontal" class="pocket-btn" data-save-url="<?php echo $linkUrl; ?>" data-lang="en"></a>
<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
</li>
<li class="sb_line">
<a href="http://line.naver.jp/R/msg/text/?<?php getHeadTitle(); ?>%0D%0A<?php echo $linkUrl; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/linebutton_88x20.png" alt="LINEで送る" /></a>
</li>
</ul>

</div>
<!-- [ /.socialSet ] -->