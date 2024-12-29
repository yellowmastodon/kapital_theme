<?php

/** Not really import, used to remap everything to new structure
 * old site used only categories
 * new site uses custom taxonomies and custom post types
 */



function kapital_custom_menu_import()
{
    add_menu_page(
        'Remap kategórií článkov (test)',                 //$page_title
        'Remap kategórií článkov (test)',                 //$menu_title
        'edit_posts',                        //$capability
        'custom_import_test',                     //$icon_url
        'kapital_render_custom_menu_import_test', //$callback
        'dashicons-database-import',         //$icon_url
        '7'                                  //$position
    );
}


function kapital_custom_post_menu_import()
{
    add_menu_page(
        'Remap obsahu článkov (test)',                 //$page_title
        'Remap obsahu článkov (test)',                 //$menu_title
        'edit_posts',                        //$capability
        'remap_post_content_test',                     //$icon_url
        function (){
            remap_post_content(true);
        }, //$callback
        'dashicons-database-import',         //$icon_url
        '9'                                  //$position
    );
}

function kapital_custom_post_menu_import_real()
{
    add_menu_page(
        'Remap obsahu (naozaj)',                 //$page_title
        'Remap obsahu (naozaj)',                 //$menu_title
        'edit_posts',                        //$capability
        'remap_post_content_real',                     //$icon_url
        function (){
            remap_post_content(false);
        }, //$callback
        'dashicons-database-import',         //$icon_url
        '9'                                  //$position
    );
}



function kapital_custom_remap_already_imported_authors_test()
{
    add_menu_page(
        'Remap už importovaných autorov (test)',                 //$page_title
        'Remap už importovaných autorov (test)',                 //$menu_title
        'edit_posts',                        //$capability
        'remap_authors',                     //$icon_url
        function (){
            remap_authors(true);
        }, //$callback
        'dashicons-database-import',         //$icon_url
        '9'                                  //$position
    );
}

function kapital_custom_remap_already_imported_authors_real()
{
    add_menu_page(
        'Remap už importovaných autorov (naozaj)',                 //$page_title
        'Remap už importovaných autorov (naozaj)',                 //$menu_title
        'edit_posts',                        //$capability
        'remap_authors_real',                     //$icon_url
        function (){
            remap_authors(false);
        }, //$callback
        'dashicons-database-import',         //$icon_url
        '9'                                  //$position
    );
}

add_action('admin_menu', 'kapital_custom_remap_already_imported_authors_test', 0);
add_action('admin_menu', 'kapital_custom_remap_already_imported_authors_real', 0);


add_action('admin_menu', 'kapital_custom_post_menu_import', 0);
add_action('admin_menu', 'kapital_custom_post_menu_import_real', 0);


function remap_authors($test){
    $authors = get_terms(array(
        'taxonomy' => 'autorstvo'
    ));
    if ($test) echo '<table>';
    echo '<tr><td>Meno</td><td>Prvé meno</td><td>Priezvisko</td><td>Celé meno</td></tr>';
        foreach($authors as $author){
            $first_name = get_term_meta($author->term_id, "_author_name_meta", true)->first_name;
            $last_name = get_term_meta($author->term_id, "_author_name_meta", true)->last_name;
            $full_name = get_term_meta($author->term_id, "_author_full_name", true);
            if($test){
                echo '<tr>';
                echo '<td>' . $author->name . '</td>';
                echo '<td>' . $first_name . '</td>';
                echo '<td>' . $last_name . '</td>';
                echo '<td>' .  $full_name . '</td>';
                echo '</tr>';
            } else {
                wp_update_term($author->term_id, 'autorstvo', array(
                    'name' => $full_name
                ));
                update_term_meta($author->term_id, "_author_last_name", $last_name);
                update_term_meta($author->term_id, "_author_first_name", $first_name);
                delete_term_meta($author->term_id, "_author_name_meta");
                delete_term_meta($author->term_id, "_author_full_name");

            }

        }
    if ($test) echo '</table>';

}

