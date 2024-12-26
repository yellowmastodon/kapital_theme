<?php
defined('ABSPATH') || exit;
if (is_multisite()) {
    $is_multisite = true;
    $current_site = get_current_blog_id();
    global $is_woocommerce_site;
    if ($is_woocommerce_site) {
        switch_to_blog(get_main_site_id());
    } 
}
?> <footer class="footer ff-grotesk" role="contentinfo">
    <div class="bg-primary py-6 px-3 px-sm-4 px-lg-5 px-xl-6">
        <div class="row alignwider justify-content-between align-items-start gx-4 gy-6">
            <div class="col-12 col-md-4">
                <?php dynamic_sidebar('footer-mailchimp-signup'); ?>
            </div>
            <div class="col-12 col-md-4 text-center">
                <?php
                global $kptl_theme_options;
                if (isset($kptl_theme_options['middle_footer_column_text'])) {
                    echo wpautop($kptl_theme_options['middle_footer_column_text']);
                }
                ?>
            </div>
            <div class="col-12 col-md-auto text-end">
                <?php get_template_part('template-parts/socials', null, array('theme_options' =>$kptl_theme_options));?>
            </div>
            <div class="col-12">
                <h2 class="h5 text-center fw-normal mb-2"><?= __("Partnerstvá:", "kapital") ?></h2>
                <?php dynamic_sidebar('footer-logos'); ?>
            </div>
            <div class="col-12 col-md-6">
            <?php if (isset($kptl_theme_options['bottom_footer_text'])): ?>
            <div class="footer-bottom-text alignwidest d-flex fs-small lh-sm">
                <?php echo wpautop($kptl_theme_options['bottom_footer_text']); ?>
            </div>
        <?php endif; ?>
            </div>
            <div class="col-12 col-md-auto">
            <?php wp_nav_menu(
                array(
                    'theme_location'  => 'footer',
                    'container' => false,
                    'menu_id' => 'footer-menu',
                    'menu_class' => 'list-unstyled lh-sm fs-small text-dark mb-0',
                    'walker'    => new Nested_Menu_List()
                )

            ); ?>
            </div>
        </div>

    </div>

    </div>
    <div class="p-4 p-md-5 px-lg-6 px-xxl-7 bg-red">
        <svg style="fill: var(--kptl-primary)" viewBox="0 0 837 216">
            <use xlink:href="#kapital-logo" />
        </svg>
    </div>
</footer>

<?php
if (is_multisite()) {
    $current_site = get_current_blog_id();
    if ($is_woocommerce_site) {
        switch_to_blog($current_site);
    } 
}

wp_footer(); ?>
</body>

</html>