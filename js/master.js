// mzfch.js
function getCookieVal (offset) {
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
	endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie (name) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen) {
	var j = i + alen;
	if (document.cookie.substring(i, j) == arg)
	  return getCookieVal (j);
	i = document.cookie.indexOf(" ", i) + 1;
	if (i == 0)
	  break;
  }
  return null;
}

function SetCookie (name, value) {
  var argv = SetCookie.arguments;
  var argc = SetCookie.arguments.length;
  var expires = (argc > 2) ? argv[2] : null;
  var path = (argc > 3) ? argv[3] : null;
  var domain = (argc > 4) ? argv[4] : null;
  var secure = (argc > 5) ? argv[5] : false;
  document.cookie = name + "=" + escape (value) +
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
	((path == null) ? "" : ("; path=" + path)) +
	((domain == null) ? "" : ("; domain=" + domain)) +
	((secure == true) ? "; secure" : "");
}

// highlight.js
/* フォーム初期値消す */
function eraseTA(obj) {
	if (obj.value == obj.defaultValue) obj.value = "";
}

/* フォームのハイライト */
var currentlyActiveInputRef = false;
var currentlyActiveInputClassName = false;

function highlightActiveInput()
{
	if(currentlyActiveInputRef){
		currentlyActiveInputRef.className = currentlyActiveInputClassName;
	}
	currentlyActiveInputClassName = this.className;
	this.className = 'inputHighlighted';
	currentlyActiveInputRef = this;
}

function blurActiveInput()
{
	this.className = currentlyActiveInputClassName;
}

var initInputHighlightScript = window.onload;
window.onload = function(){
	var tags = ['INPUT','TEXTAREA'];

	for(tagCounter=0;tagCounter<tags.length;tagCounter++){
		var inputs = document.getElementsByTagName(tags[tagCounter]);
		for(var no=0;no<inputs.length;no++){
			if(inputs[no].className && inputs[no].className=='doNotHighlightThisInput')continue;

			if(inputs[no].tagName.toLowerCase()=='textarea' || (inputs[no].tagName.toLowerCase()=='input' && inputs[no].type.toLowerCase()=='text')){
				inputs[no].onfocus = highlightActiveInput;
				inputs[no].onblur = blurActiveInput;
			}
		}
	}
	if(initInputHighlightScript)
	initInputHighlightScript();
}


// window open
function m_win(url,windowname,width,height) {
 var features="location=no, menubar=no, status=yes, scrollbars=yes, resizable=yes, toolbar=no";
 if (width) {
  if (window.screen.width > width)
   features+=", left="+(window.screen.width-width)/2;
  else width=window.screen.width;
  features+=", width="+width;
 }
 if (height) {
  if (window.screen.height > height)
   features+=", top="+(window.screen.height-height)/2;
  else height=window.screen.height;
  features+=", height="+height;
 }
 window.open(url,windowname,features);
}


/*-------------------------------------------*/
/*	rollover.js
/*-------------------------------------------*/
var initRollovers = window.onload;
window.onload = function(){
	if (!document.getElementById) return

	var aPreLoad = new Array();
	var sTempSrc;

  var setup = function(aImages) {
		for (var i = 0; i < aImages.length; i++) {
			if (aImages[i].className == 'imgover') {
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

	if(initRollovers) {
		initRollovers();
	}
}
/*
jQuery(document).ready(function(){
	jQuery('a img.imgover').hover(function(){
		jQuery(this).attr('src').replace('/\.gif/', '/_on\.gif/');
		jQuery(this).attr('src').replace('/\.png', '/_on\.png/');
		jQuery(this).attr('src').replace('/\.jpg', '/_on\.jpg/');
		//jQuery(this).remove();
	});
});
*/

/*-------------------------------------------*/
/*	ページ内するするスクロール
/*-------------------------------------------*/
jQuery(document).ready(function(){

	//
	// <a href="#***">の場合、スクロール処理を追加
	//
	jQuery('a[href*=#]').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var $target = jQuery(this.hash);
			$target = $target.length && $target || jQuery('[name=' + this.hash.slice(1) +']');
			if ($target.length) {
				var targetOffset = $target.offset().top;
				jQuery('html,body').animate({ scrollTop: targetOffset }, 1200, 'quart');
				return false;
			}
		}
	});

});

