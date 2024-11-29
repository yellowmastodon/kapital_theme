<?php 

/**
 * Secondary title that is used in theme by loading it from custom meta '_secondary_title'
 * it is also included in post content for default search compatibility, but hidden from render on front end as part of content
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function kapital_register_secondary_title_block()
{
    register_block_type(
        __DIR__,
         array(
            'render_callback' => 'hide_secondary_title_on_front'
        ) 
    );
}
add_action('init', 'kapital_register_secondary_title_block');

/** 
 * Register secondary title as meta field
 */
function secondary_title_post_meta()
{
    register_post_meta('', '_secondary_title', array(
        'auth_callback' => function() { 
            return current_user_can( 'edit_posts' );
        },
        'show_in_rest'  => [
            true,
            'schema' => [
                'type'       => 'string',

            ]
        ],
        'single' => true,
        'type' => 'string',
        'default' => ""
    ));
}

add_action('init', 'secondary_title_post_meta');

/** Register as shortcode */
add_shortcode('secondary_title', 'secondary_title_rendering');

/**
 * Removes secondary title from front end rendering 
 */
function hide_secondary_title_on_front($block_attributes, $content, $block)
{
    return '';
}
