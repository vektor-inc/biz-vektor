<?php // 電話番号または問い合わせページのURLが設定されている場合に表示
$options = biz_vektor_get_theme_options();
if ($options['contact_link'] || $options['tel_number']) :?>
<div class="mainFoot">
<div class="mainFootInner">
<!-- [ .mainFootContact ] --> 
<div class="mainFootContact"> 
<p class="mainFootTxt">
<?php biz_vektor_mainfootContact(); ?>
</p>
<?php // 問い合わせページのURLが設定されている場合に表示
$options = biz_vektor_get_theme_options();
if ($options['contact_link']) :?>
<div class="mainFootBt"><a href="<?php echo $options['contact_link'] ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bt_contact.png" alt="メールでお問い合わせはこちら" /></a></div> 
<?php endif; ?>
</div> 
<!-- [ /.mainFootContact ] -->
</div>
</div>
<?php endif; ?>