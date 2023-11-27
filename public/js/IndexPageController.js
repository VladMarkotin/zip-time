/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/indexPage/BlocksAppearanceController.js":
/*!**************************************************************!*\
  !*** ./resources/js/indexPage/BlocksAppearanceController.js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
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
var _animatedElements = /*#__PURE__*/new WeakMap();
var _ourAdvantagesItems = /*#__PURE__*/new WeakMap();
var _ourAdvantagesTimer = /*#__PURE__*/new WeakMap();
var _statisticsItems = /*#__PURE__*/new WeakMap();
var _statisticsTimer = /*#__PURE__*/new WeakMap();
var BlocksAppearanceController = /*#__PURE__*/function () {
  function BlocksAppearanceController() {
    _classCallCheck(this, BlocksAppearanceController);
    _classPrivateFieldInitSpec(this, _animatedElements, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _ourAdvantagesItems, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _ourAdvantagesTimer, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _statisticsItems, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _statisticsTimer, {
      writable: true,
      value: null
    });
  }
  _createClass(BlocksAppearanceController, [{
    key: "init",
    value: function init() {
      var _this = this;
      _classPrivateFieldSet(this, _animatedElements, document.querySelectorAll('.element-animation'));
      _classPrivateFieldSet(this, _ourAdvantagesItems, document.querySelectorAll('.our-advantages-item'));
      _classPrivateFieldSet(this, _statisticsItems, document.querySelectorAll('.statistics-item'));
      if (_classPrivateFieldGet(this, _ourAdvantagesItems).length) _classPrivateFieldSet(this, _ourAdvantagesTimer, getTimer(_classPrivateFieldGet(this, _ourAdvantagesItems), 200));
      if (_classPrivateFieldGet(this, _statisticsItems).length) _classPrivateFieldSet(this, _statisticsTimer, getTimer(_classPrivateFieldGet(this, _statisticsItems), 150));
      var options = {
        threshold: [0.5]
      };
      var observer = new IntersectionObserver(function (entry) {
        entry.forEach(function (change) {
          if (change.isIntersecting) {
            var isOuAdvItem = change.target.classList.contains('our-advantages-item');
            var isStatisticItem = change.target.classList.contains('statistics-item');
            switch (true) {
              case isOuAdvItem:
                _this.showList(change, _classPrivateFieldGet(_this, _ourAdvantagesTimer));
                break;
              case isStatisticItem:
                _this.showList(change, _classPrivateFieldGet(_this, _statisticsTimer));
                break;
              default:
                _this.addElemShowClass(change);
            }
          }
        });
      }, options);
      if (_classPrivateFieldGet(this, _animatedElements).length) {
        var _iterator = _createForOfIteratorHelper(_classPrivateFieldGet(this, _animatedElements)),
          _step;
        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var item = _step.value;
            observer.observe(item);
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }
      }
      function getTimer(items) {
        var interval = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
        return /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
          var i;
          return _regeneratorRuntime().wrap(function _callee$(_context) {
            while (1) switch (_context.prev = _context.next) {
              case 0:
                i = 1;
              case 1:
                if (!(i <= items.length)) {
                  _context.next = 7;
                  break;
                }
                _context.next = 4;
                return i * interval;
              case 4:
                i++;
                _context.next = 1;
                break;
              case 7:
              case "end":
                return _context.stop();
            }
          }, _callee);
        })();
      }
    }
  }, {
    key: "addElemShowClass",
    value: function addElemShowClass(elem) {
      elem.target.classList.add('element-show');
    }
  }, {
    key: "showList",
    value: function showList(change, generator) {
      var _this2 = this;
      var time = null;
      try {
        time = generator.next().value;
      } catch (e) {
        console.error(e);
      }
      setTimeout(function () {
        _this2.addElemShowClass(change);
      }, time ? time : 0);
    }
  }]);
  return BlocksAppearanceController;
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (BlocksAppearanceController);

/***/ }),

