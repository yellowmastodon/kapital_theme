<!DOCTYPE html>
<!--[if IE 8]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if lte IE 9]><html <?php language_attributes(); ?> class="ie9"><![endif]-->
<html <?php language_attributes(); ?>>

<head>
    <meta name="theme-color" content="#ffc2fe" />
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1 maximum-scale=1.0">
    <?php wp_head(); ?>
    <!--[if lt IE 10]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script>
        <![endif]-->
    <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/livingston-css3-mediaqueries-js/1.0.0/css3-mediaqueries.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
        <![endif]-->
</head>
<?php
$subsite_search_url = get_home_url() . '?s';
$is_multisite = false;
global $kptl_theme_options;
if (is_multisite()) {
    $is_multisite = true;
    $current_site = get_current_blog_id();
    global $is_woocommerce_site;
    if ($is_woocommerce_site) {
        switch_to_blog(get_main_site_id());
        $kptl_theme_options = get_theme_mods();
    } else {
        $kptl_theme_options = get_theme_mods();
    }
} else {
    $kptl_theme_options = get_theme_mods();
}

//add english and support to main nav menu automatically
if (isset($kptl_theme_options["english"]) || isset($kptl_theme_options["eshop_url"]) ){
    add_filter('wp_nav_menu_items', function($items, $args) use ($kptl_theme_options) {
        if ($args->theme_location === "main"){
            if (isset($kptl_theme_options["eshop_url"])){
                $items .= '<li class="menu-item d-block d-md-none level-0"><a class="btn-menu text-decoration-none" href="' . $kptl_theme_options["eshop_url"] . '">' . __("E-shop", "kapitál"). '</a></li>';
            } 
            if (isset($kptl_theme_options["english"])){
                $items .= '<li class="menu-item d-block d-md-none level-0"><a class="btn-menu text-decoration-none" href="' . $kptl_theme_options["english"] . '">' . __("English", "kapitál"). '</a></li>';
            }
            return $items;
        } else {
            return $items;
        }
    }, 10, 2);
}
$is_front = is_front_page() && !$is_woocommerce_site;
$homepage_link = home_url();
$site_name = get_bloginfo('name');
//option for support inserting. Check if campaing active
$darujme_options = get_option('kapital_darujme_settings');
if (isset($darujme_options["campaign_active"])) {
    $body_classes = $darujme_options["campaign_active"] ? 'darujme-active' : 'darujme-disabled';
} else {
    $body_classes = 'darujme-disabled';
} ?>

