<div class="wrap">
	<h2><?php echo __( 'CSSをカスタマイズ', 'biz_vektor_css_customize_title') ?></h2>
	<div class="fileedit-sub"></div>
	<?php echo $data['mess']; ?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="template">
		<textarea name="bv-css-css" cols="70" rows="30" id="newcontent"><?php echo esc_attr($data['customCss']); ?></textarea>
		<?php wp_nonce_field( 'biz-vektor-css-submit', 'biz-vektor-css-nonce'); ?>
		<p class="submit">
			<input type="submit" name="bv-css-submit" class="button button-primary" value="<?php echo __( 'CSSを更新', 'biz_vektor_css_customize_submit') ?>" />
		</p>
	</form>
</div>
