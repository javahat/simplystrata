<?php
/**
 * The user information template
 *
 * Displays links in a table
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */


// if the user is logged in
$securecontent = get_post_meta( get_the_ID(), 'simplystrata_securecontent', true );
$securecontent2 = get_field('secure_content'); 
if ( is_user_logged_in() && current_user_can('read_private_pages') && ( $securecontent != '' || $securecontent2 != '' ))		 
	{
	echo $securecontent . $securecontent2;
	}
		
else 
	{	
	the_tags();
	the_content( sprintf(
		__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'simply-strata' ),
		get_the_title()
	) );
	
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'simply-strata' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'simply-strata' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
	}	



/*
**************************************************************************
// REPEATER ROW 
// Disply if user can read private pages and rows exist
***************************************************************************
*/
// check if the repeater field has rows of data

echo '<table class="links" >   
  <tr><th width="30%">Title</th><th>Description</th></tr>';
  
if( have_rows('resource') ):

 	// loop through the rows of data
  while ( have_rows('resource') ) : the_row();
		$title = get_sub_field('title');
		$url = get_sub_field('url');
		$description = get_sub_field('description');
				
		if ( ! $public && current_user_can('read_private_pages')  )
			{
			
			echo '
			  <tr><td valign="top"><a href=' . $url . '" target="_blank">' . $title . '</a></td><td>' . $description . '</td></tr>';
			}			
			
		endwhile;
		
		// If no contacts are found...
		else : echo '<tr><td colspan="2">Hmm, there does not seem to be any useful links listed. You might want to contact the Website Manager.</td></tr>';
		
endif;	
echo '</table>';
?>	