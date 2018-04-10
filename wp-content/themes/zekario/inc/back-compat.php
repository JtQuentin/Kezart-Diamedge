<?php
/**
 * Zékario Theme back compat functionality
 *
 * Prevents Zékario Theme from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 */

/**
 * Prevent switching to Zékario Theme on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function zekario_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'zekario_upgrade_notice' );
}
add_action( 'after_switch_theme', 'zekario_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Zékario Theme on WordPress versions prior to 4.7.
 *
 * @global string $wp_version WordPress version.
 */
function zekario_upgrade_notice() {
	$message = sprintf( __( 'Zékario Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'zekario' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @global string $wp_version WordPress version.
 */
function zekario_customize() {
	wp_die( sprintf( __( 'Zékario Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'zekario' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'zekario_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @global string $wp_version WordPress version.
 */
function zekario_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Zékario Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'zekario' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'zekario_preview' );
