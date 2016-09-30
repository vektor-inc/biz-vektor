<?php
$biz_vektor_options = biz_vektor_get_theme_options();
// 3PRが「表示しない」にチェックされていない場合
if ( !isset($biz_vektor_options['top3PrDisplay']) || !$biz_vektor_options['top3PrDisplay'] ) { ?>

<!-- [ #topPr ] -->
<div id="topPr" class="topPr">
<?php
$pr_id = array(
	'1' => 'topPrLeft',
	'2' => 'topPrCenter',
	'3' => 'topPrRight',
	);
for ( $i = 1; $i <= 3 ;)
{ ?>
	<div id="<?php echo $pr_id[$i];?>" class="topPrOuter">
	<div class="topPrInner">
	<?php 
	//title
	if ( isset( $biz_vektor_options['pr'.$i.'_title'] ) && ! empty( $biz_vektor_options['pr'.$i.'_title'] ) ) { ?>
		<h3 class="topPrTit">
		<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr'.$i.'_link']) ?>">
			<?php } ?>
				<?php echo $biz_vektor_options['pr'.$i.'_title'] ?>
			<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
			</a>
			<?php } ?>
		</h3>
	<?php 
	} 

	//image
	if ($biz_vektor_options['pr'.$i.'_image']) { ?>
		<div class="prImage">
			<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
			<a href="<?php echo esc_url($biz_vektor_options['pr'.$i.'_link']) ?>">
			<?php } ?>
				<img src="<?php echo$biz_vektor_options['pr'.$i.'_image'] ?>" alt="<?php printf(__( 'Image of %s', 'biz-vektor' ),$biz_vektor_options['pr'.$i.'_title']) ; ?>" class="imageWide" />
				<img src="<?php echo $biz_vektor_options['pr'.$i.'_image_s'] ?>" alt="" class="imageSmall" />
			<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
			</a>
			<?php } ?>
		</div>
	<?php 
	}

	//description
	if ( isset( $biz_vektor_options['pr1_description'] )  && ! empty( $biz_vektor_options['pr1_description'] ) ) { ?>
		<div class="topPrTxtBox">
			<p class="topPrDescription">
				<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
				<a href="<?php echo esc_url($biz_vektor_options['pr'.$i.'_link']) ?>">
				<?php } ?>
					<?php echo nl2br(esc_html($biz_vektor_options['pr'.$i.'_description'])) ?>
				<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
				</a>
				<?php } ?>
			</p>
			<?php if ( isset( $biz_vektor_options['pr'.$i.'_link'] ) && ! empty( $biz_vektor_options['pr'.$i.'_link'] ) ) { ?>
				<div class="moreLink">
					<a href="<?php echo esc_url($biz_vektor_options['pr'.$i.'_link']) ?>">
						<?php echo esc_html( apply_filters( 'read_more_txt_top_pr', _x( 'Read more', 'Link to page', 'biz-vektor' ) ) ); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
	</div><!-- /#topPrLeft -->

<?php
$i++;
} // endfor
?>
</div>
<!-- [ #topPr ] -->

<?php } ?>
<?php if ( is_user_logged_in() == TRUE && current_user_can('edit_theme_options') ) { ?>
<div class="adminEdit">
<a href="<?php echo site_url(); ?>/wp-admin/themes.php?page=theme_options#prBox" class="btn btnS btnAdmin"><?php _e('Edit', 'biz-vektor');?></a>
</div>
<?php } ?>