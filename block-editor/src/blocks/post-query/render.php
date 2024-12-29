<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$home_plugin_path =  dirname(__DIR__, 2);

/** attributes passed from block */
$attributes;

//no wrapper for editor
$wrapper_classes = "";
if (isset($attributes["backgroundColor"])){
	$wrapper_classes = ' bg-' . $attributes["backgroundColor"] . ' py-5'; //add also padding when background color is set
}
if (!$attributes["isEditor"]) echo '<section class="post-query alignfull px-3' . $wrapper_classes . '">';


$queried_terms = array();
$exclude_queried_terms = array();

/** for tax query setup see https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters */
$tax_query = array(); //setup empty array, will be overwriten, if filter is set
$include_tax_query = array();
$exclude_tax_query = array();
/** @var array $queried_terms array of WP_Term objects set by users with slugs */
$queried_terms = array();
/** @var array $exclude_queried_terms array of WP_Term objects set by users with slugs from attribute termExclude */
$exclude_queried_terms = array();
$queried_term_slugs = array();
$exclude_queried_term_slugs = array();
$exclude_post = 0;
/**
 * Post that is displayed in kapital/featured-post should be excluded
 * in editor we get it with useEntityProp
 *  */
if ($attributes["isEditor"]) {
	$exclude_post = $attributes["excludePost"];
} else {
	global $post;
	$exclude_post = (int) get_post_meta($post->ID, "_kapital_featured_post", true);
}

/**
 * SETUP QUERY
 */

/**
 * SETUP INCLUDE QUERY
 */

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
				//render notice in editor
				if ($attributes["isEditor"]){
					echo '<p class="text-center">"' . $attributes["taxonomy"] . '" ' .  __('so slugom:', 'kapital') . ' ' . ' "' . $term_slug . '" ' . __("nenájdené", "kapital") . '</p>';
				}
			} else {
				$queried_terms[] = $queried_term;
			}
		}
	}
	//return slugs back for tax query
	if (!empty($queried_terms)) {
		$queried_term_slugs = array_map(function ($queried_term) {
			return ($queried_term->slug);
		}, $queried_terms);
	}
}


