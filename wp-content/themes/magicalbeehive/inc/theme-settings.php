<?php
/**
 * Check and setup theme's default settings
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'magicalbeehive_setup_theme_default_settings' ) ) {
	function magicalbeehive_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$magicalbeehive_posts_index_style = get_theme_mod( 'magicalbeehive_posts_index_style' );
		if ( '' == $magicalbeehive_posts_index_style ) {
			set_theme_mod( 'magicalbeehive_posts_index_style', 'default' );
		}

		// Sidebar position.
		$magicalbeehive_sidebar_position = get_theme_mod( 'magicalbeehive_sidebar_position' );
		if ( '' == $magicalbeehive_sidebar_position ) {
			set_theme_mod( 'magicalbeehive_sidebar_position', 'right' );
		}

		// Container width.
		$magicalbeehive_container_type = get_theme_mod( 'magicalbeehive_container_type' );
		if ( '' == $magicalbeehive_container_type ) {
			set_theme_mod( 'magicalbeehive_container_type', 'container' );
		}
	}
}
