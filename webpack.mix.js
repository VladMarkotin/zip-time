const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')

	mix.scripts([
    'resources/js/smooth.js',
    'resources/js/hidden.js',
    'resources/js/faq.js',
], 'public/js/style-index.js');

mix.sass('resources/sass/index-style.scss', 'public/css/index.css')