/***/ "./resources/js/indexPage/OurAdvantages.js":
/*!*************************************************!*\
  !*** ./resources/js/indexPage/OurAdvantages.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
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
var _ourAdvantagesItems = /*#__PURE__*/new WeakMap();
var _ourAdvantagesItemClass = /*#__PURE__*/new WeakMap();
var OurAdvantagesController = /*#__PURE__*/function () {
  function OurAdvantagesController() {
    _classCallCheck(this, OurAdvantagesController);
    _classPrivateFieldInitSpec(this, _ourAdvantagesItems, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _ourAdvantagesItemClass, {
      writable: true,
      value: 'our-advantages-item-focus'
    });
  }
  _createClass(OurAdvantagesController, [{
    key: "init",
    value: function init() {
      var _this = this;
      _classPrivateFieldSet(this, _ourAdvantagesItems, document.body.querySelectorAll('.our-advantages-item'));
      var _iterator = _createForOfIteratorHelper(_classPrivateFieldGet(this, _ourAdvantagesItems)),
        _step;
      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var item = _step.value;
          item.addEventListener('mouseenter', function (e) {
            if (!_this.checkClass(e.target)) e.target.classList.add(_classPrivateFieldGet(_this, _ourAdvantagesItemClass));
          });
          item.addEventListener('mouseleave', function (e) {
            if (_this.checkClass(e.target)) e.target.classList.remove(_classPrivateFieldGet(_this, _ourAdvantagesItemClass));
          });
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    }
  }, {
    key: "checkClass",
    value: function checkClass(item) {
      return item.classList.contains(_classPrivateFieldGet(this, _ourAdvantagesItemClass));
    }
  }]);
  return OurAdvantagesController;
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (OurAdvantagesController);

/***/ }),

