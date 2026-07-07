<?php
use VektorInc\VK_Admin\VkAdmin;

// vendor ディレクトリ無しで誤配信された場合など VkAdmin クラスが読み込めない環境では
// Fatal Error を出さないようにクラスの存在を確認してから初期化する.
if ( class_exists( VkAdmin::class ) ) {
	VkAdmin::init();
}
