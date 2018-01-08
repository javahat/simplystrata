<?php

/*********************************************************************************
 Add custom pages to new sites on multisite
 
*********************************************************************************/


add_action('wpmu_new_blog', 'wpb_create_my_pages', 10, 2);
 
function wpb_create_my_pages($blog_id, $user_id)
	{
  switch_to_blog($blog_id);
 
	// create home page
  $page_home = wp_insert_post(array(
    'post_title'     => 'Home',
    'post_name'      => 'home',
    'post_content'   => 'Welcome to my <strong>Simply Strata Wordpress Template</strong>. Although still in the beta stage, I designed this theme specifically with strata councils in mind. This site allows councils to easily manage and share important information with residents and tenants.</p>
    	<p>The site is fully responsive which means it is viewable both on a computer and mobile device. I have incorporated the free <strong>WP Mobile Menu plugin</strong> to achieve a fully responsive and customizable menu.</p>
    	<p>With the addition of the free <strong>Profile Builder plugin</strong>, users are able to log in and see private information not available to the public. You could create multiple levels of privacy:</p>
    <ul>
     	<li>Council</li>
     	<li>Owner</li>
     	<li>Tenant</li>
    </ul>',
    'post_secure'   => '<p>This is the secure home page. You can customize it however you would like.</p>',
    'post_status'    => 'publish',
    'post_author'    => $user_id, // or "1" (super-admin?)
    'post_type'      => 'page',
    'post_parent'      => '0',
    'menu_order'     => 1,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
    'is_front_page'  => 'true',
 	));
 
	// create documents page
  $page_documents = wp_insert_post(array(
     'post_title'     => 'Documents',
     'post_name'      => 'documents',
     'post_content'   => '<p>Below is a list of all public documents.</p>',
     'post_status'    => 'publish',
     'post_author'    => $user_id, // or "1" (super-admin?)
     'post_type'      => 'page',
     'menu_order'     => 2,
     'comment_status' => 'closed',
     'ping_status'    => 'closed',
     'is_front_page'  => 'false',
  ));
  
  // create  bylaws page
  $page_bylaws = wp_insert_post(array(
    'post_title'     => 'Bylaws',
    'post_name'      => 'bylaws',
    'post_content'   => '<p></p>',
    'post_status'    => 'publish',
    'post_author'    => $user_id, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 1,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
    'is_front_page'  => 'false',
   ));
   
   // create  rules page
   $page_rules = wp_insert_post(array(
     'post_title'     => 'Rules',
     'post_name'      => 'rules',
     'post_content'   => '<p></p>',
     'post_status'    => 'publish',
     'post_author'    => $user_id, // or "1" (super-admin?)
     'post_type'      => 'page',
     'menu_order'     => 2,
     'comment_status' => 'closed',
     'ping_status'    => 'closed',
     'is_front_page'  => 'false',
    ));
    
    // create  Contacts page
    $page_contacts = wp_insert_post(array(
      'post_title'     => 'Contacts',
      'post_name'      => 'contacts',
      'post_content'   => '<h2>Property Management</h2>
      <strong>Manager Name,
      Property Manager</strong>
      Company Name
      Company Address
      City, Province, Postal Code
      <strong>Phone:</strong> 123-456-7890 Local ###
      <strong>Fax:</strong> 123-456-7890
      
      Call for:
      <ul>
       	<li>homeowner inquiries about accounts</li>
       	<li>inquiries about bylaws</li>
       	<li>inquiries about rules and regulations
      building related inquiries</li>
      </ul>
      
      <hr />
      
      <h2>Building Management</h2>
      <strong>Manager Name
      Phone: </strong>123-456-7890<strong>
      </strong>
      
      <strong>Office Hours:</strong> Days and Hours
      
      Call for:
      <ul>
       	<li>building related inquiries</li>
       	<li>booking move-ins or move-outs (7 days in advance please)</li>
       	<li>reporting strangers in or around the building</li>
       	<li>visitor parking passes</li>
      </ul>
      
      <hr />
      
      <h2>Security Company</h2>
      <strong>Company Name
      Phone: </strong>123-456-7890<strong>
      </strong>
      
      <strong>Office Hours:</strong> Days and Hours
      
      Call for:
      <ul>
       	<li>theft or break ins</li>
       	<li>crowd gathering</li>
       	<li>drug or alcohol on the premises</li>
      </ul>
      <strong>In the case of emergencies that cannot wait until the next working day, please call 123-456-7890 (24 hours)</strong>',
      'post_status'    => 'publish',
      'post_author'    => $user_id, // or "1" (super-admin?)
      'post_type'      => 'page',
      'menu_order'     => 2,
      'comment_status' => 'closed',
      'ping_status'    => 'closed',
      'is_front_page'  => 'false',
     ));
   
  
  
// Set "static page" as the option
update_option( 'show_on_front', 'page' );

// Set the front page ID
update_option( 'page_on_front', $page_home );    
   
/*********************************************************************************
 Find and delete the WP default 'Sample Page'
*********************************************************************************/

$defaultPage = get_page_by_title( __('Sample Page', 'simply-strata') );
wp_delete_post( $defaultPage->ID );
 
  restore_current_blog();
}
?>