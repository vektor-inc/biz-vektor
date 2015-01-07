<?php
global $biz_vektor_options;
// 3PRが「表示しない」にチェックされていない場合
if ( !isset($biz_vektor_options['top3PrDisplay']) || !$biz_vektor_options['top3PrDisplay'] ) {
?>
	<!-- [ #topPr ] -->
	<div id="topPr" class="topPr">
	<div id="topPrLeft" class="topPrOuter">
	<div class="topPrInner">
	<?php 
	//title
	if ( isset( $biz_vektor_options['pr1_title'] ) && ! empty( $biz_vektor_options['pr1_title'] ) ) { ?>
		<h3 class="topPrTit">
		<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>">
			<?php } ?>
				<?php echo $biz_vektor_options['pr1_title'] ?>
			<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
			</a>
			<?php } ?>
		</h3>
	<?php 
	} 

	//image
	if ($biz_vektor_options['pr1_image']) { ?>
		<div class="prImage">
			<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>">
			<?php } ?>
				<img src="<?php echo$biz_vektor_options['pr1_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr1_title']) ; ?>" class="imageWide" />
				<img src="<?php echo $biz_vektor_options['pr1_image_s'] ?>" alt="" class="imageSmall" />
			<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
			</a>
			<?php } ?>
		</div>
	<?php 
	} 

	//description
	if ( isset( $biz_vektor_options['pr1_description'] )  && ! empty( $biz_vektor_options['pr1_description'] ) ) { ?>
		<div class="topPrTxtBox">
			<p class="topPrDescription">
				<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
				<a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>">
				<?php } ?>
					<?php echo nl2br(esc_html($biz_vektor_options['pr1_description'])) ?>
				<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
				</a>
				<?php } ?>
			</p>
			<?php if ( isset( $biz_vektor_options['pr1_link'] ) && ! empty( $biz_vektor_options['pr1_link'] ) ) { ?>
				<div class="moreLink">
					<a href="<?php echo esc_url($biz_vektor_options['pr1_link']) ?>">
						<?php echo _x( 'Read more', 'Link to page', 'biz-vektor' ); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
	</div><!-- /#topPrLeft -->
	
	<div id="topPrCenter" class="topPrOuter">
	<div class="topPrInner">
	<?php 
	//title
	if ( isset( $biz_vektor_options['pr2_title'] ) && ! empty( $biz_vektor_options['pr2_title'] ) ) { ?>
		<h3 class="topPrTit">
			<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>">
			<?php } ?>
				<?php echo $biz_vektor_options['pr2_title'] ?>
			<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
			</a>
			<?php } ?>
		</h3>
		<?php 
	} 

	//image
	if ( $biz_vektor_options['pr2_image'] ) { ?>
		<div class="prImage">
			<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>">
			<?php } ?>
				<img src="<?php echo $biz_vektor_options['pr2_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr2_title']) ; ?>" class="imageWide" />
				<img src="<?php echo $biz_vektor_options['pr2_image_s'] ?>" alt="" class="imageSmall" />
			<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
			</a>
			<?php } ?>
		</div>
	<?php 
	} 

	//description
	if ( isset( $biz_vektor_options['pr2_description'] )  && ! empty( $biz_vektor_options['pr2_description'] ) ) { ?>
		<div class="topPrTxtBox">
			<p class="topPrDescription">
				<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
				<a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>">
				<?php } ?>
					<?php echo nl2br(esc_textarea($biz_vektor_options['pr2_description'])) ?>
				<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
				</a>
				<?php } ?>
			</p>
			<?php if ( isset( $biz_vektor_options['pr2_link'] ) && ! empty( $biz_vektor_options['pr2_link'] ) ) { ?>
				<div class="moreLink">
					<a href="<?php echo esc_url($biz_vektor_options['pr2_link']) ?>">
						<?php echo _x( 'Read more', 'Link to page', 'biz-vektor' ); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
	</div><!-- /#topPrCenter -->
	
	<div id="topPrRight" class="topPrOuter">
	<div class="topPrInner">
	<?php 
	//title
	if ( isset( $biz_vektor_options['pr3_title'] ) && ! empty( $biz_vektor_options['pr3_title'] ) ) { ?>
		<h3 class="topPrTit">
			<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>">
			<?php } ?>
				<?php echo $biz_vektor_options['pr3_title'] ?>
			<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
			</a>
			<?php } ?>
		</h3>
		<?php 
	} 

	//image
	if ($biz_vektor_options['pr3_image']) { ?>
		<div class="prImage">
			<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>">
			<?php } ?>
				<img src="<?php echo $biz_vektor_options['pr3_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr3_title']) ; ?>" class="imageWide" />
				<img src="<?php echo $biz_vektor_options['pr3_image_s'] ?>" alt="" class="imageSmall" />
			<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
			</a>
			<?php } ?>
		</div>
	<?php 
	} 

	//description
	if ( isset( $biz_vektor_options['pr3_description'] )  && ! empty( $biz_vektor_options['pr3_description'] ) ) { ?>
		<div class="topPrTxtBox">
			<p class="topPrDescription">
				<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
				<a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>">
				<?php } ?>
					<?php echo nl2br(esc_textarea($biz_vektor_options['pr3_description'])) ?>
				<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
				</a>
				<?php } ?>
			</p>
			<?php if ( isset( $biz_vektor_options['pr3_link'] ) && ! empty( $biz_vektor_options['pr3_link'] ) ) { ?>
				<div class="moreLink">
					<a href="<?php echo esc_url($biz_vektor_options['pr3_link']) ?>">
						<?php echo _x( 'Read more', 'Link to page', 'biz-vektor' ); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
	</div><!-- /#topPrRight -->
	</div>
	<!-- [ #topPr ] -->

<?php } ?>
<?php if ( is_user_logged_in() == TRUE && current_user_can('edit_theme_options') ) { ?>
<div class="adminEdit">
<a href="<?php echo site_url(); ?>/wp-admin/themes.php?page=theme_options#prBox" class="btn btnS btnAdmin"><?php _e('Edit', 'biz-vektor');?></a>
</div>
<?php } ?>