/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls, RichText, MediaPlaceholder, MediaUpload, MediaUploadCheck, URLInput } from '@wordpress/block-editor';
import { useEntityProp, useEntityRecords } from '@wordpress/core-data';
import { PanelBody, ToggleControl, SelectControl, ComboboxControl, Button } from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { useState } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';
import { edit } from '@wordpress/icons';


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(
	{
		attributes,
		setAttributes,
		context: { postId, postType }
	}
) {
	let hasImages = (attributes.customImageId !== 0) ? true : false;
	console.log(attributes.customImageId);
	const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
	const [ search, setSearch ] = useState( '' );
	const { isResolving, records: posts } = useEntityRecords(
		'postType',
		attributes.featuredPostType,
		{
			per_page: 10,
			search,
		}
	);

	const setSearchDebounced = useDebounce( ( value ) => {
		setSearch( value );
	}, 100 );




	return (
		<div {...useBlockProps({className: "alignwider"})}>
			<InspectorControls>
				<PanelBody>
					<SelectControl
						__nextHasNoMarginBottom
						label={__('Obsah', 'kapital')}
						value={attributes.isPost ? "auto" : "custom"}
						onChange={(newValue) => {
							if (newValue === "auto") {
								setAttributes({ isPost: true })
							} else {
								setAttributes({ isPost: false })
							}
						}
						}
						options={[
							{ label: __("Automaticky z článku/podcastu/...", "kapital"), value: "auto" },
							{ label: __("Vlastné", "kapital"), value: "custom" },
						]
						}
					/>
					{attributes.isPost && 
						<>
						<SelectControl
							__nextHasNoMarginBottom
							label={__('Typ obsahu', 'kapital')}
							value={attributes.featuredPostType}
							onChange={(newValue)=>{
								setAttributes({featuredPostType: newValue});
								setAttributes({postId: 0}); //reset post id on post type change
							}}
							options={[
								{ label: __("Článok", "kapital"), value: "post" },
								{ label: __("Stránka", "kapital"), value: "page" },
								{ label: __("Podcast", "kapital"), value: "podcast"},
								{ label: __("Event", "kapital"), value: "event"},
							]
							}
						/>
						<ComboboxControl
						__nextHasNoMarginBottom
						label={ __(
							'Vybraný článok/podcast/...',
							'kapital'
						) }
						onChange={ (newValue) => {
							setAttributes( {postId: Number(newValue)} );
							setMeta({ ...meta, _kapital_featured_post: Number(newValue) });
						} }
						onFilterValueChange={ ( newValue ) => {
							setSearchDebounced( newValue );
						} }
						options={
							isResolving
								? [
										{
											label: __(
												'Loading...',
												'kapital'
											),
											value: 'loading',
										},
								  ]
								: posts?.map( ( post ) => ( {
										label: post?.title?.rendered,
										value: String( post?.id ),
								  } ) ) || []
						}
						value={ String(attributes.postId) || 'loading' }
					/>
					</>
					}
				</PanelBody>
			</InspectorControls>
			{attributes.isPost && 
			<ServerSideRender
				skipBlockSupportAttributes="true"
				block="kapital/featured-post"
				attributes = {attributes}
			/>
			}
			{!attributes.isPost &&
				<article className="featured-post archive-item alignwider ff-grotesk">
					<div className="row gx-4 gy-3 text-decoration-none">
						<div className="col-12 col-md-6">
						{!hasImages && (
							<MediaPlaceholder
								multiple={false}
								labels={{
									title: "Ilustračný obrázok",
								}}
								onSelect={(newImage) => setAttributes({ customImageId: newImage.id })}
							/>
						)}
						{hasImages &&
						<MediaUploadCheck>
							<MediaUpload
									multiple={false}
									addToGallery={true}
									onSelect={(newImage) => {
										
										setAttributes({ customImageId: Number(newImage.id)})
										}}
									allowedTypes={["image"]}
									value={attributes.customImageId}
									render={({ open }) => (
										<Button style={{position:"absolute", zIndex: 1, left: "16px", top: "16px", background: "white"}} icon={edit} onClick={open}>{__("Zmeniť obrázok", "kapital")}</Button>
									) }
							/>
							<ServerSideRender
											skipBlockSupportAttributes="true"
											block="kapital/featured-post"
											attributes = {{...attributes, renderOnlyImage: true}}
										/>
						</MediaUploadCheck>
										
						}
						</div>
						<div className="col-12 col-md-6">
							<URLInput
								__nextHasNoMarginBottom
								className="mb-3"
								label={__("Vlastný link", "kapital")}
								value={attributes.customLink}
								onChange={(newValue => setAttributes({customLink: newValue}))}
							/>
							<RichText
							__nextHasNoMarginBottom
							tagName='h2'
							className='h2 mt-2 mb-3 red-outline-hover'
							value={attributes.customHeading}
							onChange={(newValue)=> setAttributes({customHeading: newValue})}
							placeholder={__("Vlastný nadpis", "kapital")}
							/>

							<RichText
							tagName='p'
							value={attributes.customText}
							onChange={(newValue)=> setAttributes({customText: newValue})}
							placeholder={__("Vlastný text", "kapital")}
							/>
						</div>
					</div>
				</article>
			}
		</div>
	);
}
