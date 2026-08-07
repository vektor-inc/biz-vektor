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
	 * および期待するプレーンテキストが含まれることを検証する。
	 *
	 * 期待値はプロダクションコードと同じ式（wp_strip_all_tags( get_the_archive_title() )）
	 * で作らず、リテラルの文字列で持つ。同一式同士の比較にすると、
	 * 万が一 name が空文字へ退行しても assertStringContainsString( '', $html ) が
	 * 無条件に true になり、テストが素通りしてしまうため。
	 */
	public function test_module_panList() {

		// 期待値をリテラルの英語文言で持たせるため、テスト中のロケールを
		// en_US に固定する（wp-env のテスト環境は既定で en_US だが、
		// 環境差で落ちないよう明示的に固定する）.
		// アサーション失敗時も含め、必ず元のロケールへ戻すため try/finally で囲む.
		switch_to_locale( 'en_US' );

		try {

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
			// target_url    : is_date() 分岐へ到達させるための対象 URL（クエリに依存しないため事前に評価できる）.
			// title_filter  : get_the_archive_title の戻り値を差し替える第三者フィルタ（null なら差し替えない）.
			// expected      : module_panList.php の出力に含まれるべきプレーンテキストのリテラル値.
			$test_cases = array(
				array(
					'test_condition_name' => '年別アーカイブの場合 => <span> タグが除去されプレーンテキストになる',
					'target_url'          => get_year_link( 2023 ),
					'title_filter'        => null,
					'expected'            => 'Year: 2023',
				),
				array(
					'test_condition_name' => '月別アーカイブの場合 => <span> タグが除去されプレーンテキストになる',
					'target_url'          => get_month_link( 2023, 1 ),
					'title_filter'        => null,
					'expected'            => 'Month: January 2023',
				),
				array(
					'test_condition_name' => '日別アーカイブの場合 => <span> タグが除去されプレーンテキストになる',
					'target_url'          => get_day_link( 2023, 1, 15 ),
					'title_filter'        => null,
					'expected'            => 'Day: January 15, 2023',
				),
				array(
					'test_condition_name' => '異常系: 第三者フィルタが属性付きタグと script を返す場合 => タグも script の中身も除去される',
					'target_url'          => get_year_link( 2023 ),
					'title_filter'        => '<span class="x">2023</span><script>alert(1)</script>年鑑',
					'expected'            => '2023年鑑',
				),
			);

			foreach ( $test_cases as $case ) {

				// テストケース自体の前提: expected が空文字でないこと.
				// ここが空だと assertStringContainsString( '', $html ) が無条件に true になり、
				// name が空文字へ退行してもテストが素通りしてしまうため、先に潰しておく.
				$this->assertNotEmpty( $case['expected'], $case['test_condition_name'] . '（テストケース自体の前提: expected が空でないこと）' );

				// 第三者フィルタで get_the_archive_title() の戻り値を差し替えるケース.
				// アサーション失敗時も含め、必ずフィルタを外すため try/finally で囲む.
				$title_filter_callback = null;
				if ( null !== $case['title_filter'] ) {
					$fixed_title           = $case['title_filter'];
					$title_filter_callback = function () use ( $fixed_title ) {
						return $fixed_title;
					};
					add_filter( 'get_the_archive_title', $title_filter_callback );
				}

				try {

					// 対象の日付アーカイブ URL へ移動しクエリを構築する.
					$this->go_to( $case['target_url'] );

					// 前提条件として is_date() 分岐へ入ることを確認する.
					$this->assertTrue( is_date(), $case['test_condition_name'] . '（前提: is_date() が true であること）' );

					// header.php から get_template_part('module_panList') で呼ばれるのと同様に
					// module_panList.php を include し、出力をキャプチャする.
					// 無名関数でスコープを閉じることで、テンプレート内で使われるローカル変数
					// （$post_type, $breadcrumb_array, $key, $value, $microdata_li 等）が
					// テストメソッドのスコープへ漏れないようにする.
					$breadcrumb_html = ( function () {
						ob_start();
						include get_stylesheet_directory() . '/module_panList.php';
						return ob_get_clean();
					} )();

					// <span> タグ・script タグがエスケープされて文字列表示されないこと（不具合の直接的な症状）.
					$this->assertStringNotContainsString( '&lt;span&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;span&gt; が含まれないこと）' );
					$this->assertStringNotContainsString( '&lt;/span&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;/span&gt; が含まれないこと）' );
					$this->assertStringNotContainsString( '&lt;script&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;script&gt; が含まれないこと）' );

					// リテラルの期待値（プロダクションコードと同一の式で作らない）が含まれること.
					$this->assertStringContainsString( esc_html( $case['expected'] ), $breadcrumb_html, $case['test_condition_name'] . '（期待するプレーンテキストが含まれること）' );

				} finally {
					// 次のケースへ影響させないよう必ずフィルタを外す.
					if ( null !== $title_filter_callback ) {
						remove_filter( 'get_the_archive_title', $title_filter_callback );
					}
				}
			}
		} finally {
			// ロケールを元に戻す.
			restore_current_locale();
		}
	}
}
