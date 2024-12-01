<?php

/** 
 * Collection of various functions for rendering front end content
 */

/** Rendering any string wrapped in spans with correct classes for "bubble heading"
 * @param string $string              String to be displayed in bubble 
 * @param int $heading_level          1-6 for h1-h6.
 *                                    Defaults to 2.
 *                                    0 or any other number results in div instead of heading
 * @param string $additional_classes  pass classes as string with spaces to wrapper/heading tag  
 * @return string                       html elements for heading with children spans, if $string is empty, returns empty string
 */
function kapital_bubble_title(string $string, int $heading_level = 2, string $additional_classes = '')
{
    if (!empty($string)) {
        //add space before classes
        if ($additional_classes !== '') {
            $additional_classes = ' ' . $additional_classes;
        }
        //check if is heading (int 1-6)
        if (is_int($heading_level) && $heading_level > 0 && $heading_level < 7): $is_heading = true;
        else: $is_heading = false;
        endif;
        $output = '';
        $exploded_string = explode(" ", $string);

        //wrapper / heading tag start
        if ($is_heading): $output .= '<h' . $heading_level . ' class="bubble-heading' . $additional_classes . '">';
        else: $output .= '<div class="bubble-heading' . $additional_classes . '">';
        endif;
        $last_key = count($exploded_string);
        foreach ($exploded_string as $key => $span_content) {
            if ($key === $last_key - 1){
                $output .= '<span>' . $span_content . '</span>';
            } else {
                $output .= '<span>' . $span_content . ' </span>';
            }
        }

        //wrapper / heading tag start
        if ($is_heading): $output .= '</h' . $heading_level . '>';
        else: $output .= '</div>';
        endif;
        return ($output);
    } else {
        return ('');
    }
}
/** alternative for wp_get_attachment_image with placeholder image 
 * @param int       $attachment_id 
 * @param string    $sizes sizes attribute for img element
 * @param bool      $figure_and_caption whether to wrap the image in figure tag and display caption
 * @param string    $img_classes for img element separated by space
 * @param string    $figure_classes classes for figure element separated by space
 * @param string    $alt_text custom alt text
 * @return string   HTML figure with img element with caption or empty string on failure
 */
function kapital_responsive_image(int $attachment_id, string $sizes = "", bool $figure_and_caption = true, string $img_classes = '', string $figure_classes = '', string $alt_text = "")
{
    $attachment = get_post($attachment_id);
    if ($attachment && !is_null($attachment)) {
        $image_sizes = get_intermediate_image_sizes($attachment_id);
        $image_sizes = $image_sizes;
        //also include full size image
        $image_sizes[] = "full";
        $caption = $attachment->post_excerpt;
        if ($alt_text === "") {
            $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
        }
        $srcset = "";
        foreach ($image_sizes as $image_size) {
            if ($image_size !== 'placeholder') {

                //returns array of values for specific image size
                // https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
                $src = wp_get_attachment_image_src($attachment_id, $image_size);
                if ($srcset !== '') {
                    $srcset .= ', ';
                }
                $srcset .= $src[0] . ' ' . $src[1] . 'w';
                //calculate aspect ratio for placeholder
                if ($image_size === "full") {
                    $aspect_ratio = $src[1] / $src[2];
                    //save full size to custom variable to be used as fallback
                    $full_size_img_url = $src[0];
                }
            }
        }
        $html = "";
        if ($figure_and_caption) {
            $html .= '<figure class="' . $figure_classes . '">';
        }
        $html .= '<img srcset="' . $srcset . '"';
        $html .= ' class="' . $img_classes . '"';
        $html .= ' style="background-image: url(\'' .  wp_get_attachment_image_src($attachment_id, 'placeholder')[0] . '\'); aspect-ratio:' . $aspect_ratio . '"';
        $html .= ' src="' . $full_size_img_url . '"';
        $html .= ' sizes="' . $sizes . '"';
        $html .= ' loading="lazy"';
        $html .= ' alt="' . $alt_text . '"';
        $html .= '/>';
        if ($figure_and_caption) {
            if ($caption !== "") {
                $html .= '<figcaption class="fs-small alignnormal mt-1 ff-sans text-gray text-center">' . $caption . '</figcaption>';
            }
            $html .= '</figure>';
        }
        return $html;
    } else {
        return '';
    }
}

