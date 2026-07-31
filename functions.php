<?php
/**
 * DaveLabs Command child theme assets.
 *
 * @package davelabs-command
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function davelabs_command_assets() {
	$css_path = get_stylesheet_directory() . '/assets/css/davelabs-command.css';
	$js_path  = get_stylesheet_directory() . '/assets/js/davelabs-command.js';
	$css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' );
	$js_ver   = file_exists( $js_path ) ? filemtime( $js_path ) : wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'davelabs-command',
		get_stylesheet_directory_uri() . '/assets/css/davelabs-command.css',
		array( 'imroz-style' ),
		$css_ver
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'davelabs-command',
			get_stylesheet_directory_uri() . '/assets/js/davelabs-command.js',
			array(),
			$js_ver,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'davelabs_command_assets', 30 );

function davelabs_command_front_page_template( $template ) {
	if ( is_front_page() ) {
		$custom_template = get_stylesheet_directory() . '/template-davelabs-command-home.php';

		if ( file_exists( $custom_template ) ) {
			return $custom_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'davelabs_command_front_page_template', 999999 );
