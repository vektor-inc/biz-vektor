<?php
/**
 * Class Blog_List_Test
 *
 * inc/theme-options.php の RSS 一覧表示（biz_vektor_blogList）のテスト。
 *
 * @package Biz Vektor
 */

/**
 * RSS 一覧の出力を検証するテストクラス。
 */
class Blog_List_Test extends WP_UnitTestCase {

	/**
	 * テスト中に返すフィードの本文.
	 *
	 * @var string|WP_Error
	 */
	private $feed_response;

	/**
	 * 外部への HTTP 取得を差し替える.
	 *
	 * @return array|WP_Error
	 */
	public function mock_http() {
		if ( is_wp_error( $this->feed_response ) ) {
			return $this->feed_response;
		}
		return array(
			'headers'  => array(),
			'body'     => $this->feed_response,
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'cookies'  => array(),
			'filename' => null,
		);
	}

	/**
	 * RSS 2.0 のフィードを組み立てる.
	 *
	 * @param string $title_xml XML としてそのまま埋め込む title 要素の中身.
	 * @param string $link_xml  XML としてそのまま埋め込む link 要素の中身.
	 * @return string
	 */
	private function rss2( $title_xml, $link_xml ) {
		return '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"><channel><title>t</title>'
			. '<item><title>' . $title_xml . '</title><link>' . $link_xml . '</link><pubDate>Sun, 15 Jan 2023 12:00:00 +0000</pubDate></item>'
			. '</channel></rss>';
	}

	/**
	 * フィードの記事タイトル・リンク・見出しを安全な形で出力し、見出しの装飾タグは保つこと。
	 */
	public function test_biz_vektor_blogList() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常の記事 => 日付・タイトル・リンクが表示される',
				'feed'                => $this->rss2( 'お知らせ &amp; 更新', 'https://example.com/news/' ),
				'label'               => 'ブログ',
				'expected_contains'   => array( '2023.01.15', 'href="https://example.com/news/"', 'お知らせ &amp; 更新', '<h2>ブログ</h2>' ),
				'not_contains'        => array(),
			),
			array(
				'test_condition_name' => 'タイトルにタグ、リンクに javascript: を含む記事 => タグは取り除かれ、リンクは無効化される',
				'feed'                => $this->rss2( 'お知らせ&lt;br&gt;&lt;img src=x onerror=alert(1)&gt;です', 'javascript:alert(1)' ),
				'label'               => 'ブログ',
				'expected_contains'   => array( '>お知らせです</a>' ),
				'not_contains'        => array( '<img', '&lt;img', '&lt;br', 'javascript:' ),
			),
			array(
				'test_condition_name' => '見出しに装飾タグを含む => br と class 付き span は保たれ、script は取り除かれる',
				'feed'                => $this->rss2( 'お知らせ', 'https://example.com/news/' ),
				'label'               => 'ブログ<br><span class="x">更新情報</span><script>alert(1)</script>',
				'expected_contains'   => array( '<h2>ブログ<br><span class="x">更新情報</span>alert(1)</h2>' ),
				'not_contains'        => array( '<script>' ),
			),
			array(
				'test_condition_name' => '取得に失敗した場合 => エラーにならず何も出力しない',
				'feed'                => new WP_Error( 'http_request_failed', 'failed' ),
				'label'               => 'ブログ',
				'expected_contains'   => array(),
				'not_contains'        => array( 'topBlog' ),
			),
		);

		add_filter( 'pre_http_request', array( $this, 'mock_http' ) );

		foreach ( $test_cases as $case ) {
			$this->feed_response = $case['feed'];

			ob_start();
			biz_vektor_blogList(
				array(
					'url'   => 'https://example.com/feed/',
					'label' => $case['label'],
				)
			);
			$html = ob_get_clean();

			foreach ( $case['expected_contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $html, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $html, $case['test_condition_name'] );
			}
		}

		remove_filter( 'pre_http_request', array( $this, 'mock_http' ) );
	}
}