function remap_post_content($test = true)
{
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'date_query' => [
            'column' => 'post_date',
            'after'  => [
                'year'  => 2024,
                'month' => 11,
                'day'   => 22,
            ]],
        //'p' => 32729
    );
    $query = new WP_Query($args);


    if ($test) echo '<table class="all_posts">' . '<tr><td>Článok</td><td>Podnadpis</td><td>PEREX</td><td>IFRAMES</td><td>poznámky</td><td>Obsah</td></tr>';
    while ($query->have_posts()) {
        $query->the_post();
        if ($test) echo '<tr>';
        global $post;
        if ($test) echo '<td><a href="' . get_post_permalink($post) .  '">' . get_the_title($post) . '</a></td>';
        $content = get_the_content(null, null, $post);

        /** exceptions slugs for secondary title:
         * literarna-priloha-basne-sucasnych-palestinskych-poetiek
         * hlucha-republika
         * semenchuk-basne
         * iljasenko-basne
         * literarna-priloha-basne-sucasnych-palestinskych-poetiek
         * byt-plavcickou-nie-je-umelecky-koncept
         * dobro-pozalovat-v-evrosojuze
         * divoki-detektivi
         * agro-zivot-s-krajinou
         * some posts even start with h3 as secondary title
         * 
         * 
         * 
         */
        $secondary_title_exceptions = [
            'literarna-priloha-basne-sucasnych-palestinskych-poetiek',
            'hlucha-republika',
            'semenchuk-basne',
            'iljasenko-basne',
            'literarna-priloha-basne-sucasnych-palestinskych-poetiek',
            'byt-plavcickou-nie-je-umelecky-koncept',
            'dobro-pozalovat-v-evrosojuze',
            'divoki-detektivi',
            'agro-zivot-s-krajinou'
        ];
        $secondary_title_match = [];


        $secondary_title = "";
        $render_content = "";
        if (!in_array($post->post_name, $secondary_title_exceptions)) {
            if (str_starts_with($content, '<h2>') || str_starts_with($content, '<h3>') || str_starts_with($content, '\n<h2>') || str_starts_with($content, '\n<h3>')) {
                preg_match_all('/(<h2>|<h3>)([\s\S]*?)(<\/h2>|<\/h3>)/m', $content, $secondary_title_match);
                if (isset($secondary_title_match[2][0])) {
                    $secondary_title = $secondary_title_match[2][0];
                    $pattern = preg_quote($secondary_title_match[1][0] . $secondary_title . $secondary_title_match[3][0], '/');
                    $secondary_title = strip_tags($secondary_title, ['em', 'i', 'a']);
                    $content = preg_replace('/' . $pattern . '/', '', $content, 1);
                    $content = preg_replace('/h3>/', 'h2>', $content);
                    $content = preg_replace('/h4>/', 'h3>', $content);
                } else {
                    $secondary_title = "";
                }
                $render_content = $content;
            } else {
                $secondary_title = "";
                $render_content = "";
            }
        }
        //remove some wierd spans
        $content = preg_replace('/' . preg_quote('<span style="font-weight: 400;">', '/') . '([\s\S]*?)' . preg_quote('</span>', '/') . '/', '$1', $content);
        $content = preg_replace('~^\s+|\s+$/~u', '$2', html_entity_decode($content)); //trim nbsp
        $content = preg_replace('/(\r\n|\r|\n)&nbsp;(\r\n|\r|\n)/', '$1', htmlentities($content)); //fix empty paragraphs after html_entity_decode
        $perex_match = [];
        $perex = "";


        /** perex exceptions
         * manifest-virtualneho-materializmu
         * andrea-boknikova-aj-v-smutnej-basni-mozeme-najst-silu
         */
        $perex_exceptions = [
            'manifest-virtualneho-materializmu',
            'andrea-boknikova-aj-v-smutnej-basni-mozeme-najst-silu',
            'zem-zem'
        ];
        $content = html_entity_decode($content);
        $content = preg_replace('/<\/b>(\s{0,1})<b>|<\/strong>(\s{0,1})<strong>/', '$1', $content); //sometimes the bold is broken in multiple elements
        if (!in_array($post->post_name, $perex_exceptions)) {

            if (str_starts_with($content, '<b>') || str_starts_with($content, '<strong>')) {
                preg_match('/(<b>|<strong>)([\s\S]*?)(<\/b>|<\/strong>)/m', $content, $perex_match);
                if (isset($perex_match[2])) {
                    $perex = $perex_match[2];
                    $pattern = preg_quote($perex_match[1] . $perex_match[2] . $perex_match[3], '/');
                    //var_dump($pattern);
                    $content = preg_replace('/' . $pattern . '/', '', $content, 1);
                    $content = preg_replace('~^\s+|\s+$/~u', '$2', $content); //trim nbsp again;
                    $render_content = $content;
                }
                $content = htmlentities($content);
            }
            /** fix fucked iframes */
            $iframe_new_code_start = '<div style="aspect-ratio:16/9; position: relative;" class="alignwide imported-post-iframe-video rounded">';
            $iframe_new_code_end = '</div>';
            $pattern = '(' . preg_quote('<div style="', '/') . '[\s\S]*?' . ')(' . preg_quote('<iframe') . '[\s\S]*?' . preg_quote('</iframe>', '/') . ')' . '[\s\S]*?' . '(' . preg_quote('</div>', '/') . ')';
            $iframe_matches = array();
            $content = html_entity_decode($content);
            preg_match_all('/' . $pattern . '/m', $content, $iframe_matches);
            //just testing var
            $iframes = "";
            if (isset($iframe_matches[2][0])) {
                foreach ($iframe_matches[2] as $key => $iframe) {
                    $iframes .= esc_html($iframe) . '<br>';
                    $content = preg_replace('/' . preg_quote($iframe_matches[1][$key], '/') . '/', $iframe_new_code_start, $content);
                }
                $render_content = esc_html($content);
            }

            $footnote_matches = array();
            //just testing var
            $footnotes_str = "";
            $footnotes_arr = array();
            $pattern = '(' . preg_quote('[mfn]', '/') . ')' . '([\s\S]*?)' . '(' . preg_quote('[/mfn]', '/') . ')';
            preg_match_all('/' . $pattern . '/m', $content, $footnote_matches);
            if (isset($footnote_matches[2][0])) {
                foreach ($footnote_matches[2] as $key => $match) {
                    $uniqid = uniqid();
                    $footnotes_str .= $match . '<br>';
                    $footnotes_arr[] = (object) array("content" => utf8_encode(htmlentities($match)), 'id' => $uniqid);
                    $content = preg_replace('/' . preg_quote($footnote_matches[1][$key], '/') . preg_quote($footnote_matches[2][$key], '/') . preg_quote($footnote_matches[3][$key], '/') . '/', '<sup data-fn="' .  $uniqid . '" class="fn"><a href="#' .  $uniqid . '" id="' .  $uniqid . '-link">' . $key + 1 . '</a></sup>', $content
                    );
                }
                $content .= "\r\n" . '<!-- wp:footnotes /-->';
                $render_content = $content;
            }
            $footnotes_arr = json_encode($footnotes_arr, 0, 2);

            $content = wpautop($content);

            if ($perex !== ""){
                $content = '<!-- wp:kapital/perex {"useAsExcerpt":false} -->' . "\r\n" . '<p class="wp-block-kapital-perex perex alignwide ff-grotesk">' . $perex . '</p>' . "\r\n" . '<!-- /wp:kapital/perex -->' .  "\r\n" . $content;
                $render_content = wpautop($content, true);
            } 

            if ($secondary_title !== ""){
                $content = '<!-- wp:kapital/secondary-title -->' . "\r\n" . '<p class="wp-block-kapital-secondary-title fw-bold secondary-title alignnormal text-center ff-grotesk">' . $secondary_title . '</p>' . "\r\n" . '<!-- /wp:kapital/secondary-title -->' .  "\r\n" . $content;
                $render_content = $content;
                if (!$test) update_post_meta($post->ID, '_secondary_title', $secondary_title);
            }
            //$content = htmlentities($content);
            if (!empty($footnotes_arr) && (!$test)) update_post_meta($post->ID, 'footnotes', $footnotes_arr);
            if (!$test) wp_update_post(array(
                'ID' => $post->ID,
                'post_content' => $content
            ));
            /** remap footnotes */
        }
        if ($test) {
            echo '<td>' . $secondary_title . '</td>';
            echo '<td>' . $perex . '</td>';
            echo '<td>' . $iframes . '</td>';
            echo '<td>' . $footnotes_arr . '</td>';
            echo '<td><div class="show-more-content hide">' .  $render_content . '</div><br><a href="#" class="show-more">Rozbaliť</a></td>';
            echo '</tr>';
        }
    }
    if ($test) echo '</table>'; ?>

    <style>
        table {
            max-width: 100%;
        }

        table a {
            color: black;
        }

        table td {
            vertical-align: top;
        }

        .show-more-content {
            max-width: 100%;

        }

        .show-more-content.hide {
            max-height: 50px;
            overflow: hidden;
        }

        table tr:nth-child(odd) {
            background: lightgrey;
        }
    </style>
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('show-more')) {
                event.preventDefault();
                console.log(event.target);
                let showMoreContent = event.target.parentNode.querySelector('.show-more-content');
                if (showMoreContent.classList.contains('hide')) {
                    showMoreContent.classList.remove('hide');
                } else {
                    showMoreContent.classList.add('hide');
                }
            }
        });
    </script>

