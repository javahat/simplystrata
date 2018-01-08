<?php

//************************************************************
/*
 * Add section for custom header image
 *
 */

$args_header = array(
	'default-color' => '333333',
	'default-image' => '%1$s/images/sampleBannerImage.jpg',
);
add_theme_support( 'custom-header', $args_header );


$args_background = array(
	'default-color' => '333333',
);
add_theme_support( 'custom-background', $args_background );


//************************************************************
/*
 * Add section in Colors Panel where we will include additional custom Color setting and controls
 *
 */

//add line line break and description below existing controls
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'simplystrata_custom_content' ) ) :
class simplystrata_custom_content extends WP_Customize_Control {

	// Whitelist content parameter
	public $content = '';

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function render_content() {
		if ( isset( $this->label ) ) {
			echo '<span class="customize-control-title">' . $this->label . '</span>';
		}
		if ( isset( $this->content ) ) {
			echo $this->content;
		}
		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}
	}
}
endif;
 

// add additionl options
add_action('customize_register','javahat_customizer_options');

function javahat_customizer_options( $wp_customize ) 
	{	
		
	//***********************************
	//header color control
	//***********************************
	$wp_customize->add_setting(
 		'javahat_header_color', //give it an ID
 		array(
 			'default' => '#333333', // Give it a default
 		)
 	);

 	$wp_customize->add_control(
 		new WP_Customize_Color_Control(
 			$wp_customize,
 			'javahat_custom_header_color', //give it an ID
 			array(
 				'label' => __( 'Header Color', 'simply-strata' ), //set the label to appear in the Customizer
 				'section' => 'colors', //select the section for it to appear under 
 				'settings' => 'javahat_header_color', //pick the setting it applies to
 				'priority' => 21,
 			)
 		)
 	);
 	
 		//***********************************
 		//main menu color control
 		//***********************************
 		$wp_customize->add_setting(
 	 		'javahat_main_menu_color', //give it an ID
 	 		array(
 	 			'default' => '#000000', // Give it a default
 	 		)
 	 	);
 	
 	 	$wp_customize->add_control(
 	 		new WP_Customize_Color_Control(
 	 			$wp_customize,
 	 			'javahat_custom_main_menu_color', //give it an ID
 	 			array(
 	 				'label' => __( 'Main Menu Color', 'simply-strata' ), //set the label to appear in the Customizer
 	 				'section' => 'colors', //select the section for it to appear under 
 	 				'settings' => 'javahat_main_menu_color', //pick the setting it applies to
 	 				'priority' => 23,
 	 			)
 	 		)
 	 	);

	//***********************************
	//sidebar color control
	//***********************************
	$wp_customize->add_setting(
 		'javahat_sidebar_color', //give it an ID
 		array(
 			'default' => '#333333', // Give it a default
 		)
 	);

 	$wp_customize->add_control(
 		new WP_Customize_Color_Control(
 			$wp_customize,
 			'javahat_custom_sidebar_color', //give it an ID
 			array(
 				'label' => __( 'Sidebar Color', 'simply-strata' ), //set the label to appear in the Customizer
 				'section' => 'colors', //select the section for it to appear under 
 				'settings' => 'javahat_sidebar_color', //pick the setting it applies to
 				'priority' => 22,
 			)
 		)
 	);
 	
 	//***********************************
 	// Add html above custom settings
 	//***********************************
 	$wp_customize->add_setting( 'example-control', array() );
 	
 	$wp_customize->add_control( new simplystrata_custom_content( $wp_customize, 'example-control', array(
 		'section' => 'colors',
 		'priority' => 20,
 		'content' => __( '<hr>', 'simply-strata' ) . '</p>',
 		'description' => __( '<h2>Additional Colors</h2>', 'simply-strata' ),
 	) ) );

	}

add_action( 'wp_head', 'javahat_customize_css' );


/*
 * Output our custom Color settings CSS Style
 *
 */
function javahat_customize_css() {
 ?>
 <style type="text/css">
 #secondary { background-color:<?php echo get_theme_mod( 'javahat_sidebar_color', '#333333' ); // add in your add_settings ID and default value ?>; }
 .site-header { background: url(<?php echo get_header_image()?>) center no-repeat, <?php echo get_theme_mod( 'javahat_header_color', '#333333' ); ?>;}
  
  #menu-right { background-image: linear-gradient(<?php echo get_theme_mod( 'javahat_main_menu', '#e023ca' ); ?>, #111); }
 </style>
  <?php
 }


?>