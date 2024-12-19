<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || ! $product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('archive-item col-12 col-sm-6 col-md-4 ff-grotesk', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');
    /**
	   
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked removed woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    $categories = get_the_terms($product->get_id(), 'product_cat');
    foreach ( $categories as $cat ) $cat_slugs[] = $cat->slug;
    $is_predpredaj =  in_array( 'predpredaj', $cat_slugs ) ? true : false; 
    if (!$product->is_in_stock()){
        echo '<span class="soldout btn-like btn-secondary">' . __("Vypredané", "kapital") . '</span>';
    } elseif ($is_predpredaj) {
        echo '<span class="predpredaj btn-like btn-red">' . __("Predpredaj", "kapital") . '</span>';
    } elseif ($product->is_on_sale()) {
        echo '<span class="onsale btn-like btn-red">' . __("Zľava", "kapital") . '</span>';
    }
    do_action('woocommerce_before_shop_loop_item_title');

    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
    //woocommerce_template_loop_product_title()
    do_action( 'woocommerce_shop_loop_item_title' );
    
    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    
    do_action( 'woocommerce_after_shop_loop_item_title' );

    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */

    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</li>