/***/ "./resources/js/indexPage/ReviewsSlider.js":
/*!*************************************************!*\
  !*** ./resources/js/indexPage/ReviewsSlider.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
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
var _slider = /*#__PURE__*/new WeakMap();
var _sliderLine = /*#__PURE__*/new WeakMap();
var _sliderItems = /*#__PURE__*/new WeakMap();
var _sliderItemsCounter = /*#__PURE__*/new WeakMap();
var _sliderWidth = /*#__PURE__*/new WeakMap();
var _sliderButtonsWrapper = /*#__PURE__*/new WeakMap();
var _activeClassVal = /*#__PURE__*/new WeakMap();
var _currentSlideIndex = /*#__PURE__*/new WeakMap();
var ReviewsSlider = /*#__PURE__*/function () {
  function ReviewsSlider() {
    _classCallCheck(this, ReviewsSlider);
    _classPrivateFieldInitSpec(this, _slider, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderLine, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderItems, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderItemsCounter, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderWidth, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderButtonsWrapper, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _activeClassVal, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _currentSlideIndex, {
      writable: true,
      value: 0
    });
  }
  _createClass(ReviewsSlider, [{
    key: "init",
    value: function init() {
      var _this = this;
      _classPrivateFieldSet(this, _slider, document.querySelector('.reviews-slider'));
      _classPrivateFieldSet(this, _sliderLine, _classPrivateFieldGet(this, _slider).querySelector('.reviews-slider-line'));
      _classPrivateFieldSet(this, _sliderItems, _classPrivateFieldGet(this, _sliderLine).querySelectorAll('.reviews-slide'));
      _classPrivateFieldSet(this, _sliderItemsCounter, _classPrivateFieldGet(this, _sliderItems).length);
      _classPrivateFieldSet(this, _sliderWidth, getComputedStyle(_classPrivateFieldGet(this, _slider)).width);
      _classPrivateFieldSet(this, _sliderButtonsWrapper, document.querySelector('.reviews-slider-buttons'));
      _classPrivateFieldSet(this, _activeClassVal, 'reviews-slider-active-button');
      this.move = this.move.bind(this);
      _classPrivateFieldGet(this, _sliderLine).style.width = Number.parseInt(_classPrivateFieldGet(this, _sliderWidth)) * _classPrivateFieldGet(this, _sliderItemsCounter);
      this.cleanButtonWrapper();
      _classPrivateFieldGet(this, _sliderItems).forEach(function (item, index) {
        item.style.width = _classPrivateFieldGet(_this, _sliderWidth);
        _this.createButton(index);
      });
    }
  }, {
    key: "cleanButtonWrapper",
    value: function cleanButtonWrapper() {
      _classPrivateFieldGet(this, _sliderButtonsWrapper).innerHTML = '';
    }
  }, {
    key: "createButton",
    value: function createButton(index) {
      var _this2 = this;
      if (_classPrivateFieldGet(this, _sliderItemsCounter)) {
        var sliderButton = document.createElement('button');
        sliderButton.classList.add('reviews-slider-button');
        if (index === _classPrivateFieldGet(this, _currentSlideIndex)) sliderButton.classList.add(_classPrivateFieldGet(this, _activeClassVal));
        sliderButton.addEventListener('click', function (e) {
          _this2.move(index, e);
        });
        _classPrivateFieldGet(this, _sliderButtonsWrapper).append(sliderButton);
      }
    }
  }, {
    key: "move",
    value: function move(index, e) {
      var sliderButtons = _classPrivateFieldGet(this, _sliderButtonsWrapper).querySelectorAll('.reviews-slider-button');
      var _iterator = _createForOfIteratorHelper(sliderButtons),
        _step;
      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var item = _step.value;
          if (item.classList.contains(_classPrivateFieldGet(this, _activeClassVal))) item.classList.remove(_classPrivateFieldGet(this, _activeClassVal));
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
      if (e) e.target.classList.add(_classPrivateFieldGet(this, _activeClassVal));else sliderButtons[index].classList.add(_classPrivateFieldGet(this, _activeClassVal));
      _classPrivateFieldGet(this, _sliderLine).style.left = "-".concat(Number.parseInt(_classPrivateFieldGet(this, _sliderWidth)) * index, "px");
      _classPrivateFieldSet(this, _currentSlideIndex, index);
    }
  }, {
    key: "currentSlideIndex",
    get: function get() {
      return _classPrivateFieldGet(this, _currentSlideIndex);
    }
  }]);
  return ReviewsSlider;
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ReviewsSlider);

/***/ }),

