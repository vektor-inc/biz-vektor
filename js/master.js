/*
master.js 他複数のファイルをGruntなどのビルドツールでマージして biz-vektor.jsになるので、biz-vektor.jsは直接編集しない
*/

/*-------------------------------------------*/
/*  編集ガイド
/*-------------------------------------------*/
/*	YOUTUBEのレスポンシブ対応
/*-------------------------------------------*/
/*	SNSアイテム関連
/*-------------------------------------------*/
/*	rollover.js
/*-------------------------------------------*/
/*	ページ内するするスクロール
/*-------------------------------------------*/
/*	snsCount
/*-------------------------------------------*/

/*-------------------------------------------*/
/*  編集ガイド
/*-------------------------------------------*/

jQuery('#wp-admin-bar-editGuide .ab-item').click(function(){
	if (!jQuery(this).hasClass('close')){
		var txt = jQuery(this).html();
		jQuery(this).html(txt.replace(/OPEN/,'CLOSE')).addClass('close');
		jQuery('.adminEdit').each(function(i){
			jQuery(this).hide();
		});
		jQuery('.edit-link').each(function(i){
			jQuery(this).hide();
		});
	} else {
		var txt2 = jQuery(this).html();
		jQuery(this).html(txt2.replace(/CLOSE/,'OPEN')).removeClass('close');
		jQuery('.adminEdit').each(function(i){
			jQuery(this).show();
		});
		jQuery('.edit-link').each(function(i){
			jQuery(this).show();
		});
	}
});

/*-------------------------------------------*/
/*	YOUTUBEのレスポンシブ対応
/*-------------------------------------------*/
document.addEventListener("DOMContentLoaded",function(eve){
    jQuery('iframe').each(function(i){
        var iframeUrl = jQuery(this).attr("src");
        if(!iframeUrl){return;}
        // iframeのURLの中に youtube が存在する位置を検索する
        idx = iframeUrl.indexOf("youtube");
        // 見つからなかった場合には -1 が返される
        if(idx != -1) {
            // youtube が含まれていたらそのクラスを返す
            jQuery(this).addClass('iframeYoutube').css({"max-width":"100%"});
            var iframeWidth = jQuery(this).attr("width");
            var iframeHeight = jQuery(this).attr("height");
            var iframeRate = iframeHeight / iframeWidth;
            var nowIframeWidth = jQuery(this).width();
            var newIframeHeight = nowIframeWidth * iframeRate;
            jQuery(this).css({"max-width":"100%","height":newIframeHeight});
        }
    });
},false);

/*-------------------------------------------*/
/*	SNSアイテム関連
/*-------------------------------------------*/
;(function($){
	// When load page / window resize
	function likeBoxReSize(){
		// var i = number;
		// $('.fb-like-box').each(function(i){
		$('.fb-like-box').each(function(){
			var element = $(this).parent().width();
			if ( 501 > element || element < 280 ) {
				$(this).attr('data-width',element);
				$(this).children('span:first').css({"width":element});
				$(this).children('span iframe.fb_ltr').css({"width":element});
			}
		});
	}

	// When load page / window resize
	function fbCommentReSize(){
	// var i = number;
	// $('.fb-comments').each(function(i){
		$('.fb-comments').each(function(){
			var element = $(this).parent().width();
			$(this).attr('data-width',element);
			$(this).children('span:first').css({"width":element});
			$(this).children('span iframe.fb_ltr').css({"width":element});
		});
	}

	var setfunction = function(){
		fbCommentReSize();
		likeBoxReSize();
	}


	document.addEventListener("DOMContentLoaded", setfunction);

	var timer = false;
	$(window).resize(function() {
		if (timer !== false) {
			clearTimeout(timer);
		}
		timer = setTimeout(setfunction, 200);
	});
})(jQuery);

/*-------------------------------------------*/
/*	rollover.js
/*-------------------------------------------*/
document.addEventListener("DOMContentLoaded",function(eve){
	if (!document.getElementById) return

		var aPreLoad = new Array();
		var sTempSrc;

		var setup = function(aImages) {
		for (var i = 0; i < aImages.length; i++) {
			if (aImages[i].className.match(/(^| )imgover( |$)/i)) {
				var src = aImages[i].getAttribute('src');
				var ftype = src.substring(src.lastIndexOf('.'), src.length);
				var hsrc = src.replace(ftype, '_on'+ftype);

				aImages[i].setAttribute('hsrc', hsrc);

				aPreLoad[i] = new Image();
				aPreLoad[i].src = hsrc;

				aImages[i].onmouseover = function() {
					sTempSrc = this.getAttribute('src');
					this.setAttribute('src', this.getAttribute('hsrc'));
				}

				aImages[i].onmouseout = function() {
					if (!sTempSrc) sTempSrc = this.getAttribute('src').replace('_on'+ftype, ftype);
					this.setAttribute('src', sTempSrc);
				}
			}
		}
	};

	var aImages = document.getElementsByTagName('img');
	setup(aImages);
	var aInputs = document.getElementsByTagName('input');
	setup(aInputs);
},false);

