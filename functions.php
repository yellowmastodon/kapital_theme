<?php

/**
 * Custom functions / External files
 */

require_once 'includes/class-wp-bootstrap-navwalker.php';
require_once 'includes/custom_post_types.php';
require_once 'includes/custom_taxonomies.php';
require_once 'includes/custom_import.php';
require_once 'includes/render_functions.php';
require_once 'includes/old-site-functions.php';
//require_once 'includes/cmb-example-functions.php';
require_once 'block-editor/block-editor-functions.php';
require_once 'includes/author_taxonomy_functions.php';
require_once 'includes/custom_meta.php';
require_once 'includes/ads_post_type_functions.php';
require_once 'includes/custom_options.php';
require_once 'includes/ajax_functions.php';


//define months to be sure we can render them //fix for problem in localhost
$kapital_svk_months = array(
    __('január', 'kapital'),
    __('február', 'kapital'),
    __('marec', 'kapital'),
    __('apríl', 'kapital'),
    __('máj', 'kapital'),
    __('jún', 'kapital'),
    __('júl', 'kapital'),
    __('august', 'kapital'),
    __('september', 'kapital'),
    __('október', 'kapital'),
    __('november', 'kapital'),
    __('december', 'kapital')
);


/**
 * Add support for useful stuff and set image sizes
 */

if (function_exists('add_theme_support')) {

    // Add support for document title tag
    add_theme_support('title-tag');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    // add_image_size( 'custom-size', 700, 200, true );
    add_theme_support('align-wide');
    add_theme_support('align-full');

    // Add Support for post formats
    // add_theme_support( 'post-formats', ['post'] );
    // add_post_type_support( 'page', 'excerpt' );

    // Localisation Support
    load_theme_textdomain('kapital', get_template_directory() . '/languages');
}

/**
 * Set image sizes
 */

function kapital_theme_setup()
{
    add_image_size('placeholder', 1, 1, true); // 1x1px used as placeholder
    add_image_size('xlarge', 1920, 1920, false);
    add_image_size('xxlarge', 2560, 2560, false);
}
add_action('after_setup_theme', 'kapital_theme_setup');

//only default image sizes on theme switch
function kapital_switch_theme()
{
    update_option('thumbnail_size_w', 320);
    update_option('thumbnail_size_h', 320);
    update_option('thumbnail_crop', 0);
    update_option('medium_size_w', 640);
    update_option('medium_size_h', 640);
    update_option('medium_crop', 0);
    update_option('large_size_w', 1280);
    update_option('large_size_h', 1280);
    update_option('large_crop', 0);
}

add_action('switch_theme', 'kapital_switch_theme');


/**
 * Remove junk
 */

remove_image_size('1536x1536');
remove_image_size('2048x2048');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/**
 * Enqueue scripts
 */

