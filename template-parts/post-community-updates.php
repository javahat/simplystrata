<?php
/**
 * Display important notices on the home page
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */
 
// Documents posted within the time specified below are considered 'new'
$date = get_the_date();
$new_date = date('Y-m-d', strtotime("-1 week +1 day") );

// Get base url for internal links
$url = get_site_url();

// Set previous type to NULL when page is loaded
$previous_type = NULL;

// if user can read private posts, query all posts other than 'minutes'
if ( current_user_can('read_private_posts') )
	{
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'meta_key' => 'document_type',
		'meta_value' => 'Community Update',
		'orderby' => 'last_revised',
		'order' => 'DESC',
		'posts_per_page' => -1
		);
	
	$document_posts = get_posts($args); 
	if ( $document_posts ) 
		{
		foreach($document_posts as $post)
			{
			setup_postdata( $post );
			
			$add_doc = get_field('document_doc');
			if ( $add_doc) { $doc_word = 'yes'; $col = 4;} else { $doc_word = null; $col = 3;}
			
			// Get the meeting year and set the state of this post as current type
			$update = get_field('last_revised');
			$update_year = new DateTime($update);
			$update_year = $update_year->format('Y');
			$current_type = $update_year;
			
			// If this post doesn't have the same 'Document Type' as the last one, let's give this one a heading and open the <ul>
			if ($current_type != $previous_type) 
				{ 
				// $previous_type isn't set until the end of this foreach, so the first one doesn't have this variable
				// If this isn't the first list, close the last list's <ul>
				if ($previous_type) 
					{ ?> </tbody></table></div> <?php } ?>
		
				<!-- Set up the table to display group of documents -->
				<div class="document-section">
					<table class="document-list" title="<?php echo $current_type . ' Community Updates'; ?>">
						<thead>
							<?php
							
							?>
							<tr><td colspan="<?php echo $col; ?>"><h2><?php echo $current_type . ' Community Updates '; ?></h2></td></tr>
								<tr style="background-color: #000; color: #fff">
								<th class="doc-title">Document Title</th>
								<th class="doc-date" scope="col">Last Revised</th>
								<th class="doc-link" scope="col">PDF</th>
								<?php if ( $doc_word == 'yes') { echo '<th class="doc-link" scope="col">DOC</th>'; } ?>
							</tr>
						</thead>
						<tbody>
				<?php
				}
			$add_pdf = get_field('document_pdf');
			$add_doc = get_field('document_doc');
			
			// Format the Meeting Date to not include the year for the title
			$update_new = new DateTime($update);
			$update_date = $update_new->format('F d, Y');
			$update_month = $update_new->format('F');
			$blog_title = get_bloginfo( 'name' );
			$update_title = $update_month . ' ' . $blog_title . ' Update';
			//$update_title = $update_month . ' Community Update';
			
			// Format the posted date to compare withe the 'new date' specified above
			$posted = get_the_date();
			$posted_new = new DateTime($posted);
			$posted_date = $posted_new->format('Y-m-d');
			
							// Add a 'new' class to the row if the document is new
							echo '<tr ';
							if ( $new_date <= $posted_date ) { echo 'class="new" '; } 
							echo '>';
							?>
								<td class="doc-title" scope="row">
									<?php echo $update_title;
									if ( $new_date <= $posted_date ) { echo ' <span class="new">«NEW»</span>'; } ?>
								</td>
								<td class="doc-date" aria-label="Posted "><?php echo $update_date; ?></td>
								<td class="doc-link"><a href="<?php echo $add_pdf ?>"><img class="center" src="<?php echo $url . '/wp-content/themes/simply-strata/images/icon-pdf.png'; ?>" width="25" height="25" alt="icon for PDF - <?php $meeting_title ?>"></a></td>
								<?php 
								// Display word document if provided
								if ( $doc_word == 'yes' && ! $add_doc ) {  echo '<td></td>'; }
								elseif ( $doc_word == 'yes' && $add_doc ) { ?> 
								<td class="doc-link"><a href="<?php echo $add_doc ?>"><img class="center" src="<?php echo $url . '/wp-content/themes/simply-strata/images/icon-doc.png'; ?>" width="25" height="25" alt="icon for DOC - <?php the_title(); ?>"></a></td> <?php } ?>
							</tr>	
			<?php 
			// Remember, we closed the <ul> before the <li>'s, clever huh?
			// Set the 'State' of the this post, to compare to the next post
			$previous_type = $update_year;
		
			wp_reset_postdata(); 
			}	
			?>
				</tbody>
			</table>
		</div>
		
		<?php 
		} // end foreach
	}
?>