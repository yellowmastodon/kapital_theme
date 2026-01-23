<?php
/**
 * Register custom taxonomies
 * term_meta managed by ACF except for 'autorstvo' (author) taxonomy - defined in includes/author_taxonomy_functions.php
 */

/** @var array array containing taxonomies that have list pages, used as global variable elsewhere
 * @key taxonomy
 * @value rewrite slug
  */
//global $kapital_taxonomies_with_list_pages;
$kapital_taxonomies_with_list_pages = array('cislo' => 'cisla',
									   'seria' => 'serie',
									   'rubrika' => 'rubriky',
									   'zaner' => 'zanre',
									   'podcast-seria' => 'podcast-serie',
									   'autorstvo' => 'autorstvo');
/**
 * Registers taxonomy: "Žánre"
 */
function register_zanre_taxonomy()
{
	global $kapital_taxonomies_with_list_pages;
	$taxonomy = 'zaner';
	$labels = array(
		'name'                       => _x('Žánre', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Žáner', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Žánre', 'kapital'),
		'all_items'                  => __('Všetky žánre', 'kapital'),
		'parent_item'                => __('Nadradený žáner', 'kapital'),
		'parent_item_colon'          => __('Nadradený žáner:', 'kapital'),
		'new_item_name'              => __('Názov nového žánru', 'kapital'),
		'add_new_item'               => __('Pridať nový žáner', 'kapital'),
		'edit_item'                  => __('Upraviť žáner', 'kapital'),
		'update_item'                => __('Aktualizovať žáner', 'kapital'),
		'view_item'                  => __('Zobraziť žáner', 'kapital'),
		'separate_items_with_commas' => __('Oddeľte žánre čiarkou', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť žánre', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie žánre', 'kapital'),
		'search_items'               => __('Vyhľadať žáner', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadne nenájdené', 'kapital'),
		'no_terms'                   => __('Žiadne žánre', 'kapital'),
		'items_list'                 => __('Zoznam žánrov', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu žánrov', 'kapital'),
		'desc_field_description'     => __('Popis žánru sa zobrazí medzi názvom a zoznamom článkov.', 'kapital')
	);
	$rewrite = array(
		'slug'                       => $kapital_taxonomies_with_list_pages[$taxonomy],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => 'zaner',
		'show_in_rest'               => true,
		'rewrite'                    => $rewrite
	);
	register_taxonomy($taxonomy, array('post'), $args);
}


/**
 * Registers taxonomy: "Autorstvo" (replaces the author)
 */

function register_author_taxonomy()
{
	global $kapital_taxonomies_with_list_pages;
	$taxonomy = 'autorstvo';
	$labels = array(
		'name'                       => _x('Autorstvo', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Autorstvo', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Autorstvo', 'kapital'),
		'all_items'                  => __('Všetko autorstvo', 'kapital'),
		'parent_item'                => __('Nadradené autorstvo', 'kapital'),
		'parent_item_colon'          => __('Nadradené autorstvo:', 'kapital'),
		'new_item_name'              => __('Nové autortsvo', 'kapital'),
		'add_new_item'               => __('Pridať nové autorstvo', 'kapital'),
		'edit_item'                  => __('Upraviť autorstvo', 'kapital'),
		'update_item'                => __('Aktualizovať autorstvo', 'kapital'),
		'view_item'                  => __('Zobraziť autorstvo', 'kapital'),
		'separate_items_with_commas' => __('Autorstvo oddelené čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť autorstvoˇ', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie autorstvo', 'kapital'),
		'search_items'               => __('Vyhľadať autorstvo', 'kapital'),
		'not_found'                  => __('Autorstvo nenájdené', 'kapital'),
		'no_terms'                   => __('Žiadne autorstvo', 'kapital'),
		'items_list'                 => __('Zoznam autorstva', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu autorstva', 'kapital'),
	);
	$rewrite = array(
		'slug'                       => $kapital_taxonomies_with_list_pages[$taxonomy],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'query_var'                  => 'autorstvo',
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy($taxonomy, array('post'), $args);
}

/**
 * Registers taxonomy: "Partneri"
 */
function register_partneri_taxonomy()
{
	$labels = array(
		'name'                       => _x('Partneri', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Partner', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Partneri', 'kapital'),
		'all_items'                  => __('Všetci partneri', 'kapital'),
		'parent_item'                => __('Nadradený partner', 'kapital'),
		'parent_item_colon'          => __('Nadradený partner:', 'kapital'),
		'new_item_name'              => __('Nový partner', 'kapital'),
		'add_new_item'               => __('Pridať nového partnera', 'kapital'),
		'edit_item'                  => __('Upraviť partnera', 'kapital'),
		'update_item'                => __('Aktualizovať partnera', 'kapital'),
		'view_item'                  => __('Zobraziť partnera', 'kapital'),
		'separate_items_with_commas' => __('Oddeľte partnerov čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť partnerov', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejší partneri', 'kapital'),
		'search_items'               => __('Vyhľadať partnerov', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadni partneri', 'kapital'),
		'no_terms'                   => __('Žiadni partneri', 'kapital'),
		'items_list'                 => __('Zoznam partnerov', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu partnerov', 'kapital'),
		'desc_field_description'     => __('Popis partnerov sa zobrazí medzi názvom a zoznamom článkov.', 'kapital')

	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
		'rewrite'                    => ['slug' => 'partneri', 'with_front' => false]

	);
	register_taxonomy('partner', array('post', 'podcast'), $args);
}

/**
 * Registers taxonomy: "Tematické čísla"
 */
function register_cisla_taxonomy()
{
	global $kapital_taxonomies_with_list_pages;
	$taxonomy = 'cislo';
	$labels = array(
		'name'                       => _x('Tematické čísla', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Tematické číslo', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Čísla', 'kapital'),
		'all_items'                  => __('Všetky čísla', 'kapital'),
		'parent_item'                => __('Nadradené číslo', 'kapital'),
		'parent_item_colon'          => __('Nadradené číslo:', 'kapital'),
		'new_item_name'              => __('Nové číslo', 'kapital'),
		'add_new_item'               => __('Pridať nové číslo', 'kapital'),
		'edit_item'                  => __('Upraviť číslo', 'kapital'),
		'update_item'                => __('Aktualizovať číslo', 'kapital'),
		'view_item'                  => __('Zobraziť číslo', 'kapital'),
		'separate_items_with_commas' => __('Oddeľte čísla čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť čísla', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie čísla', 'kapital'),
		'search_items'               => __('Vyhľadať čísla', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadne čísla', 'kapital'),
		'no_terms'                   => __('Žiadne čísla', 'kapital'),
		'items_list'                 => __('Zoznam čísel', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu čísel', 'kapital'),
		'desc_field_description'     => __('Popis čísla sa zobrazí medzi názvom a zoznamom článkov.', 'kapital')

	);
	$rewrite = array(
		'slug'                       => $kapital_taxonomies_with_list_pages[$taxonomy],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
		'rewrite'                    => $rewrite
	);
	register_taxonomy('cislo', array('post'), $args);
}

/**
 * Registers taxonomy: "Tematické série"
 */

function register_serie_taxonomy()
{
	global $kapital_taxonomies_with_list_pages;
	$taxonomy = 'seria';
	$labels = array(
		'name'                       => _x('Tematické série', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Tematická séria', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Série', 'kapital'),
		'all_items'                  => __('Všetky série', 'kapital'),
		'parent_item'                => __('Nadradená séria', 'kapital'),
		'parent_item_colon'          => __('Nadradená séria:', 'kapital'),
		'new_item_name'              => __('Názov novej série', 'kapital'),
		'add_new_item'               => __('Pridať novú sériu', 'kapital'),
		'edit_item'                  => __('Upraviť sériu', 'kapital'),
		'update_item'                => __('Aktualizovať sériu', 'kapital'),
		'view_item'                  => __('Zobraziť sériu', 'kapital'),
		'separate_items_with_commas' => __('Série oddelené čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť série', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie série', 'kapital'),
		'search_items'               => __('Vyhľadať série', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadne série', 'kapital'),
		'no_terms'                   => __('Žiadne série', 'kapital'),
		'items_list'                 => __('Zoznam tematických sérií', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu tematických sérií', 'kapital'),
		'desc_field_description'     => __('Popis série sa zobrazí medzi názvom a zoznamom článkov.', 'kapital')

	);
	$rewrite = array(
		'slug'                       => $kapital_taxonomies_with_list_pages[$taxonomy],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy($taxonomy, array('post'), $args);
}

/**
 * Registers "rubrika" taxonomy
 */

function register_rubriky_taxonomy()
{
	global $kapital_taxonomies_with_list_pages;
	$taxonomy = 'rubrika';
	$labels = array(
		'name'                       => _x('Rubriky', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Rubrika', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Rubriky', 'kapital'),
		'all_items'                  => __('Všetky rubriky', 'kapital'),
		'parent_item'                => __('Nadradená rubrika', 'kapital'),
		'parent_item_colon'          => __('Nadradená rubrika:', 'kapital'),
		'new_item_name'              => __('Nová rubrika', 'kapital'),
		'add_new_item'               => __('Pridať novú rubriku', 'kapital'),
		'edit_item'                  => __('Upraviť rubriku', 'kapital'),
		'update_item'                => __('Aktualizovať rubriku', 'kapital'),
		'view_item'                  => __('Zobraziť rubriku', 'kapital'),
		'separate_items_with_commas' => __('Oddeľte rubriky čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť rubriky', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie rubriky', 'kapital'),
		'search_items'               => __('Vyhľadať rubriky', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadne rubriky', 'kapital'),
		'no_terms'                   => __('Žiadne rubriky', 'kapital'),
		'items_list'                 => __('Zoznam rubrík', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu rubrík', 'kapital'),
		'desc_field_description'     => __('Popis rubriky sa zobrazí medzi názvom a zoznamom článkov.', 'kapital')
	);
	$rewrite = array(
		'slug'                       => $kapital_taxonomies_with_list_pages[$taxonomy],
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
		'show_in_rest'               => true,
		'rewrite'                    => $rewrite
	);
	register_taxonomy($taxonomy, array('post'), $args);
}

// Register Custom Taxonomy
function register_jazyk_taxonomy()
{

	$labels = array(
		'name'                       => _x('Jazyky', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Jazyk', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Jazyk', 'kapital'),
		'all_items'                  => __('Všetky jazyky', 'kapital'),
		'parent_item'                => __('Nadradený jazyk', 'kapital'),
		'parent_item_colon'          => __('Parent Item:', 'kapital'),
		'new_item_name'              => __('Nový jazyk', 'kapital'),
		'add_new_item'               => __('Pridať nový jazyk', 'kapital'),
		'edit_item'                  => __('Upraviť jazyk', 'kapital'),
		'update_item'                => __('Aktualizovať jazyk', 'kapital'),
		'view_item'                  => __('Zobraziť jazyk', 'kapital'),
		'separate_items_with_commas' => __('Oddeľte jazyky čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť jazyky', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie jazyky', 'kapital'),
		'search_items'               => __('Vyhľadať jazyk', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadne jazyky', 'kapital'),
		'no_terms'                   => __('Žiadne jazyky', 'kapital'),
		'items_list'                 => __('Zoznam jazykov', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu jazykov', 'kapital'),
	);
	$rewrite = array(
		'slug'                       => 'language',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy('jazyk', array('post'), $args);
}


/**
 * Registers taxonomy: "Série" for custom post type "podcast"
 */

function register_podcast_serie_taxonomy()
{
	global $kapital_taxonomies_with_list_pages;
	$taxonomy = 'podcast-seria';
	$labels = array(
		'name'                       => _x('Série', 'Taxonomy General Name', 'kapital'),
		'singular_name'              => _x('Séria', 'Taxonomy Singular Name', 'kapital'),
		'menu_name'                  => __('Série', 'kapital'),
		'all_items'                  => __('Všetky série', 'kapital'),
		'parent_item'                => __('Nadradená séria', 'kapital'),
		'parent_item_colon'          => __('Nadradená séria:', 'kapital'),
		'new_item_name'              => __('Názov novej série', 'kapital'),
		'add_new_item'               => __('Pridať novú sériu', 'kapital'),
		'edit_item'                  => __('Upraviť sériu', 'kapital'),
		'update_item'                => __('Aktualizovať sériu', 'kapital'),
		'view_item'                  => __('Zobraziť sériu', 'kapital'),
		'separate_items_with_commas' => __('Série oddelené čiarkami', 'kapital'),
		'add_or_remove_items'        => __('Pridať alebo odstrániť série', 'kapital'),
		'choose_from_most_used'      => __('Vyberte z najpoužívanejších', 'kapital'),
		'popular_items'              => __('Najpoužívanejšie série', 'kapital'),
		'search_items'               => __('Vyhľadať série', 'kapital'),
		'not_found'                  => __('Nenašli sa žiadne série', 'kapital'),
		'no_terms'                   => __('Žiadne série', 'kapital'),
		'items_list'                 => __('Zoznam tematických sérií', 'kapital'),
		'items_list_navigation'      => __('Navigácia zoznamu tematických sérií', 'kapital'),
		'desc_field_description'     => __('Popis série sa zobrazí medzi názvom a zoznamom článkov.', 'kapital')

	);
	$rewrite = array(
		'slug'                       => $kapital_taxonomies_with_list_pages[$taxonomy],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy($taxonomy, array('podcast'), $args);
}


function kapital_register_custom_taxonomies()
{
	register_author_taxonomy();
	register_rubriky_taxonomy();
	register_zanre_taxonomy();
	register_serie_taxonomy();
	register_cisla_taxonomy();
	register_partneri_taxonomy();
	register_jazyk_taxonomy();
	disable_kses();
	register_podcast_serie_taxonomy();
	unregister_taxonomy_for_object_type('category', 'post');
}

add_action('init', 'kapital_register_custom_taxonomies', 10);




/**
 * Reorder either top-level menu items or submenu level items or both.
 * If not editing top-level items, return the $menu_ord variable unchanged.
 * 
 * @param array $menu_ord Associative array of menu and submenu items
 *   passed to the function by the menu_order filter hook.
 *
 * @return array
 */
function reorder_post_submenu($menu_ord)
{
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
 * We need to disable KSES as it filters out all HTML from the term descriptions for security reasons
 * This allows tinyMCE to be initialized on term description
 */
function disable_kses()
{
	remove_filter('pre_term_description', 'wp_filter_kses');
}

//add_filter( 'custom_menu_order', '__return_true' );
add_filter('menu_order', 'reorder_post_submenu');



/**
 * Default taxonomy description field using WP editor
 *
 * @link    https://codex.wordpress.org/Javascript_Reference/wp.editor
 * @return  void
 */

function html_taxonomy_description()
{
?>
	<script>
		jQuery(document).ready(function($) {
			let field = 'tag-description';
			if (document.getElementById(field) == undefined) {
				field = 'description';
				console.log(field);
			}

			wp.editor.initialize(field, {
				tinymce: {
					toolbar1: 'formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
					plugins: 'link,lists,textcolor,colorpicker',
					menubar: false,
					statusbar: false,
					height: 300,
				},
				quicktags: true,
				mediaButtons: true,
			});

			$('#submit').mousedown(e => {
				console.debug('submit.mousedown', e);
				e.preventDefault();
				tinyMCE.triggerSave();
				$(e.currentTarget).trigger('click');
			});
		});
	</script>
<?php
}
foreach (['partner', 'cislo', 'seria', 'rubrika', 'jazyk', 'podcast-seria', 'pozicia', 'zaner'] as $taxonomy) {
	add_action("{$taxonomy}_edit_form_fields", 'html_taxonomy_description');
	add_action("{$taxonomy}_add_form_fields", 'html_taxonomy_description');
}


/** 
 * Loading editor assets for tinymce on term description
 *
 * @return  void
 */
function term_editor_includes()
{
	global $pagenow, $current_screen;

	if (in_array($pagenow, array('edit-tags.php', 'term.php'))) {
		wp_enqueue_editor();
		wp_enqueue_media();
	}
}
add_action('init', 'term_editor_includes');



/**
 * Creates pages for display of lists of custom taxonomies
 */
if ( class_exists( !'WooCommerce' ) ) {
	add_action('after_switch_theme', 'create_taxonomy_list_pages_on_theme_activation');
}

function create_taxonomy_list_pages_on_theme_activation()
{
	$list_pages = array();
	// Set the title, template, etc
	global $kapital_taxonomies_with_list_pages;
	foreach ($kapital_taxonomies_with_list_pages as $taxonomy => $rewrite) {
		$taxonomy_object = get_taxonomy($taxonomy);
		if ($taxonomy === 'autorstvo'){
			$page_template = 'templates/list-authors.php';
		} elseif($taxonomy === 'cislo') {
			$page_template = 'templates/list-issues.php';
		} else { 
			$page_template = 'templates/list-terms.php';
		}
		$list_pages[] = array(
			'slug' => $rewrite,
			'title' => $taxonomy_object->labels->name,
			'page_template' => $page_template,
			'page_content' => $taxonomy === 'autorstvo' ? __('Táto stránka bola automaticky vytvorená. Zobrazuje zoznam autorstva.', 'kapital') : __('Táto stránka bola automaticky vytvorená. Zobrazuje zoznam objektov v taxonómii:', 'kapital') . '"' . $taxonomy_object->labels->name . '"'
		);
	}
	//exists check
	foreach ($list_pages as $key => $list_page) {
		$page_check = get_posts(
			array(
				'post_type'              => 'page',
				'title'                  => $list_page['title'],
				'numberposts'            => 1,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			)
		);

		if (!empty($page_check)) $page_check = $page_check[0];
		if (isset($page_check->ID)) {
			$list_pages[$key]['page_exists'] = true;
		} else {
			$list_pages[$key]['page_exists'] = false;
		}
	}

	// Store the above data in an array

	// If the page doesn't already exist, create it
	foreach ($list_pages as $list_page) {

		if (!$list_page['page_exists']) {
			$new_page = array(
				'post_type'     => 'page',
				'post_title'    => $list_page['title'],
				'post_content'  => $list_page['page_content'],
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_name'     => $list_page['slug']
			);
			$new_page_id = wp_insert_post($new_page);
		} else {
			$new_page_id = $page_check->ID;
		}

		if (!empty($list_page['page_template'])) {
			update_post_meta($new_page_id, '_wp_page_template', $list_page['page_template']);
		}
	}
}

function kapital_add_issue_endpoint(){
    add_rewrite_endpoint( 'rok', EP_PAGES);
}

add_action( 'init', 'kapital_add_issue_endpoint' );


add_action( 'parse_term_query', function ( WP_Term_Query $wp_term_query ) {

    // Admin screens
    if ( is_admin() ) {
        return;
    }

    // REST API (Gutenberg, block editor, etc.)
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }

    // WP-CLI
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
        return;
    }

    $meta_query = (array) $wp_term_query->query_vars['meta_query'];

	$meta_query['relation'] = 'OR';
	
    $meta_query[] = [
        'key'     => '_kapital_term_private',
        'value'   => '1',
        'compare' => '!=',
    ];

	$meta_query[] = [
            'key'     => '_kapital_term_private',
            'compare' => 'NOT EXISTS',
	];

    $wp_term_query->query_vars['meta_query'] = $meta_query;

});