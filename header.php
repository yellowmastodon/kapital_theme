<!DOCTYPE html>
<!--[if IE 8]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if lte IE 9]><html <?php language_attributes(); ?> class="ie9"><![endif]-->
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="dns-prefetch" href="//google-analytics.com">
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

<body <?php body_class(); ?>>
    <div class="bg-primary p-4">
        <div class="d-flex flex-row">
            <nav aria-label="Rýchle menu" aria-role="menu">
                <?php wp_nav_menu(
                    array(
                        'menu' => 'main',
                    )

                ) ?>
            </nav>
            <header class="header" role="banner">
                kapital
            </header>
        </div>
        <nav>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">Menu</button>
            <div class="offcanvas offcanvas-start" tabindex="1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-body">
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

        </nav>

    </div>
