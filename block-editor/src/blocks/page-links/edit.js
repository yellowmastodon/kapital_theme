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

import editLinks from '../utils/link-manager'
 
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function edit({
	context: { postId, postType }
}) 
{
	return(editLinks(postType, '_page_links', [{ name: "", url: "" }], __('"Filtre" stránky', "kapital"), __('Ak je zapnuté "Zobraziť filtre", pridá tieto linky medzi bublinkové filtre na vrchu stránky', 'kapital')));
}


