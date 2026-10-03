<?php
/**
 * Class Post_Type_Manager_Test
 *
 * 投稿タイプ管理（Vk_post_type_manager）の保存処理のテスト。
 *
 * @package Biz Vektor
 */

/**
 * 保存時の権限確認・入力値の整形・既存設定との互換性を検証するテストクラス。
 */
class Post_Type_Manager_Test extends WP_UnitTestCase {

	/**
	 * テスト対象のインスタンス。
	 *
	 * @var Vk_post_type_manager
	 */
	private $manager;

	/**
	 * 各テスト前の準備。
	 */
	public function set_up() {
		parent::set_up();
		// フックの二重登録を避けるため、コンストラクタを呼ばずにインスタンスを作る
		$reflection    = new ReflectionClass( 'Vk_post_type_manager' );
		$this->manager = $reflection->newInstanceWithoutConstructor();
		// 管理者に投稿タイプ設定の編集権限を付与
		$this->manager->add_cap_post_type_manage();
	}

	/**
	 * 各テスト後に $_POST を戻す。
	 */
	public function tear_down() {
		$_POST = array();
		parent::tear_down();
	}

	/**
	 * 保存処理を呼ぶときの nonce 値を返す。
	 *
	 * @return string nonce.
	 */
	private function get_nonce() {
		$reflection = new ReflectionClass( 'Vk_post_type_manager' );
		return wp_create_nonce( wp_create_nonce( $reflection->getFileName() ) );
	}

	/**
	 * 投稿タイプ設定の保存で使う標準的な $_POST を返す。
	 *
	 * @return array $_POST の内容.
	 */
	private function get_post_data() {
		return array(
			'noncename__post_type_manager' => $this->get_nonce(),
			'veu_post_type_id'             => 'item',
			'veu_post_type_items'          => array( 'title' => 'true' ),
			'veu_menu_position'            => '7',
			'veu_post_type_export_to_api'  => 'true',
			'veu_taxonomy'                 => array(
				1 => array(
					'slug'  => 'item_cat',
					'label' => 'Item Category',
				),
			),
		);
	}

	/**
	 * 投稿の種類と権限によって、保存されるかどうかが変わること。
	 */
	public function test_save_cf_value() {
		$test_cases = array(
			array(
				'test_condition_name' => '投稿タイプ設定を管理者が保存 => メタが保存される',
				'post_type'           => 'post_type_manage',
				'role'                => 'administrator',
				'expected'            => 'item',
			),
			array(
				'test_condition_name' => '通常の投稿を管理者が保存 => メタが保存されない',
				'post_type'           => 'post',
				'role'                => 'administrator',
				'expected'            => '',
			),
			array(
				'test_condition_name' => '投稿タイプ設定を編集権限の無い投稿者が保存 => メタが保存されない',
				'post_type'           => 'post_type_manage',
				'role'                => 'author',
				'expected'            => '',
			),
			array(
				'test_condition_name' => '通常の投稿を投稿者が保存 => メタが保存されない',
				'post_type'           => 'post',
				'role'                => 'author',
				'expected'            => '',
			),
		);

		foreach ( $test_cases as $test_case ) {
			// 投稿作成時の save_post フックに前回の $_POST が使われないよう空にしてから、対象の投稿とログインユーザーを用意
			$_POST   = array();
			$post_id = self::factory()->post->create( array( 'post_type' => $test_case['post_type'] ) );
			wp_set_current_user( self::factory()->user->create( array( 'role' => $test_case['role'] ) ) );

			// 保存処理を実行
			$_POST = wp_slash( $this->get_post_data() );
			$this->manager->save_cf_value( $post_id );

			// 保存されたスラッグを比較
			$this->assertSame( $test_case['expected'], get_post_meta( $post_id, 'veu_post_type_id', true ), $test_case['test_condition_name'] );
		}
	}