function kapital_get_koko_stats($post_id){
    $cache_key = 'kptl_ka_counter_' . $post_id;
    $count = get_transient($cache_key);
    if (!$count){
        global $wpdb;
        $table = $wpdb->prefix . 'koko_analytics_post_stats ';
        $sql = $wpdb->prepare("
                    SELECT COALESCE(SUM(pageviews), 0) AS pageviews
                    FROM {$table}
                    WHERE `id` = %s
        ", $post_id);
        $result = $wpdb->get_row($sql);
        $count = $result->pageviews;
        if(!isset($count)){
            $count = 1;
        }
        set_transient('kptl_ka_counter_' . $post_id, $count, 120);
    }
    return $count;
}

function kapital_support()
{
    $text = "Iba vďaka vašej pomoci môžeme prinášať nezávislý a ľavicový obsah pre všetkx zdarma";
    return '<div class="rounded-pill fw-bold h4 my-6 ff-grotesk alignwide bg-primary py-4 px-5">' . '<div class="row justify-content-between gx-4 align-items-center"><div class="col">' . $text . '</div><div class="col-auto"><a class="btn bg-white">Podporte nás</button></a></div></div></div>';
}
/**
 * Render breadcrumbs
 * @param array   $breadcrumbs array containing arrays [string text, string url, bool active]  
 * @param string    $additional_classes additional classes separated by space
 * @return string   HTML markup of breadcrumbs
 */
function kapital_breadcrumbs(array $breadcrumbs, string $additional_classes ="")
{
    $html = '<nav aria-label="breadcrumb navigácia" class="my-2 ff-grotesk breadcrumb-nav ' . $additional_classes . '"><ol class="breadcrumb">';
    $html .= '<li class="breadcrumb-item"><a href="' . get_home_url() . '">' . __("Domov", "kapital") . '</a></li>';
    foreach ($breadcrumbs as $breadcrumb) {
        $active = false;
        //check if active is true
        if (isset($breadcrumb[2])) if ($breadcrumb[2]) $active = true;
        //active breadcrumb should not have link
        if (isset($breadcrumb[1]) && !$active) {
            $html .= '<li class="breadcrumb-item"><a href="' . $breadcrumb[1] . '">' .  $breadcrumb[0] . '</a></li>';
        } elseif ($active) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' .  $breadcrumb[0] . '</li>';
        }
    }
    $html .= '</ol></nav>';
    return $html;
}

/**
 * Reorganize the terms for easier rendering
 * @param int $post_id id of post for which to retrieve terms, null to retrieve all
 * @param array $taxonomies taxonomies for which to retrieve terms
 * @return array terms organized by taxonomy (taxonomy as key) or empty array if post has no terms
 */
function get_and_reorganize_terms($post_id,  $taxonomies, $term_id_to_remove = null)
{   if (is_null($post_id)){
        $post_terms = get_terms(array(
            'taxonomy' => $taxonomies,
        ));
    } else {
        $post_terms = wp_get_post_terms($post_id, $taxonomies);
    }
    if (!empty($post_terms)){
        $filtered_terms = [];
        foreach ($taxonomies as $taxonomy) {
            $filtered_terms[$taxonomy] = [];
        }
        foreach ($post_terms as $post_term) {
            if ($term_id_to_remove !== $post_term->term_id){
                array_push($filtered_terms[$post_term->taxonomy], $post_term);
            }
        }
        return $filtered_terms;
    } else {
        return array();
    }
}

