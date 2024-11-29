/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
import {registerBlockType} from '@wordpress/blocks';


/**
 * Internal dependencies
 */
import metadata from './block.json';
import edit from './edit';
import save from './save';

import { heading as icon } from '@wordpress/icons';
import { useSelect, select } from '@wordpress/data';
import { createBlock } from '@wordpress/blocks';
import { __, _x, } from '@wordpress/i18n';
import { useEntityProp } from '@wordpress/core-data';
import { RichText, useBlockProps, BlockControls } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */

const settings = {
    icon,
    edit,
    save,
}
registerBlockType(metadata.name, settings);