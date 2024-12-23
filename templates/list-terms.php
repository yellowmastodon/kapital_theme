<?php /* Template Name: dadaw Template */

global $kapital_taxonomies_with_list_pages;
$current_taxonomy = array_search($post->post_name, $kapital_taxonomies_with_list_pages);

get_header();

/** render breadcrumbs */
$breadcrumbs = array();
if ($current_taxonomy === 'podcast-seria'){
    $breadcrumbs[] = [__('Podcasty', 'kapital'), get_post_type_archive_link('podcast')];
} else {
    $breadcrumbs[] = [__('Články', 'kapital'), get_post_type_archive_link('post')];
}
echo kapital_breadcrumbs($breadcrumbs, 'container');?>

<main class="main container" role="main" id="main">

    <header class="mb-6">
        <?php echo kapital_bubble_title(get_the_title(), 1, 'term-list-title');?>
    </header>
    <?php
$terms = get_terms( array(
    'taxonomy'   => $current_taxonomy,
    'hide_empty' => true,
    'order_by' => 'name',
    'order' => 'ASC',
    'paged' => false,
    'get' => '',
    'hide_empty' => true,
));
//var_dump($issues);
if (!empty($terms)):?>
    <section class="row alignwider mt-5">
        <?php foreach($terms as $term):
            //exclude 'tematicky'
            if ($term->slug !== 'tematicky'):?>
                <div class="archive-item col-12 archive-item col-sm-6 col-md-4 ff-grotesk text-center text-uppercase mb-6">
                    <a class="archive-item-link text-decoration-none" href="<?php echo get_term_link($term);?>">
                    <?php
                        $featured_image = get_field('featured_image', $current_taxonomy . '_' . $term->term_id);
                        //var_dump($featured_image);
                        if (!$featured_image) $featured_image = get_field('cover', $current_taxonomy . '_' . $term->term_id);
                        if (isset($featured_image) && $featured_image):
                            echo kapital_responsive_image($featured_image, "(max-width: 599px) 96vw, (max-width: 899px) 48vw, (max-width: 1199px) 33vw, (max-width: 1399px) 300px, 350px", false, "archive-item-image rounded w-100");
                        endif;
                        ?>
                        <h2 class="h3 mt-2 mb-0 red-outline-hover" data-text="<?=$term->name?>"><?=$term->name?></h2>
                    </a>
                </div>
            <?php endif;    
        endforeach; ?>
    </section>
<?php endif;?>

</main>
<?php
//var_dump($first_issue);


get_footer();

?>

