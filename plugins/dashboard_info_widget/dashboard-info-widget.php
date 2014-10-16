<?php
/*-------------------------------------------*/
/*	ダッシュボードにBizVektorのお知らせを表示
/*-------------------------------------------*/
function biz_vektor_dashboard_widget()
{
	wp_add_dashboard_widget(
		'biz_vektor_dashboard_widget',
		__('BizVektorニュース', 'biz_vektor_dashboard_widget_title'),
		'biz_vektor_dashboard_widget_function'
	);
}
add_action( 'wp_dashboard_setup', 'biz_vektor_dashboard_widget' );

function biz_vektor_dashboard_widget_function()
{

	include_once(ABSPATH . WPINC . '/feed.php');

	$my_feeds = array( 
		array('feed_url' => 'http://bizvektor.com/feed/?post_type=info', 'feed_title' => 'BizVektorからのお知らせ' ),
		array('feed_url' => 'http://bizvektor.com/forum/feed/?post_type=topic', 'feed_title' => 'BizVektorフォーラム' ), 
		array('feed_url' => 'http://bizvektor.com/feed/?post_type=blog', 'feed_title' => 'BizVektor Developers Blog' ) 
	);

	foreach ( $my_feeds as $feed )
	{
		$rss = fetch_feed( $feed["feed_url"] );

		if ( !is_wp_error($rss) )
		{
			$output = '';
			
			$maxitems = $rss->get_item_quantity( 5 ); //number of news to display (maximum)
			$rss_items = $rss->get_items( 0, $maxitems );
			$rss_title = $feed["feed_title"];

			$output .= '<div class="rss-widget">';
			$output .= '<hr style="border: 0; background-color: #DFDFDF; height: 1px;">';
			$output .= '<strong>' . $rss_title . '</strong>';
			$output .= '<hr style="border: 0; background-color: #DFDFDF; height: 1px;">';

			$output .= '<ul>';

			if ( $maxitems == 0 )
			{
				$output .= '<li>';
				$output .= __( '表示できるニュースがありません。', 'biz_vektor_dashboard_widget_no_feed_error');	
				$output .= '</li>';
			}
			else
			{
				foreach ( $rss_items as $item )
				{
					$test_date 	= $item->get_local_date();
					$content 	= $item->get_content();

					if( isset($test_date) && !is_null($test_date) )
						$item_date = $item->get_date( get_option('date_format') ) . '<br />';
					else
						$item_date = '';

					$output .= '<li style="color:#777;">';
					$output .= $item_date;
					$output .= '<a href="' . esc_url( $item->get_permalink() ) . '" title="' . $item_date . '">';
					$output .= esc_html( $item->get_title() );
					$output .= '</a>';
					$output .= '</li>';
				}
			}

			$output .= '</ul>';
			$output .= '</div>';

			echo $output;
		}
	}
}