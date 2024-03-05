/* eslint-disable react-hooks/exhaustive-deps */
import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { useState, useEffect } from '@wordpress/element';
import { date } from '@wordpress/date';
import { useEntityProp } from '@wordpress/core-data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { isValidDate } from '../helpers';
import {
    ToggleControl,
    __experimentalToggleGroupControl as ToggleGroupControl, // eslint-disable-line @wordpress/no-unsafe-wp-apis
    __experimentalToggleGroupControlOption as ToggleGroupControlOption, // eslint-disable-line @wordpress/no-unsafe-wp-apis
} from '@wordpress/components';
import DateInput from '../components/DateInput';
import TimeInput from '../components/TimeInput';

const EventDateTimePanel = () => {
    const [meta, setMeta] = useEntityProp( 'postType', 'festival_events', 'meta' );
    const updateMetaValue = ( key, newValue ) => {
        setMeta( { ...meta, [key]: newValue } );
    };

    // Get values from meta.
    const startDateTime = meta.event_start_datetime;
    const endDateTime = meta.event_end_datetime;
    const allDay = meta.event_all_day;
    const multiDay = meta.event_multi_day;

    // Set up state for managing the separation of date and time.
    const [startDate, setStartDate] = useState(isValidDate(startDateTime) ? date('Y-m-d', startDateTime) : '');
    const [startTime, setStartTime] = useState(isValidDate(startDateTime) ? date('H:i:s', startDateTime) : '00:00:00');
    const [endDate, setEndDate] = useState(isValidDate(endDateTime) ? date('Y-m-d', endDateTime) : '');
    const [endTime, setEndTime] = useState(isValidDate(endDateTime) ? date('H:i:s', endDateTime) : '00:00:00');

    // Set string of multiday based on meta.
    const multiDayState = multiDay ? 'multi' : 'single';

    useEffect(() => {
        const startTimeFallback = (startTime && !allDay) ? startTime : '00:00:00';
        // Combine start date and time when either changes.
        const prepDateTime = date('Y-m-d H:i:s', startDate + ' ' + startTimeFallback);

        if ( isValidDate(prepDateTime) ) {
            updateMetaValue('event_start_datetime', prepDateTime);
        }
    }, [startDate, startTime, multiDay, allDay]);

    useEffect(() => {
        const endTimeFallback = endTime || '00:00';
        // Set end date and time when either changes.
        // If this is a single day event, use start date for end date.
        const endDateAlt = multiDay ? endDate : startDate;
        const endDateFallback = endDateAlt || '';
        const prepDateTime = date('Y-m-d H:i:s', endDateFallback + ' ' + endTimeFallback);

        if ( isValidDate(prepDateTime) ) {
            updateMetaValue('event_end_datetime', prepDateTime);
        }
    }, [endDate, endTime, multiDay, allDay]);

    return (
        <PluginDocumentSettingPanel
            name="festival-event-meta"
            title={__('Date & Time', 'festival')}
            className="festival-event-date-time"
        >
            <ToggleGroupControl
                label={__('Single or Multi-Day Event')}
                value={multiDayState}
                isBlock
                hideLabelFromVision
                onChange={(state) => {
                    const isMultiDay = state === 'multi';
                    updateMetaValue('event_multi_day', isMultiDay)}
                }
            >
                <ToggleGroupControlOption value="single" label="Single Day" />
                <ToggleGroupControlOption value="multi" label="Multiple Day" />
            </ToggleGroupControl>
            <DateInput
                label={__('Start Date', 'festival')}
                date={startDateTime}
                onDateChange={(newDate) => setStartDate(newDate)}
            />
            {meta.event_multi_day === false ? (
                <>
                    <ToggleControl
                        label={__('All Day', 'festival')}
                        checked={meta.event_all_day}
                        onChange={(state) => updateMetaValue('event_all_day', state)}
                    />
                    {meta.event_all_day === false ?
                        <>
                            <TimeInput
                                label={__('Start Time', 'festival')}
                                time={startDateTime}
                                onTimeChange={(newTime) => setStartTime(newTime)}
                            />
                            <TimeInput
                                label={__('End Time', 'festival')}
                                time={endDateTime}
                                onTimeChange={(newTime) => setEndTime(newTime)}
                            />
                        </>
                    : null}
                </>
            ) : (
                <DateInput
                    label={__('End Date', 'festival')}
                    date={endDateTime}
                    onDateChange={(newDate) => setEndDate(newDate)}
                    min={startDate}
                />
            )}
        </PluginDocumentSettingPanel>
    );
}

registerPlugin( 'festival-event-date-time-panel', {
    render: EventDateTimePanel,
} );