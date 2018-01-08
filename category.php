<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * Template Name: Default Category Page
 * Template Post Type: post
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
<?php 
if ( is_active_sidebar('sidebar-content') ) { echo '<main>'; }
else { echo '<main class="full-width">'; }
?>
	<!-- Main content is an article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<!-- ****************** MAIN CONTENT ****************** -->
		
			<!-- Page Title -->
			<div class="entry-header">
				<?php  
				echo '<h1 class="entry-title">List of All ';
				if (!current_user_can('read_private_posts') ) { echo 'public'; } 
				echo ' Documents Posted</h1>';
				?>
			</div><!-- .entry-header -->
			
			
			<!-- Page Content -->
			<div class="entry-content">
				<?php 
				//get_template_part( 'template-parts/post-page-documents', get_post_format() );
				get_template_part( 'template-parts/post-categories', get_post_format() );				?>
			</div>

		
	</article><!-- #post-## -->
</main>

<!-- ****************** RIGHT SIDEBAR ****************** -->

<?php get_sidebar(); ?>

<!-- 
***************************************************************************************
FOOTER
***************************************************************************************
-->
<?php get_footer(); ?>
