<?php
/**
 * Class Full_Wide_Title_Widget_Test
 *
 * 全幅見出しウィジェットの保存時の検証と出力のテスト。
 *
 * @package Biz Vektor
 */

/**
 * 全幅見出しウィジェットの update() と widget_font_style() を検証するテストクラス。
 */
class Full_Wide_Title_Widget_Test extends WP_UnitTestCase {

	/**
	 * 全項目が保存され、タイトル・サブタイトルの装飾タグが残ること。
	 */
	public function test_update_saves_all_fields() {
		$widget = new BV_Full_Wide_Title();

		// 全項目を送信して保存時の検証を通す
		$instance = $widget->update(
			array(
				'media_image_id'   => '12',
				'title_bg_color'   => '#123456',
				'title_font_color' => '#fff',
				'title'            => 'Title<br>Line2 <span class="x">Em</span>',
				'text'             => 'Sub<br><span class="x">Text</span>',
			),
			array()
		);

		$this->assertSame( 12, $instance['media_image_id'] );
		$this->assertSame( '#123456', $instance['title_bg_color'] );
		$this->assertSame( '#fff', $instance['title_font_color'] );
		$this->assertStringContainsString( '<br>', $instance['title'] );
		$this->assertStringContainsString( '<span class="x">Em</span>', $instance['title'] );
		$this->assertStringContainsString( '<br>', $instance['text'] );
		$this->assertStringContainsString( '<span class="x">Text</span>', $instance['text'] );
	}

	/**
	 * 色と画像IDの不正な値が保存されないこと。
	 */
	public function test_update_rejects_invalid_values() {
		$widget = new BV_Full_Wide_Title();

		$test_cases = array(
			array(
				'test_condition_name' => '#rrggbb / #rgb 形式でない値 => 空になる',
				'new_instance'        => array(
					'title_bg_color'   => '#12345g',
					'title_font_color' => '12345',
				),
				'expected'            => array(
					'title_bg_color'   => '',
					'title_font_color' => '',
				),
			),
			array(
				'test_condition_name' => '色名 => 空になる',
				'new_instance'        => array(
					'title_bg_color'   => 'red',
					'title_font_color' => 'rgba(0,0,0,0.5)',
				),
				'expected'            => array(
					'title_bg_color'   => '',
					'title_font_color' => '',
				),
			),
			array(
				'test_condition_name' => '画像IDが数値ではない => 空になる',
				'new_instance'        => array( 'media_image_id' => '12abc' ),
				'expected'            => array( 'media_image_id' => '' ),
			),
			array(
				'test_condition_name' => '画像削除で空 => 空のまま',
				'new_instance'        => array( 'media_image_id' => '' ),
				'expected'            => array( 'media_image_id' => '' ),
			),
			array(
				'test_condition_name' => '未送信の項目 => 空になり警告が出ない',
				'new_instance'        => array(),
				'expected'            => array(
					'media_image_id'   => '',
					'title_bg_color'   => '',
					'title_font_color' => '',
					'title'            => '',
					'text'             => '',
				),
			),
		);

		foreach ( $test_cases as $test_case ) {
			// 検証を通した結果を期待値の項目ごとに比較
			$instance = $widget->update( $test_case['new_instance'], array() );
			foreach ( $test_case['expected'] as $key => $value ) {
				$this->assertSame( $value, $instance[ $key ], $test_case['test_condition_name'] . ' : ' . $key );
			}
		}
	}

	/**
	 * widget_font_style() が正しい色だけ style を出すこと。
	 */
	public function test_widget_font_style() {
		$test_cases = array(
			array(
				'test_condition_name' => '6桁の色 => style が出る',
				'color'               => '#123456',
				'expected'            => 'color:#123456;',
			),
			array(
				'test_condition_name' => '#rrggbb / #rgb 形式でない値 => style が出ない',
				'color'               => '#12345g',
				'expected'            => '',
			),
			array(
				'test_condition_name' => '色名 => style が出ない',
				'color'               => 'red',
				'expected'            => '',
			),
			array(
				'test_condition_name' => '空 => style が出ない',
				'color'               => '',
				'expected'            => '',
			),
		);

		foreach ( $test_cases as $test_case ) {
			$actual = BV_Full_Wide_Title::widget_font_style( array( 'title_font_color' => $test_case['color'] ) );
			$this->assertSame( $test_case['expected'], $actual, $test_case['test_condition_name'] );
		}
	}

	/**
	 * widget() の出力で、装飾タグが残り、不正な文字色では style が出ないこと。
	 */
	public function test_widget_output() {
		$widget = new BV_Full_Wide_Title();
		$args   = array(
			'before_widget' => '',
			'after_widget'  => '',
		);

		// 装飾タグ入りのタイトル・サブタイトルと正しい文字色で出力
		ob_start();
		$widget->widget(
			$args,
			array(
				'title'            => 'Title<br><span class="x">Em</span>',
				'text'             => 'Sub<br><span class="x">Text</span>',
				'title_font_color' => '#123456',
			)
		);
		$output = ob_get_clean();
		$this->assertStringContainsString( 'Title<br><span class="x">Em</span>', $output );
		$this->assertStringContainsString( 'Sub<br><span class="x">Text</span>', $output );
		$this->assertStringContainsString( 'style="color:#123456;"', $output );

		// 形式に合わない文字色が保存済みの場合は style を出さない
		ob_start();
		$widget->widget(
			$args,
			array(
				'title'            => 'Title',
				'text'             => 'Sub',
				'title_font_color' => '12345',
			)
		);
		$output = ob_get_clean();
		$this->assertStringNotContainsString( 'style="color:', $output );
	}
}
