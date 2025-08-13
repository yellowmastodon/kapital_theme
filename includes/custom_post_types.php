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
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'excerpt' ),
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
		'name'                  => _x( 'Inzercia', 'Post Type General Name', 'kapital' ),
		'singular_name'         => _x( 'Inzercia', 'Post Type Singular Name', 'kapital' ),
		'menu_name'             => __( 'Inzercia a podpora', 'kapital' ),
		'name_admin_bar'        => __( 'Inzercia', 'kapital' ),
		'archives'              => __( 'Archív inzercie', 'kapital' ),
		'attributes'            => __( 'Vlastnosti inzercie', 'kapital' ),
		'parent_item_colon'     => __( 'Nadradená inzercia', 'kapital' ),
		'all_items'             => __( 'Všetky inzercie', 'kapital' ),
		'add_new_item'          => __( 'Pridať novú inzerciu', 'kapital' ),
		'add_new'               => __( 'Pridať novú inzerciu', 'kapital' ),
		'new_item'              => __( 'Nové inzercia', 'kapital' ),
		'edit_item'             => __( 'Upraviť inzerciu', 'kapital' ),
		'update_item'           => __( 'Aktualizovať inzerciu', 'kapital' ),
		'view_item'             => __( 'Zobraziť inzerciu', 'kapital' ),
		'view_items'            => __( 'Zobraziť inzercie', 'kapital' ),
		'search_items'          => __( 'Vyhľadať inzerciu', 'kapital' ),
		'not_found'             => __( 'Inzercia nenájdená', 'kapital' ),
		'not_found_in_trash'    => __( 'V koši sa nenašla žiadna inzercia', 'kapital' ),
		'featured_image'        => __( 'Ilustračný obrázok', 'kapital' ),
		'set_featured_image'    => __( 'Nastaviť ilustračný obrázok', 'kapital' ),
		'remove_featured_image' => __( 'Odstrániť ilustračný obrázok', 'kapital' ),
		'use_featured_image'    => __( 'Použiť ako ilustračný obrázok', 'kapital' ),
		'insert_into_item'      => __( 'Pridať do inzercie', 'kapital' ),
		'uploaded_to_this_item' => __( 'Nahrané do inzercie', 'kapital' ),
		'items_list'            => __( 'Zoznam inzercie', 'kapital' ),
		'items_list_navigation' => __( 'Navigácia zoznamu inzercie', 'kapital' ),
		'filter_items_list'     => __( 'Filtrovať zoznam inzercie', 'kapital' ),
	);
	$args = array(
		'label'                 => __( 'Inzercia', 'kapital' ),
		'labels'                => $labels,
		'supports'              => array( 'title'),
		'post_status' => array('publish', 'draft'),
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
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'inzercia',
	);
	register_post_type( 'inzercia', $args );
}

