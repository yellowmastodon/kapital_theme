<?php /* Template Name: Newsletter: Ďakujeme za prihlásenie */
get_header();
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
$breadcrumbs[] = [__("Odber newslettru"), "", true];
global $kptl_theme_options;


echo kapital_breadcrumbs($breadcrumbs, "container");
?>
<main class="main container mt-3 d-flex flex-column justify-content-center" role="main" id="main">
    <?php while (have_posts()) : the_post();?>
            <header class="post-header alignnarrow text-center mb-4">
                <div class="bg-green ff-grotesk rounded-pill h1 mb-4 text-center text-white p-3"
                style="width: 3rem; height: 3rem; line-height: .8; margin-left: auto; margin-right: auto">
                ✓
                </div>
                <h1 class="text-uppercase mb-0"><?php the_title()?></h1>
                <?php $secondary_title = get_post_meta($post->ID, '_secondary_title', true);
                if (!empty($secondary_title)): ?>
                    <p class="secondary-title mt-4 ff-grotesk alignnormal text-center">
                        <?php echo $secondary_title ?>
                    </p>
                <?php endif; ?>
            </header>

            <div id="post-content" class="alignnarrow lh-sm text-center ff-grotesk">
                <?php
                /**
                 * Render post content
                 */
                the_content();
                ?>
                </div>
            </div>
    <?php endwhile; ?>
</main>

<?php
$render_settings["show_footer_newsletter"] = false;
get_footer(null, array('render_settings' => $render_settings));
