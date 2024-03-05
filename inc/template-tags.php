<?php
/**
 * Set up custom template tags.
 *
 * @package festival
 */

/**
 * Output the event date.
 *
 * @param string  $start_datetime Event start date and time.
 * @param string  $end_datetime Event end date and time.
 * @param boolean $is_multi_day Does this event span multiple days.
 * @param string  $site_date_format The date format as defined by the site.
 */
function festival_the_event_date( $start_datetime, $end_datetime, $is_multi_day, $site_date_format ) {
	echo '<span class="screen-reader-text">' . esc_html__( 'Date:', 'festival' ) . ' </span>';
	if ( ! $is_multi_day ) {
		echo esc_html( gmdate( $site_date_format, $start_datetime ) );
	} else {
		echo esc_html( gmdate( $site_date_format, $start_datetime ) ) . ' ' . esc_html__( 'to', 'festival' ) . ' ' . esc_html( gmdate( $site_date_format, $end_datetime ) );
	}
}

/**
 * Output the event time.
 *
 * @param string $start_datetime Event start date and time.
 * @param string $end_datetime Event end date and time.
 * @param string $site_time_format The time format as defined by the site.
 */
function festival_the_event_time( $start_datetime, $end_datetime, $site_time_format ) {
	echo '<span class="screen-reader-text">' . esc_html__( 'Time:', 'festival' ) . ' </span>';
	echo esc_html( gmdate( $site_time_format, $start_datetime ) ) . ' ' . esc_html__( 'to', 'festival' ) . ' ' . esc_html( gmdate( $site_time_format, $end_datetime ) );
}
