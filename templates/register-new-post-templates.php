<?php
function new_post_template()
{
	$post_object = get_post_type_object('post');
	$post_object->template = array(
		array(
			'kapital/secondary-title',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				)
			)
		),
		array(
			'kapital/perex',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				)
			)
		),
		array(
			'core/paragraph',
			array(
				'placeholder' => 'Obsah článku. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id tortor dictum, condimentum eros ac, porta orci. Mauris faucibus vitae est vitae pharetra. Nunc ultrices massa ut diam rutrum congue sed et turpis. Cras egestas metus eget lectus pellentesque, egestas iaculis purus dignissim. Duis vehicula egestas massa, eleifend sodales ipsum blandit vel. Maecenas nec ex ex. Morbi euismod enim dui, quis consequat eros convallis nec. Proin ut auctor nulla. Mauris ut est eget justo vestibulum pellentesque.'
			)
		),
		array(
			'kapital/sponsors'
		)
	);
	$podcast_object = get_post_type_object('podcast');
	$podcast_object->template = array(
		array(
			'kapital/secondary-title',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				)
			)
		),
		array(
			'kapital/podcast-links',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				)
			)
		),
		array(
			'core/html',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				),
			)
		),
		array(
			'core/paragraph',
			array(
				'placeholder' => 'Popis podcastu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id tortor dictum, condimentum eros ac, porta orci. Mauris faucibus vitae est vitae pharetra. Nunc ultrices massa ut diam rutrum congue sed et turpis. Cras egestas metus eget lectus pellentesque, egestas iaculis purus dignissim. Duis vehicula egestas massa, eleifend sodales ipsum blandit vel. Maecenas nec ex ex. Morbi euismod enim dui, quis consequat eros convallis nec. Proin ut auctor nulla. Mauris ut est eget justo vestibulum pellentesque.'
			)
		),
		array(
			'kapital/sponsors'
		)
	);
	$redakcia_object = get_post_type_object('redakcia');
	$redakcia_object->template = array(
		array(
			'kapital/secondary-title',
			array(
				'lock' => array(
					'move'   => true,
					'remove' => true,
				),
			),
		),
		array(
			'core/paragraph',
			array(
				'placeholder' => 'Bio člena*ky redakcie./baawdLorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc id tortor dictum, condimentum eros ac, porta orci. Mauris faucibus vitae est vitae pharetra. Nunc ultrices massa ut diam rutrum congue sed et turpis. Cras egestas metus eget lectus pellentesque, egestas iaculis purus dignissim. Duis vehicula egestas massa, eleifend sodales ipsum blandit vel. Maecenas nec ex ex. Morbi euismod enim dui, quis consequat eros convallis nec. Proin ut auctor nulla. Mauris ut est eget justo vestibulum pellentesque.'
			)
		),
		array(
			'kapital/post-query',
			array(
				'taxonomy' => 'autorstvo',
				'showHeading' => 'manual',
				'headingLevel' => 2,
				'headingText' => 'Články'
			)
		)
	);
}
add_action('init', 'new_post_template');
