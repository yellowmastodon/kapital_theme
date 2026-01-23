import { __ } from '@wordpress/i18n';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { Flex } from '@wordpress/components';
import { CheckboxControl } from '@wordpress/components';
import { useState } from '@wordpress/element';

export default function EventRecordingSetting({ meta, setMeta, postType }) {
    if (postType !== "event") return;
    let recordingMeta = [];
    const OPTIONS = {
        audio: __("Audio", "kapital"),
        video: __("Video", "kapital"),
        foto: __("Foto", "kapital")
    }
    if (meta["_kapital_event_recording"] !== null) {
        //split to array and discard empty string
        recordingMeta = meta["_kapital_event_recording"].split('-').filter(r => r !== '');
    }

    return (
        <PluginDocumentSettingPanel
            name="kapital-event-recording-panel"
            title={__("Záznam podujatia")}
        >
            <Flex
                direction={"column"}
                gap={4}>

                {Object.keys(OPTIONS).map((key) => (
                    <CheckboxControl
                        key={key}
                        __nextHasNoMarginBottom
                        label={OPTIONS[key]}
                        checked={recordingMeta.includes(key)}
                        onChange={(isChecked) => {
                            let updated = isChecked
                                ? [...recordingMeta, key]
                                : recordingMeta.filter(item => item !== key);
                            setMeta({ ...meta, _kapital_event_recording: sortStringify(updated) });
                        }}
                    />
                ))}

            </Flex>
        </PluginDocumentSettingPanel>
    );

}


/**
 * Each combination is assigned a custom icon, so it is easier to check against strings in php
 * @param {Array} array 
 * @returns {string} sorted and stringified version of the array, with '-' between values
 */
const sortStringify = (array) => {
    array = array.sort();
    let string = array.join('-');
    console.log(string);
    return string;
}