<!DOCTYPE html>
<!--[if IE 8]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if lte IE 9]><html <?php language_attributes(); ?> class="ie9"><![endif]-->
<html <?php language_attributes(); ?>>

<head>
    <meta name="theme-color" content="#ffc2fe" />
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
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
<?php $is_front = is_front_page();
$homepage_link = home_url();
$site_name = get_bloginfo('name');
//option for support inserting. Check if campaing active
$darujme_options = get_option('kapital_darujme_settings');
if (isset($darujme_options["campaign_active"])){
    $body_classes = $darujme_options["campaign_active"] ? 'darujme-active' : 'darujme-disabled';
} else {
    $body_classes = 'darujme-disabled';
}?>
<body <?php body_class($body_classes); ?>>
    <?php //svg sprites
    get_template_part('template-parts/inline-svg-icons');

    /** Top part of header with big logo and quick navigation
     * only shown on front page
     * expanded on other pages via javascript when users scrolls all the way to the top
     */ ?>
    <header role="banner" id="top-header" class="ff-grotesk bg-primary p-4 px-md-5 collapse d-print-none<?php if ($is_front): echo ' show';
                                                                        endif; ?>">
        <div class="alignwider">
            <div class="row gx-4 align-items-center">
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
                    <<?php if ($is_front): echo 'h1'; else: echo 'a tabindex="-1" href="' . $homepage_link .  '"'; endif;?> class="mb-0 col-auto flex-grow-1 ps-md-7">
                        <svg id="main-logo" viewBox="0 0 837 216">
                            <use xlink:href="#kapital-logo"></use>
                        </svg>
                        <div class="visually-hidden"><?php echo $site_name; ?></div>
                    </<?php if ($is_front): echo 'h1'; else: echo 'a'; endif;?>>
            </div>
        </div>
    </header>

    <nav id="horizontal-nav" class="fw-bold ff-grotesk px-3 bg-primary position-sticky d-print-none">
        <div class="row gx-4 align-items-center justify-content-between">
            <div class="col-auto col-lg-1 col-xl-1 text-start">
                <button class="btn-menu w-max-content" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-menu-wrapper" aria-controls="main-menu">
                    <span class="hamburger me-2 d-inline-block">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </span><span class="d-inline-block">Menu</span>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="main-menu-wrapper" aria-role="menu" aria-label="Hlavné menu">
                    <div class="offcanvas-body text-center text-sm-start px-4 py-5" tabindex="-1"   >
                        <button type="button" class="mb-3 mb-sm-0 btn btn-close" aria-label="<?=__('Zatvoriť', 'kapital')?>" data-bs-dismiss="offcanvas"><svg><use xlink:href="#icon-close"></use></svg></button>
                        <div aria-label="<?=__('Hlavné menu', 'div')?>">
                            <?php wp_nav_menu(
                                array(
                                    'theme_location'  => 'main',
                                    'container' => false,
                                    'menu_id' => 'main-menu',
                                    'menu_class' => 'list-unstyled text-uppercase text-dark mb-0'
                                )
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-alignwider">
                <div class="row gx-4 align-items-center">
                    <div class="col-6 col-lg-4 d-none d-sm-block text-start"><a class="btn-menu marker-red" href="#">link témy</a></div>
                    <?php
                    /** small logo in horizontal navigagion
                     * showed if big logo not visible
                     * dynamically adding and removing opacity-0 on scroll
                     * default hidden on front page (expanded top header with bigger logo)                       
                     */ ?>
                    <div id="horizontal-nav-logo" class="col-auto col-md-4 d-none d-md-block text-center <?php if ($is_front): echo ' invisible opacity-0';
                                                                            endif; ?>">
                        <a class="btn-menu" href="<?php echo $homepage_link ?>">
                            <svg viewBox="0 0 500 120">
                                <use xlink:href="#kapital-logo"></use>
                            </svg>
                            <div class="visually-hidden"><?php echo $site_name; ?></div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 text-end"><a class="btn-menu text-decoration-none d-none d-md-inline-block" href="#">Eshop</a><a class="btn-menu btn-podpora default-x-margin ms-4 text-decoration-none" href="#">Podpora</a></div>
                </div>
            </div>
            <div class="col-auto col-lg-1 col-xl-1 d-none d-sm-block text-end"><button class="btn-menu" xlink:href="#icon-search">
                <svg viewBox="0 0 24 24">
                    <use xlink:href="#icon-search"></use>
                </svg>
            </button><a class="btn-menu text-decoration-none" href="#">EN</a></div>
        </div>
    </nav>