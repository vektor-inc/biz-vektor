<?php
/**
 * Class Sample_Test
 *
 * @package Biz Vektor
 */

/**
 * Smoke test.
 */
class Sample_Test extends WP_UnitTestCase {

	/**
	 * PHPUnit / テスト環境が正しく起動しているかを確認するスモークテスト。
	 */
	public function test_smoke() {
		$this->assertTrue( true );
	}

	/**
	 * テスト環境で BizVektor テーマが有効になっていることを確認する。
	 *
	 * テーマのフォルダ名は worktree 上では biz-vektor 以外になるため、
	 * フォルダ名（stylesheet）ではなくテーマ名で判定する。
	 */
	public function test_active_theme() {
		$this->assertEquals( 'BizVektor', wp_get_theme()->get( 'Name' ), '有効なテーマが BizVektor であること' );
	}
}
