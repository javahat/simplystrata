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

$table_title = "Important Notice"; 

// Set previous type to NULL when page is loaded
$previous_type = NULL;

// if user can read private posts query all posts with a document location that matches the current page id and is private

if ( $current_role == 'council')
	{
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'meta_key' => 'document_type',
		'meta_value' => $table_title,
		'orderby' => 'document_type date title',
		'order' => 'DESC',
		'date_query' => array(
		        'after' => date('Y-m-d', strtotime("-1 month +1 day") ) )
		);
	}

elseif ( current_user_can('read_private_posts') && $current_role != 'council')
	{
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'meta_key' => 'document_type',
		'meta_value' => $table_title,
        'meta_query'	  => array(
            'key'		  => 'document_privacy_council',
			'value'		=> '',
			'compare'	=> '='
                ),
		'orderby' => 'document_type date title',
		'order' => 'DESC',
		'date_query' => array(
		        'after' => date('Y-m-d', strtotime("-1 month +1 day") ) )
		);
	}
else 
	{
	$args = array(
		'numberposts' => -1,
		'post_type' => 'post',
		'meta_query'	=> array(
				'relation'		=> 'AND',
				array(
					'key'		=> 'document_type',
					'value'		=> $table_title,
					'compare'	=> '='
				),
				array(
					'key'		=> 'document_privacy',
					'value'		=> '"public"',
					'compare'	=> 'LIKE'
				)
			),
		'orderby' => 'document_type date title',
		'order' => 'DESC',
		'date_query' => array(
		        'after' => date('Y-m-d', strtotime("-1 month +1 day") ) )
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
		$current_type = get_field('document_type');	
		
		// If this post doesn't have the same 'Document Type' as the last one, let's give this one a heading and open the <ul>
		if ($current_type != $previous_type) 
			{ 
			// $previous_type isn't set until the end of this foreach, so the first one doesn't have this variable
			// If this isn't the first list, close the last list's <ul>
			if ($previous_type) 
				{ ?> </tbody></table></div> <?php } ?>
				
			<!-- Set up the table to display group of documents -->
			
<div class="document-section">
	<table class="document-list" title="<?php echo $table_title . 's'; ?>">
		<thead>
			<tr><td colspan="4"><h2><?php echo $table_title . 's'; ?></h2></td></tr>
			<tr style="background-color: #000; color: #fff">
				<?php
				// determin how many columns to include in the table
				if ( $doc_word == 'yes' && $doc_xls == 'yes') { $col = 5; }
				elseif (( $doc_word == 'yes' && $doc_xls != 'yes' ) || ( $doc_word != 'yes' && $doc_xls == 'yes')) { $col = 4; }
				else { $col = 3; } 
				?>
				<th class="doc-title">Document Title</th>
				<th class="doc-date" scope="col">Posted</th>
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
					
				
					// Format the posted date to compare withe the 'new date' specified above
					$posted = get_the_date();
					$posted_new = new DateTime($posted);
					$posted_date = $posted_new->format('Y-m-d');
				
		// Add a 'new' class to the row if the document is new
					if ( $new_date <= $posted_date ) { echo '<tr class="new">'; } else { echo '<tr>'; } ?>
					
							<tr>
								<td class="doc-title" scope="row">
									<?php 
									echo '<a href="' . $permalink . '">' . $title . '</a>';
									if ( $new_date <= $posted_date ) { echo ' <span class="new">«NEW»</span>'; } ?>
								</td>
								<td class="doc-date" aria-label="posted "><?php echo $posted; ?></td>
								<td class="doc-link">
									<?php
									if ( $add_pdf ) { echo '<a href="' . $add_pdf . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-pdf-en.png" width="25" height="25" alt="icon for PDF - ' . $title . '"></a>'; }
									if ( $add_translation ) { echo '<a href="' . $add_translation . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-pdf-ch.png" width="25" height="25" alt="icon for DOC - ' . $title . '"></a> '; }
									if ( $add_doc ) { echo '<a href="' . $add_doc . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-doc.png" width="25" height="25" alt="icon for DOC - ' . $title . '"></a> '; }
									if ( $add_xls ) { echo '<a href="' . $add_xls . '"><img src="' . $url . '/wp-content/themes/simply-strata/images/icon-xls.png" width="25" height="25" alt="icon for XLS - ' . $title . '"></a>'; } ?>
								</td>
							</tr>	
							
					<?php  
			// Remember, we closed the <ul> before the <li>'s, clever huh?
			// Set the 'State' of the this post, to compare to the next post
			$previous_type = get_field('document_type');
		
		wp_reset_postdata(); 
		}	
		?>
						</tbody>
					</table>
				</div>
				
				<?php } // end foreach
				?>