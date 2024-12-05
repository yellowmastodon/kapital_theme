<?php 
/**
 * Registers the `kapital/featured-post` block on the server.
 * uses meta registered in /includes/custom_meta.php
 */
function kapital_create_sponsors_block()
{
    register_block_type(
        __DIR__
    );
}
add_action('init', 'kapital_create_sponsors_block');