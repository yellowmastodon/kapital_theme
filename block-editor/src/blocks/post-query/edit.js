/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { PanelBody, SelectControl, ToggleControl, TextControl, ToolbarItem, ToolbarGroup, RangeControl, Toolbar, ToolbarButton, BaseControl } from '@wordpress/components';
import { InspectorControls, useBlockProps, RichText } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { post } from '@wordpress/icons';


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({
	attributes,
	setAttributes,
}) {

	const postType = attributes.postType;

	//console.log(coreStore);
	console.log(attributes.postType);

	const taxonomies = useSelect( ( select ) => {
		 const { getTaxonomies } = select( coreStore );
		 console.log(postType);
		 return getTaxonomies( { per_page: -1, type: postType} );
	}, [postType] );
	console.log(taxonomies);
	const taxonomyOptions = ( taxonomies ?? [] ).map((taxonomy) => ({
		label: taxonomy.name,
		value: taxonomy.slug,
	}));
	const Heading = `h${attributes.headingLevel}`;

	return (
		<section { ...useBlockProps({className: "alignwider"}) }>
			
			<InspectorControls>
				<PanelBody>
					<SelectControl
					__nextHasNoMarginBottom
					label={__("Typ obsahu", "kapital")}
					onChange={(newValue) => {
						setAttributes({postType: newValue});
						setAttributes({taxonomy: "none"});
						setAttributes({termQuery: ""})
					}}
					options={[
						{
						label: __("Články", "kapital"),
						value: 'post',
						selected: attributes.postType === "post" ? true : false
						},
						{
						label: __("Podcasty", "kapital"),
						value: 'podcast',
						selected: attributes.postType === "podcast" ? true : false
						},
						{
						label: __("Eventy", "kapital"),
						value: 'event',
						selected: attributes.postType === "event" ? true : false
						}
					]}
					/>
					<SelectControl
						__nextHasNoMarginBottom
						multiple= {false}
						value = {attributes.taxonomy}
						label={__("Typ filtra", "kapital")}
						onChange={newValue => {
							setAttributes({taxonomy: newValue});
							setAttributes({termQuery: ""})
						}}
						options={[...taxonomyOptions, {label: __("Žiaden", "kapital"), value: "none"}]}

					/>
					{ attributes.taxonomy !== "none" &&
						<TextControl
						__nextHasNoMarginBottom
						label= {__('Slug kategórie z taxonómie:', 'kapital') + ' "' + attributes.taxonomy + '"'}
						value={ attributes.termQuery }
						onChange={ (newValue) => { setAttributes({termQuery: newValue})}}
						help={__('Viacero hodnôt oddeľte čiarkou', 'kapital')}
					/>

					}
				
					<ToggleControl
						label= {__('Tlačidlo "Zobraziť viac')}
						checked={ attributes.showMoreButton }
						onChange={ (newValue) => { setAttributes({showMoreButton: newValue})}}
					/>
					<SelectControl
						label= {__('Nadpis', 'kapital')}
						checked={ attributes.showHeading }
						onChange={ (newValue) => { setAttributes({showHeading: newValue})}}
						options={[
							{label: __("Automaticky", "kapital"), value: "auto", selected: attributes.showHeading === "auto" ? true : false},
							{label: __("Manuálne", "kapital"), value: "manual", selected: attributes.showHeading === "manual" ? true : false},
							{label: __("Skryť", "kapital"), value: "hide", selected: attributes.showHeading === "hide" ? true : false},
						]}
					/>
					<SelectControl
					__nextHasNoMarginBottom
					label={__("Úroveň nadpisu", "kapital")}
					help={__("Základný level je h2 (h1 je názov stránky)", "kapital")}
					onChange={newValue => {setAttributes({headingLevel: newValue})}}
					options={[
						{label: __("h1", "kapital"), value: 1, selected: attributes.headingLevel === 1 ? true : false},
						{label: __("h2", "kapital"), value: 2, selected: attributes.headingLevel === 2 ? true : false},
						{label: __("h3", "kapital"), value: 3, selected: attributes.headingLevel === 3 ? true : false},
						{label: __("h4", "kapital"), value: 4, selected: attributes.headingLevel === 4 ? true : false},
						{label: __("h5", "kapital"), value: 5, selected: attributes.headingLevel === 5 ? true : false},
						{label: __("h6", "kapital"), value: 6, selected: attributes.headingLevel === 6 ? true : false},
					]}
					/>
				</PanelBody>
			</InspectorControls>
	
		{attributes.showHeading === "manual" &&
			<Heading class="bubble-heading ff-grotesk">
			<RichText
						identifier="content"
						tagName="span"
                        name="Podnadpis"
                        allowedFormats={['core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/superscript']}
                        value={attributes.headingText}
						onChange={ (newContent) =>{
							setAttributes({headingText: newContent})}
						}
                        placeholder={__('Nadpis sekcie', 'kapital')}
                        disableLineBreaks = {false}
            />
			</ Heading >}
			<ServerSideRender
				skipBlockSupportAttributes="true"
				block="kapital/post-query"
				attributes = {{...attributes, isEditor: true}}
			/>
		</section>
	);
}