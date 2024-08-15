<?php function kapital_custom_menu_import()
{
    add_menu_page(
    'Remap kategórií článkov (test)',                 //$page_title
    'Remap kategórií článkov (test)',                 //$menu_title
    'edit_posts',                        //$capability
    'custom_import_test',                     //$icon_url
    'kapital_render_custom_menu_import', //$callback
    'dashicons-database-import',         //$icon_url
    '7'                                  //$position
  );
}

function kapital_render_custom_menu_import(){
/*     if (!current_user_can('edit_posts'))  {
        wp_die( __('You do not have sufficient pilchards to access this page.')    );
      }
 */
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
    $json_file_path = get_theme_file_path('/includes/remap_terms.json');
    $remap_json = json_decode(file_get_contents($json_file_path), true);
    //var_dump($remap_json);
    $i = 1;
    $prev_cislo_slug = '';
    //$available_taxonomies = get_taxonomies(array(), 'names');
    //var_dump($available_taxonomies);
    echo '<table class="all_posts">' . '<tr><td></td><td>Názov</td><td>Staré kategórie</td><td>Nové kategórie</td><td>Ilustrák</td><td>Obálka</td><td>hashtag</td><td>Vizuál</td></tr>';
    while ($query->have_posts()){
        $query->the_post();
        $post_id = get_the_ID();
        $old_terms = get_the_terms($post_id, 'category');
        $old_terms_display = '';
        $new_terms_display = '';
        $cover_image = array();
        $hashtag_match = array();
        $hashtag = '';
        $cislo_featured_image = '';
        $vizual_match = array();
        $vizual = '';
        foreach($old_terms as $old_term){
            //echo $old_term->slug . '<br>';
            if (str_starts_with($old_term->slug, '20')){
                //echo 'trueeee<br>';
                $old_terms_display .= $old_term->name . ', ';
                $new_terms_display .= $old_term->slug . ' (číslo), ';
                $cislo_page = get_page_by_path($old_term->slug);
                //var_dump($cislo_page);
                if (!$cislo_page){
                    $cislo_page = get_page_by_path('archiv/' . $old_term->slug, OBJECT, 'page');
                    if (!$cislo_page){
                        $cislo_page = get_page_by_path('aktualne-cislo', OBJECT, 'page');
                    }
                }
                $cislo_featured_image = get_post_thumbnail_id( $cislo_page->ID );
                $vizual_match_string = '/\[bt_bb_text[^\]]*\][\s]*(<h2.*)\[\/bt_bb_text\]/s';
                $hashtag_match_string = '/(>|headline=\")(#[^0-9]{1,2}[^<\s\"]*)/';
                $cover_match_string = '/' . preg_quote('[bt_bb_image image="') . '([0-9]*)"/';
                //echo $hashtag_match_string . '<br>';
                if(!preg_match($cover_match_string, $cislo_page->post_content, $cover_image)){
                    $cover_image = array();
                };
                if(!preg_match($hashtag_match_string, $cislo_page->post_content, $hashtag_match)){
                    $hashtag = '';
                } else {
                    $hashtag = $hashtag_match[2];
                }
                if(!preg_match_all($vizual_match_string, $cislo_page->post_content, $vizual_match)){
                    $vizual = '';
                } else {
                    $vizual = $vizual_match[1][0];
                    //$vizual = $cislo_page->post_content;
                };
                //var_dump($vizual_match);
                if ($old_term->slug == $prev_cislo_slug){
                    $vizual = '--||--';
                }
                if($old_term->slug == '2020-04-dystopie'){
                    $hashtag = '#0800212212';
                }
                $prev_cislo_slug = $old_term->slug;
                //var_dump($hashtag);
            } else {
                $old_terms_display .= $old_term->slug . ', ';
                $json_key = null;
                $json_keys = array();
                $json_keys = array_keys(array_column($remap_json, 'ogslug'), $old_term->slug);
                echo '<br>////old_slug ';
                var_dump($old_term->slug);
                echo ' ' . get_the_title($post_id) . ' ';
                var_dump($json_keys);
                foreach ($json_keys as $key){
                    if ($remap_json[$key]['ogslug'] == $old_term->slug){
                        $json_key = $key;
                    }
                }
                var_dump($remap_json[$key]['ogslug']);
                var_dump($remap_json[$key]['newposttypeslug']);
                echo '////';
                //var_dump($json_key);
                //var_dump($remap_json[$json_key]);
                $new_terms_display .= $remap_json[$json_key]['newslug'] . ' (' . $remap_json[$json_key]['newcategorytypeslug'] . '), ';
            }
        }
        echo '<tr><td>' . $i  . '</td><td>' . get_the_title() . '</td><td>' . $old_terms_display . '<td>' . $new_terms_display . '</td><td class="thumb_image">' . wp_get_attachment_image($cislo_featured_image, 'medium') . '</td><td class="thumb_image">' . wp_get_attachment_image($cover_image[1], 'thumbnail') . '</td><td>'. $hashtag .'</td><td class="vizual-column">' . $vizual . '</td></tr>';
        $i++;
    }
    echo '</table>
    <style>.thumb_image img{max-width: 70px; max-height: 70px; object-fit: contain; } .vizual-column{max-width: 300px;} .all_posts td{vertical-align:top;}</style>';
    wp_reset_postdata();

}