<?php

}

function kapital_render_custom_menu_import_test()
{
    /*     if (!current_user_can('edit_posts'))  {
        wp_die( __('You do not have sufficient pilchards to access this page.')    );
      }
 */
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'date_query' => [
            'column' => 'post_date',
            'after'  => [
                'year'  => 2024,
                'month' => 11,
                'day'   => 22,
            ]],);
    $query = new WP_Query($args);
    $json_file_path = get_theme_file_path('/includes/remap_terms.json');
    $remap_json = json_decode(file_get_contents($json_file_path), true);
    //var_dump($remap_json);
    $i = 1;
    $prev_cislo_slug = '';
    //$available_taxonomies = get_taxonomies(array(), 'names');
    //var_dump($available_taxonomies);
    echo '<table class="all_posts">' . '<tr><td></td><td>Názov</td><td>Podnadpis</td><td>Autorstvo</td><td>Staré kategórie</td><td>Nové kategórie</td><td>Ilustrák</td><td>Obálka</td><td>hashtag</td><td>Vizuál</td></tr>';
    while ($query->have_posts()) {
        $query->the_post();
        global $post;
        $post_id = get_the_ID();
        $old_terms = get_the_terms($post_id, 'category');
        $old_terms_display = '';
        $new_terms_display = '';
        $old_author = array();
        $cover_image = array(0, 0);
        $hashtag_match = array();
        $hashtag = '';
        $cislo_featured_image = '';
        $vizual_match = array();
        $vizual = '';
        $old_author_ID = $post->post_author;
        $old_author = get_userdata($old_author_ID);
        $old_author_display_name = $old_author->data->display_name;
        /** explode authors with multiple people into separate entries
         * výnimky:
         * Študentstvo a absolventstvo VŠVU a VŠMU
         * Martin Šurkala a kol.
         */
        if ($old_author_display_name == 'Martin Šurkala a kol.' || $old_author_display_name == 'Študentstvo a absolventstvo VŠVU a VŠMU') {
            $old_author_display_name_exploded = array($old_author_display_name);
        } else {
            $old_author_display_name_exploded = preg_split('/(\sa\s|,\s|\s\&\s)/', $old_author_display_name);
        }
        $new_authors = array();
        foreach ($old_author_display_name_exploded as $key => $author) {
            //$new_author = $new_author . $author . ' | ';
            //exists in DB test:
            //args: https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
            $existing_term = get_terms(
                array(
                    'taxonomy'          => 'autorstvo',
                    'fields'             => 'all',
                    'hide_empty'        => false,
                    'name'              => $author
                   
                )
            );
            if (sizeof($existing_term) > 0) {
                $new_author = "";
                $new_author = $existing_term[0]->term_id;
                //var_dump($existing_term);
            } else {
                $new_author = array();
                if (sizeof($old_author_display_name_exploded) > 1) {
                    $author_exploded = preg_split('/\s/', $author, 2);
                    //this might mismatch, but does not matter for front end, as the display name should be correct
                    if (sizeof($author_exploded) > 1) {
                        $new_author["first_name"] = $author_exploded[0];
                        $new_author["last_name"] = $author_exploded[1];
                    } else {
                        $new_author["first_name"] = "";
                        $new_author["last_name"] = $author_exploded[0];
                    }
                    $new_author["full_name"] = $author;
                    $new_author["slug"] = sanitize_title(preg_replace('/\s/', '', $author));
                } else {
                    $new_author = array();
                    $new_author["slug"] = $old_author->data->user_nicename;
                    $new_author["full_name"] = $author;
                    $new_author["first_name"] = get_user_meta($old_author->data->ID, 'first_name', true);
                    $new_author["last_name"] = get_user_meta($old_author->data->ID, 'last_name', true);
                    if ($new_author["last_name"] == '') {
                        if ($new_author["first_name"] !== '') {
                            $new_author["last_name"] = $new_author["first_name"];
                            $new_author["first_name"] = '';
                        } else {
                            $new_author["last_name"] = $new_author["full_name"];
                            $new_author["first_name"] = '';
                        }
                    }
                }
                //var_dump($new_author);
            }
            array_push($new_authors, $new_author);
        }


        foreach ($old_terms as $old_term) {
            //echo $old_term->slug . '<br>';
            if (str_starts_with($old_term->slug, '20')) {
                //echo 'trueeee<br>';
                $old_terms_display .= $old_term->name . ', ';
                $new_terms_display .= $old_term->slug . ' (číslo), ';
                $cislo_page = get_page_by_path($old_term->slug);
                if (!$cislo_page) {
                    $cislo_page = get_page_by_path('archiv/' . $old_term->slug, OBJECT, 'page');
                    if (!$cislo_page) {
                        $cislo_page = get_page_by_path('aktualne-cislo', OBJECT, 'page');
                    }
                }
                $cislo_featured_image = get_post_thumbnail_id($cislo_page->ID);
                $vizual_match_string = '/\[bt_bb_text[^\]]*\][\s]*(<h2.*)\[\/bt_bb_text\]/s';
                $hashtag_match_string = '/(>|headline=\")(#[^0-9]{1,2}[^<\s\"]*)/';
                $cover_match_string = '/' . preg_quote('[bt_bb_image image="') . '([0-9]*)"/';
                //echo $hashtag_match_string . '<br>';
                if (!preg_match($cover_match_string, $cislo_page->post_content, $cover_image)) {
                    $cover_image = array();
                };
                if (!preg_match($hashtag_match_string, $cislo_page->post_content, $hashtag_match)) {
                    $hashtag = '';
                } else {
                    $hashtag = $hashtag_match[2];
                }
                if (!preg_match_all($vizual_match_string, $cislo_page->post_content, $vizual_match)) {
                    $vizual = '';
                } else {
                    $vizual = $vizual_match[1][0];
                    //$vizual = $cislo_page->post_content;
                };
                if ($old_term->slug == $prev_cislo_slug) {
                    $vizual = '--||--';
                }
                if ($old_term->slug == '2020-04-dystopie') {
                    $hashtag = '#0800212212';
                }
                $prev_cislo_slug = $old_term->slug;
            } else {
                $old_terms_display .= $old_term->slug . ', ';
                $json_key = null;
                $json_keys = array();
                $json_keys = array_keys(array_column($remap_json, 'ogslug'), $old_term->slug);
                //echo '<br>////old_slug ';
                //echo ' ' . get_the_title($post_id) . ' ';
                foreach ($json_keys as $key) {
                    if ($remap_json[$key]['ogslug'] == $old_term->slug) {
                        $json_key = $key;
                    }
                }
                //echo '////';
                $new_terms_display .= $remap_json[$json_key]['newslug'] . ' (' . $remap_json[$json_key]['newcategorytypeslug'] . '), ';
            }
        }
        echo '<tr><td>' . $i  . '</td><td>' . get_the_title() . '</td><td>' . var_export($new_authors, true) . '</td><td>' . $old_terms_display . '<td>' . $new_terms_display . '</td><td class="thumb_image">' . wp_get_attachment_image($cislo_featured_image, 'medium') . '</td><td class="thumb_image">' . wp_get_attachment_image($cover_image[1], 'thumbnail') . '</td><td>' . $hashtag . '</td><td class="vizual-column">' . $vizual . '</td></tr>';
        $i++;
    }
    echo '</table>
    <style>.thumb_image img{max-width: 70px; max-height: 70px; object-fit: contain; } .vizual-column{max-width: 300px;} .all_posts td{vertical-align:top;}</style>';
    wp_reset_postdata();
}

