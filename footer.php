<?php
/**
 * The template for displaying the footer.
 */
?>
</div><!-- #main -->

<div id="back-top">
<a href="#wrap">
	<img id="pagetop" src="<?php echo get_template_directory_uri(); ?>/js/res-vektor/images/footer_pagetop.png" alt="PAGETOP" />
</a>
</div>

<!-- [ #footerSection ] -->
<div id="footerSection">

	<div id="pagetop">
	<div id="pagetopInner" class="innerBox">
	<a href="#wrap">PAGETOP</a>
	</div>
	</div>

	<div id="footMenu">
	<div id="footMenuInner" class="innerBox">
	<?php wp_nav_menu( array(
		'theme_location' => 'FooterNavi',
		'fallback_cb' => ''
	) ); ?>
	</div>
	</div>

	<!-- [ #footer ] -->
	<div id="footer">
	<!-- [ #footerInner ] -->
	<div id="footerInner" class="innerBox">
		<dl id="footerOutline">
		<dt><?php biz_vektor_footerSiteName(); ?></dt>
		<dd>
		<?php biz_vektor_print_footContact(); ?>
		</dd>
		</dl>
		<?php
		$footerSiteMap = '<!-- [ #footerSiteMap ] -->
		<div id="footerSiteMap">'."\n";
		$footerSiteMap .= wp_nav_menu(
		array(
			'theme_location' => 'FooterSiteMap',
			'fallback_cb' => '',
			'echo' => false,
		) );
		$footerSiteMap .= '</div>
		<!-- [ /#footerSiteMap ] -->'."\n";
		$footerSiteMap = apply_filters( 'bizvektor_footerSiteMap', $footerSiteMap );
		echo $footerSiteMap;
		?>
	</div>
	<!-- [ /#footerInner ] -->
	</div>
	<!-- [ /#footer ] -->

	<!-- [ #siteBottom ] -->
	<div id="siteBottom">
	<div id="siteBottomInner" class="innerBox">
	<?php biz_vektor_footerCopyRight(); ?>
	</div>
	</div>
	<!-- [ /#siteBottom ] -->
</div>
<!-- [ /#footerSection ] -->
</div>
<!-- [ /#wrap ] -->
<?php wp_footer();?>
</body>
</html>