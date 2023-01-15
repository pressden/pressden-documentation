<?php
/**
 * Plugin Name: PressDen Documentation
 * Plugin URI: https://github.com/pressden/pressden-documentation
 * Description: Adds a documentation custom post type to WordPress.
 * Version: 1.0
 * Author: D.S. Webster
 *
 * @package PressDenDocumentation
 */

// Helpers.
require __DIR__ . '/inc/helpers.php';

/**
 * Initialize documentation custom post type
 *
 * @package PressDen-Documentation
 */
function pdd_register() {
	// Privacy arguments.
	$args = array(
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
	);

	// Register documentation post type.
	pressden_register_post_type(
		'documentation',
		'Documentation',
		'Documentation',
		array_merge(
			$args,
			array(
				'menu_icon'     => 'dashicons-book',
				'menu_position' => '100',
			)
		)
	);
}
add_action( 'init', 'pdd_register' );
