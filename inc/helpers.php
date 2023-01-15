<?php
if ( ! function_exists( 'pressden_register_post_type' ) ) {
	/**
	 * Register post type with preferred defaults
	 *
	 * @param string $codename Slug.
	 * @param string $singular Singular name.
	 * @param string $plural   Plural name.
	 * @param array  $args     Custom post type arguments.
	 */
	function pressden_register_post_type( $codename, $singular, $plural, $args = array() ) {
		$labels = array(
			'name'               => $plural,
			'singular_name'      => $singular,
			'add_new_item'       => 'Add New ' . $singular,
			'edit_item'          => 'Edit ' . $singular,
			'new_item'           => 'Create ' . $singular,
			'view_item'          => 'View ' . $singular,
			'search_items'       => 'Search ' . $singular,
			'not_found'          => 'No ' . strtolower( $plural ) . ' found',
			'not_found_in_trash' => 'No ' . strtolower( $plural ) . ' found in trash',
			'parent_item_colon'  => 'Parent ' . $singular . ':',
		);

		$defaults = array(
			'labels'          => $labels,
			'capability_type' => 'post',
			'supports'        => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats' ),
			'public'          => true,
			'menu_position'   => 20,
			'rewrite'         => array( 'slug' => $codename ),
			'has_archive'     => true,
			'show_in_rest'    => true,
		);

		$args = wp_parse_args( $args, $defaults );

		register_post_type( $codename, $args );
	}
}
