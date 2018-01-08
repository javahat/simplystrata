<?php
/**
 * The home page template include
 *
 * Sets custom message based on user role.
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */

// Disply if user is logged in
if ( is_user_member_of_blog( get_current_user_id(), get_current_blog_id() ) )
	{
	//set user variables
	global $wp_roles;
	$current_user = wp_get_current_user();
	$current_name = $current_user->first_name;
	$roles = $current_user->roles;
	$current_role = array_shift( $roles );
	$current_role = ucfirst($current_role);
	$current_unit = $current_user->unit;
	$securecontent = get_post_meta( get_the_ID(), 'simplystrata_securecontent', true );
	$securecontent2 = get_field('secure_content'); 
	$site_name = get_bloginfo( 'name' );
	
	// Welcome content to ALL logged in users
	echo 'Welcome ' . $current_name . '! You are viewing the <strong>'. $site_name . '</strong> website with <strong>' . $current_role . '</strong> permission. '; 
	
	// Content only visible to users logged in but without private page privileges 
	if (! current_user_can('read_private_pages')) 
		{
		echo 'You have some access to this site but you are mostly seeing the public information with contact information.<br><br>'; 
		}
	
	// Content visible to all other logged in users (owner, strata council, admin)
	else 
		{ 
		echo 'You are able to access private documents such as minutes of strata council, Annual or Special General Meetings and other important documents specific to owners at ' . $site_name . '.<br>'; 
		}
		
	// Secure content visible to all users with read_private_pages access
	if ( current_user_can('read_private_pages') && ( $securecontent != '' || $securecontent2 != '' ))	 
		{
		echo $securecontent . $securecontent2;
		
		}
	}
	
// Display if user is not logged in, does not have read private content, or no secure content is found
elseif (! is_user_member_of_blog( get_current_user_id(), get_current_blog_id() ) || ! current_user_can('read_private_pages') || $securecontent == '') 
	{
	the_content( sprintf(
		__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'simply-strata' ),
		get_the_title()
	) );
	
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'simply-strata' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'simply-strata' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
	}	
	
if ( is_user_member_of_blog( get_current_user_id(), get_current_blog_id() ) ) 
	{ 
	get_template_part( 'template-parts/post-notices', get_post_format() ); 
	
	//$recent_posts = get_field('recent_posts'); 
	//$upcoming = get_field('upcoming'); 
	
	//if ( $recent_posts) { echo '<div class="sectionleft"><h2>Recent Posts</h2>' . $recent_posts . '</div>'; }
	//if ( $upcoming ) { echo '<div class="sectionright"><h2>Upcoming</h2>' . $upcoming . '</div>'; }
	}
?>	