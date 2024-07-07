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
	// Create an instance of the template loader.
	$template_loader = new Festival_Template_Loader();

	if ( $post->post_type === 'festival_events' ) {
		if ( file_exists( FESTIVAL_PATH . '/templates/single-event.php' ) ) {
			return $template_loader->get_template_part( 'single-event', null, false );
		}
	}

	return $single;
}
add_filter( 'single_template', 'festival_custom_single_template' );
