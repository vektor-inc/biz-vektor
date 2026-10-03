<?php
/**
 * Class Widgets_Escape_Test
 *
 * テーマ独自ウィジェット（アーカイブ一覧・タクソノミー一覧・RSS・投稿一覧）の
 * 保存時の整形と出力時のエスケープのテスト。
 *
 * @package Biz Vektor
 */

/**
 * 各ウィジェットの update() / widget() / form() を検証するテストクラス。
 */
class Widgets_Escape_Test extends WP_UnitTestCase {

	/**
	 * 見出しの装飾タグ（br / span / div の class）を含む文字列。
	 *
	 * @var string
	 */
	const DECORATED = 'Head<br><span class="x">Em</span><div class="y">Box</div>';

	/**
	 * 出力を文字列として取得する。
	 *
	 * @param callable $callback 出力を行う処理。
	 * @return string
	 */
	private function capture( $callback ) {
		ob_start();
		call_user_func( $callback );
		return ob_get_clean();
	}

	/**
	 * 投稿一覧ウィジェットの update() で count が整数化され、見出しの装飾が残ること。
	 */
	public function test_update_post_list() {
		$widget = new WP_Widget_bizvektor_post_list();

		$test_cases = array(
			array(
				'test_condition_name' => '数値文字列の件数 => 整数になる',
				'count'               => '5',
				'label'               => self::DECORATED,
				'expected_count'      => 5,
			),
			array(
				'test_condition_name' => '-1（全件表示） => -1 のまま',
				'count'               => '-1',
				'label'               => 'Plain',
				'expected_count'      => -1,
			),
			array(
				'test_condition_name' => '-1 以外の負数 => 空になる',
				'count'               => '-3',
				'label'               => 'Plain',
				'expected_count'      => '',
			),
			array(
				'test_condition_name' => '0 => 空になる',
				'count'               => '0',
				'label'               => 'Plain',
				'expected_count'      => '',
			),
			array(
				'test_condition_name' => '数字以外 => 空になる',
				'count'               => 'abc',
				'label'               => 'Plain',
				'expected_count'      => '',
			),
			array(
				'test_condition_name' => 'タグを含む件数 => 空になる',
				'count'               => '<script>alert(1)</script>',
				'label'               => 'Plain',
				'expected_count'      => '',
			),
			array(
				'test_condition_name' => '空の件数 => 空になる',
				'count'               => '',
				'label'               => 'Plain',
				'expected_count'      => '',
			),
		);

		foreach ( $test_cases as $case ) {
			$instance = $widget->update(
				array(
					'count'     => $case['count'],
					'label'     => $case['label'],
					'format'    => '0',
					'post_type' => 'post',
					'terms'     => '1,2',
				),
				array()
			);
			$this->assertSame( $case['expected_count'], $instance['count'], $case['test_condition_name'] );
			$this->assertSame( $case['label'], $instance['label'], $case['test_condition_name'] . '（見出し）' );
		}

		// script は保存時に除去され、span の class は残る
		$instance = $widget->update(
			array(
				'count'     => '3',
				'format'    => '0',
				'post_type' => 'post',
				'terms'     => '',
				'label'     => 'A<script>alert(1)</script><span class="x">B</span>',
			),
			array()
		);
		$this->assertStringNotContainsString( '<script', $instance['label'] );
		$this->assertStringContainsString( '<span class="x">B</span>', $instance['label'] );
	}

	/**
	 * RSS ウィジェットの update() で URL が esc_url_raw され、見出しの装飾が残ること。
	 */
	public function test_update_rss() {
		$widget = new wp_widget_bizvektor_rss();

		$test_cases = array(
			array(
				'test_condition_name' => '通常の https URL => そのまま',
				'url'                 => 'https://example.com/feed/?a=1&b=2',
				'expected_url'        => 'https://example.com/feed/?a=1&b=2',
			),
			array(
				'test_condition_name' => 'javascript スキームの URL => 空になる',
				'url'                 => 'javascript:alert(1)',
				'expected_url'        => '',
			),
			array(
				'test_condition_name' => '引用符を含む URL => 引用符が除去される',
				'url'                 => 'https://example.com/"onfocus="alert(1)',
				'expected_url'        => 'https://example.com/onfocus=alert(1)',
			),
		);

		foreach ( $test_cases as $case ) {
			$instance = $widget->update(
				array(
					'url'   => $case['url'],
					'label' => self::DECORATED,
				),
				array()
			);
			$this->assertSame( $case['expected_url'], $instance['url'], $case['test_condition_name'] );
			$this->assertSame( self::DECORATED, $instance['label'], $case['test_condition_name'] . '（見出し）' );
		}
	}

