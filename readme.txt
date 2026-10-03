
== Description ==
BizVektor theme will allow you to build a high-quality business web site.It is possible to change the color in the Theme Customizer, to switch to a completely different design.In addition, it is possible to increase the design by the plug-in.
Official site : https://github.com/vektor-inc

=== Tags ===
white, red, blue, black, green, orange, purple, two-columns, right-sidebar, left-sidebar, one-columns, responsive, custom-background, custom-colors, custom-header, custom-menu, editor-style,theme-options


=== Features ===
Specializing in the business-friendly, Change design, Supports customizer, Responsive Layout, Many theme Setting options, Child page list template, Display contact information, Page Navigation, Breadcrumb Navigation, and more!


=== Widgets Areas ===
The Theme has 4 widget areas.
You can use these area to customize the content of your website.


== License ==
Unless otherwise specified, all the theme files, scripts and images are licensed under GNU General Public License version 2, see file license.txt.
The exceptions to this license are as follows:
The script html5.js and css3-mediaqueries.js are licensed under MIT
Header Images are photo by theme author and are released under GPL license.


== Author ==
The theme built by Hidekazu Ishikawa (kurudrive) at Vektor,Inc.
You can contact me at inquiry form.
http://bizvektor.com/contact/


== Changelog ==
https://github.com/kurudrive/biz-vektor/commits/master

* [ 仕様変更 ] 管理画面の共通ライブラリ vektor-inc/vk-admin を 0.5.0 から 0.8.1 にアップデート
* [ 不具合修正 ] テーマオプションの設定初期化処理に nonce と権限の確認を追加
* [ 不具合修正 ] キーカラー設定で、#rrggbb / #rgb 形式以外の値（rgba() や色名など）を保存・出力しないよう修正。以前これらの値を設定していた場合は、各デザインスキンの既定色に戻ります
* [ 不具合修正 ] 全幅見出しウィジェットで、保存時の値の検証と出力時の検証を修正。文字色に #rrggbb / #rgb 形式以外（色名など）を設定していた場合は、文字色が反映されなくなります
* [ 不具合修正 ] ブロック版ウィジェット編集画面でブラウザコンソールに JavaScript エラーが繰り返し表示される不具合を修正
* [ 不具合修正 ] テーマオプション・カスタマイザの設定値（ロゴ・ファビコン・スライド・問い合わせ情報・3PR・広告欄・投稿タイプの表示名など）で、保存時の値の整形と出力時のエスケープを追加。以前、画像の代替テキストに HTML タグを入れていた場合は、タグが取り除かれます。以前、URL 欄に「contact/」のような / から始まらない相対パスを入れていた場合は、再保存しなくても先頭に http:// が付いてリンクが正しく動かなくなるため、https:// から始まる URL か / から始まるパスに入れ直してください。広告欄は、HTML の利用が制限される権限（マルチサイトのサイト管理者など）で保存すると、広告タグ（script など）が取り除かれます

== 1.13.4 ==
* [ 不具合修正 ] 固定ページ本文ウィジェットで「タイトルを表示させる」のチェックを外して保存するとPHP 8以降で未定義キー警告が記録される不具合を修正
* [ 不具合修正 ] ブロック版ウィジェット編集画面で全幅見出しウィジェットの画像設定ボタンが機能しない問題を修正
* [ 不具合修正 ] 日付アーカイブのパンくずリストで日付部分が `<span>` タグごと文字列として表示される不具合を修正

== 1.13.3 ==
* [ 不具合修正 ] vendor ディレクトリが無い状態で誤配信された際に VkAdmin クラス未定義で Fatal Error になる不具合を修正
* [ 不具合修正 ] 自動更新で vendor ディレクトリを含まないソース zip が配信され VkAdmin が動作しなくなる不具合を修正

== 1.13.2 ==
* [ 不具合修正 ] WordPress 6.7 以降で init より前に翻訳が読み込まれ _load_textdomain_just_in_time の PHP 通知が表示される不具合を修正

== 1.13.1 ==
* [ 不具合修正 ] WordPress 6.7 での翻訳不具合修正

== 1.13.0 ==
* [ 仕様変更 ] ダッシュボードの表示を BizVektor の情報から VWS 共通のものに変更
* [ 不具合修正 ] カラー処理関連の PHP エラー修正
* [ Big fix ] Fixed an issue where comments were not displaying after updating to WordPress 5.5.
* [ Bug fix ] Fixed issue with the process of adding the defer attribute

== 1.12.5 ==
* [ Specification Change ] Support for PHP8 or highter
* [ Specification Change ] Support for WordPress 6.4
