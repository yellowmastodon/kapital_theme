import { useBlockProps, RichText } from '@wordpress/block-editor';
    

export default function save( {attributes}) {
    const blockProps = useBlockProps.save( {className: 'perex alignwide ff-grotesk'});
    if (attributes.content !== ''){
        return (
            <p { ...blockProps }>
               <RichText.Content value={ attributes.content } />
            </p>
        );
    }
   else{
    return;
   }
}