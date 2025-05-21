<?php get_header();
//options to hide or display parts of the post
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);

//show/hide auto inserted ads controlled by this class
$ad_rendering_class = "";
if ($render_settings["show_ads"]) $ad_rendering_class = " show-ads";
if (!$render_settings["show_support"]) $ad_rendering_class .= " show-support";


/** render breadcrumbs */
echo kapital_breadcrumbs([[__("Podcasty", "kapital"), get_post_type_archive_link('podcast')]], 'container')

/** MAIN */
?><main class="main container<?php echo $ad_rendering_class ?>" role="main" id="main">
    <?php while (have_posts()) : the_post();

        //taxonomies to display in posts, ordered by render priority
        $custom_taxonomies = ['podcast-seria', 'partner'];
        $filtered_terms = get_and_reorganize_terms($post->ID, $custom_taxonomies); ?>

        <article <?php post_class(["main-content"]); ?>>
            <?php

            /** render post terms */
            if ($render_settings["show_categories"] && !empty($filtered_terms)): ?>
                <div class="post-terms mb-4 gy-2 row ff-grotesk text-uppercase fs-small text-center flex-wrap justify-content-center">
                    <?php foreach ($custom_taxonomies as $custom_taxonomy):
                        //autorstvo rendered separately                        
                        foreach ($filtered_terms[$custom_taxonomy] as $term):
                            //'tematicky' tag used for posts which are part of the printed issue
                            if ($term->slug === 'tematicky'):
                                if (isset($filtered_terms['cislo'][0])): ?>
                                    <div class="col-auto"><a class="marker-black" href="<?php echo get_term_link($filtered_terms['cislo'][0]); ?>"><?php echo $term->name ?></a></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="col-auto"><a class="marker-black" href="<?php echo get_term_link($term); ?>"><?php echo $term->name ?></a></div>
                    <?php endif;
                        endforeach;
                    endforeach;
                    ?>
                </div>
            <?php endif;
            /**
             * Render podcast header
             * if hidden, let's keep h1 tag, so only visually-hidden
             */ ?>
            <header class="post-header mb-4<?php if (!$render_settings["show_title"]) echo ' visually-hidden'; ?>">
                <?php
                echo kapital_bubble_title(get_the_title(), 1, 'mb-3 mb-sm-4 post-title alignwide');
                $secondary_title = get_post_meta($post->ID, '_secondary_title', true);
                if (!empty($secondary_title)): ?>
                    <p class="secondary-title ff-grotesk alignnormal text-center fw-bold">
                        <?php echo $secondary_title ?>
                    </p>
                <?php endif; ?>
            </header>
            <?php //container with views, author, publish date, featured image and podcast links ?>
            <div class="alignwide mb-5">
                <?php //container with views, and publish date 
                if ($render_settings["show_views"] && $render_settings["show_date"]): ?>
                    <div class="row align-items-end mb-1 justify-content-between">
                        <?php
                        /**
                         * Render post views
                         * if hidden, let's keep the empty div to not break the layout
                         */

                        $date_element_classes = 'post-date col-6 col-sm-2 order-2 order-sm-1 ff-sans text-gray fs-small';
                        if ($render_settings["show_date"]):
                             echo get_publish_datetime_element($post, $date_element_classes);
                             else:?>
                                <div class="<?=$date_element_classes?>"></div>
                            <?php endif;

                         /**
                         * Render post views
                         * if hidden, let's keep the empty div to not break the layout
                         */
                        ?>
                        <div class="post-views col-6 col-sm-2 order-3 col-2 ff-sans text-gray text-end fs-small opacity-0" data-id="<?php echo $post->ID ?>"><?php
                                                                                                                                                                if ($render_settings["show_views"]): ?>
                                <svg>
                                    <use xlink:href="#icon-views"></use>
                                </svg>
                                <span class="visually-hidden"><?php echo __('Počet zhliadnutí:', 'kapital') ?></span>
                                <span class="number"></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php //end row above featured image
                endif; 
                /**
                 * FEATURED IMAGE
                 * disabled by default
                 */
                if ($render_settings["show_featured_image"]):
                    $thumbnail_id = get_post_thumbnail_id();
                    if (is_int($thumbnail_id) && $thumbnail_id !== 0) {
                        echo kapital_responsive_image($thumbnail_id, "(max-width: 900px) 95vw, (max-width: 1649px) 800px, (max-width: 1919px) 900px, 1000px", true, 'rounded');
                    }
                endif;

                /** PODCAST LINKS
                 * links to podcast on various platforms stored in metadata
                 */
                //get podcast links
                $podcast_links = json_decode(get_post_meta($post->ID, '_podcast_links', true));
                //check if podcasts links array is set
                if (is_array($podcast_links)) {
                    //build it out the html string for links first, to see, if it will not result in empty string
                    $podcast_links_html = "";
                    foreach ($podcast_links as $podcast_link) {
                        if (isset($podcast_link->name) && isset($podcast_link->url) && $podcast_link->name !== "" && $podcast_link->url !== "") {
                            $podcast_links_html .= '<div class="col"><a class="btn btn-block btn-secondary" target="_blank" href="' . $podcast_link->url . '">' . $podcast_link->name . '<svg class="icon-square ms-2"><use xlink:href="#icon-arrow-up-right"></use></svg></a></div>';
                        }
                    }
                    //if not empty add wrapper
                    if ($podcast_links_html !== "") {
                        $podcast_links_html = '<div class="my-5"><div class="row gx-2 gy-2 justify-content-between flex-wrap">' . $podcast_links_html . '</div></div>';
                        echo $podcast_links_html;
                    }
                } ?>
            </div><?php //end of container with views, author, publish date and featured image?>            

            <div id="podcast-content" class="podcast-content ff-grotesk">
                <?php

                /**
                 * Render podcast content
                 * insert ad for support by default 
                 */
                the_content(); ?>

            </div>


            <?php
            if ($render_settings["show_footer"]):
                //request only series, not partners as recommendation
                get_template_part('template-parts/single-podcast-footer', null, array('custom_taxonomies' => ['podcast-seria'], 'filtered_terms' => $filtered_terms));
            endif; ?>

        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(null, array('render_settings' => $render_settings)); ?>