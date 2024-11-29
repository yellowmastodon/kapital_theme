<?php 

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function kapital_register_ad_block()
{
    register_block_type(
        __DIR__,
        /*  array(
            'render_callback' => 'ad_rendering'
        ) */
    );
}
add_action('init', 'kapital_register_ad_block');

/**
 * Server side rendering of ad block in gutenberg
 * actual rendering on the front end is handled via js and ajax call to allow caching of the posts 
 */