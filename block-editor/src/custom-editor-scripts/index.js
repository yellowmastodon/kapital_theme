/* jslint esnext: true */
/* global wp */


/**
 * Internal dependencies
 */
import {CustomTermSelector} from './customTermSelector';
import {AuthorTermSelector} from './authorTermSelector';
import {customMetaSettings} from './customMetaSettings'
import {registerKapitalButtonVariation} from '../block-variations/button';
//import {registerFormats } from './richTextCustomFormats';

//registerFormats();
registerKapitalButtonVariation();
customMetaSettings();

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
