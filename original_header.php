<?php 
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up to and including the menu.
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */
 ?>
 
 <!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script src="https://use.fontawesome.com/f8f3e0aba9.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a href="#page" class="skip">Skip to content</a>
	<!-- 
	***************************************************************************************
	PAGE HEADER
	***************************************************************************************
	-->
	<header>
		<!-- 
		*************************************************************************************
		PAGE HEADER - STATUS BAR (login status and date)
		-->
		<div class="status-bar" role="region" aria-label="Status Bar">
			<!-- display icon with user name and role along left -->
			<i class="fa left fa-user-circle-o aria-hidden='true'">
			
				<?php 
				//if user is logged in
				if ( is_user_logged_in() )			 
					{
					global $wp_roles;
					$current_user = wp_get_current_user();
					$current_name = $current_user->first_name;
					$roles = $current_user->roles;
					$current_role = array_shift( $roles );
					$current_role = ucfirst($current_role);
					$current_unit = preg_replace("/[^0-9,.]/", "", $current_user->user_login);
					//$current_unit = $current_user->user_login;
					
					//Detect whether user is a unit number or not and display message
					if ($current_role == 'Owners') { echo 'Hello ' . $current_name; }
					elseif (!preg_match("/[0-9]/i", $current_unit)) { 
					echo 'Hello ' . $current_name . '. You are logged in as ' . $current_role . '. '; }
					else { echo 'Hello ' . $current_name . ' (' . $current_role . ' from unit ' . $current_unit . ') '; }
					
					if ($current_role == 'Owner') { echo '<a href="' . get_edit_user_link() . '">Update Profile</a> '; }
					
					}
						
				//if user is not logged in
				else { echo 'You must <a href="' . home_url() . '">log in</a> to view private information. '; }
				
				edit_post_link(' Edit Content'); 
				
				if ( is_user_logged_in() ) { echo ' | <a href="' . wp_logout_url(get_permalink()) . '">Logout »</a>'; }?>
			</i>
			
			<!-- display icon with date on right -->
			<i class="fa right fa-calendar aria-hidden="true""><?php date_default_timezone_set('America/Vancouver'); echo date("M d, Y") ?></i>
						
			<!-- insert google translator -->
			<?php echo do_shortcode('[gtranslate]'); ?>
		</div>

		<!-- 
		*************************************************************************************
		PAGE HEADER - BANNER (site identity and header sidebar)
		-->
		<div class="site-header">
			<!-- 
			***********************************************************************************
			PAGE HEADER - BANNER - SITE IDENTITY (logo, title, and description of site as specified in customizer)
			-->
			<?php 
			//if the function exists, display the logo
			if ( has_custom_logo() ) { the_custom_logo(); }
			
			if ( display_header_text() ) 
				{
				?>
				<div class="site-identity" role="region" aria-label="Site Identity (name, description, logo)">
				<!-- Insert logo from customizer -->
				<?php 				
				// if no logo, display title instead	
				if ( !has_custom_logo() ) 
					{ ?>
				     <span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
					<?php
					}
					
				// Insert description from site identity in customizer if entered
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() )
					{
					echo '<p class="site-description">' . $description . '</p>';
					}
				?>					
					
			</div> <!-- END site-identity div -->
			<?php } ?>
			
			<!-- 
			*********************************************************************************
			PAGE HEADER - BANNER - HEADER SIDEBAR (sidebar in header)
			* Name: sidebar-header
			* Location: right of page banner
			-->
			<?php if ( is_active_sidebar( 'header-sidebar' ) || is_front_page() ) : ?>
				<div class="sidebar-header"role="region" aria-label="Banner Sidebar">
					<div id="sliding-note" <?php if ( is_front_page() ) { echo 'class="open"'; } elseif ( !is_front_page() ) { echo 'class="closed"'; } ?> >
						<?php dynamic_sidebar( 'header-sidebar' ); 
						if ( is_user_logged_in() )
							{
							$recent_posts = get_field('recent_posts'); 
							$upcoming = get_field('upcoming'); 
							if ( $recent_posts) { echo '<div class="sidebar-header-section"><h2 class="title">Recent Posts</h2><div class="textwidget">' . $recent_posts . '</div></div>'; }
							if ( $upcoming ) { echo '<div class="sidebar-header-section"><h2 class="title">Upcoming</h2><div class="textwidget">' . $upcoming . '</div></div>'; }
							} 
						?>
					</div>
					<button id="showTop" onclick="simplystrataSlider()">&#8693; Click to Toggle Notes</button>
				</div>
			<?php endif; ?>
		</div>
					
		<!-- 
		***********************************************************************************
		PAGE HEADER - MAIN MENU
		-->
		<!-- Desktop Menu -->
		<nav role="navigation" aria-label="<?php _e( 'Main Menu', 'simply-strata' ); ?>">
			<?php 
			wp_nav_menu( array( 
				'theme_location' => 'primary', 
				'container' => '', 
				'menu_id' => 'menu', 
				'menu_class' => '' ,
				//'walker' => new Aria_Walker_Nav_Menu(),
			) ); 
			?>
		</nav>
		
		<!-- Mobile Menu is not yet built in. We recommend installing a mobile plugin at this time. -->
		
		<!-- 
		***********************************************************************************
		PAGE HEADER - BREADCRUMBS
		-->
		<div class="breadcrumbs" role="region" aria-label="Breadcrumbs location within the website">
			<?php custom_breadcrumbs(); ?>
		</div>
	
	</header>
	<!-- 
	***************************************************************************************
	END OF PAGE HEADER
	***************************************************************************************
	-->
	
	<div id="page" class="site-content">