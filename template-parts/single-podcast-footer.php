<?php
/**
 * displays recommended podcast on single podcast page
 */
defined( 'ABSPATH' ) || exit;

if (isset($args['custom_taxonomies']) && isset($args['filtered_terms']) && !empty($args['filtered_terms'])):
    $custom_taxonomies = $args['custom_taxonomies'];
    $filtered_terms = $args['filtered_terms'];
    $recommend_terms = array();
    /**
     * get recommendation terms by order of taxonomy importance
     * Right now we only get one taxonomy but that might change
     */
    foreach ($custom_taxonomies as $custom_taxonomy) {
        if (isset($filtered_terms[$custom_taxonomy])){
            if (!empty($filtered_terms[$custom_taxonomy])) {
                $recommend_terms = $filtered_terms[$custom_taxonomy];
                break;
            }
        }
    }
    if (!empty($recommend_terms)):
        $recommend_term = $recommend_terms[rand(0, count($recommend_terms) - 1)]; //pick random term if more available
        $recommend_podcasts = get_posts(
            array(
                'post_type'     => 'podcast',
                'numberposts'   =>  4,
                'order'         => 'DESC',
                'exclude'  => array($post->ID),
                'orderby'       => 'date',
                'tax_query'     =>  array(
                    array(
                        'taxonomy' => $recommend_term->taxonomy,
                        'field' => 'id',
                        'terms' => $recommend_term->term_id,
                        'operator' => 'IN'
                    )
                )
            )
        );
    endif;
    if (!empty($recommend_podcasts)):?>
        <footer class="post-footer mt-6 alignwide">
            <?php
            echo '<p class="ff-grotesk text-uppercase mb-1 text-center fw-bold alignwide">' . __('Najnovšie podcasty zo série:', 'kapital') . '</p>';
            echo kapital_bubble_title($recommend_term->name, 2, 'alignwide');
            ?>
            <div>
                <?php foreach ($recommend_podcasts as $rec_podcast) {
                    get_template_part('template-parts/archive-single-podcast', null, array('queried_object_id' => $recommend_term->term_id, 'post' => $rec_podcast));
                } ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?= get_term_link($recommend_term) ?>" class="btn btn-secondary"><?= __('Zobraziť všetky', 'kapital') ?><svg class="icon-square ms-2">
                        <use xlink:href="#icon-arrow-right"></use>
                </svg></a>
            </div>
        </footer>
<?php endif;
//get newer and older podcast, if podcast has no taxonomy
else:?>
    <footer class="post-footer mt-6 alignwide">
    <?php
    $next_podcast = get_next_post();
    $prev_podcast = get_previous_post();
    if ($next_podcast !== "" && !is_null($next_podcast)){
        echo '<p class="ff-grotesk text-uppercase mb-1 lh-sm text-center fw-bold alignwide">' . __('Ďalší podcast', 'kapital') . '</p>';
        get_template_part('template-parts/archive-single-podcast', null, array(null, 'post' => $next_podcast));   
    }
    if ($prev_podcast !== "" && !is_null($prev_podcast)){
        echo '<p class="ff-grotesk text-uppercase mb-1 lh-sm text-center fw-bold alignwide">' . __('Predošlý podcast', 'kapital') . '</p>';
        get_template_part('template-parts/archive-single-podcast', null, array(null, 'post' => $prev_podcast));   
    }
    ?>
</footer>

<?php endif;