	/**
	 * アーカイブ一覧・タクソノミー一覧ウィジェットの update() で見出しの装飾が文字化されないこと。
	 */
	public function test_update_label() {
		$test_cases = array(
			array(
				'test_condition_name' => 'アーカイブ一覧 => 装飾が残る',
				'widget'              => new WP_Widget_archive_list(),
				'new_instance'        => array(
					'post_type'    => 'post',
					'display_type' => 'm',
					'label'        => self::DECORATED,
					'hide'         => '',
				),
				'expected'            => self::DECORATED,
			),
			array(
				'test_condition_name' => 'タクソノミー一覧 => 装飾が残り文字化されない',
				'widget'              => new WP_Widget_taxonomy_list(),
				'new_instance'        => array(
					'tax_name' => 'category',
					'label'    => self::DECORATED,
					'hide'     => '',
				),
				'expected'            => self::DECORATED,
			),
			array(
				'test_condition_name' => 'タクソノミー一覧で script を含む => タグのみ除去',
				'widget'              => new WP_Widget_taxonomy_list(),
				'new_instance'        => array(
					'tax_name' => 'category',
					'label'    => '<script>alert(1)</script><span class="x">A</span>',
					'hide'     => '',
				),
				'expected'            => 'alert(1)<span class="x">A</span>',
			),
			array(
				'test_condition_name' => 'タクソノミー一覧で見出しが空 => hide の値になる',
				'widget'              => new WP_Widget_taxonomy_list(),
				'new_instance'        => array(
					'tax_name' => 'category',
					'label'    => '',
					'hide'     => 'Category',
				),
				'expected'            => 'Category',
			),
		);

		foreach ( $test_cases as $case ) {
			$instance = $case['widget']->update( $case['new_instance'], array() );
			$this->assertSame( $case['expected'], $instance['label'], $case['test_condition_name'] );
		}
	}

