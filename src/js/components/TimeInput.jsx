/* eslint-disable react-hooks/exhaustive-deps */
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { timeConversion, padValue } from '../helpers';
import {
    Flex,
    BaseControl,
    ButtonGroup,
    Button,
    __experimentalNumberControl as NumberControl, // eslint-disable-line @wordpress/no-unsafe-wp-apis
} from '@wordpress/components';
import { format } from '@wordpress/date';

const TimeInput = ({
    label,
    time,
    onTimeChange,
}) => {
    const currentDate = new Date();
    const startTime = time ? time : currentDate;

    const [hour, setHour] = useState(format('h', startTime));
    const [minutes, setMinutes] = useState(format('i', startTime));
    const [amPm, setAmPm] = useState(format('A', startTime))

    useEffect(() => {
        const newTime = hour + ':' + minutes + ' ' + amPm;

        if (hour && minutes && amPm) {
            onTimeChange(timeConversion(newTime));
        } else {
            onTimeChange('');
        }
    }, [hour, minutes, amPm]);

    return (
        <>
            <BaseControl className="festival-time-input">
                <BaseControl.VisualLabel>{label}</BaseControl.VisualLabel>
                <Flex justify="flex-start">
                    <Flex gap="0" style={{width: "auto"}}>
                        <NumberControl
                            label={__('Hour', 'festival')}
                            className="input-hour"
                            hideLabelFromVision
                            spinControls="none"
                            min="1"
                            max="12"
                            onChange={(value) => setHour(padValue(value))}
                            value={hour}
                            style={{height: '36px'}}
                        />
                        <div className="input-separator">:</div>
                        <NumberControl
                            label={__('Minutes', 'festival')}
                            className="input-minutes"
                            hideLabelFromVision
                            spinControls="none"
                            min="0"
                            max="59"
                            onChange={(value) => setMinutes(padValue(value))}
                            value={minutes}
                            style={{height: '36px'}}
                        />
                    </Flex>
                    <ButtonGroup>
                        <Button
                            variant={amPm === 'AM' ? 'primary' : 'secondary'}
                            onClick={() => setAmPm('AM')}
                        >
                            {__('AM', 'festival')}
                        </Button>
                        <Button
                            variant={amPm === 'PM' ? 'primary' : 'secondary'}
                            onClick={() => setAmPm('PM')}
                        >
                            {__('PM', 'festival')}
                        </Button>
                    </ButtonGroup>
                </Flex>
            </BaseControl>
        </>
    );
}
export default TimeInput;