<?php 
/**
 * Register Custom Post Types
 */


/**
 * Registers podcast post type
 */

function podcast_post_type() {

	$labels = array(
		'name'                  => _x( 'Podcasty', 'Všeobecný názov typu obsahu', 'kapital' ),
		'singular_name'         => _x( 'Podcast', 'Singulár názvu typu obsahu', 'kapital' ),
		'menu_name'             => __( 'Podcasty', 'kapital' ),
		'name_admin_bar'        => __( 'Podcasty', 'kapital' ),
		'archives'              => __( 'Archív podcastov', 'kapital' ),
		'attributes'            => __( 'Vlastnosti podcastu', 'kapital' ),
		'parent_item_colon'     => __( 'Nadradený podcast:', 'kapital' ),
		'all_items'             => __( 'Všetky podcasty', 'kapital' ),
		'add_new_item'          => __( 'Pridať nový podcast', 'kapital' ),
		'add_new'               => __( 'Pridať nový', 'kapital' ),
		'new_item'              => __( 'Nový podcast', 'kapital' ),
		'edit_item'             => __( 'Upraviť podcast', 'kapital' ),
		'update_item'           => __( 'Aktualizovať podcast', 'kapital' ),
		'view_item'             => __( 'Zobraziť podcast', 'kapital' ),
		'view_items'            => __( 'Zobraziť podcasty', 'kapital' ),
		'search_items'          => __( 'Vyhľadať podcast', 'kapital' ),
		'not_found'             => __( 'Žiadne podcasty sa nenašli', 'kapital' ),
		'not_found_in_trash'    => __( 'V koši sa nenašli žiadne podcasty.', 'kapital' ),
		'featured_image'        => __( 'Ilustračný obrázok', 'kapital' ),
		'set_featured_image'    => __( 'Nastaviť ilustračný obrázok', 'kapital' ),
		'remove_featured_image' => __( 'Odstrániť ilustračný obrázok', 'kapital' ),
		'use_featured_image'    => __( 'Použiť ako ilustračný obrázok', 'kapital' ),
		'insert_into_item'      => __( 'Pridať do podcastu', 'kapital' ),
		'uploaded_to_this_item' => __( 'Nahrané do podcastu', 'kapital' ),
		'items_list'            => __( 'Zoznam podcastov', 'kapital' ),
		'items_list_navigation' => __( 'Navigácia zoznamu podcastov', 'kapital' ),
		'filter_items_list'     => __( 'Filtrovať zoznam podcastov', 'kapital' ),
	);
	$args = array(
		'label'                 => __( 'Podcast', 'kapital' ),
		'description'           => __( 'Podcasty kapitálu', 'kapital' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'podcast-seria' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-audio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
        'show_in_rest'          => true
	);
	register_post_type( 'podcast', $args );

}

/**
 * Registers redakcia post type
 */

function redakcia_post_type() {

	$labels = array(
		'name'                  => _x( 'Redakcia', 'Všeobecný názov typu obsahu', 'kapital' ),
		'singular_name'         => _x( 'Člen*ka redakcie', 'Singulár názvu typu obsahu', 'kapital' ),
		'menu_name'             => __( 'Redakcia', 'kapital' ),
		'name_admin_bar'        => __( 'Redakcia', 'kapital' ),
		'archives'              => __( 'Redakcia', 'kapital' ),
		'attributes'            => __( 'Vlastnosti člena*ky redakcie', 'kapital' ),
		'parent_item_colon'     => __( 'Nadradený člen', 'kapital' ),
		'all_items'             => __( 'Celá redakcia', 'kapital' ),
		'add_new_item'          => __( 'Pridať nového*ú člena*ku redakcie', 'kapital' ),
		'add_new'               => __( 'Pridať nového*ú člena*ku', 'kapital' ),
		'new_item'              => __( 'Nový*á člen*ka redakcie', 'kapital' ),
		'edit_item'             => __( 'Upraviť člen*ku redakcie', 'kapital' ),
		'update_item'           => __( 'Aktualizovať člen*ku redakcie', 'kapital' ),
		'view_item'             => __( 'Zobraziť člen*ku redakcie', 'kapital' ),
		'view_items'            => __( 'Zobraziť redakciu', 'kapital' ),
		'search_items'          => __( 'Vyhľadať člen*ku redakcie', 'kapital' ),
		'not_found'             => __( 'Člen*ka redakcie nenájdený*á', 'kapital' ),
		'not_found_in_trash'    => __( 'V koši sa nenašli žiadni*e členovia*ky redakcie.', 'kapital' ),
		'featured_image'        => __( 'Ilustračný obrázok', 'kapital' ),
		'set_featured_image'    => __( 'Nastaviť ilustračný obrázok', 'kapital' ),
		'remove_featured_image' => __( 'Odstrániť ilustračný obrázok', 'kapital' ),
		'use_featured_image'    => __( 'Použiť ako ilustračný obrázok', 'kapital' ),
		'insert_into_item'      => __( 'Pridať k členovi*ke redakcie', 'kapital' ),
		'uploaded_to_this_item' => __( 'Nahrané k členovi*ke redakcie', 'kapital' ),
		'items_list'            => __( 'Zoznam redakcie', 'kapital' ),
		'items_list_navigation' => __( 'Navigácia zoznamu redakcie', 'kapital' ),
		'filter_items_list'     => __( 'Filtrovať zoznam redakcie', 'kapital' ),
	);

	$args = array(
		'label'                 => __( 'Redakcia', 'kapital' ),
		'description'           => __( 'Členovia*ky redakcie', 'kapital' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
		'taxonomies'            => array( 'tags' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'redakcia', $args );

}

/**
 * Calls all functions that register post types
 */

function kapital_register_custom_post_types(){
    podcast_post_type();
    redakcia_post_type();
}

add_action( 'init', 'kapital_register_custom_post_types', 0 ); 