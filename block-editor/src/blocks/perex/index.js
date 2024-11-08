
/**
 * WordPress dependencies
 */
import { postExcerpt as icon } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import edit from './edit';
import save from './save';
import transforms from './transforms';
import { registerBlockType } from '@wordpress/blocks';
import { registerBlockVariation } from '@wordpress/blocks';
import { __, _x } from '@wordpress/i18n';

const { name } = metadata;
export { metadata, name };

const settings = {
	icon,
	transforms,
	edit,
	save,
};

registerBlockType('kapital/perex', settings);