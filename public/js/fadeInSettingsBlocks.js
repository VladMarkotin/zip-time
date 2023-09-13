/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/fadeInSettingsBlocks.js ***!
  \**********************************************/
document.addEventListener('DOMContentLoaded', function () {
  var savedTasksButton = document.querySelector('.saved-tasks-button');
  var statisticButton = document.querySelector('.statistic-button');
  var personalSettingsButton = document.querySelector('.personal-settings-button');
  // console.log(btn);

  savedTasksButton.addEventListener('click', function () {
    var table = document.querySelector('.saved-tasks-table');
    table.style.display == 'none' ? table.style.display = 'block' : table.style.display = 'none';
  });
  statisticButton.addEventListener('click', function () {
    var table = document.querySelector('.statistic-block');
    table.style.display == 'none' ? table.style.display = 'block' : table.style.display = 'none';
  });
  personalSettingsButton.addEventListener('click', function () {
    var table = document.querySelector('.personal-settings-block');
    table.style.display == 'none' ? table.style.display = 'block' : table.style.display = 'none';
  });
});
/******/ })()
;