/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor. All other files
 * get applied to the editor only.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

/**
 * Internal dependencies
 */
import { useSelect, select } from '@wordpress/data';
import { createBlock } from '@wordpress/blocks';
import { __, _x, } from '@wordpress/i18n';
import { useEntityProp } from '@wordpress/core-data';
import { RichText, useBlockProps, BlockControls} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';



/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType('kapital/secondary-title', {
    edit: ({ setAttributes, attributes, context }) => {
        let is_query;
        let secondary_title;
        if (typeof context['queryId'] == 'undefined') {
            is_query = false;
        } else {
            is_query = true;
        }
        const blockProps = useBlockProps();

        const postType = useSelect(
            (select) => select('core/editor').getCurrentPostType(), []
        );
        const [meta, setMeta] = useEntityProp('postType', postType, 'meta');

        if (!is_query) {
            secondary_title = meta['_secondary_title'];
        }


        const updateMetaValue = (value) => {
            //remove bold, as that is not allowed
            value = value.replace(/(<strong>)|(<\/strong>)|(<b>)|(<\/b>)/g, "");
            setMeta({ ...meta, _secondary_title: value });
        };

        //imported from other custom plugin, let's see if we will use default query
        if (is_query) {
            return (
                <p>
                    <BlockControls group="block">
                    </BlockControls>
                    <p  {...blockProps}>
                    <ServerSideRender block="kapital/secondary-title" attributes={{postId: context["postId"], is_query: is_query}}/>
            </p>
                </p>
            );
        } else {
            return (
                <div {...blockProps}
                className= 'secondary-title alignwide text-center ff-grotesk'>
                    <RichText 
                        name="Podnadpis"
                        allowedFormats={['core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/superscript']}
                        value={secondary_title}
                        onChange={(value) => updateMetaValue(value)}
                        placeholder={__('Podnadpis (Nechajte prázdne, ak článok nemá podnadpis)')}
                        disableLineBreaks = {true}
                        className={"fw-bold"}
                    />
                </div>
            );
        }

    },

    // No information saved to the block.
    // Data is saved to post meta via the hook.
    save: () => {
        return null;
    },
});