<?php



add_action( 'widgets_init', 'biz_vektor_sns_register_widgets' );

function biz_vektor_sns_register_widgets(){
    register_widget("WP_Widget_snsBnrs");
    register_widget("WP_Widget_fbLikeBox");
}



/*-------------------------------------------*/
/*  WP_Widget_snsBnrs Class
/*-------------------------------------------*/

class WP_Widget_snsBnrs extends WP_Widget {
    public function __construct() {
        $widget_name = biz_vektor_get_short_name().'_'.__('facebook&twitter banner', 'biz-vektor');
        parent::__construct(
            'snsBnrs',
            $widget_name,
            array( 'description' => __( '*　It is necessary to set the Theme options page.', 'biz-vektor' ) )
        );
    }

    function widget($args, $instance) {
        if (function_exists('biz_vektor_snsBnrs')) biz_vektor_snsBnrs();
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
?>
<p>Facebook、Twitterのフォローボタンを設置します。</p>
<p><a href="<?php echo admin_url(); ?>/themes.php?page=theme_options#snsSetting" target="_blank" >テーマオプション</a>
「facebook」「twitterアカウント」に入力があるとそれぞれのボタンが表示されます。<br/>
入力がない場合は何も表示されません。
</p>
<?php
    }

} // class WP_Widget_snsBnrs


/*-------------------------------------------*/
/*  WP_Widget_fbLikeBox Class
/*-------------------------------------------*/

class WP_Widget_fbLikeBox extends WP_Widget {
    function __construct() {
        $widget_name = biz_vektor_get_short_name().'_facebook Page Plugin(Like Box)';

        parent::__construct(
            'fbLikeBox',
            $widget_name,
            array( 'description' => __( '*　It is necessary to set the Theme options page.', 'biz-vektor' ) )
        );
    }

    function widget($args, $instance) {
        extract( $args );
        if (function_exists('biz_vektor_fbLikeBox')) biz_vektor_fbLikeBox();
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
?>
<p>FacebookのLikeBoxを表示します。</p>
<p><a href="<?php echo admin_url(); ?>/themes.php?page=theme_options#snsSetting" target="_blank" >テーマオプション</a>
の「facebook LikeBox」で設定した内容を表示します。</p>
<p>
※ テーマオプションの表示箇所の設定によって表示非表示が影響します。<br/>
※ コンテンツエリア（トップページ）への設置推奨</p>
<?php
    }

}

