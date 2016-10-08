<?php $biz_vektor_options = biz_vektor_get_theme_options(); ?>
<div class="optionNav" style="display:none;">
<ul>
    <li id="btn_design"><a href="#design"><?php echo __( 'Design', 'biz-vektor' ); ?></a></li>
    <li id="btn_contactInfo"><a href="#contactInfo"><?php echo __( 'Contact', 'biz-vektor' ); ?></a></li>
    <li id="btn_prBox"><a href="#prBox"><?php echo __( 'TopPR', 'biz-vektor' ); ?></a></li>
    <li id="btn_postSetting"><a href="#postSetting">
    	<?php if ( isset( $biz_vektor_options['infoLabelName'] ) && ! empty( $biz_vektor_options['infoLabelName'] )
    		&& isset( $biz_vektor_options['postLabelName'] ) && ! empty( $biz_vektor_options['postLabelName'] ) ) {

			echo esc_html( $biz_vektor_options['infoLabelName'] ) . ' & ' . esc_html( $biz_vektor_options['postLabelName'] );
    	} elseif ( isset( $biz_vektor_options['infoLabelName'] ) && ! empty( $biz_vektor_options['infoLabelName'] ) ) {

    		echo esc_html( bizVektorOptions('infoLabelName') ) . ' & ' . __( 'Posts', 'biz-vektor' );
    	} elseif ( isset( $biz_vektor_options['postLabelName'] ) && ! empty( $biz_vektor_options['postLabelName'] ) ) {

    		echo __( 'Posts', 'biz-vektor' ) . ' & ' . esc_html( $biz_vektor_options['postLabelName'] );
    	} else {
			echo __( 'Posts', 'biz-vektor' );
    	} ?></a></li>
    <li id="btn_topPage"><a href="#topPage"><?php echo __( 'Homepage', 'biz-vektor' ); ?></a></li>
    <li id="btn_slideSetting"><a href="#slideSetting"><?php echo __( 'Slide', 'biz-vektor' ); ?></a></li>
    <?php do_action('biz_vektor_options_nav_tab'); ?>
</ul>
</div>