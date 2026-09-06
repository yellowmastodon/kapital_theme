<?php


add_filter('the_title_rss', function(){
    global $post;
    $title = get_the_title($post);
    $secondary_title = get_post_meta($post->ID, '_secondary_title', true);
    if (!empty($secondary_title)){
        $title = kapital_ensure_sentence_end($title) . ' ' . trim($secondary_title);
    }
    return $title;
});


// Add image: namespace to feed header
add_action( 'rss2_ns', function() {
    echo 'xmlns:image="https://web.resource.org/rss/1.0/modules/image/"' . "\n";
} );

// Add image tags to each item
add_action( 'rss2_item', function() {
    global $post;
    $image_id = get_post_thumbnail_id( $post->ID );
    if ( ! $image_id ) return;

    $img = wp_get_attachment_image_src( $image_id, 'thumbnail' );
    if ( ! $img ) return;

    list( $url, $width, $height ) = $img;
    $link  = get_permalink( $post->ID );
    $title = esc_html( get_the_title( $post->ID ) );

    echo '<image:image>'
        . '<image:url><![CDATA[' . $url . ']]></image:url>'
        . '<image:title><![CDATA[' . $title . ']]></image:title>'
        . '<image:link><![CDATA[' . $link . ']]></image:link>'
        . '<image:width>' . $width . '</image:width>'
        . '<image:height>' . $height . '</image:height>'
        . '</image:image>';
} );

// Add image to description
add_filter( 'the_excerpt_rss', function( $excerpt ) {
    global $post;
    $image_id = get_post_thumbnail_id( $post->ID );
    if ( ! $image_id ) return $excerpt;

    $img = wp_get_attachment_image_src( $image_id, 'medium' );
    if ( ! $img ) return $excerpt;

    return '<img src="' . esc_url( $img[0] ) . '" /><br />' . $excerpt;
} );


add_action( 'init', function() {
    add_feed( 'rss', function() {
        load_template( ABSPATH . 'wp-includes/feed-rss2.php' );
    });
} );

/* add_action( 'init', function() {
    flush_rewrite_rules();
} ); */

add_filter( 'the_guid', function( $post_guid, $post_id ) {
    if ( ! is_feed() ) return $post_guid;
    return $post_guid . '?v=2';
}, 10, 2 );