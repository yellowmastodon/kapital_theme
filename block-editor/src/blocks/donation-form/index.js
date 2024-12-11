
/**
 * WordPress dependencies
 */
import { preformatted as icon } from '@wordpress/icons';
import {registerBlockType} from '@wordpress/blocks';
import { __, _x } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import edit from './edit';

const settings = {
	icon,
	edit,
	save: props => {
        return null;
    },
};

registerBlockType(metadata.name, settings);