	/**
	 * 各ウィジェットの widget() で見出しの装飾が残り、script が出力されないこと。
	 */
	public function test_widget() {
		$post_id = self::factory()->post->create( array( 'post_title' => 'Widget Test Post' ) );

		$malicious = '<span class="x">A</span><br><script>alert(1)</script>';

		$test_cases = array(
			array(
				'test_condition_name' => 'アーカイブ一覧（イベント属性・javascript リンクが除去される）',
				'widget'              => new WP_Widget_archive_list(),
				'instance'            => array( 'label' => '<span class="x">A</span><br><span class="x" onclick="alert(1)">B</span><a href="javascript:alert(1)">C</a>' ),
			),
			array(
				'test_condition_name' => 'アーカイブ一覧',
				'widget'              => new WP_Widget_archive_list(),
				'instance'            => array( 'label' => $malicious ),
			),
			array(
				'test_condition_name' => 'タクソノミー一覧',
				'widget'              => new WP_Widget_taxonomy_list(),
				'instance'            => array( 'label' => $malicious ),
			),
			array(
				'test_condition_name' => '投稿一覧（保存済みの値でも出力時に除去される）',
				'widget'              => new WP_Widget_bizvektor_post_list(),
				'instance'            => array(
					'label'     => $malicious,
					'count'     => '5',
					'post_type' => 'post',
				),
			),
		);

		foreach ( $test_cases as $case ) {
			$args = array(
				'before_widget' => '<div class="widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			);
			$html = $this->capture(
				function () use ( $case, $args ) {
					$case['widget']->widget( $args, $case['instance'] );
				}
			);
			$this->assertStringContainsString( '<span class="x">A</span><br>', $html, $case['test_condition_name'] . '（装飾が残る）' );
			$this->assertStringNotContainsString( '<script>alert(1)</script>', $html, $case['test_condition_name'] . '（script が出力されない）' );
			$this->assertStringNotContainsString( 'onclick', $html, $case['test_condition_name'] . '（イベント属性が出力されない）' );
			$this->assertStringNotContainsString( 'javascript:', $html, $case['test_condition_name'] . '（javascript: が出力されない）' );
		}

		wp_delete_post( $post_id, true );
	}

	/**
	 * 投稿一覧ウィジェットの widget() で count が 0 や不正値のとき既定値 10 件になること。
	 */
	public function test_widget_post_list_count() {
		$post_ids = self::factory()->post->create_many( 12 );
		$widget   = new WP_Widget_bizvektor_post_list();
		$args     = array(
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		);

		$test_cases = array(
			array(
				'test_condition_name' => 'count が 0 => 10 件',
				'count'               => 0,
				'expected'            => 10,
			),
			array(
				'test_condition_name' => 'count が数字以外 => 10 件',
				'count'               => 'abc',
				'expected'            => 10,
			),
			array(
				'test_condition_name' => 'count が空 => 10 件',
				'count'               => '',
				'expected'            => 10,
			),
			array(
				'test_condition_name' => 'count が -3 => 10 件',
				'count'               => '-3',
				'expected'            => 10,
			),
			array(
				'test_condition_name' => 'count が 3 => 3 件',
				'count'               => '3',
				'expected'            => 3,
			),
			array(
				'test_condition_name' => 'count が -1 => 全件（12 件）',
				'count'               => '-1',
				'expected'            => 12,
			),
			array(
				'test_condition_name' => 'count が 5 => 5 件',
				'count'               => '5',
				'expected'            => 5,
			),
		);

		foreach ( $test_cases as $case ) {
			$html = $this->capture(
				function () use ( $widget, $args, $case ) {
					$widget->widget(
						$args,
						array(
							'count'     => $case['count'],
							'post_type' => 'post',
						)
					);
				}
			);
			$this->assertSame( $case['expected'], substr_count( $html, 'class="ttBox"' ), $case['test_condition_name'] );
		}

		foreach ( $post_ids as $post_id ) {
			wp_delete_post( $post_id, true );
		}
	}

	/**
	 * 各ウィジェットの form() で input の value がエスケープされること。
	 */
	public function test_form() {
		$attack = '"><script>alert(1)</script>';

		$test_cases = array(
			array(
				'test_condition_name' => 'アーカイブ一覧の見出し（装飾タグも文字として保持される）',
				'widget'              => new WP_Widget_archive_list(),
				'instance'            => array( 'label' => $attack . '<span class="x">A</span>' ),
				'not_contains'        => array( '<script>alert(1)</script>' ),
				'contains'            => array( 'value="&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;&lt;span class=&quot;x&quot;&gt;A&lt;/span&gt;"' ),
			),
			array(
				'test_condition_name' => 'タクソノミー一覧の見出し',
				'widget'              => new WP_Widget_taxonomy_list(),
				'instance'            => array( 'label' => $attack ),
				'not_contains'        => array( '<script>alert(1)</script>' ),
				'contains'            => array( 'value="&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;"' ),
			),
			array(
				'test_condition_name' => 'RSS の見出しと URL',
				'widget'              => new wp_widget_bizvektor_rss(),
				'instance'            => array(
					'label' => $attack,
					'url'   => 'https://example.com/"onfocus="alert(1)',
				),
				'not_contains'        => array( '<script>alert(1)</script>', 'value="https://example.com/"onfocus' ),
				'contains'            => array( 'value="&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;"', 'value="https://example.com/onfocus=alert(1)"' ),
			),
			array(
				'test_condition_name' => '投稿一覧の見出し・件数・投稿タイプ',
				'widget'              => new WP_Widget_bizvektor_post_list(),
				'instance'            => array(
					'label'     => $attack,
					'count'     => $attack,
					'post_type' => $attack,
				),
				'not_contains'        => array( '<script>alert(1)</script>' ),
				'contains'            => array( 'value="&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;"' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$html = $this->capture(
				function () use ( $case ) {
					$case['widget']->form( $case['instance'] );
				}
			);
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $html, $case['test_condition_name'] );
			}
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $html, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * タクソノミー一覧ウィジェットの form() 内 JavaScript で、ラベルが JSON 形式で書き出されること。
	 */
	public function test_form_taxonomy_script() {
		register_taxonomy( 'wtest_tax', 'post', array( 'label' => 'A"B</script>', 'show_ui' => true, 'public' => true ) );

		$widget = new WP_Widget_taxonomy_list();
		$html   = $this->capture(
			function () use ( $widget ) {
				$widget->form( array() );
			}
		);

		$this->assertStringContainsString( 'post_labels["wtest_tax"] = ' . wp_json_encode( 'A"B</script>' ) . ';', $html );
		$this->assertStringContainsString( 'post_labels["category"] = ', $html );
		$this->assertStringContainsString( 'post_labels["blog"] = ' . wp_json_encode( __( 'Blog', 'biz-vektor' ) ) . ';', $html );
		$this->assertStringNotContainsString( 'A"B</script>', $html );

		unregister_taxonomy( 'wtest_tax' );
	}

	/**
	 * 固定ページ表示ウィジェットの見出しで、タイトルの装飾が残ること。
	 */
	public function test_display_page() {
		$test_cases = array(
			array(
				'test_condition_name' => 'span を含むタイトル => 装飾が残る',
				'title'               => '<span class="x">テスト</span>',
				'expected_contains'   => '<h2><span class="x">テスト</span></h2>',
				'not_contains'        => '&lt;span',
			),
			array(
				'test_condition_name' => 'br を含むタイトル => 改行タグが残る',
				'title'               => 'A<br>B',
				'expected_contains'   => '<h2>A<br>B</h2>',
				'not_contains'        => '&lt;br',
			),
			array(
				'test_condition_name' => '装飾なしのタイトル => そのまま見出しになる',
				'title'               => 'Plain',
				'expected_contains'   => '<h2>Plain</h2>',
				'not_contains'        => '&lt;',
			),
		);

		// 管理者は unfiltered_html を持つため、タイトルの HTML がそのまま保存される。
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		$widget = new wp_widget_page();
		foreach ( $test_cases as $case ) {
			$page_id = self::factory()->post->create(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_title'   => $case['title'],
					'post_content' => 'Body',
				)
			);
			$html    = $this->capture(
				function () use ( $widget, $page_id ) {
					$widget->display_page( $page_id, true );
				}
			);
			$this->assertStringContainsString( $case['expected_contains'], $html, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $html, $case['test_condition_name'] );
		}
	}

	/**
	 * 固定ページ表示ウィジェットの form() で、選択肢のタイトルからタグが取り除かれること。
	 */
	public function test_form_page() {
		$test_cases = array(
			array(
				'test_condition_name' => 'span を含むタイトル => option 内にタグが出ない',
				'title'               => '<span class="x">テスト</span>',
				'expected_contains'   => '>テスト</option>',
				'not_contains'        => '<span class="x">',
			),
			array(
				'test_condition_name' => '通常のタイトル => そのまま表示',
				'title'               => 'Plain',
				'expected_contains'   => '>Plain</option>',
				'not_contains'        => '<span',
			),
			array(
				'test_condition_name' => 'option を閉じる文字列を含むタイトル => 抜け出さない',
				'title'               => 'D</option><img src=x onerror=1>',
				'expected_contains'   => '</option>',
				'not_contains'        => '<img src=x',
			),
		);

		// 管理者は unfiltered_html を持つため、タイトルの HTML がそのまま保存される。
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		$widget = new wp_widget_page();
		foreach ( $test_cases as $case ) {
			$page_id = self::factory()->post->create(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_title'  => $case['title'],
				)
			);
			$html    = $this->capture(
				function () use ( $widget, $page_id ) {
					$widget->form( array( 'page_id' => $page_id ) );
				}
			);
			$this->assertStringContainsString( $case['expected_contains'], $html, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $html, $case['test_condition_name'] );
			wp_delete_post( $page_id, true );
		}
	}
}