// Easingの追加
jQuery.easing.quart = function (x, t, b, c, d) {
	return -c * ((t=t/d-1)*t*t*t - 1) + b;
};


/*-------------------------------------------*/
/*	メニューの開閉
/*-------------------------------------------*/
function showHide(targetID) {
	if( document.getElementById(targetID)) {
		if( document.getElementById(targetID).className == "itemOpen") {
			document.getElementById(targetID).className = "itemClose";
		} else {
			document.getElementById(targetID).className = "itemOpen";
		}
	}
}

/*-------------------------------------------*/
/*
/*-------------------------------------------*/
jQuery(document).ready(function(){
	jQuery('body :first-child').addClass('firstChild');
	jQuery('body :last-child').addClass('lastChild');
	jQuery('body li:nth-child(odd)').addClass('odd');
	jQuery('body li:nth-child(even)').addClass('even');
});
/*
======================================================================
	jquery.flatheights.js
	Version: 2010-09-15
	http://www.akatsukinishisu.net/itazuragaki/js/i20070801.html
======================================================================
/*-------------------------------------------*/
/*	$.changeLetterSize.addHandler(func)
/*	文字の大きさが変化した時に実行する処理を追加
/*-------------------------------------------*/
jQuery(document).ready(function($){
    jQuery('.topPrDescription').flatHeights();
    jQuery('.child_page_block').flatHeights();
    jQuery('.child_page_block p').flatHeights();
	jQuery('#content .child_page_block h4 a').flatHeights();
	//$('.menu li:hover').addClass('dropOpen');
	//$('.menu li').mouseout().removeClass(dropOpen);
});

jQuery.changeLetterSize = {
	handlers : [],
	interval : 1000,
	currentSize: 0
};

(function($) {

	var self = $.changeLetterSize;

	/* 文字の大きさを確認するためのins要素 */
	var ins = $('<ins>M</ins>').css({
		display: 'block',
		visibility: 'hidden',
		position: 'absolute',
		padding: '0',
		top: '0'
	});

	/* 文字の大きさが変わったか */
	var isChanged = function() {
		ins.appendTo('body');
		var size = ins[0].offsetHeight;
		ins.remove();
		if (self.currentSize == size) return false;
		self.currentSize = size;
		return true;
	};

	/* 文書を読み込んだ時点で
	   文字の大きさを確認しておく */
	$(isChanged);

	/* 文字の大きさが変わっていたら、
	   handlers中の関数を順に実行 */
	var observer = function() {
		if (!isChanged()) return;
		$.each(self.handlers, function(i, handler) {
			handler();
		});
	};

	/* ハンドラを登録し、
	   最初の登録であれば、定期処理を開始 */
	self.addHandler = function(func) {
		self.handlers.push(func);
		if (self.handlers.length == 1) {
			setInterval(observer, self.interval);
		}
	};

})(jQuery);


/*-------------------------------------------*/
/*	$(expr).flatHeights()
/*	$(expr)で選択した複数の要素について、それぞれ高さを
/*	一番高いものに揃える
/*-------------------------------------------*/

(function($) {

	/* 対象となる要素群の集合 */
	var sets = [];

	/* 高さ揃えの処理本体 */
	var flatHeights = function(set) {
		var maxHeight = 0;
		set.each(function(){
			var height = this.offsetHeight;
			if (height > maxHeight) maxHeight = height;
		});
		set.css('height', maxHeight + 'px');
	};

	/* 要素群の高さを揃え、setsに追加 */
	jQuery.fn.flatHeights = function() {
		if (this.length > 1) {
			flatHeights(this);
			sets.push(this);
		}
		return this;
	};

	/* 高さ揃えを再実行する処理 */
	var reflatting = function() {
		$.each(sets, function() {
			this.height('auto');
			flatHeights(this);
		});
	};

	/* 文字の大きさが変わった時に高さ揃えを再実行 */
	$.changeLetterSize.addHandler(reflatting);

	/* ウィンドウの大きさが変わった時に高さ揃えを再実行 */
	$(window).resize(reflatting);

})(jQuery);


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