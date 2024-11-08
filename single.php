<?php get_header(); ?>

<main class="main container" role="main" id="main">
    <nav aria-label="mininavigácia" class="my-2 ff-grotesk">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo get_home_url()?>"><?php echo __("Domov", "kapital")?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo get_post_type_archive_link('post')?>"><?php echo __("Články", "kapital")?></a></li>
        </ol>
    </nav>
        <?php while ( have_posts() ) : the_post();
         
        //taxonomies to display in posts, ordered by render priority
        $custom_taxonomies = ['cislo', 'seria', 'jazyk', 'partner', 'zaner', 'rubrika', 'autorstvo'];
        $post_terms = wp_get_post_terms($post->ID, $custom_taxonomies);
        //reorganize the terms for easier rendering
        $filtered_terms = [];        
        foreach($custom_taxonomies as $custom_taxonomy){
            $filtered_terms[$custom_taxonomy]=[];
        }                          
        foreach ($post_terms as $post_term){
            array_push($filtered_terms[$post_term->taxonomy], $post_term);
        }
        ?>

            <article <?php post_class(["main-content"]); ?>>
                <div class="post-terms row ff-grotesk text-uppercase fs-small text-center flex-wrap justify-content-center">
                    <?php foreach($custom_taxonomies as $custom_taxonomy){
                        //autorstvo rendered separately                        
                        if (!empty($filtered_terms[$custom_taxonomy]) && $custom_taxonomy !== 'autorstvo'){
                            foreach($filtered_terms[$custom_taxonomy] as $term):?>
                                 <div class="col-auto"><a class="marker-black" href="<?php
                                 //'tematicky' tag used for posts which are part of the printed issue
                                 if($term->slug === 'tematicky'){
                                    echo get_term_link($filtered_terms['cislo'][0]);
                                 } else {
                                    echo get_term_link($term);
                                 }
                                 ?>"><?php echo $term->name?></a></div>
                            <?php endforeach;
                        }
                    }
                    ?>
                </div>
                <header class="post-header alignwide" role="heading">                   
                    <?php echo kapital_bubble_title( get_the_title(), 1, 'post-title');
                    $secondary_title = get_post_meta($post->ID, '_secondary_title', true);
                    if (!empty($secondary_title)):?>
                    <p class="secondary-title ff-grotesk text-center fw-bold mt-4">
                    <?php echo $secondary_title?>
                    </p>
                    <?php endif;?>
                </header>
                <div class="alignwide">
                <div class="row align-items-end mb-1">
                    <div class="col-6 col-sm-2 order-2 order-sm-1 ff-sans text-gray fs-small post-views"><div class="visually-hidden"><?php echo __('Počet zhliadnutí:', 'kapital')?></div><?php echo do_shortcode('[koko_analytics_counter days="36500"]'); ?><svg><use xlink:href="#icon-views"></use>
                    </svg></div>
                    <div class="col-12 col-sm order-1 order-sm-2  mb-4 mb-sm-0 text-center ff-grotesk post-authors">
                        <?php if (!empty($filtered_terms['autorstvo'])):
                            foreach($filtered_terms['autorstvo'] as $key => $author):
                                if($key !== 0){
                                    echo ", ";
                                }
                                ?><a class="text-uppercase" href="<?php echo get_term_link($author);?>"><?php
                                    echo get_term_meta($author->term_id, "_author_full_name", true)
                                ?></a><?php
                            endforeach;
                        endif;?>
                    </div>
                    <div class="col-6 col-sm-2 order-3 col-2 ff-sans text-gray text-end fs-small"><?php the_date()?></div>
                </div>

                <?php $thumbnail_id = get_post_thumbnail_id();
                if (is_int($thumbnail_id) && $thumbnail_id !== 0){
                    kapital_responsive_image($thumbnail_id, 'alignwide', 'rounded');
                }?>
                </div>
                <?php //container for ad inserter?>
                <div id="post-content">
                <?php          
                the_content(); ?>
                </div>
                <footer class="post__footer">
                    <p class="post__date"><time><?php echo human_time_diff(strtotime($post->post_date)) . ' ' . __('ago'); ?></time></p>
                    <p class="post__comments"><?php comments_popup_link(__('No comments yet'), __('1 comment'), __('% comments')); ?></p>
                </footer>

            </article>

        <?php endwhile; ?>

</main>

<?php get_footer(); ?>
