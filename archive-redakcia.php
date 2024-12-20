<?php
$queried_object = get_queried_object();
$queried_object_id = get_queried_object_id();
//load template for cpt manually, as WP loads archive.php by default
if (isset($queried_object->taxonomy)){
    if ($taxonomy === 'podcast-seria'){
         $load = locate_template('archive-podcast.php', true);
     if ($load) {
        exit(); // just exit if template was found and loaded
     }
    }
}
get_header();
//var_dump(get_taxonomies(array('public'=>'true'), 'objects'));
//get current queried object

$is_general_post_archive = is_home();
$archive_title = "";
$is_term_archive = is_tax();
$breadcrumbs = array();
//all share these starting breadcrubms
global $kapital_taxonomies_with_list_pages;
//about us page 
$about_page = get_posts(array(
    'name'           => 'o-nas', 
    'post_type'      => 'page',  // You can also use 'page' or custom post types
    'posts_per_page' => 1
));
if (!empty($about_page)){
    $breadcrumbs[] = [$about_page[0]->post_title, get_the_permalink($about_page[0])];
}
$breadcrumbs[] = [__('Redakcia', 'kapital'), get_post_type_archive_link('redakcia')];

//setup title

$archive_title = __('Redakcia', 'kapital');

/** render breadcrumbs */
echo kapital_breadcrumbs($breadcrumbs, 'container');

/** MAIN */ ?>
<main class="main container" role="main" id="main">

    <?php /** archive title  */  ?>
    <header class="archive-header alignwide mb-6" role="heading">
        <?php echo kapital_bubble_title($archive_title, 1);?>
    </header>

    <?php /** filters */
    if ($wp_query->have_posts()) :
    ?>
        <section class="alignwide">
            <div class="row gy-6 gx-3">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('template-parts/archive-single-redakcia', null, array('heading_level' => 2));
                endwhile; ?>
            </div>
        </section>
    <?php endif; ?>
    <?php echo kapital_pagination(); ?>
</main>

<?php get_footer();
