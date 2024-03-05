<?php
/**
 * Define the custom post type for the plugin.
 *
 * @package festival
 */

/**
 * Register custom post type.
 */
function festival_register_post_type() {
	$labels = array(
		'name' => _x( 'Events', 'Post Type General Name', 'festival' ),
		'singular_name' => _x( 'Event', 'Post Type Singular Name', 'festival' ),
		'menu_name' => __( 'Events', 'festival' ),
		'name_admin_bar' => __( 'Event', 'festival' ),
		'archives' => __( 'Event Archives', 'festival' ),
		'attributes' => __( 'Event Attributes', 'festival' ),
		'parent_item_colon' => __( 'Parent Event:', 'festival' ),
		'all_items' => __( 'All Events', 'festival' ),
		'add_new_item' => __( 'Add New Event', 'festival' ),
		'add_new' => __( 'Add New', 'festival' ),
		'new_item' => __( 'New Event', 'festival' ),
		'edit_item' => __( 'Edit Event', 'festival' ),
		'update_item' => __( 'Update Event', 'festival' ),
		'view_item' => __( 'View Event', 'festival' ),
		'view_items' => __( 'View Events', 'festival' ),
		'search_items' => __( 'Search Event', 'festival' ),
		'not_found' => __( 'Not found', 'festival' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'festival' ),
		'featured_image' => __( 'Featured Image', 'festival' ),
		'set_featured_image' => __( 'Set featured image', 'festival' ),
		'remove_featured_image' => __( 'Remove featured image', 'festival' ),
		'use_featured_image' => __( 'Use as featured image', 'festival' ),
		'insert_into_item' => __( 'Insert into event', 'festival' ),
		'uploaded_to_this_item' => __( 'Uploaded to this event', 'festival' ),
		'items_list' => __( 'Events list', 'festival' ),
		'items_list_navigation' => __( 'Events list navigation', 'festival' ),
		'filter_items_list' => __( 'Filter events list', 'festival' ),
	);
	$rewrite = array(
		'slug' => 'event',
		'with_front' => true,
		'pages' => true,
		'feeds' => true,
	);
	$args = array(
		'label' => __( 'Event', 'festival' ),
		'description' => __( 'Festival Events', 'festival' ),
		'labels' => $labels,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'taxonomies' => array(),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 20,
		'menu_icon' => 'dashicons-calendar-alt',
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => 'events',
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => $rewrite,
		'capability_type' => 'page',
		'show_in_rest' => true,
	);
	register_post_type( 'festival_events', $args );
}
add_action( 'init', 'festival_register_post_type', 0 );
