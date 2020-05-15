<?php
/**
 * The home page template include
 *
 * Sets custom message based on user role.
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */

/*
**************************************************************************
// BUILDING MANAGER CONTACTS INFORMATION
// Disply if user can read private pages and Building Manager is not empty
***************************************************************************
*/
// check if the repeater field has rows of data
if( have_rows('contact_information') ):

 	// loop through the rows of data
  while ( have_rows('contact_information') ) : the_row();
		$public = get_sub_field('public');
		$contact_type = get_sub_field('contact_type');
		$name = get_sub_field('name');
		$title = get_sub_field('title');
		$company = get_sub_field('company');
		$website = get_sub_field('website');
		$address = get_sub_field('address');
		$city = get_sub_field('city');
		$province = get_sub_field('province');
		$postal = get_sub_field('postal_code');
		$email = get_sub_field('email');
		$hours = get_sub_field('hours');
		$phone = get_sub_field('phone');
		$local = get_sub_field('local');
		$fax = get_sub_field('fax');
		$contact_for = get_sub_field('contact_for');
		$notes = get_sub_field('notes');
		
		if ( ( ! $public && current_user_can('read_private_pages') ) || $public  )
			{
			
			echo '
			<div class="contact">
				<h2>' . $contact_type . '</h2>
				<div class="contact-left">';
			
			if ( $name && $title)
				{
				echo '<strong>' . $name . ',<br>' . $title . '</strong><br>';
				}
			
			elseif ( $name && ! $title)
				{
				echo '<strong>' . $name . '</strong><br>';
				}
				
			elseif ( ! $name && ! $title && $company)
				{
				echo '<strong>' . $company . '</strong><br>';
				}
				
			// if website is provided
			if ( $name && $website && $company)
				{
				echo '<a href="' . $website . '" target="_blank" rel="noopener">' . $company . '</a><br>';
				}
				
			// if a company name is provided
			elseif ( $name && ! $website && $company)
				{
				echo '' . $company . '<br>';
				}
					
			// if office hours are provided
			if ( $hours)
				{
				echo $hours . '<br>';
				}
				
			//if an address is provided
			if ( $address)
				{
				echo $address . '<br>' . $city . ', ' . $province . ' ' . $postal;
				}
			
			echo '
				</div>
				<div class="contact-right">
					<table class="contact">
						<tbody>';
						
			// if fax number is provided
			if ( $email )
				{
				echo '
							<tr>
								<td class="contact-title">Email:</td>
								<td class="contact-cell"><a href="mailto:' . $email . '">' . $email . '</a></td>
							</tr>';
				}
			
			// if phone number is provided, format the number and provide a link
			if ( $phone )
				{
				$phone_number_only = preg_replace("/[^\d]/", "", $phone);
				$phone_formatted = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $phone_number_only);
				echo '
							<tr>
								<td class="contact-title">Phone:</td>
								<td class="contact-cell"><a title="call ' . $phone_formatted . '" href="tel:+1' . $phone_number_only . '">' . $phone_formatted . '</a> </td>';
				
				// if a local is provided
				if ( $local )
					{
					echo 'Local ' . $local;
					}
				echo '
							</td></tr>';
				}
				
			// if fax number is provided
			if ( $fax )
				{
				$fax_number_only = preg_replace("/[^\d]/", "", $fax);
				$fax_formatted = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $fax_number_only);
				echo '
							<tr>
								<td class="contact-title">Fax:</td>
								<td class="contact-cell">' . $fax_formatted . '</td>
							</tr>';
				}
				
			echo '
							<tr>
								<td class="contact-title">Contact for:</td>
								<td class="contact-cell">' . $contact_for . '</td>
							</tr>
						</tbody>
					</table>
				</div>';
			
			// if notes are provided
			if ( $notes )
				{
				echo $notes;
				}
				
			echo '
			</div>';
			}
			
		endwhile;
		
		// If no contacts are found...
		else : echo 'Hmm, there does not seem to be any contacts listed. You might want to contact the Website Manager.';
		
endif;	

