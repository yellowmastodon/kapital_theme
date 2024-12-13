<?php
remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

/** Additional info displayed directly in post
 * remove additional info tab
 */
add_filter('woocommerce_product_tabs', 'kapital_woo_remove_additional_info_tab', 9999, 1);
function kapital_woo_remove_additional_info_tab($tabs){
    if (isset($tabs['additional_information'])){
        unset($tabs['additional_information']);
    }
    return $tabs;
}
//disable dimension display, as that should be last in attributes list
add_filter('wc_product_enable_dimensions_display', function(){return(false);});
//add dimensions back in
add_filter('woocommerce_display_product_attributes', 'kapital_woo_add_dimension', 10, 2);
function kapital_woo_add_dimension($product_attributes, $product){
    $display_dimensions = $product->has_weight() || $product->has_dimensions();
    if ( $display_dimensions && $product->has_weight() ) {
		$product_attributes['weight'] = array(
			'label' => __( 'Weight', 'woocommerce' ),
			'value' => wc_format_weight( $product->get_weight() ),
		);
	}

	if ( $display_dimensions && $product->has_dimensions() ) {
		$product_attributes['dimensions'] = array(
			'label' => __( 'Dimensions', 'woocommerce' ),
			'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
		);
	}
    return $product_attributes;
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_after_single_product', 'woocommerce_upsell_display', 10);
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 20);


add_filter('woocommerce_single_product_image_thumbnail_html', 'kapital_woo_single_product_image_html', 10, 2);
function kapital_woo_single_product_image_html($html, $attachment_id){
    return '<div class="col-12">' . kapital_responsive_image($attachment_id, "400px", false, "rounded w-100") . '</div>';
}