add_action( 'admin_menu', 'kapital_custom_menu_import', 0 );

function kapital_custom_menu_import_real()
{
    add_menu_page(
    'Remap kategórií článkov',                 //$page_title
    'Remap kategórií článkov',                 //$menu_title
    'edit_posts',                        //$capability
    'custom_import',                     //$icon_url
    'kapital_custom_import',            //$callback
    'dashicons-database-import',         //$icon_url
    '8'                                  //$position
  );
}

add_action( 'admin_menu', 'kapital_custom_menu_import_real', 0 );


function kapital_custom_import(){
    $old_terms_to_delete = array();
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
    $json_file_path = get_theme_file_path('/includes/remap_terms.json');
    $remap_json = json_decode(file_get_contents($json_file_path), true);
    //$available_taxonomies = get_taxonomies(array(), 'names');
    while ($query->have_posts()){
        $query->the_post();
        $post_id = get_the_ID();
        $old_terms = get_the_terms($post_id, 'category');
        foreach($old_terms as $old_term){
            $old_term_id = $old_term->term_id;
            //var_dump($old_term_id);
            $old_term_slug = $old_term->slug;
            $old_term_name = $old_term->name;
            //CISLO
            if (str_starts_with($old_term_slug, '20')){
                cislo_remap_cat($old_term_slug, $old_term_id, $old_term_name, $post_id);
                if(!in_array($old_term_id, $old_terms_to_delete)){
                    array_push($old_terms_to_delete, $old_term_id);
                }
            //!CISLO
            } else {
                $json_key = null;
                $json_keys = array_keys(array_column($remap_json, 'ogslug'), $old_term->slug);
                foreach ($json_keys as $key){
                    if ($remap_json[$key]['ogslug'] === $old_term->slug){
                        $json_key = $key;
                    }
                }
                if (isset($remap_json[$json_key]['newposttypeslug'])){
                    //PODCAST
                    if ($remap_json[$json_key]['newposttypeslug'] == 'podcast'){
                       /* default importer assigns 'filmovy' to 'filmovy-2' so we need to filter it.
                       * all that have "ogparentcategory" : "kapitalx" should be podcasts
                       */
                        
                        remap_podcast($old_term_slug, $old_term_id, $old_term_name, $post_id);
                        if(!in_array($old_term_id, $old_terms_to_delete)){
                            array_push($old_terms_to_delete, $old_term_id);
                        }
                    //REDAKCIA
                    } elseif ($remap_json[$json_key]['newposttypeslug'] == 'redakcia'){
                        remap_redakcia($old_term_slug, $old_term_id, $old_term_name, $post_id);
                        if(!in_array($old_term_id, $old_terms_to_delete)){
                            array_push($old_terms_to_delete, $old_term_id);
                        }
                    //POST
                    } elseif ($remap_json[$json_key]['newposttypeslug'] == 'post'){
                        remap_other_cats($post_id, $remap_json[$json_key]);
                        if(!in_array($old_term_id, $old_terms_to_delete)){
                            array_push($old_terms_to_delete, $old_term_id);
                        }
                    }
                //IF no post type defined - POST
                } else {
                    if (isset($json_key)){
                        remap_other_cats($post_id, $remap_json[$json_key]);
                    }
                }
            }
        }

    }
    foreach ($old_terms_to_delete as $old_term){
        wp_delete_term($old_term, 'category');
    }
    wp_reset_postdata();
}

function cislo_remap_cat($old_term_slug, $old_term_id, $old_term_name, $post_id){
    //get ACF fields IDs 
    $hashtag = '';
    $vizual = '';
    $cover_image = null;
    $cislo_featured_image = null;
    $cislo_page = get_page_by_path($old_term_slug);
    if (!$cislo_page){
        $cislo_page = get_page_by_path('archiv/' . $old_term_slug, OBJECT, 'page');
        if (!$cislo_page){
            $cislo_page = get_page_by_path('aktualne-cislo', OBJECT, 'page');
        }
    }
    $cislo_featured_image = get_post_thumbnail_id( $cislo_page->ID );
    $vizual_match_string = '/\[bt_bb_text[^\]]*\][\s]*(<h2.*)\[\/bt_bb_text\]/s';
    $hashtag_match_string = '/(>|headline=\")(#[^0-9]{1,2}[^<\s\"]*)/';
    $cover_match_string = '/' . preg_quote('[bt_bb_image image="') . '([0-9]*)"/';
    if(!preg_match($cover_match_string, $cislo_page->post_content, $cover_image)){
        $cover_image = array();
    };
    if(!preg_match($hashtag_match_string, $cislo_page->post_content, $hashtag_match)){
        $hashtag = '';
    } else {
        $hashtag = $hashtag_match[2];
    }
    if(!preg_match_all($vizual_match_string, $cislo_page->post_content, $vizual_match)){
        $vizual = '';
    } else {
        $vizual = $vizual_match[1][0];
    };
    if($old_term_slug == '2020-04-dystopie'){
        $hashtag = '#0800212212';
    }
    if (!term_exists($old_term_slug, 'cislo')){
        $new_term = wp_insert_term($old_term_name, 'cislo', array('slug'=>$old_term_slug));
        $new_term_id = $new_term['term_id'];
        if(isset($hashtag) && !empty($hashtag)){
            update_field('hashtag', $hashtag, 'cislo_' . (string)$new_term_id);
        }
        if (isset($vizual) && !empty($vizual)){
            update_field('ending_text', $vizual,  'cislo_' . (string)$new_term_id);
        }
        if (isset($cislo_featured_image) && !empty($cislo_featured_image)){
            update_field('featured_image', get_post($cislo_featured_image),  'cislo_' . (string)$new_term_id);
        }
        if (isset($cover_image[1]) && !empty($cover_image[1])){
            update_field('cover', get_post( $cover_image[1] ),  'cislo_' . (string)$new_term_id);
        }
        wp_set_object_terms($post_id, $old_term_slug, 'cislo', true);
        
    } else {
        wp_set_object_terms($post_id, $old_term_slug, 'cislo', true);
    }

}

