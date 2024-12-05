import { __ } from '@wordpress/i18n';
import classnames from 'classnames';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, Button, SelectControl } from '@wordpress/components';
import { addFilter } from '@wordpress/hooks';
import { useBlockProps } from '@wordpress/block-editor';

export function registerKapitalButtonVariation() {

    function addCustomAttributes(settings, name) {

        if (settings.name !== 'core/button') {
            return settings
        }
        //add custom attributes

        if (settings.attributes) {

            settings.attributes.icon = {
                type: 'string',
                default: 'none'
            };

            settings.attributes.iconAlign = {
                type: 'string',
                default: "icon-right"
            };
        }

        return settings;
    }

    addFilter('blocks.registerBlockType', 'core/button', addCustomAttributes);



    const withInspectorControls = createHigherOrderComponent((BlockEdit) => {
        return (props) => {
            const {
                attributes: { size },
                setAttributes,
                name,
              } = props;
              if (name !== 'core/button') {
                return <BlockEdit {...props} />;
              }
            return (
                <Fragment>
                    <BlockEdit {...props} />
                    <InspectorControls>
                        <PanelBody title="Ikona">
                            <SelectControl
                                __nextHasNoMarginBottom
                                label={__('Ikona', 'kapital')}
                                value={attributes.icon}
                                onChange={(newValue) => {
                                    setAttributes({ icon: newValue });
                                }}
                                options={[
                                    { label: __("Žiadna", "kapital"), value: "none" },
                                    { label: __("→", "kapital"), value: "icon-arrow-right" },
                                    { label: __("↓", "kapital"), value: "icon-arrow-down" },
                                    { label: __("↗", "kapital"), value: "icon-arrow-up-right" },
                                ]
                                }
                            />
                            {attributes.icon !== "none" &&
                                <SelectControl
                                    __nextHasNoMarginBottom
                                    label={__('Ikona', 'kapital')}
                                    value={attributes.iconAlign}
                                    onChange={(newValue) => {
                                        setAttributes({ iconAlign: newValue });
                                    }}
                                    options={[
                                        { label: __("Vpravo", "kapital"), value: "icon-right" },
                                        { label: __("Vľavo", "kapital"), value: "icon-left" },
                                    ]
                                    }
                                />
                            }
                        </PanelBody>
                    </InspectorControls>
                </Fragment>
            );
        };
    }, 'withInspectorControl');

    /**
     * Add custom element class in save element.
     *
     * @param {Object} extraProps     Block element.
     * @param {Object} blockType      Blocks object.
     * @param {Object} attributes     Blocks attributes.
     *
     * @return {Object} extraProps Modified block element.
     */

    addFilter(
        'editor.BlockEdit',
        'core/button',
        withInspectorControls
    );


    /**
     * Add icon class to the block in the editor
     */
    const addIconClass = createHigherOrderComponent((BlockListBlock) => {
        return (props) => {
            const {
                attributes: { icon, iconAlign },
                className,
                name,
            } = props;

            if (name !== 'core/button') {
                return <BlockListBlock {...props} />;
            }
            return (
                <BlockListBlock
                    {...props}
                    className={classnames(className, icon !== "none" ? `${icon} ${iconAlign}` : '')}
                />
            );
        };
    }, 'withClientIdClassName');

    addFilter(
        'editor.BlockListBlock',
        'kapital/button-block/add-editor-class',
        addIconClass
    );

}