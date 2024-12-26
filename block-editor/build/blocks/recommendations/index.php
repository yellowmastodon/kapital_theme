<?php 
/**
 * Registers the `kapital/recommendations` block on the server.
 */
function kapital_create_recommendations_block()
{
    register_block_type(
        __DIR__
    );
}
add_action('init', 'kapital_create_recommendations_block');