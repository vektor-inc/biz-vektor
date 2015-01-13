<?php
/*-------------------------------------------*/
/*	ダッシュボードにBizVektorのお知らせを表示
/*-------------------------------------------*/

add_filter('biz_vektor_is_plugin_dashboard_info_widget', 'biz_vektor_dash_beacon', 10, 1 );
function biz_vektor_dash_beacon($flag){
	$flag = true;
	return $flag;
}

//displays dashboard widget only for Japanese version
if ( 'ja' == get_locale() ) {
	add_action( 'wp_dashboard_setup', 'biz_vektor_dashboard_widget' );
}

function biz_vektor_dashboard_widget()
{
	wp_add_dashboard_widget(
		'biz_vektor_dashboard_widget',
		__( 'BizVektor news', 'biz-vektor' ),
		'biz_vektor_dashboard_widget_function'
	);
}

function biz_vektor_dashboard_widget_function()
{

	include_once(ABSPATH . WPINC . '/feed.php');

	$my_feeds = array( 
		array('feed_url' => 'http://bizvektor.com/feed/?post_type=info', 'feed_title' => __( 'BizVektor News', 'biz-vektor' ), ),
		array('feed_url' => 'http://forum.bizvektor.com/feed/?post_type=topic', 'feed_title' => __( 'BizVektor Forum', 'biz-vektor' ), ), 
		array('feed_url' => 'http://bizvektor.com/feed/?post_type=blog', 'feed_title' => __( 'BizVektor Developers Blog', 'biz-vektor' ), ) 
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
				$output .= __( 'There is no news to display', 'biz-vektor' );	
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