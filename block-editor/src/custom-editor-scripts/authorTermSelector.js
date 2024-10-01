/**
 * WordPress dependencies
 */
import { __, _x, sprintf } from '@wordpress/i18n';
import { useEffect, useMemo, useState } from '@wordpress/element';
import { FormTokenField, withFilters, SelectControl, ComboboxControl } from '@wordpress/components';

import { useSelect, useDispatch } from '@wordpress/data';
import deprecated from '@wordpress/deprecated';
import { store as coreStore } from '@wordpress/core-data';
import { useDebounce } from '@wordpress/compose';
import { speak } from '@wordpress/a11y';
import { store as noticesStore } from '@wordpress/notices';

/**
 * Internal dependencies
 */
import { store as editorStore } from '@wordpress/editor';
import { unescapeString, unescapeTerm } from './utils/terms';

/**
 * Shared reference to an empty array for cases where it is important to avoid
 * returning a new array reference on every invocation.
 *
 * @type {Array<any>}
 */
const EMPTY_ARRAY = [];

/**
 * How the max suggestions limit was chosen:
 *  - Matches the `per_page` range set by the REST API.
 *  - Can't use "unbound" query. The `FormTokenField` needs a fixed number.
 *  - Matches default for `FormTokenField`.
 */
const MAX_TERMS_SUGGESTIONS = -1;
const DEFAULT_QUERY = {
	per_page: MAX_TERMS_SUGGESTIONS,
	_fields: 'id,name',
};


/**
 * Renders a flat term selector component.
 *
 * @param {Object}  props                         The component props.
 * @param {string}  props.slug                    The slug of the taxonomy.
 * @param {boolean} props.__nextHasNoMarginBottom Start opting into the new margin-free styles that will become the default in a future version, currently scheduled to be WordPress 7.0. (The prop can be safely removed once this happens.)
 *
 * @return {JSX.Element} The rendered flat term selector component.
 */
export function AuthorTermSelector({ slug, __nextHasNoMarginBottom }) {




	const {
		hasCreateAction,
		hasAssignAction,
		terms,
		loading,
		availableTerms,
		taxonomy,
	} = useSelect(
		(select) => {
			const { getCurrentPost, getEditedPostAttribute } =
				select(editorStore);
			const { getTaxonomy, getEntityRecords, isResolving } =
				select(coreStore);
			const _taxonomy = getTaxonomy(slug);
			const post = getCurrentPost();

			return {
				hasCreateAction: _taxonomy
					? post._links?.[
					'wp:action-create-' + _taxonomy.rest_base
					] ?? false
					: false,
				hasAssignAction: _taxonomy
					? post._links?.[
					'wp:action-assign-' + _taxonomy.rest_base
					] ?? false
					: false,
				terms: _taxonomy
					? getEditedPostAttribute(_taxonomy.rest_base)
					: EMPTY_ARRAY,
				loading: isResolving('getEntityRecords', [
					'taxonomy',
					slug,
					DEFAULT_QUERY,
				]),
				availableTerms:
					getEntityRecords('taxonomy', slug, DEFAULT_QUERY) ||
					EMPTY_ARRAY,
				taxonomy: _taxonomy,
			};
		},
		[slug]
	);

	console.log(terms);

	/**
	 * Update terms for post.
	 *
	 * @param {number[]} termIds Term ids.
	 */
	const onUpdateTerms = (termIds) => {
		editPost({ [taxonomy.rest_base]: termIds });
	};

		/**
	 * Handler for checking term.
	 *
	 * @param {number} termId
	 */
		const onChange = ( termId ) => {
			const hasTerm = terms.includes( termId );
			const newTerms = hasTerm
				? terms.filter( ( id ) => id !== termId )
				: [ ...terms, termId ];
			onUpdateTerms( newTerms );
		};
	



	/* 	const { authors } = useSelect( ( select ) => {
			const { getEntityRecords } = select( 'core' )
		
			return {
				authors: getEntityRecords( 'taxonomy', 'seria', { per_page: -1 } ),
			}
		} ) */

	let options = []
	if (availableTerms) {
		options = availableTerms.map((availableTerm) => { return ({ label: availableTerm.name, value: availableTerm.id }) })
	}

	// display select dropdown
	return (
		<>
			<ComboboxControl
				options={options || []}
			/>

			{/* 		<FormTokenField
				value={ selectedTags }
				suggestions={ options }
				onInputChange = {false}
				onChange={ ( tokens ) => setSelectedTags( tokens ) }
			/> */}
		</>
	)
}

export default withFilters('editor.PostTaxonomyType')(AuthorTermSelector);