add_action('admin_menu', 'kapital_custom_menu_import', 0);

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

add_action('admin_menu', 'kapital_custom_menu_import_real', 0);

function kapital_custom_import()
{

    $old_terms_to_delete = array();
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'after'  => [
            'year'  => 2024,
            'month' => 11,
            'day'   => 22,
        ],
    );
    $query = new WP_Query($args);
    $json_file_path = get_theme_file_path('/includes/remap_terms.json');
    $remap_json = json_decode(file_get_contents($json_file_path), true);
    //$available_taxonomies = get_taxonomies(array(), 'names');
    //remove save author actions as it gets values from inputs, that are non existent here
    remove_action('created_autorstvo', 'author_save_term_fields');
    remove_action('edited_autorstvo', 'author_save_term_fields');
    $more_exceptions = array(
        array('old_author' => 'Kristína Országhová David Koronczi', 'new_authors' => array('Kristína Országhová', 'David Koronczi')),
        array('old_author' => 'Tomáš Hučko Lukáš Likavčan', 'new_authors' => array('Tomáš Hučko', 'Lukáš Likavčan')),
        array('old_author' => 'Matej Sotník Kristína Országhová', 'new_authors' => array('Matej Sotník', 'Kristína Országhová')),
        array('old_author' => 'Tomáš Hučko Michaela Pašteková', 'new_authors' => array('Tomáš Hučko', 'Michaela Hučko Pašteková')),
        array('old_author' => 'Kristína Országhová Lukáš Likavčan', 'new_authors' => array('Kristína Országhová', 'Lukáš Likavčan')),
        array('old_author' => 'Tomáš Hučko Lukáš Likavčan Kristína Országhová Dávid Koronczi', 'new_authors' => array('Tomáš Hučko', 'Lukáš Likavčan', 'Kristína Országhová', 'Dávid Koronczi')),
        array('old_author' => 'Tomáš Hučko Barbora Bírová', 'new_authors' => array('Tomáš Hučko', 'Barbora Bírová')),
        array('old_author' => 'Táňa Sedláková Michaela Pašteková Tomáš Hučko', 'new_authors' => array('Táňa Sedláková', 'Michaela Hučko Pašteková', 'Tomáš Hučko')),
    );
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $old_terms = get_the_terms($post_id, 'category');

        ///authors
        global $post;
        $old_author_ID = $post->post_author;
        $old_author = get_userdata($old_author_ID);
        $old_author_display_name = $old_author->data->display_name;

        /** explode authors with multiple people into separate entries
         * exceptions:
         * Študentstvo a absolventstvo VŠVU a VŠMU
         * Martin Šurkala a kol.
         * more exceptions - multiple author separated only by whitespace:
         * SELECT * FROM `nrkxtj_users` WHERE `display_name` REGEXP '[^\\,\\s]*\\s[^,a\\s]*\\s[^,\\s]*\\s.*';
         * Kristína Országhová David Koronczi
         * Tomáš Hučko Lukáš Likavčan
         * Matej Sotník Kristína Országhová
         * Matej Sotník Michael Papcun
         * Tomáš Hučko Michaela Pašteková
         * Kristína Országhová Lukáš Likavčan
         * Tomáš Hučko Lukáš Likavčan Kristína Országhová Dávid Koronczi
         * Tomáš Hučko Barbora Bírová
         * Táňa Sedláková Michaela Pašteková Tomáš Hučko
         * Rozpustilý*í: Káťa Kortus a Ela Plíhalová //let it be... no simple solution
         * */
        $exceptions_key = array_search($old_author_display_name, array_column($more_exceptions, 'old_author'));

        if ($old_author_display_name == 'Martin Šurkala a kol.' || $old_author_display_name == 'Študentstvo a absolventstvo VŠVU a VŠMU') {
            $old_author_display_name_exploded = array($old_author_display_name);
        } elseif ($exceptions_key) {
            $old_author_display_name_exploded = $more_exceptions[$exceptions_key]['new_authors'];
        } else {
            $old_author_display_name_exploded = preg_split('/(\sa\s|,\s|\s\&\s|\s\&amp;\s)/', $old_author_display_name);
        }
        $new_authors = array();
        foreach ($old_author_display_name_exploded as $key => $author) {
            //exception Michaela Hučko Pašteková - in split occurs as Michaela Pašteková
            if ($author === 'Michaela Pašteková') {
                $author = 'Michaela Hučko Pašteková';
            }
            //exists in DB test:
            //args: https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
            $existing_term = get_terms(
                array(
                    'taxonomy'          => 'autorstvo',
                    'fields'             => 'all',
                    'hide_empty'        => false,
                    'name'              => $author
                )
            );
            //if exists in
            if (sizeof($existing_term) > 0) {
                $new_author = "";
                $new_author_id = $existing_term[0]->term_id;
                wp_set_object_terms($post_id, $new_author_id, 'autorstvo', true);
                //var_dump($existing_term);
            } else {
                $new_author = array();
                if (sizeof($old_author_display_name_exploded) > 1) {
                    $author_exploded = preg_split('/\s/', $author, 2);
                    //this might mismatch, but does not matter for front end, as the display name should be correct
                    if (sizeof($author_exploded) > 1) {
                        $new_author["first_name"] = $author_exploded[0];
                        $new_author["last_name"] = $author_exploded[1];
                    } else {
                        $new_author["first_name"] = "";
                        $new_author["last_name"] = $author_exploded[0];
                    }
                    $new_author["full_name"] = $author;
                    $new_author["slug"] = sanitize_title(preg_replace('/\s/', '', $author));
                } else {
                    $new_author = array();
                    $new_author["slug"] = $old_author->data->user_nicename;
                    $new_author["full_name"] = $author;
                    $new_author["first_name"] = get_user_meta($old_author->data->ID, 'first_name', true);
                    $new_author["last_name"] = get_user_meta($old_author->data->ID, 'last_name', true);

                    /** last_name is needed for custom term
                     * some users did not have it
                     * */
                    if ($new_author["last_name"] == '') {
                        if ($new_author["first_name"] !== '') {
                            $new_author["last_name"] = $new_author["first_name"];
                            $new_author["first_name"] = '';
                        } else {
                            $new_author["last_name"] = $new_author["full_name"];
                            $new_author["first_name"] = '';
                        }
                    }
                }
                /** NO!!! Full name used for sorting purposes
                 * but we need to also pass last_name as argument, as saving involves a filter
                 * see autorstvo_insert_term() in author_taxonomy_functions.php
                 * */
                var_dump($new_author);
                $new_term = wp_insert_term($new_author["full_name"], 'autorstvo', array(
                    'slug' => $new_author["slug"]
                ));
                var_dump($new_term);
                $new_term_id = $new_term['term_id'];
                wp_set_object_terms($post_id, $new_term_id, 'autorstvo', true);
                update_term_meta($new_term_id, '_author_first_name',$new_author["first_name"]); //first and last name saved as object for one query
                update_term_meta($new_term_id, '_author_last_name', $new_author["last_name"]); //last name saved as separate key to allow meta query
            }
        }
        foreach ($old_terms as $old_term) {
            $old_term_id = $old_term->term_id;
            //var_dump($old_term_id);
            $old_term_slug = $old_term->slug;
            $old_term_name = $old_term->name;
            //CISLO
            if (str_starts_with($old_term_slug, '20')) {
                cislo_remap_cat($old_term_slug, $old_term_id, $old_term_name, $post_id);
                if (!in_array($old_term_id, $old_terms_to_delete)) {
                    array_push($old_terms_to_delete, $old_term_id);
                }
                //!CISLO
            } else {
                $json_key = null;
                $json_keys = array_keys(array_column($remap_json, 'ogslug'), $old_term->slug);
                foreach ($json_keys as $key) {
                    if ($remap_json[$key]['ogslug'] === $old_term->slug) {
                        $json_key = $key;
                    }
                }
                if (isset($remap_json[$json_key]['newposttypeslug'])) {
                    //PODCAST
                    if ($remap_json[$json_key]['newposttypeslug'] == 'podcast') {
                        /* default importer assigns 'filmovy' to 'filmovy-2' so we need to filter it.
                       * all that have "ogparentcategory" : "kapitalx" should be podcasts
                       */

                        remap_podcast($old_term_slug, $old_term_id, $old_term_name, $post_id);
                        if (!in_array($old_term_id, $old_terms_to_delete)) {
                            array_push($old_terms_to_delete, $old_term_id);
                        }
                        //remove authors from posts that should be podcast
                        wp_set_object_terms($post_id, array(), 'autorstvo', true);

                        //REDAKCIA
                    } elseif ($remap_json[$json_key]['newposttypeslug'] == 'redakcia') {
                        remap_redakcia($old_term_slug, $old_term_id, $old_term_name, $post_id);
                        if (!in_array($old_term_id, $old_terms_to_delete)) {
                            array_push($old_terms_to_delete, $old_term_id);
                        }
                        //POST
                    } elseif ($remap_json[$json_key]['newposttypeslug'] == 'post') {
                        remap_other_cats($post_id, $remap_json[$json_key]);
                        if (!in_array($old_term_id, $old_terms_to_delete)) {
                            array_push($old_terms_to_delete, $old_term_id);
                        }
                    }
                    //IF no post type defined - POST
                } else {
                    if (isset($json_key)) {
                        remap_other_cats($post_id, $remap_json[$json_key]);
                    }
                }
            }
        }
    }
    foreach ($old_terms_to_delete as $old_term) {
        wp_delete_term($old_term, 'category');
    }

    wp_reset_postdata();
}

