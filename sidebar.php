<?php
/**
 * The template for displaying the sidebar
 *
 * Includes the sidebar if active
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-content' )  ) : ?>
	<aside class="sidebar" role="complementary">
		<div class="sidebar-content">
			<?php dynamic_sidebar( 'sidebar-content' ); ?>
			
			<?php if ( is_user_logged_in() && ( is_page('rules') || is_page('bylaws') ) ) 
				{ $changelog = get_field('changelog'); 
				// check for rows (parent repeater)
				if( have_rows('changelog') )
					{
					echo '<div class="sidebar-content-section"><h2 class="title">Changelog</h2><div class="textwidget"><ul class="note">';
					while( have_rows('changelog') )
						{ 
						the_row();
						echo '<li>';
						echo the_sub_field('log');
						echo '</li>';
						}
					echo '</ul></div></div>'; }
					} 
				?>
			</div>
			
		</div>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
