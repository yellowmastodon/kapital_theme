<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$home_plugin_path =  dirname(__DIR__, 2);

/** attributes passed from block */
$attributes;
$heading_level = 2;
if (isset($attributes["headingLevel"])) {
	$heading_level = $attributes["headingLevel"];
}

//no wrapper for editor
$wrapper_classes = "";
$section_start = "";
if (isset($attributes["backgroundColor"])) {
	$wrapper_classes = ' bg-' . $attributes["backgroundColor"] . ' py-5'; //add also padding when background color is set
}
if (!$attributes["isEditor"]) $section_start = '<section class="post-query alignfull px-3' . $wrapper_classes . '">';


$recommendations = get_posts(array(
	'post_type' => 'recommendation',
	'posts_per_page' => -1,
	'date_query' => array(
		'after' => 'yesterday'
	)
));
//remove ads that have not yet started
$today = date('Y-m-d');


if (!empty($recommendations)):
	$no_of_rendered_recs = 0;
	ob_start();
	foreach ($recommendations as $rec):
		$rec_fields = get_fields($rec->ID);
		if ($rec_fields["recommendation_start_date"] <= $today):
			$no_of_rendered_recs++;
?>
			<li class="archive-item recommendation col-12 col-sm-6 col-md-4 col-xl-3 archive-item ff-grotesk">
				<a class="archive-item-link text-decoration-none" href="<?= $rec_fields["recommendation_url"] ?>">
					<?php
					$thumbnail_image_id = get_post_thumbnail_id($rec);
					if (isset($thumbnail_image_id) && $thumbnail_image_id !== "") {
						echo kapital_responsive_image($thumbnail_image_id, "(max-width: 599px) 95vw, (max-width: 899px) 47vw, (max-width: 1199px) 32vw, (max-width: 1399px) 300px, (max-width: 1649px) 260px, 312px", false, 'rounded w-100 archive-item-image');
					}

					$post_title = $rec->post_title;
					?>
					<<?= 'h' . ($attributes["headingLevel"] - 1) ?> class="archive-item-heading mt-2 mb-3 red-outline-hover" data-text="<?php echo $post_title ?>"><?php echo $post_title ?></<?= 'h' . ($attributes["headingLevel"] - 1) ?>>
					<div class="item-excerpt red-color-hover lh-sm">
						<?php 
						echo apply_filters('the_content', $rec->post_content );  ?>
					</div>
				</a>
			</li>
<?php
		endif;
	endforeach;
	$recs_html = ob_get_clean();
	if ($no_of_rendered_recs > 0) {
		echo $section_start . '<div class="alignwider">' 
		. kapital_bubble_title(__("Kapitál odporúča", "kapital"), $heading_level, "mb-5")
		. '<ul class="list-unstyled mb-0 justify-content-center row gx-3 gy-6 show-more-posts-wrapper">' 
		. $recs_html . '</ul></div></section>';
	} elseif ($attributes["isEditor"]) {
		echo _("Nenašli sa žiadne odporúčania", "kapital");
	}
endif;
//var_dump($attributes)

if (!$attributes["isEditor"]) echo '</section>'; ?>