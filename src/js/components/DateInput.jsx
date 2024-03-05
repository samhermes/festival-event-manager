/* eslint-disable react-hooks/exhaustive-deps */
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { padValue } from '../helpers';
import {
    Flex,
    FlexItem,
    BaseControl,
    __experimentalNumberControl as NumberControl, // eslint-disable-line @wordpress/no-unsafe-wp-apis
    SelectControl,
} from '@wordpress/components';
import { format } from '@wordpress/date';

const DateInput = ({
    label,
    date,
    onDateChange,
}) => {
    const currentDate = new Date();
    const startDate = date ? date : currentDate;

    const [month, setMonth] = useState(format('m', startDate));
    const [day, setDay] = useState(format('d', startDate));
    const [year, setYear] = useState(format('Y', startDate));

    useEffect(() => {
        const newDate = year + '-' + month + '-' + day;

        if (year && month && day) {
            onDateChange(newDate);
        } else {
            onDateChange('');
        }
    }, [month, day, year]);

    return (
        <>
            <BaseControl>
                <BaseControl.VisualLabel>{label}</BaseControl.VisualLabel>
                <Flex>
                    <FlexItem style={{flexGrow: '1'}}>
                        <SelectControl
                            options={[
                                { value: '01', label: 'January' },
                                { value: '02', label: 'February' },
                                { value: '03', label: 'March' },
                                { value: '04', label: 'April' },
                                { value: '05', label: 'May' },
                                { value: '06', label: 'June' },
                                { value: '07', label: 'July' },
                                { value: '08', label: 'August' },
                                { value: '09', label: 'September' },
                                { value: '10', label: 'October' },
                                { value: '11', label: 'November' },
                                { value: '12', label: 'December' },
                            ]}
                            value={month}
                            onChange={(value) => setMonth(value)}
                            style={{height: '36px'}}
                            __nextHasNoMarginBottom
                        />
                    </FlexItem>
                    <NumberControl
                        label={__('Day', 'festival')}
                        hideLabelFromVision
                        spinControls="none"
                        min="1"
                        max="31"
                        onChange={(value) => setDay(padValue(value))}
                        value={day}
                        className="day-input"
                        style={{width: '36px', height: '36px', textAlign: 'center'}}
                    />
                    <NumberControl
                        label={__('Year', 'festival')}
                        hideLabelFromVision
                        spinControls="none"
                        min={format('Y', currentDate)}
                        max="9999"
                        onChange={(value) => setYear(value)}
                        value={year}
                        style={{width: '56px', height: '36px', textAlign: 'center'}}
                    />
                </Flex>
            </BaseControl>
        </>
    );
}
export default DateInput;