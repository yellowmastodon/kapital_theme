<?php

defined( 'ABSPATH' ) || exit;
global $post;

$args =  array(
    'post_type'     => 'redakcia',
    'numberposts'   =>  -1,
    'orderby'       => 'date',
    'order'         => 'DESC',
    'exclude'  => array($post->ID),
);
$other_redakcia_posts = get_posts($args);?>

 <?php if (!empty($other_redakcia_posts)) :
    ?>
    <footer class="redakcia-footer mt-6 alignwide">
    <h2 class="mb-6 text-center"><?=__("Ďaľšie členstvo redakcie", "kaptial")?></h2>

            <div class="row gy-6 gx-3">
                <?php
                foreach ($other_redakcia_posts as $redakcia ):
                    get_template_part('template-parts/archive-single-redakcia', null, array('heading_level' => 3, 'post' => $redakcia ));
                endforeach; ?>
            </div>
    </footer>
    <?php endif;
