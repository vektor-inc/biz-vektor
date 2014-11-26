<?php

$folder = get_template_directory() . '/inc/style-global/';

require $folder . 'class-style-global.php';
require $folder . 'class-fonts-customizer.php';

BizVektor_Style_Global::init();
add_action( 'customize_register' , array( 'BizVektor_Style_Global_Customize', 'register' ) );
//add_action( 'wp_head', array( 'BizVektor_Style_Global_Customize', 'generate_css' ) );