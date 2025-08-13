<?php

/** 
 * Collection of various functions for rendering front end content
 */

/** Rendering any string wrapped in spans with correct classes for "bubble heading"
 * @param string $string              String to be displayed in bubble 
 * @param int $heading_level          1-6 for h1-h6.
 *                                    Defaults to 2.
 *                                    0 or any other number results in paragraph instead of heading
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
        else: $output .= '<p class="bubble-heading' . $additional_classes . '">';
        endif;
        $last_key = count($exploded_string);
        foreach ($exploded_string as $key => $span_content) {
            if ($key === $last_key - 1) {
                $output .= '<span>' . $span_content . '</span>';
            } else {
                $output .= '<span>' . $span_content . ' </span>';
            }
        }

        //wrapper / heading tag start
        if ($is_heading): $output .= '</h' . $heading_level . '>';
        else: $output .= '</p>';
        endif;
        return ($output);
    } else {
        return ('');
    }
}



function kapital_bubble_paragraphs($blocks)
{
    foreach ($blocks as $block) {
        if (! empty($block['innerBlocks'])) {
            kapital_bubble_paragraphs($block['innerBlocks']);
        } elseif ('core/paragraph' === $block['blockName']) {
            echo kapital_bubble_title(strip_tags($block["innerHTML"]), 0, "ff-grotesk bubble-paragraph alignwider");
        } else {
            echo apply_filters('the_content', render_block($block));
        }
    }
}
/** alternative for wp_get_attachment_image with placeholder image 
 * @param mixed     $attachment_id expects int, will return empty string otherwise
 * @param string    $sizes sizes attribute for img element
 * @param bool      $figure_and_caption whether to wrap the image in figure tag and display caption
 * @param string    $img_classes for img element separated by space
 * @param string    $figure_classes classes for figure element separated by space
 * @param string    $alt_text custom alt text
 * @return string   HTML figure with img element with caption or empty string on failure
 */
function kapital_responsive_image($attachment_id, string $sizes = "", bool $figure_and_caption = true, string $img_classes = '', string $figure_classes = '', string $alt_text = "")
{
    if (isset($attachment_id) && $attachment_id && is_numeric($attachment_id) && $attachment_id !== 0) {
        $attachment = get_post($attachment_id);
        $is_nonscalable = $attachment->post_mime_type === 'image/gif' ? true : false;
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
                        $aspect_ratio = (int) $src[1] / (int) $src[2];
                        //save full size to custom variable to be used as fallback
                        $full_size_img_url = $src[0];
                    }
                }
            }
            $html = "";
            if ($figure_and_caption) {
                $html .= '<figure class="' . $figure_classes . '">';
            }
            $html .= '<img';
            if (!$is_nonscalable) $html .=  ' srcset="' . $srcset . '"';
            $html .= ' class="' . $img_classes . '"';
            $html .= ' style="background-image: url(\'' .  wp_get_attachment_image_src($attachment_id, 'placeholder')[0] . '\'); aspect-ratio:' . $aspect_ratio . '"';
            $html .= ' src="' . $full_size_img_url . '"';
            if (!$is_nonscalable) $html .= ' sizes="' . $sizes . '"';
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
}

