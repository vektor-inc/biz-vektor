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
	 * テスト環境で有効なテーマが biz-vektor であることを確認する。
	 */
	public function test_active_theme() {
		$this->assertEquals( 'biz-vektor', get_option( 'stylesheet' ), '有効なテーマが biz-vektor であること' );
	}
}
