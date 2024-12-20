<?php

/**
 * Most meta fields are registered via acf
 * Author meta are registered in author_taxonomy_functions
 * Meta fields used in or modified with gutenberg blocks are registered in ../block-editor/blocks/...
 * This file only includes meta that needed specific structure and were not apropriate to register elsewhere
 */

/**
 * Register post meta which control rendering of single-post and single-podcast
 */
foreach ($post_types_with_controlled_rendering as $post_type) {
    $render_settings_schema =
    array(
        'type' => 'object',
        'properties' => [
            'show_filters' => [
                'type' => 'boolean',
                'default' => false
            ],
            'show_featured_image' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_breadcrumbs' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_title' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_author' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_categories' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_views' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_date' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_ads' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_support' => [
                'type' => 'boolean',
                'default' => true
            ],
            'show_footer' => [
                'type' => 'boolean',
                'default' => true
            ],
        ],
    );
    //set hide featured image as default for podcasts
    if ($post_type === 'podcast') $render_settings_schema["properties"]["show_featured_image"]["default"] = false;

    register_post_meta(
        $post_type,
        '_kapital_post_render_settings',
        array(
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
            'single' => true,
            'show_in_rest'  => [
                true,
                'schema' => $render_settings_schema,
            ],
            'type' => 'object',
        ),
    );
}

/**
 * registers meta for kapital/featured-post block
 * used in kapital/post-query to exclude featured post
 */

register_post_meta(
    '',
    '_kapital_featured_post',
    array(
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        },
        'single' => true,
        'show_in_rest'  => [
            true,
            'schema' => [
                'type'       => 'integer',
            ],
        ],
        'type' => 'integer',
        'default' => 0
    ),
);