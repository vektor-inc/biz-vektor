jQuery(function(){
	// ページ離脱イベント
	jQuery(window).on('beforeunload',function(){
		return('Did you save it?');
	});
	// Submitの場合のみ　ページ離脱イベント解除
	jQuery('form').on('submit',function(){
		jQuery(window).off('beforeunload');
	});

	// submitボタンにsubmitというIDをつけて
	// $('#submit').on('click',function...というのもありです。
	// また、jQuery ver 1.7.0 以前は on off がbind unbindとなります。
});

/*-------------------------------------------*/
/* メディアアップローダー
/*-------------------------------------------*/
jQuery(document).ready(function($){

	jQuery('.media_btn').click(function(e) {
		var custom_uploader;
		var media_target = jQuery(this).attr('id').replace(/media_/g,'#');
		e.preventDefault();
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
		custom_uploader = wp.media({
			title: 'Choose Image',
			library: {
				type: 'image'
			},
			button: {
				text: 'Choose Image'
			},
			multiple: false, // falseにすると画像を1つしか選択できなくなる
		});
		custom_uploader.on('select', function() {
			var images = custom_uploader.state().get('selection');
			images.each(function(file){
				jQuery(media_target).attr('value', file.toJSON().url.replace(/^https?:/, "") );
			});
		});
		custom_uploader.open();
	});
});

/*-------------------------------------------*/
/* ページ内の表示／非表示切り替えセクションの追加
/*-------------------------------------------*/
jQuery(document).ready(function($){
	jQuery('.showHideSection .showHideBtn').on("click", function() {
			jQuery(this).next().slideToggle();
	 });
});