<?php
/**
 * Add a custom column to event post type list in admin.
 *
 * @package festival
 */

/**
 * Add custom column to post screen.
 *
 * @param array $columns Existing columns.
 */
function festival_posts_column( $columns ) {
	// Find the title and add one to place the column after title.
	$offset = array_search( 'title', array_keys( $columns ), true ) + 1;

	return array_merge(
		array_slice( $columns, 0, $offset ),
		array( 'festival-date-time' => __( 'Date & Time', 'festival' ) ),
		array_slice( $columns, $offset, null )
	);
}
add_filter( 'manage_festival_events_posts_columns', 'festival_posts_column' );

/**
 * Add data to custom column.
 *
 * @param string  $column_key Slug of column.
 * @param integer $post_id ID of current post.
 */
function festival_custom_column( $column_key, $post_id ) {
	if ( $column_key === 'festival-date-time' ) {
		$site_date_format = get_option( 'date_format' );
		$site_time_format = get_option( 'time_format' );

		$start_datetime = strtotime( get_post_meta( $post_id, 'event_start_datetime', true ) );
		$end_datetime = strtotime( get_post_meta( $post_id, 'event_end_datetime', true ) );

		$is_multi_day = get_post_meta( $post_id, 'event_multi_day', true );
		$is_all_day = get_post_meta( $post_id, 'event_all_day', true );

		if ( ! empty( $start_datetime ) ) {
			festival_the_event_date( $start_datetime, $end_datetime, $is_multi_day, $site_date_format, );
			echo '<br>';
			if ( ! $is_all_day ) {
				festival_the_event_time( $start_datetime, $end_datetime, $site_time_format );
			}
		}
	}
}
add_action( 'manage_festival_events_posts_custom_column', 'festival_custom_column', 10, 2 );

/**
 * Allow custom column to be used for sorting.
 *
 * @param array $columns Array of all columns.
 */
function festival_sortable_column( $columns ) {
	$columns['festival-date-time'] = 'festival-date-time';

	return $columns;
}
add_filter( 'manage_edit-festival_events_sortable_columns', 'festival_sortable_column' );

/**
 * Modify query if post list has been sorted by custom column.
 *
 * @param object $query Current post query.
 */
function festival_orderby( $query ) {
	if ( ! is_admin() ) {
		return;
	}

	$orderby = $query->get( 'orderby' );

	if ( $orderby === 'festival-date-time' ) {
		$query->set( 'meta_key', 'event_start_datetime' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'festival_orderby' );
