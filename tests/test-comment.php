<?php
/**
 * Class Comment_Test
 *
 * functions.php のコメント表示（biz_vektor_comment）のテスト。
 *
 * @package Biz Vektor
 */

/**
 * コメント投稿者名・URL の表示を検証するテストクラス。
 */
class Comment_Test extends WP_UnitTestCase {

	/**
	 * コメント投稿者の名前や URL に「%」が含まれていても、エラーにならずに表示されること。
	 */
	public function test_biz_vektor_comment() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常の名前と URL => 名前とリンクが表示される',
				'author'              => 'テスト太郎',
				'author_url'          => 'https://example.com/',
				'expected_contains'   => array( 'テスト太郎', 'href="https://example.com/"' ),
			),
			array(
				'test_condition_name' => '名前に % を含む => 名前がそのまま表示される',
				'author'              => '100% %s 太郎',
				'author_url'          => '',
				'expected_contains'   => array( '100% %s 太郎' ),
			),
			array(
				'test_condition_name' => 'URL にパーセントエンコードを含む => リンクがそのまま表示される',
				'author'              => 'テスト花子',
				'author_url'          => 'https://example.com/%E3%81%82',
				'expected_contains'   => array( 'テスト花子', 'href="https://example.com/%E3%81%82"' ),
			),
		);

		$post_id = self::factory()->post->create();

		foreach ( $test_cases as $case ) {
			$comment_id = self::factory()->comment->create(
				array(
					'comment_post_ID'    => $post_id,
					'comment_author'     => $case['author'],
					'comment_author_url' => $case['author_url'],
					'comment_approved'   => 1,
					'comment_type'       => 'comment',
				)
			);
			$comment = get_comment( $comment_id );

			ob_start();
			biz_vektor_comment( $comment, array( 'max_depth' => 5 ), 1 );
			$html = ob_get_clean();

			foreach ( $case['expected_contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $html, $case['test_condition_name'] );
			}
		}
	}
}