/***/ "./resources/js/indexPage/Slider.js":
/*!******************************************!*\
  !*** ./resources/js/indexPage/Slider.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
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
var _sliderWrapper = /*#__PURE__*/new WeakMap();
var _slideLeftArrow = /*#__PURE__*/new WeakMap();
var _className = /*#__PURE__*/new WeakMap();
var SlideArrowController = /*#__PURE__*/function () {
  function SlideArrowController() {
    _classCallCheck(this, SlideArrowController);
    _classPrivateFieldInitSpec(this, _sliderWrapper, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _slideLeftArrow, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _className, {
      writable: true,
      value: 'transparent'
    });
  }
  _createClass(SlideArrowController, [{
    key: "init",
    value: function init() {
      var _this = this;
      _classPrivateFieldSet(this, _sliderWrapper, document.querySelector('.slider-wrapper'));
      _classPrivateFieldSet(this, _slideLeftArrow, document.querySelector('.slider-left-arrow-wrapper'));
      _classPrivateFieldGet(this, _sliderWrapper).addEventListener('mouseenter', function () {
        if (_classPrivateFieldGet(_this, _slideLeftArrow).classList.contains(_classPrivateFieldGet(_this, _className))) {
          _classPrivateFieldGet(_this, _slideLeftArrow).classList.remove(_classPrivateFieldGet(_this, _className));
        }
      });
      _classPrivateFieldGet(this, _sliderWrapper).addEventListener('mouseleave', function () {
        if (!_classPrivateFieldGet(_this, _slideLeftArrow).classList.contains(_classPrivateFieldGet(_this, _className))) {
          _classPrivateFieldGet(_this, _slideLeftArrow).classList.add(_classPrivateFieldGet(_this, _className));
        }
      });
    }
  }]);
  return SlideArrowController;
}();
var SlideItem = /*#__PURE__*/_createClass(function SlideItem(classes, content) {
  _classCallCheck(this, SlideItem);
  _defineProperty(this, "content", null);
  _defineProperty(this, "classes", null);
  this.classes = classes;
  this.content = content;
});
var _slider = /*#__PURE__*/new WeakMap();
var _sliderWrapper2 = /*#__PURE__*/new WeakMap();
var _currentWidth = /*#__PURE__*/new WeakMap();
var _step = /*#__PURE__*/new WeakMap();
var _offset = /*#__PURE__*/new WeakMap();
var _sliderLeftArrow = /*#__PURE__*/new WeakMap();
var _slideItem = /*#__PURE__*/new WeakMap();
var Slider = /*#__PURE__*/function () {
  function Slider() {
    _classCallCheck(this, Slider);
    _classPrivateFieldInitSpec(this, _slider, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderWrapper2, {
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
    _classPrivateFieldInitSpec(this, _slideItem, {
      writable: true,
      value: null
    });
  }
  _createClass(Slider, [{
    key: "init",
    value: function init(slideItem, allSlides) {
      var slides = document.body.querySelectorAll('.slide');
      _classPrivateFieldSet(this, _slider, new Array());
      _classPrivateFieldSet(this, _sliderWrapper2, document.querySelector('.slider-wrapper'));
      _classPrivateFieldSet(this, _currentWidth, window.innerWidth);
      _classPrivateFieldSet(this, _sliderLeftArrow, document.querySelector('.slider-left-arrow-wrapper'));
      _classPrivateFieldSet(this, _slideItem, slideItem);
      var _iterator = _createForOfIteratorHelper(slides),
        _step2;
      try {
        for (_iterator.s(); !(_step2 = _iterator.n()).done;) {
          var item = _step2.value;
          _classPrivateFieldGet(this, _slider).push(new (_classPrivateFieldGet(this, _slideItem))(item.classList.value.split(' '), item.innerHTML));
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
      _classPrivateFieldGet(this, _sliderWrapper2).appendChild(slide);
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
      var _this2 = this;
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
        _this2.draw();
        _classPrivateFieldGet(_this2, _sliderLeftArrow).onclick = _this2.left;
      }, 600);
    }
  }]);
  return Slider;
}();
var _slider2 = /*#__PURE__*/new WeakMap();
var _slideItem2 = /*#__PURE__*/new WeakMap();
var SliderFacade = /*#__PURE__*/function () {
  function SliderFacade(slider, slideItem) {
    _classCallCheck(this, SliderFacade);
    _classPrivateFieldInitSpec(this, _slider2, {
      writable: true,
      value: null
    });
    _defineProperty(this, "slides", new Array());
    _classPrivateFieldInitSpec(this, _slideItem2, {
      writable: true,
      value: null
    });
    _classPrivateFieldSet(this, _slider2, slider);
    _classPrivateFieldSet(this, _slideItem2, slideItem);
    var slides = document.body.querySelectorAll('.slide');
    var _iterator5 = _createForOfIteratorHelper(slides),
      _step6;
    try {
      for (_iterator5.s(); !(_step6 = _iterator5.n()).done;) {
        var item = _step6.value;
        this.slides.push(new (_classPrivateFieldGet(this, _slideItem2))(item.classList.value.split(' '), item.innerHTML));
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
      _classPrivateFieldGet(this, _slider2).init(_classPrivateFieldGet(this, _slideItem2), this.slides);
    }
  }]);
  return SliderFacade;
}();
var mainSliderClasses = {
  slideArrowController: SlideArrowController,
  slideItem: SlideItem,
  slider: Slider,
  sliderFacade: SliderFacade
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (mainSliderClasses);

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
/*!*******************************************************!*\
  !*** ./resources/js/indexPage/IndexPageController.js ***!
  \*******************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BlocksAppearanceController__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BlocksAppearanceController */ "./resources/js/indexPage/BlocksAppearanceController.js");
/* harmony import */ var _OurAdvantages__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OurAdvantages */ "./resources/js/indexPage/OurAdvantages.js");
/* harmony import */ var _ReviewsSlider__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ReviewsSlider */ "./resources/js/indexPage/ReviewsSlider.js");
/* harmony import */ var _Slider__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Slider */ "./resources/js/indexPage/Slider.js");
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




