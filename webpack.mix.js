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
        /^fs-/,
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
        /^input/,
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
    sass('assets/styles/style.scss', 'css/style.css')
    .options({
        processCssUrls: false,
    });

mix.
    sass('assets/styles/editor_styles.scss', 'css/editor_styles.css')
    .options({
        processCssUrls: false,
    });

mix.purgeCss({
    content: [
        '**/*.php',
        '**/*.js',
        '../../plugins/woocommerce/**/*.php',
        'js/plyr.min.js'
    ],
    css: ['css/editor_styles.css', 'css/style.css'],
    safelist: safelist,
});


mix.
    sass('assets/styles/plyr/plyr.scss', 'css/plyr-custom.min.css')
    .options({
        processCssUrls: false,
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

mix
    .js([
        'assets/scripts/masonry.js'
    ], 'js/masonry.min.js');

mix
    .js([
        'assets/scripts/plyr-audio-player.js'
    ], 'js/plyr-init.min.js');

mix.browserSync({
    https: true,
    ui: false,
    port: 3000,
    open: 'external',
    proxy: 'kapital_new.test',
    host: 'kapital_new.test',
    files: [
        "css/style.css",
        "css/plyr-custom.min.css",
        "js/scripts.min.js",
        "*.php"
    ]
}
);