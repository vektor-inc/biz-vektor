BizVektor本体をアップデートしました。今回も構造変更がメインです。

※今回のアップデートでは構造が大きくかわっているので、<strong><span style="color: #ff0000;">現在子テーマでカスタマイズしていて、header.phpをカスタマイズしている場合はβ11をインストールするとエラーになるのでサイトが表示されなくなります。</span></strong>子テーマのheader.phpをカスタマイズしている方は、β11のheader.phpを元にカスタマイズしなおしてください。
※header.phpは変更が多々入るのでカスタマイズはあまりお勧めしていません。
<h2>β11での変更点</h2>
<h4>機能追加</h4>
<ul>
	<li><strong><span style="color: #ff0000;">レスポンシブのサイトをより作りやすくするためのjQuery ライブラリ「ResVektor」を搭載。</span></strong>
特定のクラス名をつける事によって、画面サイズに応じて表示内容の切り替えや読み込む画像ファイルを切り替えが出来るようになりました。</li>
	<li>ページをスクロールした際に画面右下にPAGETOPボタンを自動で表示</li>
</ul>
<h4>仕様変更</h4>
<ul>
	<li>ソースの可読性を優先してheader.phpに独自の関数を書く方式をとっていましたが、公式登録を前提とした機能分散などに備え、<span style="color: #ff0000;"><strong>header.phpに書いてあった下記のタグを廃止</strong></span>しました（wp_head経由で出力されるようになります）。
biz_vektor_theme_style()、
biz_vektor_theme_styleOldIe()、
biz_vektor_gMenuDivide()、
biz_vektor_googleAnalytics（）</li>
	<li>カスタム投稿タイプ info で作成者をサポートするように変更</li>
</ul>
<h4>不具合修正</h4>
<ul>
	<li>各種phpエラーの改善</li>
</ul>
<h2>レスポンシブ対応コンテンツ制作のために今回追加した機能</h2>
今回のバージョンで実装したレスポンシブ対応コンテンツ作成用のライブラリ<span class="txtBr-full-only">「ResVektor」の主な活用方法についてご紹介します。</span>
<blockquote><span style="color:#f00;font-weight:bold;">画面サイズを切り替えて、表示されている要素が変更される事をご確認ください。</span></blockquote>
<h3>モバイル時にモバイル用の画像に自動で切替</h3>
imgタグに class="resImage-mobile" クラスを指定する事によって、画面サイズが小さい場合に画像ファイルを切り替える事が出来ます。
モバイル用の画像は、通常の画像のファイル名の末尾に _mobile を追加します。
<h4>class名を指定しない場合</h4>
<img alt="" src="http://bizvektor.com/wp-content/uploads/res_image_test.gif" />
<h4>class名を指定して、モバイル用画像を用意した場合</h4>
<img class="resImage-mobile" alt="" src="http://bizvektor.com/wp-content/uploads/res_image_test.gif" />

【例】
sample.jpg ・・・　PC、タブレットサイズ用画像
sample_mobile.jpg ・・・　モバイル用画像
[sourcecode language="php"]<img class="resImage-mobile" alt="" src="http://bizvektor.com/wp-content/uploads/res_image_test.gif" />[/sourcecode]
<h3>CSSで表示・非表示を切り替える</h3>
<h4>モバイル、タブレットサイズ以下の場合表示</h4>
<div class="show-mobile-tab">
<blockquote>■モバイル、タブレットサイズ以下の場合表示されます</blockquote>
</div>
クラス名　：　class="show-mobile-tab"
 【記入例】
[sourcecode language="php"]<div class="show-mobile-tab">
<blockquote>
■モバイル、タブレットサイズ以下の場合表示されます</blockquote>
</div>[/sourcecode]
<h4>タブレットサイズ以上の場合表示</h4>
<div class="show-tab-full">
<blockquote>■タブレットサイズ以上の場合表示</blockquote>
</div>
クラス名　：　class="show-tab-full"
【記入例】

[sourcecode language="php"]<div class="show-tab-full">
<blockquote>
■タブレットサイズ以上の場合表示</blockquote>
</div>[/sourcecode]
<h4>画面サイズが大きい場合のみ表示</h4>
<div class="show-full-only">
<blockquote>■画面サイズが大きい場合のみ表示</blockquote>
</div>
クラス名　：　class="show-full-only"
【記入例】
[sourcecode language="php"]<div class="show-full-only"><blockquote>■画面サイズが大きい場合のみ表示</blockquote></div>[/sourcecode]
<h3>画面が狭い場合に画像をaltテキストに置換する</h3>
画像にaltタグを入力して、下記の指定のclass名を設定すると、画面が狭くなると画像ではなくaltを表示します。
<h4>モバイル、タブレットサイズ以下では画像ではなくaltテキストを表示</h4>
<img class="resImgTxtChange-mobile-tab" alt="★★★モバイルとタブの場合テキスト" src="http://bizvektor.com/wp-content/themes/biz-vektor-official/images/mainVisual_001.jpg" />
クラス名　：　class="resImgTxtChange-mobile-tab"
【記入例】
[sourcecode language="php"]<img class="resImgTxtChange-mobile-tab" alt="★★★モバイルとタブの場合テキスト" src="http://bizvektor.com/wp-content/themes/biz-vektor-official/images/mainVisual_001.jpg" />[/sourcecode]
<h4>モバイルサイズ以下では画像ではなくaltテキストを表示</h4>
<img class="resImgTxtChange-mobile-only" alt="★★★モバイルの場合のテキスト" src="http://bizvektor.com/wp-content/themes/biz-vektor-official/images/mainVisual_001.jpg" />
クラス名　：　class="resImgTxtChange-mobile-only"
【記入例】
[sourcecode language="php"]<img class="resImgTxtChange-mobile-only" alt="★★★モバイルの場合のテキスト" src="http://bizvektor.com/wp-content/themes/biz-vektor-official/images/mainVisual_001.jpg" />[/sourcecode]
<h3>画面が広い場合は指定した場所で改行</h3>
文字数の長い文章の場合、読みやすいように読点などの任意の場所で改行したい。
でも読点で強制改行してしまうとスマートフォンで見た時に、無駄な改行が入っていておかしい！

そんな問題を解消します。

改行したい場所から後ろを &lt;span class="txtBr-full-only"&gt;&lt;/span&gt; で囲います。
<blockquote>長い文章です。モバイルだと改行されません。<span class="txtBr-full-only">受託のウェブ制作の場合、クライアントさんから、</span><span class="txtBr-full-only">「ここの読点で改行」などの指示を受けて、でも内心</span><span class="txtBr-full-only">「いやいや、それモバイルで見たらおかしいから！」</span><span class="txtBr-full-only">という事はちょくちょくあるのではないでしょうか？</span></blockquote>
【記入例】
[sourcecode language="php"]長い文章です。モバイルだと改行されません。<span class="txtBr-full-only">受託のウェブ制作の場合、クライアントさんから、</span><span class="txtBr-full-only">「ここの読点で改行」などの指示を受けて、でも内心</span><span class="txtBr-full-only">「いやいや、それモバイルで見たらおかしいから！」</span><span class="txtBr-full-only">という事はちょくちょくあるのではないでしょうか？</span>[/sourcecode]