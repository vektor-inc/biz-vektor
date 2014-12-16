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
.ttBoxLeft / .ttBoxRight でそれぞれ回り込む

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
	// console.log('_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!!2');
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
		if ( jQuery(targetItem).hasClass('itemOpen') ) {
			document.getElementById(targetID).className = "itemClose";
		} else {
			document.getElementById(targetID).className = "itemOpen";
		}
	}
	// resVektorRun();
	// console.log('_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!!');
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