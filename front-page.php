<?php

get_header(); ?>

<main role="main" <?php post_class('mt-5 main-content container'); ?>>

        <?php while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>


        <?php endwhile; ?>
</main>

<?php get_footer(); ?>
