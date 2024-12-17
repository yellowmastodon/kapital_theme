<?php

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'kapital_woo_output_content_wrapper', 10);

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

function kapital_woo_output_content_wrapper()
{
    global $post;
    $ad_rendering_class = "";
    if ($post){
        $render_settings = kapital_get_render_settings($post->ID, $post->post_type);
        if ($render_settings["show_ads"]) $ad_rendering_class = " show-ads";
        if ($render_settings["show_support"]) $ad_rendering_class .= " show-support";
    }

    echo '<main class="main container' . $ad_rendering_class . '" role="main" id="main"><div class="alignwider">';
}

remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'kapital_woo_output_content_wrapper_end', 10);
function kapital_woo_output_content_wrapper_end()
{
    echo '</div></main>';
}
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'kapital_woo_catalog_ordering', 30);
function kapital_woo_catalog_ordering(){
    echo '<div class="row mb-5"><div class="col-auto">';
    woocommerce_catalog_ordering();
    echo '</div></div>';
}
add_filter('woocommerce_catalog_orderby', 'kapital_woo_catalogordering_filter');
function kapital_woo_catalogordering_filter($order_array){
    unset($order_array['rating']);
    return $order_array;
}


// Remove the default product thumbnail display in the shop loop
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
// Add a custom product thumbnail display in the shop loop
add_action('woocommerce_before_shop_loop_item_title', 'kapital_woo_loop_product_thumbnail', 10);

function kapital_woo_loop_product_thumbnail()
{
    global $product; // Access the global product object
    // Display a responsive product image with a custom class
    echo $product ? kapital_responsive_image($product->get_image_id(), "(max-width: 600px) 95vw, (max-width: 900px) 50vw, (max-width: 1200px) 33vw, 450px", false, "rounded archive-item-image w-100") : '';
}

// Remove the default product link opening tag in the shop loop
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

// Add a custom product link opening tag in the shop loop
add_action('woocommerce_before_shop_loop_item', 'kapital_woo_before_shop_loop_item', 10);

function kapital_woo_before_shop_loop_item()
{
    global $product; // Access the global product object
    // Get the product's permalink and apply any custom filters
    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
    // Output the product's link with custom classes
    echo '<a href="' . esc_url($link) . '" class="d-block archive-item-link position-relative text-decoration-none woocommerce-LoopProduct-link woocommerce-loop-product__link">';
}
//add wraper for add to cart
add_filter('woocommerce_loop_add_to_cart_link', 'kapital_woo_add_to_cart_wrapper', 1);
function kapital_woo_add_to_cart_wrapper($link){
    $link = '<div class="add-to-cart-wrapper row gx-3 gy-3 align-items-center">' . $link . '<div class="col-auto spinner-col"><div class="spinner-border-sm spinner-border" role="status">
  <span class="visually-hidden">Loading...</span></div>
</div></div>';
    return $link;
}
// Remove the default product title display in the shop loop
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

// Add a custom product title display in the shop loop
add_action('woocommerce_shop_loop_item_title', 'kapital_woo_template_loop_product_title', 10, 2);
function kapital_woo_template_loop_product_title()
{
    global $product;
    $book_author = get_post_meta($product->get_id(), '_kapital_book_author', true);
    $title = get_the_title(); // Get the title of the product
    if ($book_author) $title = trim($book_author) . ': ' . $title;
    // Display the product title with custom classes and data-text attribute
    echo '<h2 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'h5 mt-2 mb-2 red-outline-hover')) . '" ' . 'data-text="' . $title . '">' . $title . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

// Remove the default product rating and price display in the shop loop
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

// Add a custom price display after the product loop item
add_action('woocommerce_after_shop_loop_item_title', 'kapital_woo_template_loop_price', 10);

function kapital_woo_template_loop_price()
{
    echo '<div class="mb-3 fw-bold">'; // Add custom styling around the price
    woocommerce_template_loop_price(); // Display the product price
    echo '</div>';
}

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 12;
  return $cols;
}