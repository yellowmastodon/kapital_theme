/* jslint esnext: true */
/* global wp */


/**
 * Internal dependencies
 */
import {CustomTermSelector} from './customTermSelector';
import {AuthorTermSelector} from './authorTermSelector';
import {customMetaSettings} from './customMetaSettings'
import {registerKapitalButtonVariation} from '../block-variations/button';
import {registerBubbleHeadingVariation} from '../block-variations/bubble-heading';
import { useSelect, select } from '@wordpress/data';


//import {registerFormats } from './richTextCustomFormats';

//registerFormats();
registerKapitalButtonVariation();
customMetaSettings();
registerBubbleHeadingVariation();

// Based on the example here: https://github.com/WordPress/gutenberg/tree/master/packages/editor/src/components/post-taxonomies#custom-taxonomy-selector
( function() {
	const el = wp.element.createElement;
	
	// It's up to you on how to make this dynamic..
	//const flatTerms = [ 'podcast-seria', 'redakcia-tag', 'jazyk', 'seria', 'cislo', 'partner' ];
	const flatTerms = [ 'podcast-seria', 'redakcia-tag', 'jazyk', 'partner', 'cislo', 'seria', 'zaner'];
	const authorTerm = [ 'autorstvo' ];
	function modifySelector( OriginalComponent ) {
		return function( props ) {
			// props.slug is the taxonomy (slug)
			if ( flatTerms.indexOf( props.slug ) >= 0 ) {
				return el(
					CustomTermSelector,
					props
				);
			} else if( authorTerm.indexOf( props.slug ) >= 0 ){
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
} )(); // end closure

import { addFilter } from '@wordpress/hooks';
import { settings } from '@wordpress/icons';

// This filter adds alignment support to core/paragraph if not already present
const wideAlignBlocks = ['core/paragraph', 'core/heading', 'core/list' ]
const addWideAlignmentSupport = (settings) => {
		if (wideAlignBlocks.includes(settings.name)) {
			settings.supports = {
				...settings.supports,
				align: ["wide", "full"],
			};
		}
    return settings;
};

// Apply the filter to the core/paragraph block
 addFilter(
    'blocks.registerBlockType',
    'kapital/more-blocks-align-support',
    addWideAlignmentSupport
); 