<?php
/**
 * Render list of events based on parameters.
 *
 * @package festival
 */

$current_datetime = current_datetime()->format( 'Y-m-d H:i:s' );

$events_per_page = $attributes['perPage'] ?? 5;
$show_pagination = $attributes['showPagination'] ?? false;
$category = $attributes['category'] ?? '';
$style = $attributes['style'] ?? 'list';
$style_class = ' is-style-' . $style;

$today = current_time( 'Y-m-d' );
$site_date_format = get_option( 'date_format' );
$site_time_format = get_option( 'time_format' );

$events_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$tax_query = array();
if ( $category ) {
	$tax_query = array(
		array(
			'taxonomy' => 'festival_event_category',
			'terms'    => $category,
		),
	);
}

$events_query = new WP_Query(
	array(
		'post_type' => 'festival_events',
		'posts_per_page' => $events_per_page,
		'meta_key' => 'event_start_datetime', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'tax_query' => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key' => 'event_start_datetime',
				'value' => $current_datetime,
				'compare' => '>=',
			),
		),
		'paged' => $events_paged,
	)
); ?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( array( 'class' => '' ) ) ); ?>>
	<?php
	if ( $events_query->have_posts() ) {
		?>
		<div class="festival-events festival-event-list">
			<h2 id="event-list-heading" class="screen-reader-text">All Events</h2>
			<ul class="event-list<?php echo esc_attr( $style_class ); ?>" aria-labelledby="event-list-heading" role="list">
			<?php
			while ( $events_query->have_posts() ) {
				$events_query->the_post();

				$event_post_id = get_the_id();

				$start_datetime = strtotime( get_post_meta( $event_post_id, 'event_start_datetime', true ) );
				$end_datetime = strtotime( get_post_meta( $event_post_id, 'event_end_datetime', true ) );

				$is_multi_day = get_post_meta( $event_post_id, 'event_multi_day', true );
				$is_all_day = get_post_meta( $event_post_id, 'event_all_day', true );

				// Skip events with no start time.
				if ( ! $start_datetime ) {
					continue;
				}
				?>

				<li class="event-item">
					<div class="event-info">
						<div class="event-date-card">
							<div class="date-card-month"><?php echo esc_html( gmdate( 'M', $start_datetime ) ); ?></div>
							<div class="date-card-day"><?php echo esc_html( gmdate( 'j', $start_datetime ) ); ?></div>
						</div>

						<div class="event-info-contain">
							<h3 class="event-title">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h3>

							<ul class="event-details">
								<li class="event-details-date">
									<?php festival_the_event_date( $start_datetime, $end_datetime, $is_multi_day, $site_date_format ); ?>
								</li>

								<?php if ( ! $is_all_day ) : ?>
								<li class="event-details-time">
									<?php festival_the_event_time( $start_datetime, $end_datetime, $site_time_format ); ?>
								</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</li>
			<?php } ?>
			</ul>
			<?php if ( $show_pagination ) { ?>
				<div class="post-nav">
					<?php
						echo wp_kses_post(
							paginate_links(
								array(
									'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
									'total' => $events_query->max_num_pages,
									'current' => max( 1, get_query_var( 'paged' ) ),
									'format' => '?paged=%#%',
								)
							)
						);
					?>
				</div>
			<?php } ?>
		</div>
		<?php
	} else {
		echo '<div class="festival-no-events"><p>' . esc_html__( 'There are no upcoming events to display at this time.', 'festival' ) . '</p></div>';
	}
	?>
</div>
<?php wp_reset_postdata(); ?>
