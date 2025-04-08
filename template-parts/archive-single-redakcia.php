<?php
defined( 'ABSPATH' ) || exit;
global $post;
//get post from args outside query
if (isset($args['post'])){
    $post = $args['post'];
}

$heading_level = 2;
if (isset($args['heading_level'])){
    $heading_level = $args['heading_level'];
    if ($heading_level > 6){
        $heading_level = 6;
    }
}?>

<article <?php post_class(["ff-grotesk text-center archive-item archive-item-redakcia col-12 col-sm-6 col-md-4 archive-redakcia-item"], $post) ?>>
    <a class="archive-item-link text-decoration-none" href="<?= get_the_permalink() ?>">
        <?php $thumbnail_image_id = get_post_thumbnail_id($post->ID);
        if ($thumbnail_image_id) {
            echo kapital_responsive_image($thumbnail_image_id, "", false, "rounded archive-item-image redakcia-portrait w-100");
        } else {
            echo '<div class="rounded w-100 archive-item-image redakcia-portrait placeholder"></div>';
        }

        $post_title = get_the_title();
        $secondary_title = get_post_meta($post->ID, '_secondary_title', true);?>
        
        <<?='h'.$heading_level?> class="h3 red-outline-hover mt-3 mb-2" data-text="<?= $post_title ?>">
            <?=$post_title?>
        </<?='h'.$heading_level?>>

        <?php if ($secondary_title && $secondary_title !== ""): ?>
            <p class="item-excerpt lh-sm"><?= $secondary_title ?></p>
        <?php endif; ?>
    </a>
</article>