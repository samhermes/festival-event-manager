<?php
/**
 * Set a custom template for the single event page.
 *
 * @package festival
 */

/**
 * Use single template for custom post type.
 *
 * @param string $single Path to single template.
 */
function festival_custom_single_template( $single ) {
	global $post;

	if ( $post->post_type === 'festival_events' ) {
		if ( file_exists( FESTIVAL_PATH . '/template-parts/single-festival-event.php' ) ) {
			return FESTIVAL_PATH . '/template-parts/single-festival-event.php';
		}
	}

	return $single;
}
add_filter( 'single_template', 'festival_custom_single_template' );
