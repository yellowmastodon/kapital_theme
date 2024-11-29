import {registerBlockType} from '@wordpress/blocks';
import {useBlockProps} from '@wordpress/block-editor';


registerBlockType('kapital/ad', {
    edit: ({ attributes }) => {
        const blockProps = useBlockProps(
            {
                className: "d-flex align-items-center justify-content-center ff-grotesk text-uppercase bg-secondary inzercia alignwidest"
            }
        )
        return(
        <div {...blockProps}>
            <div>Inzercia</div>
        </div>
        )
    },

    save: ({ attributes }) => {
        const blockProps = useBlockProps.save({
            className: "inzercia alignwidest"
        })
        return(
            <div {...blockProps}></div>
        )
    }
});