<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$home_plugin_path =  dirname(__DIR__, 2);

/** attributes passed from block */
$attributes;

//no wrapper for editor
if (!$attributes["isEditor"]) echo '<section class="alignwider">';


$queried_terms = array();
$exclude_queried_terms = array();

/** for tax query setup see https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters */
$tax_query = array(); //setup empty array, will be overwriten, if filter is set
$include_tax_query = array();
$exclude_tax_query = array();
$queried_terms = array();
$exclude_queried_terms = array();
$queried_term_slugs = array();
$exclude_queried_term_slugs = array();
$exclude_post = 0;
/**
 * Post that is displayed in kapital/featured-post should be excluded
 * in editor we get it with useEntityProp
 *  */
if ($attributes["isEditor"]){
	$exclude_post = $attributes["excludePost"];
} else {
	global $post;
	$exclude_post = get_post_meta($post->ID, "_kapital_featured_post", true);
}
//setup query for editor - includes notice
if ($attributes["isEditor"]) {
	//include query
	if ($attributes["taxonomy"] !== "none" && $attributes["termQuery"] !== "") {

		//get slugs from string
		$term_slugs = explode(",", $attributes["termQuery"]);

		//trim whitespace from slugs
		$term_slugs = array_map(function ($term_slug) {
			return trim($term_slug);
		}, $term_slugs);
		//render notice for editor, if terms do not exist
		foreach ($term_slugs as $term_slug) {
			if ($term_slug !== "") {
				$queried_term = get_term_by('slug', $term_slug, $attributes["taxonomy"], OBJECT);
				if (!$queried_term) {
					echo '<p class="text-center">"' . $attributes["taxonomy"] . '" ' .  __('so slugom:', 'kapital') . ' ' . ' "' . $term_slug . '" ' . __("nenájdené", "kapital") . '</p>';
				} else {
					$queried_terms[] = $queried_term;
				}
			}
		}
		//var_dump($queried_terms);
		//remap terms back to slugs
		if (!empty($queried_terms)) {
			$queried_term_slugs = array_map(function ($queried_term) {
				return ($queried_term->slug);
			}, $queried_terms);
		}
	}

	//exclude query
	if ($attributes["taxonomyExclude"] !== "none" && $attributes["termQueryExclude"] !== "") {
		//exclude: get slugs from string
		$exclude_term_slugs = explode(",", $attributes["termQueryExclude"]);
		//exclude: trim whitespace from slugs
		$exclude_term_slugs = array_map(function ($exclude_term_slug) {
			return trim($exclude_term_slug);
		}, $exclude_term_slugs);
		//exclude: render notice for editor, if terms do not exist
		foreach ($exclude_term_slugs as $exclude_term_slug) {
			if ($exclude_term_slug !== "") {
				$exclude_queried_term = get_term_by('slug', $exclude_term_slug, $attributes["taxonomyExclude"], OBJECT);
				if (!$exclude_queried_term) {
					echo '<p class="text-center">"' . $attributes["taxonomyExclude"] . '" ' .  __('so slugom:', 'kapital') . ' ' . ' "' . $exclude_term_slug . '" ' . __("nenájdené", "kapital") . '</p>';
				} else {
					$exclude_queried_terms[] = $exclude_queried_term;
				}
			}
		}
		//exclude: remap terms back to slugs
		if (!empty($exclude_queried_terms)) {
			$exclude_queried_term_slugs = array_map(function ($exclude_term) {
				return $exclude_term->slug;
			}, $exclude_queried_terms);
		}
		
	}
} else /*setup query for front end (simpler method without notice)*/ {

	//include query
	if ($attributes["taxonomy"] !== "none" && $attributes["termQuery"] !== "") {
	//explode from block input
	$queried_term_slugs = explode(",", $attributes["termQuery"]);
	//trim whitespace
	$queried_term_slugs = array_map(function ($term_slug) {
		return trim($term_slug);
	}, $queried_term_slugs);
	}

	//exclude query
	if ($attributes["taxonomyExclude"] !== "none" && $attributes["termQueryExclude"] !== "") {
		//explode from block input
		$exclude_queried_term_slugs = explode(",", $attributes["termQueryExclude"]);
		//trim whitespace
		$exclude_queried_term_slugs = array_map(function ($exclude_term_slug) {
			return trim($exclude_term_slug);
		}, $exclude_queried_term_slugs);
	}
}

//setup tax_query
if (!empty($queried_term_slugs) && !empty($exclude_queried_term_slugs)) {
	$tax_query['relation'] = 'AND';
}
if (!empty($queried_term_slugs)) {
	$tax_query[] = array(
		'taxonomy' =>  $attributes["taxonomy"],
		'field'	=> 'slug',
		'terms'	=> $queried_term_slugs,
		'operator' => 'IN'
	);
}
if (!empty($exclude_queried_term_slugs)) {
	$tax_query[] = array(
		'taxonomy' =>  $attributes["taxonomyExclude"],
		'field'	=> 'slug',
		'terms'	=> $exclude_queried_term_slugs,
		'operator' => 'NOT IN'
	);
}
//setup query args
$args = array(
	'post_type' => $attributes["queryPostType"],
	'orderby' => 'date',
	'order'   => 'DESC',
	'post__not_in' => array($exclude_post)
);


//if "show-more button" -> render more posts so "show more" has something to show and we do not need ajax
$args['posts_per_page'] = $attributes["showMoreButton"] ? 16 : 8;

//include tax query
if (!empty($tax_query)) $args["tax_query"] = $tax_query;


$auto_heading = "";
foreach ($queried_terms as $key => $queried_term) {
	if ($key !== 0) {
		$auto_heading .= ", ";
	}
	$auto_heading .= $queried_term->name;
}
//$link = get_term_link($queried_terms[0]);

if ($attributes["queryPostType"] === "post") {
	$auto_heading = __("Najnovšie články", "kapital");
	$link = get_post_type_archive_link('post');
} elseif ($attributes["queryPostType"] === "podcast") {
	$auto_heading = __("Najnovšie podcasty", "kapital");
	$link = get_post_type_archive_link('podcast');
} else {
	$auto_heading = __("Najbližšie eventy", "kapital");
	$link = get_post_type_archive_link('event');
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

$queried_posts = new WP_Query($args);
$count = 0;
//used to hide rows on various screens, to use 
$additional_class = "";
if ($queried_posts->have_posts()): ?>
	<div class="row gx-3 gy-6 show-more-posts-wrapper <?php if ($attributes["showMoreButton"]) echo " show-more-hide"; ?>">
		<?php while ($queried_posts->have_posts()):
			$queried_posts->the_post();
			$count++;
			if ($attributes["showMoreButton"] && $count > 6) $additional_class = "hide-sm";
			if ($attributes["showMoreButton"] && $count > 8) $additional_class = "hide-sm hide-xl";
			get_template_part('template-parts/archive-single-post', null, array('additional_class' => $additional_class));
		endwhile; ?>
	</div>
	<?php if ($attributes["showMoreButton"]): ?>
		<div class="text-center mt-4"><a show-all-text="<?php echo __("Všetky články", "kapital") ?>" href="<?php echo $link ?>" class="show-more-posts btn btn-secondary"><?php echo __('Ďalšie články', 'kapital') ?><svg class="icon-square ms-2">
					<use xlink:href="#icon-arrow-down"></use>
				</svg></a></div>
	<?php endif; ?>
<?php endif;
wp_reset_postdata();

//var_dump($attributes) 

if (!$attributes["isEditor"]) echo '</section>'; ?>