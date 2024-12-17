<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$shop_page_id = wc_get_page_id('shop');
$shop_page_title = get_the_title($shop_page_id);
$shop_page_permalink = get_the_permalink($shop_page_id);
$breadcrumbs = [[$shop_page_title, $shop_page_permalink]];
if (is_search()) {
	/* translators: %s: search query */
	$page_title = sprintf(__('Search results: &ldquo;%s&rdquo;', 'woocommerce'), get_search_query());
	if (get_query_var('paged')) {
		/* translators: %s: page number */
		$page_title .= sprintf(__('&nbsp;&ndash; Page %s', 'woocommerce'), get_query_var('paged'));
	}
} elseif (is_tax()) {
	$page_title = single_term_title('', false);
	
} else {
	$breadcrumbs[0][2] = 'active';
	$page_title   = $shop_page_title;
}

$page_title = apply_filters('woocommerce_page_title', $page_title);

echo kapital_breadcrumbs($breadcrumbs, 'container');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

do_action( 'woocommerce_before_main_content' );
/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
//do_action( 'woocommerce_shop_loop_header' );
?>
<header class="alignwide">
<?php
if (is_search()){
	echo '<h1>' . $page_title . '</h1>';
} else {
	if (strcasecmp($page_title, 'kniha') == 0){
		echo kapital_bubble_title('Knihy', 1);
	} else {
		echo kapital_bubble_title($page_title, 1);
	}
}?>
</header>
<?php
$is_term_archive = is_tax();
$is_general_post_archive = !$is_term_archive;

if ($is_term_archive){
	echo kapital_post_filters($is_general_post_archive, $is_term_archive, get_queried_object_id(), 'product_cat', 'product');
} else {
	echo kapital_post_filters($is_general_post_archive, $is_term_archive, 0, 'product_cat', 'product');
}

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action('woocommerce_before_shop_loop')?>
	<div>
    <ul class="row gy-6 gx-5 list-unstyled">
    <?php
	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );
			get_template_part( 'woocommerce/archive-single-product' );
		}
	}
?>
</ul>
</div>
<?php
	//woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked removed: woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
	echo kapital_pagination();
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );