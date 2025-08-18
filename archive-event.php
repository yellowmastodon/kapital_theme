<?php

/**
 * Archive template for displaying events.
 *
 * This template handles filtering events by year and whether they have recordings.
 * It also displays upcoming events, a year filter, and renders breadcrumbs and archive titles.
 * @todo even better filter logic. E.g. show filters even when current query has no posts, what to do when there is no recording in current year, do not show filter? redirect to page without recording filter?
 */

// Get current pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Load the header
get_header();

// Variables setup
$heading_level = 2;
$current_year = get_query_var('rok');
$recording = get_query_var('zaznam') === '1' ? true : false;
$is_first_nonfiltered_page = $paged === 1 && $current_year === "" && !$recording;
$archive_title = __('Podujatia', 'kapital');
$archive_link = get_post_type_archive_link('event');

// Initial breadcrumb setup
$breadcrumbs = array(
    [__('Podujatia', 'kapital'), $archive_link],
);

// Adjust breadcrumbs and title based on filters
if ($current_year !== "") {
    $archive_title = __('Podujatia', 'kapital') . ' ' . $current_year;
    $breadcrumbs[] = [$current_year, $archive_link . 'rok/' . $current_year . '/'];

    if ($recording) {
        $archive_title = sprintf(__('Podujatia %s so&nbsp;záznamom'), $current_year);
        $breadcrumbs[] = [__('Záznamy', 'kapital'), '', true];
    } else {
        $breadcrumbs[count($breadcrumbs) - 1][] = true;
    }
} else {
    if (!$recording) {
        $breadcrumbs[0][2] = true;

        if ($paged > 1) {
            $archive_title = __('Archív podujatí', 'kapital');
        }
    } else {
        $breadcrumbs[] = [__('Záznamy', 'kapital'), '', true];
        $archive_title = __('Podujatia so&nbsp;záznamom', 'kapital');
    }
}

/**
 * Setup year filter based on events
 * Generate year filters from event timestamps
 */
$timezone_string = get_option('timezone_string');
$timezone = new DateTimeZone($timezone_string);

// Fetch oldest event
$oldest_event = get_posts(array(
    'post_type'      => 'event',
    'meta_key'       => '_event_date_start',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
    'posts_per_page' => 1,
    'fields'         => 'ids',
));

// Fetch newest event
$newest_event = get_posts(array(
    'post_type'      => 'event',
    'meta_key'       => '_event_date_start',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'posts_per_page' => 1,
    'fields'         => 'ids',
));

$years_filters = array();

if (!empty($oldest_event) && !empty($newest_event)) {
    $oldest_timestamp = get_post_meta($oldest_event[0], '_event_date_start', true);
    $newest_timestamp = get_post_meta($newest_event[0], '_event_date_start', true);

    $oldest_date = new DateTime('@' . $oldest_timestamp);
    $oldest_date->setTimezone($timezone);
    $oldest_year = (int) $oldest_date->format('Y');

    $newest_date = new DateTime('@' . $newest_timestamp);
    $newest_date->setTimezone($timezone);
    $newest_year = (int) $newest_date->format('Y');

    $years_filters = array_map(function ($year) use ($archive_link, $recording, $current_year) {
        $is_active = $year == $current_year;
        $recording_query = $recording ? '?zaznam=1' : '';
        $base_url = $is_active ? $archive_link : $archive_link . 'rok/' . $year . '/';

        return array(
            "name" => $year,
            "url" => $base_url . $recording_query,
            "additional_class" => $is_active ? 'active' : '',
            "aria_label" => $is_active ? __("Zobraziť všetky roky", "kapital") : ''
        );
    }, range($newest_year, $oldest_year));
}

/**
 * Render breadcrumbs
 */
echo kapital_breadcrumbs($breadcrumbs, 'container');

/**
 * MAIN CONTENT
 */
