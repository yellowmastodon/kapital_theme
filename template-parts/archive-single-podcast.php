<?php global $post;
$post_permalink = get_post_permalink();
$post_title = get_the_title();
$render_settings = kapital_get_render_settings($post->ID);

?>


<article class="archive-podcast archive-item d-grid rounded bg-secondary">
        <div class="archive-podcast-top row mb-1 ff-sans fs-small text-gray">
        <?php  if ($render_settings["show_date"]):
            ?><div class="col-auto post-date"><?php echo get_the_date(); ?></div>
        <?php endif;?>
        </div>
            <a class="archive-item-link image-wrapper" href="<?=$post_permalink?>">
                
                <?php $thumbnail_image_id = get_post_thumbnail_id($post->ID);
                if ($thumbnail_image_id) {
                    echo kapital_responsive_image(get_post_thumbnail_id($post->ID), "(max-width: 599px) 95vw, (max-width: 899px) 47vw, (max-width: 1199px) 32vw, (max-width: 1399px) 300px, (max-width: 1649px) 260px, 312px", false, 'rounded w-100 archive-item-image');
                } else {
                    echo '<div class="rounded w-100 archive-item-image placeholder"></div>';
                }
                
        ?></a>
        <a class="archive-item-link content-wrapper text-decoration-none pe-2" href="<?=$post_permalink?>">

        <h2 class="title mb-2 h3 red-outline-hover" data-text="<?php echo $post_title ?>"><?php echo $post_title ?></h2>
        <div class="post-excerpt ff-grotesk lh-sm">
            <?php echo get_the_excerpt();?>
        </div>
        </a>
</article>