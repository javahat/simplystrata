<?php
/**
 * The template for displaying the footer
 *
 * Contains everything in the #footer to the end of the page
 *
 * @package JavaHat
 * @subpackage Simply_Strata
 * @since Simply Strata 1.0
 */
?>

</div><!-- #page -->

<!-- *********************************************************
     Footer Widget (1 column below content
     ********************************************************* -->
<footer class="site-footer" role="contentinfo">
  <!-- &copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?> -->
	&copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); echo ' - '; bloginfo( 'description' ); ?><br>
	<a href="<?php echo esc_url( __( 'https://simply-strata.templatedesign.ca', 'simply-strata' ) ); ?>"><?php printf( __( 'Powered by the %s', 'simply-strata' ), 'JavaHat Solutions <strong>Simply Strata</strong> theme.' ); ?></a>	
</footer><!-- .site-footer -->

<?php wp_footer(); ?>


</body>
</html>