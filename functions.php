<?php

/**
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 
 * Text Domain: simply-strata
 * Domain Path: /languages
 */
 
/*********************************************************************************
link to seperate include files
*********************************************************************************/
//require_once "wp-content/themes/simply-strata/includes/aria-walker-nav-menu.php";

include( get_stylesheet_directory() . '/includes/breadcrumbs.php' );
include( get_stylesheet_directory() . '/includes/customizer.php' );
include( get_stylesheet_directory() . '/includes/pages.php' );
//require get_template_directory() . '/inc/template-tags.php';
//require get_template_directory() . '/inc/customizer.php';


//
//Prevent cross-site login
//********************************************************************************
//
//function validate_on_login(){
//  if (!is_user_logged_in()) {
//     return;
//  }
//
//  $user = wp_get_current_user();
//
//  allow only login if user is member of this blog
//
//  if (!is_user_member_of_blog( $user->ID, get_current_blog_id() ) && !is_super_admin( $user->ID )) {
//    wp_logout();
//    wp_redirect(network_site_url());exit();
//  }
//
//}
//add_action('authenticate', array($this, 'validate_on_login'), 100, 3);

/********************************************************************************
Enqueue scripts and styles  
@since Simply Strata 1.0
*********************************************************************************/
if (!function_exists('simplystrata_enqueue_styles')) {
	function simplystrata_enqueue_styles() {
		wp_enqueue_style('simply-strata-style', get_template_directory_uri() . '/style.css', false, '20170111');
		wp_enqueue_script( 'simply-strata-html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '20170111' );
		wp_enqueue_script( 'simply-strata-custom-js', get_template_directory_uri() . '/js/simply-strata.js', array(), '20180316', true );
		if ( is_singular() && wp_attachment_is_image() ) 
			{
			wp_enqueue_script( 'simply-strata-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
			}	
		}
	}
add_action('wp_enqueue_scripts', 'simplystrata_enqueue_styles');

/********************************************************************************
Register Google fonts for Simply Strata 
@since Simply Strata 1.0
*********************************************************************************/

if ( ! function_exists( 'simplystrata_fonts_url' ) ) :

function simplystrata_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open+Sans font: on or off', 'simply-strata' ) ) {
		$fonts[] = 'Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i';
	}
	
	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'simply-strata' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;
 
/********************************************************************************
 Sets up theme defaults and registers support for various WordPress features.
 Adapted from wpmu intermediate course
 @since Simply Strata 1.0
********************************************************************************/
function simplystrata_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/simply-strata
	 */
	load_theme_textdomain( 'simply-strata' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Simply Strata 1.2
	 */
		
	add_theme_support( 'custom-logo' );
	
	function simplystrata_custom_logo_setup() 
		{
	  $defaults = array(
			'height'      => 240,
			'width'       => 400,
			'flex-width' => true,
			'header-text' => array( 'site-title', 'site-description' ),
    	);
    add_theme_support( 'custom-logo', $defaults );
		}
	add_action( 'after_setup_theme', 'simplystrata_custom_logo_setup' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'simply-strata' ),
		'social'  => __( 'Social Links Menu', 'simply-strata' ),
		'footer'  => __( 'Footer Menu', 'simply-strata' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'meeting',
		'notice',
		'link',
		'aside',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', simplystrata_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'simplystrata_setup' );


/********************************************************************************
 Add widgetized areas or sidebars
*********************************************************************************/
function simplystrata_widgets_init() {
	
		register_sidebar( array(
	     'name' => __( 'Header Sidebar', 'simply-strata' ),
	     'id' => 'header-sidebar',
	     'description' => __( 'Slide down sidebar in the header', 'simply-strata' ),
	     'before_widget' => '<div class="sidebar-header-section">',
	     'after_widget' => '</div>',
	     'before_title' => '<div class="title">',
	     'after_title' => '</div>',
	 ) ); 
	 
	  register_sidebar( array(
	     'name' => __( 'Content Sidebar', 'simply-strata' ),
	     'id' => 'sidebar-content',
	     'description' => __( 'Sidebar in page content', 'simply-strata' ),
	     'before_widget' => '<div class="sidebar-content-section">',
	     'after_widget' => '</div>',
	     'before_title' => '<h2>',
	     'after_title' => '</h2>',
	 ) );  
	
} 


add_action( 'widgets_init', 'simplystrata_widgets_init' );


/********************************************************************************
 Add custom image size attribute to enhance responsive image functionality
 Function adapted from Twenty Sixteen Template
 @since Simply Strata 1.0
 
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
*********************************************************************************/
function simplystrata_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 840 <= $width ) {
		$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	}

	if ( 'page' === get_post_type() ) {
		if ( 840 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	} else {
		if ( 840 > $width && 600 <= $width ) {
			$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		} elseif ( 600 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'simplystrata_content_image_sizes_attr', 10 , 2 );

function simplystrata_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		} else {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'simplystrata_post_thumbnail_sizes_attr', 10 , 3 );

/********************************************************************************
 Modifies tag cloud widget arguments to display all tags in the same font size
 and use list format for better accessibility.
 @since Simply Strata 1.0
 
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
*********************************************************************************/
function simplystrata_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list'; 

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'simplystrata_widget_tag_cloud_args' );

/********************************************************************************
Handles JavaScript detection.
@since Simply Strata 1.0
*********************************************************************************/
function simplystrata_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'simplystrata_javascript_detection', 0 );


/********************************************************************************
Remove Query strings from static resources
@since Simply Strata 1.0
https://kinsta.com/knowledgebase/remove-query-strings-static-resources/#remove-query-string-code
*********************************************************************************/
function _remove_script_version( $src ){ 
$parts = explode( '?', $src ); 	
return $parts[0]; 
} 
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 ); 
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

