<?php
/**
 * Define the post meta for the event post type.
 *
 * @package festival
 */

/**
 * Register all of the meta.
 */
function festival_register_meta() {

	$fields = array(
		'event_start_datetime',
		'event_end_datetime',
		'event_location_type',
		'event_location',
		'event_url_label',
		'event_url',
	);

	$args = array(
		'object_subtype' => 'festival_events',
		'show_in_rest' => true,
		'single' => true,
		'type' => 'string',
	);

	// Register strings.
	foreach ( $fields as $field ) {
		register_meta( 'post', $field, $args );
	}

	$boolean_fields = array(
		'event_all_day',
		'event_multi_day',
	);

	$boolean_args = array(
		'object_subtype' => 'festival_events',
		'show_in_rest' => true,
		'single' => true,
		'type' => 'boolean',
		'default' => false,
	);

	// Register boolean.
	foreach ( $boolean_fields as $boolean_field ) {
		register_meta( 'post', $boolean_field, $boolean_args );
	}
}
add_action( 'init', 'festival_register_meta', 0 );
