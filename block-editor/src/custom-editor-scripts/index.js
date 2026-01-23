/* jslint esnext: true */
/* global wp */


/**
 * Internal dependencies
 */
import { CustomTermSelector } from './customTermSelector';
import { AuthorTermSelector } from './authorTermSelector';
import { customMetaSettings } from './customMetaSettings'
import { ButtonTTS } from './ButtonTTS';
import { registerKapitalButtonVariation } from '../block-mods/button';
import { registerBubbleHeadingVariation } from '../block-mods/bubble-heading';


//import {registerFormats } from './richTextCustomFormats';

//registerFormats();
registerKapitalButtonVariation();
ButtonTTS();
customMetaSettings();
registerBubbleHeadingVariation();
//setImageDefaultWide();

// Based on the example here: https://github.com/WordPress/gutenberg/tree/master/packages/editor/src/components/post-taxonomies#custom-taxonomy-selector
(function () {
	const el = wp.element.createElement;

	// It's up to you on how to make this dynamic..
	//const flatTerms = [ 'podcast-seria', 'redakcia-tag', 'jazyk', 'seria', 'cislo', 'partner' ];
	const flatTerms = ['podcast-seria', 'redakcia-tag', 'jazyk', 'partner', 'cislo', 'seria', 'zaner'];
	const authorTerm = ['autorstvo'];
	function modifySelector(OriginalComponent) {
		return function (props) {
			// props.slug is the taxonomy (slug)
			if (flatTerms.indexOf(props.slug) >= 0) {
				return el(
					CustomTermSelector,
					props
				);
			} else if (authorTerm.indexOf(props.slug) >= 0) {
				return el(
					AuthorTermSelector,
					props
				);
			}
			return el(
				OriginalComponent,
				props
			);
		};
	}

	wp.hooks.addFilter(
		'editor.PostTaxonomyType',
		'kapital/custom-term-selector', // you should change this
		modifySelector
	);
})(); // end closure

import { addFilter } from '@wordpress/hooks';
import { settings } from '@wordpress/icons';

const setBlockDefaults = (settings) => {

	//Add alignment support to core/paragraph if not already present
	const wideAlignBlocks = ['core/paragraph', 'core/heading', 'core/list']

	if (wideAlignBlocks.includes(settings.name)) {
		settings.supports = {
			...settings.supports,
			align: ["wide", "full"],
		};
	}

	//setting wide broke gallery, so no default wide
	if (settings.name === 'core/image') {
		settings.attributes = {
			...settings.attributes,
			className: {
				type: 'string',
				default: 'is-style-rounded'
			},
		}

	};
	if (settings.name === 'core/gallery') {
		settings.attributes = {
			...settings.attributes,
			lightBox: {
				"allowEditing": true,
				"enabled": true
			},
			align: {
				type: 'string',
				default: 'full'
			},
			imageCrop: {
				type: 'bool',
				defualt: false
			},
			style: {
				...settings.attributes.style,
				default: {
					...settings.attributes.style?.default,
					spacing: {
						blockGap: '1rem',
					},
				},
			}
		}
		settings.supports = {
			...settings.supports,
			align: ['wide', 'full']
		}

	};

	return settings;

}
// Apply the filter to the core/paragraph block
addFilter(
	'blocks.registerBlockType',
	'kapital/block-defaults',
	setBlockDefaults
); 
