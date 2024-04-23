# VK Admin

## 概要



## 使い方

Composer の require に登録
```
composer require vektor-inc/vk-admin
```

autoload.pho を読み込み
```
require_once dirname( __FILE__ ) . '/vendor/autoload.php';
```

本体を読み込んで実行

```
use VektorInc\VK_Admin\VK_Admin;
new VK_Admin();
```


---

## Change log

== 0.5.0 ==
[ Other ]  Add article list of Vektor Pattern Library

== 0.4.1 ==
[ Bug Fix ] Fixed problem of filepath on Windows local environment.

== 0.4.0 ==
[ Other ] Cope with English news
[ Bug Fix ] Fix Widget Edit UI