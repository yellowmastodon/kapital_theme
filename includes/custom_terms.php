<?php 
/**
* Register custom taxonomies
* term_meta managed by ACF
*/

/**
 * Registers taxonomy: "Žánre"
 */
function register_zanre_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Žánre', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Žáner', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Žánre', 'kapital' ),
		'all_items'                  => __( 'Všetky žánre', 'kapital' ),
		'parent_item'                => __( 'Nadradený žáner', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradený žáner:', 'kapital' ),
		'new_item_name'              => __( 'Názov nového žánru', 'kapital' ),
		'add_new_item'               => __( 'Pridať nový žáner', 'kapital' ),
		'edit_item'                  => __( 'Upraviť žáner', 'kapital' ),
		'update_item'                => __( 'Aktualizovať žáner', 'kapital' ),
		'view_item'                  => __( 'Zobraziť žáner', 'kapital' ),
		'separate_items_with_commas' => __( 'Oddeľte žánre čiarkou', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť žánre', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie žánre', 'kapital' ),
		'search_items'               => __( 'Vyhľadať žáner', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne nenájdené', 'kapital' ),
		'no_terms'                   => __( 'Žiadne žánre', 'kapital' ),
		'items_list'                 => __( 'Zoznam žánrov', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu žánrov', 'kapital' ),
        'desc_field_description'     => __( 'Popis žánru sa zobrazí medzi názvom a zoznamom článkov.', 'kapital' )

	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => 'zaner',
		'show_in_rest'               => true,
        'rewrite'                    => ['slug' => 'zanre']
	);
	register_taxonomy( 'zaner', array( 'post' ), $args );
}

/**
 * Registers taxonomy: "Partneri"
 */
function register_partneri_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Partneri', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Partner', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Partneri', 'kapital' ),
		'all_items'                  => __( 'Všetci partneri', 'kapital' ),
		'parent_item'                => __( 'Nadradený partner', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradený partner:', 'kapital' ),
		'new_item_name'              => __( 'Nový partner', 'kapital' ),
		'add_new_item'               => __( 'Pridať nového partnera', 'kapital' ),
		'edit_item'                  => __( 'Upraviť partnera', 'kapital' ),
		'update_item'                => __( 'Aktualizovať partnera', 'kapital' ),
		'view_item'                  => __( 'Zobraziť partnera', 'kapital' ),
		'separate_items_with_commas' => __( 'Oddeľte partnerov čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť partnerov', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejší partneri', 'kapital' ),
		'search_items'               => __( 'Vyhľadať partnerov', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadni partneri', 'kapital' ),
		'no_terms'                   => __( 'Žiadni partneri', 'kapital' ),
		'items_list'                 => __( 'Zoznam partnerov', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu partnerov', 'kapital' ),
        'desc_field_description'     => __( 'Popis partnerov sa zobrazí medzi názvom a zoznamom článkov.', 'kapital' )

	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
        'rewrite'                    => ['slug' => 'partneri']

	);
	register_taxonomy( 'partner', array( 'post' ), $args );

}

/**
 * Registers taxonomy: "Tematické čísla"
 */
function register_cisla_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Tematické čísla', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Tematické číslo', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Čísla', 'kapital' ),
		'all_items'                  => __( 'Všetky čísla', 'kapital' ),
		'parent_item'                => __( 'Nadradené číslo', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradené číslo:', 'kapital' ),
		'new_item_name'              => __( 'Nové číslo', 'kapital' ),
		'add_new_item'               => __( 'Pridať nové číslo', 'kapital' ),
		'edit_item'                  => __( 'Upraviť číslo', 'kapital' ),
		'update_item'                => __( 'Aktualizovať číslo', 'kapital' ),
		'view_item'                  => __( 'Zobraziť číslo', 'kapital' ),
		'separate_items_with_commas' => __( 'Oddeľte čísla čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť čísla', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie čísla', 'kapital' ),
		'search_items'               => __( 'Vyhľadať čísla', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne čísla', 'kapital' ),
		'no_terms'                   => __( 'Žiadne čísla', 'kapital' ),
		'items_list'                 => __( 'Zoznam čísel', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu čísel', 'kapital' ),
        'desc_field_description'     => __( 'Popis čísla sa zobrazí medzi názvom a zoznamom článkov.', 'kapital' )

	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
        'rewrite'                    => ['slug' => 'cisla']

	);
	register_taxonomy( 'cislo', array( 'post' ), $args );

}

/**
 * Registers taxonomy: "Tematické série"
 */

function register_serie_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Tematické série', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Tematická séria', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Série', 'kapital' ),
		'all_items'                  => __( 'Všetky série', 'kapital' ),
		'parent_item'                => __( 'Nadradená séria', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradená séria:', 'kapital' ),
		'new_item_name'              => __( 'Názov novej série', 'kapital' ),
		'add_new_item'               => __( 'Pridať novú sériu', 'kapital' ),
		'edit_item'                  => __( 'Upraviť sériu', 'kapital' ),
		'update_item'                => __( 'Aktualizovať sériu', 'kapital' ),
		'view_item'                  => __( 'Zobraziť sériu', 'kapital' ),
		'separate_items_with_commas' => __( 'Série oddelené čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť série', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie série', 'kapital' ),
		'search_items'               => __( 'Vyhľadať série', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne série', 'kapital' ),
		'no_terms'                   => __( 'Žiadne série', 'kapital' ),
		'items_list'                 => __( 'Zoznam tematických sérií', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu tematických sérií', 'kapital' ),
        'desc_field_description'     => __( 'Popis série sa zobrazí medzi názvom a zoznamom článkov.', 'kapital' )

	);
	$rewrite = array(
		'slug'                       => 'tematicke-serie',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => ['slug' => 'serie'],
		'show_in_rest'               => true,
	);
	register_taxonomy( 'seria', array( 'post' ), $args );

}

/**
 * Renames "rubrika" taxonomy
 */

function register_rubriky_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Rubriky', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Rubrika', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Rubriky', 'kapital' ),
		'all_items'                  => __( 'Všetky rubriky', 'kapital' ),
		'parent_item'                => __( 'Nadradená rubrika', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradená rubrika:', 'kapital' ),
		'new_item_name'              => __( 'Nová rubrika', 'kapital' ),
		'add_new_item'               => __( 'Pridať novú rubriku', 'kapital' ),
		'edit_item'                  => __( 'Upraviť rubriku', 'kapital' ),
		'update_item'                => __( 'Aktualizovať rubriku', 'kapital' ),
		'view_item'                  => __( 'Zobraziť rubriku', 'kapital' ),
		'separate_items_with_commas' => __( 'Oddeľte rubriky čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť rubriky', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie rubriky', 'kapital' ),
		'search_items'               => __( 'Vyhľadať rubriky', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne rubriky', 'kapital' ),
		'no_terms'                   => __( 'Žiadne rubriky', 'kapital' ),
		'items_list'                 => __( 'Zoznam rubrík', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu rubrík', 'kapital' ),
        'desc_field_description'     => __( 'Popis rubriky sa zobrazí medzi názvom a zoznamom článkov.', 'kapital' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
        'rewrite'                    => ['slug' => 'rubriky']

	);
	register_taxonomy( 'rubrika', array( 'post' ), $args );

}

// Register Custom Taxonomy
function register_jazyk_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Jazyky', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Jazyk', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Jazyk', 'kapital' ),
		'all_items'                  => __( 'Všetky jazyky', 'kapital' ),
		'parent_item'                => __( 'Nadradený jazyk', 'kapital' ),
		'parent_item_colon'          => __( 'Parent Item:', 'kapital' ),
		'new_item_name'              => __( 'Nový jazyk', 'kapital' ),
		'add_new_item'               => __( 'Pridať nový jazyk', 'kapital' ),
		'edit_item'                  => __( 'Upraviť jazyk', 'kapital' ),
		'update_item'                => __( 'Aktualizovať jazyk', 'kapital' ),
		'view_item'                  => __( 'Zobraziť jazyk', 'kapital' ),
		'separate_items_with_commas' => __( 'Oddeľte jazyky čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť jazyky', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie jazyky', 'kapital' ),
		'search_items'               => __( 'Vyhľadať jazyk', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne jazyky', 'kapital' ),
		'no_terms'                   => __( 'Žiadne jazyky', 'kapital' ),
		'items_list'                 => __( 'Zoznam jazykov', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu jazykov', 'kapital' ),
	);
	$rewrite = array(
		'slug'                       => 'jazyky',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'jazyk', array( 'post' ), $args );
}


/**
 * Registers taxonomy: "Série" for custom post type "podcast"
 */

function register_podcast_serie_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Série', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Séria', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Série', 'kapital' ),
		'all_items'                  => __( 'Všetky série', 'kapital' ),
		'parent_item'                => __( 'Nadradená séria', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradená séria:', 'kapital' ),
		'new_item_name'              => __( 'Názov novej série', 'kapital' ),
		'add_new_item'               => __( 'Pridať novú sériu', 'kapital' ),
		'edit_item'                  => __( 'Upraviť sériu', 'kapital' ),
		'update_item'                => __( 'Aktualizovať sériu', 'kapital' ),
		'view_item'                  => __( 'Zobraziť sériu', 'kapital' ),
		'separate_items_with_commas' => __( 'Série oddelené čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť série', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie série', 'kapital' ),
		'search_items'               => __( 'Vyhľadať série', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne série', 'kapital' ),
		'no_terms'                   => __( 'Žiadne série', 'kapital' ),
		'items_list'                 => __( 'Zoznam tematických sérií', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu tematických sérií', 'kapital' ),
        'desc_field_description'     => __( 'Popis série sa zobrazí medzi názvom a zoznamom článkov.', 'kapital' )

	);
	$rewrite = array(
		'slug'                       => 'serie',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => ['slug' => 'serie'],
		'show_in_rest'               => true,
	);
	register_taxonomy( 'podcast-seria', array( 'podcast' ), $args );
}


/**
 * Registers taxonomy: "redakcia_tag" for custom post type "redakcia" to assign job positions to members of the team
 */

function register_redakcia_pozicia() {

	$labels = array(
		'name'                       => _x( 'Pozície', 'Taxonomy General Name', 'kapital' ),
		'singular_name'              => _x( 'Pozícia', 'Taxonomy Singular Name', 'kapital' ),
		'menu_name'                  => __( 'Pozície', 'kapital' ),
		'all_items'                  => __( 'Všetky pozície', 'kapital' ),
		'parent_item'                => __( 'Nadradená pozícia', 'kapital' ),
		'parent_item_colon'          => __( 'Nadradená pozícia:', 'kapital' ),
		'new_item_name'              => __( 'Nová pozícia', 'kapital' ),
		'add_new_item'               => __( 'Pridať novú pozíciu', 'kapital' ),
		'edit_item'                  => __( 'Upraviť pozíciu', 'kapital' ),
		'update_item'                => __( 'Aktualizovať pozíciu', 'kapital' ),
		'view_item'                  => __( 'Zobraziť pozíciu', 'kapital' ),
		'separate_items_with_commas' => __( 'Oddeľte pozície čiarkami', 'kapital' ),
		'add_or_remove_items'        => __( 'Pridať alebo odstrániť pozície', 'kapital' ),
		'choose_from_most_used'      => __( 'Vyberte z najpoužívanejších', 'kapital' ),
		'popular_items'              => __( 'Najpoužívanejšie pozície', 'kapital' ),
		'search_items'               => __( 'Vyhľadať pozície', 'kapital' ),
		'not_found'                  => __( 'Nenašli sa žiadne pozície', 'kapital' ),
		'no_terms'                   => __( 'Žiadne pozície', 'kapital' ),
		'items_list'                 => __( 'Zoznam pozícií', 'kapital' ),
		'items_list_navigation'      => __( 'Navigácia zoznamu pozícií', 'kapital' ),
	);
	$rewrite = array(
		'slug'                       => 'pozicia',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'redakcia-tag', array( 'redakcia' ), $args );

}

/**
 * Reorder either top-level menu items or submenu level items or both.
 * If not editing top-level items, return the $menu_ord variable unchanged.
 * 
 * @param array $menu_ord Associative array of menu and submenu items
 *   passed to the function by the menu_order filter hook.
 *
 * @return array
 */
function reorder_post_submenu( $menu_ord ) {
    // Global variable $submenu to be updated independently
    // from the local $reorder variable.
    global $submenu;

    // Optionally reorder top-level menu items.
    // Missing top-level items are automatically
    // added to the bottom of any items listed
    // here.
    // @see https://developer.wordpress.org/reference/hooks/menu_order/
    $reorder = array();


    // Enable the next line to see all submenus
    //echo '<pre>'.print_r($submenu,true).'</pre>';
    // See below for sample echo output.

    // Reorder submenu items for Post options.
    //my original order was 5,10,15,16
    $arr = array();
    $arr[] = $submenu['edit.php'][5];
    $arr[] = $submenu['edit.php'][10];
    $arr[] = $submenu['edit.php'][15];
    $arr[] = $submenu['edit.php'][17];
    $arr[] = $submenu['edit.php'][18];
    $arr[] = $submenu['edit.php'][19];
    $arr[] = $submenu['edit.php'][20];
	$arr[] = $submenu['edit.php'][21];
    $arr[] = $submenu['edit.php'][16];
    $submenu['edit.php'] = $arr; 
    return $reorder;
}


/**
 * Initialize WISIWYG editor on term description
 */
function tinymce_on_description($term, $taxonomy){
    ?>
    <script id="term_description_tinymce">
        jQuery(document).ready(function($) {
            wp.editor.initialize('tag-description', {
                tinymce: {
                    // customizable options for TinyMCE
                    toolbar1: 'formatselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
                            plugins: 'link,lists,textcolor,colorpicker',
                            menubar: false,
                            statusbar: false,
                },
                quicktags: true,
                mediaButtons: false,
            });
        });
    </script>
    <?php
}




/**
 * We need to disable KSES as it filters out all HTML from the term descriptions for security reasons
 * This allows tinyMCE to be initialized on term description
 */
function disable_kses() {
    remove_filter('pre_term_description', 'wp_filter_kses');
}

function kapital_register_custom_taxonomies(){
	register_rubriky_taxonomy();
    register_zanre_taxonomy();
    register_serie_taxonomy();
    register_cisla_taxonomy();
    register_partneri_taxonomy();
	register_jazyk_taxonomy();
    disable_kses();
    register_podcast_serie_taxonomy();
	register_redakcia_pozicia();
	unregister_taxonomy_for_object_type( 'category', 'post' );
}

//add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'reorder_post_submenu' );
add_action("category_edit_form_fields", 'tinymce_on_description', 10, 2);
add_action( 'init', 'kapital_register_custom_taxonomies', 1 );
