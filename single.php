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
 * Template Name: Right Sidebar
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
<?php get_header();?>



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
		<?php 
		while ( have_posts() )
			{
			the_post();
			
			// Get base url for internal links
			$url = get_site_url();
			
			// vars
			$posted = get_the_date();
			$author = get_the_author();
			$document_type = get_field('document_type');
			$meeting_type = get_field('meeting_type');
			$meeting_date = get_field('meeting_date');
			$council = get_field('document_privacy_council');
			$public = get_field('document_privacy');
			$published_location = get_field('published_location');
			$add_pdf = get_field('document_pdf');
			$add_translation = get_field('document_translation');
			$add_doc = get_field('document_doc');
			$add_xls = get_field('document_xls');
			$last_revised = get_field('last_revised');
			
			$title = get_the_title();
			
			// embed document if not empty
			$embed_pdf = '<span style="margin-right: auto; margin-left="auto;"><object data="' . $add_pdf . '#pagemode=thumbs&scrollbar=1&toolbar=1&statusbar=1&messages=1&navpanes=1" 
				        type="application/pdf" 
				        width="600px" 
				        height="700px">
				<p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="' . $url . '">Download PDF</a></p>
				</object></span>';
			
			if ( ! current_user_can('read_private_posts') &&  !$public  ) { echo '<h1>Document: ' . $title . '</h1><p>It appears that you are trying to take shortcuts!</p><p>Unfortunately this is a private document and you must log in to view it.</p>'; } 
            
            
//            elseif ( $document_type == 'Council Only Document' && (!strstr($current_role, 'council')) ) 
//            { echo '<div class="message"><h1>Document: ' . $title . '</h1><p>It appears that you are trying to take shortcuts!</p><p>Unfortunately this is a private document for council members only. You are viewing with ' . $current_role . ' priviledges.</p></div>';}
            
            else { ?> 
			<h1 class="center"><?php echo 'Document: ' . $title ; ?></h1>
			<table class="single-post">
				<thead><tr><th class="title" colspan="2">Document Details</th></tr></thead>
				<!-- Required: Post Info and Document Type -->
				<tr scope="row"><th>Document Type</th><td>
					<?php 
					echo $document_type;
					if ( $document_type == 'Council Only Document' ) { echo ' <i>(Only for Council Members)</i>'; } 
					else if ( $public ) { echo ' <i>(Public document)</i>'; } 
					else { echo ' <i>(Private document - Only for Owners)</i>'; } 
					?>
				</td></tr>
				
				<!-- Optional: Meeting Document Information -->
				<?php if ( $document_type == 'Meeting Minutes' ) 
					{ 
					echo '<tr scope="row"><th>Meeting Details</th><td>' . $meeting_type . ' held on ' . $meeting_date . '</td></tr>';
					}
				
				if ( $last_revised) { ?>
				<tr scope="row"><th>Last Revised</th><td><?php echo $last_revised; ?></td></tr>
                <? } ?>
				<tr scope="row"><th>Date Posted</th><td><?php echo $posted . ' by ' . $author; ?></td></tr>
				
				<!-- Document Posted at -->
				<?php 
				echo '<tr scope="row"><th>Posted To</th><td>'; 
				if ( $document_type == 'Meeting Minutes' )
					{
					echo '<a href="' . $url . '/meeting-minutes">' . $url . '/meeting-minutes</a>';
					}
					
				else if ( $document_type != 'Meeting Minutes' )
					{
					echo '<a href="' . $url . '/documents">' . $url . '/documents</a>';
					}
				if ( is_array($published_location) ) 
					{ 
					
					foreach($published_location as $published_location) 
						{ 
						echo '<br><a href="' . $published_location . '">' . $published_location . '</a></td></tr>'; 
						}
					}
				else 
					{ 
					echo '<br><a href="' . $published_location . '">' . $published_location . '</a></td></tr>';
					}
				?>		
				
				<!-- Required: Printable File Formats (or N/A) -->
				<tr scope="row"><th>Printable Files</th><td class="doc-link">
					<?php if ( $add_pdf ) { ?><a href="<?php echo $add_pdf; ?>"><img style="display: inline-block" src="<?php echo $url; ?>/wp-content/themes/simply-strata/images/icon-pdf-en.png" width="25" height="25" alt="icon for PDF - <?php echo $title; ?>"</a><?php } ?>
					<?php if ( $add_translation ) { ?><a href="<?php echo $add_translation; ?>"><img style="display: inline-block" src="<?php echo $url; ?>/wp-content/themes/simply-strata/images/icon-pdf-ch.png" width="25" height="25" alt="icon for PDF Translation - <?php echo $title; ?>"</a><?php } ?>
					<?php if ( $add_doc ) { ?><a href="<?php echo $add_doc; ?>"><img style="display: inline-block" src="<?php echo $url; ?>/wp-content/themes/simply-strata/images/icon-doc.png" width="25" height="25" alt="icon for DOC - <?php echo $title; ?>"</a><?php } ?>
					<?php if ( $add_xls ) { ?><a href="<?php echo $add_xls; ?>"><img style="display: inline-block" src="<?php echo $url; ?>/wp-content/themes/simply-strata/images/icon-xls.png" width="25" height="25" alt="icon for XLS - <?php echo $title; ?>"</a><?php } ?></td>
				</tr>
				
				<tr scope="row"><th>Quick View</th><td class="center"><?php echo $embed_pdf; ?></td></tr>
				
			</table>
                    
			<?php 
			
			}  // end if 
			
		} // end while
		?>
		
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