/*
**************************************************************************
// BUILDING MANAGER CONTACTS INFORMATION
// Disply if user can read private pages and Building Manager is not empty
***************************************************************************
*/
//	if ( get_sub_field('pm_name') )
//	
//		$pm_name = get_sub_field('pm_name');
//		$pm_website = get_sub_field('pm_website');
//		$pm_company = get_sub_field('pm_company');
//		$pm_address = get_sub_field('pm_address');
//		$pm_phone = get_sub_field('pm_phone');
//		$pm_local = get_sub_field('pm_local');
//		$pm_fax = get_sub_field('pm_fax');
//		$pm_call_for = get_sub_field('pm_call_for');
//		
//		{ 
//		echo '
//		<div class="contact">
//			<h2>Property Management</h2>
//			<div class="contact-left"><strong>' . $pm_name . ',<br>
//				Property Manager</strong><br>';
//		if ( $pm_website )
//			{
//			echo '<a href="' . $pm_website . '" target="_blank" rel="noopener">' . $pm_company . '</a><br>';
//			}
//		if ( $pm_address)
//			{
//			echo $pm_address . '<br>';
//			}
//		echo '
//			</div>
//			<div class="contact-right">
//				<table class="contact">
//					<tbody>';
//					
//		// if phone number is provided
//		if ( $pm_phone )
//			{
//			$pm_phone_number_only = preg_replace("/[^\d]/", "", $pm_phone);
//			$pm_phone2 = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $pm_phone_number_only);
//			echo '
//						<tr>
//							<td class="contact-title">Phone:</td>
//							<td class="contact-cell"><a title="call ' . $pm_phone2 . '" href="tel:+1' . $pm_phone_number_only . '">' . $pm_phone2 . '</a> </td>';
//			if ( the_field('pm_local') )
//				{
//				echo 'Local ' . $pm_local;
//				}
//			echo '
//						</td></tr>';
//		}
//			
//		// if fax number is provided
//		if ( $pm_fax )
//			{
//			$pm_fax_number_only = preg_replace("/[^\d]/", "", $pm_fax);
//			$pm_fax2 = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $pm_fax_number_only);
//			echo '
//						<tr>
//							<td class="contact-title">Fax:</td>
//							<td class="contact-cell">' . $pm_fax2 . '</td>
//						</tr>';
//			}
//			
//		echo '
//						<tr>
//							<td class="contact-title">Call for:</td>
//							<td class="contact-cell">' . $pm_call_for . '</td>
//						</tr>
//					</tbody>
//				</table>
//			</div>
//		</div>';
//	}	
//	?><!--
	<div class="contact">
	<h2>Security Company</h2>
	<div class="contact-left"><a href="http://genesissecurity.com/"><strong>Genesis Security</strong></a>
	10:00pm to 6:00am
	Thursday/Friday/Saturday</div>
	<div class="contact-right">
	<table class="contact">
	<tbody>
	<tr>
	<td class="contact-title">Phone:</td>
	<td class="contact-cell"><a title="call 604-261-0285" href="tel:+16046690822">604-669-0822</a></td>
	</tr>
	<tr>
	<td class="contact-title">Call for:</td>
	<td class="contact-cell">
	<ul>
	 	<li>homeowner inquiries about accounts</li>
	 	<li>inquiries about bylaws</li>
	 	<li>inquiries about rules and regulations
	building related inquiries</li>
	</ul>
	</td>
	</tr>
	</tbody>
	</table>
	</div>
	<strong><em>In the case of emergencies that cannot wait until the next working day, please call <a href="tel:+16042610285">604-261-0285</a> (24 hours)</em>
	</strong>
	
	</div>
	<div class="contact">
	<h2>Website Inquiries</h2>
	<div class="contact-left"><strong>Webmaster</strong></div>
	<div class="contact-right">
	<table class="contact">
	<tbody>
	<tr>
	<td class="contact-title">Email:</td>
	<td class="contact-cell"><a title="call 604-261-0285" href="mailto:webmaster@oscarvancouver.com">webmaster</a></td>
	</tr>
	<tr>
	<td class="contact-title">Email for:</td>
	<td class="contact-cell">
	<ul>
	 	<li>outdated or misleading information</li>
	 	<li>page not loading</li>
	 	<li>problem with website</li>
	</ul>
	</td>
	</tr>
	</tbody>
	</table>
	</div>
	</div>-->
	<?	
	


?>	