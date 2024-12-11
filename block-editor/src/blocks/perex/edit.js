/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
import { useEntityProp, store as coreStore } from '@wordpress/core-data';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __, _x } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';


export default function PostExcerptEditor({
	attributes,
	setAttributes,
	context: { postId, postType, queryId },
}) {

	const [ excerpt, setExcerpt ] = useEntityProp(
		'postType',
		postType,
		'excerpt',
		postId
	);

	/**
	 * Check if the post type supports excerpts.
	 * Add an exception and return early for the "page" post type,
	 * which is registered without support for the excerpt UI,
	 * but supports saving the excerpt to the database.
	 * See: https://core.trac.wordpress.org/browser/branches/6.1/src/wp-includes/post.php#L65
	 * Without this exception, users that have excerpts saved to the database will
	 * not be able to edit the excerpts.
	 */
	const postTypeSupportsExcerpts = useSelect(
		(select) => {
			if (postType === 'page') {
				return true;
			}
			return !!select(coreStore).getPostType(postType)?.supports
				?.excerpt;
		},
		[postType]
	);
	const blockProps = useBlockProps();

	/**
	 * The excerpt is editable if:
	 * - The post type supports excerpts
	 */

	if (!postType || !postId) {
		return (
			<>
				<div {...blockProps}>
					<p>{__('This block will display the excerpt.')}</p>
				</div>
			</>
		);
	}
	
	const excerptContent = postTypeSupportsExcerpts ? (
		
			<RichText 
						identifier="content"
						tagName="p"
                        name="Podnadpis"
                        allowedFormats={['core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/superscript', 'core/footnote']}
                        value={attributes.content}
						onChange={ (newContent) =>{
							setAttributes({content: newContent})
							if(attributes.useAsExcerpt) setExcerpt(newContent);
						}
					}
                        placeholder={__('Perex (Nechajte prázdne, ak článok nemá perex)', 'kapital')}
                        disableLineBreaks = {false}
            />

	) : (
		<>
			{ ()=>{
				if(!attributes.useAsExcerpt){
					if (attributes.content == '' || typeof attributes.content)
					{attributes.content}
				} 
				excerpt || __('Tento typ obsahu nepodporuje perex.', 'kapital')
			}
				
			}
		</>
	);

	return (

		<div {...blockProps} className={'perex alignwide ff-grotesk'}>
			<InspectorControls>
				<PanelBody>
                    <ToggleControl
					label="Použiť ako zhrnutie"
					checked={ attributes.useAsExcerpt }
					onChange={ (newValue) => {
						setAttributes({useAsExcerpt: newValue});
						newValue ? setExcerpt(attributes.content.originalHTML) : setExcerpt('');
					} }
					__nextHasNoMarginBottom={true}
					/>
				</PanelBody>
			</InspectorControls>
			{excerptContent}
		</div>
	);
}