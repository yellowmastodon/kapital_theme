import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, MediaPlaceholder, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, Flex } from '@wordpress/components';
import { edit, close, plus } from '@wordpress/icons';
import { useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
	/** @const integer total area in pixels, that each logo should occupy */
	const TOTAL_LOGO_AREA = 14000;
	const TEMPLATE = [['core/paragraph', { placeholder: __('Popiska sponzora', 'kapital') }]];

	const hasImages = attributes.images.length > 0;
	let images = hasImages ? attributes.images : [];

	/** Sets new image, and sets automatic width and height so that all logos cover the same area in pixels */
	async function calculateAndRemapImages(newImages) {
		const remappedImages = [];
		for (let i = 0; i < newImages.length; i++) {
			const img = {};
			img.id = newImages[i].id;
			img.src = newImages[i].url;

			if (newImages[i].mime !== "image/svg+xml") {
				let imageScaling = Math.sqrt(TOTAL_LOGO_AREA / newImages[i].sizes.full.width / newImages[i].sizes.full.height);
				img.height = newImages[i].sizes.full.height * imageScaling;
				img.width = newImages[i].sizes.full.width * imageScaling;
			} else {
				const svg = await fetch(newImages[i].url).then(response => response.text());
				let svgData = String(svg.match(/<svg[\s\S]*?>/i));
				let SVGwidth = svgData.match(/width="[\s\S]*?"/i);
				let SVGheight = svgData.match(/height="[\s\S]*?"/i);
				// Use viewbox if width/height are missing
				if (!SVGheight || !SVGwidth) {
					let viewBox = svgData.match(/viewBox=".*?"/i);
					if (viewBox) {
						const viewBoxValues = viewBox[0].slice(9).replace('"', '').split(' ');
						SVGwidth = Number(viewBoxValues[2]);
						SVGheight = Number(viewBoxValues[3]);
					} else {
						SVGwidth = 1;
						SVGheight = 1;
					}
				} else {
					SVGheight = parseFloat(SVGheight[0].slice(8).replace('"', '').replace('px', ''));
					SVGwidth = parseFloat(SVGwidth[0].slice(7).replace('"', '').replace('px', ''));
				}

				let imageScaling = Math.sqrt(TOTAL_LOGO_AREA / SVGheight / SVGwidth);
				img.height = SVGheight * imageScaling;
				img.width = SVGwidth * imageScaling;
			}

			remappedImages.push(img);
		}
		return remappedImages;
	}

	const updateImages = async (newImages) => {
		const remappedImages = await calculateAndRemapImages(newImages);
		setAttributes({ images: remappedImages });
	};

	return (
		<div {...useBlockProps({ className: "bg-secondary rounded px-4 pt-4 ff-grotesk fw-bold lh-sm kapital-sponsors" })}>
			<div className="row g-0 align-items-center">
				<div className="col-12 col-md-auto">
					{!hasImages && (
						<div className="mb-4 me-4">
							<MediaPlaceholder
								multiple
								allowedTypes={["image"]}
								style={{ maxWidth: "300px" }}
								labels={{
									title: __("Logá sponzora", "kapital"),
								}}
								onSelect={updateImages}
							/>
						</div>
					)}
					<div className="d-flex flex-row flex-wrap flex-md-column position-relative align-items-center">

						{hasImages && (
							<MediaUploadCheck>
								<MediaUpload
									multiple
									gallery
									onSelect={updateImages}
									allowedTypes={["image"]}
									value={images.map((image) => image.id)}
									render={({ open }) => (
										<Flex gap={1} style={{ position: "absolute", zIndex: 1, left: "4px", bottom: "4px" }} justify="left">
											<Button label={__("Zmeniť logá", "kapital")} style={{ background: "white" }} icon={edit} onClick={open} />
										</Flex>
									)}
								/>
							</MediaUploadCheck>
						)}
						{attributes.images.map((image, key) => (
							<img
								className="mb-4 me-4 d-block"
								key={key}
								src={image.src}
								style={{ width: `${image.width}px`, height: `${image.height}px` }}
							/>
						))}
					</div>
				</div>
				<div class="col">
					<InnerBlocks template={TEMPLATE} />
				</div>
			</div>
		</div>
	);
}