function kapital_get_koko_stats($post_id)
{
    $cache_key = 'kptl_ka_counter_' . $post_id;
    $count = get_transient($cache_key);
    if (!$count) {
        global $wpdb;
        $table = $wpdb->prefix . 'koko_analytics_post_stats ';
        $sql = $wpdb->prepare("
                    SELECT COALESCE(SUM(pageviews), 0) AS pageviews
                    FROM {$table}
                    WHERE `id` = %s
        ", $post_id);
        $result = $wpdb->get_row($sql);
        $count = $result->pageviews;
        if (!isset($count)) {
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
function kapital_breadcrumbs(array $breadcrumbs = array(), string $additional_classes = "")
{
    $html = '<nav aria-label="breadcrumb navigácia" class="mt-2 ff-grotesk breadcrumb-nav ' . $additional_classes . '"><ol class="breadcrumb">';
    $home_page_url = "";
    $is_multisite = is_multisite();
    $is_main_site = is_main_site();
    if ($is_multisite) {
        if ($is_main_site) {
            $home_page_url = get_home_url();
        } else {
            $home_page_url = get_home_url(get_main_site_id());
        }
    } else {
        $home_page_url = get_home_url();
    }
    $html .= '<li class="breadcrumb-item"><a href="' . $home_page_url . '">' . __("Domov", "kapital") . '</a></li>';
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
function get_and_reorganize_terms($post_id, $taxonomies, $term_id_to_remove = null)
{
    if (is_null($post_id)) {
        $post_terms = get_terms(array(
            'taxonomy' => $taxonomies,
        ));
    } else {
        $post_terms = wp_get_post_terms($post_id, $taxonomies);
    }
    if (!empty($post_terms)) {
        $filtered_terms = [];
        foreach ($taxonomies as $taxonomy) {
            $filtered_terms[$taxonomy] = [];
        }
        foreach ($post_terms as $post_term) {
            if ($term_id_to_remove !== $post_term->term_id) {
                array_push($filtered_terms[$post_term->taxonomy], $post_term);
            }
        }
        return $filtered_terms;
    } else {
        return array();
    }
}

function kapital_pagination($args = array())
{
    global $wp_query, $wp_rewrite;

    // Don't print empty markup if there's only one page.
    if ($wp_query->max_num_pages > 1) {

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $url_parts    = explode('?', $pagenum_link);

        // Get max pages and current page out of the current query, if available.
        $total   = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        $current = get_query_var('paged') ? (int) get_query_var('paged') : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

        // URL base depends on permalink settings.
        $format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';
        $add_args = array();
        if (isset($url_parts[1])) {
            // Find the format argument.
            $format_explode       = explode('?', str_replace('%_%', $format, $pagenum_link));
            $format_query = isset($format_explode[1]) ?  $format_explode[1] : '';
            wp_parse_str($format_query, $format_args);

            // Find the query args of the requested URL.
            wp_parse_str($url_parts[1], $url_query_args);
            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach ($format_args as $format_arg => $format_arg_value) {
                unset($url_query_args[$format_arg]);
            }
            $add_args = urlencode_deep($url_query_args);
        }

        $page_links = array();

        //number of page links to both sides of the current page
        $max_page_links = 5;
        if ($current === 1) {
            $end_size = 4;
            $start_size = 0;
        } elseif ($current === $total) {
            $end_size = 0;
            $start_size = 4;
        } else {
            $end_size = 2;
            $start_size = 2;
        }


        // first page link
        if ($current > 2):
            $link = str_replace('%_%', $format, $pagenum_link);
            $link = str_replace('%#%', 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $page_links[] = sprintf(
                '<a class="first page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-first"></use></svg></a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url($link),
                __('Prvá strana', 'kapital')
            );
        endif;

        //previous page link
        if ($current && 1 < $current):
            $link = str_replace('%_%', 2 == $current ? '' : $format, $pagenum_link);
            $link = str_replace('%#%', $current - 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $page_links[] = sprintf(
                '<a class="prev page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-prev"></use></svg></a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url($link),
                __('Predchádzajúca strana', 'kapital')
            );
        endif;

        //show current + mid size
        for ($n = 1; $n <= $total; $n++) :
            if ($n == $current) :
                $page_links[] = sprintf(
                    '<div aria-current="page" class="page-numbers current bg-primary rounded-pill d-inline-block mx-1">%s</div>',
                    number_format_i18n($n)
                );

                $dots = true;
            else :
                if ($current && $n >= $current - $start_size && $n <= $current + $end_size) :
                    $link = str_replace('%_%', 1 == $n ? '' : $format, $pagenum_link);
                    $link = str_replace('%#%', $n, $link);
                    if ($add_args) {
                        $link = add_query_arg($add_args, $link);
                    }
                    $page_links[] = sprintf(
                        '<a class="page-numbers bg-secondary rounded-pill text-decoration-none d-inline-block mx-1" href="%s">%s</a>',
                        /** This filter is documented in wp-includes/general-template.php */
                        esc_url(apply_filters('paginate_links', $link)),
                        number_format_i18n($n)
                    );
                endif;
            endif;
        endfor;

        //next link
        if ($current && $current < $total) :
            $link = str_replace('%_%', $format, $pagenum_link);
            $link = str_replace('%#%', $current + 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $page_links[] = sprintf(
                '<a class="next page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-next"></use></svg></a>',
                /** This filter is documented in wp-includes/general-template.php */
                esc_url($link),
                __('Nasledujúca strana', 'kapital')
            );
        endif;

        // last page link
        if ($current < $total - 1):
            $link = str_replace('%_%', $format, $pagenum_link);
            $link = str_replace('%#%', $total, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $page_links[] = sprintf(
                '<a class="last page-chevrons rounded-pill" href="%s"><span class="visually-hidden">%s</span><svg><use xlink:href="#icon-page-last"></use></svg></a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url($link),
                __('Prvá strana', 'kapital')
            );
        endif;

        // Make sure the nav element has an aria-label attribute: fallback to the screen reader text.
        //py-1 just to not cut the focus outline, dunno wtf
        $html = '<nav class="pagination py-1 d-flex mt-6 ff-sans justify-content-center" aria-label="' . __('Stránkovanie archívu', 'kapital') . '">';
        $html .= implode("\n", $page_links);
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

function kapital_get_issue_title_year_month(string $original_archive_title, bool $show_year = true)
{
    $date = array();
    $above_title = "";
    $archive_title = "";
    preg_match('/[0-9]{4}\s[0-9]{1,2}/', $original_archive_title, $date);
    if (count($date) === 1) {
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
 * Renders post filters
 * @param bool $is_general_post_archive if render filters for all posts
 * @param bool $is_term_archive if render child terms as filters
 * @param bool $is_page if render child pages
 * @param int $object_id id of parent term or page to render children
 * @param string $taxonomy slug of taxonomy of parent term
 * @param bool $sticky - wether to render filters as sticky with button "Filter" on mobile
 * @return string HMTL markup of filters 
 */
function kapital_post_filters(bool $is_general_post_archive = true, bool $is_term_archive = false, $is_page = false, int $object_id = 0, string $taxonomy = "", string $post_type = 'post', bool $sticky = true)
{
    if ($is_general_post_archive):
        if ($post_type === 'post') {
            $filters = get_option('kapital_post_filters');
        } elseif ($post_type === 'product') {
            $filters = get_option('kapital_product_filters');
        }
        if ($filters && !empty($filters)):
            foreach ($filters as $key => $value) {
                $filters[$key] = get_term((int) $value);
            }
        endif;

    elseif ($is_term_archive):
        $filters = get_terms(
            $taxonomy,
            array(
                'child_of' =>  $object_id,
                'orderby' => 'name'
            )
        );
    elseif ($is_page):
        $pages = get_pages(
            array(
                'child_of' =>  $object_id,
                'parent' =>  $object_id,
                'orderby' => 'title',
                'order' => 'asc'
            )
        );
        $filters = array_map(function ($page) {
            return array('name' => $page->post_title, "url" => get_the_permalink($page));
        }, $pages);
        $additional_filters = json_decode(get_post_meta($object_id, '_page_links', true));
        if ($additional_filters) {
            $additional_filters = array_map(function ($item) {
                if ($item->name !== "" && $item->url !== "") {
                    return array('name' => $item->name, 'url' => $item->url);
                }
            },  $additional_filters);

            if (!empty($additional_filters)) {
                function compareByName($a, $b)
                {
                    return strcmp($a["name"], $b["name"]);
                }
                $filters = array_merge($filters, $additional_filters);
                //sort filters alphabetically
                usort($filters, function ($a, $b) {
                    return strcmp(strtolower($a["name"]), strtolower($b["name"]));
                });
            }
        };
    else:
        $filters = array();
    endif;
    return kapital_render_filters($filters, $sticky, $is_page);
}


/**
 * Renders the HTML markup for post filters, optionally as a sticky modal with a toggle button.
 *
 * This function outputs a filter UI for posts, terms, or pages, depending on the provided $filters array.
 * It supports rendering as a sticky modal (with a toggle button for mobile), and can handle both associative arrays (with 'name', 'url' and 'class' )
 * or arrays of term objects. You can also customize the filter button text and inject additional HTML.
 *
 * @param array  $filters                    Array of filters to render. Can be associative arrays (with 'name' and 'url') or term objects.
 * @param bool   $sticky                     Whether to render filters as sticky with a toggle button (default: true).
 * @param bool   $filters_as_associative_array If true, expects $filters as associative arrays with 'name' and 'url'. If false, expects term objects. (default: true)
 * @param array $custom_button_text         Custom text for the filter toggle button array('text' => '', 'aria_label' => '') (default empty array).
 * @param string $additional_button_html     Additional HTML used for events as button "zaznamy" (recordings) next to "rok" (year)  (default: '').
 * @param bool   $indicate_active           Whether to render filter button as active
 * @return string                           HTML markup for the filters, or an empty string if no filters.
 * @todo Add 'isset' checks for filter name and link.
 */
function kapital_render_filters(array $filters, $sticky = true, $filters_as_associative_array = true, $custom_button_text = array(), bool $indicate_active = false, string $additional_button_html = '',)
{
    $html = "";
    if ($filters && !empty($filters)):
        ob_start();
        if ($sticky): ?>
            <div class="btn-filter-toggle-wrapper position-sticky alignwider" style="display: none;">
                <button type="button" class="btn-filter-toggle btn btn-outline<?= $indicate_active ? ' active' : '' ?>" aria-label="<?= isset($custom_button_text["aria_label"]) ? $custom_button_text["aria_label"] : __('Zobraziť filtre', 'kapital') ?>">
                    <?= isset($custom_button_text["text"]) ? $custom_button_text["text"] : __('Filter', 'kapital') ?>
                    <svg class="ms-2 icon-square">
                        <use xlink:href="#icon-filter"></use>
                    </svg>
                </button>
                <?= $additional_button_html ?>
            </div>
        <?php endif; ?>
        <div class="filters-modal <?php if ($sticky) echo ' position-sticky' ?>" tabindex="-1" <?php if ($sticky) echo 'style="display: none"' ?>>
            <div class="modal-dialog">
                <div class="modal-content bg-transparent">
                    <button class="btn btn-close close mb-2" data-bs-dismiss="modal" aria-label="<?= __("Skryť filtre", "kapital") ?>" style="display:none !important"><svg>
                            <use xlink:href="#icon-close"></use>
                        </svg></button>
                    <?php foreach ($filters as $filter):
                        $additional_filter_class = '';
                        $filter_aria_label = '';
                        $custom_html = '';
                        $name = '';
                        $link = '';
                        if ($filters_as_associative_array) {
                            if (isset($filter["custom_html"])) 
                                $custom_html = $filter["custom_html"];
                            if (isset($filter["additional_class"]) && $filter["additional_class"] !== '') 
                                $additional_filter_class = ' ' . $filter["additional_class"];
                            if (isset($filter["aria_label"]) && $filter["aria_label"] !== '') 
                                $filter_aria_label = ' aria-label="' . $filter["aria_label"] . '" ';
                            if (isset($filter["name"]))
                                $name = $filter["name"];
                            if (isset($filter["url"]))
                                $link = $filter["url"];
                        } else {
                            $term_slug = $filter->slug;
                            $name = $filter->name;
                            $link = get_term_link($filter);
                            $custom_html = '';
                            //shorten one specific name as it is too long for filter
                            $name = ($term_slug === "ekologia-a-polnohospodarstvo") ? __("Ekológia", "kapital") : $name;
                            $name = ($term_slug === "kniha") ? __("Knihy", "kapital") : $name;
                        }
                        if ($custom_html === ''): ?>
                            <div class="my-2 my-sm-1 mx-1">
                                <a class="btn btn-outline text-center<?= $additional_filter_class ?>" href="<?= $link ?>" <?= $filter_aria_label ?>>
                                    <?= $name ?>
                                </a>
                            </div>
                        <?php else:
                            echo $custom_html;
                        endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
<?php
        $html = ob_get_clean();
    endif;
    return $html;
}


/**
 * Sets the query to all for taxonomy "číslo" (issue)
 * Sets the query to all for post type "redakcia"
 * Sets the query to 24 for all other main queries
 * 
 * @param WP_Query $query
 */
function kapital_post_query_mod($query)
{
    if ($query->is_main_query()) {
        if ($query->is_home() || $query->is_archive()) {
            if ($query->is_post_type_archive('redakcia')) {
                $query->set('posts_per_page', -1);
            } else {
                if ($query->is_tax('cislo')) {
                    $query->set('posts_per_page', -1);
                } else {
                    $query->set('posts_per_page', 24);
                }
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
function kapital_wp_trim_excerpt($excerpt, $excerpt_word_count = 10)
{
    global $post;
    if ('' == $excerpt) {
        $excerpt = get_the_content('', false, $post);
    }
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = apply_filters('the_content', $excerpt);
    $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
    $excerpt = strip_tags($excerpt, ['<p>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>']); /*IF you need to allow just certain tags. Delete if all tags are allowed */
    $excerpt = str_replace(['h1>', 'h2>', 'h3>', 'h4>', 'h5>', 'h6>'], 'p>', $excerpt);
    $excerpt = str_replace(['<h1', '<h2', '<h3', '<h4', '<h5', '<h6'], '<p', $excerpt);
    $excerpt = preg_replace('/class=".*?"/', '', $excerpt); //fix excerpt classes - first paragraph is perex

    //Set the excerpt word count and only break after sentence is complete.
    $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
    $tokens = array();
    $excerptOutput = '';
    $count = 0;

    // Divide the string into tokens; HTML tags, or words, followed by any whitespace
    preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

    foreach ($tokens[0] as $key => $token) {
        if ($count >= $excerpt_length && (preg_match('/[\,\;\?\.\!\<\/p>]\s*$/uS', $token) || $key > 20)) {
            // Limit reached, continue until , ; ? . or ! occur at the end
            $excerptOutput .= preg_replace('/<\/p>$/', '', trim($token, " \n\r\t\v\x00,.?!")) . '...';
            break;
        }

        // Add words to complete sentence
        $count++;

        // Append what's left of the token
        $excerptOutput .= $token;
    }

    $excerpt = trim(force_balance_tags($excerptOutput));

    return $excerpt;

    return apply_filters('kapital_wp_trim_excerpt', $excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'kapital_wp_trim_excerpt');

/** change pagination base */
function kapital_custom_pagination_base()
{
    global $wp_rewrite;
    $wp_rewrite->pagination_base = 'strana'; //where new-slug is the slug you want to use 
}

//priority needs to be lower than the priority of custom post type registration
add_action('init', 'kapital_custom_pagination_base', 0);

/** simple function to get default rendering settings, if not set by meta
 * @param integer $post_id
 * @param string $post_type
 * @param boolean $show_false forcible get all as false
 * @return array
 */
function kapital_get_render_settings(int $post_id, string $post_type, bool $show_false = false)
{
    if ($show_false) {
        $render_settings = array();
    } else {
        $render_settings = get_post_meta($post_id, '_kapital_post_render_settings', true);
    }
    $default_render_settings = array(
        'show_featured_image' =>  $show_false ? false : true,
        'show_breadcrumbs' =>  $show_false ? false : true,
        'show_title' => $show_false ? false : true,
        'show_author' => $show_false ? false : true,
        'show_categories' => $show_false ? false : true, //only used for post, podcast
        'show_views' => $show_false ? false : true,
        'show_date' => $show_false ? false : true,
        'show_ads'  => $show_false ? false : true, //only used for post, podcast
        'show_support' => $show_false ? false : true, //only used for post, podcast
        'show_footer' => $show_false ? false : true, //only used for post, podcast
        'show_footer_newsletter' => $show_false ? false : true,
        'show_share_button' => $show_false ? false : true, //only used for post, podcast
        'show_filters' => false, //only used for page
        'show_event_location' => false, //only used for event

    );
    if ($post_type === 'podcast') {
        $default_render_settings["show_featured_image"] = false;
        $default_render_settings["show_author"] = false;
    }
    if ($post_type === 'page') {
        $default_render_settings["show_featured_image"] = false;
        $default_render_settings["show_share_button"] = false;
        $default_render_settings["show_views"] = false;
        $default_render_settings["show_date"] = false;
        $default_render_settings["show_categories"] = false;
        $default_render_settings["show_author"] = false;
        $default_render_settings["show_share_button"] = false;
    }
    if ($post_type === 'event') {
        $default_render_settings["show_author"] = false;
        $default_render_settings["show_event_location"] = true;
        $default_render_settings["show_ads"] = false;
    }

    if (is_array($render_settings)) {
        $render_settings = array_merge($default_render_settings, $render_settings);
    } else {
        $render_settings = $default_render_settings;
    }
    return $render_settings;
}

class Nested_Menu_List extends Walker_Nav_Menu
{
    // Start Level: This function adds the <ul> wrapper for submenus
    public function start_lvl(&$output, $depth = 0, $args = null)
    {

        // Add the submenu <ul> only if we are at a depth greater than 0 (for nested submenus)
        if ($depth >= 0) {
            $output .= '<ul class="ps-2 submenu list-unstyled">';
        }
    }

    // End Level: This function closes the <ul> for submenus
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth >= 0) {
            $output .= '</ul>';
        }
    }

    // Start Element: This function adds the <li> for each menu item
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'level-' . $depth;

        // Add the classes to the <li> element
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // Item ID and class
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        // Build the link for the menu item
        $attributes = ' class="btn-menu';
        $attributes .= '"';
        $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="' . esc_attr($item->url) . '"' : '';

        // Output the link
        if (isset($args->before)) {
            $item_output = $args->before;
        } else {
            $item_output = "";
        }

        $item_output .= '<a' . $attributes . '>';
        if (isset($args->link_before)) {
            $item_output .= $args->link_before;
        }
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        if (isset($args->link_after)) {
            $item_output .= $args->link_after;
        }
        $item_output .= '</a>';
        if (isset($args->after)) {
            $item_output .= $args->after;
        }

        $output .= $item_output;
    }

    // End Element: This function closes each <li> item
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

function auto_nbsp($text)
{
    $text = preg_replace('/\h(\S{1,2})\h(\S)/', ' $1&nbsp;$2', $text); //replace proposition whitespace
    $text = preg_replace('/(\h)(\S{1,2})\h*$/', '&nbsp;$2', $text); //replace 1-2 character strings at the end
    return $text;
};
/**
 * @param string|int|WP_Post $post wordpress post object or gmt timestamp
 * @param string $additional_classes 
 * @param string $custom_date_string override automatic generation of human readable date string
 * @param $format date() compatible format for datetime attribute, default 'Y-m-d\TH:iP'
 * @param string|bool|null $aria_label optional aria label, default "Dátum publikovania", false or empty string to remove
 * @return string html time element
 * 
 */
function get_publish_datetime_element($post, string $additional_classes = '', $custom_date_string = '', $aria_label = null, $format = 'Y-m-d\TH:iP')
{
    $is_post = $post instanceof WP_Post;
    if (!$aria_label) $aria_label = __("Dátum publikovania", "kapital");
    $html = '<time';
    $html .= $aria_label === '' || false ? '' : ' aria-label="' . $aria_label . '"';
    $html .= ' datetime="';
    if ($is_post) {
        $html .= get_the_date($format, $post);
    } else {
        $html .= wp_date($format, $post, kapital_get_timezone());
    }
    $html .= '"';
    $html .= $additional_classes !== '' ? ' class="' . $additional_classes . '"' : '';
    $html .= '>';
    if ($custom_date_string !== '') {
        $html .= $custom_date_string;
    } else {
        if ($is_post) {
            $html .= get_the_date(get_option('date_format'), $post);
        } else {
            $html .= wp_date(get_option('date_format'), $post);
        }
    }
    $html .= '</time>';
    return $html;
}

function get_publish_datetime_element_event($event_date_start, $event_date_format, $event_date_string, $date_element_classes = '')
{
    switch ($event_date_format):
        case 'day':
            echo get_publish_datetime_element($event_date_start, $date_element_classes, $event_date_string, __("Dátum konania", "kapital"), 'Y-m-d');
            break;
        case 'month':
        case 'season':
            echo get_publish_datetime_element($event_date_start, $date_element_classes, $event_date_string, __("Dátum konania", "kapital"), 'Y-m');
            break;
        case 'year':
            echo get_publish_datetime_element($event_date_start, $date_element_classes, $event_date_string, __("Dátum konania", "kapital"), 'Y');
            break;
        default:
            echo get_publish_datetime_element($event_date_start, $date_element_classes, $event_date_string, __("Dátum konania", "kapital"));
    endswitch;
}


function kapital_get_event_location_string($meta_value, $include_links = true)
{
    $location_string = "";
    if ($meta_value && $meta_value !== "") {
        $event_locations = json_decode($meta_value);
        //filter without location name
        if ($event_locations) {
            $event_locations = array_filter($event_locations, function ($location) {
                return $location->name !== "";
            });
        }
        foreach ($event_locations as $key => $location) {
            if ($key > 0) {
                $location_string .= ',<br>';
            }
            $location_string .= sprintf(
                '%s%s%s',
                $location->url === "" || !$include_links ? '' : '<a href="' . $location->url . '" target="_blank" class="text-decoration-none">',
                $location->name,
                $location->url === "" || !$include_links ? '' : '</a>'
            );
        }
    }

    return $location_string;
}

/**
 * just simple runtime cache of current_time
 * @return int current UTC timestamp
 */
function kapital_current_utc_timestamp()
{
    static $kptl_current_utc_time;
    if (isset($kptl_current_utc_time) && !is_null($kptl_current_utc_time)) {
        return $kptl_current_utc_time;
    }
    $kptl_current_utc_time = current_time('timestamp', true); // 'true' ensures UTC time
    return $kptl_current_utc_time;
}
/**
 * just simple runtime cache of current timezone
 * @return DateTimeZone current timezone
 */
function kapital_get_timezone()
{
    static $kptl_current_timezone;
    if (isset($kptl_current_timezone) && !is_null($kptl_current_timezone)) {
        return $kptl_current_timezone;
    }
    $timezone_string = get_option('timezone_string');
    $kptl_current_timezone = new DateTimeZone($timezone_string ? $timezone_string : 'UTC');
    return $kptl_current_timezone;
}
/**
 * Returns a human-readable string describing the time remaining until an event starts,
 * or its status (e.g., "Archív", "Pripravujeme", "Budúci rok", "O X rokov", etc.).
 *
 * - If the event has ended, returns "Archív".
 * - If the event date format is not specific (not 'day', 'full', or 'full-start'), returns "Pripravujeme".
 * - If the event is more than a year away, returns "Budúci rok" or "O X rokov".
 * - Otherwise, delegates to kapital_event_get_remaining_month() for finer granularity.
 *
 * @param int $event_date_start  UTC timestamp of the event start.
 * @param int $event_date_end    UTC timestamp of the event end.
 * @param DateTimeZone $timezone Timezone object for date calculations.
 * @param string $format         Event date format ('full', 'full-start', 'day', 'month', 'season', 'year').
 * @param int|null $remaining    (Optional) Precomputed seconds remaining until event start. If null, will be calculated.
 * @return string                Human-readable string describing time until event or its status.
 */
function kapital_event_get_remaining($event_date_start, $event_date_end, $timezone, $format, $remaining = null)
{
    if ($event_date_end <= kapital_current_utc_timestamp()) {
        return __('Archív', 'kapital');
    }
    //if format does not display specific date return "comin soon"
    if (!in_array($format, array('day', 'full', 'full-start'))) {
        return __('Pripravujeme', 'kapital');
    }
    $one_year = 31556926; //year in seconds
    if (is_null($remaining)) {
        $remaining = $event_date_start - kapital_current_utc_timestamp();
    }
    if ($remaining > $one_year) {
        $next_year = new DateTime('first day of January midnight next year', $timezone); // January 1st at midnight in the current timezone
        $next_year = $next_year->getTimestamp(); // Convert to UTC timestamp
        $remaining_year_string = "";
        if ($event_date_start < $next_year + $one_year) {
            $remaining_year_string = __('Budúci rok' . 'kapital');
        } else {
            $year_number = (int)round($remaining / $one_year);
            if ($year_number < 5) {
                $remaining_year_string = sprintf('O&nbsp;%&nbsp;roky', $year_number);
            } else {
                $remaining_year_string = sprintf('O&nbsp;%&nbsp;rokov', $year_number);
            }
        }
        return $remaining_year_string;
    }
    return kapital_event_get_remaining_month($event_date_start, $timezone, $format, $remaining = null);
}

function kapital_event_get_remaining_month($event_date_start, $timezone, $format, $remaining = null)
{
    $one_month = 2629743; //30.44 days in seconds
    //approximation is enough here

    if (is_null($remaining)) {
        $remaining = $event_date_start -  kapital_current_utc_timestamp();
    }
    if ($remaining > $one_month) {
        $next_month = new DateTime('first day of next month midnight', $timezone); // January 1st at midnight in the current timezone
        $next_month = $next_month->getTimestamp(); // Convert to UTC timestamp
        $remaining_month_string = "";
        if ($event_date_start < $next_month + $one_month) {
            $remaining_month_string = __('Budúci mesiac', 'kapital');
        } else {
            $month_number = (int)round($remaining / $one_month);
            if ($month_number < 5) {
                $remaining_month_string = sprintf(__('o&nbsp;%d&nbsp;mesiace', 'kapital'), $month_number);
            } else {
                $remaining_month_string = sprintf(__('o&nbsp;%d&nbsp;mesiacov', 'kapital'), $month_number);
            }
        }
        return $remaining_month_string;
    }
    return kapital_event_get_remaining_day($event_date_start, $timezone, $format, $remaining = null);
}
/**
 * 
 */
function kapital_event_get_remaining_day($event_date_start, $timezone, $format, $remaining = null)
{
    if (is_null($remaining)) {
        $remaining = $event_date_start -  kapital_current_utc_timestamp();
    }
    static $day_strings;
    if (!isset($day_strings) || is_null($day_strings)) {
        $day_strings = array_map(
            function ($number) {
                if ($number > 4) {
                    return sprintf(__('O&nbsp;%s&nbsp;dní', 'kapital'), (string)$number);
                } else {
                    return sprintf(__('O&nbsp;%s&nbsp;dni', 'kapital'), (string)$number);
                }
            },
            range(3, 31)
        );
        array_unshift($day_strings, __('Dnes', 'kapital'), __('Zajtra', 'kapital'), __('Pozajtra', 'kapital'));
    }

    $current_midnight = new DateTime('today midnight', $timezone);
    $current_midnight = $current_midnight->getTimestamp();
    $oneday = 86400;
    if ($event_date_start - $current_midnight < 0) {

        //if format not for specific hour return "today"
        if (in_array($format, array('full', 'full-start'))) {
            return kapital_event_get_remaining_hour($event_date_start, $timezone, $format, $remaining = null);
        } else {
            return $day_strings[0];
        }
    } else {
        $day_string_key = intdiv(($event_date_start - $current_midnight), $oneday);
        return $day_strings[$day_string_key];
    }
}

function kapital_event_get_remaining_hour($event_date_start, $timezone, $format, $remaining = null)
{
    if (is_null($remaining)) {
        $remaining = $event_date_start -  kapital_current_utc_timestamp();
    }
    if ($remaining < 0) {
        return __('Práve prebieha', 'kapital');
    }
    $one_hour = 3600;
    static $hour_strings;
    if (!isset($hour_strings) || is_null($hour_strings)) {
        $hour_strings = array_map(
            function ($number) {
                if ($number > 4) {
                    return sprintf(__('O&nbsp;%s&nbsp;hodín', 'kapital'), (string)$number);
                } else {
                    return sprintf(__('O&nbsp;%s&nbsp;hodiny', 'kapital'), (string)$number);
                }
            },
            range(2, 24)
        );
        array_unshift($hour_strings, __('O&nbsp;chvíľu začína', 'kapital'), __('O&nbsp;hodinu', 'kapital'));
    }
    $hour_string_key =  round($remaining / $one_hour);
    return $hour_strings[$hour_string_key];
}

/**
 * Outputs an SVG definition only once, then references it with <use> for subsequent calls.
 *
 * This function is useful in loops where the same SVG content needs to be rendered multiple times.
 * On the first call with a unique $svg_content_id, it outputs the full SVG with the content wrapped in a <g> element with the given ID.
 * On subsequent calls with the same $svg_content_id, it outputs only a <use> tag referencing the previously defined <g> element.
 *
 * Example usage:
 *   echo output_svg_once_then_use('<svg ...>', '<path ... />', 'my-icon');
 *
 * @param string $svg_def        The opening <svg> tag with all required attributes (the closing tag is added automatically).
 * @param string $svg_content    The SVG content to be wrapped in a <g> element and referenced.
 * @param string $svg_content_id Unique ID for the <g> element (without the '#' character).
 * @return string                The SVG markup, either the full definition or a <use> reference.
 */

function output_svg_once_then_use(string $svg_def, string $svg_content, string $svg_content_id)
{
    //holds the already outputed ids, so that they can be replaced by <use> 
    static $outputed_ids = array();
    $output = '';
    $output .= $svg_def;

    if (in_array($svg_content_id, $outputed_ids)) {
        $output .= "<use xlink:href=\"#{$svg_content_id}\"></use>";
    } else {
        $output .= "<g id=\"{$svg_content_id}\">";
        $output .= $svg_content;
        $output .= "</g>";
        $outputed_ids[] = $svg_content_id;
    }
    $output .= "</svg>";
    return $output;
}

/**
 * Retrieves the event thumbnail image HTML for a given event.
 *
 * If the event has a featured image, returns a responsive image using kapital_responsive_image().
 * If not, returns a placeholder SVG image, cycling through 4 variants for variety.
 *
 * @param int $post_id The ID of the post for which to get the event thumbnail.
 * @return string HTML markup for the event thumbnail image or a placeholder image.
 */
function kapital_get_event_thumbnail(int $post_id)
{
    static $placeholder_count = 0;

    $thumbnail_image_id = get_post_thumbnail_id($post_id);
    //var_dump($thumbnail_image_id);

    //if no image returns zero
    if ($thumbnail_image_id) {
        $thumbnail_image = kapital_responsive_image(get_post_thumbnail_id($post_id), "(max-width: 599px) 95vw, (max-width: 899px) 47vw, (max-width: 1199px) 32vw, (max-width: 1649px) 320px, (max-width: 2099px) 390px, 480px", false, 'rounded w-100 archive-item-image');
    } else {
        $placeholder_no = $placeholder_count  % 4 + 1;
        $thumbnail_image = '<img src="' .
            get_template_directory_uri() .
            "/assets/images/event-placeholder-{$placeholder_no}.svg" . '" alt="" class="rounded w-100 archive-item-image placeholder bg-secondary-light"/>';
        $placeholder_count++;
    }
    return $thumbnail_image;
}
