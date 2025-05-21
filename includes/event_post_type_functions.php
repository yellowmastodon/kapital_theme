<?php

function kapital_event_edit_columns($columns) {
    unset( $columns['author'] );
    unset( $columns['date'] );
    $columns['event_date'] = __( 'Dátum podujatia', 'kapital' );
    //wp_die(var_export($columns,true));
    return $columns;
}
add_filter( 'manage_event_posts_columns', 'kapital_event_edit_columns' );

function timestampJsToPhp($timestamp){
    if (gettype($timestamp) !== 'integer'){
        $timestamp = (int) $timestamp;
    }
    $timestamp = $timestamp * 0.001;
    return $timestamp;
}

/** Add the data to the custom columns for the inzercia (ads) post type */
function kapital_event_columns( $column, $post_id ) {
    switch ( $column ) {

        case 'event_date':
           $event_date_object = get_post_meta( $post_id, '_event_date_string', true);
           //check if object
           if ($event_date_object && $event_date_object !== ""){
            $date_string = json_decode(get_post_meta( $post_id, '_event_date_string', true));
            echo get_post_meta($post_id, '_event_date_start', true);
            echo '<br>';
            echo 'current ' . current_time( 'timestamp', true );
            echo '<br>';
            echo 'end ' . get_post_meta($post_id, '_event_date_end', true); 
            echo '<br>';
            echo get_publish_datetime_element(get_post_meta($post_id ,'_event_date_start', true), '', $date_string->displayDate, __("Dátum podujatia", "kapital"));
           } else {
            echo __('Nedefinované', 'kapital');
           }
           break;
        
    }
}
add_action( 'manage_event_posts_custom_column', 'kapital_event_columns', 10, 2 );

/** Add the data to the custom columns for the event post type */
function kapital_sortable_event_custom_columns( $columns ) {
    $columns['event_date'] = 'event_date';
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}
add_filter( 'manage_edit-event_sortable_columns', 'kapital_sortable_event_custom_columns' );

/** Query by ad start date and ad end date (end date is the same as default date) */
function kapital_sort_by_event_date($query){
    global $pagenow;
    $year = get_query_var('rok');

    //only do this for main query
    if (!$query->is_main_query()) 
        return;

    //only for event post type
    $post_type = $query->get( 'post_type' );
    if ( $post_type !== 'event') 
        return;

    //order by event start date and exclude current events - outputed by custom query
    if ( !is_admin() && is_post_type_archive( 'event' ) ) {
        $meta_query = array(
            array(
                'key'     => '_event_date_end',
                'value'   => kapital_current_utc_timestamp(),
                /**
                 * Include only posts where _event_date_end is smaller than or equal to the current time
                 * that means only events that have already ended
                 *  */ 
                'compare' => '<=', 
                'type'    => 'NUMERIC',
            ),
        );

        $query->set( 'meta_query', $meta_query );
        $query->set( 'meta_key', '_event_date_start' );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'ignore_custom_sort', true );
        $query->set( 'order', 'DESC' );
        $query->set( 'posts_per_page', 12 ); // Limit to 12 posts per page
        
        //is query var?
        if ($year && $year !== "") {
            // Get the timezone from WordPress settings
            $timezone_string = get_option('timezone_string');
            $timezone = new DateTimeZone($timezone_string ? $timezone_string : 'UTC');

            // Create timestamps for the start and end of the year in the specified timezone
            $start_of_year = (new DateTime("{$year}-01-01 00:00:00", $timezone))->getTimestamp();
            $end_of_year = (new DateTime("{$year}-12-31 23:59:59", $timezone))->getTimestamp();

            //Setup meta query, rewrite of previous is intentional
            $query->set('meta_query', array(
                'relation' => 'AND', // Ensure both conditions are met
                array(
                    'key'     => '_event_date_start',
                    'value'   => $end_of_year, // Include events starting before the end of the year
                    'compare' => '<=',
                    'type'    => 'NUMERIC',
                ),
                array(
                    'key'     => '_event_date_end',
                    'value'   => $start_of_year, // Include events ending after the start of the year
                    'compare' => '>=',
                    'type'    => 'NUMERIC',
                ),
            ));

            // Set posts_per_page to unlimited
            $query->set('posts_per_page', -1);
        }


    //order, and sort for admin interface
    } else if (is_admin() && $pagenow === 'edit.php'){
        $order_by = $query->get( 'orderby' );
        if ( empty( $order_by ) )
            $order_by = 'event_date';
        switch ( $order_by ) {
            case 'event_date':
                $query->set( 'meta_key', '_event_date_start' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'ignore_custom_sort', true );
                $query->set( 'order', 'DESC' );
                break;
        }
    } 
}

add_action( 'pre_get_posts', 'kapital_sort_by_event_date', 10, 1);

/**
 * manually add rok as query vars
 * 
 */
function kapital_add_custom_rewrite_rules() {
    add_rewrite_rule(
        '^podujatia/rok/([0-9]{4})/?$', // Match URLs like /podujatia/rok/2025/
        'index.php?post_type=event&rok=$matches[1]', // Map to the event post type with the 'rok' query var
        'top'
    );
}
add_action('init', 'kapital_add_custom_rewrite_rules');

//longer excerpt
add_filter('excerpt_length', function($length) {
    global $post;
    if (isset($post) && $post->post_type === 'event') {
        return 60;
    }
    return $length;
}, 99);