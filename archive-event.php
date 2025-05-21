<?php
//get current page
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//load template for cpt manually, as WP loads archive.php by default
if (isset($queried_object->taxonomy)) {
    if ($taxonomy === 'podcast-seria') {
        $load = locate_template('archive-podcast.php', true);
        if ($load) {
            exit(); // just exit if template was found and loaded
        }
    }
}
get_header();
//var_dump(get_taxonomies(array('public'=>'true'), 'objects'));
//get current queried object
//var_dump($wp_query);
$heading_level = 2;
$current_year = get_query_var('rok');
$is_general_post_archive = is_home();
$archive_title = "";
$is_term_archive = is_tax();
//all share these starting breadcrubms
$archive_link = get_post_type_archive_link('event');
$archive_title = __('Podujatia', 'kapital');

$breadcrumbs = array(
    [__('Podujatia', 'kapital'), $archive_link],
);

if ($current_year !== ""){
    $archive_title = __('Podujatia', 'kapital') . ' ' . $current_year;
    $breadcrumbs[] = [$current_year, '', true];
} else {
    $breadcrumbs[0][2] = true;
    if ($paged > 1){
        $archive_title = __('Archív podujatí', 'kapital');
    }
}


/**
 * setup year filter
 */
$timezone_string = get_option('timezone_string');
$timezone = new DateTimeZone($timezone_string);
// Query for the oldest event
$oldest_event = get_posts(array(
    'post_type'      => 'event',
    'meta_key'       => '_event_date_start',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC', // Oldest first
    'posts_per_page' => 1, // Limit to 1 post
    'fields'         => 'ids', // Only get the post ID for efficiency
));

//var_dump($oldest_event);
// Query for the newest event
$newest_event = get_posts(array(
    'post_type'      => 'event',
    'meta_key'       => '_event_date_start',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC', // Newest first
    'posts_per_page' => 1, // Limit to 1 post
    'fields'         => 'ids', // Only get the post ID for efficiency
));

// Extract years from the timestamps
$years_filters = array();
if (!empty($oldest_event) && !empty($newest_event)) {
    // Get the timestamps for the oldest and newest events
    $oldest_timestamp = get_post_meta($oldest_event[0], '_event_date_start', true);
    $newest_timestamp = get_post_meta($newest_event[0], '_event_date_start', true);

    // Convert timestamps to the desired timezone
    $oldest_date = new DateTime('@' . $oldest_timestamp); // Create DateTime from UTC timestamp
    $oldest_date->setTimezone($timezone); // Convert to the desired timezone
    $oldest_year = (int) $oldest_date->format('Y'); // Extract the year

    $newest_date = new DateTime('@' . $newest_timestamp); // Create DateTime from UTC timestamp
    $newest_date->setTimezone($timezone); // Convert to the desired timezone
    $newest_year = (int) $newest_date->format('Y'); // Extract the year

    // Create an array of years from oldest to newest
    $years_filters = array_map(function ($year) use ($archive_link) {
        return array("name" => $year, "url" => $archive_link . 'rok/' . $year . '/');
    }, range($newest_year, $oldest_year));
}

/** render breadcrumbs */
echo kapital_breadcrumbs($breadcrumbs, 'container');

/** MAIN */ ?>
<main class="main container" role="main" id="main">

    <?php /** archive title  */ 
    $header_classes = $paged === 1 && $current_year === "" ? 'visually-hidden ' : '';
    $header_classes .= 'archive-header alignwide mb-5" role="heading';
    echo '<header class="' .  $header_classes . '">';
    echo kapital_bubble_title($archive_title, 1);
    echo '</header>'; ?>

    <?php /** filters */
    /* if ($is_term_archive) {
        echo kapital_post_filters($is_general_post_archive, $is_term_archive, false, $queried_object_id, $taxonomy);
    } else {
        echo kapital_post_filters($is_general_post_archive, $is_term_archive, false, $queried_object_id);
    } */
    if ($paged === 1 && $current_year === ""):
       $heading_level = 3;
        //var_dump(kapital_current_utc_timestamp());
       $upcoming_events = new WP_Query(array(
            'post_type'      => 'event', // Only include posts of type 'event'
            'meta_key'       => '_event_date_start', // Order by event start date
            'orderby'        => 'meta_value_num', // Ensure numeric ordering
            'order'          => 'ASC', // Order ascending by start date
            'posts_per_page' => -1, // unlimited, there will never be too much planned events
            'meta_query'     => array(
                array(
                    'key'     => '_event_date_end',
                    'value'   => kapital_current_utc_timestamp(),
                    'compare' => '>=', // Include only posts where _event_date_end is greater than or equal to the current time
                    'type'    => 'NUMERIC',
                ),
            ),
        ));
        echo '<section class="alignwider mb-6">';
        echo '<header class="mb-6">' . kapital_bubble_title(__('Aktuálne podujatia', 'kapital'), 2) . '</header>';      
        if ($upcoming_events->have_posts()):
            $justify_class = $upcoming_events->post_count < 3 ? " justify-content-center" : " justify-content-start";?> 
                <ul role="list" class="list-unstyled row mb-0 gy-5 gx-3<?php echo $justify_class ?>">
                    <?php while ($upcoming_events->have_posts()) : $upcoming_events->the_post();
                    get_template_part(
                        'template-parts/archive-single-event',
                        null,
                        array('heading_level' => $heading_level)
                    );
                    endwhile;?>
                </ul>
        <?php else:
            echo '<p class="my-6 ff-grotesk  fw-bold text-center lh-sm">' . __('Nenašli sa žiadne pripravované podujatia.', 'kapital') . '</p>';
        endif;
        echo '</section>';
        wp_reset_postdata();
    endif;

    global $wp_query;
    if ($wp_query->have_posts()) :
        //justify post center when too few posts
        $section_tag = $paged === 1 && $current_year === "" ? 'section' : 'div';
        $justify_class = $wp_query->post_count < 3 ? " justify-content-center" : " justify-content-start";
        ?><<?=$section_tag?> class="alignwider">
            <?php 
            //only include section header on page 1 and if year (rok) not specified
            echo $paged === 1 && $current_year === "" ? '<header>' . kapital_bubble_title(__('Archív', 'kapital'), 2) . '</header>' : '' ;
            
            //render year filter
            if (count($years_filters) && $current_year === ""){
                echo kapital_render_filters($years_filters, true, true, __('Rok', 'kapital'));
            }?>

                <ul role="list" class="list-unstyled mb-0 row gy-5 gx-3<?php echo $justify_class ?>">
                    <?php
                    /** 
                     * see kapital_sort_by_event_date in event_post_type_functions.php
                     * posts are already filtered to exclude current events 
                     */
                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        get_template_part(
                            'template-parts/archive-single-event', 
                            null,
                            //no need to calculate if this is old event again
                            isset($current_year) && $current_year !== "" ? array('is_old_event' => true, 'heading_level' => $heading_level) : array('heading_level' => $heading_level)
                        );
                    endwhile; ?>
                </ul>
        </<?=$section_tag?>>
    <?php else:
    echo '<p class="my-6 ff-grotesk text-center fw-bold lh-sm">' . __('Nenašli sa žiadne podujatia.', 'kapital') . '</p>';
        endif; ?>
    <?php echo kapital_pagination(); ?>
</main>

<?php get_footer();
