<?php



function kapital_woo_quantity_script()
{
    // Check if we're on the cart page
    if (is_cart() || is_product()) {
        wp_enqueue_script('cart-quantity', get_stylesheet_directory_uri() . '/js/cart-quantity.min.js', [], null, true);
    }
}
add_action('wp_footer', 'kapital_woo_quantity_script');
