/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { Panel, PanelBody, SelectControl, ToggleControl, TextControl, ToolbarItem, ToolbarGroup, RangeControl, Toolbar, ToolbarButton, BaseControl } from '@wordpress/components';
import { InspectorControls, useBlockProps, RichText } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { useEntityProp, store as coreStore } from '@wordpress/core-data';
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
	context: { postId, postType }
}) {
	const queryPostType = attributes.queryPostType;
	//pass exclusion from featured post

	const taxonomies = useSelect((select) => {
		const { getTaxonomies } = select(coreStore);
		return getTaxonomies({ per_page: -1, type: queryPostType });
	}, [queryPostType]);
	const taxonomyOptions = (taxonomies ?? []).map((taxonomy) => ({
		label: taxonomy.name,
		value: taxonomy.slug,
	}));
	const Heading = `h${attributes.headingLevel}`;
	const wrapperClasses = attributes.backgroundColor ? "post-query alignfull py-5" : "post-query alignfull";
	return (
		<section {...useBlockProps({ className: wrapperClasses })}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__('Filter', 'kapital')}>
					<TextControl
							__nextHasNoMarginBottom
							label={__('Slug kategórie produktu:', 'kapital')}
							value={attributes.catQuery}
							onChange={(newValue) => { setAttributes({ catQuery: newValue }) }}
							help={__('Pri zadaní viacerých hodnôt produkt musí patriť do všetkých', 'kapital')}
					/>
					<ToggleControl
							label={__('Zobraziť nadpis', 'kapital')}
							checked={attributes.showHeading}
							onChange={(newValue) => { setAttributes({ showHeading: newValue }) }}
					/>
					<SelectControl
				__nextHasNoMarginBottom
				label={__("Úroveň nadpisu", "kapital")}
				help={__("Základný level je h2 (h1 je názov stránky)", "kapital")}
				onChange={newValue => { setAttributes({ headingLevel: newValue }) }}
				value = {attributes.headingLevel}
				options={[
					{ label: __("h1", "kapital"), value: 1 },
					{ label: __("h2", "kapital"), value: 2},
					{ label: __("h3", "kapital"), value: 3 },
					{ label: __("h4", "kapital"), value: 4 },
					{ label: __("h5", "kapital"), value: 5},
					{ label: __("h6", "kapital"), value: 6},
				]}
			/>
			</PanelBody>
				</Panel>
			</InspectorControls>
			<Heading className="bubble-heading ff-grotesk">
				<RichText
					identifier="content"
					tagName="span"
					name="Podnadpis"
					allowedFormats={['core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/superscript']}
					value={attributes.headingText}
					onChange={(newContent) => {
						setAttributes({ headingText: newContent })
					}
					}
					placeholder={__('Nadpis sekcie', 'kapital')}
					disableLineBreaks={false}
				/>
			</ Heading >
			
			<ServerSideRender
				skipBlockSupportAttributes="true"
				block="kapital/product-query"
				attributes={{ ...attributes, isEditor: true}}
			/>
		</section>
	);
}
