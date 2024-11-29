/**
 * WordPress dependencies
 */
import { __, _x, } from '@wordpress/i18n';
import { ComboboxControl, Button, Flex, FlexItem } from '@wordpress/components';

import { useSelect, useDispatch } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';


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
const MAX_TERMS = -1;
const DEFAULT_QUERY = {
	per_page: MAX_TERMS,
	_fields: 'id,name',
	orderby: 'name',
	order: 'asc',
	context: 'view'
	
};


/**
 * Renders a flat term selector component.
 *
 * @param {Object}  props                         The component props.
 * @param {string}  props.slug                    The slug of the taxonomy.
 * @param {boolean} props.__nextHasNoMarginBottom Start opting into the new margin-free styles that will become the default in a future version, currently scheduled to be WordPress 7.0. (The prop can be safely removed once this happens.)
 *
 */
export function AuthorTermSelector({ slug, __nextHasNoMarginBottom }) {
	const { editPost } = useDispatch( editorStore );
	const {
		termIds,
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
				termIds: _taxonomy
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


	//selected terms with
	let terms = availableTerms.filter(item => termIds.includes(item.id));
	
	/**
	 * Update terms for post.
	 *
	 * @param {number[]} termIds Term ids.
	 */
	const onUpdateTerms = (termIds) => {
		editPost({ [taxonomy.rest_base]: termIds });
	};
 

	let authorSearchPlaceholder = 'Vyberte autorstvo.';

		/**
	 * Handler for checking term.
	 *
	 * @param {array} termId
	 */
		const onChange = ( termId ) => {
			const hasTerm = termIds.includes( termId );
			if (!hasTerm){
				const newTerms =  [ ...termIds, termId ];
				onUpdateTerms( newTerms );
				if (newTerms.length > 0){
					authorSearchPlaceholder = 'Vyberte ďalšie autorstvo';
				} else {
					authorSearchPlaceholder = 'Vyberte autorstvo';
				}
			}
			
		};


	const removeTerm = (termId) => {
		termId = Number(termId);
		const hasTerm = termIds.includes( termId );
		if (hasTerm){
			const newTerms = termIds.filter( ( id ) => id !== termId );
			onUpdateTerms( newTerms );
			if (newTerms.length > 0){
				authorSearchPlaceholder = 'Vyberte ďalšie autorstvo';
			} else {
				authorSearchPlaceholder = 'Vyberte autorstvo';
			}
		}
	}	

	let options = []
	if (availableTerms) {
		options = availableTerms.map((availableTerm) => { return ({ label: availableTerm.name || '', value: availableTerm.id}) })
	}

	// display select dropdown
	return (
		<>
			<ComboboxControl
				options={options || []}
				onChange= {(termId) => onChange(termId)}
				placeholder = {authorSearchPlaceholder}
				value=''
			/>

			<Flex
				direction="column"
				align="start"
				gap="2"
				style={{marginTop: '16px'}}
			>
				{terms.length > 0 && 
				
				terms.map((term) => {
					return(
		
						<FlexItem
						style={{padding: '2px 2px 2px 8px', background: 'rgb(233, 233, 233)', borderRadius: '3px'}}
						>
						<span
						style={{
							lineHeight: '24px', verticalAlign: 'bottom'
						}}>
							{term.name}
						</span>
						<Button
							value={term.id}
							size={'small'}
							icon={'no-alt'}
							iconSize={16}
							onClick={event => removeTerm(event.target.closest('button').value)}>
						</Button>
						</FlexItem>
					)

				})}
			</Flex>

		</>
	)
}

export default AuthorTermSelector;