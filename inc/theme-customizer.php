<?php 
/*	To use text area at customizer
/*-------------------------------------------*/
if(class_exists('WP_Customize_Control')):
	class customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="3" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}
endif;

add_action( 'customize_register', 'bizvektor_customize_register' );
function bizvektor_customize_register($wp_customize) {
	
	/*	Design setting
	/*-------------------------------------------*/
    $wp_customize->add_section( 'biz_vektor_design', array(
        'title'          => __( 'Design settings', 'biz-vektor' ),
        'priority'       => 100,
    ) );

    $add_setting_array = array(
        'default'        => '',
        'type'           => 'option',
        'capability'     => 'edit_theme_options',
    );
    $wp_customize->add_setting( 'biz_vektor_theme_options[theme_style]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[head_logo]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[foot_logo]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[gMenuDivide]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[theme_layout]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[font_title]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[font_menu]',  $add_setting_array );
    $wp_customize->add_setting( 'biz_vektor_theme_options[topSideBarDisplay]', array('default' => false, 'type'=>'option','capability' => 'edit_theme_options'));

	/* English Fonts */
	$wp_customize->add_setting( 'biz_vektor_theme_options[global_font]', $add_setting_array ); 

		// Create BizVektor Theme styles Array
		global $biz_vektor_theme_styles;
		biz_vektor_theme_styleSetting();
		foreach( $biz_vektor_theme_styles as $biz_vektor_theme_styleKey => $biz_vektor_theme_styleValues) {
			$biz_vektor_style_array[$biz_vektor_theme_styleKey] = $biz_vektor_theme_styleValues['label'];
		}
		// Create section UI
		// $wp_customize->add_control( 'theme_style',array(
		// 	'label'     => __('Design', 'biz-vektor'),
		// 	'section'   => 'biz_vektor_design',
		// 	'settings'  => 'biz_vektor_theme_options[theme_style]',
		// 	'type' => 'select',
		// 	'choices' => $biz_vektor_style_array,
		// 	'priority' => 01,
		// ));
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'head_logo',
			array(
				'label'     => __('Header logo image', 'biz-vektor'),
				'section'   => 'biz_vektor_design',
				'settings'  => 'biz_vektor_theme_options[head_logo]',
				'priority'  => 101,
			)
		) );
		$wp_customize->add_control( 'head_logo_url_txt',
			array(
				'label'     => __('Header logo image URL', 'biz-vektor'),
				'section'   => 'biz_vektor_design', 
				'settings'  => 'biz_vektor_theme_options[head_logo]',
				'type' => 'text',
				'priority' => 102,
			));

		// Create section UI
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'foot_logo',
			array(
				'label'     => __('Footer logo image', 'biz-vektor'),
				'section'   => 'biz_vektor_design',
				'settings'  => 'biz_vektor_theme_options[foot_logo]',
				'priority' => 111,
			)
		) );
		$wp_customize->add_control( 'foot_logo_url_txt',
			array(
				'label'     => __('Footer logo image URL', 'biz-vektor'),
				'section'   => 'biz_vektor_design', 
				'settings'  => 'biz_vektor_theme_options[foot_logo]',
				'type' => 'text',
				'priority' => 112,
			));

		$biz_vektor_gMenuDivides = array(
			'divide_natural' => __('Not specified (left-justified)', 'biz-vektor'),
			'divide_4' => _x('4', 'biz-vektor-theme-customizer', 'biz-vektor'),
			'divide_5' => _x('5', 'biz-vektor-theme-customizer', 'biz-vektor'),
			'divide_6' => _x('6', 'biz-vektor-theme-customizer', 'biz-vektor'),
			'divide_7' => _x('7', 'biz-vektor-theme-customizer', 'biz-vektor'));
		$wp_customize->add_control( 'gMenuDivide',array(
			'label'     => _x('Number of header menus', 'biz-vektor-theme-customizer', 'biz-vektor'),
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[gMenuDivide]',
			'type' => 'select',
			'choices' => $biz_vektor_gMenuDivides,
			'priority' => 200,
		));

		foreach ( biz_vektor_layouts() as $layout ) {
			$biz_vektor_layout_array[$layout['value']] = $layout['label'];
		}
		$wp_customize->add_control( 'biz_vektor_layout',array(
			'label'     => __( 'Layout', 'biz-vektor' ),
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[theme_layout]',
			'type' => 'radio',
			'choices' => $biz_vektor_layout_array,
			'priority' => 301,
		));
		$wp_customize->add_control( 'font',array(
			'label'     => __( 'Heading font', 'biz-vektor' ),
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[font_title]',
			'type' => 'radio',
			'choices' => array(
				'serif' => __('Serif', 'biz-vektor'),
				'sanserif' => __('Sanserif', 'biz-vektor'),
				),
			'priority' => 501,
		));

		$wp_customize->add_control( 'font_menu',array(
			'label'     => __( 'Global Menu font', 'biz-vektor'),
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[font_menu]',
			'type' => 'radio',
			'choices' => array(
				'serif' => __( 'Serif', 'biz-vektor' ),
				'sanserif' => __( 'Sanserif', 'biz-vektor' ),
				),
			'priority' => 502,
		));

		if ( 'ja' != get_locale() ) {

			//gets fonts list $fonts
			require get_template_directory() . '/inc/fonts-list.php';

			$wp_customize->add_control( 
				new WP_Customize_Control(
					$wp_customize,
					'theme_bizvektor_global_font',
					array(
						'label'          => __( 'Google Web Fonts', 'biz-vektor' ),
						'section'        => 'biz_vektor_design',
						'settings'       => 'biz_vektor_theme_options[global_font]',
						'type'           => 'select',
						'choices'        => $fonts,
						'priority'		 => 503,
					)
				)
			);
		}

		$wp_customize->add_control( 'display_side',array(
			'label'     => __( 'Don\'t show on top page' , 'biz-vektor' ),
			'section'   => 'biz_vektor_design',
			'settings'  => 'biz_vektor_theme_options[topSideBarDisplay]',
			'type' => 'checkbox',
			'priority' => 504,
		));

	/*	Contact information
	/*-------------------------------------------*/
	// Create section
	$wp_customize->add_section( 'biz_vektor_contact', array(
	    'title'          => __('Contact settings', 'biz-vektor'),
	    'priority'       => 101,
	));

		$add_setting_array = array(
		    'default'        => '',
		    'type'           => 'option',
		    'capability'     => 'edit_theme_options',
		);
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_txt]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[tel_number]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_time]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[sub_sitename]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_address]',  $add_setting_array );
		$wp_customize->add_setting( 'biz_vektor_theme_options[contact_link]',  $add_setting_array );

		$wp_customize->add_control( 'contact_txt',
			array(
				'label'     => __('Message', 'biz-vektor'),
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_txt]',
				'type' => 'text',
				'priority' => 1,
			));
		$wp_customize->add_control( 'tel_number',
			array(
				'label'     => __('Phone number', 'biz-vektor'),
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[tel_number]',
				'type' => 'text',
				'priority' => 2,
			));
		$wp_customize->add_control( 'contact_time',
			array(
				'label'     => __('Office hours', 'biz-vektor'),
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_time]',
				'type' => 'text',
				'priority' => 3,
			));		
		$wp_customize->add_control( 'sub_sitename',
			array(
				'label'     => __('Site / Company / Store / Service name. This is displayed in the left part of the footer bottom and footer copyright section.', 'biz-vektor'),
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[sub_sitename]',
				'type' => 'text',
				'priority' => 4,
			));
		$wp_customize->add_control( new customize_Textarea_Control( $wp_customize,'contact_address',
			array(
				'label'     => __('Company address', 'biz-vektor'),
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_address]',
				//'type' => 'textfield',
				'priority' => 5,
			)));
		$wp_customize->add_control( 'contact_link',
			array(
				'label'     => __('The contact page URL', 'biz-vektor'),
				'section'   => 'biz_vektor_contact', 
				'settings'  => 'biz_vektor_theme_options[contact_link]',
				'type' => 'text',
				'priority' => 6,
			));

	/*	TOP 3PR
	/*-------------------------------------------*/
	// Create section UI
    $wp_customize->add_section( 'biz_vektor_top3pr', array(
        'title'          => __('3PR area settings', 'biz-vektor'),
        'priority'       => 102,
    ) );
    
	for ( $i = 1; $i <= 3 ;){
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_title]', 		array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_description]', 	array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_link]', 			array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_image]', 		array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		$wp_customize->add_setting( 'biz_vektor_theme_options[pr'.$i.'_image_s]', 		array('default' => '','type'=> 'option','capability' => 'edit_theme_options', ) );
		// Create section UI
		$wp_customize->add_control( 'pr'.$i.'_title',
			array(
				'label'     => '['.$i.']'.__('Title', 'biz-vektor'),
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_title]',
				'type' => 'text',
				'priority' => ($i*10)+1,
			)
		);
		$wp_customize->add_control( new customize_Textarea_Control( $wp_customize, 'pr'.$i.'_description',
			array(
				'label'     => '['.$i.']'.__('Description', 'biz-vektor'),
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_description]',
				'priority' => ($i*10)+2,
			)));
		$wp_customize->add_control( 'pr'.$i.'_link',
			array(
				'label'     => '['.$i.']'.__('URL', 'biz-vektor'),
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_link]',
				'type' => 'text',
				'priority' => ($i*10)+3,
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'pr'.$i.'_image',
			array(
				'label'     => '['.$i.']'.__('Image (Desktop version) : 310px width is recommended.', 'biz-vektor'),
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_image]',
				'priority' => ($i*10)+4,
			))
		);
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'pr'.$i.'_image_s',
			array(
				'label'     => '['.$i.']'.__('Image (Smartphone version) : 120px by 120px is recommended.', 'biz-vektor'),
				'section'   => 'biz_vektor_top3pr', 
				'settings'  => 'biz_vektor_theme_options[pr'.$i.'_image_s]',
				'priority' => ($i*10)+5,
			))
		);

	$i++;
	}
}