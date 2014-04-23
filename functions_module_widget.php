<?php

/**
 * 1. WP_Widget_contact_link Class
 */
class WP_Widget_contact_link extends WP_Widget {
	/** constructor */
	function WP_Widget_contact_link() {
		$widget_ops = array(
			'classname' => 'WP_Widget_contact_link',
			'description' => '問い合わせボタン',
		);
		$this->WP_Widget('contact_link', '問い合わせボタン', $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		?>
				<?php 
				echo $before_widget;
				if ( $title ) echo $before_title . $title . $after_title;
				// ウィジェットコンテンツ ここから ?>
					<?php
					$options = biz_vektor_get_theme_options();
					if ($options['contact_link']) :?>
					<ul>
					<li class="sideBnr" id="sideContact"><a href="<?php echo $options['contact_link'] ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/<?php _e('bnr_contact.png', 'biz-vektor'); ?>" alt="<?php _e('Contact us by e-mail', 'biz-vektor'); ?>"></a></li>
					</ul>
					<?php
					endif; ?>
				<?php // ウィジェットコンテンツ ここまで
				echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php
	}

} // class WP_Widget_contact_link

// register WP_Widget_contact_link widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_contact_link");'));


/**
 * 2. WP_Widget_fbBanner Class
 */
class WP_Widget_fbBanner extends WP_Widget {
	/** constructor */
	function WP_Widget_fbBanner() {
		$widget_ops = array(
			'classname' => 'WP_Widget_fbBanner',
			'description' => 'facebookバナー',
		);
		$this->WP_Widget('fbBanner', 'facebookバナー', $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		?>
				<?php 
				echo $before_widget;
				if ( $title ) echo $before_title . $title . $after_title;
				// ウィジェットコンテンツ ここから ?>
					<?php
					$options = biz_vektor_get_theme_options();
					$facebook = $options['facebook'];
					if ($facebook) {
						print '<ul id="snsBnr">';
						if ($facebook) { ?>
						<li><a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bnr_facebook.png" alt="facebook" /></a></li>
						<?php }
						print '</ul>';
					} ?>
				<?php // ウィジェットコンテンツ ここまで
				echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php
	}

} // class WP_Widget_fbBanner

// register WP_Widget_fbBanner widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_fbBanner");'));


/**
 * 3. WP_Widget_twBanner Class
 */
class WP_Widget_twBanner extends WP_Widget {
	/** constructor */
	function WP_Widget_twBanner() {
		$widget_ops = array(
			'classname' => 'WP_Widget_twBanner',
			'description' => 'Twitterバナー',
		);
		$this->WP_Widget('twBanner', 'Twitterバナー', $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		?>
				<?php 
				echo $before_widget;
				if ( $title ) echo $before_title . $title . $after_title;
				// ウィジェットコンテンツ ここから ?>
					<?php
					$options = biz_vektor_get_theme_options();
					$twitter = $options['twitter'];
					if ($twitter) {
						print '<ul id="snsBnr">';
						if ($twitter) { ?>
						<li><a href="https://twitter.com/#!/<?php echo htmlspecialchars($twitter); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bnr_twitter.png" alt="twitter" /></a></li>
						<?php }
						print '</ul>';
					} ?>
				<?php // ウィジェットコンテンツ ここまで
				echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php
	}

} // class WP_Widget_twBanner

// register WP_Widget_twBanner widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_twBanner");'));
