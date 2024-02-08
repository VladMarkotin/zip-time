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
    .js('resources/js/indexPage/IndexPageController.js', 'public/js/IndexPageController.js')
    .js('resources/js/indexPage/NavMenu.js', 'public/js/NavMenu.js')
    .js('resources/js/PageSmoothAppear.js', 'public/js/PageSmoothAppear.js')
    .vue()
    .css('resources/css/app.css', 'public/css/app.css')
    .sass('resources/sass/indexPage/indexPage.scss', 'public/css/indexPage')
    .sass('resources/sass/indexPage/indexPageMedia.scss', 'public/css/indexPage')
    .sass('resources/sass/loginPage/loginPage.scss', 'public/css/loginPage')
    .sass('resources/sass/loginPage/loginPageMedia.scss', 'public/css/loginPage')
    .sass('resources/sass/privacyPolicyPage/privacyPolicyPage.scss', 'public/css/privacyPolicyPage')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/customTooltip/customTooltip.scss', 'public/css');
