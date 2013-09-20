<div id="comments">
<?php if ( post_password_required() ) : ?>
<?php // No Passwords comment ?>
</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
<h3 id="comments-title"><?php _e('Comment', 'biz-vektor'); ?></h3>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<div class="navigation">
		<div class="nav-previous"><?php previous_comments_link( __('&laquo; Older Comments', 'biz-vektor') ); ?></div>
		<div class="nav-next"><?php next_comments_link( __('Newer Comments &raquo;', 'biz-vektor') ); ?></div>
	</div> <!-- .navigation -->
	<br />
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'biz_vektor_comment' ) );	?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<div class="navigation">
		<div class="nav-previous"><?php previous_comments_link( __('&laquo; Older Comments', 'biz-vektor') ); ?></div>
		<div class="nav-next"><?php next_comments_link( __('Newer Comments &raquo;', 'biz-vektor') ); ?></div>
	</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : if ( ! comments_open() ) :?>
<?php // Comment don't open ?>
<?php endif; ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
