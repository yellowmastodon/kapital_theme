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

