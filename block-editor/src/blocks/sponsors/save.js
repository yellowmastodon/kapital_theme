/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
	let images = attributes.images;
	return (
		<div {...useBlockProps.save({ className: "bg-secondary rounded px-4 pt-4 ff-grotesk fw-bold kapital-sponsors lh-sm" })}>
			<div className="row g-0 align-items-center">
				<div className="col-12 col-md-auto">
					<div class="d-flex flex-wrap flex-row flex-md-column align-items-center">

						{attributes.images.map((image, key) => {
							return (
								<img
									key={key}
									className="mb-4 me-4 d-block"
									src={image.src}
									style={{ width: String(image.width) + "px", height: String(image.height) + "px" }} />
							)
						}

						)}
					</div>

				</div>
				<div class="col">
					<InnerBlocks.Content />
				</div>
			</div>
		</div>
	);
}
