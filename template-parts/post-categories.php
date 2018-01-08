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
		'meta_value' => array(),
		'orderby' => 'document_type date title',
		'order' => 'DESC',
		'posts_per_page' => -1
		);
	}

// if user can only read public posts, query all public posts other than 'minutes'
else 
	{
	$args = array(
		'numberposts' => -1,
		'post_type' => 'post',
		'meta_query'	=> array(
				'relation'		=> 'AND',
				array(
					'key'		=> 'document_type',
					'value'		=> array('Important Notice', 'General Document', 'Building Document', 'Engineer Report', 'Council Report', 'Form', 'Meeting Minutes'),
					'compare'	=> 'IN'
				),
				array(
					'key'		=> 'document_privacy',
					'value'		=> '"public"',
					'compare'	=> 'LIKE'
				)
			),
		'orderby' => 'document_type date title',
		'order' => 'DESC',
		'posts_per_page' => -1
	);
	}
	
$document_posts = get_posts($args); 
//if no document posts
if (! $document_posts ) 
	{ 
	?>
	<div class="document-section">
		<table class="document-list" title="Documents">
			<thead>
				<tr><td colspan="3"><h2>Documents</h2></td></tr>
					<tr style="background-color: #000; color: #fff">
					<th class="doc-title">Document Title</th>
					<th class="doc-date" scope="col">Posted</th>
					<th class="doc-link" scope="col">Document Files</th>
				</tr>
			</thead>
			<tbody>
				<tr><td class="doc-title">Sorry, there are no <?php if (!current_user_can('read_private_posts') ) { echo 'public'; } ?> documents posted at this time.</td><td colspan="3"></td></tr>
			</tbody>
		</table>
	</div>
	<?php
	}
else 
	{
	
foreach($document_posts as $post)
	{
	setup_postdata( $post );
	
	$document_type = get_field('document_type');
	$add_pdf = get_field('document_pdf');
	$add_translation = get_field('document_translation');
	$add_doc = get_field('document_doc');
	$add_xls = get_field('document_xls');
	$last_revised = get_field('last_revised');
	
	$meeting_type = get_field('meeting_type');
	$meeting = get_field('meeting_date');
	$meeting_year = new DateTime($meeting);
	$meeting_year = $meeting_year->format('Y');
	$meeting_new = new DateTime($meeting);
	$meeting_date = $meeting_new->format('F d, Y');
	$meeting_month = $meeting_new->format('F');
	
	if ($document_type != 'Meeting Minutes') { $title = get_the_title(); } 
	elseif ($document_type == 'Meeting Minutes') { $title = $meeting_month . ' ' . $meeting_type; }  
	$permalink = get_permalink();
	
	// Format the posted date to compare withe the 'new date' specified above
	$posted = get_the_date();
	$posted_new = new DateTime($posted);
	$posted_date = $posted_new->format('Y-m-d');
	 
	
	// Set the state of this post as current type
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
			<table class="document-list" title="<?php echo $current_type; if ( $document_type != 'Meeting Minutes') { echo 's'; } ?>" cellpadding="0" cellspacing="0">
				<thead>
					<?php					
					if ( $current_type != 'Important Notice') { $col = 4; }
					else { $col = 3; }
					
					?>
					<tr><td colspan="<?php echo $col; ?>"><h2><?php echo $current_type; if ( $document_type != 'Meeting Minutes') { echo 's'; } ?></h2></td></tr>
						<tr style="background-color: #000; color: #fff">
						<th class="doc-title">Document Title</th>
						<?php if ( $current_type != 'Important Notice' && $current_type != 'Meeting Minutes') { echo '<th class="doc-date" scope="col">Last Revised</th>'; } ?>
						<?php if ( $current_type == 'Meeting Minutes') { echo '<th class="doc-date" scope="col">Meeting Held</th>'; } ?>
						<th class="doc-date" scope="col">Posted</th>
						<th class="doc-link" scope="col">Document Files</th>
					</tr>
				</thead>
				<tbody>
		<?php
		}
	
	// Add a 'new' class to the row if the document is new
	if ( $new_date <= $posted_date ) { echo '<tr class="new">'; } else { echo '<tr>'; } ?>
		<td class="doc-title" scope="row">
			<?php
			if ( $new_date <= $posted_date ) { echo ' <span class="new">«NEW»</span> '; } 
			echo '<a href="' . $permalink . '">' . $title . '</a>';
			?>
		</td>
		<?php 
		// display column if not important notices or meeting minutes
		if ( $current_type != 'Important Notice' ) { 
			echo '<td class="doc-title">';
			if ( $current_type == 'Meeting Minutes' ) { echo $meeting; }
			elseif ( $current_type != 'Meeting Minutes' && $last_revised ) { echo $last_revised; } 
			elseif ( $current_type != 'Meeting Minutes' && ! $last_revised ) { echo $posted; } 
			echo '</td>';
		} ?>
		<td class="doc-date" aria-label="document posted "><?php echo $posted; ?></td>
		<td >
			<a href="<?php echo $add_pdf; ?>"><img class="center" src="<?php echo $url . '/wp-content/themes/simply-strata/images/icon-pdf-en.png'; ?>" width="25" height="25" alt="icon for PDF - <?php $title ?>"></a>
			<?php 
			if ( $add_translation ) { echo '<a href="' . $add_translation . '"><img class="center" src="' . $url . '/wp-content/themes/simply-strata/images/icon-pdf-ch.png" width="25" height="25" alt="icon for DOC - ' . $title . '"></a> '; }
			if ( $add_doc ) { echo '<a href="' . $add_doc . '"><img class="center" src="' . $url . '/wp-content/themes/simply-strata/images/icon-doc.png" width="25" height="25" alt="icon for DOC - ' . $title . '"></a> '; }
			if ( $add_xls ) { echo '<a href="' . $add_xls . '"><img class="center" src="' . $url . '/wp-content/themes/simply-strata/images/icon-xls.png" width="25" height="25" alt="icon for XLS - ' . $title . '"></a>'; }
			?>			
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