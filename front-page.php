<?php

get_header(); 
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);

?>

<main <?php post_class('container main-content'); ?> id="main">
        <div id="front-page-content">
                <?php while (have_posts()) : the_post();
                        the_content();
                endwhile; ?>
        </div>
</main>

<?php
get_footer(null, array('render_settings' => $render_settings));
