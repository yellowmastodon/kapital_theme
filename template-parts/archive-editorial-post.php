<?php

//taxonomies to display in posts, ordered by render priority
$queried_object_id = $args['queried_object_id'];

if(!term_exists($queried_object_id)){
    $queried_object_id = false;
}
$custom_taxonomies = ['cislo', 'seria', 'jazyk', 'partner', 'zaner', 'rubrika', 'autorstvo'];
$filtered_terms = get_and_reorganize_terms($post->ID, $custom_taxonomies);
$render_settings = get_post_meta($post->ID, '_kapital_post_render_settings', true);
$default_render_settings = array(
    'show_featured_image' => true,
    'show_title' => true,
    'show_author' => true,
    'show_categories' => true,
    'show_views' => true,
    'show_date' => true,
    'show_ads'  => true,
    'show_support' => true,
    'show_footer' => true,
);
if(is_array($render_settings)){
    array_merge($default_render_settings, $render_settings);
} else {
    $render_settings = $default_render_settings;
}
$post_permalink = get_post_permalink($post);
$show_author = $render_settings["show_author"] && !empty($filtered_terms['autorstvo']) && $post->post_type !== 'podcast';
?>

<article data-id="<?php echo $post->ID?>" <?php post_class("alignnormal archive-item mb-6")?>>
    <h2 class="mb-4"><a class="text-decoration-none" tabindex="-1" href="<?php echo $post_permalink ?>"><?php the_title();?></a></h2>
    <div class="mb-4"><?php echo kapital_wp_trim_excerpt($post->post_content, 55)?></div>
    <?php
    if ($show_author):?>
            <div class="col-auto ff-grotesk text-uppercase fs-small post-authors">
                <svg viewBox="0 0 24 24">
                    <use xlink:href="#icon-author"></use>
                </svg>
                <?php foreach ($filtered_terms['autorstvo'] as $key => $author):
                    if ($key !== 0) {
                        echo ", ";
                    }
                ?><a href="<?php echo get_term_link($author); ?>"><?php echo $author->name
                        ?></a><?php
                        endforeach; ?>
            </div>
    <?php endif; ?>

    
    <a href="<?php echo $post_permalink?>" class="btn mt-5 btn-secondary"><?php echo __('Čítať ďalej', 'kapital')?><svg class="ms-2 icon-square"><use xlink:href="#icon-arrow-right"></svg></a>
</article>

