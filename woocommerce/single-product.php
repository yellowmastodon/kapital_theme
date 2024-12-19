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
$shop_page_id = wc_get_page_id('shop');
$shop_page_title = get_the_title($shop_page_id);
$shop_page_permalink = get_permalink($shop_page_id);
$breadcrumbs = [[$shop_page_title, $shop_page_permalink]];
echo kapital_breadcrumbs($breadcrumbs, 'container');
?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked kapital_woo_output_content_wrapper - 10 (outputs opening divs for the content)
 */
do_action('woocommerce_before_main_content');?>


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
            $product_notice = get_post_meta($product->get_id(), '_kapital_product_notice', true);
            if ($product_notice && !empty($product_notice)):?>
                <div class="alert d-inline-block alert-warning">
                    <?=$product_notice?>
                </div>
            <?php endif;
            $product_id = $product->get_id();
            $product_cat = get_the_terms($product_id, 'product_cat');
            //filter helper category for display on "Vydavateľstvo" page
            $filtered_cat = array_filter($product_cat, function ($wp_term) {
                if ($wp_term->slug !=="kptl"){
                    return $wp_term;
                }
              });
             
            $sale = $product->is_on_sale();
            $is_sold_out = !$product->is_in_stock();
            //add custom variation image handler
            if ( $product->is_type( 'variable' ) ) {
                wp_add_inline_script('scripts', "jQuery('form.variations_form').on('found_variation',function(event,variation){if(variation.image&&variation.image.src&&variation.image.srcset){jQuery('.main-image').attr('src',variation.image.srcewImageSrc);jQuery('.main-image').attr('srcset',variation.image.srcset)}});", 'after' );
            }
            if ($product_cat || $sale || $is_sold_out) {
                echo '<div><div class="row gx-2 product-cat-row gy-3 align-items-center fs-small">';
                $cat_no = count($filtered_cat);
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
                foreach ($filtered_cat as $key => $cat) {
                    if ($sale) $key++;
                    if ($is_sold_out) $key++;
                    echo '<div class="col-auto"><a class="text-uppercase text-decoration-none text-red" href="' .  get_term_link($cat, 'product_cat') . '">' . $cat->name . '</a></div>';
                    if ($cat_no > 1 && $key < $cat_no - 1) {
                        echo '<div class="col-auto"><span class="marker-red"></span></div>';
                    } 
                }
                echo '</div></div>';
            }
            the_title('<h1 class="product_title entry-title mt-3 mb-0">', '</h1>');
            $book_author = get_post_meta($product->get_id(), '_kapital_book_author', true);
            if ($book_author && !empty($book_author)) {
                echo '<p class="book-author h4 fw-bold text-red mt-2 lh-sm">' . $book_author . '</p>';
            }
            woocommerce_template_single_price();
            woocommerce_template_single_add_to_cart();
            echo apply_filters('woocommerce_short_description', $post->post_excerpt);
            ?>
        </div>
        <div class="product-gallery woocommerce-product-gallery woocommerce-product-gallery--with-images images">
            <div class="woocommerce-product-gallery__wrapper row gy-4">
                <?php
                $post_thumbnail_id = $product->get_image_id();
                $post_gallery_img = $product->get_gallery_image_ids(); ?>
                <div class="col-12">
                    <a data-bs-toggle="modal" data-bs-target="#product-modal" class="gallery-link col-12" href="<?= wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full') ?>">
                        <?php echo kapital_responsive_image($post_thumbnail_id, "400px", false, 'rounded w-100 main-image');
                        ?>
                    </a>
                </div>
                <?php
                $img_small_col_class = count($post_gallery_img) > 2 ? "col-4" : "col-6";
                foreach ($post_gallery_img as $img): ?>
                    <div class="woocommerce-product-gallery__image col-12">
                        <a data-bs-toggle="modal" data-bs-target="#product-modal" class="gallery-link col-md-12 <?= $img_small_col_class ?>" href="<?= wp_get_attachment_url($img, 'full') ?>">
                            <?= kapital_responsive_image($img, "400px", false, 'rounded w-100') ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php

        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked removed woocommerce_upsell_display - 15
         * @hooked removed woocommerce_output_related_products - 20
         */
        do_action('woocommerce_after_single_product_summary');
        ?>
    </div>
    
    <div class="modal fade modal-fullscreen" id="product-modal" tabindex="-1" aria-hidden="true" data-bs-keyboard="true">
        <a type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <svg class="h1 mb-0 icon-square">
                <use xlink:href="#icon-close"></use>
            </svg><span class="visually-hidden"><?= __("Zavrieť galériu", "kapital") ?></span>
        </a>
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content bg-transparent border-0" id="product-modal-content">

                <div id="product-carousel" class="carousel slide px-sm-5" data-ride="false" data-interval="false" data-bs-keyboard="true">

                    <div class="carousel-inner rounded"></div>
                    <a class="position-absolute carousel-control-prev p-3 opacity-100" type="button" data-bs-target="#product-carousel" data-bs-slide="prev"><svg class="h1 mb-0 icon-square">
                            <use xlink:href="#icon-page-prev"></use>
                        </svg><span class="visually-hidden"><?= __("Predošlé", "kapital") ?></span></a>
                    <a class="position-absolute carousel-control-next p-3 opacity-100" type="button" data-bs-target="#product-carousel" data-bs-slide="next"><svg class="h1 mb-0 icon-square">
                            <use xlink:href="#icon-page-next"></use>
                        </svg><span class="visually-hidden"><?= __("Ďalšie", "kapital") ?></span></a>

                </div>
            </div>
        </div>
    </div>

    <?php do_action('woocommerce_after_single_product'); ?>

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