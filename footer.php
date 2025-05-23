<?php
defined('ABSPATH') || exit;

//check if we should render newsletter signup
global $post_types_with_controlled_rendering;
global $kptl_theme_options;
if (!is_404() && !is_archive() && in_array($post->post_type, $post_types_with_controlled_rendering) && isset($args["render_settings"]) && isset($args["render_settings"]["show_footer_newsletter"])) {
    $show_footer_newsletter = $args["render_settings"]["show_footer_newsletter"];
} else {
    $show_footer_newsletter = true;
}
if (is_search()){
    $show_footer_newsletter = false;
}
if (is_multisite()) {
    $is_multisite = true;
    $current_site = get_current_blog_id();
    global $is_woocommerce_site;
    if ($is_woocommerce_site) {

        //do not render signup to newsletter on checkout. It can interfere with other forms
        if (is_checkout() || is_cart()) {
            $show_footer_newsletter = false;
        }

        switch_to_blog(get_main_site_id());
    }
}
?>




<footer class="footer ff-grotesk" role="contentinfo">

    <?php
    get_template_part('template-parts/newsletter-signup-form', null,
    array(
        'ecomail_enabled' => isset($kptl_theme_options["ecomail_enabled"]) ? $kptl_theme_options["ecomail_enabled"] : false,
        'ecomail_post_url' => isset($kptl_theme_options["ecomail_post_url"]) ? $kptl_theme_options["ecomail_post_url"] : "",
        'show_footer_newsletter' => $show_footer_newsletter,
        'show_heading' => true,
        'ecomail_gdpr' => isset($kptl_theme_options["ecomail_gdpr"]) ? $kptl_theme_options["ecomail_gdpr"] : "",
        'additional_classes' => 'mb-6 container'

     )
    );
    ?>

    <div class="bg-primary py-6 py-lg-7 px-4 px-lg-5 px-xl-6">
        <div class="alignwidest mb-6">
            <div class="row gy-6 justify-content-start justify-content-lg-center">
                <div class="col-auto">
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'footer',
                            'container' => false,
                            'menu_id' => 'footer-menu',
                            'menu_class' => 'list-unstyled lh-sm text-dark fw-bold mb-0',
                            'walker'    => new Nested_Menu_List()
                        )

                    ); ?>
                </div>
                <div class="col-12 col-lg-auto ms-lg-7">
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'footer-social',
                            'container' => false,
                            'menu_id' => 'footer-social-menu',
                            'menu_class' => 'list-unstyled lh-sm text-dark fw-bold mb-0',
                            'walker'    => new Nested_Menu_List()
                        )
                    ); ?>
                </div>
            </div>
        </div>

        <?php
        if (is_multisite()) {
            if ($is_woocommerce_site) {
                restore_current_blog();
            }
        } ?>
        <div class="col-12 mb-6 mb-lg-7 alignwidest">
            <h2 class="h5 text-center mb-4"><?= __("Partnerstvá:", "kapital") ?></h2>
            <?php dynamic_sidebar('footer-logos'); ?>
        </div>
        <div class="col-12 text-center">
            <?php if (isset($kptl_theme_options['bottom_footer_text'])): ?>
                <div class="footer-bottom-text alignwider fs-small fw-bold lh-sm">
                    <?php echo $kptl_theme_options['bottom_footer_text']; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
    <div class="p-4 p-md-5 px-lg-6 px-xxl-7 bg-red">
        <svg style="fill: var(--kptl-primary)" viewBox="0 0 837 216">
            <use xlink:href="#kapital-logo" />
        </svg>
    </div>
</footer>


<?php wp_footer(); ?>
</body>

</html>