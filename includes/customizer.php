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



function simplystrata_customize_register( $wp_customize ) 
	{
	
	// section for contact details
	$wp_customize->add_section( 'simplystrata_contact' , array(
	'title' => __( 'Contact Details', 'simply-strata')
	) );
	
	// section for colors 
	$wp_customize->add_section( 'simplystrata_colors', array(
	'title' => __( 'Color Scheme', 'simply-strata' )
	));
	
	// add default control setup
	class simplystrata_Customize_Textarea_Control extends WP_Customize_Control 
		{
		public $type = 'textarea';
		public function render_content() 
			{
			echo '<label>';
			echo '<span class="customize-control-title">' . esc_html( $this-> label ) . '</span>';
			echo '<textarea rows="2" style ="width: 100%;"';
			$this->link();
			echo '>' . esc_textarea( $this->value() ) . '</textarea>';
			echo '</label>';
			}
		}
		
	// Add controls for address, and email address.
	
	// address control 
	$wp_customize->add_setting( 'simplystrata_address_setting', array ( 'default' => __( 'Building address', 'simply-strata' ) ) );
	$wp_customize->add_control( new simplystrata_Customize_Textarea_Control(
		$wp_customize,
		'simplystrata_address_setting',
		array( 
			'label' => __( 'Address', 'simply-strata' ),
			'section' => 'simplystrata_contact',
			'settings' => 'simplystrata_address_setting'
			)
		));
	
	//email control
	$wp_customize->add_setting( 'simplystrata_email_setting', array ( 'default' => __( 'Your email address', 'simply-strata' ) ) );
	$wp_customize->add_control( new simplystrata_Customize_Textarea_Control(
	$wp_customize,
		'simplystrata_email_setting',
		array( 
			'label' => __( 'Email', 'simply-strata' ),
			'section' => 'simplystrata_contact',
			'settings' => 'simplystrata_email_setting'
			)
		));
		
	// Add color controls and settings. 
	
	// main color - site title, h1, h2, h4, widget headings, nav links, footer background
	$textcolors[] = array(
	'slug' => 'simplystrata_color',
	'default' => '#1a1a1a',
	'label' => __( 'Main color', 'simply-strata' )
	);
	
	// main background color
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor',
	'default' => '#1a1a1a',
	'label' => __( 'Main Background Color', 'simply-strata' )
	);
	
	// top sidebar background color
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor_sidebar_top',
	'default' => '#fefdca',
	'label' => __( 'Top Sidebar Color', 'simply-strata' )
	);
	
	// top sidebar background color2
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor_sidebar_top2',
	'default' => '#f7f381',
	'label' => __( 'Top Sidebar Gradient Color', 'simply-strata' )
	);
	
	// main menu color
	$textcolors[] = array(
	'slug' => 'simplystrata_color_menu',
	'default' => '#999999',
	'label' => __( 'Menu Color', 'simply-strata' )
	);
	
	// main menu border color
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor_menu_border',
	'default' => '#222222',
	'label' => __( 'Menu Border Color', 'simply-strata' )
	);
	
	// main menu background color
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor_menu',
	'default' => '#444444',
	'label' => __( 'Menu Background Color', 'simply-strata' )
	);
	
	// breadcrumbs background color
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor_breadcrumbs',
	'default' => '#eeeeee',
	'label' => __( 'Breadcrumbs Background Color', 'simply-strata' )
	);
	
	// content background color
	$textcolors[] = array(
	'slug' => 'simplystrata_bgcolor_content',
	'default' => '#ffffff',
	'label' => __( 'Content Background Color', 'simply-strata' )
	);
	
	// link color
	$textcolors[] = array(
	'slug' => 'simplystrata_color_link',
	'default' => '#531fff',
	'label' => __( 'Links Color', 'simply-strata' )
	);
	
	// link color in banner
	$textcolors[] = array(
	'slug' => 'simplystrata_color_link_banner',
	'default' => '#68b7fe',
	'label' => __( 'Links color (Site Title)', 'simply-strata' )
	);
	
	// link color in banner and footer
	$textcolors[] = array(
	'slug' => 'simplystrata_color_link_footer',
	'default' => '#999999',
	'label' => __( 'Links color (in footer)', 'simply-strata' )
	);
	
	// link color on hover
	$textcolors[] = array(
	'slug' => 'simplystrata_color_link_hover',
	'default' => '#686868',
	'label' => __( 'Links color (on hover)', 'simply-strata' )
	);
	
	// Set up the variables to loop through each color and set up a setting and control
	
	foreach ( $textcolors as $textcolor ) 
		{
		// settings
		$wp_customize->add_setting(
		$textcolor[ 'slug' ], array (
		'default' => $textcolor[ 'default' ],
		'type' => 'option'
		)
		);
		
		// controls
		$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		$textcolor[ 'slug' ],
		array (
		'label' => $textcolor[ 'label' ],
		'section' => 'simplystrata_colors',
		'settings' => $textcolor[ 'slug' ]
		)
		));
		}
	}
 
 add_action( 'customize_register', 'simplystrata_customize_register' );
 
 // Create the function for the color scheme which will hook into the wp_head action hook.
 function simplystrata_add_color_scheme() 
 	{
   $color = get_option( 'simplystrata_color' );
   $color_bg = get_option( 'simplystrata_bgcolor' );
   $color_menu = get_option( 'simplystrata_color_menu' );
   $color_sidebar_top = get_option( 'simplystrata_bgcolor_sidebar_top' );
   $color_sidebar_top2 = get_option( 'simplystrata_bgcolor_sidebar_top2' );
   $color_bg_menu = get_option( 'simplystrata_bgcolor_menu' );
   $color_bg_menu_border = get_option( 'simplystrata_bgcolor_menu_border' );
   $color_bg_breadcrumbs = get_option( 'simplystrata_bgcolor_breadcrumbs' );
   $color_bg_content = get_option( 'simplystrata_bgcolor_content' );
   $color_link = get_option( 'simplystrata_color_link' );
   $color_link_banner = get_option( 'simplystrata_color_link_banner' );
   $color_link_footer = get_option( 'simplystrata_color_link_footer' );
   $color_link_hover = get_option ( 'simplystrata_color_link_hover' );
   
   ?>
   <style>
   
   /* main color */
   h1,
   h2,
   h2.page-title,
   h2.post-title,
   h1 a:link,
   h1 a:visited,
   h2 a:link,
   h2 a:visited,
   body
   	{
   	color: <?php echo $color; ?>;
   	}
   
   /* main background color */
   body,
   footer
    {
   	background: <?php echo $color_bg; ?>;
   	}
   	
   .site-header { background: url('<?php echo get_header_image()?>') center no-repeat, <?php echo get_theme_mod( 'simplystrata_header_color', '#333333' ); ?>;}
   
   
   /* Sidebar top color */
   .sidebar-header
    {
   	background: -moz-linear-gradient(top, <?php echo $color_sidebar_top; ?> 0%, <?php echo $color_sidebar_top2; ?> 100%); /* FF3.6+ */
   	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $color_sidebar_top; ?>), color-stop(100%,<?php echo $color_sidebar_top2; ?>)); /* Chrome,Safari4+ */
   	background: -webkit-linear-gradient(top, <?php echo $color_sidebar_top; ?> 0%,<?php echo $color_sidebar_top2; ?> 100%); /* Chrome10+,Safari5.1+ */
   	background: -o-linear-gradient(top, <?php echo $color_sidebar_top; ?> 0%,<?php echo $color_sidebar_top2; ?> 100%); /* Opera11.10+ */
   	background: -ms-linear-gradient(top, <?php echo $color_sidebar_top; ?> 0%,<?php echo $color_sidebar_top2; ?> 100%); /* IE10+ */
   	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $color_sidebar_top; ?>', endColorstr='<?php echo $color_sidebar_top2; ?>',GradientType=0 ); /* IE6-9 */
   	background: linear-gradient(top, <?php echo $color_sidebar_top; ?> 0%,<?php echo $color_sidebar_top2; ?> 100%); /* W3C; A catch-all for everything else */
   	}	
   
   /* menu colors */
   #menu
    {
	 	border-top: 1px solid <?php echo $color_bg_menu_border; ?>;
	 	border-bottom: 1px solid <?php echo $color_bg_menu_border; ?>;
   	background-image: linear-gradient(<?php echo $color_bg_menu_border; ?> 0%, <?php echo $color_bg_menu; ?> 10%, <?php echo $color_bg_menu; ?> 60%, <?php echo $color_bg_menu_border; ?> 100%);
   }
   
   #menu li
   	{
   	border: none;
   	}
   
   #menu a:link,
   #menu a:visited
   	{
   	
   		color: <?php echo $color_menu; ?>;
   	}
   
   /* breadcrumbs beckground color */
   #breadcrumbs
    {
   	background: <?php echo $color_bg_breadcrumbs; ?>;
   	border-bottom: 1px solid <?php echo $color_bg_breadcrumbs; ?>;
   	}
   
   /* content background color */
   #page
    {
   background: <?php echo $color_bg_content; ?>;
   }
   
   /* links color */
   a:link,
   a:visited,
   .sidebar a:link,
   .sidebar a:visited,
   .bttn-submit 
   {
   color: <?php echo $color_link; ?>;
   } 

	.bttn-submit 
		{
		border-color: <?php echo $color_link; ?>;
		} 

   
   /* banner link color */
   .site-title a:link,
   .site-title a:visited,
   .status-bar a:link,
   .status-bar a:visited
   	{
   	color: <?php echo $color_link_banner; ?>;
   	}
   	
   	/* footer link color */
   	.site-footer a:link,
   	.site-footer a:visited
   		{
   		color: <?php echo $color_link_footer; ?>;
   		}  
   
   /* links hover color */
   a:hover,
   a:active,
   .sidebar a:hover,
   .sidebar a:active,
   .site-title a:hover,
   .site-title a:active
    {
   color: <?php echo $color_link_hover; ?>;
   }
   </style>
 
 <?php }
 add_action( 'wp_head', 'simplystrata_add_color_scheme' );	

?>