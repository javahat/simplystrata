<?php
/**
 * A comments page even though it is not used in this theme.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */
 
 //Get only the approved comments 
 $args = array(
     'status' => 'approve'
 );
  
 // The comment Query
 $comments_query = new WP_Comment_Query;
 $comments = $comments_query->query( $args );
  
 // Comment Loop
 if ( $comments ) {
     foreach ( $comments as $comment ) {
         echo '<p>' . $comment->comment_content . '</p>';
         get_the_post_thumbnail()
     }
 }


 /**
 * Comments are required by Wordpress but not used in this simple theme. 
 * Strata Councils focus on communiting information to residents but 
 * typically do not monitor the website. Therefore any communication
 * from users should be made through forms and email, not comments.
 */
 
 get_avatar( $comment, 32 );
 posts_nav_link();
 paginate_comments_links();
 if ( is_singular() ) wp_enqueue_script( "comment-reply" );
 wp_list_comments( $args );
 comments_template( $file, $separate_comments );
 comment_form();
 
 ?>