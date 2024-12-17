<?php
defined('ABSPATH') || exit;

global $product;

$limit = 10;

// Handle the legacy filter which controlled posts per page etc.
$args = apply_filters(
    'woocommerce_upsell_display_args',
    array(
        'posts_per_page' => $limit,
        'orderby'        => 'rand',
        'order'          => 'desc',
        'columns'        => 3,
    )
);
wc_set_loop_prop('name', 'up-sells');

// Get visible upsells then sort them at random, then limit result set.
$products = wc_products_array_orderby(array_filter(array_map('wc_get_product', $product->get_upsell_ids()), 'wc_products_array_filter_visible'), $args['orderby'], $args['order']);
if (count($products) <= 0) {
    $args = array(
        'posts_per_page' => 3,
        'columns'        => 3,
        'orderby'        => 'rand', // @codingStandardsIgnoreLine.
    );
    $products = array_filter(array_map('wc_get_product', wc_get_related_products($product->get_id(), $args['posts_per_page'], $product->get_upsell_ids())), 'wc_products_array_filter_visible');
}
$products = $limit > 0 ? array_slice($products, 0, $limit) : $upsells;
if (count($products) > 0): ?>

    <section class="up-sells upsells products mt-7">

        <?php echo kapital_bubble_title(__("Súvisiace produkty", "kapital"), 2, 'mb-6'); ?>

        <ul class="row gy-6 gx-5 list-unstyled">

            <?php foreach ($products as $product) : ?>

                <?php
                $post_object = get_post($product->get_id());

                setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                get_template_part('woocommerce/archive-single-product');
                ?>

            <?php endforeach; ?>

        </ul>
    </section>
<?php endif;
    
    
//woocommerce_upsell_display();
//woocommerce_output_related_products();
