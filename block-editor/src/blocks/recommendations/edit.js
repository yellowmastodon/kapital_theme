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
	const wrapperClasses = attributes.backgroundColor ? "post-query alignfull py-5" : "post-query alignfull";
	return (
		<section {...useBlockProps({ className: wrapperClasses })}>
			<ServerSideRender
				skipBlockSupportAttributes="true"
				block="kapital/recommendations"
				attributes={{ ...attributes, isEditor: true}}
			/>
		</section>
	);
}
