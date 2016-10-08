<?php get_header(); ?>
<!-- [ #container ] -->
<div id="container" class="innerBox">
	<!-- [ #content ] -->
	<div id="content" class="content">
	<?php biz_vektor_contentMain_before();?>
	<div id="content-main">
<?php
if ( biz_vektor_is_plugin_enable('widgets') && is_active_sidebar( 'top-main-widget-area' ) ) :

	dynamic_sidebar( 'top-main-widget-area' );
else :

	/*-------------------------------------------*/
	/*	No use main content widget
	/*-------------------------------------------*/

	// Widget guide message
	if ( is_user_logged_in() == TRUE && biz_vektor_is_plugin_enable('widgets')) {

		if ( current_user_can('edit_theme_options') ) { ?>
			<div class="adminEdit sectionFrame">
			<?php
			$customizer_link = '<a href="'.admin_url().'customize.php'.'">'.__( 'Customizer' , 'biz-vektor' ).'</a>';
			$widget_link =  '<a href="'.admin_url().'customize.php'.'">'.__( 'Widdget Setting Page' , 'biz-vektor' ).'</a>';
			echo '<p>'.sprintf(__( 'Items and the order that displayed on the home page, you can set freely from %s or %s.', 'biz-vektor' ), $customizer_link, $widget_link ).'<br />';
			echo __('Set on widget item to the  "Main content(Homepage)" widget area.', 'biz-vektor' ).'</p>';
			?>
			</div>
		<?php } // if ( current_user_can('edit_theme_options') ) { 	?>
	<?php }

	// page content
	if ( have_posts()) : the_post();
		if (get_post_type() === 'page') :
			$topFreeContent = NULL;
			$topFreeContent = get_the_content();
			if ($topFreeContent) : ?>
	<div id="topFreeArea">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>' ) ); ?>
	</div>
	<?php endif; // $topFreeContent ?>
	<?php endif; // get_post_type() === 'page' ?>

	<?php if ( is_user_logged_in() == TRUE ) { ?>
		<div class="adminEdit">
			<?php if ( current_user_can('activate_plugins') ) : ?>
			<p class="caption">
			<?php esc_html_e( '* In admin [Settings] &raquo; [Display Settings], if the front page is not set to a [page], nothing is displayed in this area.', 'biz-vektor' ); ?><br />
			<?php esc_html_e( '* If empty, the body of a page that you set as the front page does not display anything.', 'biz-vektor' ); ?><br />
			<?php // esc_html_e( '* If you have set a specific page as the front page, pagination does not appear at the bottom.', 'biz-vektor' ); ?>
			</p>
			<?php endif; ?>
			<span class="linkBtn linkBtnS linkBtnAdmin" style="float:left;margin-right:10px;"><?php edit_post_link( __( 'Edit', 'biz-vektor' ) ); ?></span>
			<?php if ( current_user_can('activate_plugins') ) : ?>
			<span style="float:left;margin-right:10px;"><a href="<?php echo site_url(); ?>/wp-admin/themes.php?page=theme_options#topPage" class="btn btnS btnAdmin">
				<?php esc_html_e('Title display settings', 'biz-vektor'); ?>
			</a></span>
			<span><a href="<?php echo site_url(); ?>/wp-admin/options-reading.php" class="btn btnS btnAdmin">
				<?php esc_html_e('Change the page to be displayed', 'biz-vektor'); ?>
			</a></span>
			<?php endif; ?>
		</div>
	<?php } // login ?>

	<?php endif; // have_posts() ?>

	<?php get_template_part('module_topPR'); ?>
	<?php if ( function_exists( 'biz_vektor_topSpecial' ) ): biz_vektor_topSpecial(); endif; ?>
	<?php get_template_part('module_top_list_info'); ?>
	<?php get_template_part('module_top_list_post'); ?>
<?php endif; ?>

<?php do_action('biz_vektor_fbLikeBoxDisplay'); ?>
<?php do_action('biz_vektor_snsBtns'); ?>
<?php do_action('biz_vektor_fbComments'); ?>

	</div>
	<!-- #content-main -->
	<?php biz_vektor_contentMain_after();?>
	</div>
	<!-- [ /#content ] -->
<?php $option = biz_vektor_get_theme_options();if(!$option['topSideBarDisplay']){ ?>
	<!-- [ #sideTower ] -->
	<div id="sideTower" class="sideTower">
<?php
if ( is_active_sidebar( 'common-side-top-widget-area' ) ) dynamic_sidebar( 'common-side-top-widget-area' );
if ( is_active_sidebar( 'top-side-widget-area' ) ) :
	dynamic_sidebar( 'top-side-widget-area' );
else :
	// ウィジェットに設定がない場合
	if (function_exists('biz_vektor_contactBtn'))    biz_vektor_contactBtn();
	if (function_exists('biz_vektor_snsBnrs'))       biz_vektor_snsBnrs();
endif;
if ( is_active_sidebar( 'common-side-bottom-widget-area' ) ) dynamic_sidebar( 'common-side-bottom-widget-area' );
?>
	</div>
	<!-- [ /#sideTower ] -->
	<?php biz_vektor_sideTower_after();?>
<?php } ?>
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>