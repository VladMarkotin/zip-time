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
    .js('resources/js/AsideButtonsController.js', 'public/js/AsideButtonsController.js')
    .js('resources/js/settingsPage/SettingsPageController', 'public/js/SettingsPageController.js')
    .vue()
    .css('resources/css/app.css', 'public/css/app.css')
    .sass('resources/sass/indexPage/indexPage.scss', 'public/css/indexPage')
    .sass('resources/sass/indexPage/indexPageMedia.scss', 'public/css/indexPage')
    .sass('resources/sass/loginPage/loginPage.scss', 'public/css/loginPage')
    .sass('resources/sass/loginPage/loginPageMedia.scss', 'public/css/loginPage')
    .sass('resources/sass/privacyPolicyPage/privacyPolicyPage.scss', 'public/css/privacyPolicyPage')
    .sass('resources/sass/privacyPolicyPage/privacyPolicyMedia.scss', 'public/css/privacyPolicyPage')
    .sass('resources/sass/termsOfUsePage/termsOfUsePage.scss', 'public/css/termsOfUsePage')
    .sass('resources/sass/termsOfUsePage/termsOfUseMedia.scss', 'public/css/termsOfUsePage')
    .sass('resources/sass/dataDeletionPolicyPage/dataDeletionPolicyPage.scss', 'public/css/dataDeletionPolicyPage')
    .sass('resources/sass/dataDeletionPolicyPage/dataDeletionPolicyMedia.scss', 'public/css/dataDeletionPolicyPage')
    .sass('resources/sass/settingsPage/settingsPage.scss', 'public/css/settingsPage')
    .sass('resources/sass/settingsPage/settingsPageMedia.scss', 'public/css/settingsPage')
    .sass('resources/sass/Cards/CardsMedia.scss', 'public/css/Cards')
    .sass('resources/sass/Card/CardMedia.scss', 'public/css/Card')
    .sass('resources/sass/Challenges/ChallengesMedia.scss', 'public/css/Challenges')
    .sass('resources/sass/EditCardData/EditCardDataMedia.scss', 'public/css/EditCardData')
    .sass('resources/sass/AddDetailsCard/AddDetailsCardMedia.scss', 'public/css/AddDetailsCard')
    .sass('resources/sass/AddNotes/AddNotesMedia.scss', 'public/css/AddNotes')
    .sass('resources/sass/AddNotesCard/AddNotesCardMedia.scss', 'public/css/AddNotesCard')
    .sass('resources/sass/Note/NoteMedia.scss', 'public/css/Note')
    .sass('resources/sass/AddJobTask/AddJobTaskMedia.scss', 'public/css/AddJobTask')
    .sass('resources/sass/EmergencyCall/EmergencyCallMedia.scss', 'public/css/EmergencyCall')
    .sass('resources/sass/EmergencyConfirmation/EmergencyConfirmationMedia.scss', 'public/css/EmergencyConfirmation')
    .sass('resources/sass/CloseDay/CloseDayMedia.scss', 'public/css/CloseDay')
    .sass('resources/sass/Plan/PlanMedia.scss', 'public/css/Plan')
    .sass('resources/sass/PreplanTasksTable/PreplanTasksTableMedia.scss', 'public/css/PreplanTasksTable')
    .sass('resources/sass/backlogPage/backlogPage.scss', 'public/css/backlogPage')
    .sass('resources/sass/backlogPage/backlogMedia.scss', 'public/css/backlogPage')
    .sass('resources/sass/ClosedReadyDayPlan/ClosedReadyDayPlanMedia.scss', 'public/css/ClosedReadyDayPlan')
    .sass('resources/sass/History/HistoryMedia.scss', 'public/css/History')
    .sass('resources/sass/CreateSubplanGPT/CreateSubplanGPTMedia.scss', 'public/css/CreateSubplanGPT')
    .sass('resources/sass/Stat/StatMedia.scss', 'public/css/Stat')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/customTooltip/customTooltip.scss', 'public/css');
