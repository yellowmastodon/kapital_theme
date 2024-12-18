import {registerBlockVariation} from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import classNames from 'classnames';


export function registerBubbleHeadingVariation() {
    registerBlockVariation(
        'core/heading',
        {
            name: "bubble-heading",
            title: __('Bublinkový nadpis', 'kapital'),
            attributes: {
                className: 'bubble-heading'
            },
        }
    );    
}