	/**
	 * 大文字・全角英数字を含む既存設定を再保存しても、登録されるスラッグが変わらないこと。
	 */
	public function test_save_cf_value_registered_slug() {
		$test_cases = array(
			array(
				'test_condition_name' => '大文字を含む投稿タイプ・分類のスラッグ => 再保存前後で同じスラッグが登録される',
				'legacy_post_type_id' => 'MyType',
				'legacy_taxonomy'     => 'Genre_1',
				'expected_post_type'  => 'mytype',
				'expected_taxonomy'   => 'Genre_1',
			),
			array(
				'test_condition_name' => '全角英数字を含む投稿タイプのスラッグ => 再保存前後で同じスラッグが登録される',
				'legacy_post_type_id' => 'Ｍｙ_Ｔｙｐｅ１',
				'legacy_taxonomy'     => 'genre-2',
				'expected_post_type'  => 'my_type1',
				'expected_taxonomy'   => 'genre-2',
			),
			array(
				'test_condition_name' => '日本語の分類スラッグ => 再保存前後で同じ分類名が登録される',
				'legacy_post_type_id' => 'jptax',
				'legacy_taxonomy'     => 'ジャンル',
				'expected_post_type'  => 'jptax',
				'expected_taxonomy'   => 'ジャンル',
			),
			array(
				'test_condition_name' => '全角英数字の分類スラッグ => 再保存前後で同じ分類名が登録される',
				'legacy_post_type_id' => 'fwtax',
				'legacy_taxonomy'     => 'Ｇｅｎｒｅ１',
				'expected_post_type'  => 'fwtax',
				'expected_taxonomy'   => 'Ｇｅｎｒｅ１',
			),
			array(
				'test_condition_name' => '20文字を超える投稿タイプのスラッグ => 再保存前後で同じスラッグが登録される',
				'legacy_post_type_id' => 'abcdefghijklmnopqrstuvwxyz',
				'legacy_taxonomy'     => 'genre3',
				'expected_post_type'  => 'abcdefghijklmnopqrst',
				'expected_taxonomy'   => 'genre3',
			),
		);

		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );

