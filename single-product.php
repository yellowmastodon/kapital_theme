<?php

/**
 * The Template for displaying all single products
 * 
 * Most actions removed with single-product-mods.php, but kept do_action for plugin compatibility
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
echo kapital_breadcrumbs([], 'container');
?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked kapital_woo_output_content_wrapper - 10 (outputs opening divs for the content)
 */
do_action('woocommerce_before_main_content');
?>

<?php while (have_posts()) : ?>
    <?php the_post();

    global $product;

    /**
     * Hook  woocommerce_before_single_product.
     *
     * @hook removed: woocommerce_output_all_notices - 10
     * we output these in header
     */
    do_action('woocommerce_before_single_product');

    if (post_password_required()) {
        echo get_the_password_form(); // WPCS: XSS ok.
        return;
    }
    ?>
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-wrapper', $product); ?>>
        <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked removed woocommerce_show_product_sale_flash - 10
         * @hooked removed woocommerce_show_product_images - 20
         */
        do_action('woocommerce_before_single_product_summary');

        //we get sale flash like this $product->is_on_sale()
        ?>
        <div class="summary entry-summary ff-grotesk">
            <?php
            /**
             * 
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked removed woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action('woocommerce_single_product_summary');
            $product_id = $product->get_id();
            $product_cat = get_the_terms($product_id, 'product_cat');
            $sale = $product->is_on_sale();
            $is_sold_out = !$product->is_in_stock();
            if ($product_cat || $sale || $is_sold_out) {
                echo '<div class="row gx-2 product-cat-row gy-3 align-items-center fs-small">';
                $cat_no = count($product_cat);
                if ($sale) {
                    echo '<div class="col-auto text-uppercase text-red">' . __("Zľava", "kapital") . '</div>';
                    if ($cat_no > 0) {
                        echo '<div class="col-auto"><span class="marker-red"></span></div>';
                    }
                    $cat_no++;
                }
                if ($is_sold_out) {
                    echo '<div class="col-auto text-uppercase text-red">' . __("Vypredané", "kapital") . '</div>';
                    if ($cat_no > 0) {
                        echo '<div class="col-auto"><span class="marker-red"></span></div>';
                    }
                    $cat_no++;
                }
                foreach ($product_cat as $key => $cat) {
                    if ($sale) $key++;
                    if ($is_sold_out) $key++;
                    echo '<div class="col-auto"><a class="text-uppercase text-decoration-none text-red" href="' .  get_term_link($cat, 'product_cat') . '">' . $cat->name . '</a></div>';
                    if ($cat_no > 1 && $key < $cat_no - 1) {
                        echo '<div class="col-auto"><span class="marker-red"></span></div>';
                    }
                }
                echo '</div>';
            }
            the_title('<h1 class="product_title entry-title mt-3 mb-0">', '</h1>');
            $book_author = get_post_meta($product->get_id(), '_kapital_book_author', true);
            if ($book_author && !empty($book_author)) {
                echo '<p class="book-author h3 fw-bold text-red mt-3 lh-sm">' . $book_author . '</p>';
            }
            woocommerce_template_single_price();
            if ($product->is_purchasable()) {
                if ($product->is_in_stock()) : ?>
                    <?php do_action('woocommerce_before_add_to_cart_form'); ?>
                    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                        <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                        <?php
                        do_action('woocommerce_before_add_to_cart_quantity');
                        woocommerce_quantity_input(
                            array(
                                'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                            )
                        );
                        do_action('woocommerce_after_add_to_cart_quantity');
                        ?>
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button btn btn-primary fw-bold button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
                        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                    </form>
                    <?php
                    do_action('woocommerce_after_add_to_cart_form'); ?>
            <?php endif;
            }
            echo wc_get_stock_html($product); // WPCS: XSS ok.

            echo apply_filters('woocommerce_short_description', $post->post_excerpt);
            wc_display_product_attributes($product); ?>
        </div>
        <div class="product-gallery">
            <div class="woocommerce-product-gallery__wrapper row gy-4">
                <?php
                $post_thumbnail_id = $product->get_image_id();
                $post_gallery_img = $product->get_gallery_image_ids();?>
                    <a class="col-12" href="<?=wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full')?>">
                        <?php echo kapital_responsive_image($post_thumbnail_id, "400px", false, 'rounded w-100');
                        //woocommerce_show_product_images(); 
                        ?>
                    </a>
                    <?php
                    $img_small_col_class = count($post_gallery_img) > 2 ? "col-4" : "col-6";
                    foreach($post_gallery_img as $img):?>
                        <a class="<?=$img_small_col_class?> col-md-12" href="<?=wp_get_attachment_url($img, 'full')?>">
                            <?=kapital_responsive_image($img, "400px", false, 'rounded w-100')?>
                        </a>
                    <?php endforeach;?>
            </div>
        </div>
        <?php

        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>


    <?php do_action( 'woocommerce_after_single_product' ); ?>

<?php endwhile; // end of the loop. 
?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>


<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */