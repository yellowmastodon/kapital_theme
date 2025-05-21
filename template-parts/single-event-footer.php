<?php

/**
 * displays recommended posts on single event page
 */
defined('ABSPATH') || exit;

$more_events_query = new WP_Query(array(
    'posts_per_page' => 3,
    'post_type'      => 'event',
    'meta_key'       => '_event_date_start',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'post_status'    => 'publish',
    'post__not_in'   => array($post->ID),
));

$more_events_no = $more_events_query->post_count;
$justify_class = $more_events_no < 3 ? " justify-content-center" : " justify-content-start";

$more_events_query = new WP_Query(array(
    'posts_per_page' => 3,
    'post_type'      => 'event',
    'meta_key'       => '_event_date_start',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'post_status'    => 'publish',
    'post__not_in'   => array($post->ID),
));

$more_events_no = $more_events_query->post_count;
$justify_class = $more_events_no < 3 ? " justify-content-center" : " justify-content-start";

if ($more_events_query->have_posts()) {
    echo '<footer class="event-footer alignwider mt-6">';
    echo kapital_bubble_title(__('Ďalšie podujatia', 'kaptial'), 2, 'mb-6');
    echo '<ul role="list" class="list-unstyled mb-0 row gy-5 gx-3' . $justify_class . '">';
    while ($more_events_query->have_posts()) {
        $more_events_query->the_post();
        get_template_part('template-parts/archive-single-event', null, array('heading_level' => 3));
    }
    echo '</ul>';
    echo '<div class="text-center mt-5">';
        echo '<a href="'
        . get_post_type_archive_link('event')
        . '" class="btn btn-secondary">'
        . __('Zobraziť všetky', 'kapital')
        . '<svg class="icon-square ms-2">'
        . '<use xlink:href="#icon-arrow-right"></use>'
        . '</svg></a>';
    echo '</div>';
    echo '</footer>';
    wp_reset_postdata();
}