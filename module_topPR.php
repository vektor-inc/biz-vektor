<?php
$options = biz_vektor_get_theme_options();
if ($options['pr1_title'] || $options['pr2_title'] || $options['pr3_title']) {
?>
	<!-- [ #topPr ] -->
	<div id="topPr">
	<div id="topPrLeft" class="topPrOuter">
	<div class="topPrInner">
	<h3 class="topPrTit"><a href="<?php echo esc_url($options['pr1_link']) ?>"><?php echo $options['pr1_title'] ?></a></h3>
	<?php if ($options['pr1_image']) { ?>
		<div class="prImage">
		<a href="<?php echo esc_url($options['pr1_link']) ?>">
		<img src="<?php echo$options['pr1_image'] ?>" alt="<?php echo $options['pr1_title'] ?>イメージ" class="imageWide" />
		<img src="<?php echo $options['pr1_image_s'] ?>" alt="" class="imageSmall" />
		</a>
		</div>
	<?php } ?>
	<div class="topPrTxtBox">
		<p class="topPrDescription"><a href="<?php echo esc_url($options['pr1_link']) ?>"><?php echo esc_html($options['pr1_description']) ?></a></p>
		<div class="moreLink"><a href="<?php echo esc_url($options['pr1_link']) ?>">詳しくはこちら</a></div>
	</div>
	</div>
	</div><!-- /#topPrLeft -->
	
	<div id="topPrCenter" class="topPrOuter">
	<div class="topPrInner">
	<h3 class="topPrTit"><a href="<?php echo esc_url($options['pr2_link']) ?>"><?php echo $options['pr2_title'] ?></a></h3>
	<?php if ($options['pr2_image']) { ?>
		<div class="prImage">
		<a href="<?php echo esc_url($options['pr2_link']) ?>">
		<img src="<?php echo $options['pr2_image'] ?>" alt="<?php echo $options['pr2_title'] ?>イメージ" class="imageWide" />
		<img src="<?php echo $options['pr2_image_s'] ?>" alt="" class="imageSmall" />
		</a>
		</div>
	<?php } ?>
	<div class="topPrTxtBox">
		<p class="topPrDescription"><a href="<?php echo esc_url($options['pr2_link']) ?>"><?php echo esc_html($options['pr2_description']) ?></a></p>
		<div class="moreLink"><a href="<?php echo esc_url($options['pr2_link']) ?>">詳しくはこちら</a></div>
	</div>
	</div>
	</div><!-- /#topPrCenter -->
	
	<div id="topPrRight" class="topPrOuter">
	<div class="topPrInner">
	<h3 class="topPrTit"><a href="<?php echo esc_url($options['pr3_link']) ?>"><?php echo $options['pr3_title'] ?></a></h3>
	<?php if ($options['pr3_image']) { ?>
		<div class="prImage">
		<a href="<?php echo esc_url($options['pr3_link']) ?>">
		<img src="<?php echo $options['pr3_image'] ?>" alt="<?php echo $options['pr3_title'] ?>イメージ" class="imageWide" />
		<img src="<?php echo $options['pr3_image_s'] ?>" alt="" class="imageSmall" />
		</a>
		</div>
	<?php } ?>
	<div class="topPrTxtBox">
		<p class="topPrDescription"><a href="<?php echo esc_url($options['pr3_link']) ?>"><?php echo esc_html($options['pr3_description']) ?></a></p>
		<div class="moreLink"><a href="<?php echo esc_url($options['pr3_link']) ?>">詳しくはこちら</a></div>
	</div>
	</div>
	</div><!-- /#topPrRight -->
	</div>
	<!-- [ #topPr ] -->

	<?php if ( is_user_logged_in() == TRUE ) {　?>
	<div class="adminEdit">
	<a href="<?php echo site_url(); ?>/wp-admin/themes.php?page=theme_options#topPage" class="btn btnS btnAdmin">編集</a>
	</div>
	<?php } ?>
<?php } ?>