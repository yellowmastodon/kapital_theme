
/**
 * WordPress dependencies
 */
import { postExcerpt as icon } from '@wordpress/icons';
import transforms from './transforms';
import {registerBlockType} from '@wordpress/blocks';
import { __, _x } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import edit from './edit';
import save from './save';

const settings = {
	icon,
	transforms,
	edit,
	save,
};

registerBlockType(metadata.name, settings);