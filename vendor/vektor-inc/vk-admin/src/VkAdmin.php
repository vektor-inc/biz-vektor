<?php
/**
 * VK Admin
 *
 * @package vektor-inc/vk-admin
 * @license GPL-2.0+
 *
 * @version 0.5.0
 */

namespace VektorInc\VK_Admin;

class VkAdmin {

	public static $version = '0.5.0';

	public static function init() {
		$locale = ( is_admin() && function_exists( 'get_user_locale' ) ) ? get_user_locale() : get_locale();
		load_textdomain( 'vk-admin', dirname( __FILE__ ) . '/languages/' . 'vk-admin-' . $locale . '.mo' );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_common_css' ) );
		add_action( 'customize_register', array( __CLASS__, 'admin_common_css' ) );
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'dashboard_widget' ), 1 );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'add_widget_screen_css' ) );
	}

	public static function add_widget_screen_css() {
		$current_path = dirname( __FILE__ );
		$current_url  = str_replace( ABSPATH, site_url( '/' ), $current_path );
		wp_enqueue_style( 'vk-admin-style', $current_url . '/assets/css/customize-and-widget.css', array(), self::$version, 'all' );
	}

	public static function admin_common_css() {
		$current_path = wp_normalize_path( dirname( __FILE__ ) );
		$abs_path     = wp_normalize_path( ABSPATH );
		$current_url  = str_replace( $abs_path, site_url( '/' ), $current_path );
		wp_enqueue_style( 'vk-admin-style', $current_url . '/assets/css/vk_admin.css', array(), self::$version, 'all' );
	}

	public static function admin_enqueue_scripts() {
		$current_path = wp_normalize_path( dirname( __FILE__ ) );
		$abs_path     = wp_normalize_path( ABSPATH );
		$current_url  = str_replace( $abs_path, site_url( '/' ), $current_path );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_media();
		wp_enqueue_script( 'vk-admin-js', $current_url . '/assets/js/vk_admin.js', array( 'jquery' ), self::$version );
	}

	// 管理画面用のjsを読み込むページを配列で指定する
	// $admin_pages は vk-admin-config.php に記載
	public static function admin_scripts( $admin_pages ) {
		foreach ( $admin_pages as $key => $value ) {
			$hook = 'admin_print_styles-' . $value;
			add_action( $hook, array( __CLASS__, 'admin_enqueue_scripts' ) );
		}
	}

	/**
	 * Plugin Exists
	 *
	 * @param string $plugin '${plugin_dir}/${plugin_file}.php'.
	 */
	public static function plugin_exists( $plugin ) {
		return file_exists( WP_PLUGIN_DIR . '/' . $plugin );
	}

	/**
	 * Theme Exists
	 *
	 * @param string $theme '${theme_dir}/style.css'.
	 */
	public static function theme_exists( $theme ) {
		return file_exists( WP_CONTENT_DIR . '/themes/' . $theme );
	}

	/*
	get_admin_banner
	get_news_body
	admin _ Dashboard Widget
	admin _ sub
	admin _ page_frame
	/*--------------------------------------------------*/

	/*
	get_admin_banner
	/*--------------------------------------------------*/
	public static function get_admin_banner() {
		$banner_html = '';
		$dir_url     = plugin_dir_url( __FILE__ );
		$lang        = ( get_locale() == 'ja' ) ? 'ja' : 'en';

		// 画像を配置したディレクトリの URL
		$img_base_url = 'https://raw.githubusercontent.com/vektor-inc/vk-admin-banners/main/images/';

		// 変数の初期化
		$product_array = array();

		// WP File System で JSON ファイルを読み込み
		require_once ABSPATH . 'wp-admin/includes/file.php';
		if ( WP_Filesystem() ) {
			global $wp_filesystem;

			// プロダクトの配列を取得・生成
			$product_json_url = 'https://raw.githubusercontent.com/vektor-inc/vk-admin-banners/main/vk-admin-banners.json';
			$product_json     = $wp_filesystem->get_contents( $product_json_url );
			$product_json     = mb_convert_encoding( $product_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN' );
			$product_array    = json_decode( $product_json, true );
		}

		// 現在のテーマを取得
		$current_template = get_template();

		$banner_html .= '<div class="vk-admin-banner">';

		if ( $lang == 'ja' ) {
			// $banner_html .= '<a class="admin_banner" href="https://recruit.vektor-inc.co.jp/?rel=vkadmin" target="_blank">';
			// $banner_html .= '<img src="' . $dir_url . 'images/admin_banner_recruit.jpg" alt="[ Vektor,Inc. 採用情報 ]" />';
			// $banner_html .= '</a>';
		} else {
			$banner_html .= '<a href="https://lightning.nagoya/lightning_copyright_customizer/?rel=vkadmin" target="_blank" class="button button-primary button-primary button-block" style="margin-bottom:1em;">Lightning Copyright Customizer <span class="screen-reader-text">(opens in a new tab)</span><span aria-hidden="true" class="dashicons dashicons-external" style="position:relative;top:3px;"></span></a>';
		}

		$banner_html .= '<div class="vk-admin-banner-grid">';

		if ( ! empty( $product_array ) ) {

			// テーマのバナーを設置
			foreach ( $product_array as $product ) {

				// 該当テーマがアクティブでなければスキップ
				if ( ! empty( $product['active_theme'] ) && $current_template !== $product['active_theme'] ) {
					continue;
				}

				// include パラメーターが存在する場合
				if ( ! empty( $product['include'] ) ) {
					// include パラメーターをカンマで区切って配列化
					$includes = explode( ',', $product['include'] );
					// include パラメーター が配列の場合
					if ( is_array( $includes ) ) {
						// 該当するものがあった時点で continue を２回発動
						foreach ( $includes as $include ) {
							if ( self::theme_exists( $include ) || self::plugin_exists( $include ) ) {
								continue 2;
							}
						}
					} else {
						// 該当するものがあった時点で continue を発動
						if ( self::theme_exists( $includes ) || self::plugin_exists( $includes ) ) {
							continue;
						}
					}
				}

				if ( 'theme' === $product['type'] ) {
					if ( ! self::theme_exists( $product['slug'] ) ) {
						if ( $lang === $product['language'] ) {

							// プラグインの検索結果に飛ばす場合 URL を変換する必要がある
							$product_url = true === $product['admin_url'] ? admin_url( $product['link_url'] ) : $product['link_url'];

							// バナーを追加
							$banner_html .= '<a href="' . $product_url . '" target="_blank" class="admin_banner">';
							$banner_html .= '<img src="' . $img_base_url . $product['image_file'] . '" alt="' . $product['alt'] . '" />';
							$banner_html .= '</a>';
						}
					}
				}

				if ( 'plugin' === $product['type'] ) {
					if ( ! self::plugin_exists( $product['slug'] ) ) {
						if ( $lang === $product['language'] ) {

							// プラグインの検索結果に飛ばす場合 URL を変換する必要がある
							$product_url = true === $product['admin_url'] ? admin_url( $product['link_url'] ) : $product['link_url'];

							// バナーを追加
							$banner_html .= '<a href="' . $product_url . '" target="_blank" class="admin_banner">';
							$banner_html .= '<img src="' . $img_base_url . $product['image_file'] . '" alt="' . $product['alt'] . '" />';
							$banner_html .= '</a>';
						}
					}
				}
			}
		}

		$banner_html .= '</div>';

		$banner_html .= '<a href="//www.vektor-inc.co.jp" class="vektor_logo" target="_blank" class="admin_banner"><img src="' . $img_base_url . 'vektor_logo-2020.png" alt="Vektor,Inc." /></a>';

		$banner_html .= '</div>';

		return apply_filters( 'vk_admin_banner_html', $banner_html );
	}

	public static function get_news_posttype_html( $title, $link_url, $target_id ) {
		$html  = '<h4 class="vk-metabox-sub-title">';
		$html .= esc_html( $title );
		$html .= '<a href="' . esc_url( $link_url ) . '" target="_blank" class="vk-metabox-more-link">' . __( 'Post List', 'vk_admin_textdomain' ) . '<span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
		$html .= '</h4>';
		$html .= '<ul id="' . esc_attr( $target_id ) . '" class="vk-metabox-post-list"></ul>';
		return $html;
	}

	/*
	get_news_body
	/*--------------------------------------------------*/
	public static function get_news_body() {
		$html = '';
		if ( 'ja' == get_locale() ) {
			// Japanese --------------------------------------
			$html .= self::get_news_posttype_html( 
				'Vektor製品更新情報', 
				'https://www.vektor-inc.co.jp/product-update/?rel=vkadmin', 
				'vk-product-update'
			);
			$html .= self::get_news_posttype_html(
				'VK Pattern Library', 
				'https://patterns.vektor-inc.co.jp/?rel=vkadmin', 
				'vk-pattern-library'
			);
			$html .= self::get_news_posttype_html(
				'Vektor WordPress フォーラム', 
				'https://vws.vektor-inc.co.jp/forums/?rel=vkadmin', 
				'vk-wp-forum'
			);
			$html .= self::get_news_posttype_html(
				'ベクトルからのお知らせ', 
				'https://www.vektor-inc.co.jp/info/?rel=vkadmin', 
				'vk-wp-info'
			);
			$html .= self::get_news_posttype_html(
				'Vektor WordPress ブログ', 
				'https://www.vektor-inc.co.jp/category/wordpress-info/?rel=vkadmin', 
				'vk-wp-blog'
			);
		} else {
			// English --------------------------------------
			$html .= self::get_news_posttype_html(
				'Update Information', 
				'https://vektor-inc.co.jp/en/update/?rel=vkadmin', 
				'vk-wp-update'
			);
			$html .= self::get_news_posttype_html( 
				'Vektor WordPress Information', 
				'https://vektor-inc.co.jp/en/information/?rel=vkadmin', 
				'vk-wp-info'
			);
		}

		$html = apply_filters( 'vk_admin_news_html', $html );

		add_action( 'admin_footer', array( __CLASS__, 'load_rest_api_js' ) );

		return $html;
		?>
		<?php
	}

	public static function get_posts_from_rest_api_js( $url, $target_id, $data = true ) {
		?>
		$.getJSON( "<?php echo $url ;?>",
		function(results) {
			// 取得したJSONの内容をループする
			$.each(results, function(i, item) {
				// 日付のデータを取得
				var date = new Date(item.date_gmt);
				var formate_date = date.toLocaleDateString();
				// JSONの内容の要素を</ul>の前に出力する
				$("ul#<?php echo esc_attr( $target_id ); ?>").append('<li><?php if ( $data ) { ?><span class="date">'+ formate_date +'</span><?php } ?><a href="' + item.link + '?rel=vkadmin" target="_blank">' + item.title.rendered + '</a></li>');
			});
		});
		<?php
	}

	public static function load_rest_api_js() {
		?>
	<script>
	/*-------------------------------------------*/
	/* REST API でお知らせを取得
	/*-------------------------------------------*/
	;(function($){
		jQuery(document).ready(function($){

			<?php 
			if ( 'ja' == get_locale() ) {

				// Japanese --------------------------------------
				// お知らせ
				self::get_posts_from_rest_api_js( 'https://vektor-inc.co.jp/wp-json/wp/v2/info/?per_page=3', 'vk-wp-info' );

				// VK Pattern Library
				self::get_posts_from_rest_api_js( 'https://patterns.vektor-inc.co.jp/wp-json/wp/v2/vk-patterns/?per_page=3', 'vk-pattern-library' );

				// フォーラム
				self::get_posts_from_rest_api_js( 'https://vws.vektor-inc.co.jp/wp-json/wp/v2/topics/?per_page=5', 'vk-wp-forum', false );

				// 製品更新情報
				self::get_posts_from_rest_api_js( 'https://vektor-inc.co.jp/wp-json/wp/v2/product-update/?per_page=5', 'vk-product-update' ); 

				// ブログ
				self::get_posts_from_rest_api_js( 'https://www.vektor-inc.co.jp/wp-json/wp/v2/posts/?categories=55&per_page=3', 'vk-wp-blog' );



			} else {

				// English --------------------------------------
				// お知らせ
				self::get_posts_from_rest_api_js( 
					'https://vektor-inc.co.jp/en/wp-json/wp/v2/posts/?per_page=3', 
					'vk-wp-info'
				); 

				// 製品更新情報
				self::get_posts_from_rest_api_js( 
					'https://vektor-inc.co.jp/en/wp-json/wp/v2/update/?per_page=5', 
					'vk-wp-update' 
				); 
			}
			?>

	});
	})(jQuery);
	</script>
		<?php
	}

	public static function is_dashboard_active() {
		$flag = false;
		if ( 'ja' == get_locale() ) {
			$flag = true;
		}
		if ( self::plugin_exists( 'vk-all-in-one-expansion-unit/vkExUnit.php' ) ) {
			$flag = true;
		}
		if ( ! self::plugin_exists( 'vk-post-author-display/post-author-display.php' ) ) {
			$flag = true;
		}
		$theme = wp_get_theme()->get( 'Template' );
		if ( $theme != 'lightning' ) {
			$flag = true;
		}

		return apply_filters( 'vk-admin-is-dashboard-active', $flag );
	}
	/*
	admin _ Dashboard Widget
	/*--------------------------------------------------*/
	public static function dashboard_widget() {
		if ( self::is_dashboard_active() ) {
			wp_add_dashboard_widget(
				'vk_dashboard_widget',
				__( 'Vektor WordPress Information', 'vk_admin_textdomain' ),
				array( __CLASS__, 'dashboard_widget_body' )
			);
		}
	}

	public static function dashboard_widget_body() {
		echo self::get_news_body();
		echo self::get_admin_banner();
	}

	/*
	admin _ sub
	/*--------------------------------------------------*/
	// 2016.08.07 ExUnitの有効化ページでは直接 admin_subを呼び出しているので注意
	public static function admin_sub() {
		$display = apply_filters( 'vk_admin_sub_display', true );
		if ( ! $display ) {
			return;
		}
		$adminSub  = '<div class="adminSub">' . "\n";
		$adminSub .= '<div class="adminSub_inner">' . "\n";
		if ( 'ja' == get_locale() ) {
			$adminSub .= '<div class="infoBox">' . self::get_news_body() . '</div>' . "\n";
		}
		$adminSub .= '<div class="vk-admin-banner">' . self::get_admin_banner() . '</div>' . "\n";

		$adminSub .= '</div><!-- [ /.adminSub_inner ] -->' . "\n";
		$adminSub .= '</div><!-- [ /.adminSub ] -->' . "\n";
		return $adminSub;
	}

	/*
	admin _ page_frame
	/*--------------------------------------------------*/
	public static function admin_page_frame( $get_page_title, $the_body_callback, $get_logo_html = '', $get_menu_html = '', $get_layout = 'column_3' ) {
		?>
		<div class="wrap vk_admin_page">
			<?php if ( $get_layout == 'column_2' ) : ?>
				<div class="pageLogo"><?php echo $get_logo_html; ?></div>
				<?php if ( $get_page_title ) : ?>
					<h1 class="page_title"><?php echo $get_page_title; ?></h1>
				<?php endif; ?>
			<?php endif; ?>

			<div class="adminLayout">
				<div class="adminMain <?php echo $get_layout; ?>">

					<?php if ( $get_layout == 'column_3' ) : ?>
						<div id="adminContent_sub" class="scrTracking adminMain_sub">
							<div class="adminMain_sub_inner">
								<div class="pageLogo"><?php echo $get_logo_html; ?></div>
								<?php if ( $get_page_title ) : ?>
								<h2 class="page_title"><?php echo $get_page_title; ?></h2>
								<?php endif; ?>
								<div class="vk_option_nav">
									<ul>
									<?php echo $get_menu_html; ?>
									</ul>
								</div>
							</div>
						</div><!-- [ /#adminContent_sub ] -->
					<?php endif; ?>

					<div id="adminContent_main" class="adminMain_main">
					<?php call_user_func_array( $the_body_callback, array() ); ?>
					</div><!-- [ /#adminContent_main ] -->

				</div><!-- [ /.adminMain ] -->

				<?php echo self::admin_sub(); ?>
			</div>

		</div><!-- [ /.vkExUnit_admin_page ] -->
		<?php
	}
}

