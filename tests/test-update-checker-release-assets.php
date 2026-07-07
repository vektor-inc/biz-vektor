<?php
/**
 * Class Update_Checker_Release_Assets_Test
 *
 * functions.php で設定される自動更新チェッカー（Plugin Update Checker, PUC）が
 * GitHub リリースの「添付アセット」を更新ファイルとして使う設定になっていることを検証するテスト。
 *
 * issue #349: enableReleaseAssets() を呼んでいないと PUC は GitHub 自動生成の
 * ソース zip（zipball_url）を配信する。この zip には vendor ディレクトリが含まれないため、
 * 更新後のサイトで Composer autoload が読み込めず VkAdmin が動作しなくなる不具合の回帰防止。
 *
 * @package Biz Vektor
 */

/**
 * PUC のリリースアセット設定を検証するテストクラス。
 */
class Update_Checker_Release_Assets_Test extends WP_UnitTestCase {

	/**
	 * functions.php の enableReleaseAssets() 設定を検証する。
	 *
	 * - リリースアセットが有効化されていること（releaseAssetsEnabled = true）。
	 * - アセット名フィルタ（assetFilterRegex）が release.yml の添付アセット名 biz-vektor.zip に
	 *   マッチし、無関係なアセット名にはマッチしないこと。
	 *
	 * releaseAssetsEnabled / assetFilterRegex は protected プロパティ、
	 * matchesAssetFilter() は protected メソッドのため Reflection で参照・実行する。
	 */
	public function test_enableReleaseAssets() {

		// functions.php のロード時に設定されるグローバルの更新チェッカーを取得する.
		global $myUpdateChecker;
		$this->assertNotEmpty( $myUpdateChecker, 'functions.php で $myUpdateChecker が設定されていること' );

		// 更新チェッカーから GitHub API インスタンスを取得する.
		$api = $myUpdateChecker->getVcsApi();
		$this->assertInstanceOf( 'Puc_v4p4_Vcs_GitHubApi', $api, '更新チェッカーが GitHub API を使用していること' );

		// protected プロパティ・メソッドへアクセスするための Reflection を用意する.
		$reflection = new ReflectionObject( $api );

		$enabled_prop = $reflection->getProperty( 'releaseAssetsEnabled' );
		$enabled_prop->setAccessible( true );

		$matches_method = $reflection->getMethod( 'matchesAssetFilter' );
		$matches_method->setAccessible( true );

		// リリースアセットが有効化されていること.
		// 未呼び出しだと zipball_url（vendor 無しのソース zip）が配信され、更新後に Fatal Error になる（issue #349）.
		$this->assertTrue(
			$enabled_prop->getValue( $api ),
			'enableReleaseAssets() によりリリースアセットが有効化されていること（無効だと vendor 無しのソース zip が配信される）'
		);

		// テストの配列.
		// asset_name : GitHub リリースに添付されたアセットのファイル名.
		// expected   : そのアセット名がフィルタにマッチするか（true = 更新に使われる）.
		$test_cases = array(
			array(
				'test_condition_name' => 'release.yml が添付する biz-vektor.zip => マッチ（vendor 同梱アセットが更新に使われる）',
				'asset_name'          => 'biz-vektor.zip',
				'expected'            => true,
			),
			array(
				'test_condition_name' => '先頭アンカーにより末尾一致の任意名アセット（theme-biz-vektor.zip）=> マッチしない',
				'asset_name'          => 'theme-biz-vektor.zip',
				'expected'            => false,
			),
			array(
				'test_condition_name' => 'GitHub 自動生成のソース zip 名（biz-vektor-1.13.2.zip）=> マッチしない（vendor 無し zip を除外）',
				'asset_name'          => 'biz-vektor-1.13.2.zip',
				'expected'            => false,
			),
			array(
				'test_condition_name' => '無関係なアセット名（other.zip）=> マッチしない',
				'asset_name'          => 'other.zip',
				'expected'            => false,
			),
			array(
				'test_condition_name' => '拡張子が異なる同名ファイル（biz-vektor.zip.bak）=> マッチしない（境界値）',
				'asset_name'          => 'biz-vektor.zip.bak',
				'expected'            => false,
			),
		);

		foreach ( $test_cases as $case ) {
			// PUC がアセット名フィルタに使う stdClass（name プロパティを持つ）を組み立てる.
			$asset       = new stdClass();
			$asset->name = $case['asset_name'];

			// PUC 本体の matchesAssetFilter() で実際の判定挙動を検証する.
			$actual = (bool) $matches_method->invoke( $api, $asset );

			$this->assertSame( $case['expected'], $actual, $case['test_condition_name'] );
		}
	}
}
