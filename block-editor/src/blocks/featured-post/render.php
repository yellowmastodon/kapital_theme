<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
//need this, as render callback calls multiple times and throws an error

if ($attributes["renderOnlyImage"]):
	echo kapital_responsive_image($attributes["customImageId"], "", false, "rounded");
else:
	//setup custom variables if passed from block
	if ($attributes["isPost"]) {
		if ($attributes["postId"] !== 0) {
			$args = array(
				'p' => $attributes["postId"],
				'post_type' => $attributes["featuredPostType"],
				'post_status' => 'publish',
				'posts_per_page' => 1,
			);
		} else {
			$args = array(
				'post_type' => $attributes["featuredPostType"],
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'order' => 'DESC',
				'orderby' => 'ID'
			);
		}

		$featured_post_query = new WP_Query($args);
		if ($featured_post_query->have_posts()):
			while ($featured_post_query->have_posts()):
				$featured_post_query->the_post();
				global $post;
				$post_id = $post->ID;
				$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
				$thumbnail_id = (int) get_post_meta($post->ID, '_thumbnail_id', true);
				$post_title = get_the_title($post);
				$secondary_title = get_post_meta($post->ID, '_secondary_title', true);
				$post_excerpt = get_the_excerpt();
				$post_date = get_the_date();
				$post_type = $post->post_type;
				$post_permalink = get_post_permalink($post->ID);
			endwhile;
		endif;
	} else {
		$render_settings = kapital_get_render_settings(0, '', true);
		$thumbnail_id = $attributes["customImageId"];
		$post_title = $attributes["customHeading"];
		$secondary_title = "";
		$post_excerpt = $attributes["customText"];
		$post_permalink = $attributes["customLink"];
	}

	if ($render_settings["show_categories"]) {
		if ($post_type === 'post') {
			$custom_taxonomies = ['cislo', 'seria', 'jazyk', 'partner', 'zaner', 'rubrika', 'autorstvo'];
			$filtered_terms = get_and_reorganize_terms($post_id, $custom_taxonomies);
		} elseif ($post_type === "podcast") {
			$custom_taxonomies = ['podcast-seria'];
			$filtered_terms = get_and_reorganize_terms($post_id, $custom_taxonomies);
		} else {
			$custom_taxonomies = [];
			$filtered_terms = [];
		}
	}
?>
	<article class="featured-post archive-item alignwider ff-grotesk">
		<?php if ($attributes["isPost"]):?>
		<div class="archive-post-top row ff-sans fs-small text-gray">
			<?php if ($post_type === 'podcast'): ?>
				<div class="col-auto icon-podcast text-end">
					<svg>
						<use xlink:href="#icon-podcast"></use>
					</svg>
				</div>
			<?php endif;
			if ($render_settings["show_date"]):
			?><div class="col-auto post-date"><?php echo $post_date; ?></div>
			<?php endif;
			/**
			if ($render_settings["show_views"]): ?>
				<div class="col-auto post-views opacity-0" data-id="<?php echo $post_id ?>">
					<svg>
						<use xlink:href="#icon-views"></use>
					</svg>
					<span class="visually-hidden"><?php echo __('Počet zhliadnutí:', 'kapital') ?></span>
					<span class="number"></span>
				</div>
			<?php endif;  */
			endif;?>
		</div>
		<a tabindex="-1" aria-role="none" href="<?php echo $post_permalink; ?>" class="image-wrapper archive-item-link">
			<?php
			if ($thumbnail_id !== 0) {
				//needs proper
				echo kapital_responsive_image($thumbnail_id, "(min-width: 900px) 900px, 75vw", false, "rounded archive-item-image w-100");
			} else {
				echo '<div class="rounded w-100 archive-item-image placeholder"></div>';
			}
			?>
		</a>
		<div class="post-headline-excerpt">
			<a class="archive-item-link text-decoration-none" href="<?php echo $post_permalink; ?>">
				<h2 class="h2 mb-3 red-outline-hover" data-text="<?php echo $post_title ?>"><?php echo $post_title ?></h2>
				<div class="item-excerpt lh-sm">
					<?php if ($secondary_title !== "") {
						echo '<p>' . $secondary_title . '</p>';
						//arbitrary number, when the secondary title is too short, also include excerpt but shorter
						if (strlen($secondary_title) < 14) {
							echo $post_excerpt;
						}
					} else {
						if (!$attributes["isPost"]) {
							echo force_balance_tags(strip_tags($post_excerpt, ['<p>', '<i>', '<em>', '<b>', '<strong>']));
						} else {
							echo $post_excerpt;
						}
					} ?>
				</div>
			</a>
		</div>

		<?php if ($attributes["isPost"]):
			if (!empty($filtered_terms)): ?>
				<div class="item-terms text-uppercase row gx-3 gy-1">
					<?php
					if ($render_settings["show_author"]):
						if (!empty($filtered_terms['autorstvo']) && $post_type !== 'podcast'): ?>
							<div class="col-auto post-authors">
								<svg viewBox="0 0 24 24">
									<use xlink:href="#icon-author"></use>
								</svg>
								<?php foreach ($filtered_terms['autorstvo'] as $key => $author):
									if ($key !== 0) {
										echo ", ";
									}
								?><a href="<?php echo get_term_link($author); ?>"><?php echo $author->name;
																		?></a><?php
																			endforeach; ?>
							</div>
							<?php endif;
					endif;
					if ($render_settings["show_categories"]):
						foreach ($custom_taxonomies as $custom_taxonomy):
							//autorstvo rendered separately                        
							if (!empty($filtered_terms[$custom_taxonomy]) && $custom_taxonomy !== 'autorstvo'):
								foreach ($filtered_terms[$custom_taxonomy] as $term):
									//'tematicky' tag used for posts which are part of the printed issue
									if ($term->slug === 'tematicky'):
										if (isset($filtered_terms['cislo'][0])): ?>
											<div class="col-auto"><a class="marker-black" href="<?php echo get_term_link($filtered_terms['cislo'][0]); ?>"><?php echo $term->name ?></a></div>
										<?php endif; ?>
									<?php else: ?>
										<div class="col-auto"><a class="marker-black" href="<?php echo get_term_link($term); ?>"><?php echo $term->name ?></a></div>
					<?php endif;
								endforeach;
							endif;
						endforeach;
					endif; ?>
				</div>
			<?php endif;
		endif; ?>
	</article>

<?php wp_reset_postdata();
endif; ?>