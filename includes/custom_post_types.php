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
		'taxonomies'            => array( 'podcast-seria', 'partner' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-audio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
        'show_in_rest'          => true,
		'rewrite'     => array(
			'slug' => 'podcasty',
			'with_front' => false,
			'pages' => true)
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
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'redakcia', $args );
}

// Register Custom Post Type
function inzercia_post_type() {

	$labels = array(
		'name'                  => _x( 'Inzercia', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Inzercia', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Inzercia a podpora', 'text_domain' ),
		'name_admin_bar'        => __( 'Inzercia', 'text_domain' ),
		'archives'              => __( 'Archív inzercie', 'text_domain' ),
		'attributes'            => __( 'Vlastnosti inzercie', 'text_domain' ),
		'parent_item_colon'     => __( 'Nadradená inzercia', 'text_domain' ),
		'all_items'             => __( 'Všetky inzercie', 'text_domain' ),
		'add_new_item'          => __( 'Pridať novú inzerciu', 'text_domain' ),
		'add_new'               => __( 'Pridať novú inzerciu', 'text_domain' ),
		'new_item'              => __( 'Nové inzercia', 'text_domain' ),
		'edit_item'             => __( 'Upraviť inzerciu', 'text_domain' ),
		'update_item'           => __( 'Aktualizovať inzerciu', 'text_domain' ),
		'view_item'             => __( 'Zobraziť inzerciu', 'text_domain' ),
		'view_items'            => __( 'Zobraziť inzercie', 'text_domain' ),
		'search_items'          => __( 'Vyhľadať inzerciu', 'text_domain' ),
		'not_found'             => __( 'Inzercia nenájdená', 'text_domain' ),
		'not_found_in_trash'    => __( 'V koši sa nenašla žiadna inzercia', 'text_domain' ),
		'featured_image'        => __( 'Ilustračný obrázok', 'text_domain' ),
		'set_featured_image'    => __( 'Nastaviť ilustračný obrázok', 'text_domain' ),
		'remove_featured_image' => __( 'Odstrániť ilustračný obrázok', 'text_domain' ),
		'use_featured_image'    => __( 'Použiť ako ilustračný obrázok', 'text_domain' ),
		'insert_into_item'      => __( 'Pridať do inzercie', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Nahrané do inzercie', 'text_domain' ),
		'items_list'            => __( 'Zoznam inzercie', 'text_domain' ),
		'items_list_navigation' => __( 'Navigácia zoznamu inzercie', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrovať zoznam inzercie', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Inzercia', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title'),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-button',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'inzercia',
	);
	register_post_type( 'inzercia', $args );
}

/**
 * Calls all functions that register post types
 */

function kapital_register_custom_post_types(){
    podcast_post_type();
    redakcia_post_type();
	inzercia_post_type();
}

add_action( 'init', 'kapital_register_custom_post_types', 1 ); 

