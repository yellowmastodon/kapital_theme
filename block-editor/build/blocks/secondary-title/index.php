<?php 

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function kapital_create_secondary_title_block()
{
    register_block_type(
        __DIR__,
/*         array(
            'render_callback' => 'secondary_title_rendering'
        ) */
    );
}
add_action('init', 'kapital_create_secondary_title_block');

/** Register secondary title as meta field
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
    ));
}

add_action('init', 'secondary_title_post_meta');

/** Register as shortcode */
add_shortcode('secondary_title', 'secondary_title_rendering');

//imported from other custom plugin, let's see if we will use any rendering
function secondary_title_rendering($block_attributes, $content, $block)
{
    $wrapper_attributes = get_block_wrapper_attributes(["class" => 'secondary-title has-text-align-' . $block_attributes['textAlign']]);
    if (isset($block_attributes['is_query']) && $block_attributes['is_query']) {
        $secondary_title = get_post_meta($block_attributes['postId'], '_secondary_title', true);
        if (!empty($secondary_title)) {
            return $secondary_title;
        } else {
            return '';
        }
    } else {
        $secondary_title = get_post_meta($block->context['postId'], '_secondary_title', true);
        if (!empty($secondary_title)) {

            return sprintf(
                '<p %1$s>%2$s</p>',
                $wrapper_attributes,
                $secondary_title,
            );
        } else {
            return '';
        }
    }
}
