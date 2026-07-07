<?php
/**
 * Class Dashboard_Info_Widget_Test
 *
 * plugins/dashboard_info_widget/dashboard-info-widget.php が
 * vendor（Composer autoload）の有無にかかわらず Fatal Error を出さずに
 * 読み込めることを検証するテスト。
 *
 * issue #346: vendor ディレクトリ無しでテーマが誤配信されると、
 * 未定義の VektorInc\VK_Admin\VkAdmin を呼び出して Fatal Error になる不具合の回帰防止。
 *
 * @package Biz Vektor
 */

/**
 * dashboard-info-widget.php の読み込みガードを検証するテストクラス。
 */
class Dashboard_Info_Widget_Test extends WP_UnitTestCase {

	/**
	 * dashboard-info-widget.php を autoload を読み込まないサブプロセスで include し、
	 * VkAdmin クラスの定義有無に応じて Fatal を出さず正常終了することを検証する。
	 *
	 * PHP は一度定義したクラスを未定義状態へ戻せないため、
	 * 本テストの PHPUnit プロセス（bootstrap で vendor/autoload.php を読み込み済み）とは分離した
	 * まっさらなサブプロセスで対象ファイルを include し、issue #346 の状況を忠実に再現する。
	 */
	public function test_dashboard_info_widget() {

		// 本テストはサブプロセス実行（exec）に依存するため、exec が
		// disable_functions で無効化された環境ではスキップする.
		if ( ! function_exists( 'exec' ) ) {
			$this->markTestSkipped( 'exec が無効なため本テストをスキップします' );
		}

		// テスト対象ファイル（tests ディレクトリの1つ上がテーマルート）.
		$target = dirname( __DIR__ ) . '/plugins/dashboard_info_widget/dashboard-info-widget.php';
		$this->assertFileExists( $target, 'テスト対象の dashboard-info-widget.php が存在すること' );

		// テストの配列.
		// define_class       : サブプロセス内で VkAdmin クラスをスタブ定義するか（true=vendor 配信済み相当）.
		// include_count      : 対象ファイルを include する回数.
		// expected_init_count: VkAdmin::init() が呼ばれるべき回数（クラス未定義ならガードでスキップされ 0）.
		$test_cases = array(
			array(
				'test_condition_name' => 'vendor 配信済み（VkAdmin 定義あり）で1回 include => init が実行され Fatal を出さず正常終了',
				'define_class'        => true,
				'include_count'       => 1,
				'expected_init_count' => 1,
			),
			array(
				'test_condition_name' => 'vendor 配信済み（VkAdmin 定義あり）で2回 include => init が都度実行され Fatal を出さず正常終了',
				'define_class'        => true,
				'include_count'       => 2,
				'expected_init_count' => 2,
			),
			array(
				'test_condition_name' => 'vendor 未配信（VkAdmin 未定義）で include => Fatal を出さず init はスキップされ正常終了（issue #346 回帰防止）',
				'define_class'        => false,
				'include_count'       => 1,
				'expected_init_count' => 0,
			),
			array(
				'test_condition_name' => 'vendor 未配信（VkAdmin 未定義）で2回 include => Fatal を出さず正常終了（境界値）',
				'define_class'        => false,
				'include_count'       => 2,
				'expected_init_count' => 0,
			),
		);

		foreach ( $test_cases as $case ) {

			// サブプロセスで実行する PHP スクリプトを組み立てる.
			// スタブクラスを正しい名前空間へ定義するためブロック形式の namespace 構文を用いる.
			// （ブロック形式を使う場合、namespace 宣言より前にコードを置けないため error_reporting は
			//   グローバル名前空間ブロックの中に記述する）.
			$runner = "<?php\n";

			if ( $case['define_class'] ) {
				// vendor 配信済み相当: VkAdmin クラスをスタブ定義し、init 実行時にマーカーを出力する.
				$runner .= "namespace VektorInc\\VK_Admin { class VkAdmin { public static function init() { echo 'INIT'; } } }\n";
			}

			// グローバル名前空間で対象ファイルを指定回数 include し、最後に OK を出力する.
			$runner .= "namespace {\n";
			// 全てのエラーを出力対象にして Fatal を確実に検知できるようにする.
			$runner .= "\terror_reporting(E_ALL);\n";
			for ( $i = 0; $i < $case['include_count']; $i++ ) {
				$runner .= "\tinclude " . var_export( $target, true ) . ";\n";
			}
			$runner .= "\techo 'OK';\n";
			$runner .= "}\n";

			// 一時ファイルへ書き出す（このプロセスと同じコンテナ内に生成される）.
			$tmp = tempnam( sys_get_temp_dir(), 'diw' );
			file_put_contents( $tmp, $runner );

			// autoload を一切読み込まないサブプロセスで実行する.
			$cmd       = escapeshellarg( PHP_BINARY ) . ' ' . escapeshellarg( $tmp ) . ' 2>&1';
			$output    = array();
			$exit_code = null;
			exec( $cmd, $output, $exit_code );
			$output_str = implode( "\n", $output );

			// 一時ファイルを削除する.
			unlink( $tmp );

			// Fatal Error が出ず正常終了していること.
			$this->assertSame( 0, $exit_code, $case['test_condition_name'] . ' (終了コード / 出力: ' . $output_str . ')' );

			// include が最後まで到達し OK が出力されていること.
			$this->assertStringContainsString( 'OK', $output_str, $case['test_condition_name'] . ' (OK 出力 / 出力: ' . $output_str . ')' );

			// VkAdmin::init() が期待回数だけ呼ばれていること（未定義時はガードでスキップされ 0 回）.
			$this->assertSame( $case['expected_init_count'], substr_count( $output_str, 'INIT' ), $case['test_condition_name'] . ' (init 実行回数)' );
		}
	}
}
