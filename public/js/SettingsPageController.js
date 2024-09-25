/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/settingsPage/SettingsPageAccordion.js":
/*!************************************************************!*\
  !*** ./resources/js/settingsPage/SettingsPageAccordion.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
var _accordionHeads = /*#__PURE__*/new WeakMap();
var _accordionBodies = /*#__PURE__*/new WeakMap();
var _accrodionHeadActiveClass = /*#__PURE__*/new WeakMap();
var _localStorageKey = /*#__PURE__*/new WeakMap();
var SettingsPageAccordion = /*#__PURE__*/function () {
  function SettingsPageAccordion() {
    _classCallCheck(this, SettingsPageAccordion);
    _classPrivateFieldInitSpec(this, _accordionHeads, {
      writable: true,
      value: []
    });
    _classPrivateFieldInitSpec(this, _accordionBodies, {
      writable: true,
      value: []
    });
    _classPrivateFieldInitSpec(this, _accrodionHeadActiveClass, {
      writable: true,
      value: 'accordion-head-active'
    });
    _classPrivateFieldInitSpec(this, _localStorageKey, {
      writable: true,
      value: 'activeAccodrionId'
    });
  }
  _createClass(SettingsPageAccordion, [{
    key: "init",
    value: function init() {
      _classPrivateFieldSet(this, _accordionHeads, document.querySelectorAll('.saved-tasks-table-body .accordion-head'));
      _classPrivateFieldSet(this, _accordionBodies, document.querySelectorAll('.saved-tasks-table-body .accordion-body'));
      var savedId = localStorage.getItem(_classPrivateFieldGet(this, _localStorageKey));
      if (savedId) {
        var id = JSON.parse(savedId);
        var heads = _classPrivateFieldGet(this, _accordionHeads);
        for (var i = 0; i < heads.length; i++) {
          if (heads[i].dataset.id === id) {
            heads[i].classList.add(_classPrivateFieldGet(this, _accrodionHeadActiveClass));
            break;
          }
        }
      }
      this.addClickHandler();
      function beforeUnloadHandler() {
        localStorage.removeItem(_classPrivateFieldGet(this, _localStorageKey));
      }
      window.addEventListener('beforeunload', beforeUnloadHandler.bind(this));
    }
  }, {
    key: "addClickHandler",
    value: function addClickHandler() {
      var _this = this;
      _classPrivateFieldGet(this, _accordionHeads).forEach(function (item) {
        item.onclick = function (e) {
          _classPrivateFieldGet(_this, _accordionHeads).forEach(function (item) {
            if (item === e.target) {
              var id = e.target.dataset.id;
              _this.saveId(id);
              item.classList.toggle(_classPrivateFieldGet(_this, _accrodionHeadActiveClass));
            } else item.classList.remove(_classPrivateFieldGet(_this, _accrodionHeadActiveClass));
          });
        };
      });
    }
  }, {
    key: "saveId",
    value: function saveId(id) {
      localStorage.setItem(_classPrivateFieldGet(this, _localStorageKey), JSON.stringify(id));
    }
  }]);
  return SettingsPageAccordion;
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SettingsPageAccordion);

/***/ }),

