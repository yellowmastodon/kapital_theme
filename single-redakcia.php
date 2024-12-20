<?php get_header();
//options to hide or display parts of the post
global $is_woocommerce_site;



/** render breadcrumbs */
$breadcrumbs = array();
$about_page = get_posts(array(
    'name'           => 'o-nas', 
    'post_type'      => 'page',  // You can also use 'page' or custom post types
    'posts_per_page' => 1
));
if (!empty($about_page)){
    $breadcrumbs[] = [$about_page[0]->post_title, get_the_permalink($about_page[0])];
}
$breadcrumbs[] = [__('Redakcia', 'kapital'), get_post_type_archive_link('redakcia')];
echo kapital_breadcrumbs($breadcrumbs, "container");

/** MAIN */
?>
<main class="main container" role="main" id="main">
    <?php while (have_posts()) : the_post();?>
        <article <?php post_class(["main-content"]); ?>>

            <?php
            $thumbnail_id = get_post_thumbnail_id();
            if (is_int($thumbnail_id) && $thumbnail_id !== 0) echo kapital_responsive_image($thumbnail_id, "(max-width: 400px) 95vw, (max-width: 1919px) 400px, 500px", false, 'alignnarrow rounded d-block w-100 mb-3 redakcia-portrait');
            ?>

            <header class="post-header alignwide">
                <h1 class="text-center mb-2"><?php the_title()?></h1>
                <?php $secondary_title = get_post_meta($post->ID, '_secondary_title', true);
                if (!empty($secondary_title)): ?>
                    <p class="secondary-title ff-grotesk alignnormal text-center">
                        <?php echo $secondary_title ?>
                    </p>
                <?php endif; ?>
            </header>
            <div id="post-content">
                <?php
                /**
                 * Render post content
                 * insert ad for support by default 
                 */
                the_content(); ?>
            </div>
            <?php get_template_part('template-parts/single-redakcia-footer');?>

        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>