function kapital_enqueue_scripts()
{
    // wp_enqueue_style( 'icons', '//use.fontawesome.com/releases/v5.0.10/css/all.css' );
    //remove jquery from front end
    if (!current_user_can('edit_posts')) {
        wp_deregister_script('jquery');
    }
    wp_enqueue_style('styles', get_stylesheet_directory_uri() . '/style.css?' . filemtime(get_stylesheet_directory() . '/style.css'), [], null);
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.min.js?' . filemtime(get_stylesheet_directory() . '/js/scripts.min.js'), [], null, true);
    wp_localize_script(
        'scripts',
        'site_info',
        array(
            'root' => get_bloginfo('url'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce'),
        )
    );
    wp_dequeue_style( 'wp-block-library' ); // Remove WordPress core CSS
    wp_deregister_style( 'wp-block-library' ); // Remove WordPress core CSS

    //wp_dequeue_style( 'wp-block-library-theme' ); // Remove WordPress theme core CSS
    wp_dequeue_style( 'classic-theme-styles' ); // Remove global styles inline CSS
    //wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
    wp_dequeue_style( 'global-styles' ); // Remove theme.json css
    wp_dequeue_style( 'wp-block-buttons' ); // Remove global styles inline CSS
    wp_deregister_style('wp-block-buttons' );

}

add_action('wp_enqueue_scripts', 'kapital_enqueue_scripts');



add_action('enqueue_block_editor_assets', function () {
    // Removes editor styles
    wp_deregister_style('wp-block-buttons');
    // Add back key styles, there may be more
    // change the path as needed
    
}, 102);

add_action(
	'wp_default_styles',
	function( $styles ) {

		/* Create an array with the two handles wp-block-library and
		 * wp-block-library-theme.
		 */
		$handles = [ 'wp-block-buttons', 'wp-block-button' ];

		foreach ( $handles as $handle ) {
			// Search and compare with the list of registered style handles:
			$style = $styles->query( $handle, 'registered' );
			if ( ! $style ) {
				continue;
			}
			// Remove the style
			$styles->remove( $handle );
			// Remove path and dependencies
			$styles->add( $handle, false, [] );
		}
	},
	PHP_INT_MAX
);



/**
 * Add async and defer attributes to enqueued scripts
 *
 * @param string $tag
 * @param string $handle
 * @param string $src
 * @return void
 */

function defer_scripts($tag, $handle, $src)
{

    // The handles of the enqueued scripts we want to defer
    $defer_scripts = [
        'SCRIPT_ID'
    ];

    // Find scripts in array and defer
    if (in_array($handle, $defer_scripts)) {
        return '<script type="text/javascript" src="' . $src . '" defer="defer"></script>' . "\n";
    }

    return $tag;
}

add_filter('script_loader_tag', 'defer_scripts', 10, 3);

/**
 * Remove unnecessary scripts
 *
 * @return void
 */

function deregister_scripts()
{
    wp_deregister_script('wp-embed');
}

add_action('wp_footer', 'deregister_scripts');


/**
 * Remove unnecessary styles
 *
 * @return void
 */

function deregister_styles()
{
    wp_dequeue_style('wp-block-library');
}

//add_action( 'wp_print_styles', 'deregister_styles', 100 );


/**
 * Register nav menus
 *
 * @return void
 */

function kapital_register_nav_menus()
{
    register_nav_menus([
        'main'   => __('Hlavné menu', 'kapital'),
        'quick'  => __('Rýchle menu', 'kapital'),
        'quick-serie-link' => __('Série v horizontálnej navigácii', 'kapital'),
        'footer' => 'Footer',
    ]);
}

add_action('after_setup_theme', 'kapital_register_nav_menus', 0);

add_action('customize_register', function ($wp_customize) {
    $section = $wp_customize->get_section('menu_locations');
    $section->description .= "<p>Hlavné menu sa zobrazí .</p>";
}, 12);



/**
 * Button Shortcode
 *
 * @param array $atts
 * @param string $content
 * @return void
 */

function kapital_button_shortcode($atts, $content = null)
{
    $atts['class'] = isset($atts['class']) ? $atts['class'] : 'btn';
    $atts['target'] = isset($atts['target']) ? $atts['target'] : '_self';
    return '<a class="' . $atts['class'] . '" href="' . $atts['link'] . '" target="' . $atts['target'] . '">' . $content . '</a>';
}

add_shortcode('button', 'kapital_button_shortcode');


/**
 * TinyMCE
 *
 * @param array $buttons
 * @return void
 */

function kapital_mce_buttons_2($buttons)
{
    array_unshift($buttons, 'styleselect');
    $buttons[] = 'hr';

    return $buttons;
}

add_filter('mce_buttons_2', 'kapital_mce_buttons_2');


/**
 * TinyMCE styling
 *
 * @param array $settings
 * @return void
 */

function kapital_tiny_mce_before_init($settings)
{
    $style_formats = [
        [
            'title' => 'Text Sizes',
            'items' => [
                [
                    'title'    => '2XL',
                    'selector' => 'span, p',
                    'classes'  => 'text-2xl'
                ],
                [
                    'title'    => 'XL',
                    'selector' => 'span, p',
                    'classes'  => 'text-xl'
                ],
                [
                    'title'    => 'LG',
                    'selector' => 'span, p',
                    'classes'  => 'text-lg'
                ],
                [
                    'title'    => 'MD',
                    'selector' => 'span, p',
                    'classes'  => 'text-md'
                ],
                [
                    'title'    => 'SM',
                    'selector' => 'span, p',
                    'classes'  => 'text-sm'
                ],
                [
                    'title'    => 'XD',
                    'selector' => 'span, p',
                    'classes'  => 'text-xs'
                ],
            ]
        ]
    ];

    $settings['style_formats'] = json_encode($style_formats);
    $settings['style_formats_merge'] = true;

    return $settings;
}

add_filter('tiny_mce_before_init', 'kapital_tiny_mce_before_init');


/**
 * Get post thumbnail url
 *
 * @param string $size
 * @param boolean $post_id
 * @param boolean $icon
 * @return void
 */

function get_post_thumbnail_url($size = 'full', $post_id = false, $icon = false)
{
    if (! $post_id) {
        $post_id = get_the_ID();
    }

    $thumb_url_array = wp_get_attachment_image_src(
        get_post_thumbnail_id($post_id),
        $size,
        $icon
    );
    return $thumb_url_array[0];
}


/**
 * Add Front Page edit link to admin Pages menu
 */

function front_page_on_pages_menu()
{
    global $submenu;
    if (get_option('page_on_front')) {
        $submenu['edit.php?post_type=page'][501] = array(
            __('Front Page', 'kapital'),
            'manage_options',
            get_edit_post_link(get_option('page_on_front'))
        );
    }
}
add_action('admin_menu', 'front_page_on_pages_menu');


function kapital_allow_svg_upload($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'kapital_allow_svg_upload');


function kapital_set_home_and_posts_page()
{
    update_option('show_on_front', 'page', 'on');

    $pages_to_create = array(
        'home' => array(
            'post_type'     => 'page',
            'post_title' => 'Domov',
            'post_name'  => 'domov',
            'post_status'   => 'publish',
            'post_author'   => 1,
        ),
        'posts_page' => array(
            'post_type'     => 'page',
            'post_title' => 'Články',
            'post_name' => 'clanky',
            'post_status'   => 'publish',
            'post_author'   => 1,
        )
    );
 
    foreach ($pages_to_create as $key => $page) {
        $page_check = get_posts(
            array(
                'post_type'              => 'page',
                'title'                  => $page['post_title'],
                'numberposts'            => 1,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            )
        );
        if (!empty($page_check)) $page_check = $page_check[0];
        if($page_check){
            $new_page_id = $page_check->ID;
        } else {
            $new_page_id = wp_insert_post($page);
        }
        if ($key === 'home'){
            update_option('page_on_front', $new_page_id, 'on');
        } else {
            update_option('page_for_posts', $new_page_id, 'on');
        }
    }
}

// Store the above data in an array

// If the page doesn't already exist, create it


add_action('after_switch_theme', 'kapital_set_home_and_posts_page');