function kapital_pagination( $args = array() ) {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages > 1 ) {

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $url_parts    = explode( '?', $pagenum_link );

        // Get max pages and current page out of the current query, if available.
        $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
        $current = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

        // URL base depends on permalink settings.
        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        $page_links = array();

        //number of page links to both sides of the current page
        $max_page_links = 5;
        if($current === 1){
            $end_size = 4;
            $start_size = 0;
        } elseif($current === $total) {
            $end_size = 0;
            $start_size = 4;
        } else{
            $end_size = 2;
            $start_size = 2;
        }


        // first page link
        if ($current > 2):
            $link = str_replace( '%_%', $format, $pagenum_link );
            $link = str_replace( '%#%', 1, $link );
            $page_links[] = sprintf(
                '<a class="first page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-first"></use></svg></a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url($link), __('Prvá strana', 'kapital'));
        endif;

        //previous page link
        if ($current && 1 < $current):
            $link = str_replace( '%_%', 2 == $current ? '' : $format, $pagenum_link );
            $link = str_replace( '%#%', $current - 1, $link );
            $page_links[] = sprintf(
                '<a class="prev page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-prev"></use></svg></a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url($link), __('Predchádzajúca strana', 'kapital'));
        endif;

        //show current + mid size
        for ( $n = 1; $n <= $total; $n++ ) :
            if ( $n == $current ) :
                $page_links[] = sprintf(
                    '<div aria-current="%s" class="page-numbers current bg-primary rounded-pill d-inline-block mx-1">%s</div>',
                    esc_attr( __('Aktuálna strana', 'kapital') ), number_format_i18n( $n )
                );
    
                $dots = true;
            else :
                if ( $current && $n >= $current - $start_size && $n <= $current + $end_size ) :
                    $link = str_replace( '%_%', 1 == $n ? '' : $format, $pagenum_link );
                    $link = str_replace( '%#%', $n, $link );

                    $page_links[] = sprintf(
                        '<a class="page-numbers bg-secondary rounded-pill text-decoration-none d-inline-block mx-1" href="%s">%s</a>',
                        /** This filter is documented in wp-includes/general-template.php */
                        esc_url( apply_filters( 'paginate_links', $link ) ),
                        number_format_i18n( $n )
                    );
                endif;
            endif;
        endfor;

        //next link
        if ( $current && $current < $total) :
            $link = str_replace( '%_%', $format, $pagenum_link );
            $link = str_replace( '%#%', $current + 1, $link );
   
            $page_links[] = sprintf(
                '<a class="next page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-next"></use></svg></a>',
                /** This filter is documented in wp-includes/general-template.php */
                esc_url( $link ), __('Nasledujúca strana', 'kapital')
            );
        endif;

        // last page link
        if ($current < $total - 1):
            $link = str_replace( '%_%', $format, $pagenum_link );
            $link = str_replace( '%#%', $total, $link );
            $page_links[] = sprintf(
                '<a class="last page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-last"></use></svg></a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url($link), __('Prvá strana', 'kapital'));
        endif;

        // Make sure the nav element has an aria-label attribute: fallback to the screen reader text.
        //py-1 just to not cut the focus outline, dunno wtf
        $html = '<nav class="pagination py-1 d-flex mt-4 ff-sans justify-content-center" aria_label="' . __('Stránkovanie archívu', 'kapital') . '">';
        $html .= implode( "\n", $page_links );
        $html .= '</nav>';
        return $html;
	}
}

/**
 * Function which formats issue title
 * All cisla (issues) begin with 'YYYY MM', to be sure include 'YYYY M'
 * @param string $original_title original title in "YYYY MM Title" format
 * @param bool $show_year whether to include year in formatted title
 * @return array array with two values [0] => formatted title, [1] => year and month for use above title
 */

function kapital_get_issue_title_year_month(string $original_archive_title, bool $show_year = true){
    $date = array();
    $above_title = "";
    $archive_title = "";
    preg_match('/[0-9]{4}\s[0-9]{1,2}/', $original_archive_title, $date);
    if (count($date) === 1){
        global $kapital_svk_months;
        $above_title = $date[0];
        $above_title = explode(" ", $above_title);
        $above_title = $show_year ? $kapital_svk_months[(int)$above_title[1] - 1] . ' ' . $above_title[0] : $kapital_svk_months[(int)$above_title[1] - 1];
        $archive_title = trim(str_replace($date, '', $original_archive_title));
    } else {
        $archive_title = $original_archive_title;
    }
    return array($archive_title, $above_title);
}

/**
 * Sets the query to all for taxonomy "číslo" (issue)
 * Sets the query to 24 for all other main queries
 * @param WP_Query $query
 */
function kapital_post_query_mod($query)
{
    if ($query->is_main_query()) {
        if ($query->is_home() || $query->is_archive()) {
            if ($query->is_tax('cislo')) {
                $query->set('posts_per_page', -1);
            } else {
                $query->set('posts_per_page', 24);
            }
        }
    }
}
add_action('pre_get_posts', 'kapital_post_query_mod', 1);

/**
 * Custom excerpt trim filter
 * @param $excerpt post excerpt
 * @param $excerpt_word_count   minimum number of words
 */
function kapital_wp_trim_excerpt($excerpt, $excerpt_word_count = 13)
{
    $raw_excerpt = $excerpt;
    if ('' == $excerpt) {
        $excerpt = get_the_content('');
    }
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = apply_filters('the_content', $excerpt);
    $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
    $excerpt = strip_tags($excerpt, ['<p>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>']); /*IF you need to allow just certain tags. Delete if all tags are allowed */
    $excerpt = str_replace(['h1>', 'h2>', 'h3>', 'h4>', 'h5>', 'h6>'], 'p>', $excerpt);
    $excerpt = str_replace(['<h1', '<h2', '<h3', '<h4', '<h5', '<h6'], '<p', $excerpt);
    $excerpt=preg_replace('/class=".*?"/', '', $excerpt); //fix excerpt classes - first paragraph is perex

    //Set the excerpt word count and only break after sentence is complete.
    $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
    $tokens = array();
    $excerptOutput = '';
    $count = 0;

    // Divide the string into tokens; HTML tags, or words, followed by any whitespace
    preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

    foreach ($tokens[0] as $key => $token) {
        if ($count >= $excerpt_length && (preg_match('/[\,\;\?\.\!]\s*$/uS', $token) || $key > 40)) {
            // Limit reached, continue until , ; ? . or ! occur at the end
            $excerptOutput .= trim($token, " \n\r\t\v\x00,.?!") . '...';
            break;
        }

        // Add words to complete sentence
        $count++;

        // Append what's left of the token
        $excerptOutput .= $token;
    }

    $excerpt = trim(force_balance_tags($excerptOutput));

    return $excerpt;

    return apply_filters('kapital_wp_trim_excerpt', $excerpt, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'kapital_wp_trim_excerpt');

/** change pagination base */
function kapital_custom_pagination_base() {
    global $wp_rewrite;
    $wp_rewrite->pagination_base = 'strana'; //where new-slug is the slug you want to use 
}

//priority needs to be lower than the priority of custom post type registration
add_action('init', 'kapital_custom_pagination_base', 0);

/** simple function to get default rendering settings, if not set by meta
 * @param integer $post_id
 * @return array 
 */
function kapital_get_render_settings($post_id){
    
$render_settings = get_post_meta($post_id, '_kapital_post_render_settings', true);
    $default_render_settings = array(
        'show_featured_image' => true,
        'show_title' => true,
        'show_author' => true,
        'show_categories' => true,
        'show_views' => true,
        'show_date' => true,
        'show_ads'  => true,
        'show_support' => true,
        'show_footer' => true,
    );
    //var_dump($default_render_settings);
    if(is_array($render_settings)){
        $render_settings = array_merge($default_render_settings, $render_settings);
    } else {
        $render_settings = $default_render_settings;
    }
    return $render_settings;
}