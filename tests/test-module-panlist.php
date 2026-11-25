<?php
/**
 * Class Module_PanList_Test
 *
 * module_panList.php が出力するパンくずリストの HTML を検証するテスト。
 *
 * - issue #353: 日付アーカイブのパンくずリストで
 *   `年: <span>2023年</span>` のように <span> タグが文字列表示される不具合の回帰防止。
 * - issue #452: パンくず全体が nav（ナビゲーション領域）で囲まれ、
 *   現在ページの項目だけに aria-current="page" が付き、microdata が残ること。
 *
 * @package Biz Vektor
 */

/**
 * module_panList.php の出力を検証するテストクラス。
 */
class Module_PanList_Test extends WP_UnitTestCase {

	/**
	 * 固定ページ・投稿・各アーカイブ・検索結果・404 へ go_to() した状態で
	 * module_panList.php を include し、出力されるパンくずリストの HTML を検証する。
	 *
	 * 検証内容:
	 * - nav が 1 つだけあり、aria-label が付き、#panList の内側で #panListInner を囲んでいること
	 * - 現在ページの項目だけに aria-current="page" が付くこと
	 * - すべての項目に microdata（itemprop / itemscope / itemtype）が残ること
	 * - 日付アーカイブで <span> タグがエスケープされて文字列表示されないこと
	 * - bizvektor_panList_array フィルターが空配列・キー欠落の配列・配列以外を返しても PHP エラーにならないこと
	 *
	 * 期待値はプロダクションコードと同じ式で作らず、リテラルの文字列で持つ。
	 * 同一式同士の比較にすると、出力が退行しても期待値も同じように変わり、テストが素通りしてしまうため。
	 */
	public function test_module_panList() {

		// 期待値をリテラルの英語文言で持たせるため、テスト中のロケールを
		// en_US に固定する（wp-env のテスト環境は既定で en_US だが、
		// 環境差で落ちないよう明示的に固定する）.
		// なお switch_to_locale() は現在のロケールが既に指定先と同じ場合は
		// 切り替え不要のため false を返す no-op になる（本環境では通常この経路）。
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

			// 固定ページ（第一階層と、親を持つ子階層）を作成する.
			$page_id        = self::factory()->post->create(
				array(
					'post_type'  => 'page',
					'post_title' => 'Test Page',
				)
			);
			$parent_page_id = self::factory()->post->create(
				array(
					'post_type'  => 'page',
					'post_title' => 'Parent Page',
				)
			);
			$child_page_id  = self::factory()->post->create(
				array(
					'post_type'   => 'page',
					'post_title'  => 'Child Page',
					'post_parent' => $parent_page_id,
				)
			);

			// カテゴリーと、そのカテゴリーに属する投稿を作成する.
			$category_id = self::factory()->category->create( array( 'name' => 'Test Category' ) );
			$post_id     = self::factory()->post->create(
				array(
					'post_title'    => 'Test Post',
					'post_category' => array( $category_id ),
				)
			);

			// 作者アーカイブ用に、投稿を1件持つ作者を作成する.
			$author_id = self::factory()->user->create(
				array(
					'role'         => 'author',
					'display_name' => 'Test Author',
				)
			);
			self::factory()->post->create( array( 'post_author' => $author_id ) );

			// 現在ページの項目の開始タグ（microdata と aria-current 付き）と、項目名の span の開始タグ.
			$current_li = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" aria-current="page"><span itemprop="name">';

			// テストの配列.
			// target_url        : 移動先の URL.
			// conditional_tag   : 前提として true になるべき条件分岐タグ名（その分岐へ到達できているかの確認用）.
			// title_filter      : get_the_archive_title の戻り値を差し替える第三者フィルタ（null なら差し替えない）.
			// panlist_filter    : bizvektor_panList_array フィルターの差し替え（null なら差し替えない。差し替える場合は returns に返す値を入れる）.
			// expected
			//   li_count           : 出力される li の数（すべての li に microdata が付く数でもある）.
			//   aria_current_count : aria-current="page" が出力される数.
			//   current_item_html  : aria-current="page" が付いた li と、その直後に続く HTML のリテラル（null なら検証しない）.
			//                        最後の項目のときは直後の </ul> まで含め、最後の項目に付いていることも確かめる.
			$test_cases = array(
				array(
					'test_condition_name' => '固定ページ（第一階層）の場合 => ページ名の項目だけに aria-current が付く',
					'target_url'          => get_permalink( $page_id ),
					'conditional_tag'     => 'is_page',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 2,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Test Page</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '固定ページ（子階層）の場合 => 親ページはリンクのまま、子ページ名の項目だけに aria-current が付く',
					'target_url'          => get_permalink( $child_page_id ),
					'conditional_tag'     => 'is_page',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Child Page</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '投稿の場合 => 投稿タイトルの項目だけに aria-current が付く',
					'target_url'          => get_permalink( $post_id ),
					'conditional_tag'     => 'is_single',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 4,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Test Post</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => 'カテゴリーアーカイブの場合 => カテゴリー名の項目だけに aria-current が付く',
					'target_url'          => get_category_link( $category_id ),
					'conditional_tag'     => 'is_category',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Test Category</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '作者アーカイブ（最後の項目が投稿一覧へのリンク）の場合 => リンクではなく作者名の項目に aria-current が付く',
					'target_url'          => get_author_posts_url( $author_id ),
					'conditional_tag'     => 'is_author',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Test Author</span></li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="',
					),
				),
				array(
					'test_condition_name' => '年別アーカイブの場合 => <span> タグが除去されプレーンテキストになり、その項目に aria-current が付く',
					'target_url'          => get_year_link( 2023 ),
					'conditional_tag'     => 'is_date',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Year: 2023</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '月別アーカイブの場合 => <span> タグが除去されプレーンテキストになり、その項目に aria-current が付く',
					'target_url'          => get_month_link( 2023, 1 ),
					'conditional_tag'     => 'is_date',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Month: January 2023</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '日別アーカイブの場合 => <span> タグが除去されプレーンテキストになり、その項目に aria-current が付く',
					'target_url'          => get_day_link( 2023, 1, 15 ),
					'conditional_tag'     => 'is_date',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Day: January 15, 2023</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '検索結果の場合 => 検索結果の項目だけに aria-current が付く',
					'target_url'          => home_url( '/?s=keyword' ),
					'conditional_tag'     => 'is_search',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 2,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Search Results for : keyword</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '404 の場合 => Not found の項目だけに aria-current が付く',
					'target_url'          => home_url( '/?p=999999' ),
					'conditional_tag'     => 'is_404',
					'title_filter'        => null,
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 2,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Not found</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '異常系: 第三者フィルタが属性付きタグと script を返す場合 => タグも script の中身も除去される',
					'target_url'          => get_year_link( 2023 ),
					'conditional_tag'     => 'is_date',
					'title_filter'        => '<span class="x">2023</span><script>alert(1)</script>年鑑',
					'panlist_filter'      => null,
					'expected'            => array(
						'li_count'           => 3,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . '2023年鑑</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '異常系: bizvektor_panList_array が空配列を返す場合 => エラーにならず、nav は残り、aria-current は付かない',
					'target_url'          => get_permalink( $page_id ),
					'conditional_tag'     => 'is_page',
					'title_filter'        => null,
					'panlist_filter'      => array( 'returns' => array() ),
					'expected'            => array(
						'li_count'           => 0,
						'aria_current_count' => 0,
						'current_item_html'  => null,
					),
				),
				array(
					'test_condition_name' => '異常系: bizvektor_panList_array が id・url などのキーが欠けた項目を返す場合 => エラーにならず、リンクの無い最後の項目に aria-current が付く',
					'target_url'          => get_permalink( $page_id ),
					'conditional_tag'     => 'is_page',
					'title_filter'        => null,
					'panlist_filter'      => array(
						'returns' => array(
							array(
								'name' => 'Linked Item',
								'url'  => 'https://example.com/',
							),
							array(
								'name' => 'Name Only Item',
							),
						),
					),
					'expected'            => array(
						'li_count'           => 2,
						'aria_current_count' => 1,
						'current_item_html'  => $current_li . 'Name Only Item</span></li></ul>',
					),
				),
				array(
					'test_condition_name' => '異常系: bizvektor_panList_array が配列以外（null）を返す場合 => エラーにならず、項目なしとして出力される',
					'target_url'          => get_permalink( $page_id ),
					'conditional_tag'     => 'is_page',
					'title_filter'        => null,
					'panlist_filter'      => array( 'returns' => null ),
					'expected'            => array(
						'li_count'           => 0,
						'aria_current_count' => 0,
						'current_item_html'  => null,
					),
				),
			);

			foreach ( $test_cases as $case ) {

				// 第三者フィルタで get_the_archive_title() の戻り値を差し替えるケース.
				// アサーション失敗時も含め、必ずフィルタを外すため try/finally で囲む.
				$title_filter_callback = null;
				if ( null !== $case['title_filter'] ) {
					$fixed_title           = $case['title_filter'];
					/**
					 * アーカイブタイトルをテストケースで指定した値に差し替える.
					 *
					 * @return string テストケースで指定したアーカイブタイトル.
					 */
					$title_filter_callback = function () use ( $fixed_title ) {
						return $fixed_title;
					};
					add_filter( 'get_the_archive_title', $title_filter_callback );
				}

				// bizvektor_panList_array フィルターでパンくずの項目を差し替えるケース.
				$panlist_array_callback = null;
				if ( null !== $case['panlist_filter'] ) {
					$fixed_return           = $case['panlist_filter']['returns'];
					/**
					 * パンくずの項目の配列を、テストケースで指定した値に差し替える.
					 *
					 * @return mixed テストケースで指定した値（配列以外を返す異常系も含む）.
					 */
					$panlist_array_callback = function () use ( $fixed_return ) {
						return $fixed_return;
					};
					add_filter( 'bizvektor_panList_array', $panlist_array_callback );
				}

				try {

					// 対象の URL へ移動しクエリを構築する.
					$this->go_to( $case['target_url'] );

					// 前提条件として、狙った条件分岐へ入ることを確認する.
					$this->assertTrue( call_user_func( $case['conditional_tag'] ), $case['test_condition_name'] . '（前提: ' . $case['conditional_tag'] . '() が true であること）' );

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

					// nav が 1 つだけで、aria-label が付き、#panList の内側で #panListInner を囲んでいること.
					$this->assertSame( 1, substr_count( $breadcrumb_html, '<nav' ), $case['test_condition_name'] . '（nav の開始タグが 1 つだけであること）' );
					$this->assertSame( 1, substr_count( $breadcrumb_html, '</nav>' ), $case['test_condition_name'] . '（nav の終了タグが 1 つだけであること）' );
					$this->assertStringContainsString( "<div id=\"panList\">\n<nav aria-label=\"Breadcrumb\">\n<div id=\"panListInner\" class=\"innerBox\"><ul>", $breadcrumb_html, $case['test_condition_name'] . '（#panList の内側に aria-label 付きの nav があり、#panListInner を囲んでいること）' );
					$this->assertStringContainsString( "</ul></div>\n</nav>\n</div>", $breadcrumb_html, $case['test_condition_name'] . '（nav が #panListInner の後、#panList の中で閉じていること）' );

					// aria-current="page" が現在ページの項目の数だけ付くこと.
					$this->assertSame( $case['expected']['aria_current_count'], substr_count( $breadcrumb_html, 'aria-current="page"' ), $case['test_condition_name'] . '（aria-current="page" の数）' );

					// aria-current="page" が付いた li（とその直後の HTML）が期待どおりであること.
					if ( null !== $case['expected']['current_item_html'] ) {
						$this->assertStringContainsString( $case['expected']['current_item_html'], $breadcrumb_html, $case['test_condition_name'] . '（aria-current="page" が付いた項目）' );
					}

					// すべての li に microdata が残ること.
					$this->assertSame( $case['expected']['li_count'], substr_count( $breadcrumb_html, '<li' ), $case['test_condition_name'] . '（li の数）' );
					$this->assertSame( $case['expected']['li_count'], substr_count( $breadcrumb_html, 'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"' ), $case['test_condition_name'] . '（すべての li に microdata が付いていること）' );
					$this->assertSame( $case['expected']['li_count'], substr_count( $breadcrumb_html, '<span itemprop="name">' ), $case['test_condition_name'] . '（すべての項目名に itemprop="name" が付いていること）' );

					// <span> タグ・script タグがエスケープされて文字列表示されないこと（issue #353 の不具合の直接的な症状）.
					$this->assertStringNotContainsString( '&lt;span&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;span&gt; が含まれないこと）' );
					$this->assertStringNotContainsString( '&lt;/span&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;/span&gt; が含まれないこと）' );
					$this->assertStringNotContainsString( '&lt;script&gt;', $breadcrumb_html, $case['test_condition_name'] . '（&lt;script&gt; が含まれないこと）' );

				} finally {
					// 次のケースへ影響させないよう必ずフィルタを外す.
					if ( null !== $title_filter_callback ) {
						remove_filter( 'get_the_archive_title', $title_filter_callback );
					}
					if ( null !== $panlist_array_callback ) {
						remove_filter( 'bizvektor_panList_array', $panlist_array_callback );
					}
				}
			}
		} finally {
			// ロケールを元に戻す.
			restore_current_locale();
		}
	}
}
