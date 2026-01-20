<?php

/**
 * SEO overrides for RankMath plugin
 * called directly by plugin
 * 
 */

add_filter('rank_math/json_ld', function($data) {

    global $post;

    // Remove default ProfilePage
    unset($data['ProfilePage']);

    $org_author = [
        '@id' => home_url(),
        '@type' => "Organization",
        'name' => get_bloginfo('name')      
    ];
    
    //make sure richsnippet exists
    if (!isset($data['richSnippet'])) return $data;
    //$data['richSnippet'] = [];
    if ($post->post_type === 'post') {

        $authors = wp_get_post_terms($post->ID, 'autorstvo');

        if (!empty($authors)) {

            if (count($authors) === 1) {
                $data['richSnippet']['author'] = [
                    '@id' => get_term_link($authors[0]),
                    '@type' => "Person",
                    'name' => $authors[0]->name,
                    'url' => get_term_link($authors[0])
                ];
            } else {
                $data['richSnippet']['author'] = [];
                foreach ($authors as $author) {
                    $data['richSnippet']['author'][] = [
                        '@id' => get_term_link($author),
                        '@type' => "Person",
                        'name' => $author->name,
                    ];
                }
            }

        } else {
            $data['richSnippet']['author'] = $org_author;
        }

    } else {
        $data['richSnippet']['author'] = $org_author;
    }

    return $data;

}, 98 );

/**
 * Filter URL entry before it gets added to the sitemap.
 *
 * @param array  $url  Array of URL parts.
 * @param string $type URL type. Can be user, post or term.
 * @param object $object Data object for the URL.
 */
add_filter( 'rank_math/sitemap/entry', function( $url, $type, $object ){
	
    if ( $type !== 'term' || empty( $object->term_id ) ) {
        return $url;
    }

    if ( get_term_meta( $object->term_id, '_kapital_term_private', true ) === '1' ) {
        return false;
    }

    return $url;

}, 10, 3 );