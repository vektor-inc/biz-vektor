<?php
/**
 * Class Keycolor_Sanitize_Test
 *
 * キーカラーのカラーコード検証（biz_vektor_sanitize_keycolor と各スキンの validate 関数）のテスト。
 *
 * @package Biz Vektor
 */

/**
 * キーカラーが正しいカラーコードだけを通すことを検証するテストクラス。
 */
class Keycolor_Sanitize_Test extends WP_UnitTestCase {

	/**
	 * 正しい形式はそのまま通り、空や不正な形式は既定値になること。
	 */
	public function test_biz_vektor_sanitize_keycolor() {
		$test_cases = array(
			array(
				'test_condition_name' => '6桁の16進カラーコード => そのまま返る',
				'color'               => '#c30000',
				'default'             => '#e90000',
				'expected'            => '#c30000',
			),
			array(
				'test_condition_name' => '3桁の16進カラーコード => そのまま返る',
				'color'               => '#f00',
				'default'             => '#e90000',
				'expected'            => '#f00',
			),
			array(
				'test_condition_name' => '空文字 => 既定値が返る',
				'color'               => '',
				'default'             => '#e90000',
				'expected'            => '#e90000',
			),
			array(
				'test_condition_name' => '色名のような不正な形式 => 既定値が返る',
				'color'               => 'notacolor',
				'default'             => '#e90000',
				'expected'            => '#e90000',
			),
			array(
				'test_condition_name' => '16進ではない文字を含む形式 => 既定値が返る',
				'color'               => '#12345g',
				'default'             => '#e90000',
				'expected'            => '#e90000',
			),
			array(
				'test_condition_name' => '先頭の # が無い形式 => 既定値が返る',
				'color'               => 'c30000',
				'default'             => '#e90000',
				'expected'            => '#e90000',
			),
			array(
				'test_condition_name' => '文字列以外の値 => 既定値が返る',
				'color'               => array( '#c30000' ),
				'default'             => '#e90000',
				'expected'            => '#e90000',
			),
		);

		foreach ( $test_cases as $test_case ) {
			// 検証関数に値と既定値を渡して結果を比較
			$actual = biz_vektor_sanitize_keycolor( $test_case['color'], $test_case['default'] );
			$this->assertSame( $test_case['expected'], $actual, $test_case['test_condition_name'] );
		}
	}

	/**
	 * 既定値を省略した場合、不正な形式は空文字になること。
	 */
	public function test_biz_vektor_sanitize_keycolor_without_default() {
		$this->assertSame( '', biz_vektor_sanitize_keycolor( 'notacolor' ) );
	}

	/**
	 * 001（標準）スキンの validate 関数が、不正な形式を空にして正しい形式を残すこと。
	 */
	public function test_default_design_validate() {
		// 正しい形式と不正な形式を混ぜて保存時の検証関数に渡す
		$output = biz_vektor_theme_options_default_design_validate(
			array(
				'theme_plusKeyColor'          => '#c30000',
				'theme_plusKeyColorLight'     => 'notacolor',
				'theme_plusKeyColorVeryLight' => '#12345g',
				'theme_plusKeyColorDark'      => '#900',
			)
		);
		$this->assertSame( '#c30000', $output['theme_plusKeyColor'] );
		$this->assertSame( '', $output['theme_plusKeyColorLight'] );
		$this->assertSame( '', $output['theme_plusKeyColorVeryLight'] );
		$this->assertSame( '#900', $output['theme_plusKeyColorDark'] );
	}

	/**
	 * 002（calmly）スキンの validate 関数が、不正な形式を空にして正しい形式を残すこと。
	 */
	public function test_calmly_validate() {
		// 不正な形式・正しい形式・未送信の項目を渡して保存時の検証関数を呼ぶ
		$output = biz_vektor_theme_options_calmly_validate(
			array(
				'theme_plusKeyColor'      => 'notacolor',
				'theme_plusKeyColorLight' => '#ff0000',
			)
		);
		$this->assertSame( '', $output['theme_plusKeyColor'] );
		$this->assertSame( '#ff0000', $output['theme_plusKeyColorLight'] );
		$this->assertSame( '', $output['theme_plusKeyColorDark'] );
	}
}
