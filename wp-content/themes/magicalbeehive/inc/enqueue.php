<?php
/**
 * magicalbeehive enqueue scripts
 *
 * @package magicalbeehive
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'magicalbeehive_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function magicalbeehive_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style( 'magicalbeehive-styles', get_template_directory_uri() . '/css/theme.min.css', array(), $css_version );
		
		if (is_product()){
			wp_enqueue_style( 'select2-style', get_template_directory_uri() . '/css/select2.css', array(), '' );
		}

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/scripts.js' );
		$js_version_theme = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'magicalbeehive-theme', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version_theme, true );
		wp_enqueue_script( 'magicalbeehive-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), $js_version, true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		if (is_product()){
			wp_enqueue_script( 'select2-script', get_template_directory_uri() . '/js/select2.js', array(), '', true );
			wp_enqueue_script( 'product-script', get_template_directory_uri() . '/js/product.js', array(), '', true );
		}
	}
} // endif function_exists( 'magicalbeehive_scripts' ).

add_action( 'wp_enqueue_scripts', 'magicalbeehive_scripts' );