/** 
 * EXCLUDE QUERY
 * includes two methods
 * easier method for front end without getting terms and notice
*/
if ($attributes["isEditor"]) {
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
} else { /*setup exclude query for front end (simpler method without notice)*/
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
// if newest post selected in featured post blog, it has value zero
if ($exclude_post === 0){
	unset($args['post__not_in']);
	$args['offset'] = 1;
}

//if "show-more button" -> render more posts so "show more" has something to show and we do not need ajax
$is_term_archive = $attributes["taxonomy"] !== "none" && $attributes["termQuery"] !== "" && !empty($queried_terms);

if ($attributes["queryPostType"] === 'post') {
	if (!$is_term_archive){
		$args['posts_per_page'] = $attributes["showMoreButton"] ? 16 : 8;
	} else {
		$args['posts_per_page'] = $attributes["showMoreButton"] ? 8 : 4;
	}
} elseif ($attributes["queryPostType"] === 'podcast') {
	$args['posts_per_page'] = $attributes["showMoreButton"] ? 6 : 3;
} else {
	$args['posts_per_page'] = $attributes["showMoreButton"] ? 12 : 6;
}

//include tax query
if (!empty($tax_query)) $args["tax_query"] = $tax_query;

$auto_heading = "";
$link = "";
$link_texts = ["", ""];

//Setup auto heading, and links
if ($attributes["queryPostType"] === "post") {
	$auto_heading = __("Najnovšie články", "kapital");
	$link = get_post_type_archive_link('post');
	$link_texts = [__("Ďalšie články", "kapital"), __("Všetky články", "kapital")];
} elseif ($attributes["queryPostType"] === "podcast") {
	$auto_heading = __("Podcasty", "kapital");
	$link = get_post_type_archive_link('podcast');
	$link_texts = [__("Ďalšie podcasty", "kapital"), __("Všetky podcasty", "kapital")];
} elseif ($attributes["queryPostType"] === "event") {
	$auto_heading = __("Najbližšie eventy", "kapital");
	$link = get_post_type_archive_link('event');
	$link_texts = [__("Ďalšie podujatia", "kapital"), __("Všetky podujatia", "kapital")];
}

/**
 * setup auto heading and links for term query
 * override above settings only if terms exist
 * */
if ($is_term_archive){
	foreach ($queried_terms as $key => $queried_term) {
		if ($key !== 0) {
			$auto_heading .= ", ";
			$auto_heading .= $queried_term->name;
		} else {
			$auto_heading = $queried_term->name;
			//link just first term. Maybe find other solution in the future
			$link = get_term_link($queried_term);
		}
	}
}

//create show more button
$link_button = "";
if ($attributes["showMoreButton"]){
	$link_button = '<div class="text-center"><button show-all-text="' . $link_texts[1] . '" data-href="' . $link . '" class="show-more-posts btn btn-secondary">' . $link_texts[0] . '<svg class="icon-square ms-2"><use xlink:href="#icon-arrow-down"></use></svg></button></div>';
}
//setup term description
$term_description = "";
if ($is_term_archive && $attributes["showDescription"]){
	if ($queried_terms[0]->description !== ""){
		$term_description = '<div class="term-description alignwide mb-4 mt-0 h4 text-center ff-grotesk fw-bold lh-sm">';
		foreach ($queried_terms as $queried_term){
			$term_description .= wpautop($queried_term->description, true);
		}
		$term_description .= '</div>';
	}
}

$heading_margin_b = 'mb-5';
if ($attributes["queryPostType"] === "post"){
	$heading_margin_b = $term_description === "" ? 'mb-4' : 'mb-3';
}
if ($attributes["isEditor"]) {
	if ($attributes["showHeading"] === "auto") {
		echo kapital_bubble_title($auto_heading, $attributes["headingLevel"], $heading_margin_b); //smaller margin bottom with term description
	}
} else {
	if ($attributes["showHeading"] === "auto") {
		echo kapital_bubble_title($auto_heading, $attributes["headingLevel"], $heading_margin_b);
	} elseif ($attributes["showHeading"] === "manual") {
		echo kapital_bubble_title($attributes["headingText"], $attributes["headingLevel"], $heading_margin_b);
	} else {
		echo '<h' . $attributes["headingLevel"] . ' class="visually-hidden">' . $auto_heading . '</h' . $attributes["headingLevel"] .  '>';
	}
}
//render term description
echo $term_description;

$queried_posts = new WP_Query($args);
if ($attributes["queryPostType"] === 'post'):
	$count = 0;
if ($queried_posts->have_posts()):
		//justify post center when too few posts
		if ($queried_posts->post_count < 4) {
			$justify_class = " justify-content-center";
		} else {
			$justify_class = " justify-content-start";
		}
		if (empty($queried_terms) || $attributes["taxonomy"] === "none"){
			$show_count = array("small" => 6, 'xl' => 8);
		} else {
			$show_count = array("small" => 3, "xl" => 4);
		};
		
		/** filters
		 * only renders filters for first term, maybe fix in the future?
		 */
		if ($attributes["showFilters"]){
			if ($is_term_archive){
				echo kapital_post_filters(!$is_term_archive, $is_term_archive, false, $queried_terms[0]->term_id, $queried_terms[0]->taxonomy);
			} else {
				echo kapital_post_filters(!$is_term_archive, $is_term_archive, false); 
			}
		}
		?>
		<div class="alignwider">
			<div class="row pb-4 gx-3 gy-6 show-more-posts-wrapper<?php echo $justify_class; if ($attributes["showMoreButton"]) echo " show-more-hide"; ?>">
				<?php while ($queried_posts->have_posts()):
					$queried_posts->the_post();
					$count++;
					//used to hide rows on various screens
					$additional_class = "";
					if ($attributes["showMoreButton"] && $count > $show_count["small"]) $additional_class = "hide-sm";
					if ($attributes["showMoreButton"] && $count > $show_count["xl"]) $additional_class = "hide-sm hide-xl";
					//used to move focus with show more button
					$tab_index = $attributes["showMoreButton"] && ($count === $show_count["small"] + 1 || $count === $show_count["xl"] + 1) ? true : false;
					get_template_part('template-parts/archive-single-post', null, array("additional_class" => $additional_class, "tabindex" => $tab_index, "heading_level" => $attributes["headingLevel"] + 1));
				endwhile; ?>
			</div>
		</div>
		<?php if ($attributes["showMoreButton"]) echo $link_button;?>
	<?php endif;
elseif ($attributes["queryPostType"] === 'podcast'):
	$count = 0;
	//used to move focus with show more button - true results in tabindex="-1"
	if ($queried_posts->have_posts()): ?>
		<div class="show-more-posts-wrapper pb-4 alignwide <?php if ($attributes["showMoreButton"]) echo " show-more-hide"; ?>">
			<?php while ($queried_posts->have_posts()):
				$queried_posts->the_post();
				$count++;
				//used to hide rows on various screens
				$additional_class = $attributes["showMoreButton"] && $count > 3 ? "hide-sm hide-xl" : "";
				//used to move focus with show more button
				$tab_index = $attributes["showMoreButton"] && $count > 4 ? true : false;
				get_template_part('template-parts/archive-single-podcast', null, array('additional_class' => $additional_class, 'tabindex' => $tab_index, "heading_level" => $attributes["headingLevel"] + 1));
			endwhile; ?>
		</div>
		<?php if ($attributes["showMoreButton"]) echo $link_button;?>
<?php endif;

endif;
wp_reset_postdata();

//var_dump($attributes)

if (!$attributes["isEditor"]) echo '</section>'; ?>