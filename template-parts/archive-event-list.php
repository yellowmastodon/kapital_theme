<?php

$justify_class = $args['query']->post_count < 3 ? " justify-content-center" : " justify-content-start";

?>

<ul role="list" class="list-unstyled row mb-0 gy-5 gx-3<?php echo $justify_class ?>">
     <?php while ($args['query']->have_posts()) : $args['query']->the_post();
            /**
             * we check for thumbnail image here, to have alternating placeholders
             */
            
            $thumbnail_image = kapital_get_event_thumbnail($post->ID);
            get_template_part(
                'template-parts/archive-single-event',
                null,
                isset($args['are_old_events']) && $args['are_old_events']
                ? array(
                    'is_old_event' => true,
                    'heading_level' => $args['heading_level'],
                    'thumbnail_img' => $thumbnail_image
                    )
                : array(
                    'heading_level' => $args['heading_level'],
                    'thumbnail_img' => $thumbnail_image
                ));
        endwhile; ?>
</ul>
<?php 