/**
 * WordPress dependencies
 */

import { __, _x, } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { PanelBody, ToggleControl } from '@wordpress/components';


export default function edit({
    attributes,
    setAttributes
}) {
    const blockProps = useBlockProps({className: "alignwide"})
    return (
    <div {...blockProps}>
    <InspectorControls>
                    <PanelBody>
                        <ToggleControl
                        label={__("Zobraziť zbalený formulár", "kapital")}
                        checked={ attributes.showCollapsed }
                        onChange={ (newValue) => {
                            setAttributes({showCollapsed: newValue});
                        } }
                        __nextHasNoMarginBottom
                        />
                    </PanelBody>
    </InspectorControls>
        <ServerSideRender
        skipBlockSupportAttributes="true"
        block="kapital/donation-form"
        attributes={attributes}
    />
    </div>

    );
}