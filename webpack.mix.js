// webpack.mix.js

let mix = require('laravel-mix');
require('laravel-mix-purgecss');

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
            '*.php',
        ],
        safelist: {
            standard: [
                /^btn-/,
                /^text/,
                /^bg-/,
                /^has-/,
                /^align-/,
                /^p.-/,
                /^m.-/,
                /^g.-/,
                /^fw-/,
                /^col-/,
                /^d-/,
                /^offcanvas/,
                /visible$/,
            ],
            deep: [
                /bubble-heading/,
                /^quick-menu/,
                /^offcanvas/
            ]
        }
    });
mix.
    sass('assets/styles/editor_styles.scss', 'editor_styles.css')
    .options({
        processCssUrls: false,
    })
    .purgeCss({
        content: [
            '*.php',
        ],
        safelist: {
            standard: [
                /^btn-/,
                /^text/,
                /^bg-/,
                /^has-/,
                /^align-/,
                /^p.-/,
                /^m.-/,
                /^g.-/,
                /^fw-/,
                /^col-/,
                /^d-/,
                /^offcanvas/,
                /visible$/,
            ],
            deep: [
                /bubble-heading/,
                /^quick-menu/,
                /^offcanvas/
            ]
        }
    });

// JS

mix
    .js([
        'assets/scripts/scripts.js'
    ], 'js/scripts.min.js');


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