function remap_podcast($old_term_slug, $old_term_id, $old_term_name, $post_id){

    if (get_post_type($post_id) != 'podcast' ){
        set_post_type($post_id, 'podcast');
    }
    if($old_term_slug !== 'kapitalx'){
        if (!term_exists($old_term_slug, 'podcast-seria')){
            $new_term = wp_insert_term($old_term_name, 'podcast-seria', array('slug'=>$old_term_slug));
            $new_term_id = $new_term['term_id'];
            wp_set_object_terms($post_id, $new_term_id, 'podcast-seria', true);
            //set featured image for podcast séria as the current post thumbnail
            update_field('featured_image', get_post(get_post_thumbnail_id($post_id)), 'podcast-seria_' . (string)$new_term_id);
        } else {
            wp_set_object_terms($post_id, $old_term_slug, 'podcast-seria', true);
        }
    }
}
function remap_redakcia($old_term_slug, $old_term_id, $old_term_name, $post_id){
    if (get_post_type($post_id) !== 'redakcia' ){
        set_post_type($post_id, 'redakcia');
    }
    if (!term_exists($old_term_slug, 'redakcia-tag')){
        $new_term = wp_insert_term($old_term_name, 'redakcia-tag', array('slug'=>$old_term_slug));
        $new_term_id = $new_term['term_id'];
        wp_set_object_terms($post_id, $new_term_id, 'redakcia-tag', true);
    } else {
        wp_set_object_terms($post_id, $old_term_slug, 'redakcia-tag', true);
    }
}
function remap_other_cats($post_id, $remap_array){
    $current_term_taxonomy = '';
    if (isset($remap_array['newcategorytypeslug'])){
        switch ($remap_array['newcategorytypeslug']) {
            case 'rubriky':
                $current_term_taxonomy = 'category';
            break;
            case 'zanre':
                $current_term_taxonomy = "zaner";
            break;
            case 'jazyk':
                $current_term_taxonomy = "jazyk";
            break;
            case 'tematicke-serie':
                $current_term_taxonomy = "seria";
            break;
            case 'specialny-tag':
                $current_term_taxonomy = "category";
            break;
            case 'partneri':
                $current_term_taxonomy = "partner";
            break;
        }
    }
    if (isset($remap_array['newslug']) && $current_term_taxonomy !== ''){
        if (!term_exists($remap_array['newslug'], $current_term_taxonomy)){
            $term_args = array('slug'=>$remap_array['newslug']);
            if (isset($remap_array["newparentcategoryslug"]) && $remap_array["newparentcategoryslug"] !== ''){
                if (!term_exists($remap_array["newparentcategoryslug"], $current_term_taxonomy)){
                    $parent_term = wp_insert_term($remap_array["newparentcategory"], $current_term_taxonomy, array('slug'=>$remap_array['newparentcategoryslug']));
                    $parent_term_id = $parent_term['term_id'];
                    update_field('featured_image', get_post(get_post_thumbnail_id($post_id)), $current_term_taxonomy . '_' . (string)$parent_term_id);
                } else {
                    $parent_term = get_term_by('slug', $remap_array["newparentcategoryslug"], $current_term_taxonomy, OBJECT);
                    $parent_term_id = $parent_term->term_id;
                }
                $term_args['parent'] = $parent_term_id;
            }
            $new_term = wp_insert_term($remap_array["newcategorytitle"], $current_term_taxonomy, $term_args);
            $new_term_id = $new_term['term_id'];
            update_field('featured_image', get_post(get_post_thumbnail_id($post_id)), $current_term_taxonomy . '_' . (string)$new_term_id);
            wp_set_object_terms($post_id,  $new_term_id, $current_term_taxonomy, true);
        } elseif ( $current_term_taxonomy !== '') {
            wp_set_object_terms($post_id, $remap_array['newslug'], $current_term_taxonomy, true);         
        }
    }
}
