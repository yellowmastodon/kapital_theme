/**
 * WordPress dependencies
 */

import { __, _x, } from '@wordpress/i18n';
import { useEntityProp, store as coreStore } from '@wordpress/core-data';
import { RichText, useBlockProps, BlockControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { useSelect } from '@wordpress/data';


export default function edit({
    attributes,
    setAttributes,
    context: {postId, postType}
}) {
    let secondary_title;

    const blockProps = useBlockProps();

    const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
    const updateMetaValue = (value) => {
        //remove bold, as that is not allowed
        value = value.replace(/(<strong>)|(<\/strong>)|(<b>)|(<\/b>)/g, "");
        setMeta({ ...meta, _secondary_title: value });
    };

    return (
            <RichText {...blockProps}
                tagName="p"
                name="Podnadpis"
                allowedFormats={['core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/superscript']}
                value={attributes.content}
                onChange={(newContent) => {
                    updateMetaValue(newContent);
                    setAttributes({ content: newContent })
                }
                }
                placeholder={__('Podnadpis (Nechajte prázdne, ak článok nemá podnadpis)')}
                disableLineBreaks={true}
                className={"fw-bold secondary-title alignnormal text-center ff-grotesk"}
            />
    );


}