// Register Custom Post Type
function recommendation_post_type() {

	$labels = array(
		'name'                  => _x( 'Odporúčania', 'Post Type General Name', 'kapital' ),
		'singular_name'         => _x( 'Odporúčanie', 'Post Type Singular Name', 'kapital' ),
		'menu_name'             => __( 'Kapitál odporúča', 'kapital' ),
		'name_admin_bar'        => __( 'Odporúčania', 'kapital' ),
		'archives'              => __( 'Archív odporúčaní', 'kapital' ),
		'attributes'            => __( 'Vlastnosti odporúčaní', 'kapital' ),
		'parent_item_colon'     => __( 'Nadradené odporúčanie', 'kapital' ),
		'all_items'             => __( 'Všetky odporúčania', 'kapital' ),
		'add_new_item'          => __( 'Pridať nové odporúčanie', 'kapital' ),
		'add_new'               => __( 'Pridať nové odporúčanie', 'kapital' ),
		'new_item'              => __( 'Nové odporúčanie', 'kapital' ),
		'edit_item'             => __( 'Upraviť odporúčanie', 'kapital' ),
		'update_item'           => __( 'Aktualizovať odporúčanie', 'kapital' ),
		'view_item'             => __( 'Zobraziť odporúčanie', 'kapital' ),
		'view_items'            => __( 'Zobraziť odporúčania', 'kapital' ),
		'search_items'          => __( 'Vyhľadať odporúčanie', 'kapital' ),
		'not_found'             => __( 'Odporúčanie nenájdené', 'kapital' ),
		'not_found_in_trash'    => __( 'V koši sa nenašli žiadne odporúčania', 'kapital' ),
		'featured_image'        => __( 'Ilustračný obrázok', 'kapital' ),
		'set_featured_image'    => __( 'Nastaviť ilustračný obrázok', 'kapital' ),
		'remove_featured_image' => __( 'Odstrániť ilustračný obrázok', 'kapital' ),
		'use_featured_image'    => __( 'Použiť ako ilustračný obrázok', 'kapital' ),
		'insert_into_item'      => __( 'Pridať k odporúčaniu', 'kapital' ),
		'uploaded_to_this_item' => __( 'Nahrané k odporúčaniu', 'kapital' ),
		'items_list'            => __( 'Zoznam odporúčaní', 'kapital' ),
		'items_list_navigation' => __( 'Navigácia zoznamu odporúčaní', 'kapital' ),
		'filter_items_list'     => __( 'Filtrovať zoznam odporúčaní', 'kapital' ),
	);
	$args = array(
		'label'                 => __( 'Odporúčanie', 'kapital' ),
		'description'           => __( 'Odporúčania na domovskej stránke', 'kapital' ),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-align-left',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'recommendation', $args );

}


// Register event post Type
function event_post_type() {

	$labels = array(
		'name'                  => _x( 'Podujatia', 'Post Type General Name', 'kapital' ),
		'singular_name'         => _x( 'Podujatie', 'Post Type Singular Name', 'kapital' ),
		'menu_name'             => __( 'Podujatia', 'kapital' ),
		'name_admin_bar'        => __( 'Podujatia', 'kapital' ),
		'archives'              => __( 'Archív podujatí', 'kapital' ),
		'attributes'            => __( 'Vlastnosti podujatí', 'kapital' ),
		'parent_item_colon'     => __( 'Nadradené podujatie', 'kapital' ),
		'all_items'             => __( 'Všetky podujatia', 'kapital' ),
		'add_new_item'          => __( 'Pridať nové podujatie', 'kapital' ),
		'add_new'               => __( 'Pridať nové podujatie', 'kapital' ),
		'new_item'              => __( 'Nové podujatie', 'kapital' ),
		'edit_item'             => __( 'Upraviť podujatie', 'kapital' ),
		'update_item'           => __( 'Aktualizovať podujatie', 'kapital' ),
		'view_item'             => __( 'Zobraziť podujatie', 'kapital' ),
		'view_items'            => __( 'Všetky podujatia', 'kapital' ),
		'search_items'          => __( 'Vyhľadať podujatie', 'kapital' ),
		'not_found'             => __( 'Podujatia nenájdené', 'kapital' ),
		'not_found_in_trash'    => __( 'V koši nie sú žiadne podujatia', 'kapital' ),
		'featured_image'        => __( 'Ilustračný obrázok', 'kapital' ),
		'set_featured_image'    => __( 'Nastaviť ilustračný obrázok', 'kapital' ),
		'remove_featured_image' => __( 'Odstrániť ilustračný obrázok', 'kapital' ),
		'use_featured_image'    => __( 'Použiť ako ilustračný obrázok', 'kapital' ),
		'insert_into_item'      => __( 'Pridať k podujatiu', 'kapital' ),
		'uploaded_to_this_item' => __( 'Nahrané do podujatia', 'kapital' ),
		'items_list'            => __( 'Zoznam podujatí', 'kapital' ),
		'items_list_navigation' => __( 'Navigácia zoznamu podujatí', 'kapital' ),
		'filter_items_list'     => __( 'Filtrovať zoznam podujatí', 'kapital' ),
	);
	$rewrite = array(
		'slug'                  => 'podujatia',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Podujatie', 'kapital' ),
		'description'           => __( 'Podujatia', 'kapital' ),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-calendar',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'query_var'             => 'podujatie',
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'event',
	);
	register_post_type( 'event', $args );

}

/**
 * Calls all functions that register post types
 */

function kapital_register_custom_post_types(){
    podcast_post_type();
    redakcia_post_type();
	inzercia_post_type();
	recommendation_post_type();
	event_post_type();
}

add_action( 'init', 'kapital_register_custom_post_types', 1 ); 