<?php
/**
 * Template for single event.
 *
 * @package festival
 */

get_header();

$today = current_time( 'Y-m-d' );
$site_date_format = get_option( 'date_format' );
$site_time_format = get_option( 'time_format' );

$event_post_id = get_the_id();

$start_datetime = strtotime( get_post_meta( $event_post_id, 'event_start_datetime', true ) );
$end_datetime = strtotime( get_post_meta( $event_post_id, 'event_end_datetime', true ) );

$is_multi_day = get_post_meta( $event_post_id, 'event_multi_day', true );
$is_all_day = get_post_meta( $event_post_id, 'event_all_day', true );

$location_details = get_post_meta( $event_post_id, 'event_location', true );
$url = get_post_meta( $event_post_id, 'event_url', true );
$url_label = get_post_meta( $event_post_id, 'event_url_label', true );

$event_content = get_the_content();
?>

<div class="festival-events festival-single-event">
	<h1 class="event-title"><?php the_title(); ?></h1>

	<div class="event-details-container">
		<h2 id="event-details-heading" class="screen-reader-text"><?php echo esc_html__( 'Event Details', 'festival' ); ?></h2>
		<ul class="event-details" aria-labelledby="event-details-heading">
			<li class="event-details-date">
				<span class="screen-reader-text"><?php echo esc_html__( 'Date:', 'festival' ); ?> </span>
				<?php
				if ( ! $is_multi_day ) {
					echo esc_html( gmdate( $site_date_format, $start_datetime ) );
				} else {
					echo esc_html( gmdate( $site_date_format, $start_datetime ) ) . ' ' . esc_html__( 'to', 'festival' ) . ' ' . esc_html( gmdate( $site_date_format, $end_datetime ) );
				}
				?>
			</li>

			<?php if ( ! $is_all_day ) : ?>
				<li class="event-details-time">
					<span class="screen-reader-text"><?php echo esc_html__( 'Time:', 'festival' ); ?> </span>
					<?php echo esc_html( gmdate( $site_time_format, $start_datetime ) ) . ' ' . esc_html__( 'to', 'festival' ) . ' ' . esc_html( gmdate( $site_time_format, $end_datetime ) ); ?>
				</li>
			<?php endif; ?>

			<?php if ( $location_details ) : ?>
				<li class="event-details-location">
					<div class="location-details"><?php echo esc_html( $location_details ); ?></div>
				</li>
			<?php endif; ?>

			<?php if ( $url && $url_label ) : ?>
				<li class="event-details-url">
					<a href="<?php echo esc_attr( $url ); ?>"><?php echo esc_html( $url_label ); ?></a>
				</li>
			<?php endif; ?>
		</ul>
	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="event-image">
			<?php the_post_thumbnail( 'event-thumbnail' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $event_content ) : ?>
		<div class="event-content">
			<?php echo wp_kses_post( $event_content ); ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
