<?php

/**
 * Custom functions / External files
 */

require_once 'includes/class-wp-bootstrap-navwalker.php';
require_once 'includes/custom_post_types.php';
require_once 'includes/custom_terms.php';
require_once 'includes/custom_import.php';
require_once 'includes/old-site-functions.php';
//require_once 'includes/cmb-example-functions.php';


require_once 'block-editor/block-editor-functions.php';



/**
 * Add support for useful stuff and set image sizes
 */

if ( function_exists( 'add_theme_support' ) ) {

    // Add support for document title tag
    add_theme_support( 'title-tag' );

    // Add Thumbnail Theme Support
    add_theme_support( 'post-thumbnails' );
    // add_image_size( 'custom-size', 700, 200, true );
    add_theme_support( 'align-wide' );
    add_theme_support( 'align-full' );

    // Add Support for post formats
    // add_theme_support( 'post-formats', ['post'] );
    // add_post_type_support( 'page', 'excerpt' );

    // Localisation Support
    load_theme_textdomain( 'kapital', get_template_directory() . '/languages' );
}

/**
 * Set image sizes
 */

 add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
 function wpdocs_theme_setup() {
     add_image_size( 'placeholder', 1, 1, true); // 300 pixels wide (and unlimited height)
 }

//only default image sizes on theme switch
function kapital_switch_theme() {
	update_option( 'thumbnail_size_w', 320 );
	update_option( 'thumbnail_size_h', 320 );
    update_option( 'thumbnail_crop', 0 );
    update_option( 'medium_size_w', 640 );
	update_option( 'medium_size_h', 640 );
    update_option( 'medium_crop', 0 );
    update_option( 'large_size_w', 1280 );
	update_option( 'large_size_h', 1280 );
    update_option( 'large_crop', 0 );
}

add_action('switch_theme', 'kapital_switch_theme');


/**
 * Remove junk
 */

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

function barebones_enqueue_scripts() {
   // wp_enqueue_style( 'icons', '//use.fontawesome.com/releases/v5.0.10/css/all.css' );
    //remove jquery from front end
    if( !current_user_can('edit_posts') ){
        wp_deregister_script('jquery');
    } 
    wp_enqueue_style( 'styles', get_stylesheet_directory_uri() . '/style.css?' . filemtime( get_stylesheet_directory() . '/style.css' ), [], null );
    wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.min.js?' . filemtime( get_stylesheet_directory() . '/js/scripts.min.js' ), [], null, true );
}

add_action( 'wp_enqueue_scripts', 'barebones_enqueue_scripts' );


/**
 * Add async and defer attributes to enqueued scripts
 *
 * @param string $tag
 * @param string $handle
 * @param string $src
 * @return void
 */

function defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = [
        'SCRIPT_ID'
    ];

    // Find scripts in array and defer
    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script type="text/javascript" src="' . $src . '" defer="defer"></script>' . "\n";
    }
    
    return $tag;
} 

add_filter( 'script_loader_tag', 'defer_scripts', 10, 3 );

/**
 * Remove unnecessary scripts
 *
 * @return void
 */

function deregister_scripts() {
    wp_deregister_script( 'wp-embed' );
}

add_action( 'wp_footer', 'deregister_scripts' );


/**
 * Remove unnecessary styles
 *
 * @return void
 */

function deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}

//add_action( 'wp_print_styles', 'deregister_styles', 100 );


/**
 * Register nav menus
 *
 * @return void
 */

function kapital_register_nav_menus() {
    register_nav_menus([
        'main'   => __('Hlavné menu', 'kapital'),
        'quick'  => __('Rýchle menu', 'kapital'),
        'quick-serie-link' => __('Série v horizontálnej navigácii', 'kapital'),
        'footer' => 'Footer',
    ]);
}

add_action( 'after_setup_theme', 'kapital_register_nav_menus', 0 );

add_action( 'customize_register', function( $wp_customize ) {
    $section = $wp_customize->get_section( 'menu_locations' );
    $section->description .= "<p>Hlavné menu sa zobrazí .</p>";
}, 12 );



/**
 * Button Shortcode
 *
 * @param array $atts
 * @param string $content
 * @return void
 */

function barebones_button_shortcode( $atts, $content = null ) {
    $atts['class'] = isset($atts['class']) ? $atts['class'] : 'btn';
    $atts['target'] = isset($atts['target']) ? $atts['target'] : '_self';
    return '<a class="' . $atts['class'] . '" href="' . $atts['link'] . '" target="'. $atts['target'] . '">' . $content . '</a>';
}

add_shortcode('button', 'barebones_button_shortcode');


/**
 * TinyMCE
 *
 * @param array $buttons
 * @return void
 */

function barebones_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    $buttons[] = 'hr';

    return $buttons;
}

add_filter('mce_buttons_2', 'barebones_mce_buttons_2');


/**
 * TinyMCE styling
 *
 * @param array $settings
 * @return void
 */

function barebones_tiny_mce_before_init( $settings ) {
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

add_filter('tiny_mce_before_init', 'barebones_tiny_mce_before_init');


/**
 * Get post thumbnail url
 *
 * @param string $size
 * @param boolean $post_id
 * @param boolean $icon
 * @return void
 */

    function get_post_thumbnail_url( $size = 'full', $post_id = false, $icon = false ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $thumb_url_array = wp_get_attachment_image_src(
        get_post_thumbnail_id( $post_id ), $size, $icon
    );
    return $thumb_url_array[0];
}


/**
 * Add Front Page edit link to admin Pages menu
 */

function front_page_on_pages_menu() {
    global $submenu;
    if ( get_option( 'page_on_front' ) ) {
        $submenu['edit.php?post_type=page'][501] = array( 
            __( 'Front Page', 'barebones' ), 
            'manage_options', 
            get_edit_post_link( get_option( 'page_on_front' ) )
        ); 
    }
}

add_action( 'admin_menu' , 'front_page_on_pages_menu' );
