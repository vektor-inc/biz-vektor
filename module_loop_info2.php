<?php $taxo_catelist = get_the_term_list( $post->ID,'info-cat','','',''); ?>
<!-- [ .infoListBox ] -->
<div class="infoListBox">
	<div class="entryTxtBox <?php if ( has_post_thumbnail()) : ?>haveThumbnail<?php endif; ?>">
	<h4 class="entryTitle">
	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	<?php if ( is_user_logged_in() == TRUE ) : edit_post_link('編集', '<span class="edit-link">[ ', ' ]</span>');endif ?>
	</h4>
	<p class="entryMeta">
	<span class="infoDate"><?php echo esc_html( get_the_date() ); ?></span><span class="infoCate"><?php echo $taxo_catelist; ?></span>
	</p>
	<p><?php the_excerpt(); ?></p>
	<div class="moreLink"><a href="<?php the_permalink(); ?>">この記事を読む</a></div>
	</div><!-- [ /.entryTxtBox ] -->
	
	<?php if ( has_post_thumbnail()) { ?>
		<div class="thumbImage">
		<div class="thumbImageInner">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		</div>
		</div><!-- [ /.thumbImage ] -->
	<?php } ?>	
</div><!-- [ /.infoListBox ] -->