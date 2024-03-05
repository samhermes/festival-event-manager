<?php
/**
 * Register a custom category for Festival blocks.
 *
 * @package festival
 */

/**
 * Add block category for custom event blocks.
 *
 * @param array $categories Array of existing block categories.
 */
function festival_blocks_category( $categories ) {
	// Adding a new category.
	array_unshift(
		$categories,
		array(
			'slug'  => 'festival-blocks',
			'title' => __( 'Events', 'festival' ),
		)
	);

	return $categories;
}
add_filter( 'block_categories_all', 'festival_blocks_category', 10, 2 );
