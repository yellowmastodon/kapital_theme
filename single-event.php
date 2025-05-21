<?php get_header();
$meta = get_metadata('post', $post->ID, '', true);
$event_date_start = $meta["_event_date_start"][0];
$event_date_end = $meta["_event_date_end"][0];
$event_date_string_object = json_decode($meta["_event_date_string"][0]);
$event_date_string = $event_date_string_object->displayDate;
$event_date_format = $event_date_string_object->format;
$event_locations = kapital_get_event_location_string($meta["_event_location"][0]);


//options to hide or display parts of the post
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
//show/hide auto inserted ads controlled by this class
$ad_rendering_class = "";
if ($render_settings["show_ads"]) $ad_rendering_class = " show-ads";
if ($render_settings["show_support"]) $ad_rendering_class .= " show-support";

$has_location = $render_settings["show_event_location"] && $event_locations !== "" ? true : false;

//var_dump( $meta);

/** render breadcrumbs */
if ($render_settings["show_breadcrumbs"]) {
    $breadcrumbs = array();
    $breadcrumbs[] = [__("Podujatia", "kapital"), get_post_type_archive_link('event')];
    echo kapital_breadcrumbs($breadcrumbs, "container");
}

/** MAIN */
?>
<main class="main container<?php echo $ad_rendering_class ?>" role="main" id="main">
    <?php while (have_posts()) : the_post();?>

        <article <?php post_class(["main-content"]); ?>>
            <?php

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
            /** container with date, and place 
             */
            if ($has_location || $render_settings["show_date"] || $render_settings["show_featured_image"]): ?>
                <div class="alignwide mb-5 header-bottom-container"><?php //container with date, and place
                    
                    if ($has_location || $render_settings["show_date"]): ?>
                        <div class="row align-items-end justify-content-between mb-1 lh-sm"><?php                    
                        /**
                         * Render event location
                         * if hidden, let's keep the empty div to not break the layout
                         */
                        if ($has_location):?>
                            <p class="col-12 mb-1 mb-sm-0 col-sm-auto text-start ff-grotesk text-red fw-bold"><?php
                            echo $event_locations;
                            ?></p>
                        <?php 
                        
                        endif;

                        /**
                         * Render post date
                         * if hidden, let's keep the empty div to not break the layout
                         */
                        $date_element_classes = 'event-date col-12 ff-grotesk text-red text-uppercase fw-bold';
                        $date_element_classes .= $has_location ? ' text-sm-end col-sm-auto' : ' text-center';
                        if ($render_settings["show_date"]){
                            echo get_publish_datetime_element_event($event_date_start, $event_date_format, $event_date_string, $date_element_classes);
                        }
                    ?></div><?php //end row above featured image
                    endif; ?>
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
                get_template_part('template-parts/single-event-footer', null);
            endif; ?>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(null, array('render_settings' => $render_settings)); ?>