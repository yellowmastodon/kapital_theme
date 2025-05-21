<?php

/**
 * Search results partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$article_classes = "archive-item ff-grotesk";
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
$post_title = get_the_title($post);
$secondary_title = get_post_meta($post->ID, '_secondary_title', true);

?>
<article <?php post_class([$article_classes], $post); ?>>
		<div class="archive-post-top row mb-1 ff-sans fs-small text-gray">
			<?php
			if ($render_settings["show_date"]):
			?><div class="col-auto post-date"><?php echo get_the_date(); ?></div>
			<?php endif;
			if ($render_settings["show_views"]): ?>
				<div class="col-auto post-views opacity-0" data-id="<?php echo $post->ID ?>">
					<svg>
						<use xlink:href="#icon-views"></use>
					</svg>
					<span class="visually-hidden"><?php echo __('Počet zhliadnutí:', 'kapital') ?></span>
					<span class="number"></span>
				</div><?php
					endif; ?>
		</div>
		<a href="<?php echo get_the_permalink($post); ?>" class="archive-item-link row text-decoration-none">
			<?php $thumbnail_image_id = get_post_thumbnail_id($post->ID);
			if ($thumbnail_image_id) {
				echo '<div class="col-3 d-none d-sm-block">' . kapital_responsive_image($thumbnail_image_id, "(max-width: 599px) 95vw, (max-width: 899px) 47vw, (max-width: 1199px) 32vw, (max-width: 1399px) 300px, (max-width: 1649px) 260px, 312px", false, 'rounded w-100 archive-item-image mb-2') . '</div>';
			} else {
				echo '<div class="rounded col-3 d-none d-sm-block archive-item-image placeholder mb-3"></div>';
			}
			//data-text attribute used by ::before element to generate outline
			?>
			<div class="col-12 col-sm-9 mb-3">
			<h2 class="archive-item-heading mb-3 red-outline-hover" data-text="<?php echo $post_title ?>"><?php echo $post_title ?></h2>
			<div class="item-excerpt red-color-hover lh-sm">
				<?php if ($secondary_title !== "") {
					echo '<p>' . $secondary_title . '</p>';
					//arbitrary number, when the secondary title is too short, also include excerpt but shorter
					if (strlen($secondary_title) < 14) {
						echo get_the_excerpt();
					}
				} else {
					echo get_the_excerpt();
				} ?>
			</div>
			</div>
		</a>
		<?php
		$custom_taxonomies = ['cislo', 'seria', 'jazyk', 'partner', 'zaner', 'rubrika', 'autorstvo', 'podcast-seria']; //with partners this includes also podcast seria
		$filtered_terms = get_and_reorganize_terms($post->ID, $custom_taxonomies);
		if (!empty($filtered_terms)): ?>
			<div class="item-terms text-uppercase row gx-3 gy-1">
				<?php
				if ($render_settings["show_author"]):
					if (!empty($filtered_terms['autorstvo']) && $post->post_type !== 'podcast'): ?>
						<div class="col-auto post-authors">
							<svg viewBox="0 0 24 24" class="icon-square">
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
		<?php endif; ?>
</article>