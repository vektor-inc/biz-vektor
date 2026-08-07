<?php
/**
 * Class Module_PanList_Test
 *
 * module_panList.php の日付アーカイブ（年別・月別・日別）分岐で、
 * get_the_archive_title() が返す HTML（<span> タグ）がそのまま
 * esc_html() され、画面に文字列として表示されてしまう不具合の回帰テスト。
 *
 * issue #353: 日付アーカイブのパンくずリストで
 * `年: <span>2023年</span>` のように <span> タグが文字列表示される不具合の回帰防止。
 *
 * @package Biz Vektor
 */

/**
 * module_panList.php の日付アーカイブ分岐を検証するテストクラス。
 */
class Module_PanList_Test extends WP_UnitTestCase {

	/**
	 * 日付アーカイブ（年別・月別・日別）へ go_to() した状態で
	 * module_panList.php を include し、出力されるパンくずリストの HTML に
	 * エスケープされた <span> タグ（&lt;span&gt;）が含まれないこと、
	 * および get_the_archive_title() のタグを除去したプレーンテキストが
	 * 含まれることを検証する。
	 */
	public function test_module_panList() {

		// 2023-01-15 の投稿を1件作成する.
		// go_to() で年別・月別・日別アーカイブ URL へ移動しても、
		// 該当する日付の投稿が無いと 404（is_date() が false）になってしまうため、
		// 年・月・日すべてのアーカイブに共通してヒットする投稿をあらかじめ用意する.
		self::factory()->post->create(
			array(
				'post_date'   => '2023-01-15 12:00:00',
				'post_status' => 'publish',
			)
		);

		// テストの配列.
		// url_callback: is_date() 分岐へ到達させるための対象 URL を生成するコールバック.
		$test_cases = array(
			array(
				'test_condition_name' => '年別アーカイブの場合 => <span> タグが文字列表示されずプレーンテキストになる',
				'url_callback'        => function () {
					return get_year_link( 2023 );
				},
			),
			array(
				'test_condition_name' => '月別アーカイブの場合 => <span> タグが文字列表示されずプレーンテキストになる',
				'url_callback'        => function () {
					return get_month_link( 2023, 1 );
				},
			),
			array(
				'test_condition_name' => '日別アーカイブの場合（境界値） => <span> タグが文字列表示されずプレーンテキストになる',
				'url_callback'        => function () {
					return get_day_link( 2023, 1, 15 );
				},
			),
		);

		foreach ( $test_cases as $case ) {

			// 対象の日付アーカイブ URL へ移動しクエリを構築する.
			$this->go_to( call_user_func( $case['url_callback'] ) );

			// 前提条件として is_date() 分岐へ入ることを確認する.
			$this->assertTrue( is_date(), $case['test_condition_name'] . '（前提: is_date() が true であること）' );

			// 期待するプレーンテキスト（WordPress コア関数の出力からタグを除去したもの）.
			// module_panList.php と同じリクエストコンテキストで呼ぶため、
			// 翻訳文言やロケールの違いに依存せず比較できる.
			$expected_plain_text = wp_strip_all_tags( get_the_archive_title() );

			// header.php から get_template_part('module_panList') で呼ばれるのと同様に
			// module_panList.php を include し、出力をキャプチャする.
			ob_start();
			include get_stylesheet_directory() . '/module_panList.php';
			$breadcrumb_html = ob_get_clean();

			// <span> タグがエスケープされて文字列表示されないこと（不具合の直接的な症状）.
			$this->assertStringNotContainsString( '&lt;span&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;span&gt; が含まれないこと）' );
			$this->assertStringNotContainsString( '&lt;/span&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;/span&gt; が含まれないこと）' );

			// タグを除去したプレーンテキストが breadcrumb 内に含まれること.
			$this->assertStringContainsString( esc_html( $expected_plain_text ), $breadcrumb_html, $case['test_condition_name'] . '（プレーンテキストが含まれること）' );
		}
	}
}
