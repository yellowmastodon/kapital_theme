<?php

get_header(); ?>

<main role="main" <?php post_class('container main-content'); ?> id="main">
        <div id="front-page-content">
        <?php while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>


        <?php endwhile; ?>
        </div>
</main>

<?php
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
get_footer(null, array('render_settings' => $render_settings)); ?>