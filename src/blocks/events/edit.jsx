import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { format } from '@wordpress/date';
import {
	PanelBody,
	RadioControl,
	ToggleControl,
	FormTokenField,
	Spinner,
	__experimentalNumberControl as NumberControl, // eslint-disable-line @wordpress/no-unsafe-wp-apis
} from '@wordpress/components';

import './editor.scss';

export default function Edit({
	attributes: {
		perPage,
		showPagination,
		category,
		style,
	},
	setAttributes,
}) {
	const { categories } = useSelect((select) => {
		const { getEntityRecords } = select('core');

		return {
			categories: getEntityRecords('taxonomy', 'festival_event_category'),
		}
	});

	let optionsNames = [];
	let selectedNames = [];

	if (categories && category) {
		// Narrow down categories to those that exist in custom taxonomy.
		const intersection = categories.filter(element => category.includes(element.id));

		optionsNames = categories.map(value => value.name);
		selectedNames = intersection.map(value => value.name);
	}

	const onCategoryChange = (value) => {
		const categoryIds = [];

		value.forEach((item) => {
			const matchingCategory = categories.find(o => o.name === item);
			if (matchingCategory) {
				categoryIds.push(matchingCategory.id);
			}
		})

		setAttributes({ category: categoryIds });
	}

	const eventQuery = {
		status: 'publish',
	}
	if (category) {
		eventQuery.festival_event_category = category;
	}
	if (perPage) {
		eventQuery.per_page = perPage
	}

	const eventPosts = useSelect((select) => {
		return select('core').getEntityRecords('postType', 'festival_events', eventQuery);
	});

	const isLoading = useSelect((select) => {
		return select('core/data').isResolving('core',
			'getEntityRecords', ['postType', 'festival_events', eventQuery]);
	});

	const noEventsElement = <div className="festival-no-events">
		{eventPosts && !isLoading ? (
			<p>No events to display.</p>
		) : (
			<Spinner />
		)}
	</div>;

	return (
		<div {...useBlockProps()}>
			<InspectorControls>
				<PanelBody>
					<NumberControl
						label={__('Events per page', 'festival')}
						spinControls="none"
						min="1"
						max="100"
						onChange={(value) => setAttributes({ perPage: value })}
						value={perPage}
					/>
					<ToggleControl
						label={__('Show pagination', 'festival')}
						checked={showPagination}
						onChange={(value) => setAttributes({ showPagination: value })}
					/>
					<FormTokenField
						label={__('Category', 'festival')}
						value={selectedNames}
						suggestions={optionsNames}
						onChange={(value) => onCategoryChange(value)}
					/>
					<RadioControl
						label={__('Style', 'festival')}
						selected={style}
						options={[
							{ label: 'List', value: 'list' },
							{ label: 'Grid', value: 'grid' },
						]}
						onChange={(value) => setAttributes({ style: value })}
					/>
				</PanelBody>
			</InspectorControls>
			{eventPosts && eventPosts.length ? (
				<div className="festival-events festival-event-list">
					<h2 id="event-list-heading" className="screen-reader-text">All Events</h2>
					<ul className={`event-list is-style-${style}`} aria-labelledby="event-list-heading" role="list">{ /* eslint-disable-line jsx-a11y/no-redundant-roles */ }
						{eventPosts.map((event) => {
							return (
								<div className="event-item" id={event.id} key={event.id}>
									<div className="event-info">
										<div className="event-date-card">
											<div className="date-card-month">{format('M', event.meta.event_start_datetime)}</div>
											<div className="date-card-day">{format('j', event.meta.event_start_datetime)}</div>
										</div>

										<div className="event-info-contain">
											<h3 className="event-title">
												{event.title.rendered}
											</h3>

											<ul className="event-details">
												<li className="event-details-date">
													{!event.meta.event_multi_day ? (
														format('F j, Y', event.meta.event_start_datetime)
													) : (
														format('F j, Y', event.meta.event_start_datetime) + __(' to ', 'festival') + format('F j, Y', event.meta.event_end_datetime)
													)}
												</li>

												{!event.meta.event_all_day ? (
													<li className="event-details-time">
														{format('g:i a', event.meta.event_start_datetime) + __(' to ', 'festival') + format('g:i a', event.meta.event_end_datetime)}
													</li>
												) : null}
											</ul>
										</div>
									</div>
								</div>
							);
						})}
					</ul>
				</div>
			) : (
				noEventsElement
			)}
		</div>
	);
}
