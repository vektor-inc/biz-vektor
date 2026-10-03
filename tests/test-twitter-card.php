<?php
/**
 * Class Twitter_Card_Test
 *
 * plugins/sns/module_twitter_card.php の Twitter カード出力のテスト。
 *
 * @package Biz Vektor
 */

/**
 * Twitter カードの meta タグ出力を検証するテストクラス。
 */
class Twitter_Card_Test extends WP_UnitTestCase {

	/**
	 * 説明文・タイトル・アカウント名を meta タグの属性値として安全な形で出力すること。
	 */
	public function test_biz_vektor_twitter_card() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常の抜粋とタイトル => そのまま出力される',
				'post_title'          => 'テスト記事',
				'post_excerpt'        => 'テストの抜粋です',
				'twitter'             => 'vektor_inc',
				'expected_contains'   => array(
					'<meta name="twitter:description" content="テストの抜粋です">',
					'テスト記事',
					'content="@vektor_inc"',
				),
				'not_contains'        => array(),
			),
			array(
				'test_condition_name' => '抜粋に引用符を含む => 引用符がエスケープされ、属性が増えない',
				'post_title'          => 'テスト記事',
				'post_excerpt'        => '0;url=https://example.com/" http-equiv="refresh',
				'twitter'             => 'vektor_inc',
				'expected_contains'   => array( 'content="0;url=https://example.com/&quot; http-equiv=&quot;refresh"' ),
				'not_contains'        => array( '" http-equiv="refresh"' ),
			),
			array(
				'test_condition_name' => '抜粋に装飾タグを含む => タグが文字として出力されない',
				'post_title'          => 'テスト記事',
				'post_excerpt'        => 'お知らせ<br><span class="x">です</span>',
				'twitter'             => 'vektor_inc',
				'expected_contains'   => array( '<meta name="twitter:description" content="お知らせです">' ),
				'not_contains'        => array( '&lt;br', '&lt;span', '<br>' ),
			),
			array(
				'test_condition_name' => 'タイトルに装飾タグを含む => タグが文字として出力されない',
				'post_title'          => 'お知らせ<br><span class="x">です</span>',
				'post_excerpt'        => 'テストの抜粋です',
				'twitter'             => 'vektor_inc',
				'expected_contains'   => array( '<meta name="twitter:title" content="お知らせです' ),
				'not_contains'        => array( '&lt;br', '&lt;span' ),
			),
			array(
				'test_condition_name' => 'アカウント名に引用符を含む => 引用符がエスケープされる',
				'post_title'          => 'テスト記事',
				'post_excerpt'        => 'テストの抜粋です',
				'twitter'             => 'a"><script>alert(1)</script>',
				'expected_contains'   => array( 'content="@a&quot;&gt;&lt;script&gt;' ),
				'not_contains'        => array( '<script>' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$options              = get_option( 'biz_vektor_theme_options', array() );
			$options              = is_array( $options ) ? $options : array();
			$options['twitter']   = $case['twitter'];
			$options['ogpImage']  = 'https://example.com/ogp.png';
			update_option( 'biz_vektor_theme_options', $options );

			$post_id = self::factory()->post->create(
				array(
					'post_title'   => $case['post_title'],
					'post_excerpt' => $case['post_excerpt'],
				)
			);
			$this->go_to( get_permalink( $post_id ) );
			the_post();

			ob_start();
			biz_vektor_twitter_card();
			$html = ob_get_clean();

			foreach ( $case['expected_contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $html, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $html, $case['test_condition_name'] );
			}
			wp_reset_postdata();
		}
	}
}
