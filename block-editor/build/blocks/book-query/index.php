<?php 
/**
 * Registers the `kapital/post-query-block` block on the server.
 */
function kapital_create_book_query_block()
{
    register_block_type(
        __DIR__
    );
}
add_action('init', 'kapital_create_book_query_block');