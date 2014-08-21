<?php
global $biz_vektor_options;
// 3PRが「表示しない」にチェックされていない場合
if ( !isset($biz_vektor_options['top3PrDisplay']) || !$biz_vektor_options['top3PrDisplay'] ) {

/*-------------------------------------------*/
// 初期状態でもエラーが出ない事を確認したら削除
/*-------------------------------------------*/
// // load default
// bizVektorOptions_default();
// global $bizVektorOptions_default;

// for ( $i = 1; $i <= 3 ;){
// 	if ( !isset($biz_vektor_options['pr'.$i.'_title']) ) 
// 		$biz_vektor_options['pr'.$i.'_title'] = $bizVektorOptions_default['pr'.$i.'_title'];
// 	if ( !isset($biz_vektor_options['pr'.$i.'_description']) ) 
// 		$biz_vektor_options['pr'.$i.'_description'] = $bizVektorOptions_default['pr'.$i.'_description'];
// 	if ( !isset($biz_vektor_options['pr'.$i.'_link']) ) 
// 		$biz_vektor_options['pr'.$i.'_link'] = $bizVektorOptions_default['pr'.$i.'_link'];
// 	if ( !isset($biz_vektor_options['pr'.$i.'_image']) ) 
// 		$biz_vektor_options['pr'.$i.'_image'] = $bizVektorOptions_default['pr'.$i.'_image'];
// 	if ( !isset($biz_vektor_options['pr'.$i.'_image_s']) ) 
// 		$biz_vektor_options['pr'.$i.'_image_s'] = $bizVektorOptions_default['pr'.$i.'_image_s'];
// $i++;
// }
/*-------------------------------------------*/
// ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲
/*-------------------------------------------*/
?>
	<!-- [ #topPr ] -->
	<div id="topPr" class="topPr">
	<div id="topPrLeft" class="topPrOuter">
	<div class="topPrInner">
	<h3 class="topPrTit"><a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>"><?php echo $biz_vektor_options['pr1_title'] ?></a></h3>
	<?php if ($biz_vektor_options['pr1_image']) { ?>
		<div class="prImage">
		<a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>">
		<img src="<?php echo$biz_vektor_options['pr1_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr1_title']) ; ?>" class="imageWide" />
		<img src="<?php echo $biz_vektor_options['pr1_image_s'] ?>" alt="" class="imageSmall" />
		</a>
		</div>
	<?php } ?>
	<div class="topPrTxtBox">
		<p class="topPrDescription"><a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>"><?php echo nl2br(esc_textarea($biz_vektor_options['pr1_description'])) ?></a></p>
		<div class="moreLink"><a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>"><?php echo _x( 'Read more', 'Link to page', 'biz-vektor' ); ?></a></div>
	</div>
	</div>
	</div><!-- /#topPrLeft -->
	
	<div id="topPrCenter" class="topPrOuter">
	<div class="topPrInner">
	<h3 class="topPrTit"><a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>"><?php echo $biz_vektor_options['pr2_title'] ?></a></h3>
	<?php if ($biz_vektor_options['pr2_image']) { ?>
		<div class="prImage">
		<a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>">
		<img src="<?php echo $biz_vektor_options['pr2_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr2_title']) ; ?>" class="imageWide" />
		<img src="<?php echo $biz_vektor_options['pr2_image_s'] ?>" alt="" class="imageSmall" />
		</a>
		</div>
	<?php } ?>
	<div class="topPrTxtBox">
		<p class="topPrDescription"><a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>"><?php echo nl2br(esc_textarea($biz_vektor_options['pr2_description'])) ?></a></p>
		<div class="moreLink"><a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>"><?php echo _x( 'Read more', 'Link to page', 'biz-vektor' ); ?></a></div>
	</div>
	</div>
	</div><!-- /#topPrCenter -->
	
	<div id="topPrRight" class="topPrOuter">
	<div class="topPrInner">
	<h3 class="topPrTit"><a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>"><?php echo $biz_vektor_options['pr3_title'] ?></a></h3>
	<?php if ($biz_vektor_options['pr3_image']) { ?>
		<div class="prImage">
		<a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>">
		<img src="<?php echo $biz_vektor_options['pr3_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr3_title']) ; ?>" class="imageWide" />
		<img src="<?php echo $biz_vektor_options['pr3_image_s'] ?>" alt="" class="imageSmall" />
		</a>
		</div>
	<?php } ?>
	<div class="topPrTxtBox">
		<p class="topPrDescription"><a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>"><?php echo nl2br(esc_textarea($biz_vektor_options['pr3_description'])) ?></a></p>
		<div class="moreLink"><a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>"><?php echo _x( 'Read more', 'Link to page', 'biz-vektor' ); ?></a></div>
	</div>
	</div>
	</div><!-- /#topPrRight -->
	</div>
	<!-- [ #topPr ] -->

<?php } ?>
<?php if ( is_user_logged_in() == TRUE ) {
global $user_level;
get_currentuserinfo();
if (10 <= $user_level) { ?>
<div class="adminEdit">
<a href="<?php echo site_url(); ?>/wp-admin/themes.php?page=theme_options#prBox" class="btn btnS btnAdmin"><?php _e('Edit', 'biz-vektor');?></a>
</div>
<?php }
} ?>