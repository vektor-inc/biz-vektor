<?php
/**
 * Class SEO_And_GA_Test
 *
 * plugins/seo_and_ga/seo_and_ga.php のメタキーワード出力・保存処理のテスト。
 *
 * @package Biz Vektor
 */

/**
 * メタキーワードの出力と保存を検証するテストクラス。
 */
class SEO_And_GA_Test extends WP_UnitTestCase {

	/**
	 * 投稿メタ metaKeyword を head に出力するときに、属性値として安全な形で出力されること。
	 */
	public function test_biz_vektor_seo_set_HeadKeywords() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常のカンマ区切りキーワード => そのまま出力される',
				'meta'                => 'テスト,キーワード',
				'expected_contains'   => 'テスト,キーワード" />',
				'not_contains'        => array(),
			),
			array(
				'test_condition_name' => '属性から抜け出す文字列 => 引用符がエスケープされ、タグが出力されない',
				'meta'                => 'a"><script>alert(1)</script>',
				'expected_contains'   => 'a&quot;&gt;" />',
				'not_contains'        => array( '<script>', '"><' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$post_id = self::factory()->post->create();
			update_post_meta( $post_id, 'metaKeyword', wp_slash( $case['meta'] ) );
			$this->go_to( get_permalink( $post_id ) );
			the_post();

			ob_start();
			biz_vektor_seo_set_HeadKeywords();
			$html = ob_get_clean();

			$this->assertStringContainsString( $case['expected_contains'], $html, $case['test_condition_name'] );
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $html, $case['test_condition_name'] );
			}
			wp_reset_postdata();
		}
	}

	/**
	 * 投稿編集画面の入力欄に、保存済みの値を属性値として安全な形で出力すること。
	 */
	public function test_insert_custom_field_metaKeyword() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常のキーワード => value にそのまま出力される',
				'meta'                => 'テスト,キーワード',
				'expected_contains'   => 'value="テスト,キーワード"',
			),
			array(
				'test_condition_name' => '属性から抜け出す文字列 => 引用符と山括弧がエスケープされる',
				'meta'                => '" autofocus onfocus="alert(1)',
				'expected_contains'   => 'value="&quot; autofocus onfocus=&quot;alert(1)"',
			),
		);

		foreach ( $test_cases as $case ) {
			$post_id = self::factory()->post->create();
			update_post_meta( $post_id, 'metaKeyword', wp_slash( $case['meta'] ) );
			$GLOBALS['post'] = get_post( $post_id );

			ob_start();
			insert_custom_field_metaKeyword();
			$html = ob_get_clean();

			$this->assertStringContainsString( $case['expected_contains'], $html, $case['test_condition_name'] );
		}
	}

	/**
	 * 保存時にタグが取り除かれ、バックスラッシュなどの文字が失われないこと。
	 */
	public function test_save_custom_field_metaKeyword() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常のキーワード => そのまま保存される',
				'input'               => 'テスト,キーワード',
				'expected'            => 'テスト,キーワード',
			),
			array(
				'test_condition_name' => 'タグを含む値 => タグが取り除かれて保存される',
				'input'               => 'a<script>alert(1)</script>b',
				'expected'            => 'ab',
			),
			array(
				'test_condition_name' => 'バックスラッシュと引用符を含む値 => 失われずに保存される',
				'input'               => 'C:\\path,"quoted"',
				'expected'            => 'C:\\path,"quoted"',
			),
		);

		$user_id = self::factory()->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $user_id );

		foreach ( $test_cases as $case ) {
			$post_id = self::factory()->post->create();

			// nonce は seo_and_ga.php 内の plugin_basename( __FILE__ ) と同じ値で作る（__FILE__ は実パスになる）.
			$_POST = array(
				'noncename_custom_field_metaKeyword' => wp_create_nonce( plugin_basename( realpath( get_template_directory() . '/plugins/seo_and_ga/seo_and_ga.php' ) ) ),
				'post_type'                          => 'post',
				// $_POST は WordPress によってスラッシュが付与された状態で渡される.
				'metaKeyword'                        => wp_slash( $case['input'] ),
			);
			save_custom_field_metaKeyword( $post_id );

			$this->assertSame( $case['expected'], get_post_meta( $post_id, 'metaKeyword', true ), $case['test_condition_name'] );
		}
		$_POST = array();
	}
}
