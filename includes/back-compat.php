<?php
/**
 * Simply Strata back compat functionality
 *
 * Prevents Simply Strata from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
* @package JavaHat
* @subpackage Simply_Strata
* @since Simply Strata 1.0
 */

/**
 * Prevent switching to Simply Strata on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Simply Strata 1.0
 */
function simplystrata_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'simplystrata_upgrade_notice' );
}
add_action( 'after_switch_theme', 'simplystrata_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Simply Strata on WordPress versions prior to 4.4.
 *
 * @since Simply Strata 1.0
 *
 * @global string $wp_version WordPress version.
 */
function simplystrata_upgrade_notice() {
	$message = sprintf( __( 'Simply Strata requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'simply-strata' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @since Simply Strata 1.0
 *
 * @global string $wp_version WordPress version.
 */
function simplystrata_customize() {
	wp_die( sprintf( __( 'Simply Strata requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'simply-strata' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'simplystrata_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @since Simply Strata 1.0
 *
 * @global string $wp_version WordPress version.
 */
function simplystrata_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Simply Strata requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'simply-strata' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'simplystrata_preview' );
