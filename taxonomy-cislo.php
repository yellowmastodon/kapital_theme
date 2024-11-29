<?php get_header();
//var_dump(get_taxonomies(array('public'=>'true'), 'objects'));
//get current queried object
global $wp_query;
$queried_object_id = get_queried_object_id();
$taxonomy = get_query_var('taxonomy');
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
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $queried_object_id,
            )
        )
    )
);
wp_reset_postdata();

/** render breadcrumbs */
global $kapital_taxonomies_with_list_pages;
$list_page = get_page_by_path($kapital_taxonomies_with_list_pages[$taxonomy]);

echo kapital_breadcrumbs(array(
    [ __('Články', 'kapital'), get_post_type_archive_link('post')],
    [get_the_title($list_page), get_page_link($list_page) ]
    ), 'container');
?>
<main class="main container" role="main" id="main">
    <header class="archive-header alignwide mb-5 mt-4 mt-md-0" role="heading">
        <?php $original_archive_title = get_queried_object()->name;
        $formatted_title = kapital_get_issue_title_year_month($original_archive_title);

        if ($formatted_title[1] !== "") echo '<p class="fw-bold archive-above-title mb-1 h1 text-center ff-grotesk text-uppercase">' . $formatted_title[1] . '</p>';
        echo kapital_bubble_title($formatted_title[0], 1, 'mb-4 term-title'); ?>
    </header>
    
    <?php
    $hashtag = get_field('hashtag', 'cislo_' . $queried_object_id);
    if (isset($hashtag)):
        if ($hashtag !== ""):
            ?><p class="hashtag fw-bold ff-grotesk text-center my-4"><?php echo $hashtag?></p><?php
        endif;
    endif;

    $issue_cover = get_field('cover', 'cislo_' . $queried_object_id);
    if (isset($issue_cover)):
        echo kapital_responsive_image($issue_cover, "(max-width: 640px) 95vw, (max-width: 1400px) 600px, 700px", true, 'rounded w-100', 'issue-cover alignnormal my-6', __('Obálka čísla: ', 'kapital') . $original_archive_title );      
    else:
        $featured_image = get_field('featured_image', 'cislo_' . $queried_object_id);
        if (isset($featured_image)) echo kapital_responsive_image($featured_image, "(max-width: 640px) 95vw, (max-width: 1400px) 600px, 700px", true, 'rounded w-100', 'issue-cover alignwide my-6', __('Obálka čísla: ', 'kapital') . $original_archive_title );      

    endif;


    if ($wp_query->have_posts()) :
        //justify post center when too few posts
        if ($wp_query->post_count < 4) {
            $justify_class = " justify-content-center";
        } else {
            $justify_class = " justify-content-start";
        }

    ?>
        <section class="alignwider mt-4">

            <?php
            $editorial_post_id = 0;
            while ($editorial_query->have_posts()) : $editorial_query->the_post();
                get_template_part('template-parts/archive-editorial-post', null, array('queried_object_id' => $queried_object_id));
                $editorial_post_id = $post->ID;
            endwhile; ?>
            <div class="row gx-3<?php echo $justify_class ?>">
                <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                    if ($post->ID !== $editorial_post_id){
                        get_template_part('template-parts/archive-single-post', null, array('queried_object_id' => $queried_object_id));
                    }
                endwhile; ?>
            </div>
        </section>
        <section class="ending-text alignnormal">
            <?php 
            $ending_text = get_field('ending_text', 'cislo_' . $queried_object_id);
            if (isset($ending_text)):
                if ($ending_text !== ""):
                    echo $ending_text;
                endif;
            endif;
            
            ?>
        </section>
    <?php endif; ?>
</main>

<?php get_footer();
