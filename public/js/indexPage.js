/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!******************************************!*\
  !*** ./resources/js/indexPage/Slider.js ***!
  \******************************************/
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _classPrivateFieldInitSpec(obj, privateMap, value) { _checkPrivateRedeclaration(obj, privateMap); privateMap.set(obj, value); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _classPrivateFieldGet(receiver, privateMap) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "get"); return _classApplyDescriptorGet(receiver, descriptor); }
function _classApplyDescriptorGet(receiver, descriptor) { if (descriptor.get) { return descriptor.get.call(receiver); } return descriptor.value; }
function _classPrivateFieldSet(receiver, privateMap, value) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "set"); _classApplyDescriptorSet(receiver, descriptor, value); return value; }
function _classExtractFieldDescriptor(receiver, privateMap, action) { if (!privateMap.has(receiver)) { throw new TypeError("attempted to " + action + " private field on non-instance"); } return privateMap.get(receiver); }
function _classApplyDescriptorSet(receiver, descriptor, value) { if (descriptor.set) { descriptor.set.call(receiver, value); } else { if (!descriptor.writable) { throw new TypeError("attempted to set read only private field"); } descriptor.value = value; } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var SlideItem = /*#__PURE__*/_createClass(function SlideItem(classes, content) {
  _classCallCheck(this, SlideItem);
  _defineProperty(this, "content", null);
  _defineProperty(this, "classes", null);
  this.classes = classes;
  this.content = content;
});
var _slider = /*#__PURE__*/new WeakMap();
var _sliderWrapper = /*#__PURE__*/new WeakMap();
var _currentWidth = /*#__PURE__*/new WeakMap();
var _step = /*#__PURE__*/new WeakMap();
var _offset = /*#__PURE__*/new WeakMap();
var _sliderLeftArrow = /*#__PURE__*/new WeakMap();
var Slider = /*#__PURE__*/function () {
  function Slider() {
    _classCallCheck(this, Slider);
    _classPrivateFieldInitSpec(this, _slider, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderWrapper, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _currentWidth, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _step, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _offset, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderLeftArrow, {
      writable: true,
      value: null
    });
  }
  _createClass(Slider, [{
    key: "init",
    value: function init(allSlides) {
      var slides = document.body.querySelectorAll('.slide');
      _classPrivateFieldSet(this, _slider, new Array());
      _classPrivateFieldSet(this, _sliderWrapper, document.querySelector('.slider-wrapper'));
      _classPrivateFieldSet(this, _currentWidth, window.innerWidth);
      _classPrivateFieldSet(this, _sliderLeftArrow, document.querySelector('.slider-left-arrow-wrapper'));
      var _iterator = _createForOfIteratorHelper(slides),
        _step2;
      try {
        for (_iterator.s(); !(_step2 = _iterator.n()).done;) {
          var item = _step2.value;
          _classPrivateFieldGet(this, _slider).push(new SlideItem(item.classList.value.split(' '), item.innerHTML));
          item.remove();
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
      var _iterator2 = _createForOfIteratorHelper(allSlides),
        _step3;
      try {
        for (_iterator2.s(); !(_step3 = _iterator2.n()).done;) {
          var slide = _step3.value;
          //вот тут лучше не трогать
          var allSlidesClasses = slide.classes;
          var allSlideMainClass = allSlidesClasses[1];
          if (!_classPrivateFieldGet(this, _slider).map(function (item) {
            return item.classes[1];
          }).includes(allSlideMainClass)) {
            _classPrivateFieldGet(this, _slider).push(slide);
          }
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
      _classPrivateFieldSet(this, _step, 0);
      _classPrivateFieldSet(this, _offset, 0);
      this.draw();
      this.draw();
      this.left = this.left.bind(this);
      _classPrivateFieldGet(this, _sliderLeftArrow).onclick = this.left;
    }
  }, {
    key: "draw",
    value: function draw() {
      var slide = document.createElement('div');
      var currentItem = _classPrivateFieldGet(this, _slider)[_classPrivateFieldGet(this, _step)];
      var _iterator3 = _createForOfIteratorHelper(currentItem.classes),
        _step4;
      try {
        for (_iterator3.s(); !(_step4 = _iterator3.n()).done;) {
          var item = _step4.value;
          slide.classList.add(item);
        }
      } catch (err) {
        _iterator3.e(err);
      } finally {
        _iterator3.f();
      }
      slide.innerHTML = currentItem.content;
      slide.style.left = _classPrivateFieldGet(this, _offset) * _classPrivateFieldGet(this, _currentWidth) + 'px';
      _classPrivateFieldGet(this, _sliderWrapper).appendChild(slide);
      if (_classPrivateFieldGet(this, _step) + 1 === _classPrivateFieldGet(this, _slider).length) {
        _classPrivateFieldSet(this, _step, 0);
      } else {
        var _this$step, _this$step2;
        _classPrivateFieldSet(this, _step, (_this$step = _classPrivateFieldGet(this, _step), _this$step2 = _this$step++, _this$step)), _this$step2;
      }
      _classPrivateFieldSet(this, _offset, 1);
    }
  }, {
    key: "left",
    value: function left() {
      var _this = this;
      _classPrivateFieldGet(this, _sliderLeftArrow).onclick = null;
      var slides = document.querySelectorAll('.slide');
      var offset = 0;
      var _iterator4 = _createForOfIteratorHelper(slides),
        _step5;
      try {
        for (_iterator4.s(); !(_step5 = _iterator4.n()).done;) {
          var item = _step5.value;
          item.style.left = offset * _classPrivateFieldGet(this, _currentWidth) - _classPrivateFieldGet(this, _currentWidth) + 'px';
          offset++;
        }
      } catch (err) {
        _iterator4.e(err);
      } finally {
        _iterator4.f();
      }
      setTimeout(function () {
        slides[0].remove();
        _this.draw();
        _classPrivateFieldGet(_this, _sliderLeftArrow).onclick = _this.left;
      }, 600);
    }
  }]);
  return Slider;
}();
var _slider2 = /*#__PURE__*/new WeakMap();
var SliderFacade = /*#__PURE__*/function () {
  function SliderFacade(slider) {
    _classCallCheck(this, SliderFacade);
    _classPrivateFieldInitSpec(this, _slider2, {
      writable: true,
      value: null
    });
    _defineProperty(this, "slides", new Array());
    _classPrivateFieldSet(this, _slider2, slider);
    var slides = document.body.querySelectorAll('.slide');
    var _iterator5 = _createForOfIteratorHelper(slides),
      _step6;
    try {
      for (_iterator5.s(); !(_step6 = _iterator5.n()).done;) {
        var item = _step6.value;
        this.slides.push(new SlideItem(item.classList.value.split(' '), item.innerHTML));
      }
    } catch (err) {
      _iterator5.e(err);
    } finally {
      _iterator5.f();
    }
  }
  _createClass(SliderFacade, [{
    key: "init",
    value: function init() {
      _classPrivateFieldGet(this, _slider2).init(this.slides);
    }
  }]);
  return SliderFacade;
}();
var slider = new SliderFacade(new Slider());
slider.init();
window.addEventListener('resize', function () {
  slider.init();
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*******************************************!*\
  !*** ./resources/js/indexPage/NavMenu.js ***!
  \*******************************************/
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classPrivateFieldInitSpec(obj, privateMap, value) { _checkPrivateRedeclaration(obj, privateMap); privateMap.set(obj, value); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _classPrivateFieldGet(receiver, privateMap) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "get"); return _classApplyDescriptorGet(receiver, descriptor); }
function _classApplyDescriptorGet(receiver, descriptor) { if (descriptor.get) { return descriptor.get.call(receiver); } return descriptor.value; }
function _classPrivateFieldSet(receiver, privateMap, value) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "set"); _classApplyDescriptorSet(receiver, descriptor, value); return value; }
function _classExtractFieldDescriptor(receiver, privateMap, action) { if (!privateMap.has(receiver)) { throw new TypeError("attempted to " + action + " private field on non-instance"); } return privateMap.get(receiver); }
function _classApplyDescriptorSet(receiver, descriptor, value) { if (descriptor.set) { descriptor.set.call(receiver, value); } else { if (!descriptor.writable) { throw new TypeError("attempted to set read only private field"); } descriptor.value = value; } }
var _navMenu = /*#__PURE__*/new WeakMap();
var _navMenuHeight = /*#__PURE__*/new WeakMap();
var _stickyMenuClass = /*#__PURE__*/new WeakMap();
var NavMenu = /*#__PURE__*/function () {
  function NavMenu() {
    _classCallCheck(this, NavMenu);
    _classPrivateFieldInitSpec(this, _navMenu, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _navMenuHeight, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _stickyMenuClass, {
      writable: true,
      value: 'nav-menu-sticky'
    });
  }
  _createClass(NavMenu, [{
    key: "init",
    value: function init() {
      var _this = this;
      _classPrivateFieldSet(this, _navMenu, document.body.querySelector('.nav-menu'));
      _classPrivateFieldSet(this, _navMenuHeight, parseInt(window.getComputedStyle(_classPrivateFieldGet(this, _navMenu)).height));
      window.addEventListener('scroll', function () {
        var posTop = window.pageYOffset;
        if (posTop > _classPrivateFieldGet(_this, _navMenuHeight) + 150 && !_classPrivateFieldGet(_this, _navMenu).classList.contains(_classPrivateFieldGet(_this, _stickyMenuClass))) {
          _this.addClass();
        }
        if (posTop < _classPrivateFieldGet(_this, _navMenuHeight) + 150 && _classPrivateFieldGet(_this, _navMenu).classList.contains(_classPrivateFieldGet(_this, _stickyMenuClass))) {
          _this.removeClass();
        }
      });
    }
  }, {
    key: "addClass",
    value: function addClass() {
      _classPrivateFieldGet(this, _navMenu).classList.add(_classPrivateFieldGet(this, _stickyMenuClass));
    }
  }, {
    key: "removeClass",
    value: function removeClass() {
      _classPrivateFieldGet(this, _navMenu).classList.remove(_classPrivateFieldGet(this, _stickyMenuClass));
    }
  }]);
  return NavMenu;
}();
var navMenu = new NavMenu();
navMenu.init();
})();

/******/ })()
;