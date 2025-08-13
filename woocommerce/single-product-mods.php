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

add_action('woocommerce_before_add_to_cart_quantity', 'kapital_woo_quantity_button_plus');
function kapital_woo_quantity_button_plus(){
    global $product;
    if (!$product->is_sold_individually()){
        $aria_description = sprintf(__('Zvýšiť počet produktu: %s o 1', 'kapital'), $product->get_title());
        echo '<div class="col-auto">'; //quantity wrapper start
        echo '<div class="product-quantity row gx-1">'; //quantity row start
        echo '<div class="col-auto">'; //this button wrapper
        echo '<button aria-label="' . $aria_description . '" class="kapital-woo-quantity-minus btn-menu" type="button"><svg class="icon-square"><use xlink:href="#icon-minus"></use></svg></button>';
        echo '</div>'; //this button wrapper end
        echo '<div class="col-auto">'; //quantity input wrapper
    } else {
        echo '<div class="d-none">'; //hide quantity if sold individually
    }
}
add_action('woocommerce_after_add_to_cart_quantity', 'kapital_woo_quantity_button_minus');

function kapital_woo_quantity_button_minus(){
    global $product;
    if (!$product->is_sold_individually()){
        $aria_description = sprintf(__('Znížiť počet produktu: %s o 1', 'kapital'), $product->get_title());
        echo '</div>'; //end quantity input wrapper
        echo '<div class="col-auto">'; //this button wrapper
        echo '<button aria-label="' . $aria_description . '" class="kapital-woo-quantity-plus btn-menu" type="button"><svg class="icon-square"><use xlink:href="#icon-plus"></use></svg></button>';
        echo '</div>'; //this button wrapper end
        echo '</div>'; //quantity row end
        echo '</div>'; //quantity wrapper end
    } else {
        echo '</div>'; //hide quantity if sold individually
    }
    if ($product->is_purchasable()){
        echo '<div class="col-auto">'; //submit button wrapper start;
    }

}


add_action('woocommerce_before_add_to_cart_button', 'kapital_woo_quantity_button_wrapper_start');
function kapital_woo_quantity_button_wrapper_start(){
    global $product;
    if ($product->is_purchasable()){
        echo '<div class="row gx-2 gy-3 align-items-center">'; //start wrapper around quantity + button
    }
}

add_action('woocommerce_after_add_to_cart_button', 'kapital_woo_quantity_button_wrapper_end');
function kapital_woo_quantity_button_wrapper_end(){
    global $product;
    if ($product->is_purchasable()){
        echo '</div>'; //end col around submit button
        echo '</div>'; //end wrapper around quantity + button
    }
}
// I decided they are ok where they are supposed to be
/** Additional info displayed directly in post
 * remove additional info tab
 */
/* add_filter('woocommerce_product_tabs', 'kapital_woo_remove_additional_info_tab', 9999, 1);
function kapital_woo_remove_additional_info_tab($tabs){
    if (isset($tabs['additional_information'])){
        unset($tabs['additional_information']);
    }
    return $tabs;
} */

//disable dimension display, as that should be last in attributes list
//add_filter('wc_product_enable_dimensions_display', function(){return(false);});
//add dimensions back in
add_filter('woocommerce_display_product_attributes', 'kapital_woo_add_dimension_to_end', 10, 2);
function kapital_woo_add_dimension_to_end($product_attributes, $product){
  

    $display_dimensions = $product->has_weight() || $product->has_dimensions();
    if ( $display_dimensions && $product->has_weight() ) {
        $weight = $product_attributes['weight'];
        unset($product_attributes['weight']);
		$product_attributes['weight'] = $weight;
	}

	if ( $display_dimensions && $product->has_dimensions() ) {
        $dimensions = $product_attributes['dimensions'];
        unset($product_attributes['dimensions']);
		$product_attributes['dimensions'] = $dimensions;
	}
    return $product_attributes;
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_after_single_product', 'kapital_woo_product_footer', 10);
function kapital_woo_product_footer(){
    get_template_part('woocommerce/single-product-footer');
}

add_filter('woocommerce_single_product_image_thumbnail_html', 'kapital_woo_single_product_image_html', 10, 2);
function kapital_woo_single_product_image_html($html, $attachment_id){
    return '<div class="col-12">' . kapital_responsive_image($attachment_id, "400px", false, "rounded w-100") . '</div>';
}

add_filter( 'woocommerce_available_variation', 'kapital_prepend_to_variation_description', 10, 3 );
function kapital_prepend_to_variation_description( $data, $product, $variation ) {
    // Add your custom HTML or text here.
    $data['variation_description'] = kapital_downloadable_product_ext($variation, 'mb-3') . $data['variation_description'];
    return $data;
}