		foreach ( $test_cases as $test_case ) {
			$legacy_taxonomy = array(
				1 => array(
					'slug'  => $test_case['legacy_taxonomy'],
					'label' => 'Genre',
				),
			);

			// 修正前の保存処理と同じく、入力値をそのままメタに保存した既存設定を作る（前回の $_POST は空にしておく）
			$_POST   = array();
			$post_id = self::factory()->post->create(
				array(
					'post_type'   => 'post_type_manage',
					'post_status' => 'publish',
				)
			);
			update_post_meta( $post_id, 'veu_post_type_id', $test_case['legacy_post_type_id'] );
			update_post_meta( $post_id, 'veu_post_type_items', array( 'title' => 'true' ) );
			update_post_meta( $post_id, 'veu_taxonomy', $legacy_taxonomy );

			// 再保存前に登録されるスラッグを確認
			$this->manager->add_post_type();
			$before_post_type = post_type_exists( $test_case['expected_post_type'] );
			$before_taxonomy  = taxonomy_exists( $test_case['expected_taxonomy'] );
			$this->unregister_managed( $test_case );

			// 管理画面のフォームから、既存の値のまま再保存する
			$_POST                     = $this->get_post_data();
			$_POST['veu_post_type_id'] = $test_case['legacy_post_type_id'];
			$_POST['veu_taxonomy']     = $legacy_taxonomy;
			$_POST                     = wp_slash( $_POST );
			$this->manager->save_cf_value( $post_id );

			// 再保存後に登録されるスラッグを確認
			$this->manager->add_post_type();
			$after_post_type = post_type_exists( $test_case['expected_post_type'] );
			$after_taxonomy  = taxonomy_exists( $test_case['expected_taxonomy'] );
			$this->unregister_managed( $test_case );

			$this->assertTrue( $before_post_type, $test_case['test_condition_name'] . '（再保存前の投稿タイプ）' );
			$this->assertTrue( $before_taxonomy, $test_case['test_condition_name'] . '（再保存前の分類）' );
			$this->assertTrue( $after_post_type, $test_case['test_condition_name'] . '（再保存後の投稿タイプ）' );
			$this->assertTrue( $after_taxonomy, $test_case['test_condition_name'] . '（再保存後の分類）' );

			// 次のケースに影響しないよう設定を削除
			wp_delete_post( $post_id, true );
		}
	}

	/**
	 * テストで登録した投稿タイプと分類の登録を解除する。
	 *
	 * @param array $test_case テストケース.
	 */
	private function unregister_managed( $test_case ) {
		if ( taxonomy_exists( $test_case['expected_taxonomy'] ) ) {
			unregister_taxonomy( $test_case['expected_taxonomy'] );
		}
		if ( post_type_exists( $test_case['expected_post_type'] ) ) {
			unregister_post_type( $test_case['expected_post_type'] );
		}
	}

	/**
	 * 入力値がフィールドごとに整形されること。
	 */
	public function test_sanitize_field_value() {
		$test_cases = array(
			array(
				'test_condition_name' => '投稿タイプのスラッグに HTML・記号 => 取り除かれる',
				'field'               => 'veu_post_type_id',
				'value'               => '<script>alert(1)</script>item"\'',
				'expected'            => 'scriptalert1sc',
			),
			array(
				'test_condition_name' => '投稿タイプのスラッグが正常な値 => そのまま',
				'field'               => 'veu_post_type_id',
				'value'               => 'news_item-2',
				'expected'            => 'news_item-2',
			),
			array(
				'test_condition_name' => '投稿タイプのスラッグが配列 => 空文字',
				'field'               => 'veu_post_type_id',
				'value'               => array( 'item' ),
				'expected'            => '',
			),
			array(
				'test_condition_name' => '表示項目に許可外のキーと値 => 許可されたキーだけ true で残る',
				'field'               => 'veu_post_type_items',
				'value'               => array(
					'title'   => 'true',
					'editor'  => 'yes',
					'unknown' => 'true',
					'author'  => '',
				),
				'expected'            => array(
					'title'  => 'true',
					'editor' => 'true',
				),
			),
			array(
				'test_condition_name' => '表示項目が文字列 => 空文字',
				'field'               => 'veu_post_type_items',
				'value'               => 'title',
				'expected'            => '',
			),
			array(
				'test_condition_name' => 'メニュー位置が全角数字 => 半角数字になる',
				'field'               => 'veu_menu_position',
				'value'               => '１２',
				'expected'            => '12',
			),
			array(
				'test_condition_name' => 'メニュー位置が数値でない => 空文字',
				'field'               => 'veu_menu_position',
				'value'               => '<b>abc</b>',
				'expected'            => '',
			),
			array(
				'test_condition_name' => 'REST API 出力にチェックあり => true',
				'field'               => 'veu_post_type_export_to_api',
				'value'               => 'anything',
				'expected'            => 'true',
			),
			array(
				'test_condition_name' => 'REST API 出力が空 => 空文字',
				'field'               => 'veu_post_type_export_to_api',
				'value'               => '',
				'expected'            => '',
			),
			array(
				'test_condition_name' => 'カスタム分類のスラッグ・ラベルに HTML => スラッグは英数字等のみ・ラベルはタグ除去',
				'field'               => 'veu_taxonomy',
				'value'               => array(
					1 => array(
						'slug'     => 'Genre"><script>',
						'label'    => '<span class="x">施工種別</span><script>alert(1)</script>',
						'tag'      => 'on',
						'rest_api' => '',
					),
					4 => array(
						'slug'  => 'over',
						'label' => 'over',
					),
				),
				'expected'            => array(
					1 => array(
						'slug'  => 'Genrescript',
						'label' => '施工種別',
						'tag'   => 'true',
					),
				),
			),
			array(
				'test_condition_name' => 'カスタム分類のスラッグに日本語・空白・記号 => 文字と数字だけ残る',
				'field'               => 'veu_taxonomy',
				'value'               => array(
					1 => array(
						'slug'  => 'ジャンル 1_a-b<>"',
						'label' => 'a',
					),
				),
				'expected'            => array(
					1 => array(
						'slug'  => 'ジャンル1_a-b',
						'label' => 'a',
					),
				),
			),
			array(
				'test_condition_name' => 'カスタム分類が配列でない => 空文字',
				'field'               => 'veu_taxonomy',
				'value'               => 'abc',
				'expected'            => '',
			),
		);

		foreach ( $test_cases as $test_case ) {
			$actual = Vk_post_type_manager::sanitize_field_value( $test_case['field'], $test_case['value'] );
			$this->assertSame( $test_case['expected'], $actual, $test_case['test_condition_name'] );
		}
	}

	/**
	 * 分類ラベルが、保存後も文字のまま残り、登録時にはタグだけが取り除かれること。
	 */
	public function test_taxonomy_label_registered() {
		$test_cases = array(
			array(
				'test_condition_name' => '& を含むラベルを保存 => 実体参照にならず Q&A のまま登録される',
				'saved_by_form'       => true,
				'label'               => 'Q&A',
				'expected_meta'       => 'Q&A',
				'expected_label'      => 'Q&A',
			),
			array(
				'test_condition_name' => "' を含むラベルを保存 => 実体参照にならず Men's のまま登録される",
				'saved_by_form'       => true,
				'label'               => "Men's",
				'expected_meta'       => "Men's",
				'expected_label'      => "Men's",
			),
			array(
				'test_condition_name' => 'バックスラッシュを含むラベルを保存 => 保存後も残る',
				'saved_by_form'       => true,
				'label'               => 'A\\B',
				'expected_meta'       => 'A\\B',
				'expected_label'      => 'A\\B',
			),
			array(
				'test_condition_name' => 'タグ入りの既存ラベル（整形を通さず保存済み） => 登録時にタグが取り除かれる',
				'saved_by_form'       => false,
				'label'               => 'Genre<script>alert(1)</script><b>X</b>',
				'expected_meta'       => 'Genre<script>alert(1)</script><b>X</b>',
				'expected_label'      => 'GenreX',
			),
		);

		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );

		foreach ( $test_cases as $test_case ) {
			$_POST   = array();
			$post_id = self::factory()->post->create(
				array(
					'post_type'   => 'post_type_manage',
					'post_status' => 'publish',
				)
			);

			$taxonomy = array(
				1 => array(
					'slug'  => 'label_cat',
					'label' => $test_case['label'],
				),
			);

			if ( $test_case['saved_by_form'] ) {
				$_POST                     = $this->get_post_data();
				$_POST['veu_post_type_id'] = 'labeltype';
				$_POST['veu_taxonomy']     = $taxonomy;
				$_POST                     = wp_slash( $_POST );
				$this->manager->save_cf_value( $post_id );
			} else {
				update_post_meta( $post_id, 'veu_post_type_id', 'labeltype' );
				update_post_meta( $post_id, 'veu_post_type_items', array( 'title' => 'true' ) );
				update_post_meta( $post_id, 'veu_taxonomy', wp_slash( $taxonomy ) );
			}

			$saved = get_post_meta( $post_id, 'veu_taxonomy', true );
			$this->assertSame( $test_case['expected_meta'], $saved[1]['label'], $test_case['test_condition_name'] . '（保存値）' );

			$this->manager->add_post_type();
			$registered = get_taxonomy( 'label_cat' );
			$this->assertNotFalse( $registered, $test_case['test_condition_name'] . '（登録）' );
			$this->assertSame( $test_case['expected_label'], $registered->labels->name, $test_case['test_condition_name'] . '（登録後のラベル）' );
			$this->assertSame( $test_case['expected_label'], $registered->label, $test_case['test_condition_name'] . '（登録後の label）' );

			unregister_taxonomy( 'label_cat' );
			unregister_post_type( 'labeltype' );
			wp_delete_post( $post_id, true );
		}
	}
}
