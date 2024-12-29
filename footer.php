<?php
defined('ABSPATH') || exit;
if (is_multisite()) {
    $is_multisite = true;
    $current_site = get_current_blog_id();
    global $kptl_theme_options;
    global $is_woocommerce_site;
    if ($is_woocommerce_site) {
        switch_to_blog(get_main_site_id());
    }
}
?> <footer class="footer ff-grotesk" role="contentinfo">
    <div class="bg-primary py-6 py-lg-7 px-4 px-lg-5 px-xl-6">
        <?php /**
        <div class="row alignwider justify-content-between align-items-start gx-4 gy-6">
            <div class="col-12 col-md-4">
                <?php dynamic_sidebar('footer-mailchimp-signup'); ?>
            </div>

        </div>
         */?>
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

<?php
if (is_multisite()) {
    if ($is_woocommerce_site) {
        restore_current_blog();
    }
}

wp_footer(); ?>
</body>

</html>