<?php
/**
 * Custom hooks.
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'magicalbeehive_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function magicalbeehive_site_info() {
		do_action( 'magicalbeehive_site_info' );
	}
}

if ( ! function_exists( 'magicalbeehive_add_site_info' ) ) {
	add_action( 'magicalbeehive_site_info', 'magicalbeehive_add_site_info' );

	/**
	 * Add site info content.
	 */
	function magicalbeehive_add_site_info() {
		$the_theme = wp_get_theme();

		$site_info = '<small>Copyright @ ' . date("Y") . ' The Magical Beehive. All rights reserved.</small>';

		echo apply_filters( 'magicalbeehive_site_info_content', $site_info ); // WPCS: XSS ok.
	}
}
