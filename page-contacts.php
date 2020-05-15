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
 * Template Name: Contacts
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
<main>
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
			
			global $post;
			 $page_slug = $post->post_name;
			?>
			
			<!-- Page Title -->
			<div class="entry-header">
				<?php  
				the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
				?>
			</div><!-- .entry-header -->
			
			
			<!-- Page Content -->
			<div class="entry-content">
				<?php
			
			get_template_part( 'template-parts/contact', get_post_format() );
			
			?>
			</div> <?php
			}
		?>
		
	</article><!-- #post-## -->
</main>

<!-- ****************** LEFT SIDEBAR ****************** -->

<?php get_sidebar(); ?>

<!-- 
***************************************************************************************
FOOTER
***************************************************************************************
-->
<?php get_footer(); ?>
