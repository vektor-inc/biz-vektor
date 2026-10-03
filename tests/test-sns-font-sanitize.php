<?php
/**
 * Class Sns_Font_Sanitize_Test
 *
 * Facebook アプリ ID と海外向けフォント名の保存時の整形関数のテスト。
 *
 * @package Biz Vektor
 */

/**
 * 保存時の整形関数が許可した文字だけを残すことを検証するテストクラス。
 */
class Sns_Font_Sanitize_Test extends WP_UnitTestCase {

	/**
	 * Facebook アプリ ID は数字だけになること。
	 */
	public function test_biz_vektor_sanitize_fb_app_id() {
		$test_cases = array(
			array( '数字のみ => そのまま', '1234567890', '1234567890' ),
			array( '数字以外を含む => 数字だけ', '12-34 ab', '1234' ),
			array( '空文字 => 空文字', '', '' ),
		);
		foreach ( $test_cases as $case ) {
			$this->assertSame( $case[2], biz_vektor_sanitize_fb_app_id( $case[1] ), $case[0] );
		}
	}

	/**
	 * フォント名は英数字・+・空白だけになること。
	 */
	public function test_biz_vektor_sanitize_global_font() {
		$test_cases = array(
			array( 'Open+Sans => そのまま', 'Open+Sans', 'Open+Sans' ),
			array( '空白を含む => そのまま', 'Open Sans', 'Open Sans' ),
			array( '記号を含む => 許可文字だけ', 'Arvo (Bold)!', 'Arvo Bold' ),
			array( '空文字 => 空文字', '', '' ),
		);
		foreach ( $test_cases as $case ) {
			$this->assertSame( $case[2], biz_vektor_sanitize_global_font( $case[1] ), $case[0] );
		}
	}
}
