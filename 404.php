<?php get_header();
    $url_path = $current_url = $wp->request;;
    var_dump($url_path);
    $taxonomies_with_list_pages = ['partneri', 'cisla', 'serie', 'rubriky', 'podcast-serie'];
    var_dump(in_array($url_path, $taxonomies_with_list_pages));

    if ( in_array($url_path, $taxonomies_with_list_pages)) {
       // load the file if exists
       $load = locate_template('list-terms.php', true);
       if ($load) {
          exit(); // just exit if template was found and loaded
       }
    }
get_footer();