?>
<main class="main container" role="main" id="main">

    <?php
    /**
     * Archive header title
     * hidden if also displaying upcomming events
     */
    $header_classes = $is_first_nonfiltered_page ? 'visually-hidden ' : '';
    $header_classes .= 'archive-header alignwide mb-5" role="heading';
    echo '<header class="' .  $header_classes . '">';
    echo kapital_bubble_title($archive_title, 1);
    echo '</header>';
    ?>

    <?php
    /**
     * Show upcoming events on the first, non-filtered archive page
     */
    if ($is_first_nonfiltered_page):
        $heading_level = 3;

        $upcoming_events = new WP_Query(array(
            'post_type'      => 'event',
            'meta_key'       => '_event_date_start',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_event_date_end',
                    'value'   => kapital_current_utc_timestamp(),
                    'compare' => '>=',
                    'type'    => 'NUMERIC',
                ),
            ),
        ));

        echo '<section class="alignwider mb-6">';
        echo '<header class="mb-6">' . kapital_bubble_title(__('Aktuálne podujatia', 'kapital'), 2) . '</header>';

        if ($upcoming_events->have_posts()):
            get_template_part(
                'template-parts/archive-event-list',
                null,
                array(
                    'query' => $upcoming_events,
                    'heading_level' => $heading_level
                )
            );
        else:
            echo '<p class="my-6 ff-grotesk fw-bold text-center lh-sm">' . __('Nenašli sa žiadne pripravované podujatia.', 'kapital') . '</p>';
        endif;

        echo '</section>';
        wp_reset_postdata();
    endif;

    global $wp_query;

    /**
     * Archive section for past events or filtered views
     */


    //check if there are any posts with 
    $temp_rec_query = new WP_Query(array(
        'post_type'      => 'event',
        'posts_per_page' => 1,
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key' => '_kapital_event_recording',
                'value' => 'audio',
                'compare' => 'LIKE',
            ),
            array(
                'key' => '_kapital_event_recording',
                'value' => 'video',
                'compare' => 'LIKE',
            ),
        )
    ));

    if ($wp_query->have_posts()) :
        $section_tag = $is_first_nonfiltered_page ? 'section' : 'div';
    ?>
        <<?= $section_tag ?> class="alignwider">
            <?php
            echo $is_first_nonfiltered_page ? '<header>' . kapital_bubble_title(__('Archív', 'kapital'), 2) . '</header>' : '';

            /**
             * Render year and recording filters
             */
            if (count($years_filters)) {
                array_unshift($years_filters, array('custom_html' => '<div class="filter-row-break w-100"></div>'));
                $recording_filter_html = '';
                if ($temp_rec_query->have_posts()){
                    $recording_filter_html = '<a class="btn btn-outline ms-1';
                    $recording_filter_html .= $recording ? ' active" aria-label="' . __('Zobraziť všetky podujatia', 'kapital') . '"' : '"';
                    $recording_filter_html .= ' href="' . $archive_link;
                    $recording_filter_html .= $current_year === '' ? '' : 'rok/' . $current_year . '/';
                    $recording_filter_html .= $recording ? '"' : '?zaznam=1"';
                    $recording_filter_html .= '>' . __('Záznamy', "kapital") . '</a>';
                }
            
                echo kapital_render_filters($years_filters, true, true, [
                    'text' => __('Rok', 'kapital'),
                    'aria_label' => __('', 'kapital')
                ], $current_year !== "", $recording_filter_html);
            }

            /**
             * Render filtered event list
             */
            get_template_part(
                'template-parts/archive-event-list',
                null,
                isset($current_year) || $current_year !== ""
                    ? array('query' => $wp_query, 'are_old_events' => true, 'heading_level' => $heading_level)
                    : array('query' => $wp_query, 'heading_level' => $heading_level)
            );
            ?>
        </<?= $section_tag ?>>
    <?php
    else:
        echo '<p class="my-6 ff-grotesk fw-bold text-center lh-sm">' . __('Nenašli sa žiadne podujatia.', 'kapital') . '</p>';
    endif;
    ?>

    <?php echo kapital_pagination(); ?>
</main>

<?php get_footer(); ?>