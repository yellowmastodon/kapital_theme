/**
 * Used for podcast links edit and page links edit
 */

import { __ } from '@wordpress/i18n';
import { TextControl, Button } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useBlockProps, URLInput } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';

export default function editLinks(postType, postMetaName, defaults, titleLabel, description = "") {
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
        <div {...blockProps}>

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
                                        __next40pxDefaultSize
                                        __nextHasNoMarginBottom
                                        placeholder="Text linku"
                                        name="name"
                                        value={linkObject.name}
                                        onChange={(newValue) => updateMetaValue(newValue, key, "name")}
                                    />
                                </td>
                                <td>
                                    <URLInput
                                        __next40pxDefaultSize
                                        name="url"
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
                                            {__("Odstrániť link", "kapital")}
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
                                            {__("Pridať link", "kapital")}
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