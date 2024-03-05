<?php
/**
 * Define the custom taxonomy for the event post type.
 *
 * @package festival
 */

/**
 * Register event category taxonomy.
 */
function festival_register_custom_taxonomies() {

	$labels  = array(
		'name' => _x( 'Categories', 'Taxonomy General Name', 'festival' ),
		'singular_name' => _x( 'Category', 'Taxonomy Singular Name', 'festival' ),
		'menu_name' => __( 'Categories', 'festival' ),
		'all_items' => __( 'All Categories', 'festival' ),
		'parent_item' => __( 'Parent Category', 'festival' ),
		'parent_item_colon' => __( 'Parent Category:', 'festival' ),
		'new_item_name' => __( 'New Category Name', 'festival' ),
		'add_new_item' => __( 'Add New Category', 'festival' ),
		'edit_item' => __( 'Edit Category', 'festival' ),
		'update_item' => __( 'Update Category', 'festival' ),
		'view_item' => __( 'View Category', 'festival' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'festival' ),
		'add_or_remove_items' => __( 'Add or remove categories', 'festival' ),
		'choose_from_most_used' => __( 'Choose from the most used', 'festival' ),
		'popular_items' => __( 'Popular Categories', 'festival' ),
		'search_items' => __( 'Search Categories', 'festival' ),
		'not_found' => __( 'Not Found', 'festival' ),
		'no_terms' => __( 'No categories', 'festival' ),
		'items_list' => __( 'Categories list', 'festival' ),
		'items_list_navigation' => __( 'Categories list navigation', 'festival' ),
	);
	$rewrite = array(
		'slug' => 'event-category',
		'with_front' => true,
		'hierarchical' => false,
	);
	$args    = array(
		'labels' => $labels,
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'show_in_rest' => true,
		'rewrite' => $rewrite,
	);
	register_taxonomy( 'festival_event_category', array( 'festival_events' ), $args );

}
add_action( 'init', 'festival_register_custom_taxonomies', 0 );
