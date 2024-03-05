import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { useEntityProp } from '@wordpress/core-data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import {
    TextareaControl,
    TextControl,
} from '@wordpress/components';

const EventLocationPanel = () => {
    const [meta, setMeta] = useEntityProp( 'postType', 'festival_events', 'meta' );
    const updateMetaValue = ( key, newValue ) => {
        setMeta( { ...meta, [key]: newValue } );
    };

    return (
        <PluginDocumentSettingPanel
            name="festival-event-meta"
            title={__('Location', 'festival')}
            className="festival-event-meta"
        >
            <TextareaControl
                value={meta.event_location}
                onChange={(value) => updateMetaValue('event_location', value)}
                label={__('Location Details', 'festival')}
            />
            <TextControl
                value={meta.event_url}
                onChange={(value) => updateMetaValue('event_url', value)}
                label={__('URL', 'festival')}
                type="url"
            />
            <TextControl
                value={meta.event_url_label}
                onChange={(value) => updateMetaValue('event_url_label', value)}
                label={__('Link Label', 'festival')}
                help={__('Enter a short label to use as link text.', 'festival')}
            />
        </PluginDocumentSettingPanel>
    );
}

registerPlugin( 'festival-event-location-panel', {
    render: EventLocationPanel,
} );