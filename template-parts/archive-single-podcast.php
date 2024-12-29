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
}
//used for hiding when rendered as block with "show More" button
if (isset($args['additional_class'])){
    $additional_class = " " . $args['additional_class'];
} else {
    $additional_class = "";
}

//used for moving focus when rendered as block with "show More" button
if (isset($args['tabindex'])){
    if ($args['tabindex']){
        $tab_index = true;
    } else {
        $tab_index = false;
    }
} else {
    $tab_index = false;
}

$post_permalink = get_post_permalink();
$post_title = get_the_title();
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
//get current queried object
if (isset($args['queried_object_id'])){
    $queried_object_id = $args['queried_object_id'];
    if(!term_exists($queried_object_id)){
        $queried_object_id = false;
    }
} else {
    $queried_object_id = false;
}
$custom_taxonomies = ['podcast-seria', 'partner']; //with partners this includes also podcast seria
if ($queried_object_id){
    $filtered_terms = get_and_reorganize_terms($post->ID, $custom_taxonomies, $queried_object_id);
} else {
    $filtered_terms = get_and_reorganize_terms($post->ID, $custom_taxonomies);
}

$article_classes = "archive-podcast-item ff-grotesk archive-item rounded bg-secondary p-3 mb-3";
$article_classes .= $additional_class;
?>


<article <?php if($tab_index) echo 'tabindex="-1"'; post_class([$article_classes], $post);?> >
        <div class="archive-podcast-top row justify-content-between justify-content-sm-start ff-sans fs-small text-gray">
            <?php  if ($render_settings["show_date"]):
                ?><div class="col-auto post-date"><?php echo get_the_date(); ?></div>
            <?php endif;
            if ($render_settings["show_views"]): ?>
                <div class="col-auto post-views opacity-0" data-id="<?php echo $post->ID?>">
                    <svg>
                        <use xlink:href="#icon-views"></use>
                    </svg>
                    <span class="visually-hidden"><?php echo __('Počet zhliadnutí:', 'kapital') ?></span>
                    <span class="number"></span>
                </div><?php
            endif; ?>
        </div>
            <a aria-role="none" tabindex="-1" class="archive-item-link image-wrapper" href="<?=$post_permalink?>">
                
                <?php $thumbnail_image_id = get_post_thumbnail_id($post->ID);
                if ($thumbnail_image_id) {
                    echo kapital_responsive_image(get_post_thumbnail_id($post->ID), "(max-width: 599px) 95vw, (max-width: 899px) 47vw, (max-width: 1199px) 32vw, (max-width: 1399px) 300px, (max-width: 1649px) 260px, 312px", false, 'rounded w-100 archive-item-image');
                } else {
                    echo '<div class="rounded w-100 archive-item-image placeholder"></div>';
                }
                
        ?></a>
        <a class="title-wrapper position-relative archive-item-link podcast-title-wrapper text-decoration-none" href="<?=$post_permalink?>">
            <?php if ($post->post_type === "podcast"):?>
                <svg class="item-icon-podcast position-absolute"><use xlink:href="#icon-podcast"></use></svg>
            <?php endif;?>
        <<?= 'h' . $heading_level;?> class="mb-0 archive-item-heading red-outline-hover" data-text="<?php echo $post_title ?>"><?php echo $post_title ?></<?= 'h' . $heading_level;?>>
        </a>

        <a aria-role="none" tabindex="-1" class="excerpt-wrapper archive-item-link text-decoration-none lh-sm" href="<?=$post_permalink?>">
            <?php echo get_the_excerpt();?>
        </a>

        <?php if ($render_settings["show_categories"] && !empty($filtered_terms)):?>
            <div class="item-terms text-uppercase row gx-3 gy-1">

                <?php foreach ($custom_taxonomies as $custom_taxonomy):
                    //autorstvo rendered separately                        
                    if (!empty($filtered_terms[$custom_taxonomy]) && $custom_taxonomy !== 'autorstvo'):
                        foreach ($filtered_terms[$custom_taxonomy] as $term):
                            //'tematicky' tag used for posts which are part of the printed issue
                            if ($term->slug === 'tematicky'):
                                if (isset($filtered_terms['cislo'][0])):?>
                                <div class="col-auto"><a class="marker-black" href="<?php echo get_term_link($filtered_terms['cislo'][0]); ?>"><?php echo $term->name ?></a></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="col-auto"><a class="marker-black" href="<?php echo get_term_link($term); ?>"><?php echo $term->name ?></a></div>
                           <?php endif; 
                        endforeach;
                    endif;
                endforeach;?>
            </div>
        <?php endif; ?>
</article>