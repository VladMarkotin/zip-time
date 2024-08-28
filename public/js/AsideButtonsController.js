/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/AsideButtonsController.js ***!
  \************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : String(i); }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _classPrivateFieldInitSpec(obj, privateMap, value) { _checkPrivateRedeclaration(obj, privateMap); privateMap.set(obj, value); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _classPrivateFieldGet(receiver, privateMap) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "get"); return _classApplyDescriptorGet(receiver, descriptor); }
function _classApplyDescriptorGet(receiver, descriptor) { if (descriptor.get) { return descriptor.get.call(receiver); } return descriptor.value; }
function _classPrivateFieldSet(receiver, privateMap, value) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "set"); _classApplyDescriptorSet(receiver, descriptor, value); return value; }
function _classExtractFieldDescriptor(receiver, privateMap, action) { if (!privateMap.has(receiver)) { throw new TypeError("attempted to " + action + " private field on non-instance"); } return privateMap.get(receiver); }
function _classApplyDescriptorSet(receiver, descriptor, value) { if (descriptor.set) { descriptor.set.call(receiver, value); } else { if (!descriptor.writable) { throw new TypeError("attempted to set read only private field"); } descriptor.value = value; } }
var _asideButtonsActivator = /*#__PURE__*/new WeakMap();
var _addLogButton = /*#__PURE__*/new WeakMap();
var _sendFeedbackButton = /*#__PURE__*/new WeakMap();
var _asideButtons = /*#__PURE__*/new WeakMap();
var AsideButtonsController = /*#__PURE__*/function () {
  function AsideButtonsController() {
    _classCallCheck(this, AsideButtonsController);
    _classPrivateFieldInitSpec(this, _asideButtonsActivator, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _addLogButton, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sendFeedbackButton, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _asideButtons, {
      writable: true,
      value: null
    });
  }
  _createClass(AsideButtonsController, [{
    key: "init",
    value: function init() {
      _classPrivateFieldSet(this, _asideButtonsActivator, document.querySelector('.aside-buttons-activator-wrapper'));
      _classPrivateFieldSet(this, _addLogButton, document.querySelector('.backlog-add-button'));
      _classPrivateFieldSet(this, _sendFeedbackButton, document.querySelector('.feedback-button'));
      _classPrivateFieldSet(this, _asideButtons, [_classPrivateFieldGet(this, _addLogButton), _classPrivateFieldGet(this, _sendFeedbackButton)]);
      window.addEventListener('resize', this.checkWindowWidth.bind(this));
      this.checkWindowWidth();
    }
  }, {
    key: "checkWindowWidth",
    value: function checkWindowWidth() {
      if (window.innerWidth <= 450) {
        _classPrivateFieldGet(this, _asideButtonsActivator).onclick = this.asideButtonsActivatorHandl.bind(this);
        if (_classPrivateFieldGet(this, _asideButtonsActivator).classList.contains('active')) {
          _classPrivateFieldGet(this, _asideButtonsActivator).classList.remove('active');
        }
      } else {
        _classPrivateFieldGet(this, _asideButtonsActivator).onclick = null;
        this.closeAsideButtons();
      }
    }
  }, {
    key: "asideButtonsActivatorHandl",
    value: function asideButtonsActivatorHandl(e) {
      var isShowAsideButtons = !e.target.classList.contains('active');
      if (isShowAsideButtons) {
        _classPrivateFieldGet(this, _asideButtonsActivator).classList.add('active');
        _classPrivateFieldGet(this, _asideButtons).forEach(function (button) {
          button && button.classList.add('aside-button-visible');
        });
      } else {
        _classPrivateFieldGet(this, _asideButtonsActivator).classList.remove('active');
        this.closeAsideButtons();
      }
    }
  }, {
    key: "closeAsideButtons",
    value: function closeAsideButtons() {
      _classPrivateFieldGet(this, _asideButtons).forEach(function (button) {
        button && button.classList.remove('aside-button-visible');
      });
    }
  }]);
  return AsideButtonsController;
}();
var asideButtonsController = new AsideButtonsController();
asideButtonsController.init();
/******/ })()
;