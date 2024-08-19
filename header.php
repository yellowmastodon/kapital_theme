<!DOCTYPE html>
<!--[if IE 8]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if lte IE 9]><html <?php language_attributes(); ?> class="ie9"><![endif]-->
<html <?php language_attributes(); ?>>

<head>
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
$homepage_link = home_url() ?>

<body <?php body_class(); ?>>
    <?php //svg sprites ?>
    <svg style="display: none;">
        <symbol viewBox="0 0 500 120" id="kapital-logo">
            <polygon points="21.64 59.69 21.64 72.58 45.57 95.93 72.63 95.93 72.63 92.56 44.06 65.96 72.63 39.36 72.63 35.99 46.15 35.99 21.64 59.69" />
            <path d="M121.21,34.89c-21.91,0-32.56,7.03-32.56,21.49v.24h21.5v-.24c0-4.81,4.33-5.8,10.83-5.8,9.76,0,12.74,2.27,12.74,9.73v6.13c-5.45-3.87-15.1-4.46-20.45-4.46-17.82,0-26.86,6.14-26.86,18.25s8.66,17.02,28.09,17.02c14.47,0,22.91-3.01,27.29-9.75l4.38,6.72c1.14,1.7,2.08,2.57,4.11,2.57h2.8c1.72,0,2.59-1.02,2.59-3.03v-33.55c0-17.27-10.95-25.31-34.46-25.31ZM133.72,78.55c0,3.05-2.33,6.7-13.41,6.7-7.8,0-11.28-1.82-11.28-5.91s3.73-6.25,11.73-6.25,12.96,1.99,12.96,5.47Z" />
            <path d="M423.99,34.89c-21.91,0-32.56,7.03-32.56,21.49v.24h21.5v-.24c0-4.81,4.33-5.8,10.83-5.8,9.76,0,12.73,2.27,12.73,9.73v6.13c-5.45-3.87-15.1-4.46-20.45-4.46-17.82,0-26.86,6.14-26.86,18.25s8.66,17.02,28.09,17.02c14.47,0,22.91-3.01,27.29-9.75l4.38,6.72c1.13,1.7,2.08,2.57,4.11,2.57h2.8c1.72,0,2.59-1.02,2.59-3.03v-33.55c0-17.27-10.95-25.31-34.46-25.31ZM423.1,85.25c-7.8,0-11.28-1.82-11.28-5.91s3.73-6.25,11.73-6.25,12.96,1.99,12.96,5.47c0,4.44-4.51,6.7-13.41,6.7Z" />
            <path d="M216.74,34.72c-13.71,0-21.95,5.58-25.55,14.06l-6.97-10.11c-1.16-1.74-2.09-2.56-4.07-2.56h-2.9c-1.74,0-2.44,1.05-2.44,2.9v80.15h23.23v-14.4c0-6.51-.7-12.2-1.28-17.66,3.49,5.81,9.87,10.22,20.68,10.22,15.68,0,30.78-8.94,30.78-31.83s-15.22-30.78-31.48-30.78ZM211.29,78.62c-8.36,0-13.24-5.58-13.24-13.82,0-9.29,5.11-13.94,13.13-13.94,9.06,0,13.47,4.99,13.47,13.94,0,9.64-5.46,13.82-13.36,13.82Z" />
            <path d="M276.77,0c-8.48,0-12.66,3.83-12.66,11.5s4.18,11.73,12.66,11.73,12.55-4.3,12.55-11.73-3.83-11.5-12.55-11.5Z" />
            <rect x="265.27" y="36.11" width="23.23" height="59.82" />
            <path d="M345.69,81.06c-5.81,0-8.71-1.63-8.71-7.78v-20.91h34.38v-16.26h-34.38v-17.77c0-1.86-.7-2.9-2.44-2.9h-2.9c-1.98,0-3.02.81-4.07,2.56l-10.69,19.51-13.24,6.62c-1.51.7-2.56,1.39-2.56,3.37v2.21c0,1.86,1.04,2.67,2.9,2.67h9.76v18.82c0,15.22,6.16,26.14,29.97,26.14,19.98,0,29.27-8.48,29.27-23.23h-18.47c0,4.18-2.09,6.97-8.83,6.97Z" />
            <polygon points="449.56 1.97 427.25 1.97 411.34 22.65 430.62 22.65 449.56 1.97" />
            <rect x="478.24" y="6.26" width="21.76" height="89.67" />
            <rect y="6.26" width="5.81" height="89.67" />
        </symbol>
        <symbol  viewBox="0 0 24 24" id="icon-search">
            <path class="cls-1" d="M18.1,16c1.3-1.7,1.9-3.8,1.9-6,0-2.3-.8-4.5-2.2-6.2-1.4-1.8-3.4-3-5.6-3.5C10-.2,7.7,0,5.7,1,3.6,2,2,3.7,1,5.7,0,7.7-.3,10.1.3,12.3s1.8,4.2,3.5,5.6c1.8,1.4,4,2.2,6.2,2.2h0c2.1,0,4.2-.7,5.9-1.9l5.6,5.6.3.3,2.2-2.2-5.9-5.9ZM11.4,16.9c-1.4.3-2.7.1-4-.4-1.3-.5-2.4-1.4-3.1-2.6-.8-1.1-1.2-2.5-1.2-3.9s.7-3.6,2-4.9c1.3-1.3,3.1-2,4.9-2s2.7.4,3.9,1.2c1.1.8,2,1.8,2.6,3.1.5,1.3.7,2.7.4,4-.3,1.4-.9,2.6-1.9,3.6s-2.2,1.6-3.6,1.9Z"/>
        </symbol>
    </svg>

    <?php
    /** Top part of header with big logo and quick navigation
     * only shown on front page
     * expanded on other pages via javascript when users scrolls all the way to the top
     */ ?>
    <header role="banner" id="top-header" class="bg-primary p-4 px-md-5 collapse<?php if ($is_front): echo ' show';
                                                                        endif; ?>">
        <div class="align-wider">
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
                    <<?php if ($is_front): echo 'h1'; else: echo 'div'; endif;?> class="mb-0 col-auto flex-grow-1 ps-md-6">
                        <svg id="main-logo" viewBox="0 0 500 120">
                            <use xlink:href="#kapital-logo"></use>
                        </svg>
                        <div class="visually-hidden"><?php echo get_bloginfo('name'); ?></div>
                    </<?php if ($is_front): echo 'h1'; else: echo 'div'; endif;?>>
            </div>
        </div>
    </header>

    <nav id="horizontal-nav" class="fw-bold px-4 px-md-3 bg-primary position-sticky">
        <div class="row gx-4 align-items-center justify-content-between">
            <div class="col-auto col-lg-1 text-start">
                <button class="btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-menu" aria-controls="main-menu">
                    <div class="hamburger me-2">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>Menu
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="main-menu" aria-role="menu" aria-label="Hlavne menu">
                    <div class="offcanvas-body">
                        <button type="button" class="btn-close" aria-label="Zatvoriť" data-bs-dismiss="offcanvas"></button>
                        <div>
                            Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
                        </div>
                        <div class="dropdown mt-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Dropdown button
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-align-wider">
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
                            <div class="visually-hidden"><?php echo get_bloginfo('name'); ?></div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 text-end"><a class="btn-menu text-decoration-none d-none d-md-inline-block" href="#">Eshop</a><a class="btn-menu btn-podpora default-x-margin ms-4 text-decoration-none" href="#">Podpora</a></div>
                </div>
            </div>
            <div class="col-auto col-lg-1 d-none d-sm-block text-end"><button class="btn-menu" xlink:href="#icon-search">
                <svg viewBox="0 0 24 24">
                    <use xlink:href="#icon-search"></use>
                </svg>
            </button><a class="btn-menu text-decoration-none" href="#">EN</a></div>
        </div>
    </nav>