<?php get_header();
//options to hide or display parts of the post
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
global $is_woocommerce_site;
//show/hide auto inserted ads controlled by this class
$ad_rendering_class = "";
if ($render_settings["show_ads"]) $ad_rendering_class = " show-ads";
if ($render_settings["show_support"]) $ad_rendering_class .= " show-support";


/** render breadcrumbs */
if ($render_settings["show_breadcrumbs"]) {
    $breadcrumbs = array();
    if ($post->post_type === 'page') {
        if ($is_woocommerce_site) {
            $breadcrumbs[] = [__("E-shop", "kapital"), get_permalink(wc_get_page_id('shop'))];
            if (is_checkout()){
                $breadcrumbs[] = [get_the_title(wc_get_page_id('cart')), get_permalink(wc_get_page_id('cart'))];
                $breadcrumbs[] = [get_the_title(), get_the_permalink(), true];
            } else {
                if ($post->post_parent){
                    //only retrieves one parent, but fuck it, lets not query again
                    $parent = get_post($post->post_parent);
                    $breadcrumbs[] = [$parent->post_title, get_the_permalink($parent)];
                }
                $breadcrumbs[] = [get_the_title(), get_the_permalink(), true];
            }
        } else {
            if ($post->post_parent){
                //only retrieves one parent, but fuck it, lets not query again
                $parent = get_post($post->post_parent);
                $breadcrumbs[] = [$parent->post_title, get_the_permalink($parent)];
            }
            $breadcrumbs[] = [get_the_title(), get_the_permalink(), true];
        }
    } else {
        $breadcrumbs[] = [__("Články", "kapital"), get_post_type_archive_link('post')];
    }
    echo kapital_breadcrumbs($breadcrumbs, "container");
}


/** MAIN */
?>
<main class="main container<?php echo $ad_rendering_class ?>" role="main" id="main">
    <?php while (have_posts()) : the_post();

        //taxonomies to display in posts, ordered by render priority

        if ($post->post_type === 'post') {
            $custom_taxonomies = ['cislo', 'seria', 'jazyk', 'partner', 'zaner', 'rubrika', 'autorstvo'];
            $filtered_terms = get_and_reorganize_terms($post->ID, $custom_taxonomies);
        } else {
            $filtered_terms = array();
            $custom_taxonomies = array();
        } ?>

        <article <?php post_class(["main-content"]); ?>>
            <?php

            /** render post terms */
            global $is_woocommerce_site;
            //render_settings categories are false for page
            if ($render_settings["show_categories"]): ?>
                <div class="post-terms mb-4 gy-2 row ff-grotesk text-uppercase fs-small text-center flex-wrap justify-content-center">
                    <?php foreach ($custom_taxonomies as $custom_taxonomy):
                        //autorstvo rendered separately                        
                        if (!empty($filtered_terms[$custom_taxonomy]) && $custom_taxonomy !== 'autorstvo'):
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
                        endif;
                    endforeach;
                    ?>
                </div>
            <?php endif;
            /**
             * Render article header
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

            <?php
            /** Links to child pages
             * 
             */
            if ($post->post_type === 'page' && $render_settings["show_filters"] === true){
               echo kapital_post_filters(false, false, true, $post->ID, "", "", false);
            }

            /** container with views, author, publish date and featured image 
             * all off by default for page
            */
            if ($render_settings["show_views"] || $render_settings["show_date"] || $render_settings["show_author"] || $render_settings["show_featured_image"]): ?>
                <div class="alignwide mb-5 header-bottom-container">
                    <?php //container with views, and publish date and author
                    if ($render_settings["show_views"] && $render_settings["show_date"] && $render_settings["show_author"]): ?>
                        <div class="row align-items-end justify-content-between mb-1">
                            <?php
                            /**
                             * Render post views
                             * if hidden, let's keep the empty div to not break the layout
                             */ ?>
                            <div class="post-date col-6 col-sm-2 order-2 order-sm-1 ff-sans text-gray fs-small">
                                <?php
                                if ($render_settings["show_date"]):
                                    the_date();
                                endif; ?>

                            </div>
                            <?php
                            /**
                             * Render post author(s)
                             * the div can be removed, container is justify-content-between
                             */
                            if ($render_settings["show_author"]):
                                if (!empty($filtered_terms['autorstvo'])): ?>
                                    <p class="post-authors col-12 col-sm order-1 order-sm-2 mb-3 mb-sm-0 text-center ff-grotesk">
                                        <?php
                                        foreach ($filtered_terms['autorstvo'] as $key => $author):
                                            if ($key !== 0) echo ", "; ?>
                                            <a href="<?php echo get_term_link($author); ?>"><?php echo $author->name; ?></a>
                                        <?php endforeach; ?>
                                        </p><?php
                                        endif;
                                    endif;
                                    /**
                                     * Render post views
                                     * if hidden, let's keep the empty div to not break the layout
                                     */
                                            ?><div class="post-views col-6 col-sm-2 order-3 col-2 ff-sans text-gray text-end fs-small opacity-0" data-id="<?php echo $post->ID ?>"><?php
                                                                                                                                                                                    if ($render_settings["show_views"]): ?>
                                    <svg>
                                        <use xlink:href="#icon-views"></use>
                                    </svg>
                                    <span class="visually-hidden"><?php echo __('Počet zhliadnutí:', 'kapital') ?></span>
                                    <span class="number"></span>
                                <?php endif; ?>
                            </div><?php //end row above featured image
                    endif; ?>
                        </div>
                        <?php
                        //featured image
                        if ($render_settings["show_featured_image"]):
                        $thumbnail_id = get_post_thumbnail_id();
                        if (is_int($thumbnail_id) && $thumbnail_id !== 0) echo kapital_responsive_image($thumbnail_id, "(max-width: 900px) 95vw, (max-width: 1649px) 800px, (max-width: 1919px) 900px, 1000px", true, 'rounded w-100');
                        endif; ?>
                </div><?php //end of container with views, author, publish date and featured image 
            endif;       ?>
            <div id="post-content">
                <?php
                /**
                 * Render post content
                 * insert ad for support by default 
                 */
                the_content(); ?>
            </div>
            <?php
            if ($render_settings["show_footer"]):
                get_template_part('template-paprts/single-post-footer', null, array('custom_taxonomies' => $custom_taxonomies, 'filtered_terms' => $filtered_terms));
            endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>