<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */
?>

<!-- 
***************************************************************************************
HEADER COLUMN
***************************************************************************************
-->
<?php get_header(); ?>

<!-- 
***************************************************************************************
MAIN CONTENT (site content and sidebar)
***************************************************************************************
-->	
<main class="full-width">
	<!-- Main content is an article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<!-- ****************** MAIN CONTENT ****************** -->
		<?php 
		while ( have_posts() )
			{
			the_post();
			
			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );
			
			// get page id
			$postid = get_the_ID();
			echo 'Page ID: ' . $postid;
			echo '<br><br>Role Capabilities:<br>';
			
			/*
			// Add capability to role
			// https://codex.wordpress.org/Function_Reference/add_cap
			$role = get_role( 'council' );
			$role->add_cap( 'delete_others_posts' );
			*/
			
			
			// List all capabilities of current user
			// https://isabelcastillo.com/list-capabilities-current-user-wordpress
			
			 $data = get_userdata( get_current_user_id() );
			//$data = get_role( 'council' );
			 
			if ( is_object( $data) ) {
			    $current_user_caps = $data->allcaps;
			     
			    // print it to the screen
			    echo '<pre>' . print_r( $current_user_caps, true ) . '</pre>';
				}
				
			//$user = new WP_User( $user_id );
			//$user->add_cap( 'can_edit_posts' );			        
			}
			
			
		?>
		
	</article><!-- #post-## -->
</main>

<!-- 
***************************************************************************************
FOOTER
***************************************************************************************
-->
<?php get_footer(); ?>
