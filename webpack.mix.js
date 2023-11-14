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

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/design/main.js', 'public/js')
    .js('resources/js/design/plugins.js', 'public/js')
    .js('resources/js/design/owl.carousel.min.js', 'public/js')
    .js('resources/js/design/masonry.pkgd.js', 'public/js')
    .js('resources/js/design/masonry.pkgd.min.js', 'public/js')

    .js('resources/js/design/waypoints.min.js', 'public/js')

    .js('resources/js/design/ajax-mail.js', 'public/js')
    .js('resources/js/design/jquery.counterup.min.js', 'public/js')
    .js('resources/js/design/jquery.magnific-popup.min.js', 'public/js')
    .js('resources/js/design/jquery.mb.YTPlayer.min.js', 'public/js')

    .js('resources/js/design/jquery.meanmenu.js', 'public/js')
    .js('resources/js/design/jquery.mixitup.min.js', 'public/js')
    .js('resources/js/design/jquery.nav.js', 'public/js')
    .js('resources/js/design/jquery.parallax-1.1.3.js', 'public/js')

    .js('resources/js/design/vendor/jquery-1.12.0.min', 'public/js')
    .js('resources/js/design/vendor/modernizr-2.8.3.min', 'public/js')

    
    .vue()

    mix.styles([
        'resources/css/app.css',
        'resources/css/animate.css',
        'resources/css/animate-text.css',
        'resources/css/bootstrap.min.css',
        'resources/css/et-line.css',

    ], 'public/css/all.css')

    .sass('resources/sass/app.scss', 'public/css/style.css')
    .sass('resources/sass/customTooltip/customTooltip.scss', 'public/css/style.css'); 
