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
/* �t�H�[�������l���� */
function eraseTA(obj) {
	if (obj.value == obj.defaultValue) obj.value = "";
}

/* �t�H�[���̃n�C���C�g */
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

// jQuery(document).ready(function(){
// 	jQuery('a img.imgover').hover(function(){
// 		jQuery(this).attr('src').replace('/\.gif/', '/_on\.gif/');
// 		jQuery(this).attr('src').replace('/\.png', '/_on\.png/');
// 		jQuery(this).attr('src').replace('/\.jpg', '/_on\.jpg/');
// 		//jQuery(this).remove();
// 	});
// });

/*-------------------------------------------*/
/*	�y�[�W�����邷���X�N���[��
/*-------------------------------------------*/
jQuery(document).ready(function(){

	//
	// <a href="#***">�̏ꍇ�A�X�N���[���������ǉ�
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

// Easing�̒ǉ�
jQuery.easing.quart = function (x, t, b, c, d) {
	return -c * ((t=t/d-1)*t*t*t - 1) + b;
};

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
/*	�����̑傫�����ω��������Ɏ��s���鏈�����ǉ�
/*-------------------------------------------*/
jQuery(document).ready(function($){
    // jQuery('.topPrTit').flatHeights();
    jQuery('.topPrTit').flatHeights();
    jQuery('.topPrDescription').flatHeights();
    jQuery('.child_page_block').flatHeights();
    jQuery('.child_page_block p').flatHeights();
	jQuery('#content .child_page_block h4 a').flatHeights();
});

jQuery.changeLetterSize = {
	handlers : [],
	interval : 1000,
	currentSize: 0
};

(function($) {

	var self = $.changeLetterSize;

	/* �����̑傫�����m�F���邽�߂�ins�v�f */
	var ins = $('<ins>M</ins>').css({
		display: 'block',
		visibility: 'hidden',
		position: 'absolute',
		padding: '0',
		top: '0'
	});

	/* �����̑傫�����ς������� */
	var isChanged = function() {
		ins.appendTo('body');
		var size = ins[0].offsetHeight;
		ins.remove();
		if (self.currentSize == size) return false;
		self.currentSize = size;
		return true;
	};

	/* �������ǂݍ��񂾎��_��
	   �����̑傫�����m�F���Ă��� */
	$(isChanged);

	/* �����̑傫�����ς����Ă������A
	   handlers���̊֐������Ɏ��s */
	var observer = function() {
		if (!isChanged()) return;
		$.each(self.handlers, function(i, handler) {
			handler();
		});
	};

	/* �n���h�����o�^���A
	   �ŏ��̓o�^�ł����΁A�����������J�n */
	self.addHandler = function(func) {
		self.handlers.push(func);
		if (self.handlers.length == 1) {
			setInterval(observer, self.interval);
		}
	};

})(jQuery);


/*-------------------------------------------*/
/*	$(expr).flatHeights()
/*	$(expr)�őI�����������̗v�f�ɂ��āA���ꂼ�ꍂ����
/*	���ԍ������̂ɑ�����
/*-------------------------------------------*/

(function($) {

	/* �ΏۂƂȂ��v�f�Q�̏W�� */
	var sets = [];

	/* ���������̏����{�� */
	var flatHeights = function(set) {
		var maxHeight = 0;
		set.each(function(){
			var height = this.offsetHeight;
			if (height > maxHeight) maxHeight = height;
		});
		set.css('height', maxHeight + 'px');
	};

	/* �v�f�Q�̍����𑵂��Asets�ɒǉ� */
	jQuery.fn.flatHeights = function() {
		if (this.length > 1) {
			flatHeights(this);
			sets.push(this);
		}
		return this;
	};

	/* �����������Ď��s���鏈�� */
	var reflatting = function() {
		$.each(sets, function() {
			this.height('auto');
			flatHeights(this);
		});
	};

	/* �����̑傫�����ς��������ɍ����������Ď��s */
	$.changeLetterSize.addHandler(reflatting);

	/* �E�B���h�E�̑傫�����ς��������ɍ����������Ď��s */
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
	//���C��
	function footerFixed(){
		//�h�L�������g�̍���
		var dh = document.getElementsByTagName("body")[0].clientHeight;
		//�t�b�^�[��top�����̈ʒu
		document.getElementById(footerId).style.top = "0px";
		var ft = document.getElementById(footerId).offsetTop;
		//�t�b�^�[�̍���
		var fh = document.getElementById(footerId).offsetHeight;
		//�E�B���h�E�̍���
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
	
	//�����T�C�Y
	function checkFontSize(func){
	
		//�����v�f�̒ǉ�	
		var e = document.createElement("div");
		var s = document.createTextNode("S");
		e.appendChild(s);
		e.style.visibility="hidden"
		e.style.position="absolute"
		e.style.top="0"
		document.body.appendChild(e);
		var defHeight = e.offsetHeight;
		
		//�����֐�
		function checkBoxSize(){
			if(defHeight != e.offsetHeight){
				func();
				defHeight= e.offsetHeight;
			}
		}
		setInterval(checkBoxSize,1000)
	}
	
	//�C�x���g���X�i�[
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
/*	�����̑傫�����ω��������Ɏ��s���鏈�����ǉ�
/*-------------------------------------------*/
jQuery("#btn").on("click", function() {
	jQuery(this).next().next().slideToggle();
	jQuery(this).toggleClass("active");
});



/*
 * jQuery FlexSlider v1.8
 * http://www.woothemes.com/flexslider/
 *
 * Copyright 2012 WooThemes
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Contributing Author: Tyler Smith
 */


;(function (jQuery) {
  
  //FlexSlider: Object Instance
  jQuery.flexslider = function(el, options) {
    var slider = jQuery(el);
    
    // slider DOM reference for use outside of the plugin
    jQuery.data(el, "flexslider", slider);

    slider.init = function() {
		slider.vars = jQuery.extend({}, jQuery.flexslider.defaults, options);
		jQuery.data(el, 'flexsliderInit', true);
		slider.container = jQuery('.slides', slider).first();
		slider.slides = jQuery('.slides:first > li', slider);
		slider.count = slider.slides.length;
		slider.animating = false;
		slider.currentSlide = slider.vars.slideToStart;
		slider.animatingTo = slider.currentSlide;
		slider.atEnd = (slider.currentSlide == 0) ? true : false;
		slider.eventType = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click';
		slider.cloneCount = 0;
		slider.cloneOffset = 0;
		slider.manualPause = false;
		slider.vertical = (slider.vars.slideDirection == "vertical");
		slider.prop = (slider.vertical) ? "top" : "marginLeft";
		slider.args = {};
      
      //Test for webbkit CSS3 Animations
      slider.transitions = "webkitTransition" in document.body.style;
      if (slider.transitions) slider.prop = "-webkit-transform";
      
      //Test for controlsContainer
      if (slider.vars.controlsContainer != "") {
        slider.controlsContainer = jQuery(slider.vars.controlsContainer).eq(jQuery('.slides').index(slider.container));
        slider.containerExists = slider.controlsContainer.length > 0;
      }
      //Test for manualControls
      if (slider.vars.manualControls != "") {
        slider.manualControls = jQuery(slider.vars.manualControls, ((slider.containerExists) ? slider.controlsContainer : slider));
        slider.manualExists = slider.manualControls.length > 0;
      }
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Randomize Slides
      if (slider.vars.randomize) {
        slider.slides.sort(function() { return (Math.round(Math.random())-0.5); });
        slider.container.empty().append(slider.slides);
      }
      ///////////////////////////////////////////////////////////////////
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Slider Animation Initialize
      if (slider.vars.animation.toLowerCase() == "slide") {
        if (slider.transitions) {
          slider.setTransition(0);
        }
        slider.css({"overflow": "hidden"});
        if (slider.vars.animationLoop) {
          slider.cloneCount = 2;
          slider.cloneOffset = 1;
          slider.container.append(slider.slides.filter(':first').clone().addClass('clone')).prepend(slider.slides.filter(':last').clone().addClass('clone'));
        }
        //create newSlides to capture possible clones
		slider.newSlides = jQuery('.slides:first > li', slider);
        var sliderOffset = (-1 * (slider.currentSlide + slider.cloneOffset));
        if (slider.vertical) {
          slider.newSlides.css({"display": "block", "width": "100%", "float": "left"});
          slider.container.height((slider.count + slider.cloneCount) * 200 + "%").css("position", "absolute").width("100%");
          //Timeout function to give browser enough time to get proper height initially
          setTimeout(function() {
            slider.css({"position": "relative"}).height(slider.slides.filter(':first').height());
            slider.args[slider.prop] = (slider.transitions) ? "translate3d(0," + sliderOffset * slider.height() + "px,0)" : sliderOffset * slider.height() + "px";
            slider.container.css(slider.args);
          }, 100);

        } else {
          slider.args[slider.prop] = (slider.transitions) ? "translate3d(" + sliderOffset * slider.width() + "px,0,0)" : sliderOffset * slider.width() + "px";
          slider.container.width((slider.count + slider.cloneCount) * 200 + "%").css(slider.args);
          //Timeout function to give browser enough time to get proper width initially
          setTimeout(function() {
            slider.newSlides.width(slider.width()).css({"float": "left", "display": "block"});
          }, 100);
        }
        
      } else { //Default to fade
        //Not supporting fade CSS3 transitions right now
        slider.transitions = false;
        slider.slides.css({"width": "100%", "float": "left", "marginRight": "-100%"}).eq(slider.currentSlide).fadeIn(slider.vars.animationDuration); 
      }
      ///////////////////////////////////////////////////////////////////
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Control Nav
      if (slider.vars.controlNav) {
        if (slider.manualExists) {
          slider.controlNav = slider.manualControls;
        } else {
          var controlNavScaffold = jQuery('<ol class="flex-control-nav"></ol>');
          var j = 1;
          for (var i = 0; i < slider.count; i++) {
            controlNavScaffold.append('<li><a>' + j + '</a></li>');
            j++;
          }

          if (slider.containerExists) {
            jQuery(slider.controlsContainer).append(controlNavScaffold);
            slider.controlNav = jQuery('.flex-control-nav li a', slider.controlsContainer);
          } else {
            slider.append(controlNavScaffold);
            slider.controlNav = jQuery('.flex-control-nav li a', slider);
          }
        }

        slider.controlNav.eq(slider.currentSlide).addClass('active');

        slider.controlNav.bind(slider.eventType, function(event) {
          event.preventDefault();
          if (!jQuery(this).hasClass('active')) {
            (slider.controlNav.index(jQuery(this)) > slider.currentSlide) ? slider.direction = "next" : slider.direction = "prev";
            slider.flexAnimate(slider.controlNav.index(jQuery(this)), slider.vars.pauseOnAction);
          }
        });
      }
      ///////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Direction Nav
      if (slider.vars.directionNav) {
        var directionNavScaffold = jQuery('<ul class="flex-direction-nav"><li><a class="prev" href="#">' + slider.vars.prevText + '</a></li><li><a class="next" href="#">' + slider.vars.nextText + '</a></li></ul>');
        
        if (slider.containerExists) {
          jQuery(slider.controlsContainer).append(directionNavScaffold);
          slider.directionNav = jQuery('.flex-direction-nav li a', slider.controlsContainer);
        } else {
          slider.append(directionNavScaffold);
          slider.directionNav = jQuery('.flex-direction-nav li a', slider);
        }
        
        //Set initial disable styles if necessary
        if (!slider.vars.animationLoop) {
          if (slider.currentSlide == 0) {
            slider.directionNav.filter('.prev').addClass('disabled');
          } else if (slider.currentSlide == slider.count - 1) {
            slider.directionNav.filter('.next').addClass('disabled');
          }
        }
        
        slider.directionNav.bind(slider.eventType, function(event) {
          event.preventDefault();
          var target = (jQuery(this).hasClass('next')) ? slider.getTarget('next') : slider.getTarget('prev');
          
          if (slider.canAdvance(target)) {
            slider.flexAnimate(target, slider.vars.pauseOnAction);
          }
        });
      }
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Keyboard Nav
      if (slider.vars.keyboardNav && jQuery('ul.slides').length == 1) {
        function keyboardMove(event) {
          if (slider.animating) {
            return;
          } else if (event.keyCode != 39 && event.keyCode != 37){
            return;
          } else {
            if (event.keyCode == 39) {
              var target = slider.getTarget('next');
            } else if (event.keyCode == 37){
              var target = slider.getTarget('prev');
            }
        
            if (slider.canAdvance(target)) {
              slider.flexAnimate(target, slider.vars.pauseOnAction);
            }
          }
        }
        jQuery(document).bind('keyup', keyboardMove);
      }
      //////////////////////////////////////////////////////////////////
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Mousewheel interaction
      if (slider.vars.mousewheel) {
        slider.mousewheelEvent = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";
        slider.bind(slider.mousewheelEvent, function(e) {
          e.preventDefault();
          e = e ? e : window.event;
          var wheelData = e.detail ? e.detail * -1 : e.originalEvent.wheelDelta / 40,
              target = (wheelData < 0) ? slider.getTarget('next') : slider.getTarget('prev');
          
          if (slider.canAdvance(target)) {
            slider.flexAnimate(target, slider.vars.pauseOnAction);
          }
        });
      }
      ///////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Slideshow Setup
      if (slider.vars.slideshow) {
        //pauseOnHover
        if (slider.vars.pauseOnHover && slider.vars.slideshow) {
          slider.hover(function() {
            slider.pause();
          }, function() {
            if (!slider.manualPause) {
              slider.resume();
            }
          });
        }

        //Initialize animation
        slider.animatedSlides = setInterval(slider.animateSlides, slider.vars.slideshowSpeed);
      }
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Pause/Play
      if (slider.vars.pausePlay) {
        var pausePlayScaffold = jQuery('<div class="flex-pauseplay"><span></span></div>');
      
        if (slider.containerExists) {
          slider.controlsContainer.append(pausePlayScaffold);
          slider.pausePlay = jQuery('.flex-pauseplay span', slider.controlsContainer);
        } else {
          slider.append(pausePlayScaffold);
          slider.pausePlay = jQuery('.flex-pauseplay span', slider);
        }
        
        var pausePlayState = (slider.vars.slideshow) ? 'pause' : 'play';
        slider.pausePlay.addClass(pausePlayState).text((pausePlayState == 'pause') ? slider.vars.pauseText : slider.vars.playText);
        
        slider.pausePlay.bind(slider.eventType, function(event) {
          event.preventDefault();
          if (jQuery(this).hasClass('pause')) {
            slider.pause();
            slider.manualPause = true;
          } else {
            slider.resume();
            slider.manualPause = false;
          }
        });
      }
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider:Touch Swip Gestures
      //Some brilliant concepts adapted from the following sources
      //Source: TouchSwipe - http://www.netcu.de/jquery-touchwipe-iphone-ipad-library
      //Source: SwipeJS - http://swipejs.com
      if ('ontouchstart' in document.documentElement) {
        //For brevity, variables are named for x-axis scrolling
        //The variables are then swapped if vertical sliding is applied
        //This reduces redundant code...I think :)
        //If debugging, recognize variables are named for horizontal scrolling
        var startX,
          startY,
          offset,
          cwidth,
          dx,
          startT,
          scrolling = false;
              
        slider.each(function() {
          if ('ontouchstart' in document.documentElement) {
            this.addEventListener('touchstart', onTouchStart, false);
          }
        });
        
        function onTouchStart(e) {
          if (slider.animating) {
            e.preventDefault();
          } else if (e.touches.length == 1) {
            slider.pause();
            cwidth = (slider.vertical) ? slider.height() : slider.width();
            startT = Number(new Date());
            offset = (slider.vertical) ? (slider.currentSlide + slider.cloneOffset) * slider.height() : (slider.currentSlide + slider.cloneOffset) * slider.width();
            startX = (slider.vertical) ? e.touches[0].pageY : e.touches[0].pageX;
            startY = (slider.vertical) ? e.touches[0].pageX : e.touches[0].pageY;
            slider.setTransition(0);

            this.addEventListener('touchmove', onTouchMove, false);
            this.addEventListener('touchend', onTouchEnd, false);
          }
        }

        function onTouchMove(e) {
          dx = (slider.vertical) ? startX - e.touches[0].pageY : startX - e.touches[0].pageX;
          scrolling = (slider.vertical) ? (Math.abs(dx) < Math.abs(e.touches[0].pageX - startY)) : (Math.abs(dx) < Math.abs(e.touches[0].pageY - startY));

          if (!scrolling) {
            e.preventDefault();
            if (slider.vars.animation == "slide" && slider.transitions) {
              if (!slider.vars.animationLoop) {
                dx = dx/((slider.currentSlide == 0 && dx < 0 || slider.currentSlide == slider.count - 1 && dx > 0) ? (Math.abs(dx)/cwidth+2) : 1);
              }
              slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + (-offset - dx) + "px,0)": "translate3d(" + (-offset - dx) + "px,0,0)";
              slider.container.css(slider.args);
            }
          }
        }
        
        function onTouchEnd(e) {
          slider.animating = false;
          if (slider.animatingTo == slider.currentSlide && !scrolling && !(dx == null)) {
            var target = (dx > 0) ? slider.getTarget('next') : slider.getTarget('prev');
            if (slider.canAdvance(target) && Number(new Date()) - startT < 550 && Math.abs(dx) > 20 || Math.abs(dx) > cwidth/2) {
              slider.flexAnimate(target, slider.vars.pauseOnAction);
            } else {
              slider.flexAnimate(slider.currentSlide, slider.vars.pauseOnAction);
            }
          }
          
          //Finish the touch by undoing the touch session
          this.removeEventListener('touchmove', onTouchMove, false);
          this.removeEventListener('touchend', onTouchEnd, false);
          startX = null;
          startY = null;
          dx = null;
          offset = null;
        }
      }
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Resize Functions (If necessary)
      if (slider.vars.animation.toLowerCase() == "slide") {
        jQuery(window).resize(function(){
          if (!slider.animating && slider.is(":visible")) {
            if (slider.vertical) {
              slider.height(slider.slides.filter(':first').height());
              slider.args[slider.prop] = (-1 * (slider.currentSlide + slider.cloneOffset))* slider.slides.filter(':first').height() + "px";
              if (slider.transitions) {
                slider.setTransition(0);
                slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
              }
              slider.container.css(slider.args);
            } else {
              slider.newSlides.width(slider.width());
              slider.args[slider.prop] = (-1 * (slider.currentSlide + slider.cloneOffset))* slider.width() + "px";
              if (slider.transitions) {
                slider.setTransition(0);
                slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
              }
              slider.container.css(slider.args);
            }
          }
        });
      }
      //////////////////////////////////////////////////////////////////
      
      //FlexSlider: start() Callback
      slider.vars.start(slider);
    }
    
    //FlexSlider: Animation Actions
    slider.flexAnimate = function(target, pause) {
      if (!slider.animating && slider.is(":visible")) {
        //Animating flag
        slider.animating = true;
        
        //FlexSlider: before() animation Callback
        slider.animatingTo = target;
        slider.vars.before(slider);
        
        //Optional paramter to pause slider when making an anmiation call
        if (pause) {
          slider.pause();
        }
        
        //Update controlNav   
        if (slider.vars.controlNav) {
          slider.controlNav.removeClass('active').eq(target).addClass('active');
        }
        
        //Is the slider at either end
        slider.atEnd = (target == 0 || target == slider.count - 1) ? true : false;
        if (!slider.vars.animationLoop && slider.vars.directionNav) {
          if (target == 0) {
            slider.directionNav.removeClass('disabled').filter('.prev').addClass('disabled');
          } else if (target == slider.count - 1) {
            slider.directionNav.removeClass('disabled').filter('.next').addClass('disabled');
          } else {
            slider.directionNav.removeClass('disabled');
          }
        }
        
        if (!slider.vars.animationLoop && target == slider.count - 1) {
          slider.pause();
          //FlexSlider: end() of cycle Callback
          slider.vars.end(slider);
        }
        
        if (slider.vars.animation.toLowerCase() == "slide") {
          var dimension = (slider.vertical) ? slider.slides.filter(':first').height() : slider.slides.filter(':first').width();
          
          if (slider.currentSlide == 0 && target == slider.count - 1 && slider.vars.animationLoop && slider.direction != "next") {
            slider.slideString = "0px";
          } else if (slider.currentSlide == slider.count - 1 && target == 0 && slider.vars.animationLoop && slider.direction != "prev") {
            slider.slideString = (-1 * (slider.count + 1)) * dimension + "px";
          } else {
            slider.slideString = (-1 * (target + slider.cloneOffset)) * dimension + "px";
          }
          slider.args[slider.prop] = slider.slideString;

          if (slider.transitions) {
              slider.setTransition(slider.vars.animationDuration); 
              slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.slideString + ",0)" : "translate3d(" + slider.slideString + ",0,0)";
              slider.container.css(slider.args).one("webkitTransitionEnd transitionend", function(){
                slider.wrapup(dimension);
              });   
          } else {
            slider.container.animate(slider.args, slider.vars.animationDuration, function(){
              slider.wrapup(dimension);
            });
          }
        } else { //Default to Fade
          slider.slides.eq(slider.currentSlide).fadeOut(slider.vars.animationDuration);
          slider.slides.eq(target).fadeIn(slider.vars.animationDuration, function() {
            slider.wrapup();
          });
        }
      }
    }
    
    //FlexSlider: Function to minify redundant animation actions
    slider.wrapup = function(dimension) {
      if (slider.vars.animation == "slide") {
        //Jump the slider if necessary
        if (slider.currentSlide == 0 && slider.animatingTo == slider.count - 1 && slider.vars.animationLoop) {
          slider.args[slider.prop] = (-1 * slider.count) * dimension + "px";
          if (slider.transitions) {
            slider.setTransition(0);
            slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
          }
          slider.container.css(slider.args);
        } else if (slider.currentSlide == slider.count - 1 && slider.animatingTo == 0 && slider.vars.animationLoop) {
          slider.args[slider.prop] = -1 * dimension + "px";
          if (slider.transitions) {
            slider.setTransition(0);
            slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
          }
          slider.container.css(slider.args);
        }
      }
      slider.animating = false;
      slider.currentSlide = slider.animatingTo;
      //FlexSlider: after() animation Callback
      slider.vars.after(slider);
    }
    
    //FlexSlider: Automatic Slideshow
    slider.animateSlides = function() {
      if (!slider.animating) {
        slider.flexAnimate(slider.getTarget("next"));
      }
    }
    
    //FlexSlider: Automatic Slideshow Pause
    slider.pause = function() {
      clearInterval(slider.animatedSlides);
      if (slider.vars.pausePlay) {
        slider.pausePlay.removeClass('pause').addClass('play').text(slider.vars.playText);
      }
    }
    
    //FlexSlider: Automatic Slideshow Start/Resume
    slider.resume = function() {
      slider.animatedSlides = setInterval(slider.animateSlides, slider.vars.slideshowSpeed);
      if (slider.vars.pausePlay) {
        slider.pausePlay.removeClass('play').addClass('pause').text(slider.vars.pauseText);
      }
    }
    
    //FlexSlider: Helper function for non-looping sliders
    slider.canAdvance = function(target) {
      if (!slider.vars.animationLoop && slider.atEnd) {
        if (slider.currentSlide == 0 && target == slider.count - 1 && slider.direction != "next") {
          return false;
        } else if (slider.currentSlide == slider.count - 1 && target == 0 && slider.direction == "next") {
          return false;
        } else {
          return true;
        }
      } else {
        return true;
      }  
    }
    
    //FlexSlider: Helper function to determine animation target
    slider.getTarget = function(dir) {
      slider.direction = dir;
      if (dir == "next") {
        return (slider.currentSlide == slider.count - 1) ? 0 : slider.currentSlide + 1;
      } else {
        return (slider.currentSlide == 0) ? slider.count - 1 : slider.currentSlide - 1;
      }
    }
    
    //FlexSlider: Helper function to set CSS3 transitions
    slider.setTransition = function(dur) {
      slider.container.css({'-webkit-transition-duration': (dur/1000) + "s"});
    }

    //FlexSlider: Initialize
    slider.init();
  }
  
  //FlexSlider: Default Settings
  jQuery.flexslider.defaults = {
    animation: "fade",              //String: Select your animation type, "fade" or "slide"
    slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
    slideshow: true,                //Boolean: Animate slider automatically
    slideshowSpeed: 5000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
    animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
    directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
    controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
    keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
    mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
    prevText: "Previous",           //String: Set the text for the "previous" directionNav item
    nextText: "Next",               //String: Set the text for the "next" directionNav item
    pausePlay: false,               //Boolean: Create pause/play dynamic element
    pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
    playText: 'Play',               //String: Set the text for the "play" pausePlay item
    randomize: false,               //Boolean: Randomize slide order
    slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
    animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
    pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
    pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
    controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
    manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
    start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
    before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
    after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
    end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
  }
  
  //FlexSlider: Plugin Function
  jQuery.fn.flexslider = function(options) {
    return this.each(function() {
      if (jQuery(this).find('.slides > li').length == 1) {
        jQuery(this).find('.slides > li').fadeIn(400);
      }
      else if (jQuery(this).data('flexsliderInit') != true) {
        new jQuery.flexslider(this, options);
      }
    });
  }  

})(jQuery);

jQuery('.flexslider').flexslider();
var breakPoint1 = 950; // cssのブレイクポイントよりもスクロールバー分少なめ
var breakPoint2 = 655;

/*----------------------------------------------------------*/
/*	使い方
/*----------------------------------------------------------*/
/*
━━━━━━━━━━━━━━━━━━━━
画面が狭い場合に画像をaltテキストに置換する
━━━━━━━━━━━━━━━━━━━━
class="resImgTxtChange-mobile-tab"
class="resImgTxtChange-mobile-only"

━━━━━━━━━━━━━━━━━━━━
モバイル時にモバイル用の画像に切替
━━━━━━━━━━━━━━━━━━━━
imageにclass="resImage-mobile" クラスを指定
画像ファイル名末尾に _mobile を追加
【例】 sample_mobile.jpeg

━━━━━━━━━━━━━━━━━━━━
CSSで表示・非表示を切り替える
━━━━━━━━━━━━━━━━━━━━
class="show-mobile-tab"
class="show-tab-full"
class="show-full-only"

━━━━━━━━━━━━━━━━━━━━
文字の改行ポイント
━━━━━━━━━━━━━━━━━━━━
改行したい箇所以降をspanにclassをつけて囲う
<span class="txtBr-full-only"></span>

━━━━━━━━━━━━━━━━━━━━
写真に画像の回り込みの場合のテキスト部分の横幅制御
━━━━━━━━━━━━━━━━━━━━
[class名] 外側の要素 : .ttBox / 画像（又はその枠） : .ttBoxThumb / テキスト部分 : .ttBoxTxt
ttBoxThumb にはcss側でサイズを指定をしてください（画像サイズをCSSで可変させた場合にも追従させるため）。
.ttBoxThumb/.ttBoxTxt はそれぞれ回り込みを指定してください　（画像を右にするか左にするかは案件によって異なるため）

/*----------------------------------------------------------*/
/*	画像をaltテキストに置き換えたり戻したり
/*----------------------------------------------------------*/
/*	写真に画像の回り込みの場合のテキスト部分の横幅制御
/*		[class名] 外側の要素 : ttBox / 画像（又はその枠） : ttBoxThumb / テキスト部分 : ttBoxTxt
/*
【example】
<div class="ttBox">
<div class="ttBoxThumb left"><img src="" alt="" /></div>
<div class="ttBoxTxt right">テキスト</div>
</div><!-- [ /.ttBox ] -->
*/
/*----------------------------------------------------------*/
/*	メニューの開閉
/*	<div id="menu" onclick="showHide('menu');" class="itemOpen">MENU</div>
/*----------------------------------------------------------*/
/*	トップへ戻る
/*----------------------------------------------------------*/


/*----------------------------------------------------------*/
/*	要素の表示／非表示の切り替え
/*----------------------------------------------------------*/
jQuery(function(){
	resVektorRun();
});
jQuery(document).ready(function(){
	resVektorRun();
});
jQuery(window).resize(function(){
	resVektorRun();
});

/*
fullsize > breakPoint1 ;
tab_pc > breakPoint2 ;
breakPoint1 < tab < breakPoint2;
tab_mobile < breakPoint1 ;
mobile < breakPoint2;
*/
var mode;
function resVektorRun(){
	resThumbTxtFix();
	var bodyWidth = jQuery(window).width();
	// ウィンドウサイズが960より小さい場合
	if ( bodyWidth <= breakPoint2 ) {
		// 現在のモードがモバイルじゃなかった場合にモバイルへの変換処理
		if(mode != "mode_mobile"){
			showHide_mode_mobile();
			changeImageFile_mode_mobile();
			resImgTxtChange_mode_mobile();
			// dropNav_mode_mobile();
			dropNavReset();
			dropNavFunctions();
			dropNavSubControlLinkDelete();
			mode = "mode_mobile";
		}
	}
	if ( (breakPoint2 < bodyWidth) && (bodyWidth < breakPoint1) ) {
		// 現在のモードがフルサイズじゃなかった場合にフルサイズへの変換処理
		if(mode != "mode_tab"){
			showHide_mode_tab();
			changeImageFile_mode_tab();
			resImgTxtChange_mode_tab();
			// dropNav_mode_tab();
			dropNavReset();
			dropNavFunctions();
			dropNavSubControlLinkDelete();
			mode = "mode_tab";
		}
	}
	// ウィンドウサイズが960より大きい場合
	if ( breakPoint1 <= bodyWidth ) {
		// 現在のモードがフルサイズじゃなかった場合にフルサイズへの変換処理
		if(mode != "mode_full"){
			showHide_mode_full();
			changeImageFile_mode_full();
			resImgTxtChange_mode_full();
			// dropNav_mode_full();
			dropNavReset();
			dropNavSubControlLinkRedo()
			mode = "mode_full";
		}
	}
}

/*----------------------------------------------------------*/
/*	要素の表示／非表示の切り替え
/*----------------------------------------------------------*/
function showHide_mode_full(){
	jQuery('.show-tab-full,.show-full-only').each(function(){
		jQuery(this).show();
	});
	jQuery('.show-mobile-only,.show-mobile-tab,.show-tab-only').each(function(){
		jQuery(this).hide();
	});
}
function showHide_mode_tab(){
	jQuery('.show-mobile-tab,.show-tab-only,.show-tab-full').each(function(){
		jQuery(this).show();
	});
	jQuery('.show-mobile-only,.show-full-only').each(function(){
		jQuery(this).hide();
	});
}
function showHide_mode_mobile(){
	jQuery('.show-mobile-only,.show-mobile-tab').each(function(){
		jQuery(this).show();
	});
	jQuery('.show-tab-only,.show-tab-full,.show-full-only').each(function(){
		jQuery(this).hide();
	});
}

/*----------------------------------------------------------*/
/*	画像ファイルの切り替え処理
/*----------------------------------------------------------*/

function changeImageFile_mode_mobile(){
	mobileImageChange();
}
function changeImageFile_mode_tab(){
	mobileImageBack();
}
function changeImageFile_mode_full(){
	mobileImageBack();
}
/*		モバイル用の画像ファイルに切り替える
------------------------------------------------------------*/
function mobileImageChange(){
	jQuery('img.resImage-mobile').each(function(){
		if(jQuery(this).hasClass('resImgMobile') != true){
			var imgPath = jQuery(this).attr('src').replace(/(\.[a-zA-Z]+)$/, "_mobile"+"$1");
			// 画像のファイルパスを置換　/ モバイル画像使用中識別用のクラス付与
			jQuery(this).attr('src',imgPath).addClass('resImgMobile');
		}
	});
}
/*		モバイル用になっていた画像をフルサイズ用の画像ファイルに戻す
------------------------------------------------------------*/
function mobileImageBack(){
	jQuery('img.resImage-mobile').each(function(){
		if(jQuery(this).hasClass('resImgMobile')){
			var imgPath = jQuery(this).attr('src').replace(/_mobile(\.[a-zA-Z]+)$/, ""+"$1");
			jQuery(this).attr('src',imgPath).removeClass('resImgMobile');
		}
	});
}

/*----------------------------------------------------------*/
/*	ドロップダウンナビの制御
/*----------------------------------------------------------*/
// function dropNav_mode_mobile(){
// 	dropNavFunctions();
// 	dropNavSubControlLinkDelete();
// }
// function dropNav_mode_tab(){
// 	dropNavFunctions();
// 	dropNavSubControlLinkDelete();
// }
// function dropNav_mode_full(){
// 	// サブドロップダウンボタンのaタグのURLを戻す
// 	dropDownSubControlLinkRedo()
// }
/*----------------------------------------------------------*/
/*	ドロップダウンナビの制御
/*----------------------------------------------------------*/

function dropNavFunctions(){
	/*------------------------------------------------------------
		ドロップダウンナビを展開する
	------------------------------------------------------------*/
	jQuery('.dropNavControl').each(function(){
		var dropNavUnit = jQuery(this).next();
		jQuery(this).click(function(){
			if (jQuery(this).hasClass('dropNavOpen')){
				// 既にdropNavが開かれている時 > close
				jQuery(this).removeClass('dropNavOpen');
				dropNavUnit.animate({ height:"0" });
			} else {
				// dropNavが開かれていない時　> open
				jQuery(this).removeClass('dropNavOpen');
				// 透明度0で見えないようにした状態にする
				dropNavUnit.css({"position":"absolute","opacity":"0","height":"auto"});
				// 高さを取得
				var subMenuHeight = dropNavUnit.height();
				dropNavUnit.css({"position":"relative","opacity":"1","height":"0","display":"block"});
				dropNavUnit.animate({ height:subMenuHeight },function(){
					jQuery(this).css({"height":"auto"});
				});
				jQuery(this).addClass('dropNavOpen');
			}
		});
	});
	/*------------------------------------------------------------
		リサイズされた場合に高さを再処理
	------------------------------------------------------------*/
	// jQuery(window).resize(function(){
	// 	jQuery('.dropNavControl').each(function(){
	// 		var dropNavUnit = jQuery(this).next();
	// 		if (jQuery(this).hasClass('dropNavOpen')){
	// 			dropNavUnit.css({"height":"auto"});
	// 			var subMenuHeight = dropNavUnit.height();
	// 			dropNavUnit.css({"height":subMenuHeight});
	// 		}
	// 	});
	// });
}
function dropNavReset(){
	jQuery('a.dropNavControl.dropNavSubControl').each(function(){
		jQuery(this).next().hide();
	});
}
/*		サブドロップダウンボタンのaタグのURLを逃がす
/*----------------------------------------------------------*/
function dropNavSubControlLinkDelete(){
	jQuery('a.dropNavControl.dropNavSubControl').each(function(){
		if ( jQuery(this).hasClass('subControlMode') !== true ) {
			jQuery(this).addClass('subControlMode');
			var linkUrl = jQuery(this).attr('href');
			// リンクURLを # に変更 / 本当のURLは span にいれて前に出力
			jQuery(this).attr('href','#').before('<span class="subControlLinkUrl">' + linkUrl + '</span>');
			// 本当のURLを格納したspanを隠す
			jQuery(this).prev().hide();
		}
	});
}
/*		サブドロップダウンボタンのaタグのURLを戻す
/*----------------------------------------------------------*/
function dropNavSubControlLinkRedo(){
	jQuery('span.subControlLinkUrl').each(function(){
		var linkUrl = jQuery(this).html();
		// リンクURLを元に戻す / サブコントロール識別用クラスを外す
		jQuery(this).next().attr('href',linkUrl).removeClass('subControlMode');
		jQuery(this).remove();
	});
}
/*----------------------------------------------------------*/
/*	画像をaltテキストに置き換えたり戻したり
/*----------------------------------------------------------*/
function resImgTxtChange_mode_mobile(){
	resImgTxtChange_mobile_only();
	resImgTxtChange_mobile_tab();
}
function resImgTxtChange_mode_tab(){
	resImgTxtChange_mobile_tab();
	resImgTxtBack_mobile_only();

}
function resImgTxtChange_mode_full(){
	resImgTxtBack_mobile_tab();
}

function resImgTxtChange_mobile_only(){
	jQuery('img.resImgTxtChange-mobile-only').each(function(){
		// ボタン画像の前に既にaltテキストがあるかどうか
		var spanClass = jQuery(this).prev().hasClass('resTxtChange-mobile-only');
		// ボタン画像の前にテキストが無い場合
		if (spanClass === false) {
			// ボタン画像のaltの文字をspanで囲って altTxt に代入
			var altTxt = '<span class="resTxtChange-mobile-only">'+jQuery(this).attr('alt')+'</span>';
			// ボタン画像の前に altTxt を出力
			jQuery(this).before(altTxt);
			// ボタン画像をcssで非表示に
			jQuery(this).hide();
		}
	});
}
function resImgTxtChange_mobile_tab(){
	jQuery('img.resImgTxtChange-mobile-tab').each(function(){
		// ボタン画像の前に既にaltテキストがあるかどうか
		var spanClass = jQuery(this).prev().hasClass('resTxtChange-mobile-tab');
		// ボタン画像の前にテキストが無い場合
		if (spanClass === false) {
			// ボタン画像のaltの文字をspanで囲って altTxt に代入
			var altTxt = '<span class="resTxtChange-mobile-tab">'+jQuery(this).attr('alt')+'</span>';
			// ボタン画像の前に altTxt を出力
			jQuery(this).before(altTxt);
			// ボタン画像をcssで非表示に
			jQuery(this).hide();
		}
	});
}

/*		テキストにしたボタンを画像に戻す
/*----------------------------------------------------------*/
function resImgTxtBack_mobile_tab(){
	jQuery('span.resTxtChange-mobile-tab').each(function(){
		// ボタン画像を表示
		jQuery(this).next().show();
		// テキスト化したaltを削除
		jQuery(this).remove();
	});
}
function resImgTxtBack_mobile_only(){
	jQuery('span.resTxtChange-mobile-only').each(function(){
		// ボタン画像を表示
		jQuery(this).next().show();
		// テキスト化したaltを削除
		jQuery(this).remove();
	});
}

/*----------------------------------------------------------*/
/*	写真に画像の回り込みの場合のテキスト部分の横幅制御
/*		[class名] 外側の要素 : ttBox / 画像（又はその枠） : ttBoxThumb / テキスト部分 : ttBoxTxt
/*----------------------------------------------------------*/
function resThumbTxtFix(){
	jQuery('.ttBox').each(function(){
		var parentWidth = jQuery(this).width();
		var imgWidth = jQuery(this).children('.ttBoxThumb').width();
		// var txtWidth = jQuery(this).children('.ttBoxTxt').width();
		txtWidth = parentWidth - imgWidth - 15;
		jQuery(this).children('.ttBoxTxt').css({"width":txtWidth});
	});
}
/*-------------------------------------------*/
/*	メニューの開閉
/*	<div id="menu" onclick="showHide('menu');" class="itemOpen">MENU</div>
/*-------------------------------------------*/
function showHide(targetID) {
	if( document.getElementById(targetID)) {
		var targetItem = '#' + targetID;
		if ( jQuery(targetItem).hasClass('itemOpen')) {
			document.getElementById(targetID).className = "itemClose";
		} else {
			document.getElementById(targetID).className = "itemOpen";
		}
	}
}

/*-------------------------------------------*/
/*	トップへ戻る
/*-------------------------------------------*/
jQuery(document).ready(function(){
    // hide #back-top first
    jQuery("#back-top").hide();
    // fade in #back-top
    jQuery(function () {
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#back-top').fadeIn();
            } else {
                jQuery('#back-top').stop().fadeOut();
            }
        });
        // scroll body to 0px on click
        jQuery('#back-top a').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});


/*-------------------------------------------*/
/*	表示モード制御
/*-------------------------------------------*/
// // ユーザーエージェントを判別してモバイル端末の場合はフッターのナビゲーションに表示切り替え用のリンクを追加
// if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
// 	// モバイルからのアクセスの場合
// 	jQuery(document).ready(function(){
// 		console.log(jQuery.cookie("viewMode"));
// 		/***********************************/
// 		/* フッターに表示モード切り替えリンクを追加
// 		/***********************************/
// 		// 端末モードをモバイルに設定
// 		jQuery.cookie("viewItem","mobile");
// 		if ( jQuery.cookie("viewMode") == 'pc' ) {
// 			// モバイル端末だけれどPC表示表示だったらスマホ版の切り替えリンクを表示
// 			jQuery('#siteBottom').after('<div id="viewModeSwitch"><a href="" class="modeMobile">モバイル表示</a></div>');
// 		} else {
// 			// モバイル端末だけれどPC表示表示じゃない場合（モバイル版表示の場合）PC表示への切り替えリンクを表示
// 			jQuery.cookie("viewMode","mobile");
// 			jQuery('#siteBottom').after('<div id="viewModeSwitch"><a href="" class="modePc">PC表示</a></div>');
// 		}
// 	});
// } else	{
// 	jQuery(document).ready(function(){
// 		jQuery.cookie("viewMode","pc");
// 		jQuery.cookie("viewItem","pc");
// 	});
// }

// jQuery(document).ready(function(){
// 	if ( jQuery.cookie("viewMode") != 'mobile' && jQuery.cookie("viewItem") == 'mobile' ) {
// 		// モバイルからのアクセス＆表示モードがPCの時はレスポンシブ用のCSSを削除
// 		jQuery('#viewport').remove();
// 	} else {
// 		// 表示モードがモバイルの場合はviewport指定を追加
// 		jQuery('head').append('<meta id="viewport" name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=1.0, minimum-scale=1.0">');
// 	}
// 	// PC表示へ切り替え
// 	jQuery('#viewModeSwitch .modePc').click(function(){
// 		jQuery.cookie("viewMode","pc");
// 		// ※クリックされた時点で再読み込みするので事実上不必要
// 		jQuery(this).removeClass('modePc').addClass('modeMobile').text('モバイル表示');
// 	});
// 	// スマホ版へ切り替え
// 	jQuery('#viewModeSwitch .modeMobile').click(function(){
// 		jQuery.cookie("viewMode","mobile");
// 		// ※クリックされた時点で再読み込みするので事実上不必要
// 		jQuery(this).removeClass('modeMobile').addClass('modePc').text('PC表示');
// 	});
// });
/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd && define.amd.jQuery) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	} else {
		// Browser globals.
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function raw(s) {
		return s;
	}

	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	function converted(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}
		try {
			return config.json ? JSON.parse(s) : s;
		} catch(er) {}
	}

	var config = $.cookie = function (key, value, options) {

		// write
		if (value !== undefined) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = config.json ? JSON.stringify(value) : String(value);

			return (document.cookie = [
				encodeURIComponent(key), '=', config.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// read
		var decode = config.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		var result = key ? undefined : {};
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = decode(parts.join('='));

			if (key && key === name) {
				result = converted(cookie);
				break;
			}

			if (!key) {
				result[name] = converted(cookie);
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			$.cookie(key, '', $.extend(options, { expires: -1 }));
			return true;
		}
		return false;
	};

}));
