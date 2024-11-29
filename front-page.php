<?php

get_header(); ?>

<main role="main" <?php post_class('mt-5 main'); ?>>
    <div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>


        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
