<?php

add_action( 'widgets_init', 'biz_vektor_info_register_widgets' );


function biz_vektor_info_register_widgets(){
    register_widget("WP_Widget_infoTerms");
    register_widget("WP_Widget_infoArchives");
    register_widget("WP_Widget_top_list_info");
}

/*-------------------------------------------*/
/*  WP_Widget_infoTerms Class
/*-------------------------------------------*/
class WP_Widget_infoTerms extends WP_Widget {
    function __construct() {
        $biz_vektor_options = biz_bektor_option_validate();
        $widget_name = biz_vektor_get_short_name().'_'.sprintf( __( '%s category', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] );

        parent::__construct(
            'infoTerms',
            $widget_name,
            array( 'description' => sprintf( __( 'Category list of %s', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] ),'hanshin tigers' )
        );
    }

    function widget($args, $instance) {
        extract( $args );
        $arg = array(
            'show_option_none'      => '',
            'title_li'              => '',
            'taxonomy'              => 'info-cat',
            'orderby'               => 'order',
            'echo'                  => 0
        );
        $catlist = wp_list_categories( $arg );
        if ( !empty($catlist)) {
            if ( !isset($instance['title']) || !$instance['title'] ) {
                $biz_vektor_options = biz_vektor_get_theme_options();
                $instance['title'] = sprintf( __( '%s category', 'biz-vektor' ),$biz_vektor_options['infoLabelName'] );
            } ?>
            <div class="localSection sideWidget">
            <div class="localNaviBox">
            <h3 class="localHead"><?php echo esc_html($instance['title']); ?></h3>
            <ul class="localNavi">
            <?php echo $catlist; ?>
            </ul>
            </div>
            </div>
        <?php }
    }

    function update($new_instance, $old_instance) {
        $old_instance['title'] = strip_tags( $new_instance['title'] );
        return $old_instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => 'カテゴリー',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = esc_attr($instance['title']);
        ?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php
    }
}


/*-------------------------------------------*/
/*  WP_Widget_infoArchives Class
/*-------------------------------------------*/
class WP_Widget_infoArchives extends WP_Widget {
    /** constructor */
    function __construct() {
        $biz_vektor_options = biz_vektor_get_theme_options();
        $widget_name = biz_vektor_get_short_name().'_'.sprintf( __( '%s Yearly archives', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] );

        parent::__construct(
            'infoArchives',
            $widget_name,
            array( 'description' => sprintf( __( 'Yearly archives of %s', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] ) )
        );
    }
    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
?>
    <div class="localSection sideWidget">
    <div class="localNaviBox">
    <h3 class="localHead"><?php _e('Yearly archives', 'biz-vektor'); ?></h3>
    <ul class="localNavi">
    <?php
    $args = array(
        'type' => 'yearly',
        'post_type' => 'info',
        'after' => _x('&nbsp;', 'After year','biz-vektor')
        );
    wp_get_archives($args); ?>
    </ul>
    </div>
    </div>
<?php
    }
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }
    /** @see WP_Widget::form */
    function form($instance) {
?>
<p>お知らせの年別アーカイブを表示します。</p>
<?php
    }
}

/*-------------------------------------------*/
/*  Top Info list widget
/*-------------------------------------------*/
class WP_Widget_top_list_info extends WP_Widget {

    function __construct() {
        $biz_vektor_options = biz_vektor_get_theme_options();

        $widget_name = biz_vektor_get_short_name() . '_' . sprintf( __( '%1$s list for top', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] );

        parent::__construct(
            'top_list_info',
            $widget_name,
            array( 'description' => sprintf( __( 'Displays recent %1$s posts.', 'biz-vektor' ), $biz_vektor_options['infoLabelName'] ) )
        );
    }

    function widget($args, $instance) {
        get_template_part( 'module_top_list_info' );
    }

    function form($instance){
?>
<p>お知らせリストを表示します。</p>
<p>※ 表示レイアウトは<a href="<?php echo admin_url(); ?>/themes.php?page=theme_options#postSetting" target="_blank" >テーマオプション</a>
の「お知らせ のトップページでの表示レイアウト」に準じます。<br/>
※ コンテンツエリア（トップページ）への設置推奨</p>
<?php
    }

    function update($new_instance,$old_instance){
        return $new_instance;
    }
}