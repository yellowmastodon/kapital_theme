<?php get_header();
$queried_object = get_queried_object();
$queried_object_id = get_queried_object_id();
$breadcrumbs = array(
    [__('Podcasty', 'kapital'), get_post_type_archive_link('podcast')],
);


get_footer();