// webpack.mix.js

let mix = require('laravel-mix');
require('laravel-mix-purgecss');
let safelist = {
    standard: [
        /^text/,
        /^bg-/,
        /^has-/,
        /^p.-/,
        /^m.-/,
        /^g.-/,
        /^fw-/,
        /^col-/,
        /^d-/,
        /^offcanvas/,
        /visible$/,
        /^lh-sm/, 
        /^border-/,
        /button/,
        /^pwgc/
    ],
    deep: [
        /^align/,
        /btn/,
        /bubble-heading/,
        /is-root-container/,
        /^quick-menu/,
        /^offcanvas/,
        /^h[1-6]/,
        /menu-item/,
        /rounded-pill/,
        /^text-decoration/, 
        /button/,
        /^input/
    ]
}

// Config

mix.webpackConfig({
    stats: {
        children: true
    },
});

// CSS

mix.
    sass('assets/styles/style.scss', 'style.css')
    .options({
        processCssUrls: false,
    })
    .purgeCss({
        content: [
            '**/*.php',
            '**/*.js',
            '../../plugins/woocommerce/**/*.php'
        ],
        safelist: safelist
    });
mix.
    sass('assets/styles/editor_styles.scss', 'editor_styles.css')
    .options({
        processCssUrls: false,
    })
    .purgeCss({
        content: [
            '**/*.php',
            '**/*.js',
            '../../plugins/woocommerce/**/*.php'
        ],
        safelist: safelist
    });

// JS

mix
    .js([
        'assets/scripts/scripts.js'
    ], 'js/scripts.min.js');

mix
.js([
    'assets/scripts/admin-filter-selector.js'
], 'js/admin-filter-selector.min.js');
mix
.js([
    'assets/scripts/cart-quantity-script.js'
], 'js/cart-quantity.min.js');

mix
.js([
    'assets/scripts/admin-load-post-views.js'
], 'js/admin-load-post-views.min.js');

mix.browserSync({
    https: true,
    ui: false,
    proxy: { target: 'https://localhost/kapital_new/' },
    host: 'https://localhost/kapital_new/',
    files: [
        "style.css",
        "js/scripts.min.js",
        "*.php"
    ]
}
);