/*-------------------------------------------*/
/*	ページ内するするスクロール
/*-------------------------------------------*/
document.addEventListener("DOMContentLoaded",function(){
	//
	// <a href="#***">の場合、スクロール処理を追加
	//
	jQuery('a[href*=\\#]').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var $target = jQuery(this.hash);
			if(!this.hash.slice(1)){return;}
			$target = $target.length && $target || jQuery('[name=' + this.hash.slice(1) +']');
			if ($target.length) {
				var targetOffset = $target.offset().top;
				jQuery('html,body').animate({ scrollTop: targetOffset }, 1200, 'quart');
				return false;
			}
		}
	});
},false);

// Easingの追加
jQuery.easing.quart = function (x, t, b, c, d) {
	return -c * ((t=t/d-1)*t*t*t - 1) + b;
};

/*-------------------------------------------*/
/*
/*-------------------------------------------*/
// jQuery(document).ready(function(){
// 	jQuery('body :first-child').addClass('firstChild');
// 	jQuery('body :last-child').addClass('lastChild');
// 	jQuery('body li:nth-child(odd)').addClass('odd');
// 	jQuery('body li:nth-child(even)').addClass('even');
// });
/*

/*
Copyright (c) 2007, KITAMURA Akatsuki

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/
/*
======================================================================
*  footerFixed.js
 *
 *  MIT-style license.
 *
 *  2007 Kazuma Nishihata [to-R]
 *  http://blog.webcreativepark.net
======================================================================
*/
new function(){

	var footerId = "footerSection";
	//メイン
	function footerFixed(){
		//ドキュメントの高さ
		var dh = document.getElementsByTagName("body")[0].clientHeight;
		//フッターのtopからの位置
		document.getElementById(footerId).style.top = "0px";
		var ft = document.getElementById(footerId).offsetTop;
		//フッターの高さ
		var fh = document.getElementById(footerId).offsetHeight;
		//ウィンドウの高さ
		if (window.innerHeight){
			var wh = window.innerHeight;
		}else if(document.documentElement && document.documentElement.clientHeight != 0){
			var wh = document.documentElement.clientHeight;
		}
		if(ft+fh<wh){
			document.getElementById(footerId).style.position = "relative";
			document.getElementById(footerId).style.top = (wh-fh-ft-1)+"px";
		}
	}

	//文字サイズ
	function checkFontSize(func){

		//判定要素の追加
		var e = document.createElement("div");
		var s = document.createTextNode("S");
		e.appendChild(s);
		e.style.visibility="hidden"
		e.style.position="absolute"
		e.style.top="0"
		document.body.appendChild(e);
		var defHeight = e.offsetHeight;

		//判定関数
		function checkBoxSize(){
			if(defHeight != e.offsetHeight){
				func();
				defHeight= e.offsetHeight;
			}
		}
		setInterval(checkBoxSize,1000)
	}

	//イベントリスナー
	function addEvent(elm,listener,fn){
		try{
			elm.addEventListener(listener,fn,false);
		}catch(e){
			elm.attachEvent("on"+listener,fn);
		}
	}

	addEvent(window,"load",footerFixed);
	addEvent(window,"load",function(){
		checkFontSize(footerFixed);
	});
	addEvent(window,"resize",footerFixed);
}

/*-------------------------------------------*/
/*	$.changeLetterSize.addHandler(func)
/*	文字の大きさが変化した時に実行する処理を追加
/*-------------------------------------------*/
jQuery("#btn").on("click", function() {
	jQuery(this).next().next().slideToggle();
	jQuery(this).toggleClass("active");
});

window.addEventListener('load',function() {
  var defaultparams = {}
  if(bv_sliderParams){defaultparams = jQuery.extend(defaultparams,bv_sliderParams)}
  jQuery('#topMainBnrDummy').css('display','none');
  jQuery('.flexslider').flexslider(defaultparams);
},false);
