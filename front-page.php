<?php

get_header(); ?>

<main role="main" <?php post_class('container main-content'); ?> id="main">

        <?php while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>


        <?php endwhile; ?>
</main>

<?php get_footer(); ?>
