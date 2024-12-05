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
import { TextControl, Button, Flex, FlexItem } from '@wordpress/components';
import { useSelect, select } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { RichText, ColorPalette, useBlockProps, URLInput } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function edit({
	setAttributes,
	attributes,
	context: { postId, postType }
}) {
	const blockProps = useBlockProps();
	const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
	let podcast_links;
	if (typeof meta['_podcast_links'] == 'undefined' || meta['_podcast_links'] == '') {
		podcast_links = ([{ name: "Apple Podcasts", url: "" },{ name: "Soundcloud", url: "" },{ name: "Spotify", url: "" }]);
	} else {
		podcast_links = JSON.parse(meta['_podcast_links']);
	}
	const [inputList, setInputList] = useState(podcast_links);

	const handleRemoveClick = (key) => {
		podcast_links.splice(key, 1);
		//podcast_links = podcast_links.splice(key, 1);
		//delete podcast_links[key];
		setInputList(podcast_links);
		setMeta({ ...meta, _podcast_links: JSON.stringify(podcast_links) });

	};

	const handleAddClick = (key) => {
		podcast_links = [...podcast_links, { name: "", url: "" }];
		setInputList(podcast_links);
		//custom_ludus_buttons = ([...inputList, ["", ""]]);
		setMeta({ ...meta, _podcast_links: JSON.stringify(podcast_links) });
	};



	const updateMetaValue = (value, link_index, link_field_name) => {
		podcast_links[link_index][link_field_name] = value;
		setInputList(podcast_links);
		setMeta({ ...meta, _podcast_links: JSON.stringify(podcast_links) });
	};

	return (
		<div {...blockProps}>
			<label className="mb-1" htmlFor="dalsie_tlacidla">{__('Linky podcastu', 'kapital')}</label>
			<table>
				<tbody>
			{inputList.map((linkObject, key) => {
				return (
					<tr key={key}>
						<td>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							placeholder="Text linku"
							name="name"
							value={linkObject.name}
							onChange={(newValue) => updateMetaValue(newValue, key, "name")}
						/>
						</td>
						<td>
						<URLInput
							__next40pxDefaultSize
							name="url"
							value={linkObject.url}
							onChange={(newValue) => updateMetaValue(newValue, key, "url")}
						/>
						</td>
						{inputList.length > 1 &&
						<td>
							<Button
								__next40pxDefaultSize
								isDestructive="true"
								variant="secondary"
								onClick={() => handleRemoveClick(key)}
							>
								{__("Odstrániť link", "kapital")}
							</Button>
						</td>
						}
						{inputList.length - 1 === key &&
						<td>
							<Button
								__next40pxDefaultSize
								variant="secondary"
								onClick={() => handleAddClick(key)}
							>
								{__("Pridať link", "kapital")}
							</Button>
						</td>
						}
					</tr>
				);
			}
			)}
		</tbody>
		</table>
		</div>
	);
}


