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
        <symbol viewBox="0 0 837 216" id="kapital-logo">
            <path d="M33.9006 108.158V131.385L76.9118 173.392H125.545V167.339L74.185 119.448L125.545 71.5845V65.5312H77.9519L33.9006 108.158Z"/>
            <path d="M222.815 142.139C222.815 147.629 218.626 154.189 198.723 154.189C184.695 154.189 178.454 150.895 178.454 143.546C178.454 136.198 185.145 132.313 199.538 132.313C213.931 132.313 222.815 135.888 222.815 142.139ZM200.325 63.5586C160.968 63.5586 141.824 76.2001 141.824 102.243V102.666H180.478V102.243C180.478 93.5716 188.265 91.7979 199.96 91.7979C217.501 91.7979 222.843 95.8803 222.843 109.31V120.347C213.06 113.364 195.715 112.323 186.1 112.323C154.081 112.323 137.832 123.359 137.832 145.151C137.832 166.943 153.406 175.784 188.293 175.784C214.297 175.784 229.449 170.378 237.32 158.243L245.192 170.35C247.244 173.419 248.931 174.967 252.585 174.967H257.617C260.709 174.967 262.256 173.137 262.256 169.505V109.141C262.256 78.0583 242.577 63.5867 200.325 63.5867"/>
            <path d="M579.582 146.676C569.152 146.676 563.923 143.748 563.923 132.683V95.0399H625.713V65.787H563.923V33.8032C563.923 30.4528 562.658 28.5664 559.538 28.5664H554.309C550.767 28.5664 548.884 30.0305 547 33.1556L527.8 68.2647L504.017 80.1742C501.29 81.4411 499.435 82.6799 499.435 86.2274V90.1973C499.435 93.5477 501.318 95.0117 504.664 95.0117H522.205V128.882C522.205 156.277 533.282 175.929 576.068 175.929C611.967 175.929 628.665 160.669 628.665 134.119H595.493C595.493 141.636 591.726 146.676 579.638 146.676"/>
            <path d="M837 12.0469H797.896V173.43H837V12.0469Z"/>
            <path d="M11.075 12.0469H0.645508V173.43H11.075V12.0469Z"/>
            <path d="M479.901 65.75H438.155V173.414H479.901V65.75Z"/>
            <path d="M458.84 0.761719C443.604 0.761719 436.098 7.65964 436.098 21.4555C436.098 35.2514 443.604 42.5716 458.84 42.5716C474.077 42.5716 481.386 34.829 481.386 21.4555C481.386 8.08197 474.499 0.761719 458.84 0.761719Z"/>
            <path d="M755.143 4.31641H715.055L686.465 41.537H721.099L755.143 4.31641Z"/>
            <path d="M707.576 154.169C693.548 154.169 687.307 150.875 687.307 143.527C687.307 136.178 693.998 132.293 708.391 132.293C722.784 132.293 731.668 135.869 731.668 142.119C731.668 150.115 723.571 154.169 707.576 154.169ZM709.206 63.5391C669.821 63.5391 650.705 76.1806 650.705 102.224V102.646H689.359V102.224C689.359 93.5521 697.146 91.7783 708.813 91.7783C726.354 91.7783 731.696 95.8608 731.696 109.291V120.327C721.913 113.345 704.568 112.303 694.953 112.303C662.934 112.303 646.685 123.34 646.685 145.132C646.685 166.924 662.259 175.764 697.146 175.764C723.15 175.764 738.302 170.358 746.201 158.224L754.073 170.33C756.125 173.399 757.812 174.948 761.466 174.948H766.498C769.59 174.948 771.137 173.118 771.137 169.486V109.122C771.137 78.0388 751.458 63.5672 709.206 63.5672"/>
            <path d="M353.763 142.289C338.723 142.289 329.98 132.266 329.98 117.4C329.98 100.676 339.173 92.3144 353.566 92.3144C369.843 92.3144 377.77 101.296 377.77 117.4C377.77 134.744 367.959 142.289 353.763 142.289ZM363.574 63.2586C338.948 63.2586 324.133 73.2817 317.667 88.5416L305.157 70.3536C303.077 67.2284 301.39 65.7644 297.848 65.7644H292.619C289.499 65.7644 288.234 67.6508 288.234 71.0012V215.238H329.98V189.308C329.98 177.595 328.715 167.347 327.675 157.521C333.944 167.966 345.414 175.906 364.839 175.906C393.007 175.906 420.163 159.801 420.163 118.639C420.163 77.4768 392.81 63.2305 363.602 63.2305"/>
        </symbol>
        <symbol viewBox="0 0 24 24" id="icon-search">
            <path  d="M18.1,16c1.3-1.7,1.9-3.8,1.9-6,0-2.3-.8-4.5-2.2-6.2-1.4-1.8-3.4-3-5.6-3.5C10-.2,7.7,0,5.7,1,3.6,2,2,3.7,1,5.7,0,7.7-.3,10.1.3,12.3s1.8,4.2,3.5,5.6c1.8,1.4,4,2.2,6.2,2.2h0c2.1,0,4.2-.7,5.9-1.9l5.6,5.6.3.3,2.2-2.2-5.9-5.9ZM11.4,16.9c-1.4.3-2.7.1-4-.4-1.3-.5-2.4-1.4-3.1-2.6-.8-1.1-1.2-2.5-1.2-3.9s.7-3.6,2-4.9c1.3-1.3,3.1-2,4.9-2s2.7.4,3.9,1.2c1.1.8,2,1.8,2.6,3.1.5,1.3.7,2.7.4,4-.3,1.4-.9,2.6-1.9,3.6s-2.2,1.6-3.6,1.9Z"/>
        </symbol>
        <symbol viewBox="0 0 24 24" id="icon-search">
            <path d="M18.1,16c1.3-1.7,1.9-3.8,1.9-6,0-2.3-.8-4.5-2.2-6.2-1.4-1.8-3.4-3-5.6-3.5C10-.2,7.7,0,5.7,1,3.6,2,2,3.7,1,5.7,0,7.7-.3,10.1.3,12.3s1.8,4.2,3.5,5.6c1.8,1.4,4,2.2,6.2,2.2h0c2.1,0,4.2-.7,5.9-1.9l5.6,5.6.3.3,2.2-2.2-5.9-5.9ZM11.4,16.9c-1.4.3-2.7.1-4-.4-1.3-.5-2.4-1.4-3.1-2.6-.8-1.1-1.2-2.5-1.2-3.9s.7-3.6,2-4.9c1.3-1.3,3.1-2,4.9-2s2.7.4,3.9,1.2c1.1.8,2,1.8,2.6,3.1.5,1.3.7,2.7.4,4-.3,1.4-.9,2.6-1.9,3.6s-2.2,1.6-3.6,1.9Z"/>
        </symbol>
        <symbol viewBox="0 0 24 16" id="icon-views">
            <path d="M23.7,7.6C17.8-1.8,5.6-1.5,0,8c5.7,9.7,18.3,9.7,24,0l-.3-.4ZM22.1,8c-5.3,7.7-15,7.7-20.2,0C7.2.3,16.8.3,22.1,8Z"/>
            <path d="M12,3.3c-2.6,0-4.7,2.1-4.7,4.7s2.1,4.7,4.7,4.7,4.7-2.1,4.7-4.7-2.1-4.7-4.7-4.7ZM15.2,8c0,1.7-1.4,3.2-3.2,3.2s-3.2-1.4-3.2-3.2,1.4-3.2,3.2-3.2,3.2,1.4,3.2,3.2Z"/>
        </symbol>
    </svg>

    <?php
    /** Top part of header with big logo and quick navigation
     * only shown on front page
     * expanded on other pages via javascript when users scrolls all the way to the top
     */ ?>
    <header role="banner" id="top-header" class="ff-grotesk bg-primary p-4 px-md-5 collapse<?php if ($is_front): echo ' show';
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
                    <<?php if ($is_front): echo 'h1'; else: echo 'div'; endif;?> class="mb-0 col-auto flex-grow-1 ps-md-6">
                        <svg id="main-logo" viewBox="0 0 837 216">
                            <use xlink:href="#kapital-logo"></use>
                        </svg>
                        <div class="visually-hidden"><?php echo get_bloginfo('name'); ?></div>
                    </<?php if ($is_front): echo 'h1'; else: echo 'div'; endif;?>>
            </div>
        </div>
    </header>

    <nav id="horizontal-nav" class="fw-bold ff-grotesk px-4 px-md-3 bg-primary position-sticky">
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