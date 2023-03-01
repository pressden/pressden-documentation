<?php
/**
 * Plugin Name: WP Documentation
 * Plugin URI: https://github.com/pressden/wp-documentation
 * Description: Adds a documentation custom post type to WordPress.
 * Version: 1.0
 * Author: D.S. Webster
 *
 * @package WPDocumentation
 */

// Define the custom post type slug.
define( 'WPD_SLUG', 'documentation' );

/**
 * Initialize documentation custom post type
 */
function wpd_initialize() {
	$wpd_label = ucfirst( WPD_SLUG );

	// Register documentation post type.
	$args = array(
		'labels'          => array(
			'name'               => $wpd_label,
			'singular_name'      => $wpd_label,
			'add_new_item'       => 'Add New ' . $wpd_label,
			'edit_item'          => 'Edit ' . $wpd_label,
			'new_item'           => 'Create ' . $wpd_label,
			'view_item'          => 'View ' . $wpd_label,
			'search_items'       => 'Search ' . $wpd_label,
			'not_found'          => 'No ' . strtolower( $wpd_label ) . ' found',
			'not_found_in_trash' => 'No ' . strtolower( $wpd_label ) . ' found in trash',
			'parent_item_colon'  => 'Parent ' . $wpd_label . ':',
		),
		'capability_type' => 'post',
		'supports'        => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'trackbacks',
			'custom-fields',
			'comments',
			'revisions',
			'page-attributes',
			'post-formats',
		),
		'public'          => true,
		'menu_icon'       => 'dashicons-book',
		'menu_position'   => 20,
		'rewrite'         => array( 'slug' => WPD_SLUG ),
		'has_archive'     => true,
		'show_in_rest'    => true,
	);

	register_post_type( WPD_SLUG, $args );
}
add_action( 'init', 'wpd_initialize' );

/**
 * Filter requests for documentation.
 *
 * @param object $query Instance of WP_Query object.
 */
function wpd_restrict_frontend_access( $query ) {
	// Exit early scenarios.
	if (
		// This is an admin query.
		is_admin() ||

		// This is not the main query.
		! $query->is_main_query() ||

		// This is not a documentation query.
		( ! isset( $query->query['post_type'] ) || ! 'documentation' === $query->query['post_type'] )
	) {
		return;
	}

	// Return 404 if user does not have permission to read documentation.
	if ( ! current_user_can( 'edit_posts' ) ) {
		$query->set_404();
		status_header( 404 );
	}
}
add_action('pre_get_posts', 'wpd_restrict_frontend_access');

/**
 * Exclude the documentation post type from Yoast SEO Sitemap(s)
 *
 * @param boolean $excluded  Exclusion boolean for the current post type.
 * @param string  $post_type The current post type.
 */
function wpd_wpseo_exclude_from_sitemap( $excluded, $post_type ) {
	$excludedPostTypes = array( WPD_SLUG );

	if ( in_array( $post_type, $excludedPostTypes ) ) {
		return true;
	}

	return $excluded;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'wpd_wpseo_exclude_from_sitemap', 10, 2 );
