<?php
/**
 * Class Theme_Options_Escape_Test
 *
 * テーマオプション・カスタマイザの値の保存時の整形と、出力時のエスケープのテスト。
 *
 * @package Biz Vektor
 */

/**
 * 保存側（validate / sanitize_callback）と出力側（各出力関数・テンプレート）を検証するテストクラス。
 */
class Theme_Options_Escape_Test extends WP_UnitTestCase {

	/**
	 * 各テスト後に保存オプションと $_POST を元に戻す。
	 */
	public function tear_down() {
		$_POST = array();
		unset( $_SERVER['HTTP_USER_AGENT'] );
		delete_option( 'biz_vektor_theme_options' );
		parent::tear_down();
	}

	/**
	 * 既定値に上書きした値を保存オプションとして登録する。
	 *
	 * @param array $overrides 上書きするオプション.
	 */
	private function set_options( $overrides ) {
		update_option( 'biz_vektor_theme_options', array_merge( biz_vektor_generate_default_options(), $overrides ) );
	}

	/**
	 * wp_is_mobile() の判定結果を切り替える。
	 *
	 * @param bool $is_mobile モバイル端末として扱うか.
	 */
	private function set_mobile( $is_mobile ) {
		$_SERVER['HTTP_USER_AGENT'] = $is_mobile ? 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) Mobile/15E148' : 'Mozilla/5.0 (Macintosh)';
	}

	/**
	 * 出力を文字列として取得する。
	 *
	 * @param callable $callback 出力する関数.
	 * @return string 出力された HTML.
	 */
	private function capture( $callback ) {
		ob_start();
		call_user_func( $callback );
		return ob_get_clean();
	}

	/**
	 * 保存時に URL が整えられ、装飾用の HTML が残ること。
	 */
	public function test_biz_vektor_theme_options_validate() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な URL と装飾 HTML の場合 => そのまま保存される',
				'input'               => array(
					'head_logo'         => 'https://example.com/logo.png',
					'foot_logo'         => 'https://example.com/foot.png',
					'favicon'           => 'https://example.com/favicon.ico',
					'contact_txt'       => 'お問い合わせ<br><span class="x">平日</span>',
					'tel_number'        => '03-1234-5678',
					'contact_time'      => '9:00<br>18:00',
					'sub_sitename'      => 'Sub<br>Name',
					'contact_link'      => 'https://example.com/contact/',
					'slide1link'        => 'https://example.com/a/',
					'slide1image'       => 'https://example.com/a.jpg',
					'pr1_image'         => 'https://example.com/pr.jpg',
					'pr1_image_s'       => 'https://example.com/pr_s.jpg',
				),
				'expected'            => array(
					'head_logo'    => 'https://example.com/logo.png',
					'foot_logo'    => 'https://example.com/foot.png',
					'favicon'      => 'https://example.com/favicon.ico',
					'contact_txt'  => 'お問い合わせ<br><span class="x">平日</span>',
					'tel_number'   => '03-1234-5678',
					'contact_time' => '9:00<br>18:00',
					'sub_sitename' => 'Sub<br>Name',
					'contact_link' => 'https://example.com/contact/',
					'slide1link'   => 'https://example.com/a/',
					'slide1image'  => 'https://example.com/a.jpg',
					'pr1_image'    => 'https://example.com/pr.jpg',
					'pr1_image_s'  => 'https://example.com/pr_s.jpg',
				),
			),
			array(
				'test_condition_name' => 'javascript: の URL と script・イベント属性を含む文字の場合 => 取り除かれる',
				'input'               => array(
					'head_logo'    => 'javascript:alert(1)',
					'foot_logo'    => 'javascript:alert(1)',
					'favicon'      => 'javascript:alert(1)//x.ico',
					'contact_txt'  => 'A<script>alert(1)</script><b onclick="x()">B</b>',
					'tel_number'   => '03<script>alert(1)</script>',
					'contact_time' => '9:00<img src=x onerror=alert(1)>',
					'sub_sitename' => 'S<script>alert(1)</script>',
					'contact_link' => 'javascript:alert(1)',
					'slide1link'   => 'javascript:alert(1)',
					'slide1image'  => 'javascript:alert(1)',
					'pr1_image'    => 'javascript:alert(1)',
					'pr1_image_s'  => 'javascript:alert(1)',
				),
				'expected'            => array(
					'head_logo'    => '',
					'foot_logo'    => '',
					'favicon'      => '',
					'contact_txt'  => 'Aalert(1)<b>B</b>',
					'tel_number'   => '03alert(1)',
					'contact_time' => '9:00<img src="x">',
					'sub_sitename' => 'Salert(1)',
					'contact_link' => '',
					'slide1link'   => '',
					'slide1image'  => '',
					'pr1_image'    => '',
					'pr1_image_s'  => '',
				),
			),
			array(
				'test_condition_name' => '空の場合 => 空のまま保存される',
				'input'               => array(
					'head_logo'    => '',
					'contact_txt'  => '',
					'contact_link' => '',
					'slide1image'  => '',
				),
				'expected'            => array(
					'head_logo'    => '',
					'contact_txt'  => '',
					'contact_link' => '',
					'slide1image'  => '',
				),
			),
		);

		foreach ( $test_cases as $case ) {
			$input  = array_merge( biz_vektor_generate_default_options(), $case['input'] );
			$output = biz_vektor_theme_options_validate( $input );
			foreach ( $case['expected'] as $key => $expected ) {
				$this->assertSame( $expected, $output[ $key ], $case['test_condition_name'] . ' [' . $key . ']' );
			}
		}
	}

	/**
	 * カスタマイザの URL 項目の保存前処理。
	 */
	public function test_biz_vektor_sanitize_customizer_url() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常の URL の場合 => そのまま',
				'value'               => 'https://example.com/a.png',
				'expected'            => 'https://example.com/a.png',
			),
			array(
				'test_condition_name' => '空文字の場合 => 空文字',
				'value'               => '',
				'expected'            => '',
			),
			array(
				'test_condition_name' => 'javascript: の場合 => 空文字',
				'value'               => 'javascript:alert(1)',
				'expected'            => '',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->assertSame( $case['expected'], biz_vektor_sanitize_customizer_url( $case['value'] ), $case['test_condition_name'] );
		}
	}

	/**
	 * カスタマイザの文字項目の保存前処理。
	 */
	public function test_biz_vektor_sanitize_customizer_html() {
		$test_cases = array(
			array(
				'test_condition_name' => '装飾 HTML の場合 => 残る',
				'value'               => 'A<br><span class="x">B</span>',
				'expected'            => 'A<br><span class="x">B</span>',
			),
			array(
				'test_condition_name' => 'プレーンテキストの場合 => そのまま',
				'value'               => '03-1234-5678',
				'expected'            => '03-1234-5678',
			),
			array(
				'test_condition_name' => 'script とイベント属性の場合 => 取り除かれる',
				'value'               => 'A<script>alert(1)</script><b onclick="x()">B</b>',
				'expected'            => 'Aalert(1)<b>B</b>',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->assertSame( $case['expected'], biz_vektor_sanitize_customizer_html( $case['value'] ), $case['test_condition_name'] );
		}
	}

	/**
	 * カスタマイザの対象設定に sanitize_callback が効いていること。
	 */
	public function test_bizvektor_customize_register() {
		require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
		$wp_customize = new WP_Customize_Manager();
		// テーマ側の読み込み時にコントロールクラスが無かった場合に備える
		if ( ! class_exists( 'customize_Textarea_Control' ) ) {
			class_alias( 'WP_Customize_Control', 'customize_Textarea_Control' );
		}
		bizvektor_customize_register( $wp_customize );

		$test_cases = array(
			array(
				'test_condition_name' => 'head_logo に javascript: の場合 => 空文字',
				'id'                  => 'head_logo',
				'value'               => 'javascript:alert(1)',
				'expected'            => '',
			),
			array(
				'test_condition_name' => 'contact_link に正常な URL の場合 => そのまま',
				'id'                  => 'contact_link',
				'value'               => 'https://example.com/contact/',
				'expected'            => 'https://example.com/contact/',
			),
			array(
				'test_condition_name' => 'pr1_image に javascript: の場合 => 空文字',
				'id'                  => 'pr1_image',
				'value'               => 'javascript:alert(1)',
				'expected'            => '',
			),
			array(
				'test_condition_name' => 'contact_txt に script と装飾の場合 => 装飾だけ残る',
				'id'                  => 'contact_txt',
				'value'               => 'A<br><script>alert(1)</script><span class="x">B</span>',
				'expected'            => 'A<br>alert(1)<span class="x">B</span>',
			),
			array(
				'test_condition_name' => 'pr1_title に装飾の場合 => 残る',
				'id'                  => 'pr1_title',
				'value'               => 'T<br>1',
				'expected'            => 'T<br>1',
			),
		);

		foreach ( $test_cases as $case ) {
			$setting = $wp_customize->get_setting( 'biz_vektor_theme_options[' . $case['id'] . ']' );
			$this->assertNotNull( $setting, $case['test_condition_name'] );
			$this->assertSame( $case['expected'], $setting->sanitize( $case['value'] ), $case['test_condition_name'] );
		}
	}

	/**
	 * favicon / ヘッダーロゴの出力で URL がエスケープされること。
	 */
	public function test_biz_vektor_favicon() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な URL の場合 => そのまま出力',
				'favicon'             => 'https://example.com/favicon.ico',
				'expected'            => '<link rel="SHORTCUT ICON" HREF="https://example.com/favicon.ico" />',
			),
			array(
				'test_condition_name' => '属性を閉じる文字を含む場合 => 属性の外に出ない',
				'favicon'             => 'https://example.com/a.ico" onload="alert(1)',
				'expected'            => '<link rel="SHORTCUT ICON" HREF="https://example.com/a.ico%20onload=alert(1)" />',
			),
			array(
				'test_condition_name' => 'javascript: の場合 => URL が出力されない',
				'favicon'             => 'javascript:alert(1)',
				'expected'            => '<link rel="SHORTCUT ICON" HREF="" />',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( array( 'favicon' => $case['favicon'] ) );
			$this->assertSame( $case['expected'], $this->capture( 'biz_vektor_favicon' ), $case['test_condition_name'] );
		}
	}

	/**
	 * ヘッダーロゴの src がエスケープされること。
	 */
	public function test_biz_vektor_print_headLogo() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な URL の場合 => そのまま出力',
				'head_logo'           => 'https://example.com/logo.png',
				'contains'            => 'src="https://example.com/logo.png"',
				'not_contains'        => 'javascript:',
			),
			array(
				'test_condition_name' => '属性を閉じる文字を含む場合 => 属性の外に出ない',
				'head_logo'           => 'https://example.com/a.png"><script>alert(1)</script>',
				'contains'            => 'src="https://example.com/a.png',
				'not_contains'        => '<script>',
			),
			array(
				'test_condition_name' => 'javascript: の場合 => URL が出力されない',
				'head_logo'           => 'javascript:alert(1)',
				'contains'            => 'src=""',
				'not_contains'        => 'javascript:',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( array( 'head_logo' => $case['head_logo'] ) );
			$actual = $this->capture( 'biz_vektor_print_headLogo' );
			$this->assertStringContainsString( $case['contains'], $actual, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $actual, $case['test_condition_name'] );
		}
	}

	/**
	 * ヘッダーの連絡先で、装飾 HTML が残り、script・イベント属性が除かれること。
	 */
	public function test_biz_vektor_print_headContact() {
		$test_cases = array(
			array(
				'test_condition_name' => '装飾 HTML の場合 => <br> と <span class> が残る',
				'options'             => array(
					'contact_txt'  => 'お問い合わせ<br><span class="x">平日</span>',
					'tel_number'   => '03-1234-5678',
					'contact_time' => '9:00<br>18:00',
				),
				'contains'            => array(
					'<div id="headContactTxt">お問い合わせ<br><span class="x">平日</span></div>',
					'TEL 03-1234-5678',
					'<div id="headContactTime">9:00<br>18:00</div>',
				),
				'not_contains'        => array( '&lt;br' ),
			),
			array(
				'test_condition_name' => 'script・イベント属性の場合 => 取り除かれる',
				'options'             => array(
					'contact_txt'  => 'A<script>alert(1)</script><b onclick="x()">B</b>',
					'tel_number'   => '03<img src=x onerror=alert(1)>',
					'contact_time' => '9<script>alert(2)</script>',
				),
				'mobile'              => true,
				'contains'            => array( '<b>B</b>', 'href="tel:03"' ),
				'not_contains'        => array( '<script', 'onclick="x()"', 'onerror' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( $case['options'] );
			// デザインスキンが連絡先エリアを差し替えるフィルターを外す
			remove_all_filters( 'headContactCustom' );
			$this->set_mobile( ! empty( $case['mobile'] ) );
			$actual = $this->capture( 'biz_vektor_print_headContact' );
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $actual, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $actual, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * メインフッターの連絡先で、装飾 HTML が残り、tel の href が属性から出ないこと。
	 */
	public function test_biz_vektor_mainfootContact() {
		$test_cases = array(
			array(
				'test_condition_name' => '装飾 HTML の場合 => <br> と <span class> が残る',
				'options'             => array(
					'contact_txt'  => 'お問い合わせ<br><span class="x">平日</span>',
					'tel_number'   => '03-1234-5678',
					'contact_time' => '9:00<br>18:00',
				),
				'contains'            => array(
					'<span class="mainFootCatch">お問い合わせ<br><span class="x">平日</span></span>',
					'TEL 03-1234-5678',
					'<span class="mainFootTime">9:00<br>18:00</span>',
				),
				'not_contains'        => array( '&lt;br' ),
			),
			array(
				'test_condition_name' => 'script・イベント属性・属性を閉じる文字の場合 => 取り除かれる',
				'options'             => array(
					'contact_txt'  => 'A<script>alert(1)</script><b onclick="x()">B</b>',
					'tel_number'   => '03" onmouseover="alert(1)',
					'contact_time' => '9<script>alert(2)</script>',
				),
				'mobile'              => true,
				'contains'            => array( '<b>B</b>', 'href="tel:03&quot; onmouseover=&quot;alert(1)"' ),
				'not_contains'        => array( '<script', 'onclick', 'tel:03" onmouseover=' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( $case['options'] );
			$this->set_mobile( ! empty( $case['mobile'] ) );
			$actual = $this->capture( 'biz_vektor_mainfootContact' );
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $actual, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $actual, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * フッターのコピーライトで、サブサイト名の装飾 HTML が残り、script とイベント属性が出ないこと。
	 */
	public function test_biz_vektor_footerCopyRight() {
		$test_cases = array(
			array(
				'test_condition_name' => '装飾 HTML の場合 => <br> と <span class> が残る',
				'sub_sitename'        => 'Sub<br><span class="x">Name</span>',
				'contains'            => array( 'Sub<br><span class="x">Name</span>' ),
				'not_contains'        => array( '&lt;br' ),
			),
			array(
				'test_condition_name' => 'script とイベント属性の場合 => 取り除かれる',
				'sub_sitename'        => 'S<script>alert(1)</script><b onclick="x()">B</b>',
				'contains'            => array( '<b>B</b>' ),
				'not_contains'        => array( '<script', 'onclick' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( array( 'sub_sitename' => $case['sub_sitename'] ) );
			$actual = $this->capture( 'biz_vektor_footerCopyRight' );
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $actual, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $actual, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * フッターのサイト名・ロゴで、装飾 HTML が残り、属性値とURLがエスケープされること。
	 */
	public function test_biz_vektor_footerSiteName() {
		$test_cases = array(
			array(
				'test_condition_name' => 'ロゴなしで装飾 HTML の場合 => <br> と <span class> が残る',
				'options'             => array(
					'sub_sitename' => 'Sub<br><span class="x">Name</span>',
					'foot_logo'    => '',
				),
				'contains'            => array( 'Sub<br><span class="x">Name</span>' ),
				'not_contains'        => array( '&lt;br' ),
			),
			array(
				'test_condition_name' => 'ロゴなしで script の場合 => 取り除かれる',
				'options'             => array(
					'sub_sitename' => 'S<script>alert(1)</script><b onclick="x()">B</b>',
					'foot_logo'    => '',
				),
				'contains'            => array( '<b>B</b>' ),
				'not_contains'        => array( '<script', 'onclick' ),
			),
			array(
				'test_condition_name' => 'ロゴありで属性を閉じる文字の場合 => alt と src の外に出ない',
				'options'             => array(
					'sub_sitename' => 'S"><script>alert(1)</script>',
					'foot_logo'    => 'https://example.com/f.png"><script>alert(2)</script>',
				),
				'contains'            => array( '<img src="https://example.com/f.png' ),
				'not_contains'        => array( '<script' ),
			),
			array(
				'test_condition_name' => 'ロゴありで javascript: の場合 => URL が出力されない',
				'options'             => array(
					'sub_sitename' => 'Site',
					'foot_logo'    => 'javascript:alert(1)',
				),
				'contains'            => array( 'src=""' ),
				'not_contains'        => array( 'javascript:' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( $case['options'] );
			$actual = $this->capture( 'biz_vektor_footerSiteName' );
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $actual, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $actual, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * スライドの画像・リンク・alt がエスケープされること。
	 */
	public function test_get_biz_vektor_slide_body() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な値の場合 => そのまま出力',
				'options'             => array(
					'slide1image' => 'https://example.com/a.jpg',
					'slide1link'  => 'https://example.com/a/',
					'slide1alt'   => 'Alt text',
				),
				'contains'            => array(
					'<a href="https://example.com/a/" class="slideFrame">',
					'<img src="https://example.com/a.jpg" alt="Alt text" />',
				),
				'not_contains'        => array(),
			),
			array(
				'test_condition_name' => 'alt に属性を閉じる文字とタグの場合 => alt の外に出ない',
				'options'             => array(
					'slide1image' => 'https://example.com/a.jpg',
					'slide1link'  => '',
					'slide1alt'   => 'x" onerror="alert(1)"><script>alert(2)</script>',
				),
				'contains'            => array( 'alt="x&quot; onerror=&quot;alert(1)&quot;&gt;"' ),
				'not_contains'        => array( '<script', '" onerror=' ),
			),
			array(
				'test_condition_name' => 'image と link が javascript: の場合 => URL が出力されない',
				'options'             => array(
					'slide1image' => 'javascript:alert(1)',
					'slide1link'  => 'javascript:alert(2)',
					'slide1alt'   => '',
				),
				'contains'            => array(),
				'not_contains'        => array( 'javascript:' ),
			),
			array(
				'test_condition_name' => 'image と link に属性を閉じる文字の場合 => 属性の外に出ない',
				'options'             => array(
					'slide1image' => 'https://example.com/a.jpg" onerror="alert(1)',
					'slide1link'  => 'https://example.com/a/" onclick="alert(2)',
					'slide1alt'   => '',
				),
				'contains'            => array(),
				'not_contains'        => array( '" onerror=', '" onclick=' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( $case['options'] );
			$actual = get_biz_vektor_slide_body();
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $actual, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $actual, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * サイドバーの問い合わせボタンの href がエスケープされること。
	 */
	public function test_get_biz_vektor_contactBtn() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な URL の場合 => そのまま出力',
				'contact_link'        => 'https://example.com/contact/',
				'contains'            => 'href="https://example.com/contact/"',
				'not_contains'        => 'javascript:',
			),
			array(
				'test_condition_name' => '属性を閉じる文字の場合 => 属性の外に出ない',
				'contact_link'        => 'https://example.com/c/" onclick="alert(1)',
				'contains'            => 'href="https://example.com/c/',
				'not_contains'        => '" onclick=',
			),
			array(
				'test_condition_name' => 'javascript: の場合 => URL が出力されない',
				'contact_link'        => 'javascript:alert(1)',
				'contains'            => 'href=""',
				'not_contains'        => 'javascript:',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( array( 'contact_link' => $case['contact_link'] ) );
			$actual = get_biz_vektor_contactBtn();
			$this->assertStringContainsString( $case['contains'], $actual, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $actual, $case['test_condition_name'] );
		}
	}

	/**
	 * module_mainfoot.php の問い合わせボタンの href がエスケープされること。
	 */
	public function test_module_mainfoot() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な URL の場合 => そのまま出力',
				'contact_link'        => 'https://example.com/contact/',
				'contains'            => 'href="https://example.com/contact/"',
				'not_contains'        => 'javascript:',
			),
			array(
				'test_condition_name' => '属性を閉じる文字の場合 => 属性の外に出ない',
				'contact_link'        => 'https://example.com/c/" onclick="alert(1)',
				'contains'            => 'href="https://example.com/c/',
				'not_contains'        => '" onclick=',
			),
			array(
				'test_condition_name' => 'javascript: の場合 => URL が出力されない',
				'contact_link'        => 'javascript:alert(1)',
				'contains'            => 'href=""',
				'not_contains'        => 'javascript:',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( array( 'contact_link' => $case['contact_link'] ) );
			$actual = $this->capture(
				function () {
					include get_template_directory() . '/module_mainfoot.php';
				}
			);
			$this->assertStringContainsString( $case['contains'], $actual, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $actual, $case['test_condition_name'] );
		}
	}

	/**
	 * module_topPR.php の画像 URL・alt・タイトルがエスケープされること。
	 */
	public function test_module_topPR() {
		$test_cases = array(
			array(
				'test_condition_name' => '正常な値の場合 => そのまま出力',
				'options'             => array(
					'pr1_title'   => 'PR Title',
					'pr1_image'   => 'https://example.com/pr.jpg',
					'pr1_image_s' => 'https://example.com/pr_s.jpg',
				),
				'contains'            => array(
					'src="https://example.com/pr.jpg"',
					'src="https://example.com/pr_s.jpg"',
					'alt="Image of PR Title"',
				),
				'not_contains'        => array(),
			),
			array(
				'test_condition_name' => 'タイトルに装飾 HTML の場合 => 見出しでは残り、alt ではタグが除かれる',
				'options'             => array(
					'pr1_title'   => 'A<br><span class="x">B</span>',
					'pr1_image'   => 'https://example.com/pr.jpg',
					'pr1_image_s' => 'https://example.com/pr_s.jpg',
				),
				'contains'            => array( 'A<br><span class="x">B</span>', 'alt="Image of A B"' ),
				'not_contains'        => array(),
			),
			array(
				'test_condition_name' => 'タイトルに属性を閉じる文字の場合 => alt の外に出ない',
				'options'             => array(
					'pr1_title'   => 'x" onerror="alert(1)',
					'pr1_image'   => 'https://example.com/pr.jpg',
					'pr1_image_s' => 'https://example.com/pr_s.jpg',
				),
				'contains'            => array( 'alt="Image of x&quot; onerror=&quot;alert(1)"' ),
				'not_contains'        => array( 'alt="Image of x" onerror=' ),
			),
			array(
				'test_condition_name' => '画像 URL が javascript: の場合 => URL が出力されない',
				'options'             => array(
					'pr1_title'   => 'T',
					'pr1_image'   => 'javascript:alert(1)',
					'pr1_image_s' => 'javascript:alert(2)',
				),
				'contains'            => array(),
				'not_contains'        => array( 'javascript:' ),
			),
			array(
				'test_condition_name' => '画像 URL に属性を閉じる文字の場合 => 属性の外に出ない',
				'options'             => array(
					'pr1_title'   => 'T',
					'pr1_image'   => 'https://example.com/pr.jpg" onerror="alert(1)',
					'pr1_image_s' => 'https://example.com/pr_s.jpg" onerror="alert(2)',
				),
				'contains'            => array(),
				'not_contains'        => array( '" onerror=' ),
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( $case['options'] );
			$actual = $this->capture(
				function () {
					include get_template_directory() . '/module_topPR.php';
				}
			);
			foreach ( $case['contains'] as $needle ) {
				$this->assertStringContainsString( $needle, $actual, $case['test_condition_name'] );
			}
			foreach ( $case['not_contains'] as $needle ) {
				$this->assertStringNotContainsString( $needle, $actual, $case['test_condition_name'] );
			}
		}
	}

	/**
	 * alt 用の文字列で、改行タグが半角スペースになりタグが取り除かれること。
	 */
	public function test_biz_vektor_get_alt_text() {
		$test_cases = array(
			array(
				'test_condition_name' => 'br を含む場合 => 半角スペースになる',
				'text'                => 'A<br>B',
				'expected'            => 'A B',
			),
			array(
				'test_condition_name' => '大文字・自己終了形の br を含む場合 => 半角スペースになる',
				'text'                => 'A<BR/>B<br />C',
				'expected'            => 'A B C',
			),
			array(
				'test_condition_name' => 'プレーンテキストの場合 => そのまま',
				'text'                => 'Alt text',
				'expected'            => 'Alt text',
			),
			array(
				'test_condition_name' => 'script を含む場合 => タグごと取り除かれる',
				'text'                => 'A<script>alert(1)</script><b>B</b>',
				'expected'            => 'AB',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->assertSame( $case['expected'], biz_vektor_get_alt_text( $case['text'] ), $case['test_condition_name'] );
		}
	}

	/**
	 * 投稿タイプの表示名の保存時にタグが除かれ、空の場合は既定値になること。
	 */
	public function test_biz_vektor_theme_options_validate_post_label_name() {
		$defaults   = biz_vektor_generate_default_options();
		$test_cases = array(
			array(
				'test_condition_name' => '通常の文字の場合 => そのまま',
				'value'               => 'ニュース',
				'expected'            => 'ニュース',
			),
			array(
				'test_condition_name' => 'タグを含む場合 => タグが除かれる',
				'value'               => 'News<script>alert(1)</script>',
				'expected'            => 'News',
			),
			array(
				'test_condition_name' => '空白だけの場合 => 既定値になる',
				'value'               => '  ',
				'expected'            => $defaults['postLabelName'],
			),
		);

		foreach ( $test_cases as $case ) {
			$input  = array_merge( $defaults, array( 'postLabelName' => $case['value'] ) );
			$output = biz_vektor_theme_options_validate( $input );
			$this->assertSame( $case['expected'], $output['postLabelName'], $case['test_condition_name'] );
		}
	}

	/**
	 * 広告欄は unfiltered_html 権限がある場合はそのまま、無い場合は許可タグ以外が除かれること。
	 */
	public function test_biz_vektor_theme_options_validate_ad_fields() {
		$ad_tag     = '<div class="ad"><script async src="https://example.com/ad.js"></script></div>';
		$test_cases = array(
			array(
				'test_condition_name' => 'unfiltered_html 権限がある場合 => 広告タグがそのまま保存される',
				'unfiltered_html'     => true,
				'value'               => $ad_tag,
				'expected'            => $ad_tag,
			),
			array(
				'test_condition_name' => 'unfiltered_html 権限が無い場合 => script が除かれ装飾は残る',
				'unfiltered_html'     => false,
				'value'               => '<div class="ad">A<script>alert(1)</script></div>',
				'expected'            => '<div class="ad">Aalert(1)</div>',
			),
			array(
				'test_condition_name' => 'unfiltered_html 権限が無く空の場合 => 空のまま',
				'unfiltered_html'     => false,
				'value'               => '',
				'expected'            => '',
			),
		);

		foreach ( $test_cases as $case ) {
			$user_id = self::factory()->user->create( array( 'role' => 'administrator' ) );
			$user    = new WP_User( $user_id );
			$user->add_cap( 'unfiltered_html', $case['unfiltered_html'] );
			wp_set_current_user( $user_id );

			$input  = array_merge(
				biz_vektor_generate_default_options(),
				array(
					'ad_content_moretag' => $case['value'],
					'ad_content_after'   => $case['value'],
					'ad_related_after'   => $case['value'],
				)
			);
			$output = biz_vektor_theme_options_validate( $input );
			foreach ( array( 'ad_content_moretag', 'ad_content_after', 'ad_related_after' ) as $key ) {
				$this->assertSame( $case['expected'], $output[ $key ], $case['test_condition_name'] . ' [' . $key . ']' );
			}
		}
		wp_set_current_user( 0 );
	}

	/**
	 * ヘッダーロゴの alt でサイト名がエスケープされること。
	 */
	public function test_biz_vektor_print_headLogo_alt() {
		$test_cases = array(
			array(
				'test_condition_name' => '通常のサイト名の場合 => そのまま',
				'blogname'            => 'My Site',
				'contains'            => 'alt="My Site"',
				'not_contains'        => 'onerror',
			),
			array(
				'test_condition_name' => '属性を閉じる文字を含む場合 => alt の外に出ない',
				'blogname'            => 'A" onerror="alert(1)',
				'contains'            => 'alt="A&quot; onerror=&quot;alert(1)"',
				'not_contains'        => '" onerror="',
			),
		);

		foreach ( $test_cases as $case ) {
			update_option( 'blogname', $case['blogname'] );
			$this->set_options( array( 'head_logo' => 'https://example.com/logo.png' ) );
			$actual = $this->capture( 'biz_vektor_print_headLogo' );
			$this->assertStringContainsString( $case['contains'], $actual, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $actual, $case['test_condition_name'] );
		}
	}

	/**
	 * 画像の alt で改行タグが半角スペースになること（スライド・フッターロゴ・3PR）。
	 */
	public function test_alt_text_with_line_break() {
		// スライド
		$this->set_options(
			array(
				'slide1image' => 'https://example.com/a.jpg',
				'slide1alt'   => 'A<br>B<BR/>C',
			)
		);
		$this->assertStringContainsString( 'alt="A B C"', get_biz_vektor_slide_body() );

		// フッターロゴ
		$this->set_options(
			array(
				'foot_logo'    => 'https://example.com/f.png',
				'sub_sitename' => 'A<br>B',
			)
		);
		$this->assertStringContainsString( 'alt="A B"', $this->capture( 'biz_vektor_footerSiteName' ) );

		// 3PR
		$this->set_options(
			array(
				'pr1_title'   => 'A<br />B',
				'pr1_image'   => 'https://example.com/pr.jpg',
				'pr1_image_s' => 'https://example.com/pr_s.jpg',
			)
		);
		$actual = $this->capture(
			function () {
				include get_template_directory() . '/module_topPR.php';
			}
		);
		$this->assertStringContainsString( 'alt="Image of A B"', $actual );
	}

	/**
	 * 3PR のタイトルに script を入れても見出しに出力されないこと。
	 */
	public function test_module_topPR_title() {
		$this->set_options(
			array(
				'pr1_title'   => 'A<script>alert(1)</script><b onclick="x()">B</b>',
				'pr1_image'   => 'https://example.com/pr.jpg',
				'pr1_image_s' => 'https://example.com/pr_s.jpg',
			)
		);
		$actual = $this->capture(
			function () {
				include get_template_directory() . '/module_topPR.php';
			}
		);
		$this->assertStringContainsString( '<b>B</b>', $actual );
		$this->assertStringNotContainsString( '<script', $actual );
		$this->assertStringNotContainsString( 'onclick="x()"', $actual );
	}

	/**
	 * サイトマップで投稿タイプの表示名がエスケープされること。
	 */
	public function test_module_sitemap() {
		self::factory()->post->create( array( 'post_status' => 'publish' ) );

		$test_cases = array(
			array(
				'test_condition_name' => '通常の表示名の場合 => そのまま出力',
				'label'               => 'ニュース',
				'contains'            => 'ニュース',
				'not_contains'        => '<script',
			),
			array(
				'test_condition_name' => 'タグを含む場合 => タグが文字として出力される',
				'label'               => 'N<script>alert(1)</script>',
				'contains'            => 'N&lt;script&gt;alert(1)&lt;/script&gt;',
				'not_contains'        => '<script>alert(1)',
			),
		);

		foreach ( $test_cases as $case ) {
			$this->set_options( array( 'postLabelName' => $case['label'] ) );
			$actual = $this->capture(
				function () {
					include get_template_directory() . '/module_sitemap.php';
				}
			);
			$this->assertStringContainsString( $case['contains'], $actual, $case['test_condition_name'] );
			$this->assertStringNotContainsString( $case['not_contains'], $actual, $case['test_condition_name'] );
		}
	}

	/**
	 * サイトマップで投稿タイプのリンクがエスケープされること。
	 */
	public function test_module_sitemap_link() {
		$type = 'test_sitemap_type';
		register_post_type( $type, array( 'public' => true ) );
		register_taxonomy( 'test_sitemap_tax', $type, array( 'hierarchical' => true ) );
		self::factory()->post->create(
			array(
				'post_status' => 'publish',
				'post_type'   => $type,
			)
		);
		update_option( 'biz_vektor_ad_options', array( 'types' => array( $type ) ) );
		$filter = function () {
			return 'https://example.com/ev"onx=1';
		};
		add_filter( 'home_url', $filter );

		$actual = $this->capture(
			function () {
				include get_template_directory() . '/module_sitemap.php';
			}
		);
		remove_filter( 'home_url', $filter );
		unregister_taxonomy( 'test_sitemap_tax' );
		unregister_post_type( $type );
		delete_option( 'biz_vektor_ad_options' );

		$this->assertStringContainsString( 'sectionBox', $actual );
		$this->assertStringNotContainsString( 'ev"onx', $actual );
	}

	/**
	 * LINE ボタンの href に入る表示名が属性値として出力されること。
	 */
	public function test_module_snsBtns_line_href() {
		$page_id = self::factory()->post->create(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
			)
		);
		update_option( 'show_on_front', 'page' );
		update_option( 'page_for_posts', $page_id );
		update_option( 'page_on_front', 0 );
		$this->set_options( array( 'postLabelName' => 'ab"cd onx=1' ) );
		$this->set_mobile( true );
		$this->go_to( get_permalink( $page_id ) );

		$actual = $this->capture(
			function () {
				include get_template_directory() . '/plugins/sns/module_snsBtns.php';
			}
		);
		delete_option( 'show_on_front' );
		delete_option( 'page_for_posts' );
		delete_option( 'page_on_front' );

		$this->assertMatchesRegularExpression( '/<a href="line:\/\/msg\/text\/[^"]*"><span/', $actual );
		$this->assertStringContainsString( 'ab&quot;cd onx=1', $actual );
		$this->assertStringNotContainsString( 'ab"cd', $actual );
	}

	/**
	 * 管理バーのメニュー名で投稿の表示名がエスケープされること。
	 */
	public function test_bizvektor_adminbar_custom_menu_post_label() {
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );
		$this->set_options( array( 'postLabelName' => 'ab<i>cd' ) );

		require_once ABSPATH . WPINC . '/class-wp-admin-bar.php';
		global $wp_admin_bar;
		$backup       = $wp_admin_bar;
		$wp_admin_bar = new WP_Admin_Bar();
		require_once get_template_directory() . '/plugins/extra_module/adminBarCustom.php';
		bizvektor_adminbar_custom_menu();

		$ids = array( 'postLabelName', 'postAdminMenu_list', 'postAdminMenu_new', 'postAdminMenu_category' );
		$out = '';
		foreach ( $wp_admin_bar->get_nodes() as $node ) {
			if ( 'postLabelName' === $node->id || 'postLabelName' === $node->parent ) {
				$out .= $node->title;
			}
		}
		$wp_admin_bar = $backup;

		$this->assertStringContainsString( 'ab&lt;i&gt;cd', $out );
		$this->assertStringNotContainsString( '<i>', $out );
		$this->assertCount( 4, array_filter( explode( 'ab&lt;i&gt;cd', $out ) ) ? array_fill( 0, 4, 1 ) : array(), 'dummy' );
	}
}
