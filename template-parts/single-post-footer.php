<?php
/**
 * displays recommended posts on single post page
 */
defined( 'ABSPATH' ) || exit;

if (isset($args['custom_taxonomies']) && isset($args['filtered_terms'])):
    $custom_taxonomies = $args['custom_taxonomies'];
    $filtered_terms = $args['filtered_terms'];
    $recommend_terms = array();
    //shift partner taxonomy to last 
    $custom_taxonomies = array_diff($custom_taxonomies, array('partner'));
    $custom_taxonomies[] = 'partner';
    //get recommendation terms by order of taxonomy importance
    foreach ($custom_taxonomies as $custom_taxonomy) {
        if (isset($filtered_terms[$custom_taxonomy])){
            if (!empty($filtered_terms[$custom_taxonomy] && $custom_taxonomy !== 'autorstvo')) {
                if ($custom_taxonomy === 'cislo') {
                    $is_thematical = false;  //if issue, check if post is thematical for issue
                    foreach ($filtered_terms['rubrika'] as $rubrika) {
                        if ($rubrika->slug === 'tematicky') $is_thematical = true;
                    }
                    if ($is_thematical) {
                        $recommend_terms = $filtered_terms['cislo'];
                        break;
                    }
                } elseif ($custom_taxonomy === 'zaner') {
                    $is_editorial = false;  //if issue, check if post is thematical for issue
                    foreach ($filtered_terms['zaner'] as $zaner) {
                        if ($zaner->slug === 'editorialy' && !empty($filtered_terms['cislo'])){
                            $recommend_terms = $filtered_terms['cislo'];
                            break;
                        }  else {
                            $recommend_terms = $filtered_terms[$custom_taxonomy];
                            break;
                        }
                    }
                } else {
                    $recommend_terms = $filtered_terms[$custom_taxonomy];
                    break;
                }
            }
        }
    }
    $recommended_posts_no = 0;
    if (!empty($recommend_terms)):
        $recommend_term = $recommend_terms[rand(0, count($recommend_terms) - 1)];
        $recommended_posts = get_posts(
            array(
                'numberposts'   =>  12,
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
        //var_dump($recommended_posts);
        //check if we have enough posts
        $recommended_posts_no = count($recommended_posts);
        $count = 4;
        if ($recommended_posts_no < $count) {
            $count = $recommended_posts_no;
        }
        //pick random 4 (or less) posts
    //var_dump($recommended_posts_keys);
    endif;
    if ($recommended_posts_no > 0): 
        if ($recommended_posts_no > 1){
            $recommended_posts_keys = array_rand($recommended_posts, $count); 
        } else { 
            $recommended_posts_keys = [0];
        }
        ?>

        <footer class="post-footer mt-6 alignwider">
            <?php
            echo '<p class="ff-grotesk text-uppercase mb-1 text-center fw-bold alignwide">' . __('Podobné články', 'kapital') . '</p>';
            echo kapital_bubble_title($recommend_term->name, 2, 'alignwide');
            ?>
            <div class="row gy-6 text-left gx-3<?php if ($recommended_posts_no < 3) echo " justify-content-center"?>">
                <?php 
                foreach ($recommended_posts_keys as $rec_post_key) {
                    //var_dump($recommended_posts[$rec_post_key]->post_title);
                    //setup_postdata($recommended_posts[$rec_post_key]);
                    get_template_part('template-parts/archive-single-post', null, array('queried_object_id' => $recommend_term->term_id, 'post' => $recommended_posts[$rec_post_key], "heading_level" => 3));
                    //wp_reset_postdata();
                } ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?= get_term_link($recommend_term) ?>" class="btn btn-secondary"><?= __('Zobraziť všetky', 'kapital') ?><svg class="icon-square ms-2">
                        <use xlink:href="#icon-arrow-right"></use>
                    </svg></a>
            </div>
        </footer>
<?php endif;
endif;