var _blocksAppearanceController = /*#__PURE__*/new WeakMap();
var _ourAdvantagesController = /*#__PURE__*/new WeakMap();
var _reviewsSlider = /*#__PURE__*/new WeakMap();
var _slideArrowController = /*#__PURE__*/new WeakMap();
var _slideItem = /*#__PURE__*/new WeakMap();
var _slider = /*#__PURE__*/new WeakMap();
var _sliderFacade = /*#__PURE__*/new WeakMap();
var IndexPageController = /*#__PURE__*/function () {
  function IndexPageController() {
    _classCallCheck(this, IndexPageController);
    _classPrivateFieldInitSpec(this, _blocksAppearanceController, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _ourAdvantagesController, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _reviewsSlider, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _slideArrowController, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _slideItem, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _slider, {
      writable: true,
      value: null
    });
    _classPrivateFieldInitSpec(this, _sliderFacade, {
      writable: true,
      value: null
    });
  }
  _createClass(IndexPageController, [{
    key: "init",
    value: function init(blocksAppearanceController, ourAdvantagesController, reviewsSlider, slideArrowController, slideItem, slider, sliderFacade) {
      var _this = this;
      _classPrivateFieldSet(this, _blocksAppearanceController, new blocksAppearanceController());
      _classPrivateFieldSet(this, _ourAdvantagesController, new ourAdvantagesController());
      _classPrivateFieldSet(this, _reviewsSlider, new reviewsSlider());
      _classPrivateFieldSet(this, _slideArrowController, new slideArrowController());
      _classPrivateFieldSet(this, _slideItem, slideItem);
      _classPrivateFieldSet(this, _slider, slider);
      _classPrivateFieldSet(this, _sliderFacade, new sliderFacade(new (_classPrivateFieldGet(this, _slider))(), _classPrivateFieldGet(this, _slideItem)));
      ;
      _classPrivateFieldGet(this, _blocksAppearanceController).init();
      _classPrivateFieldGet(this, _ourAdvantagesController).init();
      _classPrivateFieldGet(this, _reviewsSlider).init();
      _classPrivateFieldGet(this, _slideArrowController).init();
      _classPrivateFieldGet(this, _sliderFacade).init();
      window.addEventListener('resize', function () {
        _classPrivateFieldGet(_this, _reviewsSlider).init();
        _classPrivateFieldGet(_this, _reviewsSlider).move(_classPrivateFieldGet(_this, _reviewsSlider).currentSlideIndex);
        _classPrivateFieldGet(_this, _sliderFacade).init();
      });
    }
  }]);
  return IndexPageController;
}();
var indexPageController = new IndexPageController();
var slideArrowController = _Slider__WEBPACK_IMPORTED_MODULE_3__["default"].slideArrowController,
  slider = _Slider__WEBPACK_IMPORTED_MODULE_3__["default"].slider,
  slideItem = _Slider__WEBPACK_IMPORTED_MODULE_3__["default"].slideItem,
  sliderFacade = _Slider__WEBPACK_IMPORTED_MODULE_3__["default"].sliderFacade;
indexPageController.init(_BlocksAppearanceController__WEBPACK_IMPORTED_MODULE_0__["default"], _OurAdvantages__WEBPACK_IMPORTED_MODULE_1__["default"], _ReviewsSlider__WEBPACK_IMPORTED_MODULE_2__["default"], slideArrowController, slideItem, slider, sliderFacade);
})();

/******/ })()
;