/***/ "./resources/js/settingsPage/SettingsPageSidebar.js":
/*!**********************************************************!*\
  !*** ./resources/js/settingsPage/SettingsPageSidebar.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
var _settingsTableTabs = /*#__PURE__*/new WeakMap();
var _settingsSidebarBtn = /*#__PURE__*/new WeakMap();
var _settingsTableTabsMobileClass = /*#__PURE__*/new WeakMap();
var _settingsTableTabsMobileVisClass = /*#__PURE__*/new WeakMap();
var _settingsSidebarBtnVisClass = /*#__PURE__*/new WeakMap();
var SettingsPageSidebar = /*#__PURE__*/function () {
  function SettingsPageSidebar() {
    _classCallCheck(this, SettingsPageSidebar);
    _classPrivateFieldInitSpec(this, _settingsTableTabs, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _settingsSidebarBtn, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _settingsTableTabsMobileClass, {
      writable: true,
      value: 'sidebar-mobile'
    });
    _classPrivateFieldInitSpec(this, _settingsTableTabsMobileVisClass, {
      writable: true,
      value: 'sidebar-mobile-visible'
    });
    _classPrivateFieldInitSpec(this, _settingsSidebarBtnVisClass, {
      writable: true,
      value: 'settings-sidebar-btn-visible'
    });
  }
  _createClass(SettingsPageSidebar, [{
    key: "init",
    value: function init() {
      _classPrivateFieldSet(this, _settingsTableTabs, document.body.querySelector('.settings-table-tabs-wrapper'));
      _classPrivateFieldSet(this, _settingsSidebarBtn, document.body.querySelector('.settings-sidebar-btn'));
      window.addEventListener('resize', this.checkWindowWidth.bind(this));
      this.checkWindowWidth();
    }
  }, {
    key: "checkWindowWidth",
    value: function checkWindowWidth() {
      var _this = this;
      if (window.innerWidth <= 1265) {
        _classPrivateFieldGet(this, _settingsTableTabs) && _classPrivateFieldGet(this, _settingsTableTabs).classList.add(_classPrivateFieldGet(this, _settingsTableTabsMobileClass));
        if (_classPrivateFieldGet(this, _settingsSidebarBtn)) {
          _classPrivateFieldGet(this, _settingsSidebarBtn).classList.add(_classPrivateFieldGet(this, _settingsSidebarBtnVisClass));
          _classPrivateFieldGet(this, _settingsSidebarBtn).onclick = this.sidebarBtnActivatorHandl.bind(this);
        }
      } else {
        _classPrivateFieldGet(this, _settingsSidebarBtn) && _classPrivateFieldGet(this, _settingsSidebarBtn).classList.remove(_classPrivateFieldGet(this, _settingsSidebarBtnVisClass));
        if (_classPrivateFieldGet(this, _settingsTableTabs)) {
          [_classPrivateFieldGet(this, _settingsTableTabsMobileVisClass)].forEach(function (remClass) {
            _classPrivateFieldGet(_this, _settingsTableTabs).classList.remove(remClass);
          });
        }
      }
    }
  }, {
    key: "sidebarBtnActivatorHandl",
    value: function sidebarBtnActivatorHandl() {
      _classPrivateFieldGet(this, _settingsTableTabs).classList.add(_classPrivateFieldGet(this, _settingsTableTabsMobileVisClass));
      document.body.onclick = this.closeSideBarHandl.bind(this);
    }
  }, {
    key: "closeSideBarHandl",
    value: function closeSideBarHandl(e) {
      var target = e.target;
      if (target.classList.contains('settings-sidebar-btn')) return; //костыль, что бы избавиться от бага с открытием

      while (target) {
        if (target.classList && target.classList.contains('sidebar-mobile-visible')) {
          return;
        }
        target = target.parentNode;
      }
      _classPrivateFieldGet(this, _settingsTableTabs).classList.remove(_classPrivateFieldGet(this, _settingsTableTabsMobileVisClass));
      document.body.onclick = null;
    }
  }]);
  return SettingsPageSidebar;
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SettingsPageSidebar);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*************************************************************!*\
  !*** ./resources/js/settingsPage/SettingsPageController.js ***!
  \*************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SettingsPageSidebar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SettingsPageSidebar */ "./resources/js/settingsPage/SettingsPageSidebar.js");
/* harmony import */ var _SettingsPageAccordion__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SettingsPageAccordion */ "./resources/js/settingsPage/SettingsPageAccordion.js");
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


var _settingsPageSidebar = /*#__PURE__*/new WeakMap();
var _settingsPageAccordion = /*#__PURE__*/new WeakMap();
var SettingsPageController = /*#__PURE__*/function () {
  function SettingsPageController() {
    _classCallCheck(this, SettingsPageController);
    _classPrivateFieldInitSpec(this, _settingsPageSidebar, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _settingsPageAccordion, {
      writable: true,
      value: null
    });
  }
  _createClass(SettingsPageController, [{
    key: "init",
    value: function init(settingsPageSidebar, settingsPageAccordion) {
      _classPrivateFieldSet(this, _settingsPageSidebar, new settingsPageSidebar());
      _classPrivateFieldSet(this, _settingsPageAccordion, new settingsPageAccordion());
      _classPrivateFieldGet(this, _settingsPageSidebar).init();
      _classPrivateFieldGet(this, _settingsPageAccordion).init();
      var self = this;
      window.livewire.on('rerender', function () {
        _classPrivateFieldGet(self, _settingsPageSidebar).init();
        _classPrivateFieldGet(self, _settingsPageAccordion).init();
      });
    }
  }]);
  return SettingsPageController;
}();
var settingsPageController = new SettingsPageController();
settingsPageController.init(_SettingsPageSidebar__WEBPACK_IMPORTED_MODULE_0__["default"], _SettingsPageAccordion__WEBPACK_IMPORTED_MODULE_1__["default"]);
})();

/******/ })()
;