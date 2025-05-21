/**
 * Used for podcast links edit and page links edit
 */

import { __ } from '@wordpress/i18n';
import { TextControl, Button } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useBlockProps, URLInput } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';

export default function editLinks(postType, postMetaName, defaults, titleLabel, description = "", otherLabels = {}, includeBlockProps = true) {
    const DEFAULT_OTHER_LABELS = {linkPlaceholder: __("Text linku", "kapital"), urlPlaceholder: __("Vložte URL, alebo začnite písať", "kapital"), removeLink: __("Odstrániť link", "kapital"), addLink: __("Pridať link", "kapital") };
    otherLabels = {...DEFAULT_OTHER_LABELS, ...otherLabels};
    const blockProps = useBlockProps();
    const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
    let podcast_links;
    if (typeof meta[postMetaName] == 'undefined' || meta[postMetaName] == '') {
        podcast_links = defaults;
    } else {
        podcast_links = JSON.parse(meta[postMetaName]);
    }
    const [inputList, setInputList] = useState(podcast_links);

    const handleRemoveClick = (key) => {
        podcast_links.splice(key, 1);
        //podcast_links = podcast_links.splice(key, 1);
        //delete podcast_links[key];
        setInputList(podcast_links);
        setMeta({ ...meta, [postMetaName]: JSON.stringify(podcast_links) });

    };

    const handleAddClick = (key) => {
        podcast_links = [...podcast_links, { name: "", url: "" }];
        setInputList(podcast_links);
        //custom_ludus_buttons = ([...inputList, ["", ""]]);
        setMeta({ ...meta, [postMetaName]: JSON.stringify(podcast_links) });
    };

    const updateMetaValue = (value, link_index, link_field_name) => {
        podcast_links[link_index][link_field_name] = value;
        setInputList(podcast_links);
        setMeta({ ...meta, [postMetaName]: JSON.stringify(podcast_links) });
    };

    return (
        //some blocks use this with other components
        <div {...(includeBlockProps ? blockProps : {})}>
            <table>
            <thead><tr><th style={{fontWeight: "normal", fontSize: '1.2rem'}} colSpan="4">{titleLabel}</th></tr></thead>

                <tbody>

                {description !== "" &&
                        <tr>
                            <td style={{paddingBottom: '8px', paddingTop: '8px'}} className="fs-small" colSpan="4">
                                {description}
                            </td>
                        </tr>
                    } 
                    {inputList.map((linkObject, key) => {
                        return (
                            <tr key={key}>
                                <td>
                                    <TextControl
                                        style={{minWidth: '200px'}}
                                        __next40pxDefaultSize
                                        __nextHasNoMarginBottom
                                        placeholder= {otherLabels.linkPlaceholder}
                                        name="name"
                                        value={linkObject.name}
                                        onChange={(newValue) => updateMetaValue(newValue, key, "name")}
                                    />
                                </td>
                                <td>
                                    <URLInput
                                        style={{minWidth: '200px'}}
                                        __next40pxDefaultSize
                                        name="url"
                                        placeholder={otherLabels.urlPlaceholder}
                                        value={linkObject.url}
                                        onChange={(newValue) => updateMetaValue(newValue, key, "url")}
                                    />
                                </td>
                                {inputList.length > 1 &&
                                    <td>
                                        <Button
                                            __next40pxDefaultSize
                                            isDestructive="true"
                                            variant="secondary"
                                            onClick={() => handleRemoveClick(key)}
                                        >
                                            {otherLabels.removeLink}
                                        </Button>
                                    </td>
                                }
                                {inputList.length - 1 === key &&
                                    <td>
                                        <Button
                                            __next40pxDefaultSize
                                            variant="secondary"
                                            onClick={() => handleAddClick(key)}
                                        >
                                            {otherLabels.addLink}
                                        </Button>
                                    </td>
                                }
                            </tr>
                        );
                    }
                    )}
                </tbody>
            </table>
        </div>
    );

}