<div class="wrap">
	<h2><?php echo __( 'CSSカスタマイズ', 'biz_vektor_css_customize_title') ?></h2>
	<div class="fileedit-sub"></div>
	<?php echo $data['mess']; ?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="template">
		<textarea name="bv-css-css" cols="70" rows="10" id="newcontent"><?php echo esc_attr($data['customCss']); ?></textarea>
		<?php wp_nonce_field( 'biz-vektor-css-submit', 'biz-vektor-css-nonce'); ?>
		<p class="submit">
			<input type="submit" name="bv-css-submit" class="button button-primary" value="<?php echo __( 'CSSを更新', 'biz_vektor_css_customize_submit') ?>" />
		</p>
	</form>

<div id="tipsList">
<h3>デザインカスタマイズ例文リスト</h3>
<ul>
</ul>
</div>

<div id="tipsBody">

<dl id="mainContentWidth">
<dt>PC画面でメインエリアの幅を広くする</dt>
<dd>
<code>
@media (min-width: 970px) {<br>
#main #container #content { width:680px; }<br>
}
</code>
</dd>
</dl>

<dl id="sideBarWidth">
<dt>PC画面でサイドバーの幅を広くする</dt>
<dd>
<code>
@media (min-width: 970px) {<br>
#main #container #sideTower { width:260px; }<br>
}
</code>
</dd>
</dl>

<dl id="postThumbnailLeft">
<dt>投稿のサムネイルを画像を左側にする</dt>
<dd>
<code>#content .infoList .infoListBox div.thumbImage { float:left; }<br>
#content .infoList .infoListBox div.entryTxtBox.haveThumbnail { float:right }
</code>
</dd>
</dl>

</div><!-- [ /#tipsBody ] -->
</div>