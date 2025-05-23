<?php
$queried_object = get_queried_object();
$queried_object_id = get_queried_object_id();
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

$is_general_post_archive = is_home();
$archive_title = "";
$is_term_archive = is_tax();
//all share these starting breadcrubms
global $kapital_taxonomies_with_list_pages;
$breadcrumbs = array(
    [__('Články', 'kapital'), get_post_type_archive_link('post')],
);

//setup title
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
    $archive_title = sprintf(__('Články publikované dňa %s', 'kapital'), '<span>' . str_replace(' ', '&nbsp;', get_the_date('j. n. Y')) . '</span>');
    $breadcrumbs[0][2] = true;
} elseif (is_month()) {
    $archive_title = sprintf(__('Články publikované v mesiaci %s', 'kapital'), '<span>' . get_the_date('F Y') . '</span>');
    $breadcrumbs[0][2] = true;
} elseif (is_year()) {
    $archive_title =  sprintf(__('Články publikované v roku %s', 'kapital'), '<span>' . get_the_date('Y') . '</span>');
    $breadcrumbs[0][2] = true;
} else {
    $archive_title = __('Najnovšie články', 'kapital');
    $breadcrumbs[0][2] = true;
}
/** render breadcrumbs */
echo kapital_breadcrumbs($breadcrumbs, 'container');

/** MAIN */ ?>
<main class="main container" role="main" id="main">

    <?php /** archive title  */ 

    $header_classes = 'archive-header alignwide mb-5" role="heading';

    if ($is_term_archive) {
        if ($queried_object->slug === "le-monde-diplomatique") {
            echo '<header class="' .  $header_classes . '">';
            echo '<h1 id="le-monde-archive-header-logo" class="alignnormal mb-6 text-center"><a target="_blank" href="https://www.monde-diplomatique.fr/"><img class="w-100" alt="' . $queried_object->name . '" src="' . get_stylesheet_directory_uri() .  '/assets/images/le_monde_logo.svg"></img></a></h1>';
            echo '</header>';
            if (get_query_var('paged') < 2) {
                $editorial_query = new WP_Query(
                    array(
                        'post_type'              => 'post',
                        'title'                  => 'Editoriál',
                        'posts_per_page'         => 1,
                        'no_found_rows'          => true,
                        'ignore_sticky_posts'    => true,
                        'update_post_term_cache' => false,
                        'update_post_meta_cache' => false,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'partner',
                                'field' => 'term_id',
                                'terms' => $queried_object_id,
                            )
                        )
                    )
                );
                wp_reset_postdata();
                while ($editorial_query->have_posts()) : $editorial_query->the_post();
                    get_template_part('template-parts/archive-editorial-post', null, array('queried_object_id' => $queried_object_id));
                    $editorial_post_id = $post->ID;
                endwhile;
            }
        } else {
            echo '<header class="' .  $header_classes . '">';
            echo kapital_bubble_title($archive_title, 1, 'term-title');
        }

        if ($queried_object->description !== "") {
            echo '<div class="term-description h4 text-center ff-grotesk fw-bold lh-sm">';
            echo wpautop($queried_object->description, true);
            echo '</div>';
        }
    } else {
        echo '<header class="' .  $header_classes . '">';
        echo kapital_bubble_title($archive_title, 1, 'term-title');
    }
    echo '</header>'; ?>

    <?php /** filters */
    if ($is_term_archive) {
        echo kapital_post_filters($is_general_post_archive, $is_term_archive, false, $queried_object_id, $taxonomy);
    } else {
        echo kapital_post_filters($is_general_post_archive, $is_term_archive, false, $queried_object_id);
    }


    if ($wp_query->have_posts()) :
        //justify post center when too few posts
        if ($wp_query->post_count < 4) {
            $justify_class = " justify-content-center";
        } else {
            $justify_class = " justify-content-start";
        }

    ?>
        <div class="alignwider">
            <div class="row gy-6 gx-3<?php echo $justify_class ?>">
                <?php while (have_posts()) : the_post();
                    get_template_part('template-parts/archive-single-post', null, array('queried_object_id' => $queried_object_id));
                endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php echo kapital_pagination(); ?>
</main>

<?php get_footer();
