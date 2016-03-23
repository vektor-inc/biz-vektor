<?php

if( !function_exists('biz_vektor_getHeadKeywords') ){
    function biz_vektor_getHeadKeywords(){
        trigger_error("biz_vektor_getHeadKeywords()は非推奨となりました。子ページテンプレートのheader.phpより該当部分を削除してください。(キーワードは別の方法でちゃんと出力されています!)");
        return '';
    }
}

if( !function_exists('biz_vektor_fbLikeBoxFront') ){
    function biz_vektor_fbLikeBoxFront(){
        trigger_error("biz_vektor_fbLikeBoxFront()は非推奨となりました。add_action('biz_vektor_fbLikeBoxFront');と置き換えることを推奨します。");
        $options = biz_vektor_get_theme_options();
        if ( isset($options['fbLikeBoxFront']) && $options['fbLikeBoxFront'] ) {
            biz_vektor_fbLikeBox();
        }
    }
}