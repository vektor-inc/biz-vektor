<?php
$options = biz_vektor_get_theme_options();
if ($options['contact_link']) :?>
<ul>
<li class="sideBnr" id="sideContact"><a href="<?php echo $options['contact_link'] ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/<?php _e('bnr_contact.png', 'biz-vektor'); ?>" alt="<?php _e('Contact us by e-mail', 'biz-vektor'); ?>"></a></li>
</ul>
<?php
endif;
if (is_front_page()) :
dynamic_sidebar( 'top-side-widget-area' );
endif;
dynamic_sidebar( 'primary-widget-area' );
biz_vektor_snsBnrs();
biz_vektor_fbLikeBoxSide();
dynamic_sidebar( 'secondary-widget-area' );
?>