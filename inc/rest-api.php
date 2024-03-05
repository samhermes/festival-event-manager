<?php
/**
 * Modify /festival_events REST route to order by upcoming events.
 *
 * @package festival
 */

/**
 * Order events by start date and time.
 *
 * @param array $args Existing route arguments.
 */
function festival_modify_event_endpoint( $args ) {
	$current_datetime = current_datetime()->format( 'Y-m-d H:i:s' );

	$args['orderby'] = 'meta_value';
	$args['order'] = 'ASC';
	$args['meta_key'] = 'event_start_datetime'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
	$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		array(
			'key' => 'event_start_datetime',
			'value' => $current_datetime,
			'compare' => '>=',
		),
	);

	return $args;
}
add_filter( 'rest_festival_events_query', 'festival_modify_event_endpoint' );
