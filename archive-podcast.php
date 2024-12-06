<?php get_header();
$queried_object = get_queried_object();
$queried_object_id = get_queried_object_id();

$queried_object = get_queried_object();
$queried_object_id = get_queried_object_id();
$is_general_podcast_archive = is_post_type_archive('podcast');
$archive_title = "";
$is_term_archive = is_tax();
//all share these starting breadcrubms
$breadcrumbs = array(
    [__('Podcasty', 'kapital'), get_post_type_archive_link('podcast')],
);


if ($is_term_archive) {
    $archive_title = get_queried_object()->name;
    //add taxonomy list page breadcrumb (if exists)
    $taxonomy = $queried_object->taxonomy;
    if (array_key_exists($taxonomy, $kapital_taxonomies_with_list_pages)) {
        $list_page = get_page_by_path($kapital_taxonomies_with_list_pages[$taxonomy]);
        $breadcrumbs[] = [get_the_title($list_page), get_page_link($list_page)];
    }
    //add parent archive breadcrumb
    $parent = (isset($queried_object->parent)) ? get_term_by('id', $queried_object->parent, $taxonomy) : false;
    if ($parent) {
        $breadcrumbs[] = [$parent->name, get_term_link($parent)];
    }
} elseif (is_day()) {
    $archive_title = sprintf(__('Podcasty publikované dňa %s', 'kapital'), '<span>' . str_replace(' ', '&nbsp;', get_the_date('j. n. Y')) . '</span>');
    $breadcrumbs[0][2] = true;
} elseif (is_month()) {
    $archive_title = sprintf(__('Podcasty publikované v mesiaci %s', 'kapital'), '<span>' . get_the_date('F Y') . '</span>');
    $breadcrumbs[0][2] = true;
} elseif (is_year()) {
    $archive_title =  sprintf(__('Podcasty publikované v roku %s', 'kapital'), '<span>' . get_the_date('Y') . '</span>');
    $breadcrumbs[0][2] = true;
} else {
    $archive_title = __('Najnovšie podcasty', 'kapital');
    $breadcrumbs[0][2] = true;
}
/** render breadcrumbs */
echo kapital_breadcrumbs($breadcrumbs, 'container');
/** MAIN */ ?>
<main class="main container" role="main" id="main">

    <?php /** archive title  */  ?>
    <header class="archive-header alignwide mb-6" role="heading">
        <?php echo kapital_bubble_title($archive_title, 1, 'term-title'); ?>
    </header>
    <?php if ($wp_query->have_posts()):?>
        <section class="alignwide">
                <?php while (have_posts()) : the_post();
                    get_template_part('template-parts/archive-single-podcast', null, array('queried_object_id' => $queried_object_id));
                endwhile; ?>
        </section>
    <?php endif; ?>
    <?php echo kapital_pagination(); ?>


</main><?php

get_footer();