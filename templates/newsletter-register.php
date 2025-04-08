<?php /* Template Name: Prihlasovanie na newsletter */
get_header();
$render_settings = kapital_get_render_settings($post->ID, $post->post_type);
$breadcrumbs[] = [get_the_title(), get_the_permalink(), true];
global $kptl_theme_options;


echo kapital_breadcrumbs($breadcrumbs, "container");
?>
<main class="main container mt-3 d-flex flex-column justify-content-center" role="main" id="main">
    <?php while (have_posts()) : the_post();?>
            <header class="post-header alignnarrow">
                <h1 class="text-center text-uppercase mb-5"><?php the_title()?></h1>
                <?php $secondary_title = get_post_meta($post->ID, '_secondary_title', true);
                if (!empty($secondary_title)): ?>
                    <p class="secondary-title ff-grotesk alignnormal text-center">
                        <?php echo $secondary_title ?>
                    </p>
                <?php endif; ?>
            </header>

            <div id="post-content" class="alignnarrow">
                <div class="ff-grotesk lh-sm mb-5 text-center">
                <?php
                /**
                 * Render post content
                 */
                the_content();?>
                </div>

                <?php get_template_part('template-parts/newsletter-signup-form', null,
                array(
                    'ecomail_enabled' => isset($kptl_theme_options["ecomail_enabled"]) ? $kptl_theme_options["ecomail_enabled"] : false,
                    'ecomail_post_url' => isset($kptl_theme_options["ecomail_post_url"]) ? $kptl_theme_options["ecomail_post_url"] : "",
                    'show_footer_newsletter' => true,
                    'show_heading' => false,
                    'ecomail_gdpr' => isset($kptl_theme_options["ecomail_gdpr"]) ? $kptl_theme_options["ecomail_gdpr"] : "",
                )
                );
                //disable rendering in footer after it has been outputed
                $render_settings["show_footer_newsletter"] = false;


            ?>
            </div>
    <?php endwhile; ?>
</main>

<?php get_footer(null, array('render_settings' => $render_settings));