<body <?php body_class($body_classes); ?>>
    <a class="btn btn-white rounded-0 position-absolute visually-hidden-focusable" href="#main"><?=__("Prejsť na hlavný obsah")?></a>
    <?php //svg sprites
    get_template_part('template-parts/inline-svg-icons');
    /** Top part of header with big logo and quick navigation
     * only shown on front page
     * expanded on other pages via javascript when users scrolls all the way to the top
     */ ?>
    <header role="banner" id="top-header" class="ff-grotesk bg-primary p-4 px-md-5 collapse d-print-none<?php if ($is_front): echo ' show';
                                                                                                        endif; ?>">
        <div class="alignwider">
            <div class="row gx-3 align-items-center">
                <nav class="col-auto quick-menu-container d-none d-md-block" aria-label="Rýchla">
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'quick',
                            'container' => false,
                            'menu_id' => 'quick-menu',
                            'menu_class' => 'list-unstyled text-uppercase text-dark mb-0'
                        )

                    ) ?>
                </nav>
                <<?php if ($is_front): echo 'h1';
                    else: echo 'a tabindex="-1" href="' . $homepage_link .  '"';
                    endif; ?> class="mb-0 col-auto flex-grow-1 ps-md-7">
                    <svg id="main-logo" viewBox="0 0 837 216">
                        <use xlink:href="#kapital-logo"></use>
                    </svg>
                    <div class="visually-hidden"><?php echo $site_name; ?></div>
                </<?php if ($is_front): echo 'h1';
                    else: echo 'a';
                    endif; ?>>
            </div>
        </div>
    </header>
    <div class="horizontal-nav-wrapper position-sticky">
        <nav id="horizontal-nav" class="fw-bold ff-grotesk px-3 bg-primary d-print-none">
            <div class="row gx-4 align-items-center justify-content-between">
                <div class="col-2 col-lg-1 col-xl-1 text-start">
                    <button class="btn-menu fw-bold main-menu-toggler w-max-content" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-menu-wrapper" aria-controls="main-menu">
                        <div class="hamburger me-2 d-inline-block">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                </div><span class="text">Menu</span>
                    </button>
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="main-menu-wrapper" aria-role="menu" aria-label="Hlavné menu">
                        <div class="offcanvas-body d-flex flex-column justify-content-between p-6 p-sm-5" tabindex="-1">
                            <button type="button" class="mb-3 mb-sm-0 btn btn-close" aria-label="<?= __('Zatvoriť', 'kapital') ?>" data-bs-dismiss="offcanvas"><svg>
                                    <use xlink:href="#icon-close"></use>
                                </svg></button>
                            <div aria-label="<?= __('Hlavné menu', 'div') ?>">
                                <?php wp_nav_menu(
                                    array(
                                        'theme_location'  => 'main',
                                        'container' => false,
                                        'menu_id' => 'main-menu',
                                        'menu_class' => 'list-unstyled text-uppercase text-dark mb-0',
                                        'depth' => 2,
                                        'walker' => new Nested_Menu_List()
                                    ) 
                                ) ?>
                            </div>
                            <div class="mt-6">
                                <?php get_template_part('template-parts/socials', null, array('theme_options' => $kptl_theme_options, 'search_url' => $subsite_search_url));?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-alignwider">
                    <div class="row gx-4 align-items-center">

                        <?php
                        /** Get header series to display in header
                         * Print all and the visible one will be selected by js, so that caching is possible
                         */
                        ?>
                        <div class="header-series-wrapper col-6 col-lg-4 d-none d-md-block text-start">
                            <?php $header_series = (get_option('kapital_header_series'));
                            if (isset($header_series)):
                                if ($header_series && !empty($header_series)):
                                    foreach($header_series as $series):
                                        $series_term = get_term((int) $series);?>
                                        <a class="btn-menu marker-red" href="<?= get_term_link($series_term)?>" style="display: none"><?=$series_term->name?></a>
                                    <?php endforeach;
                                endif;
                            endif;
                            ?>
                        </div>
                        <?php
                        /** small logo in horizontal navigagion
                         * showed if big logo not visible
                         * dynamically adding and removing opacity-0 on scroll
                         * default hidden on front page (expanded top header with bigger logo)                       
                         */ ?>
                        <div id="horizontal-nav-logo" class="col-auto col-md-4 text-center <?php if ($is_front): echo ' invisible opacity-0';
                                                                                                                endif; ?>">
                            <a class="btn-menu" href="<?php echo $homepage_link ?>">
                                <svg viewBox="0 0 500 120">
                                    <use xlink:href="#kapital-logo"></use>
                                </svg>
                                <div class="visually-hidden"><?php echo $site_name; ?></div>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 text-end">
                            <?php if ($is_multisite && isset($kptl_theme_options["eshop_url"])):?>
                                <a class="btn-menu d-none d-md-inline-block text-decoration-none" href="<?=$kptl_theme_options["eshop_url"]?>">
                                    <?= __("E-shop", "kapital")?>
                                </a>
                            <?php endif;?>
                            <?php if (isset($kptl_theme_options["podpora"])):?>
                                <a class="btn-menu btn-podpora default-x-margin ms-4 text-decoration-none" href="<?=$kptl_theme_options["podpora"]?>">Podpora</a>
                            <?php endif;?>

                        </div>
                    </div>
                </div>
                <div class="col-auto col-lg-1 col-xl-1 d-none d-md-block">
                    <div class="row gx-4 justify-content-end flex-nowrap">
                        <div class="col-auto">
                            <button class="btn-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch" aria-label="<?= __("Zatvoriť dialóg vyhľadávania.", "kapital") ?>">
                            <svg class="icon-square" viewBox="0 0 24 24">
                                <use xlink:href="#icon-search"/>
                            </svg>
                            </button>
                        </div>
                        <?php if (isset($kptl_theme_options["english"])):?>
                            <div class="col-auto">
                                <a class="btn-menu text-decoration-none" href="<?=$kptl_theme_options["english"]?>">EN</a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </nav>
        <?php
        global $is_woocommerce_site;
        if (is_multisite()) {
            switch_to_blog($current_site);
        }
        if ($is_woocommerce_site) {
            if ( is_store_notice_showing() ) {
                $notice = get_option( 'woocommerce_demo_store_notice' );
                if (!empty($notice)){
                    $notice_id = md5( $notice );
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo apply_filters( 'woocommerce_demo_store', '<p class="alert alert-warning woocommerce-store-notice demo_store" data-notice-id="' . esc_attr( $notice_id ) . '" style="display:none;">' . wp_kses_post( $notice ) . ' <a href="#" class="woocommerce-store-notice__dismiss-link">' . esc_html__( 'Skryť', 'kapital' ) . '</a></p>', $notice );
                }
            }
            woocommerce_output_all_notices();        
            if (!is_cart()  && !is_checkout()):
                $cart_contents = WC()->cart->get_cart_contents_count();?>
                <div class="kapital-cart-link-wrapper position-relative">
                    <a class="btn btn-outline rounded-pill position-absolute" href="<?=wc_get_cart_url()?>">
                        <span class="visually-hidden"><?=__("Prejsť do košíka", "kapital")?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" width="20" height="20" class="icon-square" aria-hidden="true" focusable="false"><circle cx="12.6667" cy="24.6667" r="2" fill="currentColor"></circle><circle cx="23.3333" cy="24.6667" r="2" fill="currentColor"></circle><path fill-rule="evenodd" clip-rule="evenodd" d="M9.28491 10.0356C9.47481 9.80216 9.75971 9.66667 10.0606 9.66667H25.3333C25.6232 9.66667 25.8989 9.79247 26.0888 10.0115C26.2787 10.2305 26.3643 10.5211 26.3233 10.8081L24.99 20.1414C24.9196 20.6341 24.4977 21 24 21H12C11.5261 21 11.1173 20.6674 11.0209 20.2034L9.08153 10.8701C9.02031 10.5755 9.09501 10.269 9.28491 10.0356ZM11.2898 11.6667L12.8136 19H23.1327L24.1803 11.6667H11.2898Z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M5.66669 6.66667C5.66669 6.11438 6.1144 5.66667 6.66669 5.66667H9.33335C9.81664 5.66667 10.2308 6.01229 10.3172 6.48778L11.0445 10.4878C11.1433 11.0312 10.7829 11.5517 10.2395 11.6505C9.69614 11.7493 9.17555 11.3889 9.07676 10.8456L8.49878 7.66667H6.66669C6.1144 7.66667 5.66669 7.21895 5.66669 6.66667Z" fill="currentColor"></path></svg>
                        <span class="kapital-cart-quantity-mini-badge rounded-pill text-white bg-red position-absolute" style="display: none"?>">
                        </span>
                    </a>
                </div>
                <?php wp_add_inline_script('scripts', 'jQuery(document.body).on("added_to_cart",function(){updateCartCount()});jQuery(updateCartCount());function updateCartCount(){jQuery.ajax({url:wc_add_to_cart_params.ajax_url,type:"GET",data:{action:"get_cart_item_count"},success:function(t){t.data.cart_count>0?jQuery(".kapital-cart-quantity-mini-badge").css("display","inline-block"):jQuery(".kapital-cart-quantity-mini-badge").css("display","none"),jQuery(".kapital-cart-quantity-mini-badge").text(t.data.cart_count)},})}', 'after' )?>
            <?php endif;
        }
        ?>
    </div>
    <?php get_template_part('template-parts/offcanvas-search', null, array('woocommerce' => $is_woocommerce_site));
?>