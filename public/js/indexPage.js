/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/indexPage/Slider.js ***!
  \******************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
var slides = document.body.querySelectorAll('.slide');
var slider = new Array();
var sliderWrapper = document.querySelector('.slider-wrapper');
var currentWidth = window.innerWidth;
var sliderLeftArrow = document.querySelector('.slider-left-arrow-wrapper');
var sliderRightArrow = document.querySelector('.slider-right-arrow-wrapper');
console.log(sliderRightArrow);
var _iterator = _createForOfIteratorHelper(slides),
  _step;
try {
  for (_iterator.s(); !(_step = _iterator.n()).done;) {
    var item = _step.value;
    slider.push(item.classList.value.split(' '));
    item.remove();
  }
} catch (err) {
  _iterator.e(err);
} finally {
  _iterator.f();
}
var step = 0;
var offset = 0;
var draw = function draw() {
  var slide = document.createElement('div');
  var _iterator2 = _createForOfIteratorHelper(slider[step]),
    _step2;
  try {
    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
      var item = _step2.value;
      slide.classList.add(item);
    }
  } catch (err) {
    _iterator2.e(err);
  } finally {
    _iterator2.f();
  }
  slide.style.left = offset * currentWidth + 'px';
  sliderWrapper.appendChild(slide);
  if (step + 1 === slider.length) {
    step = 0;
  } else {
    step++;
  }
  offset = 1;
};
var right = function right() {
  var slides = document.querySelectorAll('.slide');
  var offset = 0;
  var _iterator3 = _createForOfIteratorHelper(slides),
    _step3;
  try {
    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
      var item = _step3.value;
      item.style.left = offset * currentWidth - currentWidth + 'px';
      offset++;
    }
  } catch (err) {
    _iterator3.e(err);
  } finally {
    _iterator3.f();
  }
  setTimeout(function () {
    slides[0].remove();
    draw();
  }, 600);
};
var left = function left() {
  var slides = document.querySelectorAll('.slide');
  var offset = 0;
  var _iterator4 = _createForOfIteratorHelper(slides),
    _step4;
  try {
    for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
      var item = _step4.value;
      item.style.left = offset * currentWidth - currentWidth + 'px';
      offset++;
    }
  } catch (err) {
    _iterator4.e(err);
  } finally {
    _iterator4.f();
  }
  setTimeout(function () {
    slides[0].remove();
    draw();
  }, 600);
};
draw();
draw();
sliderRightArrow.addEventListener('click', right);
sliderLeftArrow.addEventListener('click', left);
/******/ })()
;