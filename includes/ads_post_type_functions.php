<?php
/** Disables gutenberg for selected post types */
function kapital_disable_gutenberg( $current_status, $post_type ) {

    // Disabled post types
    $disabled_post_types = array( 'inzercia', 'recommendation' );

    // Change $can_edit to false for any post types in the disabled post types array
    if ( in_array( $post_type, $disabled_post_types, true ) ) {
        $current_status = false;
    }

    return $current_status;
}
add_filter( 'use_block_editor_for_post_type', 'kapital_disable_gutenberg', 10, 2 );

/** saves end date from acf as post publish date */
function kapital_update_post_date_from_acf($post_id, $post) {
	// remove this filter to prevent potential infinite loop
	// date format must be "Y-m-d H:i:s"
    remove_action('save_post', 'kapital_update_post_date_from_acf', 20);
    if ($post->post_type === "inzercia"){
        $post_date = get_field('ad_end_date');
        $post = wp_update_post(array(
            'ID' => $post_id,
            'post_date' => $post_date));
    } elseif ($post->post_type === "recommendation") {
        $post_date = get_field('recommendation_end_date');
        $post = wp_update_post(array(
            'ID' => $post_id,
            'post_date' => $post_date));
    }

}
add_action('save_post', 'kapital_update_post_date_from_acf', 20, 2);

/** edit.php modifications */

/** Add the custom columns to the book post type */
function kapital_inzercia_edit_columns($columns) {
    unset( $columns['author'] );
    unset( $columns['date'] );
    $columns['ad_start_date'] = __( 'Začiatok inzercie (vrátane)', 'kapital' );
    $columns['ad_end_date'] = __( 'Koniec inzercie (vrátane)', 'kapital' );
    $columns['ad_url'] = __( 'Link', 'kapital' );
    $columns['ad_clicks'] = __('Kliknutia', 'kapital');
    $columns['ad_desktop_image'] = __('Obrázok desktop', 'kapital');
    $columns['ad_mobile_image'] = __('Obrázok mobil', 'kapital');
    return $columns;
}
add_filter( 'manage_inzercia_posts_columns', 'kapital_inzercia_edit_columns' );



function kapital_recommendation_edit_columns($columns) {
    unset( $columns['author'] );
    unset( $columns['date'] );
    $columns['rec_start_date'] = __( 'Začiatok zobrazenia odporúčania (vrátane)', 'kapital' );
    $columns['rec_end_date'] = __( 'Koniec zobrazenia odporúčania (vrátane)', 'kapital' );
    $columns['rec_url'] = __( 'Link', 'kapital' );
    return $columns;
}

add_filter( 'manage_recommendation_posts_columns', 'kapital_recommendation_edit_columns' );


/** Add the data to the custom columns for the inzercia (ads) post type */
function kapital_inzercia_columns( $column, $post_id ) {
    switch ( $column ) {

        case 'ad_start_date':
           echo date('d. m. Y', strtotime(get_field('ad_start_date')));
           break;
        //change date rendering
        case 'ad_end_date':
            echo get_the_time('d. m. Y', $post_id); 
            break;
        case 'ad_url':
            echo get_field('ad_url', $post_id); 
            break;
        case 'ad_clicks':
            echo get_post_meta($post_id, '_ad_click_counter', true);
            break;
        case 'ad_desktop_image':
            echo '<img class="ad_column_image" src="'. wp_get_attachment_image_src(get_field('ad_desktop_image', $post_id), 'thumbnail')[0] . '"/>'; 

            //echo '<img class="ad_column_image" src="'. wp_get_attachment_image_src(get_field('ad_desktop_image', $post_id), 'thumbnail') . '"/>'; 
            break;
        case 'ad_mobile_image':
            echo '<img class="ad_column_image" src="'. wp_get_attachment_image_src(get_field('ad_mobile_image', $post_id), 'thumbnail')[0] . '"/>'; 
            break;
    }
}
add_action( 'manage_inzercia_posts_custom_column', 'kapital_inzercia_columns', 10, 2 );



function kapital_recommendation_columns( $column, $post_id ) {
    switch ( $column ) {

        case 'rec_start_date':
           echo date('d. m. Y', strtotime(get_field('recommendation_start_date')));
           break;
        //change date rendering
        case 'rec_end_date':
            echo get_the_time('d. m. Y', $post_id); 
            break;
        case 'rec_url':
            echo get_field('recommendation_url', $post_id); 
            break;
    }
}
add_action( 'manage_recommendation_posts_custom_column', 'kapital_recommendation_columns', 10, 2 );

function kapital_inzercia_row_actions( $actions, $post ) {
    if ( 'inzercia' === $post->post_type || 'recommendation' === $post->post_type) {
        // Removes the "Quick Edit" action.
        unset( $actions['inline hide-if-no-js'] );
    }
    return $actions;
}
add_filter( 'post_row_actions', 'kapital_inzercia_row_actions', 10, 2 );



/** Make columns sortable for the inzercia (ads) post type */
function kapital_sortable_inzercia_custom_columns( $columns ) {
    $columns['ad_start_date'] = 'ad_start_date';
    $columns['ad_end_date'] = 'ad_end_date';
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}
add_filter( 'manage_edit-inzercia_sortable_columns', 'kapital_sortable_inzercia_custom_columns' );

function kapital_sortable_recommendation_custom_columns( $columns ) {
    $columns['rec_start_date'] = 'rec_start_date';
    $columns['rec_end_date'] = 'rec_end_date';
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
    return $columns;
}
add_filter( 'manage_edit-recommendation_sortable_columns', 'kapital_sortable_recommendation_custom_columns' );

/** Query by ad start date and ad end date (end date is the same as default date) */
function kapital_sort_by_ad_date($query){
    global $pagenow;
    if ( !is_admin() || $pagenow !== 'edit.php' )
        return;
    $post_type = $query->get( 'post_type' );
    $order_by = $query->get( 'orderby' );

    if ( $post_type === 'inzercia' || $post_type === 'recommendation') {
        if ( empty( $order_by ) )
            $order_by = 'ad_end_date';
        
        switch ( $order_by ) {
            case 'ad_start_date':
                $query->set( 'meta_key', 'ad_start_date' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'ignore_custom_sort', true );
                break;
            case 'recommendation_start_date':
                $query->set( 'meta_key', 'recommendation_start_date' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'ignore_custom_sort', true );
                break;
            case 'ad_end_date':
                $query->set('orderby', 'date');
        }
    }
}

add_action( 'pre_get_posts', 'kapital_sort_by_ad_date', 10, 1);

/** fix rendering of ad image on edit.php */
function kapital_ad_image_size(){
    global $pagenow;
    global $typenow;
    if ( !is_admin() || $pagenow !== 'edit.php' || $typenow !== 'inzercia')
            return;
    echo '<style>.ad_column_image{max-width:100%}</style>';

}
add_action( 'admin_head', 'kapital_ad_image_size' );

function kapital_register_ad_counter_meta(){
    register_post_meta( 'inzercia', '_ad_click_counter', array(
        'single' => true,
        'type'  => 'integer',
        'default' => 0
        )
    );
}
add_action('init', 'kapital_register_ad_counter_meta');