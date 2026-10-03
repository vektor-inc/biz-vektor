<?php
/**
 * Class Ad_Tag_Sanitize_Test
 *
 * 広告タグ欄の保存時検証（biz_vektor_sanitize_ad_tag）のテスト。
 *
 * @package Biz Vektor
 */

/**
 * 権限に応じて広告タグ欄の値が整えられることを検証するテストクラス。
 */
class Ad_Tag_Sanitize_Test extends WP_UnitTestCase {

	/**
	 * unfiltered_html 権限の有無で結果が変わること。
	 */
	public function test_biz_vektor_sanitize_ad_tag() {
		$test_cases = array(
			array(
				'test_condition_name' => '権限なし・script を含む値 => script タグが除去される',
				'role'                => 'author',
				'unfiltered_html'     => false,
				'value'               => '<script>var a = 1;</script><p>text</p>',
				'expected'            => 'var a = 1;<p>text</p>',
			),
			array(
				'test_condition_name' => '権限なし・装飾タグ => 残る',
				'role'                => 'author',
				'unfiltered_html'     => false,
				'value'               => '<span class="x">text</span>',
				'expected'            => '<span class="x">text</span>',
			),
			array(
				'test_condition_name' => '権限あり・script を含む値 => そのまま残る',
				'role'                => 'administrator',
				'unfiltered_html'     => true,
				'value'               => '<script>var a = 1;</script><p>text</p>',
				'expected'            => '<script>var a = 1;</script><p>text</p>',
			),
			array(
				'test_condition_name' => '権限あり・装飾タグ => 残る',
				'role'                => 'administrator',
				'unfiltered_html'     => true,
				'value'               => '<span class="x">text</span>',
				'expected'            => '<span class="x">text</span>',
			),
			array(
				'test_condition_name' => '権限なし・文字列以外の値 => 空文字になる',
				'role'                => 'author',
				'unfiltered_html'     => false,
				'value'               => array( '<p>text</p>' ),
				'expected'            => '',
			),
		);

		foreach ( $test_cases as $test_case ) {
			// ロール別のユーザーを作成してログインし、権限の有無が想定どおりか確認
			$user_id = self::factory()->user->create( array( 'role' => $test_case['role'] ) );
			wp_set_current_user( $user_id );
			$this->assertSame( $test_case['unfiltered_html'], current_user_can( 'unfiltered_html' ), $test_case['test_condition_name'] );

			// 検証関数を実行して結果を比較
			$actual = biz_vektor_sanitize_ad_tag( $test_case['value'] );
			$this->assertSame( $test_case['expected'], $actual, $test_case['test_condition_name'] );
		}
	}
}