/********************************************************************************
Advanced Custom Fields Settings
@since Simply Strata 1.0
https://www.advancedcustomfields.com/blog/acf-has-settings/
*********************************************************************************/

function simplystrata_acf_init() {
	acf_update_setting('capability', 'delete_pages');
	acf_update_setting('remove_wp_meta_box', true);
}

add_action('acf/init', 'simplystrata_acf_init');



global $wp_roles;
$current_user = wp_get_current_user();
$current_name = $current_user->first_name;
$roles = $current_user->roles;
$current_role = array_shift( $roles );

if ( $current_role == 'owner' )
	{
	function remove_menus()
		{
  	remove_menu_page( 'index.php' );                  //Dashboard
  	remove_menu_page( 'edit.php' );                   //Posts
  	}
  add_action( 'admin_menu', 'remove_menus' );
  }
  
//if ( $current_role == 'council' )
//	{
//	function remove_menus()
//		{
//	  remove_menu_page( 'index.php' );                  //Dashboard
//	  remove_menu_page( 'edit-comments.php' );          //Comments
//	  remove_menu_page( 'tools.php' );                  //Tools
//	  add_menu_page( 'users.php' );                  //Users
//	  //remove_menu_page( 'edit.php' );                   //Posts
//	  //remove_menu_page( 'jetpack' );                    //Jetpack* 
//	  //remove_menu_page( 'upload.php' );                 //Media
//	  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
//	  //remove_menu_page( 'themes.php' );                 //Appearance
//	  //remove_menu_page( 'plugins.php' );                //Plugins
//	  //remove_menu_page( 'users.php' );                  //Users
//	  //remove_menu_page( 'options-general.php' );        //Settings
//	  }
//	add_action( 'admin_menu', 'remove_menus' );
//	}
	
// hide test page
// https://www.johnparris.com/how-to-hide-pages-in-the-wordpress-admin/
function jp_exclude_pages_from_admin($query) {
 
  if ( ! is_admin() )
    return $query;
 
  global $pagenow, $post_type;
 
  if ( !current_user_can( 'administrator' ) && $pagenow == 'edit.php' && $post_type == 'page' )
    $query->query_vars['post__not_in'] = array( '278' ); // Enter your page IDs here
  
 
}
add_filter( 'parse_query', 'jp_exclude_pages_from_admin' );

/********************************************************************************
removes profile options
@since Simply Strata 1.0
https://www.lockedowndesign.com/add-new-fields-to-wordpress-user-profiles/
*********************************************************************************/

if ( ! function_exists( 'ld_modify_contact_methods' ) ) :

    function ld_modify_contact_methods( $contactmethods ) {
        //$contactmethods['linkedin'] = __( 'Linked In' );
        //$contactmethods['youtube'] = __( 'YouTube' );
        //$contactmethods['instagram'] = __( 'Instagram' );
        unset($contactmethods['facebook']);
        unset($contactmethods['twitter']);
        unset($contactmethods['googleplus']);
        unset($contactmethods['profile']);

        return $contactmethods;
    }
    add_filter('user_contactmethods','ld_modify_contact_methods', 10, 1);

endif;

/********************************************************************************
Add login/logout button to primary navigation
@since Simply Strata 1.1
2018-12-21 https://wordpress.stackexchange.com/questions/156217/add-logout-link-to-navigation-menu
*********************************************************************************/
add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );

function wti_loginout_menu_link( $items, $args ) {
   if ($args->theme_location == 'primary') {
      if (is_user_logged_in()) {
         $items .= '<li class="right"><a href="'. wp_logout_url(get_permalink()) .'">'. __("Log Out") .'</a></li>';
      }
   }
   return $items;
}

/********************************************************************************
Prevent Cross Site Authentication 
@since Simply Strata 1.0
https://really-simple-plugins.com/prevent-cross-site-authentication-for-logged-in-users-on-wordpress-multisite/
*********************************************************************************/

// https://developer.wordpress.org/reference/hooks/authenticate/
// https://codex.wordpress.org/Function_Reference/get_current_blog_id




//add_filter( 'wp_authenticate', 'myplugin_auth_signon', 30, 3 );
//function myplugin_auth_signon( $user, $username, $password ) {
//     
//     if  (!is_user_member_of_blog( get_current_user_id(), get_current_blog_id() )) {
//         // TODO what should the error message be? (Or would these even happen?)
//         // Only needed if all authentication handlers fail to return anything.
//         $user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Invalid username, email address or incorrect password.' ) );
//     }
//     
//     return $user;
//     
//}
 



/********************************************************************************
Disable Comments in Theme
@since Simply Strata 1.0
https://gist.github.com/mattclements/eab5ef656b2f946c4bfb
*********************************************************************************/


//add_filter( 'simple_history/log_query_inner_where', function($where) {
//    		global $wpdb;
//    		if (isset($_GET['editUser'])) {
//    			$user_id = $_GET['editUser'];
//    		}else{
//    			$user_id = get_current_user_id();
//    		}
//			$where .= sprintf('
//			AND id IN (
//
//				SELECT id
//					# , c1.history_id, c2.history_id
//				FROM %1$s AS h
//
//				INNER JOIN %2$s AS c2
//					ON c2.history_id = h.id
//					AND c2.key = "user_id"
//					AND c2.value = "%3$s"
//
//			)
//			', $wpdb->prefix.'simple_history', $wpdb->prefix.'simple_history_contexts', $user_id);
//
//			return $where;
//    	} );

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}