function cislo_remap_cat($old_term_slug, $old_term_id, $old_term_name, $post_id)
{
    //get ACF fields IDs 
    $hashtag = '';
    $vizual = '';
    $cover_image = null;
    $cislo_featured_image = null;
    $cislo_page = get_page_by_path($old_term_slug);
    if (!$cislo_page) {
        $cislo_page = get_page_by_path('archiv/' . $old_term_slug, OBJECT, 'page');
        if (!$cislo_page) {
            $cislo_page = get_page_by_path('aktualne-cislo', OBJECT, 'page');
        }
    }
    $cislo_featured_image = get_post_thumbnail_id($cislo_page->ID);
    $vizual_match_string = '/\[bt_bb_text[^\]]*\][\s]*(<h2.*)\[\/bt_bb_text\]/s';
    $hashtag_match_string = '/(>|headline=\")(#[^0-9]{1,2}[^<\s\"]*)/';
    $cover_match_string = '/' . preg_quote('[bt_bb_image image="') . '([0-9]*)"/';
    if (!preg_match($cover_match_string, $cislo_page->post_content, $cover_image)) {
        $cover_image = array();
    };
    if (!preg_match($hashtag_match_string, $cislo_page->post_content, $hashtag_match)) {
        $hashtag = '';
    } else {
        $hashtag = $hashtag_match[2];
    }
    if (!preg_match_all($vizual_match_string, $cislo_page->post_content, $vizual_match)) {
        $vizual = '';
    } else {
        $vizual = $vizual_match[1][0];
    };
    if ($old_term_slug == '2020-04-dystopie') {
        $hashtag = '#0800212212';
    }
    if (!term_exists($old_term_slug, 'cislo')) {
        $new_term = wp_insert_term($old_term_name, 'cislo', array('slug' => $old_term_slug));
        $new_term_id = $new_term['term_id'];
        if (isset($hashtag) && !empty($hashtag)) {
            update_field('hashtag', $hashtag, 'cislo_' . (string)$new_term_id);
        }
        if (isset($vizual) && !empty($vizual)) {
            update_field('ending_text', $vizual,  'cislo_' . (string)$new_term_id);
        }
        if (isset($cislo_featured_image) && !empty($cislo_featured_image)) {
            update_field('featured_image', get_post($cislo_featured_image),  'cislo_' . (string)$new_term_id);
        }
        if (isset($cover_image[1]) && !empty($cover_image[1])) {
            update_field('cover', get_post($cover_image[1]),  'cislo_' . (string)$new_term_id);
        }
        wp_set_object_terms($post_id, $old_term_slug, 'cislo', true);
    } else {
        wp_set_object_terms($post_id, $old_term_slug, 'cislo', true);
    }
}

