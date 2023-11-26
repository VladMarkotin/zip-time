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
    .js([
        'resources/js/indexPage/Slider.js',
        'resources/js/indexPage/NavMenu.js',
        'resources/js/indexPage/OurAdvantages.js',
        'resources/js/indexPage/ReviewsSlider.js',
        'resources/js/indexPage/BlocksAppearanceController.js',
    ], 'public/js/indexPage.js')
    .vue()
    .css('resources/css/app.css', 'public/css/app.css')
    .sass('resources/sass/indexPage/indexPage.scss', 'public/css/indexPage')
    .sass('resources/sass/indexPage/indexPageMedia.scss', 'public/css/indexPage')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/customTooltip/customTooltip.scss', 'public/css');
