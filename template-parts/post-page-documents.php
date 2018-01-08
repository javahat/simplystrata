<?php
/**
 * Display any page specific document posts in a table below the title 
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */

				
// get current page id to compare with specified 'document location'
global $post;
$page_slug = $post->ID;
$page_slugs = '"' . $page_slug . '"';

//$post_slugs = get_field('published_location');


// Get base url for internal links
$url = get_site_url();

// Set previous type to NULL when page is loaded
$previous_type = NULL;

// Calculate whether document was posted within the past week
$date = get_the_date();
$new_date = date('Y-m-d', strtotime("-1 week +1 day") );

// get current page slug to hide documents assigned to specified pages
$slug = $post->post_name;

// if user can read private posts query all posts with a document location that matches the current page id and is private
if ( current_user_can('read_private_posts') )
	{
	$args = array(
		'numberposts'   => -1,
		'post_type'     => 'post',
		'meta_query'	  => array(
				'relation'  => 'OR',
				array(
					'key'		  => 'published_location',
					'value'	  => $page_slug,
					'compare'	=> '='
				),
				array(
					'key'		  => 'published_location',
					'value'		=> $page_slugs,
					'compare'	=> 'LIKE'
				),
			),
		'orderby' => 'published_location title',
		'order' => 'ASC'
	);
	}

// if user can not read private posts, query public posts with a document location that matches the current page id and is private
else 
	{	
	$args = array(
		'numberposts'        => -1,
		'post_type'          => 'post',
		'meta_query'	       => array(
				'relation'		   => 'AND',
				array(
					'key'		       => 'document_privacy',
					'value'		     => '"public"',
					'compare'	     => 'LIKE'
				  ),
				array(
							'relation' => 'OR',
				array(
					'key'		       => 'published_location',
					'value'	       => $page_slug,
					'compare'	     => '='
				  ),
				array(
					'key'		       => 'published_location',
					'value'		     => $page_slugs,
					'compare'	     => 'LIKE'
				  ),
				
			  ), ),
		'orderby'            => 'document_location title',
		'order'              => 'ASC'
	);
	}

// The Query
$document_posts = get_posts($args); 

// If you would like to specify pages not to display page specific document, enter them here
// eg if ( ( $slug != 'minutes' ) && have_posts()) :
if ( $document_posts )
	{
	foreach($document_posts as $post)
		{
		
		setup_postdata( $post ); 
		
		
		// Set the state of this post as the published page
		$current_type = $page_slug;	
		
		// If this post doesn't have the same 'Document Type' as the last one, let's give this one a heading and open the <ul>
		if ($current_type != $previous_type) 
			{ 
			// $previous_type isn't set until the end of this foreach, so the first one doesn't have this variable
			// If this isn't the first list, close the last list's <ul>
			if ($previous_type) 
				{ ?> </tbody></table></div> <?php } ?>
				
			<!-- Set up the table to display group of documents -->

			<div class="page-documents" aria-label="List of Printable Documents">
				<h2>Printable Documents</h2>
				<table class="document-list" title="Printable Documents" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th class="doc-title">Document Title</th>
							<th class="doc-date" scope="col">Last Revised</th>
							<th class="doc-link" scope="col">Printable Files</th>
						</tr>
					</thead>
					<tbody>	
			<?php 
			}

			$last_revised = get_field('last_revised');
			
			$add_pdf = get_field('document_pdf');
			$add_translation = get_field('document_translation');
			$add_doc = get_field('document_doc');
			$add_xls = get_field('document_xls');
			
			$permalink = get_permalink();
			$title = get_the_title();
			
			$published_location = $page_slug;
		
			// Format the posted date to compare withe the 'new date' specified above
			$posted = get_the_date();
			$posted_new = new DateTime($posted);
			$posted_date = $posted_new->format('Y-m-d');
			
			// Feb 5, 2019: If no last_revided date, display post date
			if ( $last_revised == '') { $last_revised = $posted; }
		
			// Add a 'new' class to the row if the document is new
			if ( $new_date <= $posted_date ) { echo '<tr class="new">'; } else { echo '<tr>'; } ?>

						<td class="doc-title" scope="row">
							<?php 
							if ( $new_date <= $posted_date ) { echo ' <span class="new">«NEW»</span> '; } 
							echo '<a href="' . $permalink . '">' . $title . '</a>'; ?>
						</td>
						<td class="doc-date" aria-label="last revised "><?php echo $last_revised; ?></td>
						<td class="doc-link">
							<?php
							if ( $add_pdf ) { echo '<a href="' . $add_pdf . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-pdf-en.png" width="25" height="25" alt="icon for PDF - ' . $title . '"></a>'; }
							if ( $add_translation ) { echo '<a href="' . $add_translation . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-pdf-ch.png" width="25" height="25" alt="icon for Chinese Translation - ' . $title . '"></a> '; }
							if ( $add_doc ) { echo '<a href="' . $add_doc . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-doc.png" width="25" height="25" alt="icon for DOC - ' . $title . '"></a> '; }
							if ( $add_xls ) { echo '<a href="' . $add_xls . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-xls.png" width="25" height="25" alt="icon for XLS - ' . $title . '"></a>'; } ?>
						</td>
					</tr>	
					
			<?php  
	// Remember, we closed the <ul> before the <li>'s, clever huh?
	// Set the 'State' of the this post, to compare to the next post
	$previous_type = $page_slug;

wp_reset_postdata(); 
}	
?>
				</tbody>
			</table>
		</div>
		
		<?php } // end foreach
		?>