function remap_podcast($old_term_slug, $old_term_id, $old_term_name, $post_id)
{

    if (get_post_type($post_id) != 'podcast') {
        set_post_type($post_id, 'podcast');
    }
    if ($old_term_slug !== 'kapitalx') {
        if (!term_exists($old_term_slug, 'podcast-seria')) {
            $new_term = wp_insert_term($old_term_name, 'podcast-seria', array('slug' => $old_term_slug));
            $new_term_id = $new_term['term_id'];
            wp_set_object_terms($post_id, $new_term_id, 'podcast-seria', true);
            //set featured image for podcast séria as the current post thumbnail
            update_field('featured_image', get_post(get_post_thumbnail_id($post_id)), 'podcast-seria_' . (string)$new_term_id);
        } else {
            wp_set_object_terms($post_id, $old_term_slug, 'podcast-seria', true);
        }
    }
}
function remap_redakcia($old_term_slug, $old_term_id, $old_term_name, $post_id)
{
    if (get_post_type($post_id) !== 'redakcia') {
        set_post_type($post_id, 'redakcia');
    }
    if (!term_exists($old_term_slug, 'redakcia-tag')) {
        $new_term = wp_insert_term($old_term_name, 'redakcia-tag', array('slug' => $old_term_slug));
        $new_term_id = $new_term['term_id'];
        wp_set_object_terms($post_id, $new_term_id, 'redakcia-tag', true);
    } else {
        wp_set_object_terms($post_id, $old_term_slug, 'redakcia-tag', true);
    }
}
function remap_other_cats($post_id, $remap_array)
{
    $current_term_taxonomy = '';
    if (isset($remap_array['newcategorytypeslug'])) {
        switch ($remap_array['newcategorytypeslug']) {
            case 'rubriky':
                $current_term_taxonomy = 'rubrika';
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
                $current_term_taxonomy = "rubrika";
                break;
            case 'partneri':
                $current_term_taxonomy = "partner";
                break;
        }
    }
    if (isset($remap_array['newslug']) && $current_term_taxonomy !== '') {
        if (!term_exists($remap_array['newslug'], $current_term_taxonomy)) {
            $term_args = array('slug' => $remap_array['newslug']);
            if (isset($remap_array["newparentcategoryslug"]) && $remap_array["newparentcategoryslug"] !== '') {
                if (!term_exists($remap_array["newparentcategoryslug"], $current_term_taxonomy)) {
                    $parent_term = wp_insert_term($remap_array["newparentcategory"], $current_term_taxonomy, array('slug' => $remap_array['newparentcategoryslug']));
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
        } elseif ($current_term_taxonomy !== '') {
            wp_set_object_terms($post_id, $remap_array['newslug'], $current_term_taxonomy, true);
        }
    }
}
