import {RichText, useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const blockProps = useBlockProps.save({className: "fw-bold secondary-title alignnormal text-center ff-grotesk"});
    if (attributes.content !== '') {
        return (
            <p {...blockProps}>
                <RichText.Content
                value={attributes.content}
                />
            </p>
        );
    }
    else {
        return;
    }
}