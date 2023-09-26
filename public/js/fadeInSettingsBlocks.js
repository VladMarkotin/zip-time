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

    // table.style.display == ('none') ?   table.style.display = 'block' : 
    //                                     table.style.display = 'none';

    if (table.style.display == 'none') {
      setTimeout(function () {
        table.style.display = 'block';
      }, 50);
      this.classList.add('onclick');
    } else {
      table.style.display = 'none';
      this.classList.remove('onclick');
    }
  });
  statisticButton.addEventListener('click', function () {
    var table = document.querySelector('.statistic-block');

    // table.style.display == ('none') ?   table.style.display = 'block' : 
    //                                     table.style.display = 'none';

    if (table.style.display == 'none') {
      setTimeout(function () {
        table.style.display = 'block';
      }, 50);
      this.classList.add('onclick');
    } else {
      table.style.display = 'none';
      this.classList.remove('onclick');
    }
  });
  personalSettingsButton.addEventListener('click', function () {
    var table = document.querySelector('.personal-settings-block');

    // table.style.display == ('none') ?   table.style.display = 'block' : 
    //                                     table.style.display = 'none';

    if (table.style.display == 'none') {
      setTimeout(function () {
        table.style.display = 'block';
      }, 50);
      this.classList.add('onclick');
    } else {
      table.style.display = 'none';
      this.classList.remove('onclick');
    }
  });
});
/******/ })()
;