<?php
/**
 * Class Theme_Options_Reset_Test
 *
 * テーマオプションの設定初期化処理（biz_vektor_them_edit_function）のテスト。
 *
 * @package Biz Vektor
 */

/**
 * 設定の初期化に nonce・権限・確認番号・チェックが必要なことを検証するテストクラス。
 */
class Theme_Options_Reset_Test extends WP_UnitTestCase {

	/**
	 * 各テスト後に $_POST・設定エラー・ユーザー・保存オプションを元に戻す。
	 */
	public function tear_down() {
		$_POST = array();
		global $wp_settings_errors;
		$wp_settings_errors = array();
		wp_set_current_user( 0 );
		delete_option( 'biz_vektor_theme_options' );
		parent::tear_down();
	}

	/**
	 * 設定の初期化は、nonce・権限・確認番号・チェックがすべて揃った場合だけ実行されること。
	 */
	public function test_biz_vektor_them_edit_function() {
		$test_cases = array(
			array(
				'test_condition_name' => 'nonce・権限・確認番号・チェックがすべて正しい場合 => 初期化される',
				'role'                => 'administrator',
				'nonce'               => 'valid',
				'reset_key'           => '1234',
				'reset_key_port'      => '1234',
				'reset_check'         => 'True',
				'expected'            => true,
				'expected_error'      => false,
			),
			array(
				'test_condition_name' => 'nonce がない場合 => 初期化されない',
				'role'                => 'administrator',
				'nonce'               => 'none',
				'reset_key'           => '1234',
				'reset_key_port'      => '1234',
				'reset_check'         => 'True',
				'expected'            => false,
				'expected_error'      => true,
			),
			array(
				'test_condition_name' => 'nonce が不正な場合 => 初期化されない',
				'role'                => 'administrator',
				'nonce'               => 'invalid',
				'reset_key'           => '1234',
				'reset_key_port'      => '1234',
				'reset_check'         => 'True',
				'expected'            => false,
				'expected_error'      => true,
			),
			array(
				'test_condition_name' => 'テーマオプションを編集する権限がない場合 => 初期化されない',
				'role'                => 'subscriber',
				'nonce'               => 'valid',
				'reset_key'           => '1234',
				'reset_key_port'      => '1234',
				'reset_check'         => 'True',
				'expected'            => false,
				'expected_error'      => true,
			),
			array(
				'test_condition_name' => '確認番号が一致しない場合 => 初期化されない',
				'role'                => 'administrator',
				'nonce'               => 'valid',
				'reset_key'           => '1234',
				'reset_key_port'      => '9999',
				'reset_check'         => 'True',
				'expected'            => false,
				'expected_error'      => true,
			),
			array(
				'test_condition_name' => '確認番号が両方とも空の場合 => 初期化されない',
				'role'                => 'administrator',
				'nonce'               => 'valid',
				'reset_key'           => '',
				'reset_key_port'      => '',
				'reset_check'         => 'True',
				'expected'            => false,
				'expected_error'      => true,
			),
			array(
				'test_condition_name' => 'チェックボックスにチェックがない場合 => 初期化されない',
				'role'                => 'administrator',
				'nonce'               => 'valid',
				'reset_key'           => '1234',
				'reset_key_port'      => '1234',
				'reset_check'         => '',
				'expected'            => false,
				'expected_error'      => true,
			),
		);

		foreach ( $test_cases as $case ) {
			// 初期値と異なる設定を保存して、初期化されたかを判別できるようにする.
			global $wp_settings_errors;
			$wp_settings_errors     = array();
			$options                = biz_vektor_generate_default_options();
			$options['theme_style'] = 'changed-for-test';
			update_option( 'biz_vektor_theme_options', $options );

			// ユーザーを設定.
			wp_set_current_user( self::factory()->user->create( array( 'role' => $case['role'] ) ) );

			// 送信内容（フォームと同じ項目）を組み立てる.
			$post = array(
				'bizvektor_action_mode'    => 'reset',
				'bizvektor_reset_key'      => $case['reset_key'],
				'bizvektor_reset_key_port' => $case['reset_key_port'],
			);
			if ( '' !== $case['reset_check'] ) {
				$post['bizvektor_reset_check'] = $case['reset_check'];
			}
			if ( 'valid' === $case['nonce'] ) {
				$post['_wpnonce'] = wp_create_nonce( 'biz_vektor_options-options' );
			} elseif ( 'invalid' === $case['nonce'] ) {
				$post['_wpnonce'] = 'invalid-nonce';
			}
			$_POST = wp_slash( $post );

			// テスト関数実行.
			biz_vektor_them_edit_function( $_POST );

			// 初期化されたかを確認.
			$saved  = get_option( 'biz_vektor_theme_options' );
			$actual = ( ! isset( $saved['theme_style'] ) || 'changed-for-test' !== $saved['theme_style'] );
			$this->assertSame( $case['expected'], $actual, $case['test_condition_name'] );

			// 初期化されなかった場合は画面にエラーが出ることを確認.
			$this->assertSame( $case['expected_error'], ! empty( get_settings_errors( 'biz_vektor_options' ) ), $case['test_condition_name'] . '（エラー表示）' );
		}
	}

	/**
	 * options.php 経由の保存（sanitize コールバック）でも、確認が通らない初期化は行われないこと。
	 */
	public function test_biz_vektor_theme_options_validate() {
		$test_cases = array(
			array(
				'test_condition_name' => '初期化の確認がすべて正しい場合 => 初期値が返る',
				'with_nonce'          => true,
				'reset_check'         => 'True',
				'expected'            => true,
			),
			array(
				'test_condition_name' => 'チェックボックスにチェックがない場合 => 初期値は返らない',
				'with_nonce'          => true,
				'reset_check'         => '',
				'expected'            => false,
			),
			array(
				'test_condition_name' => 'nonce がない場合 => 初期値は返らない',
				'with_nonce'          => false,
				'reset_check'         => 'True',
				'expected'            => false,
			),
		);

		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );

		foreach ( $test_cases as $case ) {
			// 初期値と異なる設定を保存しておく.
			$options                = biz_vektor_generate_default_options();
			$options['theme_style'] = 'changed-for-test';
			update_option( 'biz_vektor_theme_options', $options );

			// 送信内容を組み立てる.
			$post = array(
				'bizvektor_action_mode'    => 'reset',
				'bizvektor_reset_key'      => '1234',
				'bizvektor_reset_key_port' => '1234',
			);
			if ( '' !== $case['reset_check'] ) {
				$post['bizvektor_reset_check'] = $case['reset_check'];
			}
			if ( $case['with_nonce'] ) {
				$post['_wpnonce'] = wp_create_nonce( 'biz_vektor_options-options' );
			}
			$_POST = wp_slash( $post );

			// テスト関数実行し、初期値が返ったかを確認.
			$result = biz_vektor_theme_options_validate( biz_vektor_generate_default_options() );
			$actual = ( isset( $result['theme_style'] ) && 'changed-for-test' !== $result['theme_style'] );
			$this->assertSame( $case['expected'], $actual, $case['test_condition_name'] );
		}
	}
}
