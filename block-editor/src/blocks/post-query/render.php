<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$home_plugin_path =  dirname(__DIR__, 2);


$attributes;
if (!$attributes["isEditor"]): ?><section class="alignwider"><?php endif; //no wrapper for editor
	$queried_terms = array();
	if ($attributes["taxonomy"] !== "none" && $attributes["termQuery"] !== "") {
		$term_slugs = explode(",", $attributes["termQuery"]);
		$term_slugs = array_map(function ($term_slug) {
			return trim($term_slug);
		}, $term_slugs);

		$queried_terms = [];
		//get terms with notice for editor
		if ($attributes["isEditor"]) {
			foreach ($term_slugs as $term_slug) {
				if ($term_slug !== "") {
					$queried_term = get_term_by('slug', $term_slug, $attributes["taxonomy"], OBJECT);
					if (!$queried_term) {
						echo '<p class="text-center">"' . $attributes["taxonomy"] . '" ' .  __('so slugom:', 'kapital') . ' ' . ' "' . $term_slug . '" ' . __("nenájdené", "kapital") . '</p>';
					} else{
						$queried_terms[] = $queried_term;
					}
				}
			}
		//get terms for front end display
		} else {
			$queried_terms = get_terms(
				array(
					'taxonomy' => $attributes["taxonomy"],
					'hide_empty' => true,
					'slug' => $term_slugs
				)
			);
		}

		$auto_heading = "";
		foreach ($queried_terms as $key => $queried_term){
			if ($key !== 0){
				$auto_heading .= ", ";
			}			
			$auto_heading .= $queried_term->name;
		}
		$link = get_term_link($queried_terms[0]);
	} else {
		if ($attributes["postType"] === "post") {
			$auto_heading = __("Najnovšie články", "kapital");
			$link = get_post_type_archive_link('post');
		} elseif ($attributes["postType"] === "podcast") {
			$auto_heading = __("Najnovšie podcasty", "kapital");
			$link = get_post_type_archive_link('podcast');
		} else {
			$auto_heading = __("Najbližšie eventy", "kapital");
			$link = get_post_type_archive_link('event');
		}
	}

	if ($attributes["isEditor"]) {
		if ($attributes["showHeading"] === "auto") {
			echo kapital_bubble_title($auto_heading, $attributes["headingLevel"], 'mb-5');
		}
	} else {
		if ($attributes["showHeading"] === "auto") {
			echo kapital_bubble_title($auto_heading, $attributes["headingLevel"], 'mb-5');
		} elseif ($attributes["showHeading"] === "manual") {
			echo kapital_bubble_title($attributes["headingText"], $attributes["headingLevel"], 'mb-4');
		}
	}
	$args = array(
		'post_type' => $attributes["postType"],
		'orderby' => 'date',
		'order'   => 'DESC',
	);
	$args['posts_per_page'] = $attributes["showMoreButton"] ? 16 : 8;
	$tax_query = array();
	if ($attributes["taxonomy"] !== "none" && !empty($queried_terms) !== ""){
		//we filter already queried terms, so we only query for existing slugs
		$queried_terms_slugs = array_map(function ($term){
			return $term->slug;
		}, $queried_terms);
		//var_dump($queried_terms_slugs);
		$tax_query = array(
			'taxonomy' => $attributes["taxonomy"],
			'field'   => 'slug',
			'terms'		=> $queried_terms_slugs
		);
		$args["tax_query"] = array($tax_query);
	}
	//var_dump($args);
	$queried_posts = new WP_Query($args);
	//var_dump($home_dir);
	//var_dump($queried_posts);
	$count = 0;
	//used to hide rows on various screens, to use 
	$additional_class = "";
	if ($queried_posts->have_posts()):?>
		<div class="row show-more-posts-wrapper <?php if ($attributes["showMoreButton"]) echo " show-more-hide";?>">
		<?php while ($queried_posts->have_posts()):
			$queried_posts->the_post();
			$count++;
			if ($attributes["showMoreButton"] && $count > 6) $additional_class = "hide-sm";
			if ($attributes["showMoreButton"] && $count > 8) $additional_class = "hide-sm hide-xl";
			get_template_part('template-parts/archive-single-post', null, array('additional_class'=> $additional_class));
		endwhile;?>
		</div>
		<div class="text-center"><a show-all-text="<?php echo __("Všetky články", "kapital")?>" href="<?php echo $link?>"class="show-more-posts btn btn-secondary"><?php echo __('Ďalšie články', 'kapital')?><svg class="icon-square ms-2"><use xlink:href="#icon-arrow-down"></use></svg></a></div>
	<?php endif;
	wp_reset_postdata();

	//var_dump($attributes) ?>
	<?php if (!$attributes["isEditor"]): ?></section><?php endif; ?>