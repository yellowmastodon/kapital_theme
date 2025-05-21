<?php 

function kapital_post_edit_columns($columns) {
    unset( $columns['author'] );
    unset($columns['tags']);
    $columns['post_views'] = __( 'Zobrazenia', 'kapital' );
    //wp_die(var_export($columns,true));
    return $columns;
}
add_filter( 'manage_post_posts_columns', 'kapital_post_edit_columns' );


/** Add the data to the custom columns for the inzercia (ads) post type */
function kapital_post_columns( $column, $post_id ) {
    switch ( $column ) {

        case 'post_views':
            echo '<span class="post-views" data-id="' . $post_id . '"><span class="number"></span></span>';
            break;
        
    }
}
add_action( 'manage_post_posts_custom_column', 'kapital_post_columns', 10, 2 );


function my_custom_admin_scripts($hook) {
    // Load only on edit.php
    if ($hook !== 'edit.php') {
        return;
    }

    // Check that post type is 'post'
    $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : 'post';
    if ($post_type !== 'post') {
        return;
    }

    // Enqueue your script
    wp_enqueue_script(
        'admin_load_post_views',
        get_template_directory_uri() . '/js/admin-load-post-views.min.js',
        array('jquery'),
        '1.0.0',
        true
    );
    wp_localize_script(
        'admin_load_post_views',
        'site_info',
        array(
            'root' => get_bloginfo('url'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce'),
        )
    );
}
add_action('admin_enqueue_scripts', 'my_custom_admin_scripts');