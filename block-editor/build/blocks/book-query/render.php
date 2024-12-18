<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$home_plugin_path =  dirname(__DIR__, 2);

/** attributes passed from block */
$attributes;
//no wrapper for editor
$wrapper_classes = "";
global $is_woocommerce_site;

if (isset($attributes["backgroundColor"])){
	$wrapper_classes = ' bg-' . $attributes["backgroundColor"] . ' py-5'; //add also padding when background color is set
}
if (!$attributes["isEditor"]) echo '<section class="post-query alignfull px-3' . $wrapper_classes . '">';

$term_slugs = explode(",", $attributes["catQuery"]);
//trim whitespace from slugs
$term_slugs = array_map(function ($term_slug) {
	return trim($term_slug);
}, $term_slugs);

//books are products from eshop
$args = array(
	'post_type' => 'product',
	'orderby' => 'date',
	'order'   => 'DESC',
	'posts_per_page' => -1,
 	'tax_query' => array(
 		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',        
			'terms'    => $term_slugs, 
			'operator' => 'AND',
		), 
	) 
);
	
	if ($is_woocommerce_site){
		$queried_products = new WP_Query($args);
	} else {
		switch_to_blog(2);
		//WP query not working as the taxonomies not registered in php on the main site
		register_taxonomy('product_cat', 'product');
		$queried_products = new WP_Query($args);
		//var_dump($queried_products);
		unregister_taxonomy('product_cat');

	}
	if(!$attributes["isEditor"] && $attributes["showHeading"] && $attributes["headingText"] !== ""){
		echo kapital_bubble_title($attributes["headingText"], $attributes["headingLevel"], 'mb-4');
	}

	if ($queried_products->have_posts()): ?>
		<ul class="row gy-6 gx-5 list-unstyled alignwider">
				<?php
				while ($queried_products->have_posts()):
					$queried_products->the_post();
					global $post;
					$author = get_post_meta($post->ID, "_kapital_book_author", true);
					$title = get_the_title();
					if ($author && $author !== ""){
						$title = $author . ': ' . $title;
					}
					?>
					<li <?php post_class("archive-item col-12 col-sm-6 col-md-4 ff-grotesk")?>>
					<a href="<?=get_the_permalink($post)?>" class="d-block archive-item-link position-relative text-decoration-none">
						<?php echo kapital_responsive_image(get_post_thumbnail_id($post), "400px", false, 'rounded archive-item-image w-100')?>
						<h2 class="h3 mt-2 mb-2 red-outline-hover" data-text="<?=$title?>"><?=$title?></h2>
					</a>
					</li>
					<?php 
				endwhile; ?>
		</ul>
		<?php endif;

if ($is_woocommerce_site){
	wp_reset_postdata();
} else {
	wp_reset_postdata();
	restore_current_blog();
}


if (!$attributes["isEditor"]) echo '</section>'; ?>